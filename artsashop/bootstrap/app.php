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
 **************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 */

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

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
        \App\Console\Commands\CommandIndexerProducts::class,
    ])
    ->withMiddleware(function (Middleware $middleware): void {

        // Redireciona para o login, usuários não autenticados
        $middleware->redirectGuestsTo(
            fn (Request $request) => route('wsdadmin.login')
        );

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

        // Aliases existentes
        $middleware->alias([
            'auth.customer' => \App\Http\Middleware\RedirectIfCustomerUnauthenticated::class,
        ]);

    })
    ->withExceptions(function (Exceptions $exceptions): void {

        // APIs continuam retornando erros em JSON
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*'),
        );

        // Tratamento visual das exceções do frontend
        $exceptions->render(function (Throwable $exception, Request $request) {

            // Não interfere no tratamento das APIs
            if ($request->is('api/*')) {
                return null;
            }

            $status = $exception instanceof HttpExceptionInterface
                ? $exception->getStatusCode()
                : 500;

            return response()->view(
                'errors.404',
                [
                    'exception' => $exception,
                    'status' => $status,
                ],
                $status
            );
        });

    })
    ->create();
