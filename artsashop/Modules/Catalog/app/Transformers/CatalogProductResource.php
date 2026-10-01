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

namespace Modules\Catalog\Transformers;

use Idea\Framework\Seo\Traits\HasApiSeoResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Catalog\Concerns\ProductApiAttributes;
use Modules\Catalog\Concerns\ProductApiImages;
use Modules\Catalog\Concerns\ProductApiStores;
use Modules\Catalog\Concerns\ProductApiTags;

class CatalogProductResource extends JsonResource
{

    use ProductApiImages;
    use ProductApiAttributes;
    use ProductApiTags;
    use ProductApiStores;
    use HasApiSeoResponse;

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'productId' => $this->product_id,
            'stores' => $this->getProductStores($this->product_id),
            'name' => $this->name,
            'description' => $this->description,
            'shortDescription' => $this->short_description,
            'videoUrl' => $this->video_url,
            'slug' => $this->slug_key,
            'brand' => [
                'brandName' => $this->brand_name,
                'brandKey' => $this->brand_key,
            ],
            'attributeSet' => [
                'attributeSetKey' => $this->attribute_set_key,
                'attributeSetName' => $this->attribute_set_name,
            ],
            'tags' => $this->getProductTags($this->product_id),
            'skus' => [
                "{$this->sku}" => [
                    'productSku' => $this->sku,
                    'ean' => $this->ean,
                    'productImage' => $this->image,
                    'productThumbnail' => $this->thumbnail,
                    'images' => $this->getProductImages($this->product_id),
                    'prices' => [
                        'price' => number_format($this->price, 2, '.', ''),
                        'finalPrice' => number_format($this->final_price, 2, '.', ''),
                    ],
                    'stock' => [
                        'qty' => intval($this->qty),
                        'stockStatus' => $this->status,
                    ],
                    'dimensions' => [
                        'weight' => number_format($this->weight, 2, '.'),
                        'volumeWeight' => number_format($this->volume_weight, 2, '.'),
                        'height' => number_format($this->height, 2, '.'),
                        'width' => number_format($this->width, 2, '.'),
                        'length' => number_format($this->length, 2, '.'),
                    ],
                    'attributes' => $this->getProductAttributes($this->product_id)
                ]
            ],
//            'seo' => $this->seoData(
//                entity: CatalogProductsRepository::getProductById($this->product_id)
//            ),
            'updatedAt' => $this->updated_at,
        ];

    }


}
