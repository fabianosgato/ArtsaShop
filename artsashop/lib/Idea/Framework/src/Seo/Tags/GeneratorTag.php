<?php

namespace Idea\Framework\Seo\Tags;

use Idea\Framework\Seo\Data\SeoPageData;

class GeneratorTag extends AbstractSeoTag
{
    protected function handle(SeoPageData $data): void
    {
        $this->value = $data->generator;
    }

    public function render(): string
    {
        return sprintf(
            '<meta name="generator" content="%s">',
            $this->escape($this->value)
        );
    }
}
