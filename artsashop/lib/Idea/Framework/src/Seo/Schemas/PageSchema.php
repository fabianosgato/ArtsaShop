<?php

namespace Idea\Framework\Seo\Schemas;

use Idea\Framework\Seo\Data\SeoPageData;

class PageSchema extends AbstractSchema
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
            'publisher' => [
                '@type' => 'Organization',
                'name' => $this->data->ogSiteName ?? config('app.name'),
                'logo' => 'https://ecommerce.lef-tecnologia.com.br/images/frontend/logo.webp'
            ],
        ];

    }

}
