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
use Idea\Framework\Repository\Seo\SeoMetaTagRepository;
use Illuminate\Support\Facades\Session;

class SeoConfigController extends AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('wsdadm.partials.grids', [
            'componentName' => 'system::grids.seo-config-grid'
        ]);
    }

    public function insert()
    {

        // Retorna a View
        return view('wsdadm.partials.forms', [
            'componentName' => 'system::form.sys-carrier-form',
            'data' => []
        ]);
    }

    public function edit($id)
    {

        $seoMetaTags = SeoMetaTagRepository::find($id);

        if ($seoMetaTags)
            // Retorna a View
            return view('wsdadm.partials.forms', [
                'componentName' => 'system::form.seo-config-form',
                'data' => $seoMetaTags->toArray()
            ]);

        Session::flash('error', 'SEO MetaTag nao definida ou não existe mais');

        return redirect()->route('wsdadm.seo-config');


    }

}
