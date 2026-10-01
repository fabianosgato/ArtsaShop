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
 * Rotas padroes do sistema
 */

use Illuminate\Support\Facades\Route;

// Rota padrao para o Dashboard
//Route::get('/wsdadm', [\App\Http\Controllers\Backend\Dashboard::class, 'index'])
//    ->name('dashboard');

// Rotas para o "profile" do usuario
Route::middleware('auth')->group(function () {

    Route::get('/wsdadm', [\App\Http\Controllers\Backend\Dashboard::class, 'index'])
        ->name('wsdadm.dashboard');

    Route::get('/profile', [\App\Http\Controllers\Backend\ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [\App\Http\Controllers\Backend\ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [\App\Http\Controllers\Backend\ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('/wsdadm/manual', [\App\Http\Controllers\Backend\Dashboard::class, 'manual'])
        ->name('wsdadm.manual');

});

require __DIR__.'/auth.php';
