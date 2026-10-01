<?php

namespace Idea\Framework\Seo\Schemas;

use Idea\Framework\Seo\Data\SeoPageData;

class CategorySchema extends AbstractSchema
{
    public function __construct(
        protected SeoPageData $data
    ) {}

    public function toArray(): array
    {

        return [
            '@context' => 'https://schema.org',
            '@type' => 'ItemList',
            'name' => $this->data->title,
            'description' => $this->data->description,
            'url' => $this->data->canonicalUrl,

            'itemListElement' => $this->buildItems(),
        ];
    }

    protected function buildItems(): array
    {
        $items = [];

        foreach ($this->data->categoryProducts as $index => $product) {

            $item = [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'url' => $product['url'],
            ];

            if (!empty($product['name'])) {
                $item['name'] = $product['name'];
            }

            $items[] = $item;
        }

        return $items;
    }
}
