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

namespace Modules\Sales\Services;

use App\Models\SalesOrder;
use App\Models\SalesOrderPayment;
use App\Models\SalesOrderQuote;
use App\Models\SalesOrderStatus;
use Idea\Framework\Repository\Customer\CustomerAddressRepository;
use Idea\Framework\Repository\Customer\CustomerEntityRepository;
use Idea\Framework\Repository\Sales\SalesOrderCodeRepository;
use Idea\Framework\Repository\Sales\SalesOrderCustomerRepository;
use Idea\Framework\Repository\Sales\SalesOrderItemRepository;
use Idea\Framework\Repository\Sales\SalesOrderPaymentRepository;
use Idea\Framework\Repository\Sales\SalesOrderRepository;
use Idea\Framework\Repository\Sales\SalesOrderStatusRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Modules\Checkout\Services\CheckoutCartService;
use Modules\Checkout\Services\StockService;
use Modules\Customers\Services\CheckoutCustomerService;
use Modules\Sales\Services\Concerns\OrderAddress;
use Modules\Sales\Services\Concerns\SendOrderEmails;
use Modules\Sales\Services\Concerns\ValidatePayments;


class SalesOrderPlacementService
{

    // Trait para validação de Pagamentos
    use ValidatePayments;

    // Trait para envio de e-mails
    use SendOrderEmails;

    // Trait para endereços do pedido/cliente
    use OrderAddress;

    public function __construct(
        protected SalesQuoteService   $salesQuoteService,
        protected CheckoutCartService $checkoutCartService
    )
    {
    }

    /**
     * Finaliza o checkout e cria o pedido
     */
    public function place(array $quote, array $payload): SalesOrder
    {

        // Retorna a loja atual
        $store = app('currentStore');

        // Sessão do checkout
        $checkoutSession = session()->get('checkout');

        // Valida se o cliente já está logado
        $customer = Auth::guard('customer')->user();

        // Se o customer nao existir, irá validar a criação da conta
        if (!$customer) {
            // Valida se o cliente irá criar a conta
            if (!empty($checkoutSession['create_account'])) {
                $payload['register']['create_account'] = $checkoutSession['create_account'];
                // se o cliente preencheu a senha
                if (!empty($checkoutSession['password'])) {
                    $payload['register']['password'] = $checkoutSession['password'];
                }
            } else {
                $payload['register']['create_account'] = false;
            }
        }

        /** 1. Cliente */
        $customer = CheckoutCustomerService::resolveOrCreate(
            quote: $quote,
            payload: $payload,
        );

        // Atualiza o (customer document) base de dados
        CustomerEntityRepository::updateCustomerDocument(
            customerId: $customer->customer_id,
            vatNumber: $payload['register']['vat_number']
        );

        /** 2. Vincula cliente ao quote */
        $quoteModel = $this->salesQuoteService->attachCustomerToQuoteId(
            customerId: $customer->customer_id,
            quoteId: $quote['quote_id']
        );

        /** 3. Estoque */
        foreach ($quote['items'] as $item) {
            app(StockService::class)->validate(
                $item['product_id'],
                $item['qty']
            );
        }

        // =============================
        // TRANSACTION (APENAS DB)
        // =============================
        $result = DB::transaction(function () use ($payload, $customer, $quoteModel, $store) {

            $statusOrder = $this->getProcessingStatus();

            if (!$quoteModel) {
                throw new \RuntimeException('Quote ativo não encontrado.');
            }

            /** Pedido */
            $order = SalesOrderRepository::createOrder([
                'store_id' => $store->store_id,
                'store_code' => $store->code,
                'status_id' => $statusOrder->status_id,
                'status_type' => $statusOrder->status,
                'status_code' => $statusOrder->status,
                'status_label' => $statusOrder->label,
                'payment_method' => $quoteModel->payment_method,
                'payment_description' => $this->paymentDescription($quoteModel->payment_method),
                'base_shipping_amount' => $quoteModel->shipping_cost ?? 0,
                'base_discount_amount' => $quoteModel->discount_amount ?? 0,
                'base_subtotal' => $quoteModel->subtotal ?? 0,
                'base_grand_total' => $quoteModel->grand_total ?? 0,
                'canal' => 'web',
                'remote_ip' => request()->ip(),
                'estimated_delivery_date' => now()->addDays(21)->format('Y-m-d H:i:s'),
            ]);

            $this->generateIncrementCode($order);

            // Vincula o pedido ao cliente
            SalesOrderCustomerRepository::create([
                'order_id' => $order->order_id,
                'customer_id' => $customer->customer_id,
            ]);

            // Salva os dados do Endereço do cliente no pedido
            $this->persistOrderAddresses($order, $customer, $quoteModel);

            // Salva os itens do pedido
            $this->persistItems($order, $quoteModel->items->toArray());

            // Salva o pagamento escolhido do pedido
            $payment = $this->persistPayment($order, $quoteModel);

            // Finaliza o checkout
            $this->finalizeCheckout($quoteModel->quote_id);

            // RETORNAR DADOS NECESSÁRIOS
            return [
                'order' => $order,
                'payment' => $payment,
                'quote' => $quoteModel
            ];

        });


        // =============================
        // FORA DA TRANSACTION
        // =============================
        try {

            $salesOrder = $this->validatePayment(
                $result['order'],
                $result['payment'],
                $result['quote'],
                $payload
            );

        } catch (\Throwable $e) {
            // Gera o log para validação do Pagamento
            Log::error('Erro ao validar pagamento', [
                'order_id' => $result['order']->order_id,
                'error' => $e->getMessage()
            ]);

            return $result['order']; // retorna mesmo assim

        }

        // envio de email só após pagamento validado
        // $this->sendCreatedOrderMail($salesOrder);

        return $salesOrder;

    }

