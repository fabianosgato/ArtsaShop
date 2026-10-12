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

    Route::prefix('brands')->group(function () {

        // Retorna as marcas do sistema
        Route::get('/', [\Modules\Brands\Http\Controllers\Api\CatalogBrandController::class, 'index'])
            ->name('api.v1.catalog.brand.index');

        // Insere marca no sistema
        Route::Post('/', [\Modules\Brands\Http\Controllers\Api\CatalogBrandController::class, 'store'])
            ->name('api.v1.catalog.brand.store');

        // Atualiza uma marca no sistema
        Route::Put('/{key}', [\Modules\Brands\Http\Controllers\Api\CatalogBrandController::class, 'update'])
            ->name('api.v1.catalog.brand.update');

        // Deleta uma marca no sistema
        Route::Delete('/', [\Modules\Brands\Http\Controllers\Api\CatalogBrandController::class, 'destroy'])
            ->name('api.v1.catalog.brand.delete');

    });

});
