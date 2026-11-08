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

use Closure;
use Illuminate\Http\Request;
use Modules\Customers\Services\CustomerAuthService;

class RedirectIfCustomerUnauthenticated
{
    public function handle(Request $request, Closure $next)
    {

        $customer = app(CustomerAuthService::class)->user();

        if (!$customer)
            return response()->redirectTo(route('account.login'));

        // Continua a requisição caso a autenticação seja bem-sucedida
        return $next($request);

    }

}
