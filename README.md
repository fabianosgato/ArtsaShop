# ArtsaShop

> Plataforma de e-commerce desenvolvida com Laravel, utilizando uma arquitetura modular e separação entre frontend e painel administrativo.

**Demo:** https://ecommerce.lef-tecnologia.com.br/

---

## Sobre o projeto

O **ArtsaShop** é uma plataforma de comércio eletrônico desenvolvida com **Laravel 13**, criada com foco em uma arquitetura organizada, modular e preparada para evolução.

O projeto foi desenvolvido como uma aplicação real, buscando aplicar boas práticas de desenvolvimento backend, organização de domínio, separação de responsabilidades e integração entre diferentes componentes da aplicação.

A aplicação possui dois ambientes principais:

* **Frontend:** interface pública da loja.
* **WsdAdm:** painel administrativo utilizado para gerenciamento da plataforma.

O projeto utiliza uma arquitetura baseada em módulos através do `nwidart/laravel-modules`, permitindo que funcionalidades relacionadas sejam organizadas de forma independente dentro da aplicação.

---

## Demonstração

A aplicação está disponível em:

**https://ecommerce.lef-tecnologia.com.br/**

> O ambiente online tem como objetivo demonstrar a aplicação funcionando. O projeto continua em desenvolvimento e algumas funcionalidades podem estar em evolução.

---

## Principais tecnologias

### Backend

* PHP 8.3+
* Laravel 13
* Laravel Sanctum
* Livewire 4
* Eloquent ORM
* Laravel Queues
* Laravel Cache
* PHPUnit
* Laravel Pint

### Administração

* FilamentPHP 5
* Livewire
* Filament Forms
* Filament Tables
* Filament Actions
* Filament Notifications

### Arquitetura

* `nwidart/laravel-modules`
* Arquitetura modular
* Service Layer
* Repository Pattern
* DTOs
* EAV (Entity-Attribute-Value)
* Separação entre frontend e administração

### Frontend

* Blade
* Tailwind CSS 4
* Vite
* Alpine.js
* Livewire

O Vite possui entradas separadas para os assets do painel administrativo e do frontend da loja, permitindo que as duas áreas tenham seus próprios recursos e ciclo de desenvolvimento.

---

## Arquitetura modular

Uma das principais características do projeto é a utilização do `nwidart/laravel-modules`.

A ideia é evitar que toda a aplicação fique concentrada nas estruturas tradicionais de um único projeto Laravel, permitindo organizar funcionalidades relacionadas dentro de módulos independentes.

Exemplo conceitual:

```text
Modules/
├── Brands/
├── Catalog/
├── Checkout/
├── Customers/
├── Eav/
├── Reports/
├── Sales/
└── System/
```

Cada módulo pode possuir seus próprios:

* Controllers
* Models
* Services
* Repositories
* Requests
* Views
* Routes
* Migrations
* Providers
* Tests

Essa abordagem facilita a manutenção e permite que novas funcionalidades sejam adicionadas sem concentrar toda a regra de negócio em uma única estrutura.

---

## Catálogo de produtos

O catálogo utiliza uma estrutura própria para gerenciamento de produtos, categorias, atributos e mídias.

Entre os conceitos implementados estão:

* Produtos
* Categorias
* Relação produto/categoria
* Grupos de atributos
* Atributos EAV
* Opções de atributos
* Imagens e mídias
* Controle de estoque
* Preços
* Peso
* Paginação de produtos

### EAV

O projeto possui uma implementação de **Entity-Attribute-Value (EAV)** para permitir que produtos tenham atributos configuráveis.

Essa estrutura possibilita trabalhar com diferentes tipos de produtos sem precisar alterar a estrutura principal da tabela de produtos para cada novo atributo.

---

## Checkout

O checkout foi desenvolvido como um fluxo integrado de compra, envolvendo:

* Carrinho
* Itens do carrinho
* Cliente
* Endereço
* Métodos de pagamento
* Descontos
* Pedido
* Processamento do pagamento

A lógica de negócio é concentrada em serviços específicos, evitando colocar toda a responsabilidade diretamente nos Controllers ou componentes de interface.

---

## Pagamentos

A aplicação possui integração com gateway de pagamento e estrutura preparada para diferentes métodos de pagamento.

Entre os fluxos trabalhados estão:

* PIX
* Cartão
* Boleto
* Descontos específicos por método de pagamento
* Processamento de pedidos
* Fluxos assíncronos relacionados ao pagamento
* Tratamento de retorno do gateway

A integração foi estruturada de forma a manter as responsabilidades relacionadas ao gateway separadas da lógica geral do pedido.

---

## Painel administrativo

O projeto utiliza **FilamentPHP 5** para construção do painel administrativo.

O painel possui recursos para gerenciamento das principais entidades da aplicação, utilizando:

* Forms
* Tables
* Actions
* Notifications
* Components reutilizáveis
* Livewire

A utilização do Filament permite construir interfaces administrativas mantendo a lógica de negócio separada dos componentes de apresentação.

