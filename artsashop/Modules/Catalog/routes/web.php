<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 *
 * É concedida permissão, gratuitamente, a qualquer pessoa que obtenha uma cópia
 * deste software e arquivos de documentação associados
 *
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
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
