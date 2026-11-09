# lib/Idea/Framework — Core do ArtsaShop

O **`lib/Idea/Framework`** é o "Core" da aplicação, desenvolvido baseado na experiência de **8 anos com Magento 1.x**. Foi criado para atender clientes que precisavam de um e-commerce performático, sem a complexidade e custos de infraestrutura do **Magento 2.x**.

> **Objetivo:** Melhorar o que o Magento 1.x oferecia e corrigir problemas de performance, mantendo simplicidade operacional.

---

## Estrutura de Diretórios

```
lib/Idea/
├── Framework/           # Core principal (PHP packages)
│   ├── src/
│   │   ├── Admin/       # Componentes admin (MenuBuilder, Grid, Permissions)
│   │   ├── Apis/        # Base para APIs
│   │   ├── Concerns/    # Traits/Concerns (Validators, Email, ApiResponse)
│   │   ├── Contracts/   # Interfaces (RepositoryInterface, ServiceInterface)
│   │   ├── Exceptions/  # Handler customizado
│   │   ├── Media/       # Processamento de imagens (Resize, Storage, Validation)
│   │   ├── Repository/  # Repository Pattern (AbstractRepository + 60+ repos concretos)
│   │   ├── Services/    # Service Layer (AbstractService, ServiceCache)
│   │   ├── Seo/         # SEO Manager (Tags, Schemas, OpenGraph, Twitter, JSON-LD)
│   │   ├── View/        # Breadcrumbs, View composers
│   │   ├── Jobs/        # Jobs base
│   │   ├── Providers/   # IdeaFrameworkServiceProvider
│   │   ├── AdminController.php
│   │   ├── Debug.php
│   │   ├── Utils.php
│   │   └── helpers.php  # Helpers globais (getConfigData, seo(), formatPrice, getCmsBlock)
│   ├── config/idea.php  # Configuração central (cache, imagens, breadcrumbs)
│   └── resources/views/ # Views compartilhadas (admin, frontend)
└── runtimes/
    └── 8.3/             # Docker runtime PHP 8.3 (Dockerfile, php.ini, supervisord)
```

---

## Principais Componentes

### 1. **Repository Pattern** (`src/Repository/`)
- **`AbstractRepository`** — Base com CRUD genérico (`all`, `find`, `create`, `update`, `delete`, `updateOrCreate`)
- **60+ Repositories Concretos** organizados por domínio:
  - **Catalog** (11): Products, Categories, Attributes, Media, Prices, Tags, Queue, Store, Status, CategoryProduct, ProductAttribute
  - **Eav** (6): Attributes, AttributeSet, EntityAttribute, Category, Options, OptionValue
  - **System** (9): Store, Config, Group, User, GroupProfile, Carrier, UrlRewrite, AddressState, Module, ModuleMenu
  - **Sales** (11): Order, OrderItem, OrderAddress, OrderStatus, Quote, QuoteItem, QuoteAddress, QuoteCustomer, History, Payment, DiscountRule, OrderCode
  - **Customers** (3): Entity, Address, Wishlist
  - **CMS** (4): Page, Block, Banner, FAQ
  - **Reviews** (3): Review, Entity, Like
  - **Search** (1): SearchRepository
- **Padrão:** Todos estendem `AbstractRepository` e implementam `RepositoryInterface`
- **Uso:** `CatalogProductsRepository::getNewProducts(limit: 10)`

---

### 2. **Service Layer** (`src/Services/`)
- **`AbstractService`** — Base com injeção de `ServiceCache`
- **`ServiceCache`** — Cache com **tags** e TTL configurável por tipo
  - Tags definidas em `config/idea.php` → `cache.types`
  - Suporta `rememberForever` (expire_in = 0)
  - Métodos: `remember()`, `forgetByTags()`, `forgetByKey()`, `forgetByKeyList()`
  - TTL dinâmico: usa o **maior** `expire_in` entre as tags informadas
- **Exemplo de uso no CatalogProductService:**
  ```php
  $this->serviceCache->remember(
      cacheKey: "catalog:product-block:newProducts:limit:$limit",
      tags: ['homepage', 'catalog_products'],
      closure: fn() => CatalogProductsRepository::getNewProducts(limit: $limit)
  );
  ```

---

### 3. **Admin Components** (`src/Admin/`)
| Componente | Função |
|------------|--------|
| **MenuBuilderComponent** (Livewire) | Menu dinâmico do WsdAdmin — lê `SysModulesMenu` + permissões |
| **Grid** (Livewire + Filament) | Base para grids admin — `InteractsWithTable`, `InteractsWithForms`, `InteractsWithActions` |
| **GridsTitlesCompoments** | Títulos padronizados de grids |
| **Permissions** | Verificação de permissão por `moduleMenuId` + action (`view`, `create`, `edit`, `delete`) |
| **NavigationManager** | Constrói menu hierárquico (módulo → submódulos) com status ativo/aberto |
| **ExternalImageGallery** | Galeria de imagens externas |

**Fluxo do Menu:**
1. `NavigationManager::getMenuItems()` → carrega módulos ativos (`SysModuleRepository`)
2. Para cada módulo, busca `SysModulesMenu` (status=true, is_visible=true, ordenado)
3. Verifica permissão do usuário via `Permissions::checkPermissions()`
4. Marca item ativo comparando `menu_link` com `Route::currentRouteName()`

