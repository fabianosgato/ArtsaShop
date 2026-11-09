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
namespace Idea\Framework\Media\Processing;

use Intervention\Image\Drivers\Imagick\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Interfaces\ImageInterface;

class ImageResizer
{

    /**
     * Gera as imagens redimensionadas e retorna um array com cada uma
     * Lê o arquivo original UMA vez para eficiência
     *
     * @param string $originalImagePath
     * @return array<string, ImageInterface>
     * @throws \Intervention\Image\Exceptions\InvalidArgumentException
     */
    public static function resize(string $originalImagePath): array
    {
        if (!file_exists($originalImagePath)) {
            return [];
        }

        $manager = new ImageManager(new Driver());
        $generatedImages = [];

        // Lê o arquivo original UMA vez
        $originalImage = $manager->read($originalImagePath);

        // Remove metadata EXIF/ICC (via Imagick)
        if ($originalImage->core() instanceof \Imagick) {
            $originalImage->core()->stripImage();
        }

        foreach (config('idea.images.images_sizes') as $label => [$width, $height]) {
            // Clona a imagem original para não modificar a base
            $image = $originalImage->clone();

            // Resize inteligente (mantém aspect ratio, não aumenta)
            $image->scaleDown(width: $width, height: $height);

            // Canvas fixo com fundo branco
            $image->pad($width, $height, 'ffffff');

            // Sharpen leve
            $image->sharpen(10);

            $generatedImages[$label] = $image;
        }

        return $generatedImages;
    }

}
