# Implementação Vue.js — ArtsaShop Frontend

> **Sessão Original:** `agent:artsashop-assistent:dashboard:0302c4a7-9264-46a2-b25e-d39a7a9118ca`  
> **Data:** 2026-11-12  
> **Objetivo:** Migrar frontend Blade + Livewire + Alpine.js → Vue 3 + Inertia.js + Pinia + Tailwind 4

---

## 🎯 Visão Geral

O ArtsaShop utiliza **Blade + Livewire + Alpine.js** no frontend. A migração para **Vue 3 + Inertia.js** visa:
- Melhor DX (Developer Experience) com TypeScript, Composition API, Pinia
- SPA navigation sem reload (Inertia)
- Reatividade nativa Vue vs Alpine.js
- Ecossistema moderno (Vite, Pinia, Vue Router opcional)
- Manter arquitetura modular Laravel + URL Rewrite system

---

## ✅ Status Atual (O que Foi Feito)

### **Base Técnica Validada**
- ✅ Vite Dev Server rodando limpo em `http://localhost:5173/`
- ✅ Laravel Vite Plugin v3.2.1
- ✅ **SSR temporariamente desabilitado** no `vite.config.js` (linha `ssr: 'resources/js/frontend/ssr.ts'` comentada)
- ✅ Build de produção passando (`npm run build`)
- ✅ Pacotes instalados corretamente:
  - `@inertiajs/vue3` ^2.3.29
  - `@inertiajs/vite` ^3.9.1
  - `vue` ^3.5.45
  - `pinia` ^2.x
  - `vue-router` ^4.6.4 (opcional, Inertia gerencia roteamento)

> **⚠️ Deploy:** Reativar SSR em produção + configurar Node.js (PM2/Docker)

---

### **Estrutura de Layouts Vue (Mapeamento Blade → Vue)**

| Blade Layout | Vue Layout | Uso Principal |
|--------------|------------|---------------|
| `1column.blade.php` | `1column.vue` | Páginas simples |
| `2columns-left.blade.php` | `2columns-left.vue` | **Categorias, Busca** (Sidebar esquerda 3/12 + Main 9/12) |
| `2columns-right.blade.php` | `2columns-right.vue` | Sidebar direita |
| `2columns-home.blade.php` | **`2columns-home.vue`** | **Home** (Banners + Container centralizado) |
| `2columns-product.blade.php` | `2columns-product.vue` | **Produto** (Galeria + Info + Sidebar opcional) |
| `2columns-customer.blade.php` | `2columns-customer.vue` | Área do cliente (Menu conta + conteúdo) |

**Arquivos Criados na Sessão:**
- `resources/js/frontend/layouts/FrontendLayout.vue` — Componente base com `props.layout` + slots nomeados
- `resources/js/frontend/pages/Home.vue` — Usa `FrontendLayout layout="2columns-home"` + Hero, Categorias, ProductGrid, Newsletter

---

### **Componentes Base (Stubs Tipados) Entregues**

| Componente | Status | Descrição |
|------------|--------|-----------|
| `components/Header.vue` | ✅ Stub | Header principal: logo, search, cart, wishlist, user menu |
| `components/HeaderTop.vue` | ✅ Completo | Top bar: menu conta, wishlist, carrinho, moeda, idioma (baseado no Blade `header-top.blade.php`) |
| `components/Footer.vue` | ✅ Stub | Footer com links, newsletter, redes sociais |
| `components/Navigation.vue` | ✅ Stub | Navegação categorias (mega menu) |
| `components/Breadcrumbs.vue` | ✅ Stub | Breadcrumbs via SEO/URL Rewrite |
| `components/Banners.vue` | ✅ Stub | Carrossel banners (Home) |
| `components/LeftNavigation.vue` | ✅ Stub | Sidebar filtros/categorias (Categoria/Produto) |
| `components/MobileDrawer.vue` | ✅ Stub | Drawer mobile para sidebar |

---

### **Pinia Stores — Planejadas (Código Completo Entregue)**

| Store | Arquivo | Funcionalidades | Persistência |
|-------|---------|-----------------|--------------|
| **Cart** | `stores/cart.ts` | addItem, removeItem, updateQuantity, clear, stock check, subtotal, count | `localStorage` (`artsashop_cart`) |
| **Wishlist** | `stores/wishlist.ts` | add, remove, toggle, count | `localStorage` (`artsashop_wishlist`) |
| **Compare** | `stores/compare.ts` | add, remove, clear, max 4 produtos | `localStorage` (`artsashop_compare`) |

**Padrão:** Composition API + TypeScript + `defineStore` + `ref`/`computed` + actions tipadas.

---

### **Correção Crítica: Import do Inertia**

