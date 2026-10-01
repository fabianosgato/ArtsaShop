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
use Idea\Framework\Repository\System\SysModuleRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SysModulesController extends AdminController
{

    public function index()
    {
        return view('wsdadm.partials.grids', ['componentName' => 'system::grids.sys-module-grid']);
    }

    public function insert()
    {
        // Retorna a View
        return view('wsdadm.partials.forms', [
            'componentName' => 'system::form.sys-module-form',
            'data' => []
        ]);

    }

    public function edit($id)
    {
        // Retorna a View
        return view('wsdadm.partials.forms', [
            'componentName' => 'system::form.sys-module-form',
            'data' => SysModuleRepository::find($id)->toArray()
        ]);

    }

    public function save(Request $request): RedirectResponse
    {
        // Retorna os dados do POST
        $postData = $request->post();

        if ($postData['_token']) {
            unset($postData['_token']);

            if (!empty($postData['module_id'])) {
                SysModuleRepository::update($postData['module_id'], $postData);
                Session::flash('success', 'Móodulo atualizado com sucesso!');
            } else {
                SysModuleRepository::create($postData);
                Session::flash('success', 'Modulo criado com sucesso!');
            }

        } else
            Session::flash('error', 'Voce nao tem permissao ao acessar esses dados');

        // Redireciona para a listagem padrao
        return redirect()->route('sysmodules.index');

    }

}
