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

namespace Idea\Framework\Repository;

use App\Models\CatalogCategoryEntity;
use App\Models\CatalogProduct;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;


class SearchRepository
{

    /**
     * Método usado para retornar os exames agrupados na busca
     * @return Builder
     */
    public static function getProducts(): Builder
    {

        // Inicializa a query do produto
        $query = CatalogProduct::query();

        // Adiciona os campos ao select
        $query->addSelect([
            'catalog_product.product_id',
            'catalog_product.attribute_set_id',
            'catalog_product.brand_id',
            'catalog_product.status_id',
            'catalog_product.sku',
            'catalog_product.name',
            'catalog_product.video_url',
            'catalog_product.description',
            'catalog_product.short_description',
            'catalog_product.slug_key',
            'catalog_product.ean',
            'catalog_product.qty',
            'catalog_product.weight',
            'catalog_product.volume_weight',
            'catalog_product.height',
            'catalog_product.width',
            'catalog_product.length',
            'catalog_product.image',
            'catalog_product.thumbnail',
            'catalog_product.is_excluded',
            'catalog_product.updated_at',
            'eav_attributes_set.attribute_set_key',
            'eav_attributes_set.attribute_set_name',
            'catalog_product_category.category_name',
            'catalog_product_category.slug_key AS category_slug_key',
            'catalog_product_brands.brand_name',
            'catalog_product_brands.brand_key',
            'catalog_product_prices.price_id',
            'catalog_product_prices.price',
            'catalog_product_prices.final_price',
            'catalog_product_status.status',
            'catalog_product_status.status_key',
        ]);

        $query->join(
            table: 'eav_attributes_set',
            first: 'eav_attributes_set.attribute_set_id',
            operator: '=',
            second: 'catalog_product.attribute_set_id'
        );

        // Join na tabela de Marcas
        $query->join(
            table: 'catalog_product_brands',
            first: 'catalog_product_brands.brand_id',
            operator: '=',
            second: 'catalog_product.brand_id'
        );

        // Join na tabela de preços
        $query->join(
            table: 'catalog_product_prices',
            first: 'catalog_product_prices.product_id',
            operator: '=',
            second: 'catalog_product.product_id'
        );

        // Join na tabela de Categoria Final do produto
        $query->join(
            table: 'catalog_product_category',
            first: 'catalog_product_category.product_id',
            operator: '=',
            second: 'catalog_product.product_id'
        );

        // Status
        $query->join(
            table: 'catalog_product_status',
            first: 'catalog_product_status.status_id',
            operator: '=',
            second: 'catalog_product.status_id'
        );

        // Join nas tabelas de Categorias
        $query->join(
            table: 'eav_attributes_category',
            first: 'eav_attributes_category.eav_attribute_set_id',
            operator: '=',
            second: 'catalog_product.attribute_set_id'
        )->join(
            table: 'catalog_category_entity',
            first: 'catalog_category_entity.entity_id',
            operator: '=',
            second: 'eav_attributes_category.eav_category_products_id'
        );

        // Agrupa por produto
        $query->groupBy([
            'catalog_product.product_id',
            'catalog_product.name',
            'catalog_product.slug_key',
        ]);

        // Ordenação
        $query->orderByDesc('catalog_product.name');

        return $query;

    }

    /**
     * Filtro de Categorias
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param mixed $category
     * @return void
     */
    private static function applyCategoryFilter(
        Builder $query,
        mixed   $category
    ): void
    {

        if (blank($category)) {
            return;
        }

        // Aceita um único valor ou um array
        if (!is_array($category)) {
            $category = [$category];
        }

        // Remove valores vazios
        $category = array_filter($category);

        if (empty($category)) {
            return;
        }

        // Busca os paths das categorias selecionadas
        $paths = CatalogCategoryEntity::query()
            ->whereIn('entity_id', $category)
            ->pluck('category_path');

        // Monta a lista final de IDs
        $categoryIds = CatalogCategoryEntity::query()
            ->where(function ($query) use ($paths, $category) {

                // Inclui as categorias selecionadas
                $query->whereIn('entity_id', $category);

                // Inclui todas as categorias filhas
                foreach ($paths as $path) {
                    $query->orWhere(
                        'category_path',
                        'LIKE',
                        $path . '/%'
                    );
                }

            })
            ->pluck('entity_id')
            ->unique()
            ->values()
            ->all();

        $query->whereIn(
            'catalog_category_entity.entity_id',
            $categoryIds
        );

    }

    /**
     * Aplica o filtro de preços
     * @param Builder $query
     * @param mixed $priceRange
     * @return void
     */
    private static function applyPriceFilter(
        Builder $query,
        mixed   $priceRange
    ): void
    {
        if (blank($priceRange)) {
            return;
        }

        // Aceita um único valor ou um array
        if (!is_array($priceRange)) {
            $priceRange = [$priceRange];
        }

        // Remove valores vazios
        $priceRange = array_filter($priceRange);

        if (empty($priceRange)) {
            return;
        }

        $query->having(function ($query) use ($priceRange) {

            foreach ($priceRange as $range) {

                [$from, $to] = array_pad(
                    explode('-', $range),
                    2,
                    null
                );

                $from = is_numeric($from) ? (float)$from : 0;
                $to = is_numeric($to) ? (float)$to : null;

                $priceExpression = "
                LEAST(
                    MIN(
                        CASE
                            WHEN catalog_product_prices.final_price > 0
                            THEN catalog_product_prices.final_price
                            ELSE catalog_product_prices.price
                        END
                    ),
                    MIN(catalog_product_prices.price)
                )
            ";

                if ($to !== null) {

                    $query->orHavingRaw(
                        "{$priceExpression} BETWEEN ? AND ?",
                        [$from, $to]
                    );

                } else {

                    $query->orHavingRaw(
                        "{$priceExpression} >= ?",
                        [$from]
                    );

                }

            }

        });

    }