---

### 4. **SEO System** (`src/Seo/`)
- **`SeoManager`** — Orquestrador principal
  - `set(Model|array|SeoPageData)` → define fonte de dados
  - `render()` → retorna HTML completo (meta tags + JSON-LD schemas)
  - `resolvePageType()` → detecta tipo: `home`, `product`, `category`, `brand`, `default` (via `SysUrlRewriteRepository`)
- **Tags** (Collection): Title, Description, Canonical, Robots, Author, OpenGraph, Twitter, Generator
- **Schemas** (JSON-LD): WebSite, Page, Product, Category, Brand
- **Helper global:** `seo($model)` → `{{ seo($product) }}` nas views

---

### 5. **Media Processing** (`src/Media/`)
- **`ImageResizer`** — Redimensionamento inteligente com **Intervention Image v4 + Imagick**
  - Tamanhos definidos em `config/idea.php` → `images.images_sizes`:
    - `product_main` (1000x1000), `product_page` (383x383), `product_sharing` (300x300),
    - `product_listing` (215x215), `product_thumbnail` (80x80)
  - Pipeline: strip metadata → `scaleDown` → `pad` (canvas fixo branco) → `sharpen(10)`
  - Retorna array `[label => ImageObject]` para storage posterior
- **`ImageStorage`**, **`ImageValidator`**, **`MediaDownloader`** — Completam o ciclo

---

### 6. **Configuração Central** (`config/idea.php`)
```php
'breadcrumbs' => [ ... ],           // Integração com davejamesmiller/laravel-breadcrumbs
'images' => [
    'allowed_type_mimes' => [...],
    'images_sizes' => [ ... 5 tamanhos ... ]
],
'cache' => [
    'types' => [
        'seo-meta' => ['expire_in' => 3200],
        'store_host' => ['expire_in' => 0],      // eterno
        'catalog_products' => ['expire_in' => 3600],
        'catalog_category' => ['expire_in' => 3600],
        'attributes_set' => ['expire_in' => 3600],
        'cms' => ['expire_in' => 3600],
        'homepage' => ['expire_in' => 3600],
        'banners' => ['expire_in' => 0],         // eterno
    ]
]
```

---

### 7. **Helpers Globais** (`helpers.php` — auto-loaded no ServiceProvider)
| Helper | Função |
|--------|--------|
| `getConfigData($path)` | Lê config do e-commerce via `SysConfigRespository` (cacheado) |
| `getPagarmePublicKey()` | Retorna chave pública PagarMe conforme ambiente (sandbox/production) |
| `seo($source)` | Renderiza SEO completo: `{{ seo($product) }}` |
| `formatPrice($price)` | Formata BRL pt_BR com `NumberFormatter::CURRENCY` |
| `getCmsBlock($identifier)` | Retorna HTML de bloco CMS |

---

### 8. **Docker Runtime** (`runtimes/8.3/`)
- **Dockerfile** — PHP 8.3 + extensões necessárias
- **php.ini** — Configurações otimizadas (opcache, memory_limit, upload)
- **supervisord.conf** — Gerencia queue workers, scheduler, horizon
- **start-container** — Script de entrada

---

## Integração com Módulos

O **ServiceProvider** (`IdeaFrameworkServiceProvider`):
1. Carrega `helpers.php`
2. Registra views namespace `idea-components`
3. **`setupConfigModules()`** — Para cada módulo habilitado:
   - Merge config `config/config.php` do módulo
   - Se tiver `sysconfig`, insere em batch na tabela `sys_config_data` (evita N+1)
4. Registra componentes Livewire: `titles-component`, `menu-builder-component`
5. Registra breadcrumbs (se `routes/breadcrumbs.php` existir)

---

## Filosofia "Anti-Magento 2"

| Magento 2 | Idea Framework |
|-----------|----------------|
| EAV pesado, joins complexos | EAV otimizado + Repository Pattern |
| Full page cache complexo (Varnish) | Cache por tags nativo Laravel Redis |
| Layout XML + PHTML | Blade + Livewire + Filament |
| Dependency Injection pesado | Laravel Container nativo + Services simples |
| Muitos arquivos, boot lento | Modular (nwidart/laravel-modules), lazy loading |
| Requer Varnish/Redis/Elasticsearch obrigatórios | Redis opcional, funciona bem só com DB + file cache |
| Deploy complexo | Docker simples (runtimes/8.3) |

---

## Como Estender

1. **Novo Repository:** Estenda `AbstractRepository`, defina `$model` e `$tableId`
2. **Novo Service:** Estenda `AbstractService`, injete `ServiceCache` + Repositories necessários
3. **Novo Módulo Admin:** Use `Grid` base + `MenuBuilderComponent` automático via `SysModulesMenu`
4. **SEO customizado:** Adicione Tag/Schema nas collections do `SeoManager`
5. **Novo tamanho de imagem:** Adicione em `config/idea.php` → `images.images_sizes`

---

> **Atualizado em:** 2026-11-09  
> **Projeto:** ArtsaShop (ecommerce-laravel)  
> **Autor:** Fabiano Gato (8 anos Magento 1.x)