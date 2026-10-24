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
