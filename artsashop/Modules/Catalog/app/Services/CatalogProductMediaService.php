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
namespace Modules\Catalog\Services;

use App\Models\CatalogProduct;
use Idea\Framework\Media\Download\MediaDownloader;
use Idea\Framework\Media\Processing\ImageResizer;
use Idea\Framework\Media\Storage\ImageStorage;
use Idea\Framework\Media\Validation\ImageValidator;
use Idea\Framework\Repository\Catalog\CatalogProductMediaRepository;
use Idea\Framework\Repository\Catalog\CatalogProductsRepository;
use Illuminate\Support\Facades\Storage;

class CatalogProductMediaService
{

    /**
     * Retorna as imagens do produto caso existam no storage
     * @param \App\Models\CatalogProduct $catalogProduct
     * @return array
     */
    public static function getProductImages(CatalogProduct $catalogProduct): array
    {

        $productImages = [];

        // Retorna as imagens do produto
        $catalogProductImages = CatalogProductMediaRepository::getProductImages(
            productId: $catalogProduct->product_id
        );

        foreach  ($catalogProductImages as $catalogProductImage) {

            if (Storage::disk('public')->exists($catalogProductImage->media_file)) {
                $productImages[] = [
                    'media_file' => $catalogProductImage->media_file,
                    'media_url' => $catalogProductImage->media_url,
                ];
            }
        }

        return $productImages;


    }


    /**
     * Processa e atualiza os arquivos de imagem de um produto
     * @param \App\Models\CatalogProduct $catalogProduct
     * @return void
     */
    public static function proccessImages(CatalogProduct $catalogProduct): void
    {

        // Retorna as imagens do produto
        $catalogProductImages = CatalogProductMediaRepository::getProductImages(
            productId: $catalogProduct->product_id
        );

        if ($catalogProductImages) {

            foreach ($catalogProductImages as $idx => $catalogProductImage) {

                // Valida se as images existem no diretório
                if (Storage::disk('public')->exists($catalogProductImage->media_file)) {

                    // Retorna os dados da imagem
                    $mediaFile = Storage::disk('public')->path($catalogProductImage->media_file);

                    // Caminho da Imagem
                    $path = pathinfo($mediaFile);

                    // Valida se a imagem existe no diretório
                    if (ImageValidator::isValid($mediaFile)) {

                        // Resize das imagens
                        $resized = ImageResizer::resize($mediaFile);

                        if (count($resized) > 0) {

                            // Salva as imagens no disco
                            $stored = ImageStorage::save(
                                images: $resized,
                                absoluteTargetDir: $path['dirname'],
                                baseName: "{$catalogProduct->sku}_{$idx}"
                            );

                            // Salva a imagem no repositorio
                            CatalogProductMediaRepository::updateProductMedia([
                                'media_id' => $catalogProductImage->media_id,
                                'product_id' => $catalogProduct->product_id,
                                'media_type' => $path['extension'],
                                'media_file' => $stored['1000x1000']['relative_path'],
                                'media_url' => $stored['1000x1000']['url'],
                                'sort_order' => $idx
                            ]);

                            // Deverá salvar no produto somente a primeira imagem, pois é a principal
                            if ($idx == 0) {

                                // Salva as imagens na tabela de produtos
                                CatalogProductsRepository::updateImageProduct(
                                    $catalogProduct->product_id,
                                    [
                                        'image' => $stored['255x255']['url'],
                                        'thumbnail' => $stored['80x80']['url']
                                    ]
                                );

                            }

                        }

                    }

                }

            }

        }

    }

    /**
     * Metodo que valida as imagens do produto e realiza os resizes
     * @param array $dataPost
     * @param \App\Models\CatalogProduct $catalogProduct
     * @return void
     * @throws \Exception
     */
    public static function processImages(array $dataPost, CatalogProduct $catalogProduct): void
    {

        // Exclui as imagens do produto
        CatalogProductMediaRepository::deleteImagesProduct(
            $catalogProduct->product_id
        );

        if (count($dataPost['product']['images']) > 0) {

            foreach ($dataPost['product']['images'] as $idx => $image) {

                // Diretório criado UMA ÚNICA VEZ
                $targetDir = MediaDownloader::createDir($catalogProduct->sku);

                // Realiza o download da Imagem
                $originalPath = MediaDownloader::getImage(
                    $image,
                    $catalogProduct->sku,
                    $idx
                );

                if (!$originalPath || !ImageValidator::isValid($originalPath)) {
                    // remove lixo
                    @unlink($originalPath);
                }

                // Resize das imagens
                $resized = ImageResizer::resize($originalPath);

                if (count($resized) > 0) {

                    // Salva as imagens no disco
                    $stored = ImageStorage::save(
                        images: $resized,
                        absoluteTargetDir: $targetDir,
                        baseName: "{$catalogProduct->sku}_{$idx}"
                    );

                    // Salva a imagem no repositorio
                    CatalogProductMediaRepository::create([
                        'product_id' => $catalogProduct->product_id,
                        'media_type' => 'jpg',
                        'media_file' => $stored['1000x1000']['relative_path'],
                        'media_url' => $stored['1000x1000']['url'],
                    ]);

                    // Deverá salvar no produto somente a primeira imagem, pois é a principal
                    if ($idx == 0) {

                        // Salva as imagens na tabela de produtos
                        CatalogProductsRepository::updateImageProduct(
                            $catalogProduct->product_id,
                            [
                                'image' => $stored['255x255']['url'],
                                'thumbnail' => $stored['80x80']['url']
                            ]
                        );

                    }

                }

            }

        }


    }

}
