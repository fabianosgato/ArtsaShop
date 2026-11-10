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

namespace Idea\Framework\Repository\Catalog\Contracts;

use App\Models\CatalogProduct;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

interface CatalogProductsRepositoryInterface
{
    public function isExist($productSku): bool;
    public function getBaseProduct($productSku): ?CatalogProduct;
    public function updateAttributeSetProduct(int $productId, int $attributeSetId): void;
    public function updateProduct(int $id, array $attributes = []): ?CatalogProduct;
    public function syncTags($productId, $tagName): void;
    public function getProducts(): Builder;
    public function getProductsPagination($perPage): LengthAwarePaginator;
    public function getProductsByCategoryPagination(int $categoryId, ?array $priceRange = null, int $perPage = 32): LengthAwarePaginator;
    public function applyPriceFilter(Builder $query, mixed $priceRange): void;
    public function getProductsByBrandsPagination($brandId, int $perPage = 32): LengthAwarePaginator;
    public function searchProductsSuggestion(string $word, int $perPage = 32): LengthAwarePaginator;
    public function searchProductsPagination(string $word, int $perPage = 32): LengthAwarePaginator;
    public function allProductsPagination(int $perPage = 32): LengthAwarePaginator;
    public function getProductsBlock(int $limit, int $eavAttributeId = 0): Collection;
    public function getNewProducts(int $limit): Collection;
    public function getProductBySlug(string $slugKey): ?CatalogProduct;
    public function getProductById($productId): ?CatalogProduct;
    public function getProductBySku($productSku): ?CatalogProduct;
    public function getData(): Builder;
    public function getByAttributeSet(int $attributeSetId, int $limit = 10): Builder;
    public function updateAttributeSet(int $productId, int $attributeSetId): void;
    public function updateImageProduct($productId, $images): void;
    public function updateProductBrand(int $productId, int $brandId): void;
    public function deleteProduct(int $productId): void;
    public function deleteByAttributeSet(int $eavAttributeSetId): void;
}
