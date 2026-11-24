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
namespace Modules\Catalog\Services;

use Idea\Framework\Repository\Catalog\CatalogCategoryProductRepository;
use Idea\Framework\Repository\Catalog\CatalogCategoryRepository;
use Idea\Framework\Repository\Eav\EavAttributesCategoryRepository;
use Idea\Framework\Services\ServiceCache;
use Illuminate\Support\Str;

class CatalogCategoryProductService
{

    /**
     * retorna a árvore de Categorias para o menu
     * @return mixed
     */
    public function getMenuCategories()
    {
        return app(ServiceCache::class)->remember(
            cacheKey: 'catalog:categories:vertical-menu',
            tags: ['catalog_category'],
            closure: fn () => CatalogCategoryRepository::getMenuCategories()
        );
    }

    /**
     * Busca caminho completo pelo slug (SEM DB)
     */
    public function buildActivePathIdsFromTree(array $categories, string $slug, array $path = []): array
    {
        foreach ($categories as $category) {

            if (! $category['has_products']) {
                continue;
            }

            $newPath = [...$path, $category['entity_id']];

            if ($category['slug_key'] === $slug) {
                return $newPath;
            }

            if ($category['has_children']) {

                $found = $this->buildActivePathIdsFromTree(
                    $category['children'],
                    $slug,
                    $newPath
                );

                if ($found) {
                    return $found;
                }
            }
        }

        return [];
    }


    /**
     * Aplica estado ativo (POR REFERÊNCIA)
     */
    public function applyActiveState(array &$categories, int $activeCategoryId, array $activePathIds): void
    {
        foreach ($categories as &$category) {

            $category['is_active'] =
                $category['entity_id'] === $activeCategoryId;

            $category['is_open'] =
                in_array($category['entity_id'], $activePathIds);

            if ($category['has_children']) {
                $this->applyActiveState($category['children'], $activeCategoryId, $activePathIds);
            }
        }
    }

    public static function getCategoryByAttributeSetId($attributeSetId)
    {
        return app(ServiceCache::class)->remember(
            cacheKey: "catalog-category:category-by-attributeset:attributeSetId:{$attributeSetId}",
            tags: ['catalog_category'],
            closure: function () use ($attributeSetId) {
                return EavAttributesCategoryRepository::getCategoryByAttributeSet(
                    $attributeSetId
                );
            }
        );
    }

    public static function saveProductCategories(int $productId, string $path, string $productSlug, ?string $parentSlug = null): void
    {

        $parts = explode('>', $path, 2);
        $category = trim($parts[0]);
        $isLast = count($parts) === 1;

        // Slug atual da categoria
        $currentSlug = Str::slug($category);

        // Slug completo (hierárquico)
        $slugKey = $parentSlug
            ? $parentSlug . '/' . $currentSlug
            : $currentSlug;

        // Retorna os dados da Categoria pelo slug
        $catalogCategory = CatalogCategoryRepository::getCategoryByPath(
            categoryPath: $slugKey
        );

        if ($catalogCategory) {

            // Cria a relação do produto com a Categoria
            CatalogCategoryProductRepository::create([
                'category_id' => $catalogCategory->entity_id,
                'product_id' => $productId,
                'position' => 0
            ]);

            if (!$isLast) {
                self::saveProductCategories(
                    productId: $productId,
                    path: $parts[1],
                    productSlug: $productSlug,
                    parentSlug: $slugKey
                );

            }

        }

    }

}
