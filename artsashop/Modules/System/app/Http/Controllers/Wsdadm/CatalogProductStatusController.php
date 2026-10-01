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

use App\Models\CatalogProductStatus;
use Idea\Framework\Admin\AdminController;

class CatalogProductStatusController extends AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('wsdadm.partials.grids', [
            'componentName' => 'system::grids.catalog-product-status-grid'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function insert()
    {
        // Retorna a View
        return view('wsdadm.partials.forms', [
            'componentName' => 'system::form.catalog-product-status-form',
            'data' => []
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $catalogProductStatus = CatalogProductStatus::query()->where('status_id', '=', $id)
            ->first()->toArray();

        if ($catalogProductStatus) {
            // Retorna a View
            return view('wsdadm.partials.forms', [
                'componentName' => 'system::form.catalog-product-status-form',
                'data' => $catalogProductStatus
            ]);
        }

    }

}
