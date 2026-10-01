<?php
/**
 * Lef Tecnologia
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
 * @copyright    Copyright (c) 2010 - 2025
 * @author       Fabiano Gato <fabiano.sgato@gmail.com>
 *
 */

use Illuminate\Support\Facades\Route;
use Modules\Brands\Http\Controllers\Wsdadm\BrandsController;

Route::prefix('wsdadm')->middleware('auth')->group(function () {

    Route::prefix('brands')->middleware('auth')->group(function () {

        Route::get('/', [BrandsController::class, 'index'])->name('wsdadm.brands');

        Route::get('/insert', [BrandsController::class, 'insert'])->name('wsdadm.brands.insert');

        Route::get('/edit/{id}', [BrandsController::class, 'edit'])->name('wsdadm.brands.edit');

    });

});
