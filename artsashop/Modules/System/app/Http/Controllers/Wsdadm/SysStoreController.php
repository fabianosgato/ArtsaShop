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
use Idea\Framework\Repository\System\SysStoreRepository;

class SysStoreController extends AdminController
{

    public function index()
    {
        return view('wsdadm.partials.grids', [
            'componentName' => 'system::grids.sys-store-grid'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function insert()
    {
        // Retorna a View
        return view('wsdadm.partials.forms', [
            'componentName' => 'system::form.sys-store-form',
            'data' => []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function edit($id)
    {

        $sysStore = SysStoreRepository::getData()->find($id)->toArray();

        // Retorna a View
        return view('wsdadm.partials.forms', [
            'componentName' => 'system::form.sys-store-form',
            'data' => $sysStore
        ]);
    }

}
