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
