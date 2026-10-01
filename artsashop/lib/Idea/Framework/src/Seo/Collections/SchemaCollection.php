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

namespace Idea\Framework\Seo\Collections;

use Idea\Framework\Seo\Contracts\SeoSchemaContract;

class SchemaCollection
{
    protected array $schemas = [];

    public function add(SeoSchemaContract $schema): self
    {
        $this->schemas[] = $schema;
        return $this;
    }

    public function render(): string
    {
        return collect($this->schemas)
            ->map(fn($schema) => $schema->render())
            ->implode(PHP_EOL);
    }
}
