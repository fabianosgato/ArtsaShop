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

class ImageResizer
{

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

        foreach (config('idea.images.images_sizes') as $label => [$width, $height]) {

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