**Erro Encontrado:**
```bash
Failed to resolve import "@inertiajs/inertia-vue3" from "resources/js/frontend/components/Header.vue"
```

**Causa:** Pacote **não existe** com esse nome.

**Imports Corretos:**
```typescript
// ✅ CORRETO - Router/Link (SPA navigation)
import { Link } from '@inertiajs/vue3'

// ✅ CORRETO - Head (SEO meta tags)
import { Head } from '@inertiajs/vue3'

// ✅ CORRETO - Helpers
import { usePage, useForm, useRemember } from '@inertiajs/vue3'

// ✅ CORRETO - createInertiaApp (apenas em app.ts/ssr.ts)
import { createInertiaApp } from '@inertiajs/vue3'

// ❌ ERRADO - Não existe
import { Link } from '@inertiajs/inertia-vue3'
```

**Quando Usar `<Link>` vs `<a>` nativo:**

| Cenário | Recomendação |
|---------|--------------|
| Navegação interna SPA (sem reload) | `<Link href="/categoria/eletronicos">` |
| Links externos / SEO / Crawlers | `<a href="/categoria/eletronicos">` |
| Formulários / POST | `useForm()` + `<form @submit="submit">` |
| Header/Menu principal | `<a>` nativo **ou** `<Link>` (ambos funcionam) |

> **Dica:** No Header/Menu principal, **`<a href>` nativo é mais simples** e garante que crawlers (Google, WhatsApp preview) funcionem. Use `<Link>` em botões "Adicionar ao carrinho", paginação, filtros AJAX.

---

## 📋 Roadmap — Próximos Passos

| Etapa | O que Fazer | Arquivos a Criar | Prioridade |
|-------|-------------|------------------|------------|
| **1. Pinia Stores** | Criar stores reais | `stores/cart.ts`, `stores/wishlist.ts`, `stores/compare.ts` | 🔴 Alta |
| **2. Composables** | Utils reutilizáveis | `composables/useMasks.ts`, `useValidators.ts`, `useDebounce.ts` | 🟡 Média |
| **3. Layout Base** | Expandir componentes filhos | `Header.vue` completo, `Footer.vue`, `Navigation.vue`, etc. | 🟡 Média |
| **4. Componentes Core** | Blocos reutilizáveis | `ProductCard.vue`, `ProductGrid.vue`, `MiniCart.vue`, `ProductGallery.vue` | 🟡 Média |
| **5. Páginas Principais** | Views Inertia | `ProductDetail.vue`, `CategoryProducts.vue`, `Brand.vue`, `Cart.vue`, `Checkout/*.vue` | 🟢 Baixa |
| **6. Migrar Controllers** | Laravel → Inertia | `IndexController`, `CatalogProductController`, `CatalogCategoryController`, `BrandController` | 🟢 Baixa |

---

## 🏗️ Arquitetura Vue + Inertia no ArtsaShop

### **Entrada Principal (`resources/js/frontend/app.ts`)**
```typescript
import { createInertiaApp } from '@inertiajs/vue3'
import { createPinia } from 'pinia'
import { createApp } from 'vue'

createInertiaApp({
  resolve: (name) => {
    const pages = import.meta.glob('./pages/**/*.vue', { eager: true })
    return pages[`./pages/${name}.vue`]
  },
  setup({ el, App, props, plugin }) {
    const app = createApp({ render: () => h(App, props) })
    app.use(plugin).use(createPinia()).mount(el)
  },
  progress: { color: '#ea580c' }, // Orange-600
})
```

### **Vite Config (`vite.config.js`)**
```javascript
import inertia from '@inertiajs/vite'

export default defineConfig({
  plugins: [
    inertia({
      resolve: ['resources/js/frontend/pages/**/*.vue'],
      // ssr: 'resources/js/frontend/ssr.ts', // 🔥 DESABILITADO TEMPORARIAMENTE PARA DEV
    }),
    // ...
  ],
  // ...
})
```

### **Shared Props (Laravel → Inertia)**
No `App\Providers\AppServiceProvider.php` (ou middleware):
```php
Inertia::share([
    'auth' => [
        'user' => auth()->user() ? [
            'customer_id' => auth()->user()->customer_id,
            'customer_name' => auth()->user()->customer_name,
            'customer_email' => auth()->user()->customer_email,
        ] : null,
    ],
    'cart_count' => fn() => session('cart_count', 0),
    'wishlist_count' => fn() => session('wishlist_count', 0),
    'store' => fn() => app('currentStore'),
    'flash' => fn() => [
        'success' => session('success'),
        'error' => session('error'),
    ],
]);
```

Acessível no Vue via:
```typescript
const page = usePage()
const user = page.props.auth?.user
const cartCount = page.props.cart_count
```

