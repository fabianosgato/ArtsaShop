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

Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    Route::prefix('catalog')->group(function () {

        // Lista todos os produtos
        Route::get('/', [\Modules\Catalog\Http\Controllers\Api\CatalogProductController::class, 'index'])
            ->name('api.v1.catalog.product.index');

        // Insere um produto
        Route::Post('/', [\Modules\Catalog\Http\Controllers\Api\CatalogProductController::class, 'store'])
            ->name('api.v1.catalog.product.store');

        // Atualiza um produto
        Route::Put('/', [\Modules\Catalog\Http\Controllers\Api\CatalogProductController::class, 'update'])
            ->name('api.v1.catalog.product.update');

        // Atualiza as imagens de um produto
        Route::Put('/update-images', [\Modules\Catalog\Http\Controllers\Api\CatalogProductController::class, 'updateImages'])
            ->name('api.v1.catalog.product.updateImages');

        // Retorna as informações de um produto
        Route::get('/product', [\Modules\Catalog\Http\Controllers\Api\CatalogProductController::class, 'show'])
            ->name('api.v1.catalog.product.product');

    });

});
