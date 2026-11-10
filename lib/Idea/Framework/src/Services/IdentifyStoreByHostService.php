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

namespace Idea\Framework\Services;

use App\Models\SysStore;
use Idea\Framework\Repository\System\SysStoreRepository;
use Illuminate\Http\Request;

class IdentifyStoreByHostService extends AbstractService
{

    /**
     * Verifica se existe a loja configurada no banco de dados
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\SysStore
     */
    public function identifyStore(Request $request): SysStore
    {

        // Valida se a app está em producao
        if (config('app.env') === 'production') {

            // Busca store pelo host
            $store =  app(ServiceCache::class)->remember(
                cacheKey:"config_store_cache.pool.{$request->getHost()}",
                tags: [
                    'store_host'
                ],
                closure: function () use ($request) {
                    return SysStoreRepository::getStoreByHost(
                        host: $request->getHost()
                    );
                }

            );

            // Valida se a loja foi encontrada
            if (!$store) {

                // Retorna as informaçoes da loja padrão
                $store =  app(ServiceCache::class)->remember(
                    cacheKey:"config_store_cache.pool.default",
                    tags: [
                        'store_host'
                    ],
                    closure: function () use ($request) {
                        return SysStoreRepository::getDefault();
                    }

                );

                // Valida se o host nao está vazio
                if (!empty($store->host)) {
                    return $store;
                }

            }

        } else {

            // Quando nao é homologação/local deve retornar as informaçoes da loja padrão
            $store =  app(ServiceCache::class)->remember(
                cacheKey:"config_store_cache.pool.default",
                tags: [
                    'store_host'
                ],
                closure: function () use ($request) {
                    return SysStoreRepository::getDefault();
                }
            );

        }

        return $store;

    }

}
