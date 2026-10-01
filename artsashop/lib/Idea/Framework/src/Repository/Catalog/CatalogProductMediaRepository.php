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

namespace Idea\Framework\Repository\Catalog;

use App\Models\CatalogProduct;
use App\Models\CatalogProductMedia;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;

class CatalogProductMediaRepository extends AbstractRepository
{

    // Inicializa a Classe
    protected static $model = CatalogProductMedia::class;

    /**
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public static function getData(): Builder
    {
        return self::loadModel()::query();
    }

    /**
     * Exclui as imagens do produto
     * @param int $productId
     * @return void
     */
    public static function deleteImagesProduct(int $productId)
    {

        // Deleta as imagens do produto
        self::getData()->where(
            column: 'product_id',
            operator: '=',
            value: $productId
        )->delete();

    }

    /**
     * Retorna as imagens do produto
     * @param $productId
     * @return \Illuminate\Database\Eloquent\Collection|null
     */
    public static function getProductImages($productId)
    {

        // Inicializa a query
        $query = self::getData();

        // Filtra pelo Produto
        $query->where(
            column: 'product_id',
            operator: '=',
            value: $productId
        );

        if ($query->exists())
            return $query
                ->orderBy('sort_order')
                ->get();

        return null;

    }

    /**
     * Retorna as imagens do produto
     * @param \App\Models\CatalogProduct $product
     * @return mixed
     */
    public static function getProductImagesData(CatalogProduct $product)
    {

        $cacheKey = "product_images_component_{$product->product_id}";

        return Cache::remember($cacheKey, 8600, function () use ($product) {

            $contexts = [
                0 => "",
                1 => " - Detalhe da Marca {$product->brand_name}",
                2 => " - Categoria {$product->attribute_set_name}",
                3 => " - Especificações Técnicas e Modelo {$product->sku}",
                4 => " - Vista Lateral e Acabamento",
                5 => " - Aplicação e uso"
            ];

            $images = [];
            $productImages = CatalogProductMediaRepository::getProductImagesArray($product->product_id);

            foreach ($productImages as $index => $productImage) {

                $suffix = $contexts[$index] ?? " - Foto {$index} {$product->brand_name}";
                $shortName = Str::words($product->name, 5, '');
                $altText = "{$shortName}{$suffix}";

                // '1000x1000': Imagem grande do produto
                // '454x454': Imagem padrao do produto (página e WhatsApp)
                // '300x300': Imagem de compartilhamento
                // '255x255': Listagens do produtos
                // '80x80': Thubnails do produto

                $imageData = [
                    'image' => $productImage['media_url'],
                    '454x454' => str_replace('1000x1000', '454x454', $productImage['media_url']),
                    '300x300' => str_replace('1000x1000', '300x300', $productImage['media_url']),
                    '255x255' => str_replace('1000x1000', '255x255', $productImage['media_url']),
                    '80x80' => str_replace('1000x1000', '80x80', $productImage['media_url']),
                    'alt' => Str::limit($altText, 125)
                ];

                if ($index === 0) {
                    $images['default'] = $imageData;
                } else {
                    $images["image_{$index}"] = $imageData;
                }

            }

            return $images;

        });

    }

    /**
     * Retorna as imagens do produto no formato de array
     * @param $productId
     * @return array
     */
    public static function getProductImagesArray($productId): array
    {

        $query = self::getProductImages($productId);

        if ($query) {
            return $query->toArray();

        }

        return [];

    }

    /**
     * Atualiza a ordenação das imagens/media do produto
     * @param int $mediaId
     * @param int $sortOrder
     * @return void
     */
    public static function saveSortOrderImage(int $mediaId, int $sortOrder): void
    {
        // Atualiza a ordenação das imagens do produto
        self::getData()->updateOrCreate(
            attributes: [
                'media_id' => $mediaId
            ],
            values:[
                'sort_order' => $sortOrder
            ]
        );

    }

}

