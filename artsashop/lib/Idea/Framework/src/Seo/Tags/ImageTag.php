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
