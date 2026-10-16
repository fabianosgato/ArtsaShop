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
namespace Idea\Framework\Seo\Collections;

use Idea\Framework\Contracts\Seo\SeoTagContract;
use Idea\Framework\Seo\Data\SeoPageData;

class TagCollection
{
    /**
     * @var SeoTagContract[]
     */
    protected array $tags = [];

    /**
     * Adiciona uma tag à coleção.
     */
    public function add(SeoTagContract $tag): self
    {
        $this->tags[] = $tag;

        return $this;
    }

    /**
     * Inicializa todas as tags com os dados da página.
     */
    public function initialize(SeoPageData $data): self
    {
        foreach ($this->tags as $tag) {
            $tag->initialize($data);
        }

        return $this;
    }

    /**
     * Retorna apenas as tags válidas para renderização.
     *
     * @return SeoTagContract[]
     */
    public function valid(): array
    {
        return array_filter(
            $this->tags,
            fn(SeoTagContract $tag) => $tag->shouldRender()
        );
    }

    /**
     * Renderiza todas as tags válidas.
     */
    public function render(): string
    {
        return collect($this->valid())
            ->map(fn(SeoTagContract $tag) => $tag->render())
            ->implode(PHP_EOL);
    }

    /**
     * Retorna todas as tags (inclusive inválidas).
     *
     * @return SeoTagContract[]
     */
    public function all(): array
    {
        return $this->tags;
    }
}
