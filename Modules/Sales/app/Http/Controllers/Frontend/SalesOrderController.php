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
namespace Modules\Sales\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Idea\Framework\Repository\Sales\SalesOrderRepository;
use Idea\Framework\Repository\Sales\SalesOrdersTrackingRepository;
use Illuminate\Support\Facades\Auth;

class SalesOrderController extends Controller
{

    /**
     * Mostra detalhes de um pedido na conta do cliente
     */
    public function index($id)
    {

        // Valida se o cliente esta realmente autenticado
        if (Auth::guard('customer')->check()) {

            $salesOrder = SalesOrderRepository::getOrder($id);

            if ($salesOrder->exists()) {
                // Retorna o pedido do cliente
                $customerSalesOrder = $salesOrder->first();

                $salesOrderTracking = SalesOrdersTrackingRepository::getOrderTracking($customerSalesOrder->order_id);

                if ($salesOrderTracking->exists()) {
                    $orderTracking = $salesOrderTracking->first();
                } else {
                    $orderTracking = null;
                }

                // Retorna com os dados do Cliente
                return view('sales::frontend.order-details', [
                    'order' => $customerSalesOrder,
                    'tracking' => $orderTracking
                ]);

            }

        }

        // Redireciona para a página de login
        return redirect()->route('account.login')->withErrors([
            'Você precisa estar logado'
        ]);

    }

}
