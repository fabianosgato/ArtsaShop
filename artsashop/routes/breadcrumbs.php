<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * Não editar ou acrescentar à este arquivo se você quiser fazer o upgrade para versões
 * mais recentes no futuro.
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */

use Idea\Framework\Repository\Catalog\CatalogCategoryRepository;
use Idea\Framework\View\Front\Breadcrumbs\Breadcrumbs;
use Idea\Framework\View\Front\Breadcrumbs\Generator as BreadcrumbTrail;

// Home
Breadcrumbs::for('home', function (BreadcrumbTrail $trail) {
    $trail->push('Home', route('index.home'));
});

// Página de Contato
Breadcrumbs::for('contacts.index', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Fale Conosco', route('contacts.index'));
});

// Página de "Esqueci Minha Senha"
Breadcrumbs::for('account.forgotpassword', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Esqueci minha senha', route('account.forgotpassword'));
});

// Página de login
Breadcrumbs::for('account.login', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Meu Painel', route('account.login'));
});

// Página de login
Breadcrumbs::for('account.create', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Criação da conta', route('account.create'));
});

// Busca
Breadcrumbs::for('catalogsearch.shop', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Shop', route('catalogsearch.shop'));
});

// Resultados da Busca
Breadcrumbs::for('catalogsearch.result', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Busca', route('catalogsearch.result'));
});

// Carrinho de Compras
Breadcrumbs::for('checkout.cart', function (BreadcrumbTrail $trail) {
    $trail->parent('home');
    $trail->push('Carrinho de Compras', route('checkout.cart'));
});

// Finalização da Compra
Breadcrumbs::for('checkout.onepage.index', function (BreadcrumbTrail $trail) {
    $trail->parent('checkout.cart');
    $trail->push('Finalização da Compra', route('checkout.onepage.index'));
});

// Conclusao da Compra
Breadcrumbs::for('checkout.onepage.success', function (BreadcrumbTrail $trail) {
    $trail->parent('checkout.onepage.index');
    $trail->push('Conclusão da Compra', null);
});

// Páginas de CMS
Breadcrumbs::for('cms', function (BreadcrumbTrail $trail, \App\Models\CmsPage $page) {
    $trail->parent('home');
    $trail->push($page->title, url($page->slug_key));
});

// Páginas de Categoria (com hierarquia)
Breadcrumbs::for('category', function (BreadcrumbTrail $trail, \App\Models\CatalogCategoryEntity $category) {

    if ($category->parent_id) {
        $catalogCategoryEntity = CatalogCategoryRepository::getCategoryByParentId($category->parent_id);
        $trail->parent('category', $catalogCategoryEntity);
    } else {
        $trail->parent('home');
    }

    $trail->push($category->category, url($category->slug_key));

});

// Páginas de Marcas
Breadcrumbs::for('brand', function (BreadcrumbTrail $trail, \App\Models\CatalogProductBrand $brand) {
    $trail->parent('home');
    $catalogProductBrand = \Idea\Framework\Repository\Brand\CatalogProductBrandRepository::getBrand($brand->brand_id);
    $trail->push($catalogProductBrand->brand_name, url($catalogProductBrand->brand_key));
});

// Páginas do produto
Breadcrumbs::for('product', function (BreadcrumbTrail $trail, \App\Models\CatalogProduct $product) {
    $trail->parent('home');
    $trail->push($product->name, url($product->slug_key));

});