---

## Separação Frontend / WsdAdm

Os assets são organizados separadamente para evitar o acoplamento entre a loja e o painel administrativo.

```text
resources/
├── css/
│   ├── frontend/
│   └── wsdadm/
│
└── js/
    ├── frontend/
    └── wsdadm/
```

O Vite possui entradas independentes para cada área:

```javascript
'resources/css/wsdadm/app.css',
'resources/js/wsdadm/app.js',

'resources/css/frontend/app.css',
'resources/js/frontend/app.js'
```

Essa separação facilita a evolução independente da interface pública e do sistema administrativo.

---

## Estrutura de serviços

O projeto utiliza uma camada de serviços para concentrar regras de negócio.

Exemplos de responsabilidades que são tratadas através dessa abordagem:

```text
Service
├── Product
├── Checkout
├── Cart
├── Order
├── Payment
├── Clinic
└── ...
```

A intenção é manter os Controllers e componentes de interface mais simples, delegando operações de negócio para classes especializadas.

---

## Repositories

O projeto também utiliza Repository Pattern em partes do domínio.

Os repositories são responsáveis pelo acesso e manipulação de determinadas entidades, mantendo o código de persistência separado das regras de negócio.

Essa abordagem é utilizada em conjunto com Services para organizar o fluxo:

```text
Controller / Livewire / Filament
                │
                ▼
             Service
                │
                ▼
           Repository
                │
                ▼
            Eloquent
                │
                ▼
             Database
```

---

## Vite e Tailwind CSS

O frontend utiliza **Tailwind CSS 4** integrado ao Vite.

A configuração permite que o frontend e o WsdAdm mantenham seus próprios arquivos CSS e JavaScript.

O projeto também possui configuração específica para permitir que o Tailwind processe os componentes utilizados pelo Filament dentro de `vendor/filament`.

---

## Instalação

### Requisitos

* PHP >= 8.3
* Composer
* Node.js / NPM
* MySQL ou outro banco compatível com Laravel
* Extensões PHP necessárias pelo Laravel

O Laravel 13 atualmente requer PHP 8.3 ou superior.

### Clone o projeto

```bash
git clone https://github.com/fabianosgato/wsd-ecommerce.git

cd wsd-ecommerce
```

### Instale as dependências

```bash
composer install
```

```bash
npm install
```

### Configure o ambiente

```bash
cp .env.example .env
```

Configure no `.env` as informações do banco de dados e demais serviços utilizados pela aplicação.

Depois:

```bash
php artisan key:generate
```

### Banco de dados

Execute as migrations:

```bash
php artisan migrate
```

Caso o projeto disponibilize seeders para o ambiente desejado:

```bash
php artisan db:seed
```

### Assets

Para desenvolvimento:

```bash
npm run dev
```

Ou para gerar os assets de produção:

```bash
npm run build
```

O próprio `composer.json` do projeto possui scripts de setup e desenvolvimento que automatizam parte desse processo.

---

## Desenvolvimento

O projeto possui um script para iniciar simultaneamente os principais processos utilizados durante o desenvolvimento:

```bash
composer run dev
```

Esse processo inicia:

* Laravel
* Queue worker
* Laravel Pail
* Vite

A configuração está definida no `composer.json`.

---

## Testes

Os testes podem ser executados através do:

```bash
composer test
```

ou:

```bash
php artisan test
```

O projeto utiliza PHPUnit para testes automatizados.

---

## Objetivos técnicos do projeto

Além de funcionar como uma plataforma de e-commerce, este projeto também serve como laboratório para aplicação de conceitos de engenharia de software em uma aplicação Laravel de maior complexidade.

Entre os principais objetivos estão:

* Organização modular
* Separação de responsabilidades
* Reutilização de componentes
* Service Layer
* Repository Pattern
* EAV
* Integração com gateways de pagamento
* Processamento assíncrono
* Cache
* Filas
* Desenvolvimento de interfaces administrativas
* Otimização de frontend
* SEO
* Integração entre diferentes partes do sistema

---

## Status

**Em desenvolvimento.**

O projeto é continuamente evoluído e algumas áreas ainda estão sendo aprimoradas.

O objetivo deste repositório é também demonstrar a evolução de uma aplicação Laravel real, incluindo decisões arquiteturais, implementação de funcionalidades e resolução de problemas encontrados durante o desenvolvimento.

---

## Próximos passos

Algumas das áreas que podem receber evolução:

* Ampliação da cobertura de testes
* Melhorias de observabilidade
* Evolução do sistema de relatórios
* Melhorias de performance
* Melhorias de documentação
* Evolução das integrações de pagamento
* Automação de deploy
* CI/CD
* Ampliação das funcionalidades administrativas

---

## Licença

Este projeto está disponibilizado sob a licença MIT.

---

## Autor

**Fabiano**

Desenvolvedor PHP / Laravel

Mais de uma década de experiência com desenvolvimento PHP, com foco em aplicações web, sistemas de e-commerce, integrações e arquitetura de aplicações Laravel.
