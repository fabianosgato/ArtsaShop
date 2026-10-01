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

use Idea\Framework\Repository\Catalog\CatalogCategoryProductRepository;
use Idea\Framework\Repository\Catalog\CatalogCategoryRepository;
use Illuminate\Support\Str;

class CatalogCategoryProductService
{

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
