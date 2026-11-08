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
use Tests\TestCase;

class MediaDownloaderIntegrationTest extends TestCase
{

    public function testDownloadInternetImageIsRaw(): void
    {
        // Arrange: URL de teste para download da imagem
        $image = 'https://fastly.picsum.photos/id/448/200/300.jpg?hmac=9a1pqR60H2xWN80jPWfmdVkRII-wEQZceiSHpJSZnE4';

        // Act:
        $rawImage = MediaDownloader::downloadRawImage($image);

        // Assert: valida se o download foi realizado
        $this->assertNotFalse($rawImage);

        // Cria um buffer de informações de arquivo
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($rawImage);

        // Assert: valida se o MIME type é uma imagem
        $this->assertStringStartsWith('image/', $mimeType);

    }

}
