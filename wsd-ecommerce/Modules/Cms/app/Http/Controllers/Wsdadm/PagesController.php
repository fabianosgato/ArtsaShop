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
namespace Modules\Cms\Http\Controllers\Wsdadm;

use Idea\Framework\Admin\AdminController;
use Idea\Framework\Repository\Cms\CmsPageRepository;

class PagesController extends AdminController
{

    // Botão de Insert
    public bool $buttonInsert = true;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('wsdadm.partials.grids', [
            'componentName' => 'cms::grids.pages-grid'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function insert()
    {
        // Retorna a View
        return view('wsdadm.partials.forms', [
            'componentName' => 'cms::form.pages-form',
            'data' => []
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        // Retorna os dados da pagina criada/atualizada
        $data = CmsPageRepository::getData()
            ->where(['page_id' => $id])
            ->get();

        if ($data) {
            // Retorna a View
            return view('wsdadm.partials.forms', [
                'componentName' => 'cms::form.pages-form',
                'data' => $data->first()->toArray()
            ]);

        }

        return redirect()->route(route('wsdadm.cms.pages'));


    }

}
