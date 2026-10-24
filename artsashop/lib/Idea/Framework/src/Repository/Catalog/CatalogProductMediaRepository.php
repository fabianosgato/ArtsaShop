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

namespace Idea\Framework\Repository\Catalog;

use App\Models\CatalogProduct;
use App\Models\CatalogProductMedia;
use Idea\Framework\Repository\AbstractRepository;
use Idea\Framework\Services\ServiceCache;
use Illuminate\Database\Eloquent\Builder;
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
     * Atualiza a imagem de um produto
     * @param $mediaData
     * @return \App\Models\CatalogProductMedia
     */
    public static function updateProductMedia($mediaData): CatalogProductMedia
    {
        return self::getData()->updateOrCreate(
            attributes: [
                'media_id' => $mediaData['media_id'] ?? null
            ],
            values: $mediaData
        );
    }

    /**
     * Retorna as imagens do produto
     *      product_main: Imagem padrão do produto
     *      product_page: Imagem na página do produto
     *      product_sharing: Imagem de compartilhamento (WhatsApp)
     *      product_listing: Listagem do produto
     *      product_thumbnail: Thumbnail do produto
     *
     * @param \App\Models\CatalogProduct $product
     * @return mixed
     */
    public static function getProductImagesData(CatalogProduct $product)
    {

        return app(ServiceCache::class)->remember(
            cacheKey: "product_images_component_{$product->product_id}",
            tags: ['catalog_products'],
            closure: function () use ($product) {

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

                    $imageData = [
                        'product_main' => $productImage['media_url'],
                        'product_page' => str_replace('1000x1000', '454x454', $productImage['media_url']),
                        'product_sharing' => str_replace('1000x1000', '300x300', $productImage['media_url']),
                        'product_listing' => str_replace('1000x1000', '255x255', $productImage['media_url']),
                        'product_thumbnail' => str_replace('1000x1000', '80x80', $productImage['media_url']),
                        'alt' => Str::limit($altText, 125)
                    ];

                    if ($index === 0) {
                        $images['default'] = $imageData;
                    } else {
                        $images["image_{$index}"] = $imageData;
                    }

                }

                return $images;

            }
        );

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

