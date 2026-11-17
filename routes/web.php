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

// Rota da página inicial
Route::get('/', [\App\Http\Controllers\Frontend\IndexController::class, 'index'])
    ->name('index.home');

// Rota Fale Conosco
Route::get('fale-conosco', [\App\Http\Controllers\Frontend\ContactsController::class, 'index'])
    ->name('contacts.index');

// Post Fale Conosco
Route::post('fale-conosco/send', [\App\Http\Controllers\Frontend\ContactsController::class, 'sendPost'])
    ->name('contacts.sendPost');

// Rota para o sitemap_index.xml
Route::get('/sitemap_index.xml', function () {
    return redirect('/sitemap/sitemap.xml', 301);
});

// Rota para as páginas com SEO/UrlRewrite (Produtos, Categorias, Cms, Marcas)
Route::fallback([\App\Http\Controllers\Frontend\UrlRewriteController::class, 'resolve'])
    ->middleware('web');

// Rotas para definir o location do cliente
Route::prefix('location')->group(function () {

    // Action que busca o CEP
    Route::get('zipcode/{cep}', [\App\Http\Controllers\Backend\LocationController::class, 'lookup'])
        ->where('cep', '[0-9]{8}')
        ->name('location.cep.lookup');

    Route::post('save', [\App\Http\Controllers\Backend\LocationController::class, 'save'])
        ->name('location.save');

});
