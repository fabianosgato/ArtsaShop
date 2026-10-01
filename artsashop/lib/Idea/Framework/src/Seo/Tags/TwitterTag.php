<?php

namespace Idea\Framework\Seo\Tags;

use Idea\Framework\Seo\Data\SeoPageData;

class TwitterTag extends AbstractSeoTag
{
    protected array $tags = [];

    protected function handle(SeoPageData $data): void
    {
        $this->tags = [
            'twitter:card' => $data->twitterCard ?? 'summary_large_image',
            'twitter:title' => $data->ogTitle ?: $data->title,
            'twitter:description' => $data->ogDescription ?: $data->description,
            'twitter:image' => $data->ogImage ?: asset('images/frontend/logo.webp'),
            'twitter:site' => null,
            'twitter:creator' => null,
        ];
    }

    public function shouldRender(): bool
    {
        return true;
    }

    public function render(): string
    {
        return collect($this->tags)
            ->filter(fn($value) => !empty($value))
            ->map(function ($value, $name) {
                return sprintf(
                    '<meta name="%s" content="%s">',
                    $name,
                    $this->escape((string)$value)
                );
            })
            ->implode(PHP_EOL);
    }
}
