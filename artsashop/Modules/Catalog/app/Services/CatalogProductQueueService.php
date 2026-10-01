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
namespace Modules\Catalog\Services;

use Idea\Framework\Repository\Catalog\CatalogProductCategoryRepository;
use Idea\Framework\Repository\Catalog\CatalogProductQueueRepository;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Repository\Eav\EavAttributesCategoryRepository;

class CatalogProductQueueService
{

    /**
     *
     * php artisan module:make-job ProcessCatalogProductQueue Catalog
     *
     * Adiciona o produto a queue
     * @param int $productId
     * @param string $productSku
     * @param string $productJson
     * @return void
     */
    public static function addToQueue(int $productId, string $productSku, string $productJson): void
    {
        // Adiciona o produto a fila de edicao
        CatalogProductQueueRepository::saveOrUpdate(
            productId: $productId,
            productSku: $productSku,
            productJson: $productJson,
        );
    }

    /**
     * Realiza o processamento de queues
     * @return void
     * @throws \Exception
     */
    public static function processQueue()
    {

        // Retorna os produtos que estao na Queue
        $productQueues = CatalogProductQueueRepository::getCatalogQueue();

        // Lista os produtos da Queue
        foreach ($productQueues as $productQueue) {

            // Retorna as informações do produto
            $catalogProduct = CatalogProductsRepository::getProductById(
                productId: $productQueue['product_id']
            );

            // Retorna a ultima categoria do produto
            $eavAttributesCategory = EavAttributesCategoryRepository::getCategoryByAttributeSetId(
                attributeSetId: $catalogProduct->attribute_set_id
            );

            // Valida se o produto possui
            if ($eavAttributesCategory) {

                // Salva a ultima categoria do produto
                $catalogProductCategory = CatalogProductCategoryRepository::saveOrUpdate(
                    catalogProduct: $catalogProduct,
                    attributes: [
                        'category_name' => $eavAttributesCategory->category,
                        'slug_key' => $eavAttributesCategory->slug_key
                    ]
                );

                // Cria uma Tag para o produto baseado na última categoria
                $tags[] = $catalogProductCategory->category_name;

            }

            // Vincula as Tags de Produtos
            foreach ($tags ?? [] as $tag) {
                CatalogProductsRepository::syncTags($catalogProduct->product_id, $tag);
            }

            // Cria as categorias de produtos
            CatalogCategoryProductService::saveProductCategories(
                productId: $productQueue['product_id'],
                path: $productQueue['attribute_set_name'],
                productSlug: $productQueue['slug_key']
            );

            // Deleta o produto da Queue
            CatalogProductQueueRepository::deleteQueue($productQueue['product_id']);

        }

    }

}
