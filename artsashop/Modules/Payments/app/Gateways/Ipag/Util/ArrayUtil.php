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

namespace Modules\Payments\Gateways\Ipag\Util;

abstract class ArrayUtil
{
    public const string ACCESS_SEPARATOR = '.';

    public static function get(string $path, array $array, $default = null)
    {
        $splitPath = explode(self::ACCESS_SEPARATOR, $path);

        while (is_array($array) && ($key = array_shift($splitPath))) {
            if (array_key_exists($key, $array)) {
                $array = &$array[$key];
            } else {
                $array = null;
            }
        }

        return is_null($array) || !empty($splitPath) ? $default : $array;
    }

    public static function set(string $path, array &$array, $value = null): void
    {
        $splitPath = explode(self::ACCESS_SEPARATOR, $path);

        while (is_array($array) && ($key = array_shift($splitPath))) {
            if (!$splitPath) {
                $array[$key] = $value;
            } else {
                if (!array_key_exists($key, $array) || !is_array($array[$key])) {
                    $array[$key] = [];
                }
                $array = &$array[$key];
            }
        }
    }

    /**
     * Retorna um novo array de strings dentro do array informado.
     *
     * @param array $data
     * @return array
     */
    public static function extractStrings(array $data): array
    {
        return array_reduce($data, function ($strings, $value) {
            if (is_array($value)) {
                return array_merge($strings, self::extractStrings($value));
            } elseif (is_string($value) && !is_numeric($value)) {
                $strings[] = $value;
            }
            return $strings;
        }, []);
    }

}
