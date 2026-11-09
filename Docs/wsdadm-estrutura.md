# WsdAdmin - Estrutura do Painel Administrativo

## Visão Geral

O WsdAdmin é o painel administrativo do ArtsaShop, construído com **FilamentPHP 5**, **Livewire 4**, **WireUI** e **AdminLTE**, sobre **Tailwind CSS 4 + Vite**.

---

## Rotas (`routes/wsdadm.php`)

### Grupo Guest (não autenticado)
| Método | URI | Controller | Name |
|--------|-----|------------|------|
| GET | `/wsdadm` | `AuthenticatedSessionController@login` | `wsdadmin.login` |
| POST | `/wsdadm/login-post` | `AuthenticatedSessionController@store` | `wsdadmin.login.store` |
| GET | `forgot-password` | `PasswordResetLinkController@create` | `password.request` |
| POST | `forgot-password` | `PasswordResetLinkController@store` | `password.email` |
| GET | `reset-password/{token}` | `NewPasswordController@create` | `password.reset` |
| POST | `reset-password` | `NewPasswordController@store` | `password.store` |

### Grupo Auth (autenticado)
| Método | URI | Controller | Name |
|--------|-----|------------|------|
| GET | `/dashboard` | `Backend\Dashboard@index` | `wsdadm.dashboard` |
| GET | `/profile` | `Backend\ProfileController@edit` | `profile.edit` |
| PATCH | `/profile` | `Backend\ProfileController@update` | `profile.update` |
| DELETE | `/profile` | `Backend\ProfileController@destroy` | `profile.destroy` |
| GET | `/wsdadm/manual` | `Backend\Dashboard@manual` | `wsdadm.manual` |
| GET | `verify-email` | `EmailVerificationPromptController` | `verification.notice` |
| GET | `verify-email/{id}/{hash}` | `VerifyEmailController` | `verification.verify` |
| POST | `email/verification-notification` | `EmailVerificationNotificationController@store` | `verification.send` |
| GET | `confirm-password` | `ConfirmablePasswordController@show` | `password.confirm` |
| POST | `confirm-password` | `ConfirmablePasswordController@store` | — |
| POST | `logout` | `AuthenticatedSessionController@destroy` | `logout` |
| PUT | `password` | `PasswordController@update` | `password.update` |

---

## Views (`resources/views/wsdadm/`)

### Layouts (`layouts/`)
| Arquivo | Descrição |
|---------|-----------|
| `app.blade.php` | Layout principal: fontes Figtree, favicons, Vite (CSS/JS wsdadm), `@filamentStyles`, `@livewireStyles`, `@filamentScripts`, `@livewireScripts`, `@vite`, `wireui:scripts`. Estrutura AdminLTE (wrapper, sidebar, header, content-wrapper, footer). |
| `aside.blade.php` | Sidebar com logo + `livewire:menu-builder-component` (menu dinâmico gerenciável). |
| `navigation.blade.php` | Top navbar: theme toggle (dark/light), user dropdown (profile/logout) via WireUI `x-dropdown`. |
| `guest.blade.php` | Layout para páginas de guest (login, password reset). |
| `manual.blade.php` | Layout da página de manual. |
| `flash-messages.blade.php` | Mensagens flash (toasts/notificações). |

### Páginas Principais
| Arquivo | Descrição |
|---------|-----------|
| `dashboard.blade.php` | Dashboard: boas-vindas + cards de pedidos do dia (usa `$orders['total']`, `$orders['dateIni']`, `$orders['dateEnd']`). |
| `manual.blade.php` | Manual do sistema. |

### Autenticação (`auth/`)
- `login.blade.php`
- `forgot-password.blade.php`
- `reset-password.blade.php`
- `verify-email.blade.php`
- `confirm-password.blade.php`
- `register.blade.php`

### Perfil (`profile/`)
- Edição de perfil do usuário administrativo.

### Componentes Livewire (`livewire/`)
Componentes customizados do WsdAdmin.

### Partials (`partials/`)
Partials reutilizáveis.

---

## Stack Tecnológica

| Tecnologia | Uso |
|------------|-----|
| **FilamentPHP 5** | Base do admin panel (styles, scripts, componentes) |
| **Livewire 4** | Componentes reativos (menu builder, notificações) |
| **WireUI** | Componentes UI (dropdown, buttons, inputs, scripts) |
| **AdminLTE** | Estrutura CSS (wrapper, sidebar, header, content-wrapper) |
| **Tailwind CSS 4 + Vite** | Assets separados em `resources/css/wsdadm/` e `resources/js/wsdadm/` |
| **Alpine.js** | Interatividade client-side (via Livewire/WireUI) |

---

## Pontos-Chave da Arquitetura

1. **Menu Dinâmico** — `livewire:menu-builder-component` no aside permite gerenciar menu pelo admin.
2. **Separação Total de Assets** — WsdAdmin não mistura com Frontend (`wsdadm` vs `frontend` no Vite).
3. **Notificações Globais** — `@livewire('notifications')` no layout principal.
4. **Multi-Store no Admin** — Middleware `IdentifyStoreByHost` ativo no grupo `web` (resolve loja pelo host).
5. **Dark Mode Nativo** — Suporte via Tailwind + theme toggle na navbar.
6. **CSRF Desabilitado** — Apenas em `payments/callback` e `payments/redirect` (webhooks de gateway).

---

## Middleware Específicos (definidos em `bootstrap/app.php`)

- `redirectGuestsTo` → `wsdadmin.login`
- `trustProxies(at: '*')` → Cloudflare/Load Balancers
- `IdentifyStoreByHost` → Apenas grupo `web` (multi-store)
- `preventRequestForgery(except: ['payments/callback', 'payments/redirect'])`
- `alias('auth.customer')` → `RedirectIfCustomerUnauthenticated`
- `HandleInertiaRequests` → Suporte a Inertia.js (Vue.js) no grupo `web`

---

## Comandos Artisan Registrados

- `GenerateSitemapCommand` — Geração de sitemap
- `CommandIndexerProducts` — Indexação de produtos (busca/SEO)

---

## Health Check

- Endpoint: `/up`

---

> **Atualizado em:** 2026-11-09  
> **Projeto:** ArtsaShop (ecommerce-laravel)