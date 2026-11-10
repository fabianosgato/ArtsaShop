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

use App\Models\CatalogCategoryProduct;
use App\Models\CatalogProduct;
use App\Models\CatalogProductAttribute;
use App\Models\CatalogProductCategory;
use App\Models\CatalogProductMedia;
use App\Models\CatalogProductPrice;
use App\Models\CatalogProductQueue;
use App\Models\CatalogProductStore;
use App\Models\CatalogProductTagsEntity;
use App\Models\SeoPage;
use App\Models\SysUrlRewrite;
use Idea\Framework\Concerns\SearchScoring;
use Idea\Framework\Repository\Catalog\Contracts\CatalogProductsRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class CatalogProductsRepository implements CatalogProductsRepositoryInterface
{
    use SearchScoring;

    protected string $model = CatalogProduct::class;

    protected function model(): Builder
    {
        return app($this->model)::query();
    }

    /**
     * Valida se o produto existe na base
     * @param $productSku
     * @return bool
     */
    public function isExist($productSku): bool
    {
        return $this->model()
            ->where('sku', '=', $productSku)
            ->exists();
    }

    /**
     * Retorna as informações do produto
     * @param $productSku
     * @return \App\Models\CatalogProduct|null
     */
    public function getBaseProduct($productSku): ?CatalogProduct
    {
        $catalogProduct = $this->model()
            ->where('sku', '=', $productSku);

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
    public function updateAttributeSetProduct(int $productId, int $attributeSetId): void
    {
        $this->model()->find($productId)
            ->update(['attribute_set_id' => $attributeSetId]);
    }

    /**
     * Atualiza um produto na base de dados
     * @param int $id
     * @param array $attributes
     * @return \App\Models\CatalogProduct|null
     * @throws \Exception
     */
    public function updateProduct(int $id, array $attributes = []): ?CatalogProduct
    {
        try {
            return $this->model()->updateOrCreate(
                ['product_id' => $id, 'sku' => $attributes['sku']],
                $attributes
            );
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Erro ao atualizar produto', [
                'product_id' => $id,
                'sku' => $attributes['sku'] ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
            throw $e;
        }
    }

    /**
     * Sincroniza as tags do produto
     * @param $productId
     * @param $tagName
     * @return void
     */
    public function syncTags($productId, $tagName): void
    {
        CatalogProductTagRepository::saveTagToProduct(
            productId: $productId,
            tagName: $tagName
        );
    }

    /**
     * Metodo principal de retorno dos produtos
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getProducts(): Builder
    {
        $query = $this->model();

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

        $query->join('eav_attributes_set', 'eav_attributes_set.attribute_set_id', '=', 'catalog_product.attribute_set_id');
        $query->join('catalog_product_brands', 'catalog_product_brands.brand_id', '=', 'catalog_product.brand_id');
        $query->join('catalog_product_prices', 'catalog_product_prices.product_id', '=', 'catalog_product.product_id');
        $query->join('catalog_product_status', 'catalog_product_status.status_id', '=', 'catalog_product.status_id');
        $query->join('catalog_product_category', 'catalog_product_category.product_id', '=', 'catalog_product.product_id');

        return $query;
    }

    /**
     * Retorna todos os produtos paginados. Usado no retorno da API
     * @param $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProductsPagination($perPage): LengthAwarePaginator
    {
        $query = $this->getProducts()
            ->orderBy('catalog_product.product_id', 'desc')
            ->orderByRaw('CASE WHEN catalog_product.qty > 0 THEN 0 ELSE 1 END');

        return $query->paginate($perPage);
    }

    /**
     * Retorna os produtos paginados filtrando por uma categoria específica
     * @param int $categoryId
     * @param int $perPage
     * @param array|null $priceRange
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getProductsByCategoryPagination(int $categoryId, ?array $priceRange = null, int $perPage = 32): LengthAwarePaginator
    {
        $query = $this->getProducts();

        $query->join('catalog_category_product', 'catalog_category_product.product_id', '=', 'catalog_product.product_id');
        $query->where('catalog_category_product.category_id', '=', $categoryId);

        if (!empty($priceRange)) {
            $this->applyPriceFilter($query, $priceRange);
        }

        $query->orderByRaw('CASE WHEN catalog_product.qty > 0 THEN 0 ELSE 1 END');
        $result = $query->orderBy('catalog_product.product_id', 'desc')->paginate($perPage);

        return $result;
    }

    /**
     * Aplica o filtro de preços
     * @param Builder $query
     * @param mixed $priceRange
     * @return void
     */
    public function applyPriceFilter(Builder $query, mixed $priceRange): void
    {
        if (blank($priceRange)) {
            return;
        }

        if (!is_array($priceRange)) {
            $priceRange = [$priceRange];
        }

        $priceRange = array_filter($priceRange);

        if (empty($priceRange)) {
            return;
        }

        $query->having(function ($query) use ($priceRange) {
            foreach ($priceRange as $range) {
                [$from, $to] = array_pad(explode('-', $range), 2, null);
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
    public function getProductsByBrandsPagination($brandId, int $perPage = 32): LengthAwarePaginator
    {
        $query = $this->getProducts();
        $query->where('catalog_product.brand_id', '=', $brandId);
        $query->orderByRaw('CASE WHEN catalog_product.qty > 0 THEN 0 ELSE 1 END');
        $query->groupBy(['catalog_product.name', 'catalog_product.slug_key']);
        return $query->orderBy('catalog_product.product_id', 'desc')->paginate($perPage);
    }

    /**
     * Retorna os produtos paginados filtrando pela busca (sugestões)
     * @param string $word
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchProductsSuggestion(string $word, int $perPage = 32): LengthAwarePaginator
    {
        $processed = $this->processSearchTerms($word);
        $terms = $processed['terms'];
        $search = $processed['search'];

        if (empty($search)) {
            return $this->model()
                ->where('catalog_product.status_id', '=', 1)
                ->orderByDesc('catalog_product.product_id')
                ->paginate($perPage);
        }

        $query = $this->getProducts();
        $query->where('catalog_product.status_id', '=', 1);
        $query->whereRaw(
            "MATCH(catalog_product.name, catalog_product.description, catalog_product.sku) AGAINST(? IN BOOLEAN MODE)",
            [$search]
        );

        $this->applyRelevanceScoring($query, $terms, $search);
        $query->orderByRaw('CASE WHEN catalog_product.qty > 0 THEN 0 ELSE 1 END');
        $query->orderByDesc('relevance_score');
        $query->orderByDesc('fulltext_score');
        $query->orderByDesc('catalog_product.product_id');

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Realiza a busca de produtos no site
     * @param string $word
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function searchProductsPagination(string $word, int $perPage = 32): LengthAwarePaginator
    {
        $processed = $this->processSearchTerms($word);
        $terms = $processed['terms'];
        $search = $processed['search'];

        if (empty($search)) {
            return $this->model()
                ->where('catalog_product.status_id', '=', 1)
                ->orderByDesc('catalog_product.product_id')
                ->paginate($perPage);
        }

        $query = $this->getProducts();
        $query->where('catalog_product.status_id', '=', 1);
        $query->whereRaw(
            "MATCH(catalog_product.name, catalog_product.description, catalog_product.sku) AGAINST(? IN BOOLEAN MODE)",
            [$search]
        );

        $this->applyRelevanceScoring($query, $terms, $search);
        $query->orderByRaw('CASE WHEN catalog_product.qty > 0 THEN 0 ELSE 1 END');
        $query->orderByDesc('relevance_score');
        $query->orderByDesc('fulltext_score');
        $query->orderByDesc('catalog_product.product_id');

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Retorna todos os produtos do sistema
     * @param int $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function allProductsPagination(int $perPage = 32): LengthAwarePaginator
    {
        $query = $this->getProducts();
        $query->where('catalog_product.status_id', '=', 1)
            ->where('catalog_product.qty', '>', 0)
            ->orderByRaw('CASE WHEN catalog_product.qty > 0 THEN 0 ELSE 1 END')
            ->orderBy('catalog_product.product_id', 'desc');

        return $query->paginate($perPage);
    }

    /**
     * Retorna uma lista de produtos para blocos do site
     * @param int $limit
     * @param int $eavAttributeId
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getProductsBlock(int $limit, int $eavAttributeId = 0): Collection
    {
        $query = $this->getProducts();

        if ($eavAttributeId != 0) {
            $query->where('catalog_product.attribute_set_id', '=', $eavAttributeId);
        }

        $query->where('catalog_product.status_id', '=', 1)
            ->where('catalog_product.qty', '>', 0)
            ->orderBy('catalog_product.created_at', 'DESC');

        return $query->limit($limit)->get();
    }

    /**
     * Retorna uma lista de produtos para blocos do site
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getNewProducts(int $limit): Collection
    {
        $baseQuery = DB::table('catalog_product')
            ->select([
                'catalog_product.product_id',
                'catalog_product.attribute_set_id',
                'catalog_product.created_at'
            ])
            ->where('catalog_product.status_id', '=', 1)
            ->where('catalog_product.qty', '>', 0);

        $sub = $baseQuery->selectRaw('
            ROW_NUMBER() OVER (
                PARTITION BY catalog_product.attribute_set_id
                ORDER BY catalog_product.created_at DESC
            ) as rn'
        );

        $query = $this->getProducts()
            ->joinSub($sub, 'filtered', function ($join) {
                $join->on('catalog_product.product_id', '=', 'filtered.product_id');
            })
            ->where('filtered.rn', '=', 1)
            ->limit($limit);

        return $query->get();
    }

    /**
     * Busca um Produto do catálogo pelo Slug
     * @param string $slugKey
     * @return \App\Models\CatalogProduct|null
     */
    public function getProductBySlug(string $slugKey): ?CatalogProduct
    {
        return $this->model()
            ->where('slug_key', '=', $slugKey)
            ->first();
    }

    /**
     * Retorna os dados do produto pelo ID
     * @param $productId
     * @return \App\Models\CatalogProduct|null
     */
    public function getProductById($productId): ?CatalogProduct
    {
        $query = $this->getProducts();
        $query->addSelect('catalog_category_entity.category');
        $query->where('catalog_product.product_id', '=', $productId);
        $query->join('catalog_category_product', 'catalog_category_product.product_id', '=', 'catalog_product.product_id')
            ->join('catalog_category_entity', 'catalog_category_entity.entity_id', '=', 'catalog_category_product.category_id');

        if ($query->exists()) {
            return $query->first();
        }
        return null;
    }

    /**
     * Retorna os dados do produto pelo SKU
     * @param $productSku
     * @return ?CatalogProduct
     */
    public function getProductBySku($productSku): ?CatalogProduct
    {
        $query = $this->getData();
        $query->where('catalog_product.sku', '=', $productSku);

        if ($query->exists()) {
            return $query->first();
        }
        return null;
    }

    /**
     * Retorna a lista de produtos para o WsdAdm
     * @return Builder
     */
    public function getData(): Builder
    {
        return $this->getProducts();
    }

    /**
     * Retorna os produtos pelo Grupo de Atributos
     * @param int $attributeSetId
     * @param int $limit
     * @return Builder
     */
    public function getByAttributeSet(int $attributeSetId, int $limit = 10): Builder
    {
        $query = $this->getProducts();
        $query->where('catalog_product.attribute_set_id', '=', $attributeSetId);
        $query->orderByRaw('CASE WHEN catalog_product.qty > 0 THEN 0 ELSE 1 END');
        $query->orderBy('catalog_product.product_id', 'DESC');

        if ($limit) {
            $query->limit($limit);
        }
        return $query;
    }

    /**
     * Metodo responsavel por alterar o grupo de attributos de um produto
     * @param int $productId
     * @param int $attributeSetId
     * @return void
     */
    public function updateAttributeSet(int $productId, int $attributeSetId): void
    {
        CatalogProduct::query()
            ->where('product_id', '=', $productId)
            ->update(['attribute_set_id' => $attributeSetId]);
    }

    /**
     * Metodo utilizado para atualizar as imagens de um produto
     * @param $productId
     * @param $images
     * @return void
     */
    public function updateImageProduct($productId, $images): void
    {
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
    public function updateProductBrand(int $productId, int $brandId): void
    {
        CatalogProduct::query()
            ->where('product_id', '=', $productId)
            ->update(['brand_id' => $brandId]);
    }

    /**
     * Metodo responsavel por Excluir o Produto do Sistema.
     * @param int $productId
     * @return void
     * @throws \Throwable
     */
    public function deleteProduct(int $productId): void
    {
        DB::beginTransaction();
        try {
            SysUrlRewrite::query()
                ->where('target_type', '=', 'product')
                ->where('target_path', '=', 'product/' . $productId)
                ->delete();

            CatalogProductMedia::query()->where('product_id', '=', $productId)->delete();
            CatalogProductStore::query()->where('product_id', '=', $productId)->delete();
            CatalogProductTagsEntity::query()->where('product_id', '=', $productId)->delete();
            CatalogProductQueue::query()->where('product_id', '=', $productId)->delete();
            CatalogCategoryProduct::query()->where('product_id', '=', $productId)->delete();
            CatalogProductCategory::query()->where('product_id', '=', $productId)->delete();
            CatalogProductPrice::query()->where('product_id', '=', $productId)->delete();
            CatalogProductAttribute::query()->where('product_id', '=', $productId)->delete();

            SeoPage::query()
                ->where('object', '=', 'product')
                ->where('object_id', '=', (string) $productId)
                ->delete();

            CatalogProduct::query()->where('product_id', '=', $productId)->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function deleteByAttributeSet(int $eavAttributeSetId): void
    {
        $catalogProducts = CatalogProduct::query()
            ->where('attribute_set_id', '=', $eavAttributeSetId)
            ->get();

        foreach ($catalogProducts as $catalogProduct) {
            $this->deleteProduct($catalogProduct->product_id);
        }
    }
}
