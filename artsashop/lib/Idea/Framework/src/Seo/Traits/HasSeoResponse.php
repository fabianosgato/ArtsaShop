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

namespace Idea\Framework\Seo\Traits;

use Idea\Framework\Repository\Seo\SeoPageRepository;
use Idea\Framework\Seo\Contracts\SeoAware;
use Idea\Framework\Seo\Data\SeoPageData;
use Idea\Framework\Seo\Factories\SeoPageDataFactory;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;


trait HasSeoResponse
{

    protected array $seoContext = [];

    public function setSeoContext(array $context): self
    {
        $this->seoContext = $context;
        return $this;
    }

    /**
     * Retorna as metatags SEO de um produto
     * @param \Idea\Framework\Seo\Contracts\SeoAware|null $entity
     * @return void
     */
    public function getSeoMetaTags(?SeoAware $entity = null): void
    {

        $routeName = request()->route()?->getName() ?? 'unknown';
        $url = request()->fullUrl();

        $entityKey = $entity ? get_class($entity) . '_' . ($entity->id ?? spl_object_id($entity)) : 'no-entity';

        $cacheKey = 'seo_meta:' . md5($routeName . '|' . $url . '|' . $entityKey);

        $seoData = Cache::rememberForever($cacheKey, function () use ($entity) {

            if ($entity) {
                $seo = SeoPageRepository::getSeoFor($entity);
            }

            if (!isset($seo) || !$seo) {
                return new SeoPageData(
                    title: $entity?->getDefaultTitle() ?? config('app.name'),
                    description: $entity?->getDefaultDescription() ?? '',
                    canonicalUrl: url()->current(),
                    noIndex: $entity?->getDefaultNoIndex() ?? false,
                    noFollow: $entity?->getDefaultNoFollow() ?? false,
                );
            }

            $seoArray = [
                'meta_title' => $seo->title,
                'meta_description' => $seo->description,
                'canonical_url' => $seo->canonical_url,
                'no_index' => $seo->robot_index === 'noindex',
                'no_follow' => $seo->robot_follow === 'nofollow',
                'priority' => $seo->priority,
                'change_frequency' => $seo->change_frequency,
                'updated_at' => $seo->updated_at,
            ];

            foreach ($seo->metaTags()->get() as $tag) {
                $seoArray[$tag->metaTagName()->first()->property] = $tag->content;
            }

            $seoData = SeoPageDataFactory::fromArray($seoArray);

            if ($seo->object == 'product') {

                $seoData->productName = $entity->name;
                $seoData->productDescription = $entity->description;

                $seoData->productImage = $entity->image;
                $seoData->productSku = $entity->sku;
                $seoData->brand = $entity->brand_name;

                $seoData->image = $entity->image;
                $seoData->price = $entity->final_price;
                $seoData->currency = 'BRL';
                $seoData->inStock = $entity->qty > 0;

                // Valida se o produto possui video
                if (!empty($entity->video_url)) {
                    $seoData->ogVideo = $entity->video_url;
                }

            } elseif ($seo->object == 'category' || $seo->object == 'brand') {

                if (!empty($this->seoContext['category_products'])) {
                    $seoData->categoryProducts = $this->seoContext['category_products'];
                }

            }

            return $seoData;

        });

        View::share('seoData', $seoData);

    }

}
