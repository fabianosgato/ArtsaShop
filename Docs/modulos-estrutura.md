# Módulos do ArtsaShop

O projeto utiliza **`nwidart/laravel-modules`** para arquitetura modular. Cada módulo é independente com seus próprios controllers, models, services, repositories, views, routes, migrations, providers e testes.

---

## Lista de Módulos

| Módulo | Alias | Status | Descrição |
|--------|-------|--------|-----------|
| **Eav** | `eav` | Ativo | Entity-Attribute-Value — Atributos dinâmicos para produtos |
| **System** | `system` | Ativo | Configurações globais do sistema |
| **Brands** | `brands` | Ativo | Cadastro de Marcas de produtos |
| **Catalog** | `catalog` | Ativo | Produtos, categorias, atributos, mídia, estoque, preços |
| **CatalogSearch** | `catalogsearch` | Ativo | Busca no site (frontend) |
| **Checkout** | `checkout` | Ativo | Fluxo de compra (carrinho, cliente, endereço, pagamento, pedido) |
| **Cms** | `cms` | Ativo | Páginas institucionais (Quem Somos, Política de Privacidade, etc.) |
| **Customers** | `customers` | Ativo | Gestão de clientes |
| **Payments** | `payments` | Ativo | Gateways de pagamento (Strategy Pattern) — PIX, Cartão, Boleto |
| **Reports** | `reports` | **Pendente** | Relatórios (falta implementar) |
| **Review** | `review` | **Parcial** | Reviews de Produtos e Marcas (falta terminar) |
| **Sales** | `sales` | Ativo | Pedidos, orçamentos (quotes), emails, eventos |
| **SalesRules** | `salesrules` | Ativo | Promoções, regras de desconto |
| **Site** | `site` | **Pendente** | Controle da Home page (falta implementar, existência incerta) |

---

## Estrutura Interna por Módulo

### **Eav** (`Modules/Eav/`)
```
app/
├── Enums/           # Enumeradores do EAV
├── Http/            # Controllers, Requests
├── Livewire/        # Componentes Livewire (admin)
├── Providers/       # EavServiceProvider
├── Services/        # EavAttributeSetService, etc.
└── Transformers/    # API Resources/Transformers
```
**Responsabilidade:** Implementação completa de EAV (Entity-Attribute-Value) para atributos dinâmicos de produtos. Permite diferentes tipos de produtos sem alterar a tabela principal.

---

### **System** (`Modules/System/`)
```
app/
├── Http/            # Controllers, Requests
├── Livewire/        # Componentes Livewire (configurações admin)
├── Providers/       # SystemServiceProvider
├── Services/        # Serviços de configuração
└── Transformers/    # Transformers
```
**Responsabilidade:** Configurações globais do sistema (lojas, URLs, SEO, etc.).

---

### **Brands** (`Modules/Brands/`)
```
app/
├── Http/            # Controllers, Requests
├── Livewire/        # Componentes Livewire (CRUD marcas no admin)
├── Providers/       # BrandsServiceProvider
└── Services/        # CatalogProductBrandService
```
**Responsabilidade:** Cadastro e gestão de marcas de produtos.

---

### **Catalog** (`Modules/Catalog/`) — *Maior módulo*
```
app/
├── Concerns/        # Traits/Concerns reutilizáveis
├── Filament/        # Resources, Pages, Widgets do Filament (admin)
├── Http/            # Controllers, Requests
├── Jobs/            # ProcessCatalogProductQueue, etc.
├── Livewire/        # Components (Categories/, Products/)
├── Providers/       # CatalogServiceProvider
├── Services/        # CatalogProductService, CatalogCategoryProductService,
│                    # CatalogProductAttributeService, CatalogProductMediaService,
│                    # CatalogProductQueueService
├── Tasks/           # Tasks assíncronas
├── Transformers/    # API Resources
└── View/            # View composers, components
```
**Responsabilidade:** Catálogo completo — Produtos, Categorias, Atributos EAV, Imagens/Mídia, Estoque, Preços, Pesos, Paginação. Integra com EAV para atributos dinâmicos.

---

