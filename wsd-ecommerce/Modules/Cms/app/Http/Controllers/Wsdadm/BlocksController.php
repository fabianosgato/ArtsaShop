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
use Idea\Framework\Repository\Cms\CmsBlockRepository;

class BlocksController extends AdminController
{

    // Botao de insert
    public bool $buttonInsert = true;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('wsdadm.partials.grids', ['componentName' => 'cms::grids.blocks-grid']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function insert()
    {
        // Retorna a View
        return view('wsdadm.partials.forms', [
            'componentName' => 'cms::form.blocks-form',
            'data' => []
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        // Retorna os dados do conteúdo criado/atualizado
        $data = CmsBlockRepository::find($id);

        if ($data) {
            // Retorna a View
            return view('wsdadm.partials.forms', [
                'componentName' => 'cms::form.blocks-form',
                'data' => $data->toArray()
            ]);

        }

        return redirect()->route('wsdadm.cms.blocks')->withErrors(
            'O Conteúdo estático não foi localizado'
        );

    }

}
