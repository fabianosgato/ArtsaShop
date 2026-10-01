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
 * Rotas padroes do sistema
 */

use Illuminate\Support\Facades\Route;

/**
 * Rotas para o admin wsdadm
 */
Route::prefix('wsdadm')->middleware('auth')->group(function () {

    // Inicializa as rotas do Admin
    Route::prefix('catalog')->middleware('auth')->group(function () {

        // Define as rotas do submodulo Categories
        Route::prefix('categories')->group(function () {

            Route::get('/', [\Modules\Catalog\Http\Controllers\Wsdadm\CategoriesController::class, 'index'])
                ->middleware('auth')
                ->name('wsdadm.categories');

        });

        // Define as rotas do submodulo Products
        Route::prefix('products')->group(function () {

            Route::get('/', [\Modules\Catalog\Http\Controllers\Wsdadm\ProductController::class, 'index'])
                ->middleware('auth')
                ->name('wsdadm.catalog.products');

            Route::post('/reorder-images', [\Modules\Catalog\Http\Controllers\Wsdadm\ProductController::class, 'reorderImages'])
                ->middleware('auth')
                ->name('wsdadm.catalog.products.reorderImages');

            Route::get('insert', [\Modules\Catalog\Http\Controllers\Wsdadm\ProductController::class, 'insert'])
                ->middleware('auth')
                ->name('wsdadm.catalog.products.insert');

            Route::get('show/{id}', [\Modules\Catalog\Http\Controllers\Wsdadm\ProductController::class, 'show'])
                ->middleware('auth')
                ->name('wsdadm.catalog.products.show');

            Route::get('edit/{id}', [\Modules\Catalog\Http\Controllers\Wsdadm\ProductController::class, 'edit'])
                ->middleware('auth')
                ->name('wsdadm.catalog.products.edit');

        });

    });

});
