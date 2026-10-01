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

Route::middleware('check.apikey')->prefix('v1')->group(function () {

    // Roda dos relatorios
    Route::prefix('report')->group(function () {

        // Rotas para criacao de Logs
        Route::prefix('logs')->group(function () {

            // PUT do relatorio de Logs
            Route::put('/', [\Modules\Reports\Http\Controllers\Api\LogsController::class, 'store'])
                ->name('logs.store');

        });

    });

});
