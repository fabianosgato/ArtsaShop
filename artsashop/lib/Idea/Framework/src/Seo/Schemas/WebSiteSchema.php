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

class WebSiteSchema extends AbstractSchema
{
    public function __construct(
        protected SeoPageData $data,
        protected string      $baseUrl
    )
    {
    }

    public function toArray(): array
    {

        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            "@id" => $this->baseUrl,
            'url' => $this->data->canonicalUrl ?? $this->baseUrl,
            'name' => $this->data->title,
            'description' => $this->data->description,
            'image' => [
                asset('images/frontend/logo.webp')
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => $this->data->ogSiteName ?? config('app.name'),
                'logo' => asset('images/frontend/logo.webp')
            ],

            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => [
                    '@type' => "EntryPoint",
                    'urlTemplate' => url('/catalogsearch/result') . '?q={search_term_string}',
                ],
                'query-input' => 'required name=search_term_string'
            ],

        ];

    }

}
