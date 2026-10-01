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

namespace Idea\Framework\Seo\Tags;

use Idea\Framework\Seo\Data\SeoPageData;

class DescriptionTag extends AbstractSeoTag
{
    protected function handle(SeoPageData $data): void
    {
        $this->value = $data->description;
    }

    public function render(): string
    {
        return sprintf(
            '<meta name="description" content="%s">',
            $this->escape($this->value)
        );
    }
}
