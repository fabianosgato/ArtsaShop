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
use Modules\CatalogSearch\Http\Controllers\CatalogSearchController;

// Rota para a busca
Route::prefix('catalogsearch')->group(function () {

    // Rota para busca completa do site
    Route::get('result', [CatalogSearchController::class, 'result'])
        ->name('catalogsearch.result');

    // Rota para sugestões de busca
    Route::get('suggestions', [CatalogSearchController::class, 'suggestions'])
        ->name('catalogsearch.suggestions');

});
