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
