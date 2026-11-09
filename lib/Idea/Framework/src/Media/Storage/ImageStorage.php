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
namespace Idea\Framework\Media\Storage;

use Idea\Framework\Media\DTO\ImageListDTO;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Interfaces\ImageInterface;
use RuntimeException;

class ImageStorage
{

    /**
     * Converte path absoluto em path público relativo
     */
    private static function toPublicPath(string $absolutePath): string
    {
        $publicRoot = Storage::disk('public')->path('');

        return ltrim(
            str_replace($publicRoot, '', $absolutePath),
            DIRECTORY_SEPARATOR
        );
    }

    /**
     * Salva as imagens redimensionadas no diretório já criado
     *
     * @param array<string, ImageInterface> $images
     * @param string $absoluteTargetDir
     * @param string $baseName
     * @param string $extension
     *
     * @return array<string, ImageListDTO>
     */
    public static function save(
        array $images,
        string $absoluteTargetDir,
        string $baseName,
        string $extension = 'webp'
    ): array {

        if (empty($images)) {
            throw new RuntimeException('Nenhuma imagem para salvar.');
        }

        if (!is_dir($absoluteTargetDir)) {
            throw new RuntimeException('Diretório de destino inválido.');
        }

        $disk = Storage::disk('public');
        $savedImages = [];

        foreach ($images as $size => $image) {
            if (!$image instanceof ImageInterface) {
                continue;
            }

            $fileName = "{$baseName}_{$size}.{$extension}";
            $absolutePath = rtrim($absoluteTargetDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $fileName;

            // Intervention Image v4 - encode para WebP com qualidade
            $image->toWebp(quality: 80)->save($absolutePath);

            // Converte para path público relativo
            $relativePath = self::toPublicPath($absolutePath);

            $savedImages[$size] = new ImageListDTO(
                $absolutePath,
                $relativePath,
                $disk->url($relativePath)
            );
        }

        return $savedImages;
    }


}