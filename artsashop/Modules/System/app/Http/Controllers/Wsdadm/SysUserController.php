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
use Idea\Framework\Repository\System\SysUserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class SysUserController extends AdminController
{

    public function index()
    {
        return view('wsdadm.partials.grids', ['componentName' => 'system::grids.sys-user-grid']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Seleciona o usuario
        $sysUser = SysUserRepository::find($id)->toArray();

        if ($sysUser) {
            // Retorna a View
            return view('wsdadm.partials.forms', [
                'componentName' => 'system::form.sys-user-form',
                'data' => $sysUser
            ]);

        }
    }

    public function insert()
    {
        return view('wsdadm.partials.forms', [
            'componentName' => 'system::form.sys-user-form',
            'data' => []
        ]);
    }

    public function save(Request $request)
    {

        // Retorna os dados do POST
        $postData = $request->post();

        if ($postData['_token']) {
            unset($postData['_token']);

            if ($postData['password'] == '') {
                unset($postData['password']);
            } else {
                $postData['password'] = Hash::make($postData['password']);
            }

            if (!empty($postData['user_id'])) {

                // Atualiza os dados do usuario
                SysUserRepository::update($postData['user_id'], $postData);

                Session::flash('success', 'Usuario atualizado com sucesso!');

            } else {
                SysUserRepository::create($postData);
                Session::flash('success', 'Usuario criado com sucesso!');
            }

        } else
            Session::flash('error', 'Voce nao tem permissao ao acessar esses dados');

        // Redireciona para o grid de menus
        return redirect()->route('sysusers.index');
        // ('sysusers.index');


    }

}
