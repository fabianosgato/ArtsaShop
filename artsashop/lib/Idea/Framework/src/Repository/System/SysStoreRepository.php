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
declare(strict_types=1);

namespace Idea\Framework\Repository\System;

use App\Models\SysStore;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;

class SysStoreRepository extends AbstractRepository
{

    // Model da classe
    protected static $model = SysStore::class;

    /**
     * Retorna a LOJA padrao
     * @return \App\Models\SysStore
     */
    public static function getDefault(): SysStore
    {
        return self::getData()->where(
            column: 'code',
            operator:'=',
            value: 'default'
        )->first();

    }

    /**
     * Retorna as Stores configuradas no sistema
     */
    public static function getStores(): Collection
    {
        return self::getData()->get();
    }

    /**
     * Retorna as configurações de uma Store pelo host. Se não encontrado, irá retornar a loja padrão
     * @param $host
     * @return \App\Models\SysStore
     */
    public static function getStoreByHost($host): ?SysStore
    {

        // Inicializa a query
        $store = self::getData()->where(
            column: 'host',
            operator:'=',
            value: $host
        );

        // Se existir irá retornar a loja
        if ($store->exists())
            return $store->first();

        // Se nao existir irá retornar a loja padrao
        return null;

    }

    /**
     * Retorna as configurações de uma Store pelo host
     * @param $storeId
     * @return \App\Models\SysStore
     */
    public static function getStoreById($storeId): SysStore
    {
        // Inicializa a query
        return self::getData()->find($storeId);
    }

    /**
     * Retorna as configurações de uma Store pelo code
     * @param $code
     * @return \App\Models\SysStore|null
     */
    public static function getStoreByCode($code): ?SysStore
    {

        // Key do cache
        $cacheKey = 'store_host_code:' . md5($code);

        // Retorna o cache da loja especifica
        return Cache::rememberForever($cacheKey, function () use ($code) {
            // Inicializa a query
            $store = self::getData()->where(
                column: 'code',
                operator:'=',
                value: $code
            );

            // Se existir irá retornar a loja
            if ($store->exists())
                return $store->first();

            // Se nao existir irá retornar a loja padrao
            return self::getData()->where(
                column: 'code',
                operator:'=',
                value: 'default'
            )->first();

        });

    }

    /**
     * Retorna as configurações de uma Store pelo code
     * @param $codeOrder
     * @return \App\Models\SysStore|null
     */
    public static function getStoreByCodeOrder($codeOrder): ?SysStore
    {

        // Inicializa a query
        $sysStore = self::getData()->where(
            column: 'code_order',
            operator: '=',value:
            $codeOrder
        );

        if ($sysStore->exists())
            return $sysStore->first();

        else
            return self::getData()->where(
                column: 'code',
                operator: '=',
                value: 'default'
            )->first();

    }

}
