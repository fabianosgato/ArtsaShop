<?php

use Illuminate\Support\Facades\Route;
use Modules\Reports\Http\Controllers\ReportsController;

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

Route::prefix('reports')->group(function () {

    // Relatorio de pedidos
    Route::get('/orders', [ReportsController::class, 'orders'])->middleware('auth')->name('reports.orders');
    Route::get('/orders-view/{id}', [ReportsController::class, 'orderReportView'])->middleware('auth')->name('reports.orders-view');
    Route::get('/orders-show/{id}', [ReportsController::class, 'orderReportShow'])->middleware('auth')->name('reports.orders-show');

    // Relatorio de Logs
    Route::get('/logs', [ReportsController::class, 'logs'])->middleware('auth')->name('reports.logs');

    // Relatorio de Preços Customizados
    Route::get('/fob-custom', [ReportsController::class, 'fobCustom'])->middleware('auth')->name('reports.fob-custom');

    // Relatorio de Pesos Incorretos
    Route::get('/incorrect-weight', [ReportsController::class, 'incorrectWeight'])->middleware('auth')->name('reports.incorrect-weight');

});
