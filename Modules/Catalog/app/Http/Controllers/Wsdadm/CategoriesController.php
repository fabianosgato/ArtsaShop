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
namespace Modules\Catalog\Http\Controllers\Wsdadm;

use Idea\Framework\Admin\AdminController;

class CategoriesController extends AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('catalog::wsdadm.categories', [
            'componentName' => 'catalog::categories.categories-page'
        ]);
    }

}
