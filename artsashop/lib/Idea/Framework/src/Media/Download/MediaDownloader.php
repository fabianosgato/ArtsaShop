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
namespace Idea\Framework\Media\Download;

use Idea\Framework\Utils;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MediaDownloader
{

    /**
     * Realiza o download da Imagem de um Produto
     */
    public static function downloadRawImage(string $url): bool|string
    {
        $response = Http::withHeaders([
            'user-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 Chrome/140.0.0.0 Safari/537.36',
            'dnt' => '1',
            'upgrade-insecure-requests' => '1',
            'accept' => 'image/avif,image/webp,image/apng,image/svg+xml,image/*,*/*;q=0.8',
            'sec-fetch-site' => 'same-origin',
            'sec-fetch-mode' => 'navigate',
            'sec-fetch-user' => '?1',
            'sec-fetch-dest' => 'document',
            'referer' => 'https://google.com/'
        ])
            ->timeout(30)
            ->retry(3, 100, throw: false)
            ->get($url);

        if (
            ! $response->successful() ||
            empty($response->body()) ||
            ! str_starts_with(
                strtolower($response->header('Content-Type') ?? ''),
                'image/'
            )
        ) {
            return false;
        }

        return $response->body();
    }

    /**
     * Metodo que cria o diretório pelo SKU do produto
     * @param $productSku
     * @return bool|string
     */
    public static function createDispersedPath($productSku): bool|string
    {

        // Caminho completo das imagens do catálogo
        $dirImages = Storage::disk('public')->path('media');

        // Remove do SKU os caracteres indevidos
        $productSku = Utils::clearSku($productSku);

        // Valida se o SKU do produto não esteja vazio
        if ($productSku != '') {

            // Retorna a primeira letra do ASIN para a criação do diretório
            $fistLetter = substr($productSku, 0, 5);

            // Cria o diretorio de imagens
            if (!is_dir($dirImages . DIRECTORY_SEPARATOR . $fistLetter)) {
                mkdir($dirImages . DIRECTORY_SEPARATOR . $fistLetter, 0777, true);
            }

            // Retorna a primeira letra do ASIN para a criação do diretório
            $secondLetter = substr($productSku, 5, 2);

            // Cria o diretorio de imagens
            if (!is_dir($dirImages . DIRECTORY_SEPARATOR . $fistLetter . DIRECTORY_SEPARATOR . $secondLetter)) {
                mkdir($dirImages . DIRECTORY_SEPARATOR . $fistLetter . DIRECTORY_SEPARATOR . $secondLetter, 0777, true);
            }

            // Retorna o caminho completo do diretorio
            return $dirImages . DIRECTORY_SEPARATOR . $fistLetter . DIRECTORY_SEPARATOR . $secondLetter . DIRECTORY_SEPARATOR;

        } else {
            return false;

        }

    }

    /**
     * Retorna a extensao da imagem
     * @param string $urlImage
     * @return mixed
     */
    private static function getExtension(string $urlImage): string
    {
        $path = parse_url($urlImage, PHP_URL_PATH);
        $ext = pathinfo($path, PATHINFO_EXTENSION);

        return $ext ?: 'jpg';
    }

    /**
     * Método que retorna a imagem do produto
     * @param string $imageLocation
     * @param string $productSku
     * @param int $idx
     * @return bool|string
     */
    public static function getImageDownloadedPath(
        string $imageLocation,
        string $productSku,
        int    $idx): bool|string
    {


        if ($imageLocation != '') {

            // Valida se o local da imagem é uma URL
            if (Str::isUrl($imageLocation)) {
                // Retorna o conteúdo da imagem vinda de URL
                $remoteImageRaw = self::downloadRawImage($imageLocation);

            } else if (Storage::disk('public')->exists($imageLocation)) {
                // Retorna o conteúdo da imagem vindo localmente
                $remoteImageRaw = Storage::disk('public')->get($imageLocation);

            } else {
                // Inicializa a variável
                $remoteImageRaw = false;

            }

            // Retorna a imagem
            if ($remoteImageRaw) {

                // Cria o diretório da imagem atual da imagem
                $imageDir = self::createDispersedPath($productSku);

                // Valida se o diretório foi criado com sucesso
                if ($imageDir) {

                    // Extensao da imagem
                    $extension = self::getExtension($imageLocation);

                    // Caminho da imagem a ser criada
                    $imagemMedia = $imageDir . "{$productSku}_$idx.$extension";

                    // Deleta o arquivo se existe no diretório
                    if (file_exists($imagemMedia)) {
                        @unlink($imagemMedia);
                    }

                    if (file_put_contents($imagemMedia, $remoteImageRaw) === false) {
                        return false;
                    }

                    // Seta a permissao da imagem
                    @chmod($imagemMedia, 0644);

                    return $imagemMedia;

                } else {
                    return false;

                }

            } else {
                return false;

            }

        }

        return false;

    }

}
