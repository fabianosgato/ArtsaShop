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
