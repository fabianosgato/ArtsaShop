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
namespace Idea\Framework;

use Throwable;

class Utils
{

    /**
     * Função helper local para formatar exceptions da API
     */
    public static function formatApiExceptionData(Throwable $exception, $message): array
    {
        if (config('app.debug')) {
            return [
                'type' => class_basename($exception),
                'message' => $message,
                'file' => $exception->getFile(),
                'line' => $exception->getLine(),
                'trace' => collect($exception->getTrace())->take(5),
            ];
        }

        return [
            'message' => is_array($message)
                ? $message
                : [$message],
        ];
    }



    /**
     * Metodo usado para Limpar espaços em branco dos registros do CSV
     * @param array $array
     * @return mixed
     */
    public static function trimArray(array $array): array
    {

        $trimmedArray = [];

        foreach ($array as $key => $value) {
            // Faz trim na chave se for string
            $trimmedKey = is_string($key) ? trim($key) : $key;

            if (is_array($value)) {
                // Se o valor for um array, chama recursivamente
                $trimmedArray[$trimmedKey] = self::trimArray($value);
            } elseif (is_string($value)) {
                // Faz trim no valor se for string
                $trimmedArray[$trimmedKey] = trim($value);
            } else {
                // Caso o valor não seja string, mantém o valor original
                $trimmedArray[$trimmedKey] = $value;
            }
        }

        return $trimmedArray;

    }

    /**
     * Faz o arredondamento dos valores
     * @param $value
     * @param int $precision
     * @return number
     */
    public static function roundUp($value, int $precision = 2): float
    {

        $value = (float)$value;
        $precision = (int)$precision;

        if ($precision < 0) {
            $precision = 0;
        }

        $decPointPosition = strpos($value, '.');
        if ($decPointPosition === false) {
            return $value;
        }

        $floorValue = (float)(substr($value, 0, $decPointPosition + $precision + 1));
        $followingDecimals = (int)substr($value, $decPointPosition + $precision + 1);

        if ($followingDecimals) {
            $ceilValue = $floorValue + pow(10, -$precision); // does this give always right result?
        } else {
            $ceilValue = $floorValue;
        }

        return $ceilValue;
    }

    /**
     * Limpa o SKU do produto removendo caracteres que não pode ser enviados
     * @param $asin
     * @return string
     */
    public static function clearSku($productSku): string
    {
        $productSku = preg_replace("/[^A-Za-z0-9.!? ]/", "", $productSku);
        $productSku = preg_replace("/[^A-Za-z0-9.!?\s]/", "", $productSku);
        $productSku = preg_replace("/[^A-Za-z0-9.!?[:space:]]/", "", $productSku);
        return str_replace(".", "", $productSku);
    }

    /**
     * Metodo que formata o CPF/CNPJ de um cliente
     * @param $value
     * @return string
     */
    public static function formatCustomerDocument($value): string
    {

        $CPF_LENGTH = 11;
        $cnpj_cpf = preg_replace("/\D/", '', $value);

        if (strlen($cnpj_cpf) === $CPF_LENGTH) {
            return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1\$2\$3-\$4", $cnpj_cpf);
        }

        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1\$2\$3/\$4-\$5", $cnpj_cpf);

    }

    /**
     * Calcula o peso cubado (peso volumétrico) de um produto
     *
     * @param float $height Altura em cm
     * @param float $width Largura em cm
     * @param float $length Comprimento em cm
     * @param int $factor Fator de cubagem (padrão: 6000)
     * @return float Peso cubado em kg
     */
    public static function calculateCubedWeight(float $height, float $width, float $length, int $factor = 6000): float
    {
        $volume = $height * $width * $length; // cm³
        $cubedWeight = $volume / $factor;    // kg
        return self::roundUp($cubedWeight);       // arredonda para 2 casas decimais
    }


}
