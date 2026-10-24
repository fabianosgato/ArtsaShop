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
use Idea\Framework\Repository\System\SysStoreRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Método responsavel por validar a loja de acordo com o host
 */
class IdentifyStoreByHost
{
    public function handle(Request $request, Closure $next): Response
    {

        // Busca store pelo host
        $store = SysStoreRepository::getDefault();

        // Disponibiliza globalmente
        app()->instance('currentStore', $store);
        view()->share('currentStore', $store);

        return $next($request);

    }

}
