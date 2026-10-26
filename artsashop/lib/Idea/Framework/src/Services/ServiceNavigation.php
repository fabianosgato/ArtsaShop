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
namespace Idea\Framework\Services;

use Idea\Framework\Repository\Catalog\CatalogCategoryRepository;

class ServiceNavigation extends AbstractService
{

    public function menuCategories(): array
    {

        $categories = app(ServiceCache::class)->remember(
            cacheKey: 'catalog:categories:vertical-menu',
            tags: ['catalog_category'],
            closure: fn () => CatalogCategoryRepository::getMenuCategories(),
        );

        return collect($categories)
            ->filter(fn ($category) => $category['has_products'])
            ->map(fn ($category) => [
                'id'       => $category['entity_id'],
                'name'     => $category['category'],
                'url'      => url($category['slug_key']),
                'children' => collect($category['children'] ?? [])
                    ->map(fn ($child) => [
                        'id'   => $child['entity_id'],
                        'name' => $child['category'],
                        'url'  => url($child['slug_key']),
                    ])
                    ->values()
                    ->all(),
            ])
            ->values()
            ->all();
    }


}
