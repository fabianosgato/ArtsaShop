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
declare(strict_types=1);

namespace Idea\Framework\Services;

use Idea\Framework\Repository\Catalog\CatalogProductMediaRepository;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Idea\Framework\Repository\System\SysUrlRewriteRepository;
use Illuminate\Support\Str;

class SiteMapService
{
    protected const IMAGE_NS = 'http://www.google.com/schemas/sitemap-image/1.1';

    protected string $path;
    protected \SimpleXMLElement $xml;

    public function __construct()
    {
        $this->path = public_path('sitemap');
    }

    /**
     * Gera todos os sitemaps
     * @return void
     */
    public function generate(): void
    {
        $this->clearDirectory();
        $this->generateByType('product', 'sitemap-products', 2000);
        $this->generateByType('category', 'sitemap-category', 500);
        $this->generateByType('cms', 'sitemap-content', 1000, true);
        $this->generateByType('brand', 'sitemap-brand', 1000, true);

        $this->generateStatic();

        $this->generateIndex();

    }

    /**
     * Array para geração dos sitemaps estáticos
     * @return array[]
     */
    protected function staticPages(): array
    {
        return [
            'https://ecommerce.lef-tecnologia.com.br/' => ['priority' => '1.0', 'changefreq' => 'daily'],
            'https://ecommerce.lef-tecnologia.com.br/fale-conosco' => ['priority' => '0.6', 'changefreq' => 'monthly'],
        ];
    }

    /**
     * Gera os sitemaps estáticos
     */
    protected function generateStatic(): void
    {
        $this->loadTemplate();

        foreach ($this->staticPages() as $uri => $data) {

            $node = $this->xml->addChild('url');

            $node->addChild('loc', $uri);
            $node->addChild('lastmod', now()->toDateString());
            $node->addChild('changefreq', $data['changefreq']);
            $node->addChild('priority', $data['priority']);
        }

        $this->save('sitemap-static.xml');
    }

    /**
     * Gera os sitemaps com base na SysUrlRewrite
     * @param string $type
     * @param string $filePrefix
     * @param int $limit
     * @param bool $single
     * @return void
     */
    protected function generateByType(
        string $type,
        string $filePrefix,
        int    $limit = 1000,
        bool   $single = false
    ): void
    {

        $page = 1;

        do {

            $query = SysUrlRewriteRepository::getData()
                ->where(
                    column: 'target_type',
                    operator: '=',
                    value: $type)
                ->where(
                    column: 'is_system',
                    operator: '=',
                    value:1
                )
                ->orderBy(
                    column: 'url_rewrite_id',
                    direction: 'DESC'
                );

            if (!$single) {
                $query->limit($limit)->offset(($page - 1) * $limit);
            }

            $urls = $query->get();

            if ($urls->isEmpty()) break;

            $this->loadTemplate();

            // PRELOAD
            $products = [];
            $images = [];

            if ($type === 'product') {

                $productIds = [];

                foreach ($urls as $url) {
                    if ($this->isInvalidUrl($url->request_path)) continue;

                    $id = $this->extractId($url->target_path);
                    if ($id) $productIds[] = $id;
                }

                $products = $this->preloadProducts($productIds);
                $images = $this->preloadProductImages($productIds);
            }

            foreach ($urls as $url) {

                if ($this->isInvalidUrl($url->request_path)) {
                    continue;
                }

                $this->addUrl($url, $products, $images);
            }

            $fileName = $single
                ? "{$filePrefix}.xml"
                : "{$filePrefix}-{$page}.xml";

            $this->save($fileName);

            if ($single) break;

            $page++;

        } while (true);
    }

    /**
     * Cria as URLs para os sitemaps
     * @param $url
     * @param array $products
     * @param array $images
     * @return void
     */
    protected function addUrl($url, array $products = [], array $images = []): void
    {
        $node = $this->xml->addChild('url');

        $node->addChild('loc', url($url->request_path));

        // 🔥 lastmod REAL
        $lastmod = $this->resolveLastMod($url, $products);
        $node->addChild('lastmod', $lastmod);

        $node->addChild('changefreq', $this->getChangeFreq($url->target_type));
        $node->addChild('priority', $this->getPriority($url->target_type));

        // 🔥 IMAGENS
        if ($url->target_type === 'product') {

            $productId = $this->extractId($url->target_path);

            if ($productId && isset($images[$productId])) {

                $product = $products[$productId] ?? null;

                foreach ($images[$productId] as $index => $image) {

                    $imageXml = $node->addChild('image:image', '', self::IMAGE_NS);

                    $imageXml->addChild('image:loc', $image['media_url'], self::IMAGE_NS);

                    if ($product) {

                        $alt = $this->generateImageAlt($product, $index);

                        $imageXml->addChild('image:title', htmlspecialchars($alt), self::IMAGE_NS);
                        $imageXml->addChild('image:caption', htmlspecialchars($alt), self::IMAGE_NS);
                    }
                }
            }
        }
    }

