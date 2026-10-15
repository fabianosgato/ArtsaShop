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
use Idea\Framework\Seo\Support\SitemapTag as SitemapTagSupport;
use Idea\Framework\Seo\Traits\RenderableCollection;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Collection;

class SitemapTag extends Collection implements Renderable
{
    use RenderableCollection;

    public static function initialize(?SeoPageData $seoPageData = null): static
    {
        $collection = new static;

        if ($sitemap = config('seo.sitemap')) {
            $collection->push(new SitemapTagSupport($sitemap));
        }

        return $collection;
    }
}
