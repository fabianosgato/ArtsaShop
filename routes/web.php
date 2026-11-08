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

Route::get('/sitemap_index.xml', function () {
    return redirect('/sitemap/sitemap.xml', 301);
});

// Rota da página inicial
Route::get('/', [\App\Http\Controllers\Frontend\IndexController::class, 'index'])
    ->name('index.home');
//    ->withoutMiddleware([
//        \Illuminate\Session\Middleware\StartSession::class,
//        \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class
//    ]);

// Rota Fale Conosco
Route::get('fale-conosco', [\App\Http\Controllers\Frontend\ContactsController::class, 'index'])
    ->name('contacts.index');

// Rota Fale Conosco
Route::post('fale-conosco/send', [\App\Http\Controllers\Frontend\ContactsController::class, 'sendPost'])
    ->name('contacts.sendPost');

// Rota para as páginas com SEO/UrlRewrite (Produtos, Categorias, Cms, Marcas)
Route::fallback([\App\Http\Controllers\Frontend\UrlRewriteController::class, 'resolve'])
    ->middleware('web');