    /**
     * Data de modificação de Produtos
     * @param $url
     * @param array $products
     * @return string
     */
    protected function resolveLastMod($url, array $products): string
    {
        if ($url->target_type === 'product') {

            $productId = $this->extractId($url->target_path);

            if ($productId && isset($products[$productId])) {

                $product = $products[$productId];

                return !empty($product['updated_at'])
                    ? date('Y-m-d', strtotime($product['updated_at']))
                    : now()->toDateString();
            }
        }

        return !empty($url->updated_at)
            ? date('Y-m-d', strtotime($url->updated_at))
            : now()->toDateString();
    }

    /**
     * Retorna os produtos para geração das URLs de imagens
     * @param array $ids
     * @return array
     */
    protected function preloadProducts(array $ids): array
    {
        if (empty($ids)) return [];

        return CatalogProductsRepository::getProducts()
            ->whereIn('catalog_product.product_id', $ids)
            ->get()
            ->keyBy('product_id')
            ->toArray();
    }

    protected function preloadProductImages(array $ids): array
    {
        if (empty($ids)) return [];

        return CatalogProductMediaRepository::getData()
            ->select('product_id', 'media_url')
            ->whereIn('product_id', $ids)
            ->get()
            ->groupBy('product_id')
            ->toArray();
    }

    protected function extractId(string $targetPath): ?int
    {
        $parts = explode('/', $targetPath);
        return isset($parts[1]) ? (int)$parts[1] : null;
    }

    /**
     * Valida se as URLs são inválidas
     * @param string $path
     * @return bool
     */
    protected function isInvalidUrl(string $path): bool
    {
        $path = trim($path, '/');

        return str_starts_with($path, 'checkout')
            || str_starts_with($path, 'customer')
            || str_starts_with($path, 'search')
            || str_contains($path, '?');
    }

    /**
     * Cria as descrições alt das imagens para o Sitemap
     * @param $product
     * @param int $index
     * @return string
     */
    protected function generateImageAlt($product, int $index): string
    {
        $contexts = [
            0 => "",
            1 => " - Detalhe da Marca {$product['brand_name']}",
            2 => " - Categoria {$product['attribute_set_name']}",
            3 => " - Especificações Técnicas e Modelo {$product['sku']}",
            4 => " - Vista Lateral e Acabamento",
            5 => " - Aplicação e uso"
        ];

        $suffix = $contexts[$index] ?? " - Foto {$index} {$product['brand_name']}";
        $shortName = Str::words($product['name'], 5, '');

        return Str::limit("{$shortName}{$suffix}", 125);
    }

    /**
     * Cria as estrategias de priority
     * @param string $type
     * @return string
     */
    protected function getPriority(string $type): string
    {
        return match ($type) {
            'product' => '1.0',
            'category' => '0.8',
            'brand' => '0.7',
            'cms' => '0.6',
            default => '0.5',
        };
    }

    /**
     * Cria as estratégias de ChangeFreq
     * @param string $type
     * @return string
     */
    protected function getChangeFreq(string $type): string
    {
        return match ($type) {
            'product' => 'daily',
            'category' => 'daily',
            'brand' => 'weekly',
            'cms' => 'monthly',
            default => 'monthly',
        };
    }

    /*
    |--------------------------------------------------------------------------
    | XML
    |--------------------------------------------------------------------------
    */

    protected function loadTemplate(string $type = 'urlset'): void
    {
        $template = match ($type) {
            'index' => base_path('resources/sitemap/sitemap-group.xml'),
            default => base_path('resources/sitemap/sitemap.xml'),
        };

        $this->xml = simplexml_load_file($template);
    }

    protected function save(string $file): void
    {
        if (!file_exists($this->path)) {
            mkdir($this->path, 0777, true);
        }

        $this->xml->asXML($this->path . '/' . $file);
    }

    protected function generateIndex(): void
    {
        $this->loadTemplate('index');

        $files = glob($this->path . '/*.xml');

        // Remove o próprio index
        $files = array_filter($files, function ($file) {
            return !str_contains($file, 'sitemap.xml');
        });

        // 🔥 Ordem desejada
        $priorityOrder = [
            'sitemap-products',
            'sitemap-category',
            'sitemap-brand',
            'sitemap-content', // cms
            'sitemap-static'
        ];

        // 🔥 Agrupa arquivos por tipo
        $grouped = [];

        foreach ($files as $file) {
            $basename = basename($file);

            foreach ($priorityOrder as $type) {
                if (str_starts_with($basename, $type)) {
                    $grouped[$type][] = $file;
                    break;
                }
            }
        }

        // 🔥 Monta XML na ordem correta
        foreach ($priorityOrder as $type) {

            if (empty($grouped[$type])) continue;

            // Ordena paginação (ex: -1, -2, -3)
            sort($grouped[$type]);

            foreach ($grouped[$type] as $file) {

                $node = $this->xml->addChild('sitemap');

                $node->addChild('loc', asset('sitemap/' . basename($file)));
                $node->addChild('lastmod', now()->toDateString());
            }
        }

        $this->xml->asXML($this->path . '/sitemap.xml');

    }

    /*
    |--------------------------------------------------------------------------
    | CLEANUP
    |--------------------------------------------------------------------------
    */

    protected function clearDirectory(): void
    {
        if (!file_exists($this->path)) {
            mkdir($this->path, 0777, true);
            return;
        }

        foreach (glob($this->path . '/*.xml') as $file) {
            unlink($file);
        }
    }
}
