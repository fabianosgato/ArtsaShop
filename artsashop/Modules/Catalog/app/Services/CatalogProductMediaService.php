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

    public static function proccessImages(CatalogProduct $catalogProduct): void
    {

        // Retorna as imagens do produto
        $images = CatalogProductMediaRepository::getProductImages(
            productId: $catalogProduct->product_id
        );

        if ($images) {

            // Exclui as imagens atuais do produto
            CatalogProductMediaRepository::deleteImagesProduct(
                productId: $catalogProduct->product_id
            );

            foreach ($images as $idx => $image) {

                // Valida se as images existem no diretório
                if (Storage::disk('public')->exists($image->media_file)) {

                    // Retorna os dados da imagem
                    $mediaFile = Storage::disk('public')->path($image->media_file);

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

    }

    /**
     * Metodo que valida as imagens do produto e realiza os resizes
     * @param $dataPost
     * @param $productId
     * @return void
     * @throws \Exception
     */
    public static function processImages($dataPost, $productId): void
    {

        // Exclui as imagens do produto
        CatalogProductMediaRepository::deleteImagesProduct($productId);

        foreach ($dataPost['skus'] as $productSku) {

            if (count($productSku['images']) > 0) {

                foreach ($productSku['images'] as $idx => $image) {

                    // Diretório criado UMA ÚNICA VEZ
                    $targetDir = MediaDownloader::createDir($productSku['productSku']);

                    // Realiza o download da Imagem
                    $originalPath = MediaDownloader::getImage(
                        $image,
                        $productSku['productSku'],
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
                            baseName: "{$productSku['productSku']}_{$idx}"
                        );

                        // Salva a imagem no repositorio
                        CatalogProductMediaRepository::create([
                            'product_id' => $productId,
                            'media_type' => 'jpg',
                            'media_file' => $stored['1000x1000']['relative_path'],
                            'media_url' => $stored['1000x1000']['url'],
                        ]);

                        // Deverá salvar no produto somente a primeira imagem, pois é a principal
                        if ($idx == 0) {

                            // Salva as imagens na tabela de produtos
                            CatalogProductsRepository::updateImageProduct(
                                $productId,
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
