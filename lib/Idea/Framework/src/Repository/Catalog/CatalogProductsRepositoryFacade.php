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

use App\Models\CatalogProduct;
use Idea\Framework\Repository\Catalog\Contracts\CatalogProductsRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Facade estático para compatibilidade com código existente.
 * Delega para a instância resolvida via container (CatalogProductsRepositoryInterface).
 */
class CatalogProductsRepositoryFacade
{
    private static function instance(): CatalogProductsRepositoryInterface
    {
        return app(CatalogProductsRepositoryInterface::class);
    }

    public static function isExist($productSku): bool
    {
        return self::instance()->isExist($productSku);
    }

    public static function getBaseProduct($productSku): ?CatalogProduct
    {
        return self::instance()->getBaseProduct($productSku);
    }

    public static function updateAttributeSetProduct(int $productId, int $attributeSetId): void
    {
        self::instance()->updateAttributeSetProduct($productId, $attributeSetId);
    }

    public static function updateProduct(int $id, array $attributes = []): ?CatalogProduct
    {
        return self::instance()->updateProduct($id, $attributes);
    }

    public static function syncTags($productId, $tagName): void
    {
        self::instance()->syncTags($productId, $tagName);
    }

    public static function getProducts(): \Illuminate\Database\Eloquent\Builder
    {
        return self::instance()->getProducts();
    }

    public static function getProductsPagination($perPage): LengthAwarePaginator
    {
        return self::instance()->getProductsPagination($perPage);
    }

    public static function getProductsByCategoryPagination(int $categoryId, ?array $priceRange = null, int $perPage = 32): LengthAwarePaginator
    {
        return self::instance()->getProductsByCategoryPagination($categoryId, $priceRange, $perPage);
    }

    public static function applyPriceFilter(\Illuminate\Database\Eloquent\Builder $query, mixed $priceRange): void
    {
        self::instance()->applyPriceFilter($query, $priceRange);
    }

    public static function getProductsByBrandsPagination($brandId, int $perPage = 32): LengthAwarePaginator
    {
        return self::instance()->getProductsByBrandsPagination($brandId, $perPage);
    }

    public static function searchProductsSuggestion(string $word, int $perPage = 32): LengthAwarePaginator
    {
        return self::instance()->searchProductsSuggestion($word, $perPage);
    }

    public static function searchProductsPagination(string $word, int $perPage = 32): LengthAwarePaginator
    {
        return self::instance()->searchProductsPagination($word, $perPage);
    }

    public static function allProductsPagination(int $perPage = 32): LengthAwarePaginator
    {
        return self::instance()->allProductsPagination($perPage);
    }

    public static function getProductsBlock(int $limit, int $eavAttributeId = 0): \Illuminate\Database\Eloquent\Collection
    {
        return self::instance()->getProductsBlock($limit, $eavAttributeId);
    }

    public static function getNewProducts(int $limit): \Illuminate\Database\Eloquent\Collection
    {
        return self::instance()->getNewProducts($limit);
    }

    public static function getProductBySlug(string $slugKey): ?CatalogProduct
    {
        return self::instance()->getProductBySlug($slugKey);
    }

    public static function getProductById($productId): ?CatalogProduct
    {
        return self::instance()->getProductById($productId);
    }

    public static function getProductBySku($productSku): ?CatalogProduct
    {
        return self::instance()->getProductBySku($productSku);
    }

    public static function getData(): \Illuminate\Database\Eloquent\Builder
    {
        return self::instance()->getData();
    }

    public static function getByAttributeSet(int $attributeSetId, int $limit = 10): \Illuminate\Database\Eloquent\Builder
    {
        return self::instance()->getByAttributeSet($attributeSetId, $limit);
    }

    public static function updateAttributeSet(int $productId, int $attributeSetId): void
    {
        self::instance()->updateAttributeSet($productId, $attributeSetId);
    }

    public static function updateImageProduct($productId, $images): void
    {
        self::instance()->updateImageProduct($productId, $images);
    }

    public static function updateProductBrand(int $productId, int $brandId): void
    {
        self::instance()->updateProductBrand($productId, $brandId);
    }

    public static function deleteProduct(int $productId): void
    {
        self::instance()->deleteProduct($productId);
    }

    public static function deleteByAttributeSet(int $eavAttributeSetId): void
    {
        self::instance()->deleteByAttributeSet($eavAttributeSetId);
    }
}
