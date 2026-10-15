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
namespace Modules\Sales\Http\Controllers\Wsdadm;

use Idea\Framework\Admin\AdminController;
use Idea\Framework\Repository\Sales\SalesOrderPaymentRepository;
use Idea\Framework\Repository\Sales\SalesOrderRepository;

class SalesController extends AdminController
{

    // Define se o sistema ira apresentar o botao de inserir
    public bool $buttonInsert = false;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('wsdadm.partials.grids', ['componentName' => 'sales::grid.sales-order-grid']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function show($id)
    {

        // Retorna as informacoes do pedido
        $order = SalesOrderRepository::getOrder($id)->first()->toArray();

        return view('sales::orders.show', [
            'order' => $order,
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
        ]);

    }

    public function view($id)
    {

        // Retorna as informacoes do pedido
        $order = SalesOrderRepository::getApprovedOrder($id)->first();

        // Retorna para o VIEW os dados do pedido
        return view('sales::wsdadm.view', [
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
            'payment' => SalesOrderPaymentRepository::getPaymentByOrderId(
                orderId: $id
            )
            // 'tracking' => BbOrders::getOrderData($order->canal_remote_code),
            // 'historics' => ReportOrderRepository::getData($order->order_id)->get()->toArray()
        ]);

    }

}
