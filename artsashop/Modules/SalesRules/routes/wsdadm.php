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

Route::prefix('sales-rules')->group(function () {

    Route::get('/', [Modules\SalesRules\Http\Controllers\Wsdadm\SalesRulesController::class, 'index'])
        ->name('wsdadm.sales-rules');

    Route::get('/insert', [Modules\SalesRules\Http\Controllers\Wsdadm\SalesRulesController::class, 'insert'])
        ->name('wsdadm.sales-rules.insert');

    Route::get('/edit/{id}', [Modules\SalesRules\Http\Controllers\Wsdadm\SalesRulesController::class, 'edit'])
        ->name('wsdadm.sales-rules.edit');

});
