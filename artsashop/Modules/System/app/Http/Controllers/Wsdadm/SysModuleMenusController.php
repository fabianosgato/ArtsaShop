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
use Idea\Framework\Repository\System\SysModuleMenuRepository;
use Idea\Framework\Repository\System\SysModuleRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;

class SysModuleMenusController extends AdminController
{

    /**
     * Display a listing of the resource.
     */
    public function index($moduleId)
    {

        if ($moduleId) {

            // Retorna o Modulo do Menu de Acesso
            $module = SysModuleRepository::find($moduleId);

            View::share('actionInsert', route(
                name:'wsdadm.sysmenu.insert',
                parameters:[
                    'moduleId' => $module->module_id
                ]
            ));

            return view('system::sysmodulemenus.grid', [
                'moduleId' => $module->module_id,
                'moduleName' => $module->module_name,
            ]);

        }

        Session::flash('error', 'Modulo não foi definido!');

        return redirect('/admin/sysmodules');

    }

    /**
     * Show the form for creating a new resource.
     */
    public function insert($moduleId)
    {
        return view('wsdadm.partials.forms', [
            'componentName' => 'system::form.sys-module-menu-form',
            'data' => [
                'module_id' => $moduleId
            ],
            'params' => [
                'moduleId' => $moduleId,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($moduleId, $id)
    {

        // Busca pelo registro
        $sysModuleMenu = SysModuleMenuRepository::find($id)->toArray();

        View::share('moduleId', $moduleId);

        return view('wsdadm.partials.forms', [
            'componentName' => 'system::form.sys-module-menu-form',
            'data' => $sysModuleMenu,
            'params' => [
                'moduleId' => $moduleId,
            ],
        ]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function save(Request $request): RedirectResponse
    {

        // Retorna os dados do POST
        $postData = $request->post();

        if ($postData['_token']) {
            unset($postData['_token']);

            if (!empty($postData['module_menu_id'])) {
                SysModuleMenuRepository::update($postData['module_menu_id'], $postData);
                Session::flash('success', 'Menu atualizado com sucesso!');

            } else {
                SysModuleMenuRepository::create($postData);
                Session::flash('success', 'Menu criado com sucesso!');
            }

        } else
            Session::flash('error', 'Voce nao tem permissao ao acessar esses dados');

        // Redireciona para o grid de menus
        return redirect()->to('/admin/sysmenus?module_id='.$postData['module_id']);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
