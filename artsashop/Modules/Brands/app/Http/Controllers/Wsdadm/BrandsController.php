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

namespace Modules\Brands\Http\Controllers\Wsdadm;

use Idea\Framework\Admin\AdminController;
use Idea\Framework\Repository\Brand\CatalogProductBrandRepository;

class BrandsController extends AdminController
{

    public bool $buttonInsert = true;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('wsdadm.partials.grids', [
            'componentName' => 'brands::grids.brands-grid'
        ]);
    }

    public function insert()
    {

        return view('wsdadm.partials.forms', [
            'componentName' => 'brands::form.catalog-product-brand-form',
            'data' => []
        ]);

    }

    public function edit($id)
    {

        $catalogProductBrand = CatalogProductBrandRepository::find($id);

        // Retorna a View
        return view('wsdadm.partials.forms', [
            'componentName' => 'brands::form.catalog-product-brand-form',
            'data' => $catalogProductBrand->toArray()
        ]);
    }

}
