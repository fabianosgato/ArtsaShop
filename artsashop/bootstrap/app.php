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

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: [
            __DIR__ . '/../routes/wsdadm.php',
            __DIR__ . '/../routes/web.php',
        ],
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up'
    )
    ->withCommands([
        \App\Console\Commands\GenerateSitemapCommand::class,
    ])
    ->withMiddleware(function (Middleware $middleware): void {

        // Proxy / Cloudflare
        $middleware->trustProxies(
            at: '*',
        );

        // Store Resolver (APENAS WEB)
        $middleware->appendToGroup(
            'web',
            \App\Http\Middleware\IdentifyStoreByHost::class
        );

        // Remove a validação CSRF do "payments/callback" para os métodos de pagamento
        $middleware->preventRequestForgery(except: [
            'payments/callback',
            'payments/redirect',
        ]);

        // API continua protegida por API Key
        $middleware->appendToGroup(
            group:'api',
            middleware: 'check.apikey'
        );

        // Aliases existentes
        $middleware->alias([
            'check.apikey' => \App\Http\Middleware\ApiAuthMiddleware::class,
            'auth.customer' => \App\Http\Middleware\RedirectIfCustomerUnauthenticated::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );
    })->create();
