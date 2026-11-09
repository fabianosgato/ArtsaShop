# Frontend - Estrutura e Sistema de URL Rewrite

## Visão Geral

O frontend do ArtsaShop utiliza **Blade + Livewire + Alpine.js + Tailwind CSS 4 + Vite** com assets separados em `resources/css/frontend/` e `resources/js/frontend/`. O sistema de roteamento é centralizado no **URL Rewrite** (padrão Magento-like).

---

## Rotas (`routes/web.php`)

| Rota | Controller | Name | Descrição |
|------|------------|------|-----------|
| `GET /` | `Frontend\IndexController@index` | `index.home` | Página inicial |
| `GET fale-conosco` | `Frontend\ContactsController@index` | `contacts.index` | Página de contato |
| `POST fale-conosco/send` | `Frontend\ContactsController@sendPost` | `contacts.sendPost` | Envio do formulário |
| `GET sitemap_index.xml` | Redirect | — | Redireciona para `/sitemap/sitemap.xml` |
| **Fallback** | `Frontend\UrlRewriteController@resolve` | — | **Sistema de URL Rewrite** (Produtos, Categorias, Marcas, CMS) |

> **Importante:** O `Route::fallback` captura **todas as rotas não definidas** e delega ao `UrlRewriteController`.

---

## Sistema de URL Rewrite

### Tabela `sys_url_rewrite`

```sql
CREATE TABLE `sys_url_rewrite` (
  `url_rewrite_id` int unsigned NOT NULL AUTO_INCREMENT,
  `request_path` varchar(255) DEFAULT NULL COMMENT 'Request Path (ex: produto-legal)',
  `target_path` varchar(255) DEFAULT NULL COMMENT 'Target Path (ex: product/123)',
  `is_system` smallint unsigned DEFAULT '1' COMMENT '1 = sistema, 0 = customizado',
  `target_type` varchar(255) DEFAULT NULL COMMENT 'product, category, brand, cms',
  `options` varchar(255) DEFAULT NULL COMMENT 'JSON: {"redirect": 301}',
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`url_rewrite_id`),
  UNIQUE KEY `UNQ_CORE_URL_REWRITE_REQUEST_PATH` (`request_path`),
  KEY `IDX_CORE_URL_REWRITE_TARGET_PATH` (`target_path`,`request_path`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;
```

### Fluxo de Resolução (`UrlRewriteController::resolve`)

```
Request: GET /produto-legal/
         ↓
Route::fallback → UrlRewriteController@resolve
         ↓
$slug = trim($request->path(), '/')  // "produto-legal"
         ↓
SysUrlRewriteRepository::getBySlug($slug)
         ↓
Encontrado?
├── NÃO → abort(404)
└── SIM → $rewrite = ['target_path' => 'product/123', 'target_type' => 'product', 'options' => '{"redirect":301}']
         ↓
Tem options.redirect === 301?
├── SIM → Busca canonical (sem options) pelo mesmo target_path
│         → Redirect 301 para /canonical-slug
└── NÃO → Continua
         ↓
explode('/', target_path) → [$targetType, $id]
         ↓
match ($targetType):
├── 'product'    → app(CatalogProductController::class)->index($id)
├── 'category'   → app(CatalogCategoryController::class)->index($id)
├── 'brand'      → app(BrandController::class)->index($id)
├── 'cms'        → app(CmsPagesController::class)->index($id)
└── default      → abort(404)
```

---

## `SysUrlRewriteRepository` — Operações Principais

### `getBySlug($slug)`
```php
// Busca exata por request_path
return SysUrlRewrite::where('request_path', $slug)->first()->toArray() ?? false;
```

### `saveUrlRewrite(array $attributes)`
**Campos esperados:**
- `request_path` (ex: `produto-legal`)
- `target_path` (ex: `product/123`)
- `target_type` (product|category|brand|cms)
- `is_system` (default 1)
- `options` (nullable, JSON: `{"redirect": 301}`)

**Lógica:**
1. Normaliza paths (remove `/`)
2. Se `request_path` já existe → **atualiza** (log se `target_path` diferente)
3. Se não existe, mas `target_path` já tem outras URLs:
   - Para cada URL existente com `request_path` diferente → **adiciona redirect 301** (`options = {"redirect":301}`, `is_system = 0`)
   - Para a URL igual ao novo `request_path` → **atualiza**
