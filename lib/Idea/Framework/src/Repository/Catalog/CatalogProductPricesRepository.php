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

namespace Idea\Framework\Repository\Catalog;

use App\Models\CatalogProductPrice;
use Idea\Framework\Repository\AbstractRepository;
use Modules\CatalogSearch\DTO\PriceRangeDTO;

class CatalogProductPricesRepository extends AbstractRepository
{

    protected static $model = CatalogProductPrice::class;

    /**
     * Retorna os preços de um produto
     * @param int $productId
     * @return array
     */
    public static function getPrices(int $productId): array
    {

        $query = CatalogProductPrice::query();

        $query->where(
            column: 'product_id',
            operator: '=',
            value: $productId
        );

        if ($query->exists())
            return $query->first()->toArray();

        return [];

    }

    /**
     * Atualiza os preços de um Marketplace
     * @param int $productId
     * @param array $attributes
     * @return bool
     */
    public static function updatePrices(int $productId, array $attributes)
    {

        try {

            // Retorna a query de produtos
            $catalogProductPrices = self::loadModel()::query()
                ->where(
                    column: 'product_id',
                    operator: '=',
                    value:$productId
                );

            // Seleciona o produto
            if ($catalogProductPrices->exists()) {
                // Atualiza os dados
                self::loadModel()::query()->find($catalogProductPrices->first()->price_id)->update($attributes);

            } else {
                // Cria os preços do produto
                self::loadModel()::query()->create($attributes);

            }

            return true;

        } catch (\Exception $e) {
            return false;

        }

    }

    /**
     * Retorna as camadas de preços dos produtos para busca lateral
     * @return \Modules\CatalogSearch\DTO\PriceRangeDTO
     */
    public static function getPriceRange(?int $categoryId): PriceRangeDTO
    {

        $result = self::loadModel()::query()
            ->selectRaw("
                MIN(
                    CASE
                        WHEN final_price IS NOT NULL
                        AND final_price > 0
                        THEN final_price
                        ELSE price
                    END
                ) as min_price
            ")
            ->selectRaw("
                MAX(
                    CASE
                        WHEN final_price IS NOT NULL
                        AND final_price > 0
                        THEN final_price
                        ELSE price
                    END
                ) as max_price
            ");

        $result->join(
            table: 'catalog_category_product',
            first: 'catalog_category_product.product_id',
            operator:'=',
            second:'catalog_product_prices.product_id'
        );

        if ($categoryId)
            $result->where(
                column: 'catalog_category_product.category_id',
                operator: '=',
                value:$categoryId
            );

        return new PriceRangeDTO(
            minPrice: (float) $result->first()->min_price,
            maxPrice: (float) $result->first()->max_price,
        );
    }

}
