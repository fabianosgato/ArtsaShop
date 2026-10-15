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
namespace Idea\Framework\Concerns;

use Idea\Framework\Repository\System\SysConfigRespository;

trait SysConfigApplication
{

    public function getConfig(string $path)
    {

        // Retorna todas as configurações do sistema
        $sysConfig = SysConfigRespository::getConfigs();

        if (!empty($sysConfig[$path]))
            return $sysConfig[$path];

        return null;

    }

}