4. Se não existe nada → **cria novo** (`firstOrCreate`)

### `getCanonicalByTargetPath($targetPath)`
```php
// Retorna a URL "principal" (sem redirect/options)
return SysUrlRewrite::where('target_path', $targetPath)
    ->whereNull('options')
    ->first();
```

---

## Controllers Frontend por Target Type

### 1. **Product** (`CatalogProductController@index`)
```php
public function index(int $productId)
{
    $catalogProduct = ServiceCache::remember(
        "product_page_{$productId}",
        ['catalog_products'],
        fn() => CatalogProductsRepository::getProductById($productId)
    );

    if (empty($catalogProduct)) abort(404);

    // SEO via HasSeoResponse trait
    $this->getSeoMetaTags(entity: $catalogProduct);
    view()->share('product', $catalogProduct);

    return view('catalog::frontend.product', ['product' => $catalogProduct]);
}
```
**View:** `Modules/Catalog/resources/views/frontend/product.blade.php`  
**Layout:** `2columns-product` (sidebar + conteúdo)

---

### 2. **Category** (`CatalogCategoryController@index`)
```php
public function index(int $categoryId)
{
    $catalogCategory = CatalogCategoryRepository::getCategoryById($categoryId);
    if (!$catalogCategory) abort(404);

    $products = CatalogProductsRepository::getProductsByCategoryPagination(
        categoryId: $catalogCategory->entity_id,
        perPage: 44,
        priceRange: request()->input('prices', [])
    );

    // Schema para JSON-LD (até 15 produtos)
    $productsSchema = array_map(...);

    $this->setSeoContext(['category_products' => $productsSchema])
         ->getSeoMetaTags($catalogCategory);

    view()->share('category', $catalogCategory);

    return view('catalog::frontend.category-products', compact('category', 'products'));
}
```
**View:** `Modules/Catalog/resources/views/frontend/category-products.blade.php`  
**Layout:** `2columns-left`  
**Filtros:** `?prices[min]=100&prices[max]=500`  
**Paginação:** `vendor.pagination.tailwind`

---

### 3. **Brand** (`BrandController@index`)
```php
public function index(string $brandId)
{
    $brands = CatalogProductBrandRepository::getBrand(intval($brandId));

    $products = CatalogProductsRepository::getProductsByBrandsPagination(
        brandId: $brands['brand_id'],
        perPage: 16
    );

    $productsSchema = array_map(...);

    $this->setSeoContext(['category_products' => $productsSchema])
         ->getSeoMetaTags(entity: $brands);

    return view('brands::frontend.brand', compact('brand', 'products'));
}
```
**View:** `Modules/Brands/resources/views/frontend/brand.blade.php`  
**Layout:** Herda do app layout

---

### 4. **CMS Page** (`CmsPagesController@index`)
```php
public function index(int $pageId)
{
    $page = CmsPageRepository::getPage($pageId);
    if (!$page) abort(404);

    view()->share('cms', $page);
    $this->getSeoMetaTags(entity: $page);

    // Remove figcaption de links com imagens (cleanup)
    $content = preg_replace(
        '/<a[^>]*>(<img[^>]*>).*?<figcaption[^>]*>.*?<\/figcaption>.*?<\/a>/is',
        '$1',
        $page->content
    );

    return view('cms::frontend.page', [
        'page' => ['title' => $page->title, 'content' => $content]
    ]);
}
```
**View:** `Modules/Cms/resources/views/frontend/page.blade.php`

---

## SEO Integration (`HasSeoResponse` Trait)

Todos os controllers usam `Idea\Framework\Seo\Traits\HasSeoResponse`:

```php
$this->getSeoMetaTags(entity: $catalogProduct);
// ou
$this->setSeoContext(['category_products' => $schema])
     ->getSeoMetaTags($catalogCategory);
```

