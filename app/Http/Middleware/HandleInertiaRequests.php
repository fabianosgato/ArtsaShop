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
namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app'; // views/app.blade.php

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return array_merge(parent::share($request), [
            'appName' => config('app.name'),
            'appUrl' => config('app.url'),
            'currentStore' => app('currentStore'),

            'route' => [
                'name' => $request->route()?->getName(),
            ],

            'auth' => [
                'customer' => $request->user('customer')?->only('customer_id', 'customer_name', 'customer_email'),
            ],

            'flash' => [
                'success' => fn() => $request->session()->get('success'),
                'error' => fn() => $request->session()->get('error'),
            ],

            'store' => [
                'code' => app('currentStore')->code,
                'layout' => app('currentStore')->layout,
            ],

            'pagarmePublicKey' => fn() => getPagarmePublicKey(),
            'csrf_token' => fn() => csrf_token(),

        ]);
    }
}
