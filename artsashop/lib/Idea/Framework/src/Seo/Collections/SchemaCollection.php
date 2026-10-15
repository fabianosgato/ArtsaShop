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
