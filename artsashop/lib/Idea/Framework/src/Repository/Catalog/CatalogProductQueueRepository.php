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

use App\Models\CatalogProductQueue;
use Idea\Framework\Repository\AbstractRepository;

class CatalogProductQueueRepository extends AbstractRepository
{

    protected static $model = CatalogProductQueue::class;

    public static function deleteQueue($productId)
    {
        self::loadModel()::query()->where(['product_id' => $productId])->delete();
    }

    public static function getCatalogQueue(): array
    {

        // Inicializa a query
        $query = self::loadModel()::query();

        $query->addSelect([
            'catalog_product.product_id',
            'catalog_product.sku',
            'catalog_product.name',
            'catalog_product.slug_key',
            'catalog_product.qty',
            'eav_attributes_set.attribute_set_id',
            'eav_attributes_set.attribute_set_key',
            'eav_attributes_set.attribute_set_name',
            'catalog_product_queue.product_json',
            'catalog_product_queue.created_at',
        ]);

        $query->join(
            table: 'catalog_product',
            first: 'catalog_product.product_id',
            operator: '=',
            second: 'catalog_product_queue.product_id'
        );

        $query->join(
            table:'eav_attributes_set',
            first:'eav_attributes_set.attribute_set_id',
            operator:'=',
            second:'catalog_product.attribute_set_id'
        );

        $query->orderBy('catalog_product_queue.created_at');

        $query->limit(10);

        if ($query->get())
            return $query->get()->toArray();

        return [];

    }

    /**
     * Adiciona o produto a Queue
     * @param int $productId
     * @param string $productSku
     * @param string $productJson
     * @return void
     */
    public static function saveOrUpdate(int $productId, string $productSku, string $productJson)
    {

        $queue = self::loadModel()::query()->where(
            column: 'product_id', operator: '=', value: $productId
        );

        if (!$queue->exists()) {

            self::loadModel()::query()->firstOrCreate([
                'product_id' => $productId,
                'product_sku' => $productSku,
                'product_json' => $productJson,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

        }

        self::loadModel()::query()
            ->where(['product_id' => $productId])
            ->update([
                'product_json' => $productJson,
                'created_at' => date('Y-m-d H:i:s'),
            ]);

    }

}
