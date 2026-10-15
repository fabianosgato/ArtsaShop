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
