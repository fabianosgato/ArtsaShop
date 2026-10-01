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
 * Realiza as autenticações das APIs
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
