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


class ApiAuthMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        // Lê o cabeçalho personalizado
        $userHeader   = $request->header('x-api-user');
        $apiKeyHeader = $request->header('x-api-key');

        // Compara com valores definidos no .env
        if ($userHeader !== 'systemdefaultapi' || $apiKeyHeader !== 'mid-nwi5ZCyBqGbsd85hjh2dTgkWyIDgDtT3BlfbkFJs3qRqssA1fJqp8sadcs07r8srdrasd') {
            // Retorna 401 se não corresponder
            return response()->json(['message' => 'Unauthenticated user'], 401);
        }

        // Continua a requisição caso a autenticação seja bem-sucedida
        return $next($request);

    }

}
