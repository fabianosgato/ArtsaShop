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
use Modules\Catalog\Http\Controllers\Api\CatalogProductController;

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

    Route::prefix('catalog')->group(function () {

        Route::get('/', [CatalogProductController::class, 'index'])->name('index');
        Route::Post('/', [CatalogProductController::class, 'store'])->name('store');
        Route::Put('/', [CatalogProductController::class, 'update'])->name('update');

        Route::get('/product', [CatalogProductController::class, 'show'])->name('product');

    });

});
