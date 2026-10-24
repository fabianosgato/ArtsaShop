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

Route::prefix('wsdadm')->group(function () {

    Route::prefix('cms')->group(function () {

        Route::prefix('page')->group(function () {

            Route::get('/', [\Modules\Cms\Http\Controllers\Wsdadm\PagesController::class, 'index'])
                ->middleware('auth')
                ->name('wsdadm.cms.pages');

            Route::get('edit/{id}', [\Modules\Cms\Http\Controllers\Wsdadm\PagesController::class, 'edit'])
                ->middleware('auth')
                ->name('wsdadm.cms.pages.edit');

            Route::get('insert', [\Modules\Cms\Http\Controllers\Wsdadm\PagesController::class, 'insert'])
                ->middleware('auth')
                ->name('wsdadm.cms.pages.insert');

        });

        Route::prefix('blocks')->group(function () {

            Route::get('/', [\Modules\Cms\Http\Controllers\Wsdadm\BlocksController::class, 'index'])
                ->middleware('auth')
                ->name('wsdadm.cms.blocks');

            Route::get('edit/{id}', [\Modules\Cms\Http\Controllers\Wsdadm\BlocksController::class, 'edit'])
                ->middleware('auth')
                ->name('wsdadm.cms.blocks.edit');

            Route::get('insert', [\Modules\Cms\Http\Controllers\Wsdadm\BlocksController::class, 'insert'])
                ->middleware('auth')
                ->name('wsdadm.cms.blocks.insert');

        });

        Route::prefix('banners')->group(function () {
            Route::get('/', [\Modules\Cms\Http\Controllers\Wsdadm\BannersController::class, 'index'])
                ->middleware('auth')
                ->name('wsdadm.cms.banners');
            Route::get('edit/{id}', [\Modules\Cms\Http\Controllers\Wsdadm\BannersController::class, 'edit'])
                ->middleware('auth')
                ->name('wsdadm.cms.banners.edit');
            Route::get('insert', [\Modules\Cms\Http\Controllers\Wsdadm\BannersController::class, 'insert'])
                ->middleware('auth')
                ->name('wsdadm.cms.banners.insert');
        });

        Route::prefix('faq')->group(function () {

            Route::get('/', [\Modules\Cms\Http\Controllers\Wsdadm\FaqController::class, 'index'])
                ->middleware('auth')
                ->name('wsdadm.cms.faq');
            Route::get('/edit/{id}', [\Modules\Cms\Http\Controllers\Wsdadm\FaqController::class, 'edit'])
                ->middleware('auth')
                ->name('wsdadm.cms.faq.edit');
            Route::get('/insert', [\Modules\Cms\Http\Controllers\Wsdadm\FaqController::class, 'insert'])
                ->middleware('auth')
                ->name('wsdadm.cms.faq.insert');

        });

    });
});
