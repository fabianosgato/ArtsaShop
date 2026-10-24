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

class SysConfigRespository extends AbstractRepository
{

    protected static $model = SysConfigDatum::class;

    /**
     * Retorna as configurações gerais do sistema
     * @return array
     */
    public static function getConfigs(): array
    {

        // Inicializa o array de configuração do sistema
        $systemConfigs = [];

        // Cria o array com as configurações gerais do sistema
        foreach (self::loadModel()::all() as $config) {
            $systemConfigs[$config->path] = $config->value;
        }

        return $systemConfigs;

    }

}
