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
declare(strict_types=1);

namespace Idea\Framework\Repository\Catalog;

use App\Models\CatalogProductStore;
use Idea\Framework\Repository\AbstractRepository;
use Idea\Framework\Repository\System\SysStoreRepository;

class CatalogProductStoreRepository extends AbstractRepository
{

    protected static $model = CatalogProductStore::class;

    public static function deleteProductStores($productId): void
    {

        // Busca store pelo host
        $stores = SysStoreRepository::getStores();

        foreach ($stores as $store) {

            // Deleta o produto da Store
            $productStore = self::getData()
                ->where(
                    'product_id',
                    '=',
                    $productId
                )
                ->where(
                    'store_id',
                    '=',
                    $store->store_id
                );

            if ($productStore->exists()) {
                // Retorna as informações da loja
                $sysStore = SysStoreRepository::getStoreById($store->store_id);
                // Nao pode excluir um produto de uma loja padrao
                if ($sysStore->code != 'default')
                    $productStore->delete();

            }

        }

    }

    public static function saveProductToStore($storeHost, $productId)
    {

        // Busca store pelo host
        $store = SysStoreRepository::getStoreByHost($storeHost);

        if ($store) {
            $productStore = self::getData()
                ->where(
                    'product_id',
                    '=',
                    $productId
                )
                ->where(
                    'store_id',
                    '=',
                    $store->store_id
                );

            if (!$productStore->exists()) {
                self::getData()->create([
                    'store_id' => $store->store_id,
                    'product_id' => $productId
                ]);

            }

        }

    }

    /**
     * Retorna as lojas que o produto pertence
     * @param $productId
     */
    public static function getProductStores($productId)
    {

        // Inicializa a query
        $query = self::getData();

        // Join na tabela de "Stores"
        $query->join(
            table: 'sys_store',
            first: 'sys_store.store_id',
            operator: '=',
            second: 'catalog_product_store.store_id'
        );

        $query->where(
            column: 'catalog_product_store.product_id',
            operator: '=',
            value: $productId
        );

        if ($query->exists()) {
            return $query->get();
        }

        return null;

    }

}
