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

Route::middleware('guest')->group(function () {

    // Rota para o login do usuário
    Route::get('/wsdadm', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'login'])
        ->name('wsdadmin.login');

    // Realiza o POST do login do usuário
    Route::post('/wsdadm/login-post', [\App\Http\Controllers\Auth\AuthenticatedSessionController::class, 'store'])
        ->name('wsdadmin.login.store');

    // Rota para o form do "esqueci a senha" do WsdAdmin
    Route::get('forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'create'])
        ->name('password.request');

    // Realiza o POST do "esqueci a senha"
    Route::post('forgot-password', [\App\Http\Controllers\Auth\PasswordResetLinkController::class, 'store'])
        ->name('password.email');

    Route::get('reset-password/{token}', [\App\Http\Controllers\Auth\NewPasswordController::class, 'create'])
        ->name('password.reset');

    Route::post('reset-password', [\App\Http\Controllers\Auth\NewPasswordController::class, 'store'])
        ->name('password.store');

});


// Rotas padrões do WsdAdmin
Route::middleware('auth')->group(function () {

    // Rota para o Dashboard do sistema
    Route::get('/dashboard', [\App\Http\Controllers\Backend\Dashboard::class, 'index'])
        ->name('wsdadm.dashboard');

    // Rota para edição do perfil do usuá´rio
    Route::get('/profile', [\App\Http\Controllers\Backend\ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [\App\Http\Controllers\Backend\ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [\App\Http\Controllers\Backend\ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    Route::get('/wsdadm/manual', [\App\Http\Controllers\Backend\Dashboard::class, 'manual'])
        ->name('wsdadm.manual');

});

require __DIR__ . '/auth.php';
