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


trait HasApiSeoResponse
{
    protected function seoData(SeoAware $entity): array
    {

        // Retorna o SEO da página
        $seo = SeoPageRepository::getSeoFor($entity);

        if (!$seo) {
            return [];
        }

        $metaTags = [];

        foreach ($seo->metaTags()->get() as $tag) {
            $metaTags[] = [
                'name' => $tag->metaTagName()->first()->property,
                'value' => $tag->content
            ];
        }

        return [
            'title' => $seo->title,
            'titleSource' => $seo->title_source,
            'description' => $seo->description,
            'descriptionSource' => $seo->description_source,
            'changeFrequency' => $seo->change_frequency,
            'priority' => $seo->priority,
            'schema' => $seo->schema,
            'canonical' => $seo->canonical_url,
            'robotIndex' => $seo->robot_index,
            'robotFollow' => $seo->robot_follow,
            'focusKeyword' => $seo->focus_keyword,
            'tags' => $seo->tags,
            'metaTags' => $metaTags,
        ];
    }
}
