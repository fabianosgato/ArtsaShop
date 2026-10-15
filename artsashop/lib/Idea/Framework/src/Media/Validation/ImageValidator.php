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
namespace Idea\Framework\Media\Validation;

class ImageValidator
{
    /**
     * MIME types permitidos
     */
    private const ALLOWED_MIME_TYPES = [
        'image/jpeg',
        'image/png',
        'image/webp',
        'image/gif',
    ];

    /**
     * Valida se o arquivo é uma imagem válida
     *
     * @param string $filePath
     * @return bool
     */
    public static function isValid(string $filePath): bool
    {
        // Arquivo existe?
        if (!file_exists($filePath) || !is_file($filePath)) {
            return false;
        }

        // Arquivo vazio?
        if (filesize($filePath) === 0) {
            return false;
        }

        // Verifica se o PHP consegue ler a imagem
        $imageInfo = @getimagesize($filePath);
        if ($imageInfo === false) {
            return false;
        }

        // MIME real detectado pelo PHP
        $mimeType = $imageInfo['mime'] ?? null;

        if (!$mimeType || !in_array($mimeType, self::ALLOWED_MIME_TYPES, true)) {
            return false;
        }

        return true;
    }

    /**
     * Retorna o MIME type real da imagem
     *
     * @param string $filePath
     * @return string|null
     */
    public static function getMimeType(string $filePath): ?string
    {
        $imageInfo = @getimagesize($filePath);
        return $imageInfo['mime'] ?? null;
    }

    /**
     * Retorna largura e altura da imagem
     *
     * @param string $filePath
     * @return array|null
     */
    public static function getDimensions(string $filePath): ?array
    {
        $imageInfo = @getimagesize($filePath);

        if ($imageInfo === false) {
            return null;
        }

        return [
            'width'  => $imageInfo[0],
            'height' => $imageInfo[1],
        ];
    }
}
