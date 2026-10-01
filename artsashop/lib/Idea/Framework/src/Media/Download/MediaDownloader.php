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
namespace Idea\Framework\Media\Download;

use Idea\Framework\Utils;
use Illuminate\Support\Facades\Storage;

class MediaDownloader
{

    /**
     * Realiza o download da Imagem do Produto
     */
    private static function grabImage(string $url): bool|string
    {

        $ch = curl_init($url);

        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 3600);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)');

        // Retorna a Imagem
        $raw = curl_exec($ch);

        // Valida se houve erro ao buscar a imagem
        $errno = curl_errno($ch);
        curl_close($ch);

        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $contentType = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);

        if (
            $errno ||
            $httpCode !== 200 ||
            empty($raw) ||
            strpos($contentType, 'image/') !== 0
        ) {
            curl_close($ch);
            return false;
        }

        return $raw;

    }

    /**
     * Metodo que cria o diretório pelo ASIN
     * @param $productSku
     * @return bool|string
     */
    public static function createDir($productSku): bool|string
    {

        // Caminho completo das imagens do catálogo
        $dirImages = Storage::disk('public')->path('media');

        if ($productSku != '') {

            // Remove do ASIN os caracteres que não podem subir
            $productSku = Utils::clearSku($productSku);

            if ($productSku) {

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
     * Método que apenas retorna a imagem do sistema
     * @param $imageUrl
     * @param $productSku
     * @param $idx
     * @param string $tmpDir
     * @param int $attempt
     * @param int $maxAttempts
     * @return bool|string
     * @throws \Exception
     */
    public static function getImage($imageUrl, $productSku, $idx, string $tmpDir = 'import', int $attempt = 1, int $maxAttempts = 3): bool|string
    {

        if ($imageUrl != '') {

            if (Storage::disk('public')->exists($imageUrl)) {
                // Retorna o conteúdo da imagem vindo localmente
                $remoteImageRaw = Storage::disk('public')->get($imageUrl);
            } else {
                // Retorna o conteúdo da imagem vinda de URL
                $remoteImageRaw = self::grabImage($imageUrl);
            }

            // Retorna a imagem
            if ($remoteImageRaw) {

                // Cria o diretório da imagem atual da imagem
                $imageDir = self::createDir($productSku);

                // Valida se o diretório foi criado com sucesso
                if ($imageDir) {

                    // Extensao da imagem
                    $extension = self::getExtension($imageUrl);

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
                if ($attempt < $maxAttempts) {
                    return self::getImage($imageUrl, $productSku, $idx, $tmpDir, $attempt + 1, $maxAttempts);
                }

                return false;

            }

        }

        return false;

    }

}
