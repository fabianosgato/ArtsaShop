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

Route::post('/auth/login', [\App\Http\Controllers\Api\Login::class, 'store'])
    ->name('api.login.store');

Route::post('/auth/logout', [\App\Http\Controllers\Api\Login::class, 'delete'])
    ->middleware('auth:sanctum')
    ->name('api.login.delete');

// CEP Lookup (proxy para ViaCEP / BrasilAPI)
Route::prefix('cep')->group(function () {
    Route::get('{cep}', [\App\Http\Controllers\Api\ZipCodeController::class, 'lookup'])
        ->where('cep', '[0-9]{8}')
        ->name('api.cep.lookup');
});

// Rotas para definir o location do cliente
Route::prefix('location')->group(function () {
    Route::post('save', [\App\Http\Controllers\Api\LocationController::class, 'save'])
        ->name('api.location.save');
});
