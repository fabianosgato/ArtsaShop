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
declare(strict_types=1);

namespace Idea\Framework\Repository\System;

use App\Models\SysConfigDatum;
use Idea\Framework\Repository\AbstractRepository;
use Idea\Framework\Services\ServiceCache;

class SysConfigRepository extends AbstractRepository
{

    protected static $model = SysConfigDatum::class;

    /**
     * Retorna as configurações gerais do sistema (com cache)
     * @return array
     */
    public static function getConfigs(): array
    {
        return app(ServiceCache::class)->remember(
            cacheKey: 'sys_config_all',
            tags: ['store_host'],  // expire_in: 0 = eterno (config/idea.php)
            closure: function () {
                $systemConfigs = [];
                foreach (self::loadModel()::all() as $config) {
                    $systemConfigs[$config->path] = $config->value;
                }
                return $systemConfigs;
            }
        );
    }

    /**
     * Invalida o cache de configurações (chamar após insert/update/delete)
     * @return void
     */
    public static function forgetCache(): void
    {
        app(ServiceCache::class)->forgetByKey('sys_config_all');
    }

}
