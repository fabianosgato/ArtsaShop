<?php
/**
 * Lef Tecnologia
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

namespace Modules\Reports\Http\Controllers;

use Idea\Framework\Admin\AdminController;
use Idea\Framework\Repository\Reports\ReportOrderRepository;
use Idea\Framework\Repository\Sales\SalesOrderRepository;

class ReportsController extends AdminController
{

    // Define se o sistema ira apresentar o botao de inserir
    public bool $buttonInsert = false;

    /**
     * Action de listagem de todos os pedidos.
     */
    public function orders()
    {
        return view('wsdadm.partials.grids', ['componentName' => 'reports::grids.report-order-grid']);
    }

    /**
     * Action de listagem de todos os Logs
     */
    public function logs()
    {
        return view('wsdadm.partials.grids', ['componentName' => 'reports::grids.report-log-grid']);
    }

    /**
     * Action de listagem de todos os Logs
     */
    public function fobCustom()
    {
        return view('wsdadm.partials.grids', ['componentName' => 'reports::grids.report-fob-custom-grid']);
    }

    /**
     * Action de listagem de todos os Logs
     */
    public function incorrectWeight()
    {
        return view('wsdadm.partials.grids', ['componentName' => 'reports::grids.report-incorrect-weight-grid']);
    }

    /**
     * Action de Visualização do Pedido que esta no log
     */
    public function orderReportView($id)
    {

        // Retorna as informacoes do pedido
        $order = SalesOrderRepository::getOrder($id)->first();

        return view('reports::orders.view', [
            'order' => $order->toArray(),
            'customer' => SalesOrderRepository::getOrderCustomer(
                orderId: $id
            )->first(),
            'billing' => SalesOrderRepository::getOrderAddress(
                orderId: $id,
                addressType: 'billing'
            )->first(),
            'shipping' => SalesOrderRepository::getOrderAddress(
                orderId: $id,
                addressType: 'shipping'
            )->first(),
            'products' => SalesOrderRepository::getOrderItens(
                orderId: $id
            )->get()->toArray(),
            'historics' => ReportOrderRepository::getData(
                orderId:$order->order_id
            )->get()->toArray()
        ]);

    }


}
