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
