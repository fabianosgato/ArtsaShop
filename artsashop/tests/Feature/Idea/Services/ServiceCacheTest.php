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
declare(strict_types=1);

namespace Tests\Feature\Idea\Services;

use Idea\Framework\Repository\Cms\CmsBannerRepository;
use Idea\Framework\Services\ServiceCache;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

class ServiceCacheTest extends TestCase
{

    public function testGetCacheExpireInReturnsDefaultWhenTagIsNotConfiguredWithZero(): void
    {
        $tags = [
            'catalog_products',
        ];

        $expireIn = app(ServiceCache::class)->getCacheExpireIn($tags);

        $this->assertSame(3600, $expireIn);
    }

    public function testGetCacheExpireInReturnsZeroWhenOneOfTheTagsIsForever(): void
    {
        $tags = [
            'catalog_products',
            'banners',
        ];

        $expireIn = app(ServiceCache::class)->getCacheExpireIn($tags);

        $this->assertSame(0, $expireIn);
    }


    public function testExpireInIntVal(): void
    {

        // Arrange: Instancia a classe de Cache
        $serviceCache = new ServiceCache();
        $expireIn = $serviceCache->defaultExpireIn();

        // Valida se o resultado é um inteiro
        $this->assertIsInt($expireIn);

        $this->assertSame(
            intval(getConfigData(
                path: 'cache/config/expire_in'
            )),
            $expireIn
        );

    }

    public function testRemember(): void
    {

        // Arrange: Key do cache
        $cacheKey = 'banners_home_topo';
        // Arrange: local do banner
        $bannerLocal = 'banner_main_top';
        // Arrange: Array de tags
        $tags = [
            'banners',
        ];

        // Act: Cria o cache
        app(ServiceCache::class)->remember(
            cacheKey: $cacheKey,
            tags: $tags,
            closure: function () use ($bannerLocal) {
                return CmsBannerRepository::getData()
                    ->where('is_active', 1)
                    ->where('banner_type', 'banner_home')
                    ->where('banner_local', $bannerLocal)
                    ->orderBy('banner_order')
                    ->get();
            }
        );

        // Assert: Valida se o cache ainda existe
        $this->assertTrue(Cache::tags($tags)->has($cacheKey));


    }

    public function testForgetByTags()
    {

        // Arrange: Key do cache
        $cacheKey = 'banners_home_topo';
        // Arrange: local do banner
        $bannerLocal = 'banner_main_top';
        // Arrange: Array de tags
        $tags = [
            'banners',
        ];
        // Arrange: Cria o cache
        app(ServiceCache::class)->remember(
            cacheKey: $cacheKey,
            tags: $tags,
            closure: function () use ($bannerLocal) {
                return CmsBannerRepository::getData()
                    ->where('is_active', 1)
                    ->where('banner_type', 'banner_home')
                    ->where('banner_local', $bannerLocal)
                    ->orderBy('banner_order')
                    ->get();
            }
        );

        // Act: Limpa o cache pelas tags
        app(ServiceCache::class)->forgetByTags($tags);

        // Assert: Valida se o cache ainda existe
        $this->assertFalse(Cache::tags($tags)->has($cacheKey));

    }

    public function testForgetByKey()
    {

        // Arrange: Key do cache
        $cacheKey = 'banners_home_topo';
        // Arrange: local do banner
        $bannerLocal = 'banner_main_top';
        // Arrange: Array de tags
        $tags = [
            'banners',
        ];

        // Act: Cria o cache
        app(ServiceCache::class)->remember(
            cacheKey: $cacheKey,
            tags: $tags,
            closure: function () use ($bannerLocal) {
                return CmsBannerRepository::getData()
                    ->where('is_active', 1)
                    ->where('banner_type', 'banner_home')
                    ->where('banner_local', $bannerLocal)
                    ->orderBy('banner_order')
                    ->get();
            }
        );

        // Assert: Valida se o cache ainda existe
        $this->assertFalse(Cache::has($cacheKey));

    }

}
