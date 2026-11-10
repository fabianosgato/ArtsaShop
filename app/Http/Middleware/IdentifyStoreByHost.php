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

namespace App\Http\Middleware;

use Closure;
use Idea\Framework\Services\IdentifyStoreByHostService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Método responsavel por validar a loja de acordo com o host
 */
class IdentifyStoreByHost
{
    public function handle(Request $request, Closure $next): Response
    {

        // Retorna as informações da loja
        $store = app(IdentifyStoreByHostService::class)->identifyStore(
            $request
        );

        // Valida se a loja possui host cadastrado
        if (empty($store->host)) {

            // Mantém URI + query string
            $uri = $request->getRequestUri();

            // URL final
            $redirectUrl = env('APP_URL') . $uri;

            // Redirect 301 permanente pela URL cadastrada no sistema
            return redirect()->to($redirectUrl, 301);

        }

        // Disponibiliza globalmente
        app()->instance('currentStore', $store);
        view()->share('currentStore', $store);

        return $next($request);

    }

}
