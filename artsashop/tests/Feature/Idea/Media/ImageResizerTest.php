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
use Illuminate\Support\Facades\Http;
use Intervention\Image\Image;
use Tests\TestCase;

class ImageResizerTest extends TestCase
{

    public function testResizeGeneratesAllImageSizes(): void
    {

        // Arrange: Sku do produto a ser testado
        $productSku = 'ATSA80NG23I00C';

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

        // Assert: Valida se o retorno é um array
        $this->assertIsArray($imagesSizes);

        // Assert: Valida se o retorno possui os cinco tamanhos de imagens
        $this->assertCount(5, $imagesSizes);

        // Assert: Valida que TODOS os valores desse array são instâncias de Intervention\Image\Image
        $this->assertContainsOnlyInstancesOf(Image::class, array_values($imagesSizes));

    }

    public function testResizeReturnsEmptyArrayWhenImageDoesNotExist(): void
    {
        // Arrange: caminho de uma imagem que não existe
        $imagePath = storage_path('media/image-does-not-exist.jpg');

        // Act: tenta redimensionar a imagem
        $imagesSizes = ImageResizer::resize($imagePath);

        // Assert: retorna um array vazio
        $this->assertSame([], $imagesSizes);
    }

}
