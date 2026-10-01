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

    Route::prefix('stores')->group(function () {

        // Rota para exibir as Lojas
        Route::get('/', [\Modules\System\Http\Controllers\Api\StoreController::class, 'index'])
            ->name('get.store.index');

    });

});
