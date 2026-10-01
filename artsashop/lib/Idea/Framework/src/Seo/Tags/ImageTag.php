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
use Idea\Framework\Seo\Support\MetaTag;
use Illuminate\Support\HtmlString;

class ImageTag extends MetaTag
{
    public static function initialize(?SeoPageData $seoPageData): ?MetaTag
    {
        $image = $seoPageData?->image;

        if (! $image) {
            return null;
        }

        return new MetaTag(
            name: 'image',
            content: new HtmlString($image),
        );
    }
}
