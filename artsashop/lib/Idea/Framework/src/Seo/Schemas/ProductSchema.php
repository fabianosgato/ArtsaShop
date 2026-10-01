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
namespace Idea\Framework\Seo\Schemas;

use Idea\Framework\Seo\Data\SeoPageData;

class ProductSchema extends AbstractSchema
{
    public function __construct(
        protected SeoPageData $data
    ) {}

    public function toArray(): array
    {

        $schema = [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $this->data->productName ?? $this->data->title,
            'description' => $this->data->description ?? $this->data->productDescription,
            'image' => [
                $this->data->productImage ?? asset('images/frontend/logo.webp')
            ],
            'sku' => $this->data->productSku,
            'brand' => [
                '@type' => 'Brand',
                'name' => $this->data->brand ?? config('app.name'),
            ],
            'offers' => [
                '@type' => 'Offer',
                'url' => $this->data->canonicalUrl,
                'priceCurrency' => $this->data->currency ?? 'BRL',
                'price' => $this->data->price,
                'availability' => $this->data->inStock
                    ? 'https://schema.org/InStock'
                    : 'https://schema.org/OutOfStock',
                'seller' => [
                    '@type' => 'Organization',
                    'name' => $this->data->ogSiteName ?? config('app.name'),
                ],
                'shippingDetails' => [
                    '@type' => 'OfferShippingDetails',

                    'shippingRate' => [
                        '@type' => 'MonetaryAmount',
                        'value' => '0',
                        'currency' => $this->data->currency ?? 'BRL',
                    ],

                    'shippingDestination' => [
                        '@type' => 'DefinedRegion',
                        'addressCountry' => 'BR',
                    ],

                    'deliveryTime' => [
                        '@type' => 'ShippingDeliveryTime',

                        'handlingTime' => [
                            '@type' => 'QuantitativeValue',
                            'minValue' => 1,
                            'maxValue' => 1,
                            'unitCode' => 'DAY',
                        ],

                        'transitTime' => [
                            '@type' => 'QuantitativeValue',
                            'minValue' => 10,
                            'maxValue' => 20,
                            'unitCode' => 'DAY',
                        ],
                    ],
                ],
                'hasMerchantReturnPolicy' => [
                    '@type' => 'MerchantReturnPolicy',
                    'applicableCountry' => 'BR',
                    'returnPolicyCategory' => 'https://schema.org/MerchantReturnFiniteReturnWindow',
                    'merchantReturnDays' => 7,
                    'returnMethod' => 'https://schema.org/ReturnByMail',
                    'returnFees' => 'https://schema.org/FreeReturn',
                ],
            ],
        ];

        if (!empty($this->data->ogVideo)) {
            // Extrai o ID do vídeo de qualquer formato comum do YouTube
            parse_str(parse_url($this->data->ogVideo, PHP_URL_QUERY), $params);
            $videoID = $params['v'] ?? basename(parse_url($this->data->ogVideo, PHP_URL_PATH));

            // URLs finais para o seu JSON-LD
            $embedUrl = "https://www.youtube.com/watch?v=" . $videoID;

            $schema['subjectOf'] = [
                '@type' => 'VideoObject',
                'name' => $this->data->productName ?? $this->data->title,
                'description' => $this->data->description,
                'thumbnailUrl' => "https://i.ytimg.com/vi/{$videoID}/default.jpg",
                'embedUrl' => 'https://www.youtube.com/embed/'.$videoID
            ];
        }

        // Avaliações (opcional)
        if ($this->data->ratingValue && $this->data->reviewCount) {
            $schema['aggregateRating'] = [
                '@type' => 'AggregateRating',
                'ratingValue' => $this->data->ratingValue,
                'reviewCount' => $this->data->reviewCount,
            ];
        }

        return array_filter($schema, fn ($v) => !is_null($v));

    }
}
