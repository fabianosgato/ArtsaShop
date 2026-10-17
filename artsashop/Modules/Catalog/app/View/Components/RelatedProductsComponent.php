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
namespace Modules\Catalog\View\Components;

use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Services\ServiceCache;
use Illuminate\View\Component;
use Illuminate\View\View;

class RelatedProductsComponent extends Component
{
    public array $products;

    public function __construct($attributeSetId)
    {
        // 1. Cache do pool maior
        $productsPool = app(ServiceCache::class)->remember(
            cacheKey:"related_products.pool.{$attributeSetId}",
            tags: [
                'catalog_products',
            ],
            closure: function () use ($attributeSetId) {
                $products = CatalogProductsRepository::getProductsBlock(
                    limit: 50, // pool maior
                    eavAttributeId: $attributeSetId
                );
                return $products ? $products->toArray() : [];
            }
        );

        // 2. Randomiza pegando apenas 4
        $this->products = $this->getRandomProducts($productsPool, 4);

    }

    protected function getRandomProducts(array $products, int $limit): array
    {
        if (empty($products)) {
            return [];
        }

        shuffle($products);

        return array_slice($products, 0, $limit);
    }

    public function render(): View|string
    {
        return view('catalog::frontend.components.related-products-component');
    }
}
