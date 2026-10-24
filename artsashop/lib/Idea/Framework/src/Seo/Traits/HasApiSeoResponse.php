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
namespace Idea\Framework\Seo\Traits;

use Idea\Framework\Contracts\Seo\SeoAware;
use Idea\Framework\Repository\Seo\SeoPageRepository;

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
