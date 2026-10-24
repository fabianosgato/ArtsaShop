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
use Idea\Framework\Repository\Cms\CmsBannerRepository;

class BannersController extends AdminController
{

    // Botão de Insert
    public bool $buttonInsert = true;

    public function index()
    {
        return view('wsdadm.partials.grids', [
            'componentName' => 'cms::grids.banners-grid'
        ]);
    }


    /**
     * Mostra o form para inserção.
     */
    public function insert()
    {
        // Retorna a View
        return view('wsdadm.partials.forms', [
            'componentName' => 'cms::form.banners-form',
            'data' => []
        ]);

    }

    /**
     * Mostra o form para edição.
     */
    public function edit($id)
    {

        // Retorna os dados da página criada/atualizada
        $cmsBanner = CmsBannerRepository::find($id);

        if ($cmsBanner) {
            // Retorna a View
            return view('wsdadm.partials.forms', [
                'componentName' => 'cms::form.banners-form',
                'data' => $cmsBanner->toArray()
            ]);

        }

        return redirect()->route('wsdadm.cms.pages')->withErrors(
            'O banner escolhido não está mais disponível.'
        );

    }

}