### **CatalogSearch** (`Modules/CatalogSearch/`)
```
app/
├── DTO/             # Data Transfer Objects
├── Http/            # Controllers (busca frontend)
├── Providers/       # CatalogSearchServiceProvider
├── Services/        # Serviços de busca (Elasticsearch/Meilisearch/DB)
└── View/            # View components de busca
```
**Responsabilidade:** Busca no frontend da loja (autocomplete, filtros, resultados).

---

### **Checkout** (`Modules/Checkout/`)
```
app/
├── DTO/             # CartItemDTO
├── Http/            # Controllers (checkout flow)
├── Providers/       # CheckoutServiceProvider
├── Services/        # CheckoutCartService, StockService
├── Validators/      # Validações de checkout
└── View/            # View components (carrinho, mini-cart)
```
**Responsabilidade:** Fluxo integrado de compra — Carrinho, Itens, Cliente, Endereço, Métodos de Pagamento, Descontos, Pedido, Processamento. Lógica de negócio em Services.

---

### **Cms** (`Modules/Cms/`)
```
app/
├── Http/            # Controllers (páginas institucionais)
├── Livewire/        # Componentes Livewire (admin)
├── Providers/       # CmsServiceProvider
└── View/            # View components (renderização de páginas)
```
**Responsabilidade:** Páginas estáticas/institucionais — "Quem Somos", "Institucional", "Política de Privacidade", etc.

---

### **Customers** (`Modules/Customers/`)
```
app/
├── Http/            # Controllers (área do cliente, admin)
├── Providers/       # CustomersServiceProvider
└── Services/        # Serviços de cliente
```
**Responsabilidade:** Gestão de clientes — cadastro, endereços, pedidos, wishlist, autenticação frontend.

---

### **Payments** (`Modules/Payments/`) — *Strategy Pattern*
```
app/
├── Concerns/        # Traits compartilhados
├── Contracts/       # Interfaces (PaymentGateway, PaymentMethod)
├── Exceptions/      # Exceções customizadas
├── Facade/          # Facade para acesso fácil
├── Gateways/        # AbstractGateway, IpagGateway, PagarMeGateway, configs
├── Http/            # Controllers (callbacks, redirects)
├── Manager/         # PaymentManager (factory/strategy)
├── Methods/         # AbstractMethod, IpagPixMethod, IpagCreditCardMethod,
│                    # IpagBoletoMethod, PagarMePixMethod, PagarMeCreditCardMethod,
│                    # PagarMeBoletoMethod
└── Providers/       # PaymentsServiceProvider
```
**Responsabilidade:** Integração com gateways (Ipag, PagarMe) usando **Strategy Pattern**. Suporta PIX, Cartão, Boleto. Descontos por método. Fluxos assíncronos. Retorno de gateway isolado da lógica de pedido.

---

### **Reports** (`Modules/Reports/`)
```
app/
├── Http/            # Controllers
├── Livewire/        # Componentes Livewire (dashboards/relatórios)
└── Providers/       # ReportsServiceProvider
```
**Status:** **Pendente** — Falta implementar relatórios (vendas, produtos, clientes, financeiro).

---

### **Review** (`Modules/Review/`)
```
app/
├── Enums/           # Status de review, tipos
├── Http/            # Controllers
├── Providers/       # ReviewServiceProvider
└── Services/        # ReviewService
```
**Status:** **Parcial** — Reviews de Produtos e Marcas. Falta terminar (frontend, moderação, emails).

---

### **Sales** (`Modules/Sales/`)
```
app/
├── Concerns/        # Traits
├── Emails/          # Mailable classes (confirmação, status, etc.)
├── Events/          # Eventos (OrderCreated, OrderPaid, etc.)
├── Http/            # Controllers (admin + frontend)
├── Listeners/       # Event Listeners
├── Livewire/        # Componentes (admin: orders, quotes)
├── Providers/       # SalesServiceProvider
├── Services/        # SalesQuoteService, SalesOrderService, etc.
├── Transformers/    # API Resources
└── View/            # View components
```
**Responsabilidade:** Pedidos (Orders), Orçamentos (Quotes), Emails transacionais, Eventos de domínio, Histórico, Status de pagamento/entrega.

---