    /**
     * Aplica o filtro pelos atributos selecionados.
     *
     * Cada atributo recebido possui o formato:
     *
     * categoryId:attributeId
     *
     * Exemplo:
     * 26:8
     * 26:13
     *
     * @param Builder $query
     * @param mixed $selectedAttributes
     * @return void
     */
    private static function applyAttributeFilter(
        Builder $query,
        mixed   $selectedAttributes
    ): void
    {

        if (blank($selectedAttributes)) {
            return;
        }

        if (!is_array($selectedAttributes)) {
            $selectedAttributes = [$selectedAttributes];
        }

        $selectedAttributes = collect($selectedAttributes)
            ->map(function ($item) {

                $parts = explode(':', $item, 2);

                if (count($parts) !== 2) {
                    return null;
                }

                [$categoryId, $attributeId] = $parts;

                if (
                    !is_numeric($categoryId) ||
                    !is_numeric($attributeId)
                ) {
                    return null;
                }

                return [
                    'category_id' => (int)$categoryId,
                    'attribute_id' => (int)$attributeId,
                ];

            })
            ->filter()
            ->values();

        if ($selectedAttributes->isEmpty()) {
            return;
        }

        /*
         * Cada atributo selecionado precisa existir
         * no produto e estar habilitado.
         */
        foreach ($selectedAttributes as $attribute) {

            $query->whereExists(function ($subQuery) use ($attribute) {

                $subQuery
                    ->selectRaw('1')
                    ->from('catalog_product_attributes')
                    ->whereColumn(
                        'catalog_product_attributes.product_id',
                        'catalog_product.product_id'
                    )
                    ->where(
                        'catalog_product_attributes.attribute_id',
                        $attribute['attribute_id']
                    )
                    ->where(
                        'catalog_product_attributes.value',
                        '1'
                    );

            });

        }

    }

    /**
     * Realiza a busca de produtos no site
     * @param array $requestData
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function searchProductsPagination(
        array $requestData,
        int   $perPage = 32
    ): LengthAwarePaginator
    {

        // Remove espaços extras
        $word = trim($requestData['word']);

        // Inicializa o search
        $search = '';

        if ($word) {

            // Quebra os termos
            $terms = collect(
                preg_split('/\s+/', $word)
            )->filter()->values();

            // Primeiro termo = intenção principal
            $mainTerm = $terms->first();

            // Busca FULLTEXT
            $search = '+' . $mainTerm;

            foreach ($terms->slice(1) as $term) {
                $search .= ' ' . $term;
            }
        }

        // Query base da busca geral de produtos
        $query = self::getProducts();

        if ($search) {

            // FULLTEXT SEARCH
            $query->whereRaw(
                "MATCH(
            catalog_product.name,
            catalog_product.description,
            catalog_product.sku
            ) AGAINST(? IN BOOLEAN MODE)",
                [$search]
            );

            // Score de relevância customizado
            $scoreSql = [];
            $bindings = [];

            foreach ($terms as $index => $term) {

                // Primeiro termo = intenção principal
                $nameWeight = $index === 0 ? 100 : 15;
                $descWeight = $index === 0 ? 30 : 5;
                $skuWeight = $index === 0 ? 120 : 25;

                // Nome começando com termo
                $scoreSql[] = "
                CASE
                    WHEN catalog_product.name LIKE ? THEN " . ($nameWeight + 50) . "
                    ELSE 0
                END
            ";

                $bindings[] = $term . '%';

                // Nome contendo termo
                $scoreSql[] = "
                CASE
                    WHEN catalog_product.name LIKE ? THEN {$nameWeight}
                    ELSE 0
                END
            ";

                $bindings[] = '%' . $term . '%';

                // Description
                $scoreSql[] = "
                CASE
                    WHEN catalog_product.description LIKE ? THEN {$descWeight}
                    ELSE 0
                END
            ";

                $bindings[] = '%' . $term . '%';

                // SKU
                $scoreSql[] = "
            CASE
                WHEN catalog_product.sku LIKE ? THEN {$skuWeight}
                ELSE 0
            END
            ";

                $bindings[] = '%' . $term . '%';

            }

            $scoreExpression = implode(' + ', $scoreSql);

            // Score FULLTEXT do MySQL
            $query->selectRaw(
                "(
                        MATCH(
                            catalog_product.name,
                            catalog_product.description,
                            catalog_product.sku
                        ) AGAINST(? IN BOOLEAN MODE)
                 ) as fulltext_score",
                [$search]
            );

            // Score customizado
            $query->selectRaw(
                "({$scoreExpression}) as relevance_score",
                $bindings
            );

        }

        self::applyPriceFilter(
            query: $query,
            priceRange: $requestData['prices'] ?? null
        );

        // Aplica o filtro de categoria
        self::applyCategoryFilter(
            query: $query,
            category: ($requestData['category']) ?? null
        );

        // Aplica o filtro pelos atributos selecionados
//        self::applyAttributeFilter(
//            query: $query,
//            selectedAttributes: $requestData['selected_attributes'] ?? null
//        );

        // Ordenação final
        if ($search) {
            $query->orderByDesc('relevance_score');
            $query->orderByDesc('fulltext_score');
        }

        $query->orderByDesc('catalog_product.product_id');

        return $query
            ->paginate($perPage)
            ->withQueryString();

    }

}
