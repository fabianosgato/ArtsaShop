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
use Idea\Framework\Repository\System\SysCarrierRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SysCarrierController extends AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('wsdadm.partials.grids', [
            'componentName' => 'system::grids.sys-carrier-grid'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $sysCarrier = SysCarrierRepository::find($id)->toArray();

        if ($sysCarrier) {
            // Retorna a View
            return view('wsdadm.partials.forms', [
                'componentName' => 'system::form.sys-carrier-form',
                'data' => $sysCarrier
            ]);
        }

        Session::flash('error', 'Transportadora nao definida ou não existe mais');

        return redirect()->route('sys-carriers.index');

    }

    public function insert()
    {
        return view('wsdadm.partials.forms', [
            'componentName' => 'system::form.sys-carrier-form',
            'data' => []
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
