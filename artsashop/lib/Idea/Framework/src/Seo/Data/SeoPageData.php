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

namespace Idea\Framework\Seo\Data;

use Carbon\Carbon;

class SeoPageData
{
    public function __construct(
        public string  $title,
        public ?string $description = null,
        public ?string $canonicalUrl = null,
        public ?string $url = null,
        public ?string $image = null,
        public ?string $author = null,

        public ?string $titleSource = 'manual',
        public ?string $descriptionSource = 'manual',

        public bool    $noIndex = false,
        public bool    $noFollow = false,

        public float   $priority = 0.8,
        public string  $changeFreq = 'weekly',

        public ?Carbon $updatedAt = null,

        // Open Graph
        public ?string $ogTitle = null,
        public ?string $ogDescription = null,

        public ?string $ogLocale = 'pt_BR',
        public ?string $ogType = 'website',
        public ?string $ogUrl = null,
        public ?string $ogSiteName = null,
        public ?string $ogImage = null,
        public ?string $ogImageAlt = null,
        public ?int $ogImageWidth = null,
        public ?int $ogImageHeight = null,
        public ?string $ogVideo = null,
        public ?string $ogAudio = null,

        public ?string $generator = null,

        // Product
        public ?string $productName = null,
        public ?string $productDescription = null,
        public ?string $productImage = null,
        public ?string $productSku = null,
        public ?string $brand = null,

        public ?float $price = null,
        public ?string $currency = 'BRL',
        public bool $inStock = true,

        public ?float $ratingValue = null,
        public ?int $reviewCount = null,

        // Category
        public array $categoryProducts = [],

        // Twitter
        public ?string $twitterCard = 'summary_large_image',

        // Controle de sitemap
        public bool    $includeInSitemap = true,
    )
    {
        $this->updatedAt ??= now();
    }

    /**
     * Retorna a URL final da página.
     */
    public function resolvedUrl(): ?string
    {

        // Verifica se existe paginação.
        $currentPage = request()->get('page');

        if($currentPage) {
            return request()->fullUrl();
        } else {
            return $this->canonicalUrl ?? $this->url;
        }

    }

    /**
     * Retorna o valor da meta robots.
     */
    public function robots(): string
    {
        $directives = [];

        // Verifica se existe paginação.
        $currentPage = request()->get('page');

        // Valida se a pagina é maior que 1
        if($currentPage > 1) {
            $directives[] = 'noindex';
        } else {
            $directives[] = $this->noIndex ? 'noindex' : 'index';
        }

        $directives[] = $this->noFollow ? 'nofollow' : 'follow';

        return implode(',', $directives);
    }
}