**Fluxo:**
1. Cache key: `seo_meta:{md5(route|url|entity)}` (tags: `seo-meta`, TTL 3200s)
2. Busca `SeoPageRepository::getSeoFor($entity)` → `SeoPage` model
3. Se não existe → `SeoPageData` default (title=app.name, canonical=current URL)
4. Se existe → Constrói `SeoPageData` com:
   - Meta tags do banco (`title`, `description`, `canonical_url`, `no_index`, `no_follow`, `priority`, `change_frequency`)
   - Meta tags relacionadas (`og:*`, `twitter:*`, etc.)
   - **Produto:** `productName`, `productDescription`, `productImage`, `sku`, `brand`, `price`, `currency`, `inStock`, `ogVideo`
   - **Categoria/Marca:** `categoryProducts` (para JSON-LD ItemList)
5. `View::share('seoData', $seoData)` → disponível em `head.blade.php`

**Renderização no Head (`resources/views/frontend/components/html/page-meta-component.blade.php`):**
```blade
@if (isset($seoData))
    {!! seo($seoData) !!}
@endif
```
→ Chama `SeoManager::render()` → HTML completo (meta tags + JSON-LD schemas)

---

## Layouts Frontend (`resources/views/frontend/layouts/`)

| Layout | Uso | Estrutura |
|--------|-----|-----------|
| `1column.blade.php` | Páginas simples | Header → Navigation → Breadcrumbs → Content → Footer |
| `2columns-left.blade.php` | Categorias, CMS | Sidebar esquerda + Content |
| `2columns-right.blade.php` | — | Content + Sidebar direita |
| `2columns-home.blade.php` | Home | Hero + Vitrines |
| `2columns-product.blade.php` | Produto | Gallery esquerda (9/12) + Info direita (3/12) |
| `2columns-customer.blade.php` | Área do cliente | Sidebar conta + Content |

**Estrutura base (`1column.blade.php`):**
```blade
@include('frontend.components.html.head')
<body>
<section class="wrapper">
    @include('frontend.components.html.header-top')
    @include('frontend.components.html.header')
    @include('frontend.components.catalog.navigation')
    <x-frontend.breadcrumbs-component/>

    <div class="content">
        <div class="container">
            <main>{{ $slot }}</main>
        </div>
    </div>
    @include('frontend.components.html.footer')
    @include('frontend.components.html.before_body_end')
</section>
```

---

## Assets Frontend (Vite)

**Entradas (`vite.config.js`):**
```js
// resources/css/frontend/app.css
// resources/js/frontend/react.jsx   // React via Inertia? Ou apenas JS
```

**Carregamento no head:**
```blade
@viteReactRefresh
@vite([
    'resources/css/frontend/app.css',
    'resources/js/frontend/react.jsx',
])
@livewireStyles
<link rel="stylesheet" href="{{ asset('css/frontend/styles.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/responsive.css') }}">
<link rel="stylesheet" href="{{ asset('css/frontend/theme/buttons.css') }}">
```

---

## Multi-Store no Frontend

Middleware `IdentifyStoreByHost` (em `bootstrap/app.php` → grupo `web`):
- Resolve `currentStore` pelo `Host` da requisição
- Disponível via `app('currentStore')` nas views
- Usado para: preços, estoque, URLs, configurações por loja

---

## Exemplos de URLs Geradas

| Entidade | request_path (exemplo) | target_path | target_type |
|----------|------------------------|-------------|-------------|
| Produto | `camiseta-basica-preta` | `product/42` | `product` |
| Categoria | `camisetas/masculino` | `category/15` | `category` |
| Marca | `nike` | `brand/3` | `brand` |
| CMS | `quem-somos` | `cms/7` | `cms` |

**Redirect 301 automático:** Se produto muda de slug (`camiseta-preta` → `camiseta-basica-preta`), o antigo recebe `options={"redirect":301}` e redireciona para o canônico.

---

## Criação Automática de Rewrites

No `CatalogProductService::saveOrUpdate()`:
```php
SysUrlRewriteRepository::saveUrlRewrite([
    'request_path' => $attributes['slug_key'],
    'target_path' => 'product/' . $product->product_id,
    'target_type' => 'product',
    'is_system' => 1,
]);
```
O mesmo ocorre para Categorias, Marcas e Páginas CMS via seus respectivos Services.

---

> **Atualizado em:** 2026-11-09  
> **Projeto:** ArtsaShop (ecommerce-laravel)