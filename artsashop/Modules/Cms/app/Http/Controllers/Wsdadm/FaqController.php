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
use Idea\Framework\Repository\Cms\CmsFaqRepository;

class FaqController extends AdminController
{

    // Botão de Insert
    public bool $buttonInsert = true;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('wsdadm.partials.grids', [
            'componentName' => 'cms::grids.faq-grid'
        ]);
    }

    public function insert()
    {
        // Retorna a View
        return view('wsdadm.partials.forms', [
            'componentName' => 'cms::form.faq-form',
            'data' => []
        ]);
    }

    public function edit($id)
    {

        // Retorna a faq pelo ID
        $cmsFaq = CmsFaqRepository::find($id);

        if ($cmsFaq) {
            // Retorna a View
            return view('wsdadm.partials.forms', [
                'componentName' => 'cms::form.faq-form',
                'data' => $cmsFaq->toArray()
            ]);

        }

        return redirect()->route('wsdadm.cms.faq')->withErrors(
            'O conteúdo da faq não foi localizado!'
        );

    }

}
