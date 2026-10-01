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
namespace Idea\Framework\Seo\Factories;

use Carbon\Carbon;
use Idea\Framework\Seo\Data\SeoPageData;

class SeoPageDataFactory
{
    /**
     * Cria SeoPageData a partir de array (ex: repository).
     */
    public static function fromArray(array $data): SeoPageData
    {
        $titleSource = $data['titleSource'] ?? 'manual';
        $descriptionSource = $data['descriptionSource'] ?? 'manual';

        $title = self::resolveTitle($data, $titleSource);
        $description = self::resolveDescription($data, $descriptionSource);

        return new SeoPageData(
            title: $title,
            description: $description,
            canonicalUrl: $data['canonical_url'] ?? config('app.url'),

            url: $data['canonical_url'] ?? config('app.url'),
            image: $data['image'] ?? asset('images/frontend/logo.webp'),

            author: $data['author'] ?? null,
            titleSource: $titleSource,
            descriptionSource: $descriptionSource,

            noIndex: ($data['robotIndex'] ?? 'index') === 'noindex',
            noFollow: ($data['robotFollow'] ?? 'follow') === 'nofollow',

            priority: (float)($data['priority'] ?? 0.8),
            changeFreq: $data['change_frequency'] ?? 'weekly',

            updatedAt: isset($data['updated_at'])
                ? Carbon::parse($data['updated_at'])
                : null,

            ogTitle: $data['og:title'] ?? null,
            ogDescription: $data['og:description'] ?? null,
            ogLocale: $data['og:locale'] ?? 'pt_BR',
            ogType: self::resolveOgType($data['og:type'] ?? null),
            ogUrl: $data['og:url'] ?? null,
            ogSiteName: $data['og:site_name'] ?? config('app.APP_NAME'),
            ogImage: $data['og:image'] ?? null,
            ogImageAlt: $data['og:image:alt'] ?? null,
            ogImageWidth: !empty($data['og:image:width']) ? (int)$data['og:image:width'] : null,
            ogImageHeight: !empty($data['og:image:height']) ? (int)$data['og:image:height'] : null,
            ogVideo: $data['og:video'] ?? null,
            ogAudio: $data['og:audio'] ?? null,

            generator: $data['generator'] ?? null,

            twitterCard: $data['twitter_card'] ?? 'summary_large_image',

            includeInSitemap: (bool)($data['include_in_sitemap'] ?? true),

        );
    }

    protected static function resolveTitle(array $data, string $source): string
    {

        if ($source === 'manual' && !empty($data['meta_title'])) {
            return $data['meta_title'] . " ~ ".config('app.name');
        }

        // fallback automático
        return $data['title']
            ?? config('app.name')
            ?? 'Untitled Page';
    }

    protected static function resolveDescription(array $data, string $source): ?string
    {
        if ($source === 'manual' && !empty($data['meta_description'])) {
            return $data['meta_description'];
        }

        // fallback automático
        return $data['meta_description'] ?? null;
    }

    protected static function resolveOgType(?string $type): string
    {
        if (!$type) {
            return 'website';
        }

        if (str_contains($type, '|')) {
            return explode('|', $type)[0];
        }

        return $type;
    }

    /**
     * Cria SeoPageData a partir de um Model genérico (sem acoplamento).
     */
    public static function fromModel(object $model): SeoPageData
    {
        return self::fromArray(
            method_exists($model, 'toArray')
                ? $model->toArray()
                : get_object_vars($model)
        );
    }
}
