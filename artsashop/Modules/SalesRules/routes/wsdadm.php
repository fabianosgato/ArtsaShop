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
 * @description Arquivo de Rotas para o WsdAdmin
 *
 */

use Illuminate\Support\Facades\Route;

Route::prefix('sales-rules')->group(function () {

    Route::get('/', [Modules\SalesRules\Http\Controllers\Wsdadm\SalesRulesController::class, 'index'])
        ->name('wsdadm.sales-rules');

    Route::get('/insert', [Modules\SalesRules\Http\Controllers\Wsdadm\SalesRulesController::class, 'insert'])
        ->name('wsdadm.sales-rules.insert');

    Route::get('/edit/{id}', [Modules\SalesRules\Http\Controllers\Wsdadm\SalesRulesController::class, 'edit'])
        ->name('wsdadm.sales-rules.edit');

});
