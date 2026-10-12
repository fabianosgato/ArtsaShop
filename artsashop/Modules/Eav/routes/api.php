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


Route::middleware('auth:sanctum')->prefix('v1')->group(function () {

    Route::prefix('attribute-sets')->group(function () {

        Route::get('/', [\Modules\Eav\Http\Controllers\Api\AttributeSetController::class, 'index'])
            ->name('api.v1.attributes-set.index');

        Route::Post('/', [\Modules\Eav\Http\Controllers\Api\AttributeSetController::class, 'store'])
            ->name('api.v1.attributes-set.store');

        Route::Put('/', [\Modules\Eav\Http\Controllers\Api\AttributeSetController::class, 'update'])
            ->name('api.v1.attributes-set.update');

        Route::get('/{id}', [\Modules\Eav\Http\Controllers\Api\AttributeSetController::class, 'show'])
            ->name('api.v1.attribute-set.show');

    });

});
