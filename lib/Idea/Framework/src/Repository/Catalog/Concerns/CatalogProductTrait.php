<?php

namespace Idea\Framework\Repository\Catalog\Concerns;

trait CatalogProductTrait
{

    public static function catalogSimpleColums()
    {
        return [
            'catalog_product.product_id',
            'catalog_product.sku',
            'catalog_product.name',
            'catalog_product.image',
            'catalog_product.slug_key',
            'catalog_product.thumbnail',
            'catalog_product_prices.price',
            'catalog_product_prices.final_price',
        ];

    }


    public static function catalogProductColums()
    {

        return [
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
        ];

    }

}