---

## 🔑 Conceitos-Chave da Migração

### **1. Layout System (Equivalente ao `AppLayout.php`)**
O `FrontendLayout.vue` recebe `layout` prop e renderiza estrutura correta via slots:
```vue
<FrontendLayout layout="2columns-left">
  <template #sidebar>
    <!-- Filtros customizados para esta página -->
  </template>
  
  <!-- Conteúdo principal -->
  <ProductGrid :products="products" />
</FrontendLayout>
```

### **2. URL Rewrite System (Mantido)**
O sistema Magento-like de `sys_url_rewrite` + `Route::fallback` → `UrlRewriteController` **continua no Laravel**. O Vue/Inertia recebe os dados já resolvidos pelo Controller.

### **3. SEO (Mantido)**
`HasSeoResponse` trait + `SeoManager` + helper `seo($model)` → JSON-LD + meta tags.
No Vue: `<Head>` do Inertia para title/description dinâmicos por página.

### **4. Multi-Store (Mantido)**
Middleware `IdentifyStoreByHost` → `app('currentStore')` → Shared prop `store`.

### **5. Assets (Separados)**
- Frontend: `resources/css/frontend/`, `resources/js/frontend/` (Vite entry)
- WsdAdmin: `resources/css/wsdadm/`, `resources/js/wsdadm/` (Vite entry independente)

---

## 📚 Referências Oficiais

| Documentação | Link |
|--------------|------|
| **Inertia.js + Vue 3** | https://inertiajs.com/vue3 |
| **Pinia** | https://pinia.vuejs.org/ |
| **Vue 3 Composition API** | https://vuejs.org/guide/extras/composition-api-faq.html |
| **Tailwind CSS 4** | https://tailwindcss.com/docs |
| **Vite + Laravel** | https://laravel.com/docs/vite |
| **Laravel Boost (MCP)** | Configurado no projeto (`boost.json`) |

---

## 📝 Convenções do Projeto

### **TypeScript**
- `strict: true` no `tsconfig.json`
- Interfaces para props, emits, store state
- `defineProps<Props>()`, `defineEmits<Emits>()`

### **Vue**
- `<script setup lang="ts">` obrigatório
- Composition API + `ref`/`computed`/`watch`
- Componentes em `PascalCase.vue`
- Imports com alias `@/` → `resources/js/frontend/`

### **Pinia**
- Uma store por domínio (cart, wishlist, compare, user, etc.)
- `defineStore('name', () => { ... })` — Setup Store pattern
- Persistência via `localStorage` (plugins Pinia opcional futuramente)

### **Inertia**
- `<Link>` para navegação SPA interna
- `useForm()` para formulários
- `<Head>` para SEO por página
- `usePage()` para shared props
- Progress bar configurada (laranja ArtsaShop)

---

## 🚀 Como Continuar

### **Opção 1: Criar Pinia Stores (Recomendado)**
```bash
# Estrutura
resources/js/frontend/stores/
├── cart.ts
├── wishlist.ts
└── compare.ts
```

### **Opção 2: Expandir Componentes Core**
```bash
resources/js/frontend/components/
├── ProductCard.vue
├── ProductGrid.vue
├── MiniCart.vue
├── ProductGallery.vue
└── ...
```

### **Opção 3: Criar Página ProductDetail**
```bash
resources/js/frontend/pages/
├── ProductDetail.vue
└── CategoryProducts.vue
```

### **Opção 4: Migrar Controller**
```php
// CatalogProductController@index
return inertia('ProductDetail', [
    'product' => $product,
    'seoData' => $seoData,
]);
```

---

## 📌 Decisões Registradas

| Decisão | Data | Contexto |
|---------|------|----------|
| Usar Vue 3 + Inertia + Pinia | 2026-11-12 | Substituir Blade/Livewire/Alpine |
| Manter URL Rewrite no Laravel | 2026-11-12 | Não reescrever roteamento |
| SSR desabilitado em dev | 2026-11-12 | Estabilidade dev server |
| `<a>` nativo no Header/Menu | 2026-11-12 | SEO/crawlers |
| Pinia stores com localStorage | 2026-11-12 | Persistência client-side |
| Layouts via props + slots | 2026-11-12 | Equivalente ao AppLayout.php Blade |

---

> **Última Atualização:** 2026-11-12  
> **Sessão:** `agent:artsashop-assistent:dashboard:0302c4a7-9264-46a2-b25e-d39a7a9118ca`  
> **Control UI:** https://claw.lef-tecnologia.com.br/chat/artsashop-assistent/dashboard/0302c4a7-9264-46a2-b25e-d39a7a9118ca