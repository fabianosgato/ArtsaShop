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
