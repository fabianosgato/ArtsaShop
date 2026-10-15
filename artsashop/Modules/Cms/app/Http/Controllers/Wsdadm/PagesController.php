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

        // Retorna os dados da página criada/atualizada
        $data = CmsPageRepository::find($id);

        if ($data) {
            // Retorna a View
            return view('wsdadm.partials.forms', [
                'componentName' => 'cms::form.pages-form',
                'data' => $data->toArray()
            ]);

        }

        // Redireciona em caso de erro
        return redirect()->route('wsdadm.cms.pages')->withErrors(
            'A página escolhida não foi localizada!'
        );

    }

}
