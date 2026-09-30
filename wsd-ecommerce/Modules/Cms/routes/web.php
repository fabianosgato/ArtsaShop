<?php

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

        });

    });
});
