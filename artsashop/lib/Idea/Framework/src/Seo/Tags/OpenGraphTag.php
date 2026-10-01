<?php

namespace Idea\Framework\Seo\Tags;

use Idea\Framework\Seo\Data\SeoPageData;

class OpenGraphTag extends AbstractSeoTag
{

    protected array $tags = [];

    protected function handle(SeoPageData $data): void
    {
        $image = $data->ogImage ?: asset('images/frontend/logo.webp');

        $this->tags = [
            'og:locale' => $data->ogLocale ?? 'pt_BR',
            'og:type' => $data->ogType ?? 'website',
            'og:title' => $data->ogTitle ?: $data->title,
            'og:description' => $data->ogDescription ?: $data->description,
            'og:url' => $data->ogUrl ?: $data->canonicalUrl,
            'og:site_name' => $data->ogSiteName,
            'og:image' => $image,
            'og:image:alt' => $data->ogImageAlt ?: $data->title,
            'og:image:width' => $data->ogImageWidth,
            'og:image:height' => $data->ogImageHeight,
            'og:video' => $data->ogVideo,
            'og:audio' => $data->ogAudio,
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
            ->map(function ($value, $property) {
                return sprintf(
                    '<meta property="%s" content="%s">',
                    $property,
                    $this->escape((string)$value)
                );
            })
            ->implode(PHP_EOL);
    }

}
