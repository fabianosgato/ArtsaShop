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
namespace Modules\Payments\Http\Controllers;

use App\Http\Controllers\Controller;
use Idea\Framework\Repository\Sales\SalesOrderPaymentRepository;
use Idea\Framework\Repository\Sales\SalesOrderRepository;
use Idea\Framework\Services\Payments\IpagPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Sales\Emails\SalesOrderApprovedMail;
use Modules\Sales\Emails\SalesOrderCanceledMail;
use Modules\Sales\Emails\SalesOrderCreatedMail;
use Modules\Sales\Transformers\SalesOrderResource;

class PaymentsController extends Controller
{

    public function __construct(
        protected IpagPayment $ipagPayment
    )
    {
    }

    public function pay($orderId)
    {

        // Retorna o Pedido do Cliente
        $order = SalesOrderRepository::getOrder($orderId)->first();

        if ($order->payment_method == 'pix') {
            $this->ipagPayment->paymentPix($order);

        }

    }

    /**
     * Valida o Pagamento
     * @param $orderId
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function validatePayment($orderId)
    {
        // Retorna o Pedido do Cliente
        $order = SalesOrderRepository::getOrder($orderId)->first();

        if ($order) {

            // Retorna as informações do pagamento
            $paymentData = SalesOrderPaymentRepository::getPaymentByOrderId($order->order_id);

            if ($paymentData['method'] == 'credit_card') {
                if ($paymentData['additional_information']['requires_3ds']) {
                    return response()->json([
                        'status' => $order->status,
                        'url_3ds' => $paymentData['additional_information']['redirect_url'],
                    ]);
                }
            }

            return response()->json([
                'status' => $order->status
            ]);

        }

    }

    /**
     * Metodo de Callback para o IPag processar o pedido
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function callback(Request $request)
    {

        try {

            $payload = $request->all();

            if (empty($payload)) {
                return response()->json([
                    'message' => 'Payload vazio'
                ], 400);
            }

            // Extrai dados principais
            $orderIncrement = $payload['attributes']['order_id'] ?? null;
            $status = $payload['attributes']['status']['code'] ?? null;

            if (!$orderIncrement) {
                return response()->json([
                    'message' => 'Order ID não enviado'
                ], 400);
            }

            // Busca pedido
            $order = SalesOrderRepository::getByIncrement($orderIncrement)->first();

            if (!$order) {
                return response()->json([
                    'message' => 'Pedido não encontrado'
                ], 404);
            }

            $statusOrder = $this->ipagPayment->checkPayment(
                $payload['id']
            );

            // Atualiza o status do pedido
            SalesOrderRepository::updateOrder(
                orderId: $order->order_id,
                attributes: [
                    'status_id'    => $statusOrder->status_id,
                    'status_type'  => $statusOrder->status,
                    'status_code'  => $statusOrder->status,
                    'status_label' => $statusOrder->label,
                    'shipping_cost'=> $quoteModel->shipping_cost ?? 0,
                    'canal'        => 'web',
                ]);

            // Retorna todos os dados do pedido
            $orderData = (new SalesOrderResource(
                SalesOrderRepository::getOrder($order->order_id)->first()
            ))->resolve();

            if ($orderData['status']['code'] == 'approved') {
                Mail::to($orderData['customer']['customerEmail'])
                    ->send(new SalesOrderApprovedMail($order));

            } else if ($orderData['status']['code'] == 'canceled') {
                Mail::to($orderData['customer']['customerEmail'])
                    ->send(new SalesOrderCanceledMail($order));

            } else if ($orderData['status']['code'] == 'pending_payment') {
                Mail::to($orderData['customer']['customerEmail'])
                    ->send(new SalesOrderCreatedMail($order));

            }

            // Retorna as informações do pedido
            return response()->json(
                $orderData
            );

        } catch (\Throwable $e) {

            Log::error('IPag Webhook Error', [
                'error' => $e->getMessage(),
                'payload' => $request->all()
            ]);

            return response()->json([
                'message' => 'Erro ao processar webhook',
                'error' => $e->getMessage()
            ], 500);

        }

    }

    /**
     * Retorna o IPag para os metodos de pagamento
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function redirect(Request $request)
    {

        // Retorna o payload da requisição
        $payload = $request->all();

        if (!empty($payload['transaction_id'])) {

            // Retorna as informações do pedido
            $salesOrder = SalesOrderRepository::getOrderByIncrementId(
                orderIncrementId: $payload['transaction_order_id']
            );

            // Realiza a consulta do pedido no IPag e retorna o status do pedido
            $statusOrder = app(IpagPayment::class)->consult(
                $salesOrder,
                $payload['transaction_id']
            );

            // Atualiza o status do pedido
            SalesOrderRepository::updateOrder(
                orderId: $salesOrder->order_id,
                attributes: [
                    'status_id'    => $statusOrder->status_id,
                    'status_type'  => $statusOrder->status,
                    'status_code'  => $statusOrder->status,
                    'status_label' => $statusOrder->label,
                    'shipping_cost'=> $quoteModel->shipping_cost ?? 0,
                    'canal'        => 'web',
                ]);

            // Retorna todos os dados do pedido
            $orderData = (new SalesOrderResource(
                SalesOrderRepository::getOrder($salesOrder->order_id)->first()
            ))->resolve();

            if ($orderData['status']['code'] == 'approved') {
                Mail::to($orderData['customer']['customerEmail'])
                    ->send(new SalesOrderApprovedMail($salesOrder));

            } else if ($orderData['status']['code'] == 'canceled') {
                Mail::to($orderData['customer']['customerEmail'])
                    ->send(new SalesOrderCanceledMail($salesOrder));

                // Neste caso redireciona para a página de falha
                return redirect()->route('checkout.onepage.fail');

            } else if ($orderData['status']['code'] == 'pending_payment') {
                Mail::to($orderData['customer']['customerEmail'])
                    ->send(new SalesOrderCreatedMail($salesOrder));

            }

            // Redireciona para a pagina de sucesso
            return redirect()->route('checkout.onepage.success', [
                'id' => $salesOrder->order_id
            ]);

        }

    }

}
