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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Payments\Facade\PaymentFacade;
use Modules\Sales\Emails\SalesOrderApprovedMail;
use Modules\Sales\Emails\SalesOrderCanceledMail;
use Modules\Sales\Emails\SalesOrderCreatedMail;
use Modules\Sales\Transformers\SalesOrderResource;

class PaymentsController extends Controller
{

    public function __construct(
        protected PaymentFacade $payments
    )
    {
    }

    public function pay($orderId)
    {

        // Retorna o Pedido do Cliente
        $order = SalesOrderRepository::getOrder($orderId)->first();

        if ($order->payment_method == 'pix') {
            $gateway = $this->payments->gateway();
            if ($gateway->supports('pix')) {
                $method = $gateway->getMethod('pix');
                $method->authorize($order, []);
            }

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
     * Método de Callback para o gateway processar o pedido (Webhook)
     * Usa o gateway ativo via Strategy Pattern
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function callback(Request $request)
    {
        // Delega validação HMAC para o gateway ativo
        if (!$this->payments->validateWebhook($request)) {

            Log::warning('Payment Webhook: Assinatura HMAC inválida', [
                'ip' => $request->ip(),
                'payload' => $request->all()
            ]);
            return response()->json([
                'message' => 'Assinatura inválida'
            ], 401);
        }

        try {

            $payload = $request->all();

            if (empty($payload)) {
                return response()->json([
                    'message' => 'Payload vazio'
                ], 400);
            }

            // Processa o webhook através do gateway ativo (Strategy Pattern)
            $webhookData = $this->payments->handleWebhook($payload);

            if (empty($webhookData['order_id'])) {
                return response()->json([
                    'message' => 'Order ID não enviado no webhook'
                ], 400);
            }

            // Busca pedido pelo increment_code (código do pedido no gateway)
            $order = SalesOrderRepository::getByIncrement($webhookData['order_id'])->first();

            if (!$order) {
                return response()->json([
                    'message' => 'Pedido não encontrado'
                ], 404);
            }

            // Consulta status da transação no gateway ativo
            $transactionId = $webhookData['transaction_id'] ?? $payload['id'] ?? null;
            $statusOrder = $this->payments->checkTransaction($transactionId);

            if (!$statusOrder) {
                return response()->json([
                    'message' => 'Não foi possível consultar status da transação'
                ], 500);
            }

            // Normaliza o status retornado pelo gateway
            $normalizedStatus = $this->normalizeGatewayStatus($statusOrder);

            // Atualiza o status do pedido
            SalesOrderRepository::updateOrder(
                orderId: $order->order_id,
                attributes: [
                    'status_id'    => $normalizedStatus['status_id'],
                    'status_type'  => $normalizedStatus['status_type'],
                    'status_code'  => $normalizedStatus['status_code'],
                    'status_label' => $normalizedStatus['status_label'],
                    'shipping_cost'=> $order->shipping_cost ?? 0,
                    'canal'        => 'web',
                ]);

            // Retorna todos os dados do pedido
            $orderData = (new SalesOrderResource(
                SalesOrderRepository::getOrder($order->order_id)->first()
            ))->resolve();

            // Envia e-mail baseado no status final
            $this->sendStatusEmail($orderData);

            // Retorna as informações do pedido
            return response()->json($orderData);

        } catch (\Throwable $e) {

            Log::error('Payment Webhook Error', [
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
     * Retorno do gateway após pagamento (Redirect)
     * Usa o gateway ativo via Strategy Pattern
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse|void
     */
    public function redirect(Request $request)
    {
        $payload = $request->all();

        if (empty($payload['transaction_id'])) {
            return redirect()->route('checkout.onepage.fail')
                ->with('error', 'Transaction ID não informado');
        }

        try {
            // Busca pedido pelo increment_code
            $incrementCode = $payload['transaction_order_id'] ?? $payload['order_code'] ?? null;

            if (!$incrementCode) {
                return redirect()->route('checkout.onepage.fail')
                    ->with('error', 'Order code não informado');
            }

            $salesOrder = SalesOrderRepository::getOrderByIncrementId(
                orderIncrementId: $incrementCode
            );

            if (!$salesOrder) {
                return redirect()->route('checkout.onepage.fail')
                    ->with('error', 'Pedido não encontrado');
            }

            // Consulta status da transação no gateway ativo
            $statusOrder = $this->payments->checkTransaction(
                $payload['transaction_id']
            );

            if (!$statusOrder) {
                return redirect()->route('checkout.onepage.fail')
                    ->with('error', 'Não foi possível consultar status da transação');
            }

            // Normaliza o status
            $normalizedStatus = $this->normalizeGatewayStatus($statusOrder);

            // Atualiza o status do pedido
            SalesOrderRepository::updateOrder(
                orderId: $salesOrder->order_id,
                attributes: [
                    'status_id'    => $normalizedStatus['status_id'],
                    'status_type'  => $normalizedStatus['status_type'],
                    'status_code'  => $normalizedStatus['status_code'],
                    'status_label' => $normalizedStatus['status_label'],
                    'shipping_cost'=> $salesOrder->shipping_cost ?? 0,
                    'canal'        => 'web',
                ]);

            // Retorna dados atualizados
            $orderData = (new SalesOrderResource(
                SalesOrderRepository::getOrder($salesOrder->order_id)->first()
            ))->resolve();

            // Envia e-mail baseado no status
            $this->sendStatusEmail($orderData);

            // Redireciona baseado no status
            if ($normalizedStatus['status_code'] === 'approved') {
                return redirect()->route('checkout.onepage.success', [
                    'id' => $salesOrder->order_id
                ]);
            }

            if ($normalizedStatus['status_code'] === 'canceled') {
                return redirect()->route('checkout.onepage.fail');
            }

            // Para pending_payment (PIX aguardando), vai para success page
            return redirect()->route('checkout.onepage.success', [
                'id' => $salesOrder->order_id
            ]);

        } catch (\Throwable $e) {
            Log::error('Payment Redirect Error', [
                'error' => $e->getMessage(),
                'payload' => $request->all()
            ]);

            return redirect()->route('checkout.onepage.fail')
                ->with('error', 'Erro ao processar retorno do pagamento');
        }
    }

    /**
     * Normaliza status do gateway para status do sistema
     *
     * @param array $statusOrder
     * @return array
     */
    protected function normalizeGatewayStatus(array $statusOrder): array
    {
        // Status do gateway (ex: 'paid', 'pending', 'canceled', 'failed', 'pre_authorized')
        $gatewayStatus = $statusOrder['status'] ?? $statusOrder['order_status'] ?? $statusOrder['charge_status'] ?? 'unknown';

        // Mapeia para status do sistema
        return match ($gatewayStatus) {
            'paid', 'approved', 'pre_authorized' => [
                'status_id'    => \App\Models\SalesOrderStatus::where('code', 'awaiting_approval')->first()?->status_id,
                'status_type'  => 'awaiting_approval',
                'status_code'  => 'approved',
                'status_label' => 'Aguardando aprovação da clínica',
            ],
            'pending', 'waiting_payment', 'pending_payment', 'processing' => [
                'status_id'    => \App\Models\SalesOrderStatus::where('code', 'pending_payment')->first()?->status_id,
                'status_type'  => 'pending_payment',
                'status_code'  => 'pending_payment',
                'status_label' => 'Aguardando pagamento',
            ],
            'canceled', 'cancelled', 'declined', 'failed', 'refunded' => [
                'status_id'    => \App\Models\SalesOrderStatus::where('code', 'canceled')->first()?->status_id,
                'status_type'  => 'canceled',
                'status_code'  => 'canceled',
                'status_label' => 'Cancelado',
            ],
            default => [
                'status_id'    => \App\Models\SalesOrderStatus::where('code', 'pending_payment')->first()?->status_id,
                'status_type'  => 'pending_payment',
                'status_code'  => 'pending_payment',
                'status_label' => 'Aguardando pagamento',
            ],
        };
    }

    /**
     * Envia e-mail baseado no status do pedido
     *
     * @param array $orderData
     * @return void
     */
    protected function sendStatusEmail(array $orderData): void
    {
        $email = $orderData['customer']['customerEmail'] ?? null;

        if (!$email) {
            return;
        }

        try {
            if ($orderData['status']['code'] == 'approved') {
                Mail::to($email)->send(new SalesOrderApprovedMail(
                    SalesOrderRepository::getOrder($orderData['order_id'])->first()
                ));
            } else if ($orderData['status']['code'] == 'canceled') {
                Mail::to($email)->send(new SalesOrderCanceledMail(
                    SalesOrderRepository::getOrder($orderData['order_id'])->first()
                ));
            } else if ($orderData['status']['code'] == 'pending_payment') {
                Mail::to($email)->send(new SalesOrderCreatedMail(
                    SalesOrderRepository::getOrder($orderData['order_id'])->first()
                ));
            }
        } catch (\Throwable $e) {
            Log::error('Erro ao enviar e-mail de status', [
                'error' => $e->getMessage(),
                'order_id' => $orderData['order_id'] ?? null
            ]);
        }
    }

}
