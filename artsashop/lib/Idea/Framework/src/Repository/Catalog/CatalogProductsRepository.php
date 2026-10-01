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

use App\Models\CatalogProduct;
use App\Models\CatalogProductAttribute;
use App\Models\CatalogProductPrice;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CatalogProductsRepository extends AbstractRepository
{

    protected static $model = CatalogProduct::class;

    /**
     * Valida se o produto existe na base
     * @param $productSku
     * @return bool
     */
    public static function isExist($productSku): bool
    {

        return self::loadModel()::query()
            ->where(
                column: 'sku',
                operator: '=',
                value: $productSku
            )->exists();

    }

    /**
     * Retorna as informaçções base do produto
     * @param $productSku
     * @return \App\Models\CatalogProduct|null
     */
    public static function getBaseProduct($productSku): ?CatalogProduct
    {

        $catalogProduct = self::loadModel()::query()
            ->where(
                column: 'sku',
                operator: '=',
                value: $productSku
            );

        if ($catalogProduct->exists())
            return $catalogProduct->first();

        return null;

    }

    /**
     * Método usado para alterar o grupo de atributos de um produto
     * @param int $productId
     * @param int $attributeSetId
     * @return void
     */
    public static function updateAttributeSetProduct(int $productId, int $attributeSetId): void
    {
        // Altera o Grupo de atributos do produto
        self::loadModel()::query()->find($productId)
            ->update([
                'attribute_set_id' => $attributeSetId
            ]);

    }

    /**
     * Atualiza um produto na base de dados
     * @param int $id
     * @param array $attributes
     * @return \App\Models\CatalogProduct|null
     */
    public static function updateProduct(int $id, array $attributes = []): ?CatalogProduct
    {
        try {

            return self::loadModel()::query()->updateOrCreate(
                attributes: [
                    'product_id' => $id,
                    'sku' => $attributes['sku']
                ],
                values:$attributes
            );

        } catch (\Exception $e) {
            dd($e->getMessage());

        }

    }

    /**
     * Sincroniza as tags do produto
     * @param $productId
     * @param $tagName
     * @return void
     */
    public static function syncTags($productId, $tagName): void
    {

        // Salva a Tag para o produto
        CatalogProductTagRepository::saveTagToProduct(
            productId:$productId,
            tagName: $tagName
        );

    }

    /**
     * Metodo principal de retorno dos produtos
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getProducts(): Builder
    {

        // Inicializa a query do produto
        $query = self::loadModel()::query();

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

        // Join na tabela de Status de Produto
        $query->join(
            table: 'catalog_product_status',
            first: 'catalog_product_status.status_id',
            operator: '=',
            second: 'catalog_product.status_id'
        );

        // Join na tabela de Categoria Final do produto
        $query->join(
            table: 'catalog_product_category',
            first: 'catalog_product_category.product_id',
            operator: '=',
            second: 'catalog_product.product_id'
        );

        return $query;

    }

    /**
     * Retorna todos os produtos paginados. Usado no retorno da API
     * @param $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getProductsPagination($perPage): LengthAwarePaginator
    {

        // Inicializa a query
        $query = self::getProducts()
            ->orderBy(
                column: 'catalog_product.product_id',
                direction: 'desc'
            );

        // Mostra os produtos sem estoque por último nas listagens
        $query->orderByRaw(
            'CASE WHEN catalog_product.qty > 0 THEN 0 ELSE 1 END'
        );

        return $query->paginate($perPage);

    }

    /**
     * Retorna os produtos paginados filtrando por uma categoria específica
     * @param int $categoryId
     * @param int $perPage
     * @param array|null $prices
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getProductsByCategoryPagination(int $categoryId, int $perPage=32, ?array $priceRange): LengthAwarePaginator
    {

        // Inicializa a query
        $query = self::getProducts();

        // Join na tabela de catalog_category_product
        $query->join(
            table: 'catalog_category_product',
            first: 'catalog_category_product.product_id',
            operator: '=',
            second: 'catalog_product.product_id'
        );

        // Filtra pelo ID da Categoria
        $query->where(
            column: 'catalog_category_product.category_id',
            operator: '=',
            value: $categoryId
        );

        if (count($priceRange) > 0) {
            // Aplica o filtro de preço
            self::applyPriceFilter(
                $query,
                $priceRange
            );
        }

        // Mostra os produtos sem estoque por último nas listagens
        $query->orderByRaw(
            'CASE WHEN catalog_product.qty > 0 THEN 0 ELSE 1 END'
        );

        return $query->orderBy(
            column: 'catalog_product.product_id',
            direction: 'desc'
        )
        ->paginate($perPage);

    }

    /**
     * Aplica o filtro de preços
     * @param Builder $query
     * @param mixed $priceRange
     * @return void
     */
    public static function applyPriceFilter(
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

                if ($to !== null) {
                    $query->orHavingRaw(
                        "catalog_product_prices.final_price BETWEEN ? AND ?",
                        [$from, $to]
                    );

                } else {

                    $query->orHavingRaw(
                        "catalog_product_prices.final_price >= ?",
                        [$from]
                    );

                }

            }

        });

    }

    /**
     * Retorna os produtos paginados filtrando por uma marca específica
     * @param $brandId
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getProductsByBrandsPagination($brandId, int $perPage=32): LengthAwarePaginator
    {

        // Inicializa a query do produto
        $query = self::getProducts();

        // Seleciona o produto pelo ID
        $query->where(
            column: 'catalog_product.brand_id',
            operator: '=',
            value: $brandId
        );

        // Mostra os produtos sem estoque por último nas listagens
        $query->orderByRaw(
            'CASE WHEN catalog_product.qty > 0 THEN 0 ELSE 1 END'
        );

        $query->groupBy([
            'catalog_product.name',
            'catalog_product.slug_key',
        ]);

        return $query->orderBy(
            column: 'catalog_product.product_id',
            direction: 'desc'
        )->paginate($perPage);

    }

    /**
     * Retorna os produtos paginados filtrando pela busca
     * @param string $word
     * @return array
     */
    public static function searchProductsSuggestion(string $word): array
    {

        // Quebra os termos
        $terms = collect(
            preg_split('/\s+/', $word)
        )
            ->filter()
            ->values();

        // Primeiro termo = intenção principal
        $mainTerm = $terms->first();

        // Busca FULLTEXT
        // Exemplo:
        // +lareira vapor
        $search = '+' . $mainTerm;

        foreach ($terms->slice(1) as $term) {
            $search .= ' ' . $term;
        }

        // Query base
        $query = self::getProducts();

        // Apenas produtos ativos
        $query->where(
            'catalog_product.status_id',
            '=',
            1
        );

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
            $skuWeight  = $index === 0 ? 120 : 25;

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

        // Produtos com estoque primeiro
        $query->orderByRaw(
            'CASE WHEN catalog_product.qty > 0 THEN 0 ELSE 1 END'
        );

        // Ordenação final
        $query->orderByDesc('relevance_score');
        $query->orderByDesc('fulltext_score');
        $query->orderByDesc('catalog_product.product_id');

        // Limite de sugestões
        $products = $query
            ->limit(5)
            ->get();

        // Total encontrado
        $total = (clone $query)->count();

        return [
            'products' => $products->map(function ($product) {

                return [
                    'name'  => $product->name,
                    'url'   => url($product->slug_key),
                    'image' => $product->thumbnail
                ];

            }),

            'total' => $total
        ];

    }

    /**
     * Realiza a busca de produtos no site
     * @param $word
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function searchProductsPagination(
        $word,
        int $perPage = 32
    ): LengthAwarePaginator
    {

        // Remove espaços extras
        $word = trim($word);

        // Quebra os termos
        $terms = collect(
            preg_split('/\s+/', $word)
        )
            ->filter()
            ->values();

        // Primeiro termo = intenção principal
        $mainTerm = $terms->first();

        // Busca FULLTEXT
        // Exemplo:
        // +lareira vapor
        $search = '+' . $mainTerm;

        foreach ($terms->slice(1) as $term) {
            $search .= ' ' . $term;
        }

        // Query base
        $query = self::getProducts();

        // Apenas produtos ativos
        $query->where(
            'catalog_product.status_id',
            '=',
            1
        );

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
            $skuWeight  = $index === 0 ? 120 : 25;

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

        // Produtos com estoque primeiro
        $query->orderByRaw(
            'CASE WHEN catalog_product.qty > 0 THEN 0 ELSE 1 END'
        );

        // Ordenação final
        $query->orderByDesc('relevance_score');
        $query->orderByDesc('fulltext_score');
        $query->orderByDesc('catalog_product.product_id');

        return $query
            ->paginate($perPage)
            ->withQueryString();

    }

    /**
     * Retorna todos os produtos do sistema
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function allProductsPagination(int $perPage=32): LengthAwarePaginator
    {

        // Inicializa a query do produto
        $query = self::getProducts();

        // Retorna apenas os produtos com estoque
        $query->where(
            column: 'catalog_product.status_id',
            operator: '=',
            value:1
        )->where(
            column: 'catalog_product.qty',
            operator: '>',
            value:0
        );

        // Mostra os produtos sem estoque por último nas listagens
        $query->orderByRaw(
            'CASE WHEN catalog_product.qty > 0 THEN 0 ELSE 1 END'
        );

        return $query->orderBy(
            column: 'catalog_product.product_id',
            direction:  'desc'
        )->paginate($perPage);

    }

    /**
     * Retorna uma lista de produtos para blocos do site
     * @param int $limit
     * @param int $eavAttributeId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getProductsBlock(int $limit, int $eavAttributeId = 0): \Illuminate\Database\Eloquent\Collection
    {

        // Inicializa a query
        $query = self::getProducts();

        if ($eavAttributeId != 0) {
            $query->where(
                column: 'catalog_product.attribute_set_id',
                operator: '=',
                value:$eavAttributeId
            );
        }

        // Retorna apenas os produtos com estoque
        $query->where(
            column: 'catalog_product.status_id',
            operator: '=',
            value:1
        )->where(
            column: 'catalog_product.qty',
            operator: '>',
            value:0
        );

        // Ordenação por data de cadastro decrescente
        $query->orderBy(
            column: 'catalog_product.created_at',
            direction: 'DESC'
        );

        // Retorna os produtos
        return $query->limit($limit)->get();

    }

    /**
     * Retorna uma lista de produtos para blocos do site
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getNewProducts(int $limit)
    {
        $cacheKey = "catalog:products-block:v2:limit={$limit}";

        return Cache::remember($cacheKey, now()->addHour(), function () use ($limit) {

            // QUERY BASE SIMPLES (SEM getProducts)
            $baseQuery = DB::table('catalog_product')
                ->select([
                    'catalog_product.product_id',
                    'catalog_product.attribute_set_id',
                    'catalog_product.created_at'
                ])
                ->where('catalog_product.status_id', 1)
                ->where('catalog_product.qty', '>', 0);

            // ROW_NUMBER sem poluir select
            $sub = $baseQuery->selectRaw('
                ROW_NUMBER() OVER (
                    PARTITION BY catalog_product.attribute_set_id
                    ORDER BY catalog_product.created_at DESC
                ) as rn'
            );

            //
            $query = self::getProducts()
                ->joinSub($sub, 'filtered', function ($join) {
                    $join->on('catalog_product.product_id', '=', 'filtered.product_id');
                })
                ->where('filtered.rn', 1)
                ->limit($limit);

            return $query->get();

        });

    }

    /**
     * Busca um Produto do catálogo pelo Slug
     * @param string $slugKey
     * @return \App\Models\CatalogProduct|null
     */
    public static function getProductBySlug(string $slugKey): ?CatalogProduct
    {

        // Inicializa a query do produto
        $query = self::loadModel()::query();

        // Filtra pelo ID da AmazonProducts
        $query->where(
            column: 'slug_key',
            operator: '=',
            value: $slugKey
        );

        // Retorna o primeiro registro encontrado
        return $query->first();

    }

    /**
     * Retorna os dados do produto pelo ID
     * @param $productId
     * @return \App\Models\CatalogProduct|null
     */
    public static function getProductById($productId): ?CatalogProduct
    {

        // Inicializa a query do produto
        $query = self::getProducts();

        // Adiciona o nome da Categoria ao select
        $query->addSelect(
            'catalog_category_entity.category'
        );

        // Seleciona o produto pelo ID
        $query->where(
            column: 'catalog_product.product_id',
            operator: '=',
            value: $productId
        );

        // Realiza o join nas tabelas de Categorias
        $query->join(
                table:'catalog_category_product',
                first: 'catalog_category_product.product_id',
                operator: '=',
                second: 'catalog_product.product_id'
            )
            ->join(
                table:'catalog_category_entity',
                first: 'catalog_category_entity.entity_id',
                operator: '=',
                second: 'catalog_category_product.category_id'
            );

        if ($query->exists())
            return $query->first();

        return null;

    }

    /**
     * Retorna os dados do produto pelo SKU
     * @param $productSku
     * @return ?CatalogProduct
     */
    public static function getProductBySku($productSku): ?CatalogProduct
    {

        // Inicializa a query do produto
        $query = self::getData();

        // Seleciona o produto pelo ID
        $query->where(
            column: 'catalog_product.sku',
            operator: '=',
            value: $productSku
        );

        if ($query->exists()) {
            return $query->first();
        }

        return null;

    }

    /**
     * Retorna a lista de produtos para o WsdAdm
     * @return Builder
     */
    public static function getData(): Builder
    {

        // Inicializa a query do produto
        return self::getProducts();

    }

    /**
     * Retorna os produtos pelo Grupo de Atributos
     * @param $attributeSetId
     * @param int $limit
     * @return Builder
     */
    public static function getByAttributeSet($attributeSetId, int $limit = 10): Builder
    {
        // Retorna os produtos
        $query = self::getProducts();

        // Filtra pelo grupo de atributos
        $query->where(
            column: 'catalog_product.attribute_set_id',
            operator: '=',
            value: $attributeSetId
        );

        if ($limit)
            $query->limit($limit)
                ->orderBy('catalog_product.product_id', 'DESC')
                ->inRandomOrder();

        // Mostra os produtos sem estoque por último nas listagens
        $query->orderByRaw(
            'CASE WHEN catalog_product.qty > 0 THEN 0 ELSE 1 END'
        );

        // Retorna os produtos por ordem de cadastro decrescente
        return $query->orderBy(
            column: 'catalog_product.product_id',
            direction:  'desc'
        );

    }

    /**
     * Metodo responsavel por alterar o grupo de attributos de um produto
     * @param int $productId
     * @param int $attributeSetId
     * @return void
     */
    public static function updateAttributeSet(int $productId, int $attributeSetId): void
    {

        // Retorna os dados do produto
        $catalogProduct = CatalogProduct::query()
            ->where(
                column: 'product_id',
                operator: '=',
                value: $productId
            );

        // Atualiza o grupo de atributos do produto
        $catalogProduct->update([
            'attribute_set_id' => $attributeSetId
        ]);

    }

    /**
     * Metodo utilizado para atualizar as imagens de um produto
     * @param $productId
     * @param $images
     * @return void
     */
    public static function updateImageProduct($productId, $images): void
    {

        // Inicializa a query do produto
        CatalogProduct::query()
            ->where('product_id', '=', $productId)
            ->update([
                'image' => $images['image'],
                'thumbnail' => $images['thumbnail'],
            ]);

    }

    /**
     * Metodo responsavel por alterar a Marca de um produto
     * @param $productId
     * @param $brandId
     * @return void
     */
    public static function updateBrand($productId, $brandId): void
    {

        // Inicializa a query do produto
        CatalogProduct::query()
            ->where('product_id', '=', $productId)
            ->update([
                'brand_id' => $brandId
            ]);

    }

    /**
     * Metodo responsavel por alterar o status de um produto dependendo do estoque
     * @param $productId
     * @param $qty
     * @return void
     */
    public static function updateStatus($productId, $qty): void
    {

        if ($qty == 0) {
            // Inicializa a query do produto
            CatalogProduct::query()
                ->where('product_id', '=', $productId)
                ->update([
                    'status_id' => 3,
                    'qty' => $qty
                ]);

        } else {
            // Inicializa a query do produto
            CatalogProduct::query()
                ->where('product_id', '=', $productId)
                ->update([
                    'status_id' => 1,
                    'qty' => $qty
                ]);
        }

    }

    /**
     * Metodo usado para Atualizar os pesos de produtos
     * @param array $data
     * @return false|mixed
     */
    public static function updateWeights(array $data)
    {

        if (!empty($data['item_code'])) {

            // Inicializa a query do produto
            $query = CatalogProduct::query();

            # Busca o produto
            $catalogProduct = $query->where(
                'asin', '=', str_replace("LA", "", $data['item_code'])
            );

            # Valida se o produto existe na base
            if ($catalogProduct->exists()) {

                try {

                    $attributes = [
                        'weight' => floatval(str_replace(",", ".", $data['weight']))
                    ];

                    // Inicializa a query do produto
                    self::loadModel()::query()->where([
                        'product_id' => $catalogProduct->first()->product_id
                    ])->update($attributes);

                    return $catalogProduct;

                } catch (\Exception $exception) {

                    Log::error("[{$catalogProduct->asin}] {" . print_r($attributes, true) . "}}");
                    Log::error("[{$catalogProduct->asin}] {" . $exception->getMessage() . "}}");

                }

            }

        }

        return false;

    }

    /**
     * Metodo responsavel por EXCLUIR DEFINITIVAMENTE um produto da base.
     * Apenas serao excluidos produtos que estao como "NAO APROVADOS" que sao produtos nao editados ainda
     * @param $productId
     * @return void
     */
    public static function deleteProduct($productId): void
    {

        // Exclui os preços do produto
        CatalogProductPrice::query()->where('product_id', $productId)->delete();

        // Exclui a relacao dos Atributos do produto
        CatalogProductAttribute::query()->where('product_id', $productId)->delete();

        // Exclui o produto do Catalogo
        CatalogProduct::query()->where('product_id', $productId)->delete();

    }

    public static function deleteByAttributeSet(int $eavAttributeSetId): void
    {

        // Exclui os produtos pelo ID do grupo de atributo
        $catalogProducts = CatalogProduct::query()->where(
            column: 'attribute_set_id',
            operator: '=',
            value:$eavAttributeSetId
        )->get();

        foreach ($catalogProducts as $catalogProduct) {
            self::deleteProduct(
                productId: $catalogProduct->product_id
            );
        }

    }

}
