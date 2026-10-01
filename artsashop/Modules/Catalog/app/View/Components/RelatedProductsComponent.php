<?php

namespace Modules\Catalog\View\Components;

use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\Component;
use Illuminate\View\View;

class RelatedProductsComponent extends Component
{
    public array $products;

    public function __construct($attributeSetId)
    {
        $cacheKey = "related_products.pool.{$attributeSetId}";

        // 1. Cache do pool maior
        $productsPool = Cache::remember(
            $cacheKey,
            now()->addMinutes(30),
            function () use ($attributeSetId) {

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
