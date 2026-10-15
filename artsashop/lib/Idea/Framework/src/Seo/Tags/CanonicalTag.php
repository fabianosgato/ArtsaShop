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
namespace Idea\Framework\Seo\Tags;

use Idea\Framework\Seo\Data\SeoPageData;

class CanonicalTag extends AbstractSeoTag
{
    protected function handle(SeoPageData $data): void
    {
        $this->value = $data->resolvedUrl();
    }

    public function render(): string
    {
        return sprintf(
            '<link rel="canonical" href="%s">',
            $this->escape($this->value)
        );
    }
}
