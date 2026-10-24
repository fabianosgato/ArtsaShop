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
namespace Modules\SalesRules\Http\Controllers\Wsdadm;

use Idea\Framework\Admin\AdminController;
use Idea\Framework\Repository\Sales\SalesDiscountRuleRepository;
use Illuminate\Support\Facades\Session;

class SalesRulesController extends AdminController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('wsdadm.partials.grids', [
            'componentName' => 'salesrules::grids.sales-rules-grid'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function insert()
    {

        // Retorna a View
        return view('wsdadm.partials.forms', [
            'componentName' => 'salesrules::form.sales-rules-form',
            'data' => []
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $salesRule = SalesDiscountRuleRepository::getRuleById($id);

        if ($salesRule) {

            // Retorna a View
            return view('wsdadm.partials.forms', [
                'componentName' => 'salesrules::form.sales-rules-form',
                'data' => $salesRule->toArray()
            ]);

        } else {
            // Cria a mensagem
            Session::flash('error', "Regra de desconto inexistente com o ID {$id}!");

        }

        // Redireciona para listagem de produtos
        return redirect()->route('wsdadm.sales-rules');

    }

}
