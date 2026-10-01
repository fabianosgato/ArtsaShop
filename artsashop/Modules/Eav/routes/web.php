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
 */

use Illuminate\Support\Facades\Route;

Route::prefix('wsdadm')->middleware('auth')->group(function () {

    Route::prefix('eav')->middleware('auth')->group(function () {

        Route::prefix('attributeset')->middleware('auth')->group(function () {

            Route::get('/', [\Modules\Eav\Http\Controllers\AttributeSetController::class, 'index'])
                ->name('wsdadm.eav.attributeset');

            Route::get('/ajax', [\Modules\Eav\Http\Controllers\AttributeSetController::class, 'ajax'])
                ->name('wsdadm.eav.attributeset.ajax');

            Route::get('insert', [\Modules\Eav\Http\Controllers\AttributeSetController::class, 'insert'])
                ->name('wsdadm.eav.attributeset.insert');

            Route::get('edit/{id}', [\Modules\Eav\Http\Controllers\AttributeSetController::class, 'edit'])
                ->name('wsdadm.eav.attributeset.edit');

            Route::get('delete/{id}', [\Modules\Eav\Http\Controllers\AttributeSetController::class, 'delete'])
                ->name('wsdadm.eav.attributeset.delete');

            Route::get('attributes/{id}', [\Modules\Eav\Http\Controllers\AttributeSetController::class, 'attributes'])
                ->name('wsdadm.eav.attributeset.attributes');

            Route::post('save', [\Modules\Eav\Http\Controllers\AttributeSetController::class, 'save'])
                ->name('wsdadm.eav.attributeset.save');

        });

        Route::prefix('attributes')->middleware('auth')->group(function () {

            Route::get('/{attributeSetId}', [\Modules\Eav\Http\Controllers\Wsdadm\EavAttributesController::class, 'index'])
                ->name('wsdadm.eav.attribute');

            Route::get('insert/{attributeSetId}', [\Modules\Eav\Http\Controllers\Wsdadm\EavAttributesController::class, 'insert'])
                ->name('wsdadm.eav.attribute.insert');

            Route::get('edit/{attributeSetId}/{id}', [\Modules\Eav\Http\Controllers\Wsdadm\EavAttributesController::class, 'edit'])
                ->name('wsdadm.eav.attribute.edit');

            Route::get('delete/{attributeSetId}/{id}', [\Modules\Eav\Http\Controllers\Wsdadm\EavAttributesController::class, 'delete'])
                ->name('wsdadm.eav.attribute.delete');

        });

    });

});

