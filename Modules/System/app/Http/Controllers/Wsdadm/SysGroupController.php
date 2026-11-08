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
use Idea\Framework\Repository\System\SysGroupRepository;
use Illuminate\Support\Facades\Session;

class SysGroupController extends AdminController
{

    public function index()
    {
        return view('wsdadm.partials.grids', [
            'componentName' => 'system::grids.sys-group-grid'
        ]);
    }

    public function insert()
    {
        return view('wsdadm.partials.forms', [
            'componentName' => 'system::form.sys-group-form',
            'data' => []
        ]);
    }

    public function edit($id)
    {

        if (!empty($id)) {
            // Seleciona o grupo de usuarios
            $sysGroup = SysGroupRepository::find($id)->toArray();

            return view('wsdadm.partials.forms', [
                'componentName' => 'system::form.sys-group-form',
                'data' => $sysGroup
            ]);

        }

        Session::flash('error', 'Grupo não definido ou não existe mais');

        return redirect()->route('wsdadm.sysgroups');

    }

}
