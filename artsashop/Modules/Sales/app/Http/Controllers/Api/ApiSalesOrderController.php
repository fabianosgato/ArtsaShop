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
namespace Modules\Sales\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Idea\Framework\Repository\Sales\SalesOrderRepository;
use Idea\Framework\Repository\Sales\SalesOrderStatusRepository;
use Idea\Framework\Repository\Sales\SalesOrdersTrackingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Modules\Sales\Concerns\OrdersApiResponse;
use Modules\Sales\Emails\SalesOrderTrackingMail;

class ApiSalesOrderController extends Controller
{

    use OrdersApiResponse;

    /**
     * Lista todos os pedidos
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {

        if ($request->accepts(['application/json'])) {

            // Retorna os itens por página
            $perPage = $request->get('per_page', 250);

            // Retorna os pedidos do sistema
            $salesOrder = SalesOrderRepository::getOrdersPagination($perPage);

            // Response Json
            return response()->json(
                $this->paginatedResponse($salesOrder)
            );

        }

        return response()->json(
            $this->resultError()
        );

    }

    /**
     * Show the specified resource.
     */
    public function details(Request $request): \Illuminate\Http\JsonResponse|array
    {

        if ($request->accepts(['application/json'])) {

            // Array data vindos da API
            $arrayData = $request->all();

            if ($arrayData) {

                // Retorna o pedido
                $order = SalesOrderRepository::getByIncrement($arrayData['orderId']);

                if ($order->exists()) {

                    // Retorna as informacoes do pedido
                    return $this->resultSalesOrder(
                        salesOrder: SalesOrderRepository::getOrder(
                            $order->first()->order_id
                        )->first()
                    );

                } else {
                    return response()->json(
                        $this->resultError()
                    );

                }

            }

        }

        return response()->json(
            $this->resultError()
        );

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        if ($request->accepts(['application/json'])) {

            // Array data vindos da API
            $arrayData = $request->all();

            if ($arrayData) {

                // Retorna o pedido
                $order = SalesOrderRepository::getByIncrement($arrayData['orderId']);

                if ($order->exists()) {

                    // Inicializa o status inicial do pedido
                    $orderStatus = $order->first()->status_type;

                    // Salva o pedido na base de dados
                    $salesOrdersTracking = SalesOrdersTrackingRepository::saveOrUpdateTracking(
                        orderId: $order->first()->order_id,
                        values: [
                            'order_id' => $order->first()->order_id,
                            'tracking_code' => $arrayData['tracking']['tracking_number'],
                            'carrier' => $arrayData['tracking']['carrier_name'],
                            'method' => $arrayData['tracking']['carrier_name'],
                            'url' => $arrayData['tracking']['carrier_url']
                        ]
                    );

                    if ($salesOrdersTracking) {

                        if ($arrayData['tracking']['statusOrder'] == 20) {
                            // Retorna o status do pedido "Completo/Entregue"
                            $statusOrder = SalesOrderStatusRepository::getByCode('complete');

                        } else if ($arrayData['tracking']['statusOrder'] == 17) {
                            // Retorna o status do pedido "Devolvido"
                            $statusOrder = SalesOrderStatusRepository::getByCode('refunded');

                        } else {

                            // Retorna o status do pedido "em trasito"
                            $statusOrder = SalesOrderStatusRepository::getByCode('transit');

                        }

                        SalesOrderRepository::updateOrder(
                            orderId: $order->first()->order_id,
                            attributes: [
                                'status_id'    => $statusOrder->status_id,
                                'status_type'  => $statusOrder->status,
                                'status_code'  => $statusOrder->status,
                                'status_label' => $statusOrder->label,
                                'shipping_cost'=> $quoteModel->shipping_cost ?? 0,
                                'canal'        => 'web',
                            ]);

                        // Se o status inicial do pedido for aprovado envia o email de tracking
                        if ($orderStatus == 'approved')
                            // Envia o email com o rastreio apenas para produtos Aprovados

                            Mail::to('fabianogattoti@gmail.com')
                                ->send(new SalesOrderTrackingMail(
                                    SalesOrderRepository::getOrder(
                                        orderId: $order->first()->order_id
                                    )->first())
                                );

//                            Mail::to($order->first()->customer_email)
//                                ->send(new SalesOrderTrackingMail(
//                                    SalesOrderRepository::getOrder(
//                                        orderId: $order->first()->order_id
//                                    )->first())
//                                );

                        // Retorna o Pedido atualizado
                        return $this->resultSalesOrder(
                            salesOrder: SalesOrderRepository::getOrder(
                                $order->first()->order_id
                            )->first()
                        );

                    }

                } else {
                    return response()->json(
                        $this->resultError()
                    );
                }


            } else {
                return response()->json([
                    'error' => true,
                    'message' => 'Dados enviados sao incorretos ',
                ]);
            }
        }

        return response()->json([
            'error' => true,
            'message' => 'Dados enviados sao incorretos ',
        ]);

    }

}
