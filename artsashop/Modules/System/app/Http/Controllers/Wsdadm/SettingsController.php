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
namespace Modules\System\Http\Controllers\Wsdadm;

use Idea\Framework\Admin\AdminController;
use Idea\Framework\Repository\System\SysConfigRespository;

class SettingsController extends AdminController
{

    /**
     * Exibe as configurações do sistema.
     */
    public function index()
    {

        // Retorna as configurações do sistema
        $sysConfig = SysConfigRespository::getConfigs();

        return view('wsdadm.partials.forms', [
            'componentName' => 'system::form.sys-config-form',
            'data' => $sysConfig
        ]);

    }


}
