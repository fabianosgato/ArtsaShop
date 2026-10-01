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

use Illuminate\Support\Facades\Route;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
*/

Route::middleware('check.apikey')->prefix('v1')->group(function () {

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
