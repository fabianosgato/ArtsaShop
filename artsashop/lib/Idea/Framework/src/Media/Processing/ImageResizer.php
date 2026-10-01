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

namespace Idea\Framework\Media\Processing;

use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;

class ImageResizer
{
    /**
     * Tamanhos padrão das imagens
     */
    private const SIZES = [
        '1000x1000' => [1000, 1000],    // Imagem grande do produto
        '454x454' => [383, 383],      // Imagem na página do produto
        '300x300' => [300, 300],      // Imagem de compartilhamento (WhatsApp)
        '255x255' => [215, 215],      // Listagem do produtos
        '80x80' => [80, 80],        // Thubnails do produto
    ];

    /**
     * Gera as imagens redimensionadas e retorna um array com cada uma
     *
     * @param string $originalImagePath
     * @return array
     */
    public static function resize(string $originalImagePath): array
    {
        if (!file_exists($originalImagePath)) {
            return [];
        }

        $manager = new ImageManager(new Driver());
        $generatedImages = [];

        foreach (self::SIZES as $label => [$width, $height]) {

            $image = $manager->read($originalImagePath);

            // REMOVE METADATA REAL (via Imagick)
            $imagick = $image->core()->native();
            $imagick->stripImage();

            // Resize inteligente
            $image->scaleDown(width: $width, height: $height);

            // Canvas fixo
            $image->pad($width, $height, 'ffffff');

            // Sharpen leve
            $image->sharpen(10);

            $generatedImages[$label] = $image;

        }

        return $generatedImages;
    }

}
