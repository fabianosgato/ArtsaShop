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
use Modules\Brands\Http\Controllers\Wsdadm\BrandsController;

Route::prefix('wsdadm')->middleware('auth')->group(function () {

    Route::prefix('brands')->middleware('auth')->group(function () {

        Route::get('/', [BrandsController::class, 'index'])->name('wsdadm.brands');

        Route::get('/insert', [BrandsController::class, 'insert'])->name('wsdadm.brands.insert');

        Route::get('/edit/{id}', [BrandsController::class, 'edit'])->name('wsdadm.brands.edit');

    });

});
