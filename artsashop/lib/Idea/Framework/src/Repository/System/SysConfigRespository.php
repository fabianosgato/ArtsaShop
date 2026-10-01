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
declare(strict_types=1);

namespace Idea\Framework\Repository\System;

use App\Models\SysConfigDatum;
use Idea\Framework\Repository\AbstractRepository;
use Illuminate\Support\Facades\Cache;

class SysConfigRespository extends AbstractRepository
{

    protected static $model = SysConfigDatum::class;

    /**
     * Retorna uma configuração especifica
     * @param $path
     * @return mixed|null
     */
    public function getConfig($path)
    {
        $configs = self::getConfigs();
        if (in_array($path, $configs)) {
            return $configs[$path];
        }
        return null;
    }

    /**
     * Retorna as configurações gerais do sistema
     * @return array
     */
    public static function getConfigs(): array
    {

        // Retorna a configuração do sistema que está no cache
        return Cache::rememberForever('idea.sysconfig', function () {

            // Inicializa o array de configuração do sistema
            $systemConfigs = [];

            // Cria o array com as configurações gerais do sistema
            foreach (self::loadModel()::all() as $config) {
                $systemConfigs[$config->path] = $config->value;
            }

            return $systemConfigs;

        });

    }

}
