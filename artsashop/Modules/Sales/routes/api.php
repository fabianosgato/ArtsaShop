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

    Route::prefix('sales')->group(function () {

        // Rotas para os pedidos
        Route::prefix('order')->group(function () {

            Route::get('/', [Modules\Sales\Http\Controllers\Api\ApiSalesOrderController::class, 'index'])
                ->name('api.v1.sales.order.index');

            Route::get('/details', [Modules\Sales\Http\Controllers\Api\ApiSalesOrderController::class, 'details'])
                ->name('api.v1.sales.order.details');

            Route::post('/update', [Modules\Sales\Http\Controllers\Api\ApiSalesOrderController::class, 'update'])
                ->name('api.v1.sales.order.update');

        });

        // Rotas para o Quote
        Route::prefix('quote')->group(function () {

            // Index dos Quotes Ativos
            Route::get('/', [Modules\Sales\Http\Controllers\Api\ApiSalesQuoteController::class, 'index'])
                ->name('api.v1.sales.quote.index');

            Route::post('update', [Modules\Sales\Http\Controllers\Api\ApiSalesQuoteController::class, 'updateQuote'])
                ->name('api.v1.sales.quote.update');

        });

    });

});
