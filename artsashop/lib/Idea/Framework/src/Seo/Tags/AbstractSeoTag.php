<?php

namespace Idea\Framework\Seo\Tags;

use Idea\Framework\Seo\Contracts\SeoTagContract;
use Idea\Framework\Seo\Data\SeoPageData;

abstract class AbstractSeoTag implements SeoTagContract
{

    protected ?SeoPageData $data = null;

    /**
     * Valor principal da tag.
     */
    protected mixed $value = null;

    /**
     * Atributos adicionais da tag.
     */
    protected array $attributes = [];

    public function initialize(SeoPageData $data): void
    {
        $this->data = $data;

        $this->handle($data);
    }

    /**
     * Cada tag implementa sua lógica aqui.
     */
    abstract protected function handle(SeoPageData $data): void;

    public function shouldRender(): bool
    {
        return !empty($this->value);
    }

    /**
     * Escapa valor para HTML seguro.
     */
    protected function escape(string $value): string
    {
        return e($value);
    }

    /**
     * Renderiza atributos HTML.
     */
    protected function renderAttributes(): string
    {
        return collect($this->attributes)
            ->filter(fn($v) => $v !== null)
            ->map(fn($v, $k) => sprintf('%s="%s"', $k, $this->escape((string)$v)))
            ->implode(' ');
    }
}
