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
use Modules\Payments\Http\Controllers\PaymentsController;

Route::prefix('payments')->group(function () {

    // Rota para "refazer" o pagamento
    Route::get('pay/{orderId}', [PaymentsController::class, 'pay'])->name('payments.pay');

    // Rota para "validar" o pagamento
    Route::get('status/{orderId}', [PaymentsController::class, 'validatePayment'])->name('payments.validatePayment');

    // Rota de Redirect para Pagamentos
    Route::post('redirect', [PaymentsController::class, 'redirect'])->name('payments.redirect');

    // Rota de Callback para Pagamentos
    Route::post('callback', [PaymentsController::class, 'callback'])->name('payments.callback');

});
