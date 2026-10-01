<?php

use Illuminate\Support\Facades\Route;
use Modules\Brands\Http\Controllers\Api\CatalogBrandController;

/*
 *--------------------------------------------------------------------------
 * API Routes
 *--------------------------------------------------------------------------
 *
 * Here is where you can register API routes for your application. These
 * routes are loaded by the RouteServiceProvider within a group which
 * is assigned the "api" middleware group. Enjoy building your API!
 *
 */

Route::middleware('check.apikey')->prefix('v1')->group(function () {

    Route::prefix('brands')->group(function () {

        Route::get('/', [CatalogBrandController::class, 'index'])->name('get.brand.index');
        Route::Post('/', [CatalogBrandController::class, 'store'])->name('post.brand.index');
        Route::Put('/{key}', [CatalogBrandController::class, 'update'])->name('put.brand.index');
        Route::Delete('/', [CatalogBrandController::class, 'destroy'])->name('delete.brand.index');

    });

});
