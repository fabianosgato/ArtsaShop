<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Inicializa as rotas do Admin
Route::prefix('wsdadm')->middleware('auth')->group(function () {

    Route::prefix('sales-rules')->group(function () {

        Route::get('/', [Modules\SalesRules\Http\Controllers\Wsdadm\SalesRulesController::class, 'index'])
            ->name('wsdadm.sales-rules');

        Route::get('/insert', [Modules\SalesRules\Http\Controllers\Wsdadm\SalesRulesController::class, 'insert'])
            ->name('wsdadm.sales-rules.insert');

        Route::get('/edit/{id}', [Modules\SalesRules\Http\Controllers\Wsdadm\SalesRulesController::class, 'edit'])
            ->name('wsdadm.sales-rules.edit');

    });


});
