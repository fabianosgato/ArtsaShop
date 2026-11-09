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
namespace Idea\Framework\Services;

use App\Models\SeoPage;
use App\Models\SysUrlRewrite;
use Idea\Framework\Contracts\ServiceInterface;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Repository\Seo\SeoPageRepository;
use Idea\Framework\Repository\System\SysUrlRewriteRepository;
use Modules\Catalog\Services\CatalogProductMediaService;

class IndexerService implements ServiceInterface
{
    public function __construct(
        protected CatalogProductsRepository $catalogProductsRepository
    )
    {
    }

    public function reindex(): void
    {
        // Retorna todos os produtos da base
        $catalogProducts = $this->catalogProductsRepository::getProducts()
            ->orderBy(
                column: 'product_id',
                direction: 'desc'
            )
            ->get();

        foreach ($catalogProducts as $index => $catalogProduct) {
            print("$index : {$catalogProduct->product_id} {$catalogProduct->sku} : {$catalogProduct->name} \n");

            // 1. Indexa as imagens de produtos
            CatalogProductMediaService::proccessAllImages(
                catalogProduct: $catalogProduct
            );

            // 2. Valida/Cria URL Rewrite (sys_url_rewrite)
            $this->ensureUrlRewrite($catalogProduct);

            // 3. Valida/Cria SEO Page (seo_pages)
            $this->ensureSeoPage($catalogProduct);
        }
    }

    /**
     * Garante que o produto tem URL Rewrite válido
     * @param \App\Models\CatalogProduct $product
     */
    protected function ensureUrlRewrite($product): void
    {
        $targetPath = 'product/' . $product->product_id;

        // Verifica se já existe URL rewrite para este produto
        $existing = SysUrlRewrite::query()
            ->where('target_type', 'product')
            ->where('target_path', $targetPath)
            ->first();

        if (!$existing) {
            // Cria URL rewrite usando o slug_key do produto
            SysUrlRewriteRepository::saveUrlRewrite([
                'request_path' => $product->slug_key,
                'target_path' => $targetPath,
                'target_type' => 'product',
                'is_system' => 1,
            ]);
            print("  → URL Rewrite criado: {$product->slug_key} → {$targetPath}\n");
        }
    }

    /**
     * Garante que o produto tem SEO Page válido
     * @param \App\Models\CatalogProduct $product
     */
    protected function ensureSeoPage($product): void
    {
        // Verifica se já existe SEO page para este produto
        $existing = SeoPage::query()
            ->where('object', 'product')
            ->where('object_id', (string) $product->product_id)
            ->first();

        if (!$existing) {
            // Cria SEO page com dados padrão do produto
            SeoPageRepository::saveOrUpdateByObject(
                object: 'product',
                objectId: $product->product_id,
                seoPageData: [
                    'object' => 'product',
                    'object_id' => $product->product_id,
                    'path' => trim("{$product->slug_key}-{$product->product_id}"),
                    'title' => $product->name,
                    'title_source' => 'auto',
                    'description' => $product->short_description ?? '',
                    'description_source' => 'auto',
                    'change_frequency' => 'weekly',
                    'priority' => 0.5,
                    'schema' => '',
                    'focus_keyword' => '',
                    'tags' => '',
                    'robot_index' => 'index',
                    'robot_follow' => 'follow',
                    'canonical_url' => url(trim($product->slug_key)),
                ]
            );
            print("  → SEO Page criado: {$product->name}\n");
        }
    }
}