### **SalesRules** (`Modules/SalesRules/`)
```
app/
├── Http/            # Controllers
├── Livewire/        # Componentes (regras de promoção no admin)
├── Providers/       # SalesRulesServiceProvider
└── Services/        # Promoção/Desconto services
```
**Responsabilidade:** Regras de promoção — cupons, descontos por quantidade, "compre X leve Y", frete grátis, condições por cliente/produto/categoria.

---

### **Site** (`Modules/Site/`)
```
app/
├── Http/            # Controllers (homepage)
└── Providers/       # SiteServiceProvider
```
**Status:** **Pendente/Incerto** — Controle do que aparece na Home (banners, vitrines, destaques). Ainda não implementado totalmente; existência incerta.

---

### **Catalog** (já visto acima) — *Relevante para Site*

---

## Padrões Arquiteturais Comuns

| Padrão | Onde Aplicado |
|--------|---------------|
| **Service Layer** | Todos os módulos (`Services/`) — regras de negócio |
| **Repository Pattern** | Via `Idea\Framework\Repository\*` — acesso a dados |
| **DTO** | `Checkout`, `CatalogSearch` — transferência tipada |
| **Strategy Pattern** | `Payments` — Gateways e Métodos intercambiáveis |
| **EAV** | `Eav` + `Catalog` — Atributos dinâmicos |
| **Event/Listener** | `Sales` — OrderCreated, OrderPaid, etc. |
| **Jobs/Queue** | `Catalog` (ProcessCatalogProductQueue), `Checkout` |
| **Filament Resources** | `Catalog`, `Brands`, `Customers`, `Sales`, `SalesRules`, `Cms` — Admin UI |
| **Livewire Components** | Todos — Admin e Frontend reativo |
| **Transformers/API Resources** | `Catalog`, `Sales`, `Eav`, `System` — API responses |

---

## Integração entre Módulos

```
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│   Catalog   │────▶│   Eav       │◀───│  Brands     │
│ (Produtos)  │     │ (Atributos) │     │ (Marcas)    │
└──────┬──────┘     └─────────────┘     └─────────────┘
       │
       ▼
┌─────────────┐     ┌─────────────┐     ┌─────────────┐
│  Checkout   │────▶│  Payments   │────▶│   Sales     │
│ (Carrinho,  │     │ (Gateway,   │     │ (Pedidos,   │
│  Checkout)  │     │  Strategy)  │     │  Quotes)    │
└──────┬──────┘     └─────────────┘     └──────┬──────┘
       │                                       │
       ▼                                       ▼
┌─────────────┐                         ┌─────────────┐
│ Customers   │                         │ SalesRules  │
│ (Cliente,   │                         │ (Promoções, │
│  Endereços) │                         │  Descontos) │
└─────────────┘                         └─────────────┘
```

---

## Módulos Base (`lib/Idea/Framework`)

O projeto possui dependências locais em `lib/`:
- `lib/Idea/Framework` — Core compartilhado (Repositories base, AbstractService, ServiceCache, etc.)
- `lib/alperenersoy/filament-export` — Exportação Filament customizada

Estes são incluídos via `composer.json` como repositórios `path` com `symlink: true`.

---

## Status de Implementação

| Módulo | Completo | Observações |
|--------|----------|-------------|
| Eav | ✅ | Base para Catalog |
| System | ✅ | Configurações globais |
| Brands | ✅ | CRUD completo |
| Catalog | ✅ | Core do e-commerce |
| CatalogSearch | ✅ | Busca funcional |
| Checkout | ✅ | Fluxo completo |
| Cms | ✅ | Páginas institucionais |
| Customers | ✅ | Área do cliente + admin |
| Payments | ✅ | Strategy Pattern, 2 gateways |
| Reports | ❌ | **Não implementado** |
| Review | ⚠️ | **Parcial** (falta frontend/moderação) |
| Sales | ✅ | Pedidos, quotes, emails |
| SalesRules | ✅ | Regras de desconto |
| Site | ❓ | **Incerto/Parcial** |

---

> **Atualizado em:** 2026-11-09  
> **Projeto:** ArtsaShop (ecommerce-laravel)  
> **Package:** `nwidart/laravel-modules` v13