    /**
     * Gera o increment code do pedido
     * @param \App\Models\SalesOrder $order
     * @return void
     */
    private function generateIncrementCode(SalesOrder $order): void
    {

        // Gera o IncrementCode com a "LOJA"
        $increment = strtoupper(app('currentStore')->code_order) . '-' . str_pad($order->order_id, 11, '0', STR_PAD_LEFT);

        SalesOrderCodeRepository::create([
            'order_id' => $order->order_id,
            'increment_code' => $increment,
        ]);

        // Atualiza o pedido com o IncrementId
        SalesOrderRepository::updateOrder(
            orderId: $order->order_id,
            attributes: [
                'increment_id' => $increment
            ]
        );

    }

    /**
     * Metodo que persiste os itens do pedido
     */
    private function persistItems(SalesOrder $order, array $items): void
    {
        foreach ($items as $item) {

            // Json dos dados do produto
            $productSnapshot = json_decode($item['product_snapshot'], true);

            SalesOrderItemRepository::create([
                'order_id' => $order->order_id,
                'product_id' => $item['product_id'],
                'product_sku' => $productSnapshot['sku'] ?? '',
                'product_name' => $productSnapshot['name'] ?? '',
                'qty_ordered' => $item['qty'],
                'price' => $item['price'],
                'row_total' => $item['subtotal'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Persiste o Pagamento do pedido
     * @param \App\Models\SalesOrder $order
     * @param \App\Models\SalesOrderQuote $salesOrderQuote
     * @return SalesOrderPayment
     */
    private function persistPayment(SalesOrder $order, SalesOrderQuote $salesOrderQuote): SalesOrderPayment
    {

        // Inicializa a variavel de informações adicionais
        $additionalInformation = [];

        // Cria o pagamento do pedio no banco
        return SalesOrderPaymentRepository::createPayment([
            'order_id' => $order->order_id,
            'method' => $salesOrderQuote->payment_method,
            'value' => $salesOrderQuote->grand_total ?? $salesOrderQuote->subtotal,
            'description' => 'Pagamento via ' . $this->paymentDescription($salesOrderQuote->payment_method) ?? null,
            'additional_information' => json_encode($additionalInformation)
        ]);

    }

    /**
     * Finaliza o checkout
     * @param int $quoteId
     * @return void
     */
    public function finalizeCheckout(int $quoteId): void
    {

        // Desativa o quote atual no banco de dados
        $this->salesQuoteService->deactivateAndDeleteQuote($quoteId);

        // Limpa os dados do carrinho
        $this->checkoutCartService->clear();

        // Esquece os dados da sessão do pedido
        session()->forget([
            'cart',  // Limpa os dados da sessão do carrinho
            'checkout' // Limpa os dados da sessão do checkout
        ]);

        // Regenera o ID por segurança após uma transação
        session()->regenerate();

    }

    /**
     * Limpa a sessão do Quote
     * @return void
     */
    public function clearCheckoutSessions()
    {

        // Acessa o gerenciador de sessão e destrói a sessão específica
        Session::getHandler()->destroy(session()->getId());

        // Remove apenas a chave do carrinho/quote
        session()->forget('quote');

        // Regenera o ID por segurança após uma transação
        session()->regenerate();

    }

    /**
     * Retorna o status de novos pedidos. Deve ser sempre "pendente" pois ainda não validamos o Pagamento
     * @return \App\Models\SalesOrderStatus
     */
    private function getProcessingStatus(): SalesOrderStatus
    {
        return SalesOrderStatusRepository::getByCode('pending');
    }

    /**
     * Retorna endereço padrão do cliente
     */
    private function hydrateFromCustomerAddress(int $customerId, string $type): array
    {
        $address = CustomerAddressRepository::getData()
            ->where('customer_id', $customerId)
            ->where(
                $type === 'shipping'
                    ? 'is_default_shipping'
                    : 'is_default_billing',
                1
            )
            ->first();

        if (!$address && $type === 'shipping') {
            return $this->hydrateFromCustomerAddress($customerId, 'billing');
        }

        if (!$address) {
            return [];
        }

        return [
            'name' => $address->recipient_name,
            'phone' => $address->phone,
            'cellphone' => $address->cellphone,
            'postcode' => $address->postcode,
            'street' => $address->street,
            'number' => $address->number,
            'complement' => $address->complement,
            'neighborhood' => $address->neighborhood,
            'city' => $address->city,
            'region' => $address->region,
            'country' => $address->country ?? 'Brasil',
        ];
    }
}
