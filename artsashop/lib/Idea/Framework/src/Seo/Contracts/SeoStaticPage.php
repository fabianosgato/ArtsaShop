<?php

namespace Idea\Framework\Seo\Contracts;

class SeoStaticPage implements SeoAware
{

    public function __construct(
        protected string $code,
        protected string $title,
        protected string $description = '',
        protected bool $noIndex = false,
        protected bool $noFollow = false
    )
    {
    }

    public function getSeoObject(): string
    {
        return 'static_page';
    }

    public function getSeoObjectId(): string
    {
        return $this->code;
    }

    public function getDefaultTitle(): string
    {
        return $this->title;
    }

    public function getDefaultDescription(): string
    {
        return $this->description;
    }

    public function getDefaultNoIndex(): bool
    {
        return $this->noIndex;
    }

    public function getDefaultNoFollow(): bool
    {
        return $this->noIndex;
    }

}
