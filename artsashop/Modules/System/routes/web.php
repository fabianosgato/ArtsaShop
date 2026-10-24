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

    // Rotas para as Lojas
    Route::prefix('sysstore')->middleware('auth')->group(function () {

        Route::get('/', [\Modules\System\Http\Controllers\Wsdadm\SysStoreController::class, 'index'])
            ->middleware('auth')
            ->name('wsdadm.sysstore');

        Route::get('edit/{id}', [\Modules\System\Http\Controllers\Wsdadm\SysStoreController::class, 'edit'])
            ->middleware('auth')
            ->name('wsdadm.sysstore.edit');

        Route::get('insert', [\Modules\System\Http\Controllers\Wsdadm\SysStoreController::class, 'insert'])
            ->middleware('auth')
            ->name('wsdadm.sysstore.insert');

    });

    // Configuração Geral
    Route::prefix('sysconfig')->middleware('auth')->group(function () {

        Route::get('/', [\Modules\System\Http\Controllers\Wsdadm\SettingsController::class, 'index'])
            ->middleware('auth')
            ->name('wsdadm.sysconfig');

        Route::post('save', [\Modules\System\Http\Controllers\Wsdadm\SettingsController::class, 'save'])
            ->middleware('auth')
            ->name('wsdadm.sysconfig.save');

    });

    // Define as rotas do submodulo sysgroups
    Route::prefix('sysgroups')->middleware('auth')->group(function () {

        Route::get('/', [\Modules\System\Http\Controllers\Wsdadm\SysGroupController::class, 'index'])
            ->middleware('auth')
            ->name('wsdadm.sysgroups');

        Route::get('insert', [\Modules\System\Http\Controllers\Wsdadm\SysGroupController::class, 'insert'])
            ->middleware('auth')
            ->name('wsdadm.sysgroups.insert');

        Route::get('edit/{id}', [\Modules\System\Http\Controllers\Wsdadm\SysGroupController::class, 'edit'])
            ->middleware('auth')
            ->name('wsdadm.sysgroups.edit');

        Route::post('save', [\Modules\System\Http\Controllers\Wsdadm\SysGroupController::class, 'save'])
            ->middleware('auth')
            ->name('wsdadm.sysgroups.save');

    });

    // Define as rotas do submodulo sysusers
    Route::prefix('sysusers')->middleware('auth')->group(function () {

        Route::get('/', [\Modules\System\Http\Controllers\Wsdadm\SysUserController::class, 'index'])
            ->middleware('auth')
            ->name('wsdadm.sysusers');

        Route::get('insert', [\Modules\System\Http\Controllers\Wsdadm\SysUserController::class, 'insert'])
            ->middleware('auth')
            ->name('wsdadm.sysusers.insert');

        Route::get('edit/{id}', [\Modules\System\Http\Controllers\Wsdadm\SysUserController::class, 'edit'])
            ->middleware('auth')
            ->name('wsdadm.sysusers.edit');

        Route::post('save', [\Modules\System\Http\Controllers\Wsdadm\SysUserController::class, 'save'])
            ->middleware('auth')
            ->name('wsdadm.sysusers.save');
    });

    // Define as rotas do submodulo sysmodules
    Route::prefix('sysmodules')->middleware('auth')->group(function () {

        Route::get('/', [\Modules\System\Http\Controllers\Wsdadm\SysModulesController::class, 'index'])
            ->middleware('auth')
            ->name('wsdadm.sysmodules');

        Route::get('insert', [\Modules\System\Http\Controllers\Wsdadm\SysModulesController::class, 'insert'])
            ->middleware('auth')
            ->name('wsdadm.sysmodules.insert');

        Route::get('edit/{id}', [\Modules\System\Http\Controllers\Wsdadm\SysModulesController::class, 'edit'])
            ->middleware('auth')
            ->name('wsdadm.sysmodules.edit');

        Route::post('save', [\Modules\System\Http\Controllers\Wsdadm\SysModulesController::class, 'save'])
            ->middleware('auth')
            ->name('wsdadm.sysmodules.save');
    });

    // Define as rotas do submodulo sysmenus
    Route::prefix('sysmenus')->middleware('auth')->group(callback: function () {

        Route::get('/{moduleId}', [\Modules\System\Http\Controllers\Wsdadm\SysModuleMenusController::class, 'index'])
            ->middleware('auth')
            ->name('wsdadm.sysmenu');

        Route::get('insert/{moduleId}', [\Modules\System\Http\Controllers\Wsdadm\SysModuleMenusController::class, 'insert'])
            ->middleware('auth')
            ->name('wsdadm.sysmenu.insert');

        Route::get('edit/{moduleId}/{id}', [\Modules\System\Http\Controllers\Wsdadm\SysModuleMenusController::class, 'edit'])
            ->middleware('auth')
            ->name('wsdadm.sysmenu.edit');

    });

    // Define as rotas do submodulo sysmenus
    Route::prefix('product-status')->middleware('auth')->group(function () {

        Route::get('/', [\Modules\System\Http\Controllers\Wsdadm\CatalogProductStatusController::class, 'index'])
            ->middleware('auth')
            ->name('wsdadm.product-status');

        Route::get('insert', [\Modules\System\Http\Controllers\Wsdadm\CatalogProductStatusController::class, 'insert'])
            ->middleware('auth')
            ->name('wsdadm.product-status.insert');

        Route::get('edit/{id}', [\Modules\System\Http\Controllers\Wsdadm\CatalogProductStatusController::class, 'edit'])
            ->middleware('auth')
            ->name('wsdadm.product-status.edit');

        Route::post('save', [\Modules\System\Http\Controllers\Wsdadm\CatalogProductStatusController::class, 'save'])
            ->middleware('auth')
            ->name('wsdadm.product-status.save');

    });

    // Define as rotas do submodulo sysmenus
    Route::prefix('carriers')->middleware('auth')->group(function () {

        Route::get('/', [\Modules\System\Http\Controllers\Wsdadm\SysCarrierController::class, 'index'])
            ->middleware('auth')
            ->name('wsdadm.carriers');

        Route::get('insert', [\Modules\System\Http\Controllers\Wsdadm\SysCarrierController::class, 'insert'])
            ->middleware('auth')
            ->name('wsdadm.carriers.insert');

        Route::get('edit/{id}', [\Modules\System\Http\Controllers\Wsdadm\SysCarrierController::class, 'edit'])
            ->middleware('auth')
            ->name('wsdadm.carriers.edit');

        Route::post('save', [\Modules\System\Http\Controllers\Wsdadm\SysCarrierController::class, 'save'])
            ->middleware('auth')
            ->name('wsdadm.carriers.save');

    });

    // Rotas para as Lojas
    Route::prefix('seo-config')->middleware('auth')->group(function () {

        Route::get('/', [\Modules\System\Http\Controllers\Wsdadm\SeoConfigController::class, 'index'])
            ->middleware('auth')
            ->name('wsdadm.seo-config');

        Route::get('edit/{id}', [\Modules\System\Http\Controllers\Wsdadm\SeoConfigController::class, 'edit'])
            ->middleware('auth')
            ->name('wsdadm.seo-config.edit');

        Route::get('insert', [\Modules\System\Http\Controllers\Wsdadm\SeoConfigController::class, 'insert'])
            ->middleware('auth')
            ->name('wsdadm.seo-config.insert');

    });

});
