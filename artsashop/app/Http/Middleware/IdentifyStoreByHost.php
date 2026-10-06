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
use Idea\Framework\Repository\System\SysStoreRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Método responsavel por detectar a loja de acordo com o host
 */
class IdentifyStoreByHost
{
    public function handle(Request $request, Closure $next): Response
    {

        // Retorna o host
        $host = $request->getHost();

        // Busca store pelo host
        $store = SysStoreRepository::getDefault();

        // Disponibiliza globalmente
        app()->instance('currentStore', $store);
        view()->share('currentStore', $store);

        return $next($request);

    }

}
