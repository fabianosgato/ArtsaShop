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

    // Roda dos relatorios
    Route::prefix('report')->group(function () {

        // Rotas para criacao de Logs
        Route::prefix('logs')->group(function () {

            // PUT do relatorio de Logs
            Route::put('/', [\Modules\Reports\Http\Controllers\Api\LogsController::class, 'store'])
                ->name('api.v1.report.logs.store');

        });

    });

});
