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
