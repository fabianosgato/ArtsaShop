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
    Route::prefix('sales')->middleware('auth')->group(function () {

        Route::prefix('orders')->group(function () {

            Route::get('/', [\Modules\Sales\Http\Controllers\Wsdadm\SalesController::class, 'index'])
                ->middleware('auth')
                ->name('wsdadm.orders');

            Route::get('view/{id}', [\Modules\Sales\Http\Controllers\Wsdadm\SalesController::class, 'view'])
                ->middleware('auth')
                ->name('wsdadm.orders.view');

            Route::get('show/{id}', [\Modules\Sales\Http\Controllers\Wsdadm\SalesController::class, 'show'])
                ->middleware('auth')
                ->name('wsdadm.orders.show');

        });

    });

});

/**
 * Rotas para o frontend
 */
Route::prefix('sales')->middleware('auth.customer')->group(function () {

    Route::prefix('order')->middleware('auth.customer')->group(function () {

        // Página com detalhes do pedido do cliente
        Route::get('index/{id}', [\Modules\Sales\Http\Controllers\Frontend\SalesOrderController::class, 'index'])
            ->middleware('auth.customer')
            ->name('sales.order.index');

    });


});
