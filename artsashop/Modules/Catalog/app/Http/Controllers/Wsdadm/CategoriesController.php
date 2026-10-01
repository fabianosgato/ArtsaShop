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
