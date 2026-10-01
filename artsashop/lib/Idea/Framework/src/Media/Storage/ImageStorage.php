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
namespace Idea\Framework\Media\Storage;

use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use RuntimeException;

class ImageStorage
{
    /**
     * Salva as imagens redimensionadas no diretório já criado
     *
     * @param array  $images              Array retornado pelo ImageResizer
     * @param string $absoluteTargetDir   Diretório absoluto gerado pelo MediaDownloader
     * @param string $baseName            Nome base do arquivo
     * @param string $extension
     *
     * @return array
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

            if (!$image instanceof Image) {
                continue;
            }

            $fileName = "{$baseName}_{$size}.{$extension}";
            $absolutePath = rtrim($absoluteTargetDir, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $fileName;

            // Salva a imagem para WebP
            $image->toWebp(80)->save($absolutePath);

            // Converte para path público relativo
            $relativePath = self::toPublicPath($absolutePath);

            $savedImages[$size] = [
                'path'          => $absolutePath,
                'relative_path' => $relativePath,
                'url'           => $disk->url($relativePath),
            ];
        }

        return $savedImages;
    }

    /**
     * Converte path absoluto em path público relativo
     */
    public static function toPublicPath(string $absolutePath): string
    {
        $publicRoot = Storage::disk('public')->path('');

        return ltrim(
            str_replace($publicRoot, '', $absolutePath),
            DIRECTORY_SEPARATOR
        );
    }
}
