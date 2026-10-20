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
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class MediaDownloaderTest extends TestCase
{

    public function testDownloadImageIsRaw(): void
    {

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

        // Act
        $rawImage = MediaDownloader::downloadRawImage(
            'https://example.com/test.jpg'
        );

        // Assert
        $this->assertNotFalse($rawImage);

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($rawImage);

        $this->assertStringStartsWith('image/', $mimeType);

    }

    public function testDownloadImageIsFalse(): void
    {
        Http::fake([
            'https://example.com/*' => Http::response('', 404),
        ]);

        $rawImage = MediaDownloader::downloadRawImage(
            'https://example.com/test.jpg'
        );

        $this->assertFalse($rawImage);
    }

    public function testDownloadImageSendsBrowserHeaders(): void
    {
        // Arrange: cria uma imagem JPEG em memória
        $image = imagecreatetruecolor(10, 10);

        ob_start();
        imagejpeg($image);
        $imageContent = ob_get_clean();

        imagedestroy($image);

        Http::fake([
            'https://example.com/*' => Http::response(
                $imageContent,
                200,
                ['Content-Type' => 'image/jpeg']
            ),
        ]);

        // Act
        MediaDownloader::downloadRawImage(
            'https://example.com/test.jpg'
        );

        // Assert
        Http::assertSent(function (Request $request) {
            return $request->hasHeader(
                'User-Agent',
                'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/140.0.0.0 Safari/537.36'
            ) && $request->hasHeader(
                'accept',
                'image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8'
            );
        });

    }

    public function testCreateDispersedPath(): void
    {

        // Arrange: SKU de teste de um produto qualquer
        $productSku = 'B6766ks-3';

        // Act: Chama o metodo para criar o diretório do produto
        $dispersedPath = MediaDownloader::createDispersedPath($productSku);

        // Asset: Valida se retornou uma string
        $this->assertIsString($dispersedPath);

        // Asset: Valida se retornou uma string
        $this->assertDirectoryExists(
            $dispersedPath
        );

    }

    public function testCreateDispersedPathIsFalse(): void
    {

        // Arrange: SKU de teste de um produto qualquer
        $productSku = ';/%-%&';

        // Act: Cria o diretório do produto
        $dispersedPath = MediaDownloader::createDispersedPath($productSku);

        // Asset: Valida se não retornou uma string
        $this->assertIsNotString($dispersedPath);

        // Asset: Valida se retornou um bool
        $this->assertIsBool(
            $dispersedPath
        );

    }

    public function testSuccessGetImageFromLocalDir()
    {

        // Arrange: SKU de teste de um produto qualquer
        $imageUrl = 'imports/ATSA80NG23I00B_0.jpg';
        $productSku = 'ATSA80NG23I00B';

        // Act
        $imagePath = MediaDownloader::getImageDownloadedPath(
            imageLocation: $imageUrl,
            productSku: $productSku,
            idx: 0
        );

        // Assert: o método deve retornar o caminho do arquivo criado.
        $this->assertIsString($imagePath);

        // Assert: Valida se a imagem foi criada no diretorio
        $this->assertTrue(File::exists($imagePath));

        // Assert: Valida se a imagem foi criada corretamente
        $this->assertStringEndsWith(
            'ATSA80NG23I00B_0.jpg',
            $imagePath
        );

        // Assert: Valida se a imagem é realmente uma imagem verdadeira
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($imagePath);
        $this->assertStringStartsWith('image/', $mimeType);

        // Assert: valida a extensão da imagem
        $this->assertSame(
            'jpg',
            pathinfo($imagePath, PATHINFO_EXTENSION)
        );

    }

    public function testErrorGetImageFromLocalDir()
    {

        // Arrange: Arquivo inexistente no storage
        $imageUrl = 'imports/ATSA80NG23I00B_1.jpg';
        // Sku do produto a ser testado
        $productSku = 'ATSA80NG23I00B';

        // Act: Retorna o caminho da imagem
        $imagePath = MediaDownloader::getImageDownloadedPath(
            imageLocation: $imageUrl,
            productSku: $productSku,
            idx: 0
        );

        // Assert: o método deve retornar False quando a imagem não existe
        $this->assertFalse($imagePath);

        // Assert: o método não deve retornar o caminho do arquivo criado.
        $this->assertIsNotString($imagePath);

    }

    public function testGetImagePermissionFile()
    {

    }

    public function testSuccessGetImageFromRemote()
    {

    }

    public function testErrorGetImageFromRemote()
    {

    }

    public function testGetImageWithEmptyUrl()
    {

    }

    public function testErrorGetImageWhenFileCannotBeWritten()
    {

    }

    public function testGetImageReplaceExistingFile()
    {

    }


}
