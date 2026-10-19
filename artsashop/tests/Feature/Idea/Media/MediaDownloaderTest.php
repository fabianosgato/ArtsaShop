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

class MediaDownloaderTest extends TestCase
{

    public function testDownloadImageIsRaw(): void
    {

        // Arrange: Url de teste para download da imagem
        $image ="https://fastly.picsum.photos/id/448/200/300.jpg?hmac=9a1pqR60H2xWN80jPWfmdVkRII-wEQZceiSHpJSZnE4";

        // Act:
        $rawImage = MediaDownloader::downloadRawImage($image);

        // Cria um buffer de informações de arquivo
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($rawImage);

        // Asset: Valida se o MIME type começa com 'image/' (ex: image/jpeg, image/png)
        $this->assertStringStartsWith('image/', $mimeType);

    }

    public function testDownloadImageIsFalse(): void
    {

        // Arrange: Url incorreta para o download da imagem
        $image ="https://fastly.picsum.photos/id/448/200/3003.jpg?hmac=9a1pqR60H2xWN80jPWfmdVkRII-wEQZceiSHpJSZnE4";

        // Act:
        $rawImage = MediaDownloader::downloadRawImage($image);

        // Asset: Valida se o MIME type começa com 'image/' (ex: image/jpeg, image/png)
        $this->assertIsBool($rawImage);

    }

    public function testCreateDispersedPath(): void
    {



    }



}
