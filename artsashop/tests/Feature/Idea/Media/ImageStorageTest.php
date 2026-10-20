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

namespace Tests\Feature\Idea\Media;

use Idea\Framework\Media\Download\MediaDownloader;
use Idea\Framework\Media\Processing\ImageResizer;
use Idea\Framework\Media\Storage\ImageStorage;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class ImageStorageTest extends TestCase
{

    public function testSaveImage(): void
    {

        // Arrange: Sku do produto a ser testado
        $productSku = 'ATSA80NG23I00C';

        // Arrange: Diretório criado para as imagens
        $targetDir = MediaDownloader::createDispersedPath($productSku);

        // Arrange: cria uma imagem JPEG em memória
        $image = imagecreatetruecolor(10, 10);

        ob_start();
        imagejpeg($image);
        $imageContent = ob_get_clean();

        imagedestroy($image);

        // Arrange: cria uma resposta HTTP falsa
        Http::fake([
            'https://example.com/*' => Http::response(
                $imageContent,
                200,
                ['Content-Type' => 'image/jpeg']
            ),
        ]);

        // Act: Retorna o caminho da imagem
        $imagePath = MediaDownloader::getImageDownloadedPath(
            imageLocation: 'https://example.com/test.jpg',
            productSku: $productSku,
            idx: 0
        );

        // Act: Redimensiona as imagens do produto
        $imagesSizes = ImageResizer::resize(
            $imagePath
        );

        // Act: Salva as imagens nos diretórios corretos
        $stored = ImageStorage::save(
            images: $imagesSizes,
            absoluteTargetDir: $targetDir,
            baseName: "{$productSku}_0"
        );

        dd($stored);



    }

}
