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
namespace Idea\Framework\Services\Payments;

use App\Models\SalesOrder;
use Idea\Framework\Repository\Sales\SalesOrderHistoryRespository;
use Idea\Framework\Repository\Sales\SalesOrderRepository;
use Idea\Framework\Repository\Sales\SalesOrderStatusRepository;
use Idea\Framework\Services\Payments\Concerns\BankSlip;
use Idea\Framework\Services\Payments\Concerns\CreditCard;
use Idea\Framework\Services\Payments\Ipag\Core\Enums\AcquirerStatus;
use Idea\Framework\Services\Payments\Ipag\Core\Enums\GatewayStatus;
use Idea\Framework\Services\Payments\Ipag\Core\Enums\Others;
use Idea\Framework\Services\Payments\Ipag\Core\Enums\PaymentStatus;
use Idea\Framework\Services\Payments\Ipag\Core\Enums\PaymentTypes;
use Idea\Framework\Services\Payments\Ipag\Core\IpagClient;
use Idea\Framework\Services\Payments\Ipag\Core\IpagEnvironment;
use Idea\Framework\Services\Payments\Ipag\Exception\HttpException;
use Idea\Framework\Services\Payments\Ipag\Model\PaymentTransaction;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class IpagPayment
{

    use CreditCard;
    use BankSlip;

    public IpagClient $ipagClient;

    public function __construct()
    {

        // Chaves (API_ID, API_KEY) armazenadas em config ou .env
        $apiId = config('services.ipag.api_id');
        $apiKey = config('services.ipag.api_key');
        $apiEnvironment = config('services.ipag.api_env');

        // Inicializa o Client do IPag
        $this->ipagClient = new IpagClient(
            apiID: $apiId,
            apiKey: $apiKey,
            environment: ($apiEnvironment == 'SANDBOX' ? IpagEnvironment::SANDBOX : IpagEnvironment::PRODUCTION),
        );
    }

    /**
     * Retorna os itens do pedido
     * @param $orderId
     * @return array
     */
    private function getOrderItens($orderId)
    {

        $itens = [];

        $salesOrderItens = SalesOrderRepository::getOrderItens($orderId)
            ->get();

        if ($salesOrderItens) {

            foreach ($salesOrderItens as $salesOrderItem) {

                $itens[] = [
                    'name' => $salesOrderItem->product_name,
                    'unit_price' => $salesOrderItem->final_price,
                    'quantity' => intval($salesOrderItem->qty_ordered),
                    'sku' => $salesOrderItem->product_sku,
                    'description' => $salesOrderItem->product_name
                ];

            }

        }

        return $itens;

    }

    /**
     * Retorna o Cliente do Pedido
     * @param $orderId
     * @return array
     */
    private function getOrderCustomer($orderId): array
    {

        // Inicializa a variável de Customer
        $customer = [];

        // Retorna os dados do cliente
        $salesOrderCustomer = SalesOrderRepository::getOrderCustomer($orderId)
            ->first();

        if ($salesOrderCustomer) {

            // Endereço de Cobranca do Pedido
            $orderAddressBilling = SalesOrderRepository::getOrderAddress($orderId, 'billing')
                ->first();

            if (!$orderAddressBilling) {
                Log::error("PEDIDO SEM ENDEREÇO DE COBRANÇA PARA O ID: $orderId");
            }

            // Endereço de Cobranca do Pedido
            $orderAddressShipping = SalesOrderRepository::getOrderAddress($orderId, 'shipping')
                ->first();

            if (!$orderAddressBilling) {
                Log::error("PEDIDO SEM ENDEREÇO DE ENTREGA PARA O ID: $orderId");
            }

            $customer = [
                'name' => $salesOrderCustomer->customer_name,
                'email' => $salesOrderCustomer->customer_email,
                'cpf_cnpj' => $salesOrderCustomer->vat_number,
                'phone' => $orderAddressBilling->customer_cellphone,
                'business_name' => $salesOrderCustomer->customer_name,
                'ip' => request()->ip(),
                'billing_address' => [
                    'street' => $orderAddressBilling->street,
                    'number' => $orderAddressBilling->number,
                    "complement" => $orderAddressBilling->complement,
                    'district' => $orderAddressBilling->neighborhood ?? 'Centro',
                    'city' => $orderAddressBilling->city,
                    'state' => $orderAddressBilling->region,
                    'zipcode' => $orderAddressBilling->postcode
                ],
                'shipping_address' => [
                    'street' => $orderAddressShipping->street,
                    'number' => $orderAddressShipping->number,
                    "complement" => $orderAddressShipping->complement,
                    'district' => $orderAddressBilling->neighborhood ?? 'Centro',
                    'city' => $orderAddressShipping->city,
                    'state' => $orderAddressShipping->region,
                    'zipcode' => $orderAddressShipping->postcode
                ]
            ];

        }

        return $customer;

    }

    /**
     * Cria um array para o envio dos dados de pagamento para o IPag
     * @param \App\Models\SalesOrder $salesOrder
     * @param array $paymentData
     * @return \Idea\Framework\Services\Payments\Ipag\Model\PaymentTransaction
     */
    private function dataPayment(SalesOrder $salesOrder, array $paymentData): PaymentTransaction
    {

        // Retorna o Cliente do pedido
        $customer = $this->getOrderCustomer($salesOrder->order_id);

        // Retorna os Itens do Pedido
        $products = $this->getOrderItens($salesOrder->order_id);

        $data = [
            'amount' => $salesOrder->base_grand_total,
            'callback_url' => route('payments.callback'),
            'redirect_url' => route('payments.redirect'),
            'order_id' => $salesOrder->increment_id,
            'payment' => $paymentData,
            'customer' => $customer,
            'products' => $products
        ];

        // Retorna o PaymentTransaction (transação do pagamento)
        return new PaymentTransaction(
            $data
        );

    }

    /**
     * Metodo responsavel por validar o Pagamento do Pedido
     * @param $transactionId
     * @return \App\Models\SalesOrderStatus|void
     */
    public function checkPayment($transactionId)
    {

        try {

            // Inicializa o status da transação do pagamento
            $responseTransaction = $this->ipagClient->transaction()->get($transactionId);

            // Retorna o status do Pagamento do Pedido
            $statusPayment = $responseTransaction->getParsedPath('attributes.status.code');

            // Verifica o status retornado do pagamento
            switch ($statusPayment) {
                case PaymentStatus::CAPTURED:
                case PaymentStatus::PRE_AUTHORIZED:
                    return SalesOrderStatusRepository::getByCode('approved');

                case PaymentStatus::WAITING_PAYMENT:
                    return SalesOrderStatusRepository::getByCode('pending_payment');

                case PaymentStatus::DECLINED:
                case PaymentStatus::CANCELED:
                    return SalesOrderStatusRepository::getByCode('canceled');

                case PaymentStatus::IN_ANALYSIS:
                    return SalesOrderStatusRepository::getByCode('holded');

                case PaymentStatus::CHARGEDBACK:
                    return SalesOrderStatusRepository::getByCode('refunded');

                case PaymentStatus::IN_DISPUTE:
                    return SalesOrderStatusRepository::getByCode('in_dispute');

                default:
                    return SalesOrderStatusRepository::getByCode('pending');
            }

        } catch (HttpException $e) {

            $code = $e->getResponse()->getStatusCode();
            $errors = $e->getErrors();

            Log::error('ERRO NO IPAG', [
                'error_code' => $code,
                'errors' => $errors,
            ]);

        } catch (\Exception $e) {
            Log::error('ERRO NO IPAG', [
                'errors' => $e->getMessage(),
            ]);

        }

    }

    /**
     * Realiza o "pagamento" do metodo PIX para o IPag
     * @param \App\Models\SalesOrder $salesOrder
     * @return array
     */
    public function paymentPix(SalesOrder $salesOrder): array
    {

        // Inicializa a transaction
        $paymentTransaction = $this->dataPayment(
            salesOrder: $salesOrder,
            paymentData: [
                'type' => PaymentTypes::PIX,
                'method' => Others::PIX,
                'pix_expires_in' => 60
            ]
        );

        try {

            // Retorna o Pagamento do pedido
            $responsePayment = $this->ipagClient->payment()->create($paymentTransaction);

            // Retorna o QRCode do PIX
            $pixQrCodeBase64 = $responsePayment->getParsedPath('attributes.pix.qrcode_base64');

            // Se o QRCode nao for gerado, irá gerar nosso proprio
            if (!$pixQrCodeBase64) {

                // Gera o QRCode
                $qrcode = base64_encode(
                    QrCode::format('png')
                        ->size(300)
                        ->generate($responsePayment->getParsedPath('attributes.pix.qrcode'))
                );

                $pixQrCodeBase64 = "data:image/png;base64," . $qrcode;

            }

            return [
                'status_payment' => $responsePayment->getParsedPath('attributes.status.code'),
                'status_gateway' => $responsePayment->getParsedPath('attributes.gateway.code'),
                'status_acquirer' => $responsePayment->getParsedPath('attributes.acquirer.code'),
                'pix' => [
                    'link' => $responsePayment->getParsedPath('attributes.pix.link'),
                    'qrcode' => $responsePayment->getParsedPath('attributes.pix.qrcode'),
                    'qrcode_base64' => $pixQrCodeBase64, // qrCode
                ]
            ];

        } catch (HttpException $e) {

            // Gera os logs de erro
            Log::error('ERRO NO PIX DO IPAG', [
                'errors' => $e->getMessage(),
            ]);

            return [
                'status_payment' => 'canceled',
                'status_gateway' => 'canceled',
                'status_acquirer' => 'canceled',
                'pix' => [
                    'error' => 'Erro ao gerar PIX: ' . json_encode($e->getErrors())
                ]
            ];

        }

    }

    /**
     * Raliza o pagamento pelo Cartão de Crédito
     * @param \App\Models\SalesOrder $salesOrder
     * @param array $paymentCard
     * @return array
     */
    public function paymentCreditCard(SalesOrder $salesOrder, array $paymentCard): array
    {
        try {

            // Cria o Transaction para o Pagamento
            $paymentTransaction = $this->dataPayment(
                salesOrder: $salesOrder,
                paymentData: $this->paymentDataCreditCard($paymentCard),
            );

            // Executa pagamento
            $response = $this->ipagClient->payment()->create($paymentTransaction);

            // Cria o historico do pedido para logs
            SalesOrderHistoryRespository::createHistory(
                salesOrder: $salesOrder,
                attributes: [
                    'is_customer_notified' => false,
                    'is_visible_on_front' => false,
                    'comment' => json_encode(method_exists($response, 'toArray') ? $response->toArray() : $response),
                    'status_code' => 'IPAG RESPONSE RAW'
                ]
            );

            // Extrai status
            $statusPayment  = $response->getParsedPath('attributes.status.code');
            $statusGateway  = $response->getParsedPath('attributes.gateway.code');
            $statusAcquirer = $response->getParsedPath('attributes.acquirer.code');

            // Extrai a URL de autenticação para cartões 3ds
            $urlAuthentication = $response->getParsedPath('attributes.url_authentication');

            // Cria o historico do pedido para logs
            SalesOrderHistoryRespository::createHistory(
                salesOrder: $salesOrder,
                attributes: [
                    'is_customer_notified' => false,
                    'is_visible_on_front' => false,
                    'comment' => json_encode([
                        'order_id' => $salesOrder->increment_code,
                        'status_payment' => $statusPayment,
                        'status_gateway' => $statusGateway,
                        'status_acquirer' => $statusAcquirer,
                        'url_3ds' => $urlAuthentication,
                    ]),
                    'status_code' => 'IPAG STATUS'
                ]
            );

            // Valida a aprovação do pedido
            $isApproved =
                in_array($statusPayment, [
                    PaymentStatus::CAPTURED,
                    PaymentStatus::PRE_AUTHORIZED
                ]) &&
                $statusGateway === GatewayStatus::SUCCEED &&
                $statusAcquirer === AcquirerStatus::APPROVED_OR_COMPLETED_SUCCESSFULLY;

            SalesOrderHistoryRespository::createHistory(
                salesOrder: $salesOrder,
                attributes: [
                    'is_customer_notified' => false,
                    'is_visible_on_front' => false,
                    'comment' => json_encode([
                        'order_id' => $salesOrder->increment_code,
                        'approved' => $isApproved,
                    ]),
                    'status_code' => 'IPAG STATUS'
                ]
            );

            return [
                'success' => $isApproved,
                'requires_3ds' => !empty($urlAuthentication),
                'redirect_url' => $urlAuthentication,
                'status_payment' => $statusPayment,
            ];

        } catch (HttpException $e) {

            // Gera os logs de erro
            Log::error('ERRO NO CREDIT CARD DO IPAG', [
                'errors' => $e->getMessage(),
            ]);

            SalesOrderHistoryRespository::createHistory(
                salesOrder: $salesOrder,
                attributes: [
                    'is_customer_notified' => false,
                    'is_visible_on_front' => false,
                    'comment' => json_encode([
                        'order_id' => $salesOrder->increment_code,
                        'status_code' => $e->getResponse()->getStatusCode(),
                        'errors' => $e->getErrors(),
                    ]),
                    'status_code' => 'IPAG HTTP ERROR'
                ]
            );

            return [
                'success' => false,
                'requires_3ds' => false,
                'redirect_url' => null,
                'status_payment' => 'error',
            ];

        } catch (\Throwable $e) {

            // Gera os logs de erro
            Log::error('ERRO NO CREDIT CARD DO IPAG', [
                'errors' => $e->getMessage(),
            ]);

            SalesOrderHistoryRespository::createHistory(
                salesOrder: $salesOrder,
                attributes: [
                    'is_customer_notified' => false,
                    'is_visible_on_front' => false,
                    'comment' => json_encode([
                        'order_id' => $salesOrder->increment_code,
                        'message' => $e->getMessage(),
                        'trace' => $e->getTraceAsString(),
                    ]),
                    'status_code' => 'IPAG HTTP ERROR'
                ]
            );

            return [
                'success' => false,
                'requires_3ds' => false,
                'redirect_url' => null,
                'status_payment' => 'error',
            ];
        }
    }

    /**
     * Pagamento via Boleto
     * @param $salesOrder
     * @return array
     */
    public function paymentBankSlips($salesOrder): array
    {

        try {

            // Monta payload
            $paymentTransaction = $this->dataPayment(
                salesOrder: $salesOrder,
                paymentData: $this->paymentDataBoleto($salesOrder),
            );

            // Cria o Pagamento
            $response = $this->ipagClient->payment()->create($paymentTransaction);

            // Extrai as informaçções do boleto
            $statusPayment  = $response->getParsedPath('attributes.status.code');
            $statusGateway  = $response->getParsedPath('attributes.gateway.code');
            $statusAcquirer = $response->getParsedPath('attributes.acquirer.code');

            // Retorna a linha digitável do boleto
            $digitableLine = $response->getParsedPath('attributes.boleto.digitable_line');

            // Valida se o pedido foi aprovado
            $isApproved =
                in_array($statusPayment, [
                    PaymentStatus::CAPTURED,
                    PaymentStatus::PRE_AUTHORIZED
                ]) &&
                $statusGateway === GatewayStatus::SUCCEED &&
                $statusAcquirer === AcquirerStatus::APPROVED_OR_COMPLETED_SUCCESSFULLY;

            return [
                'success' => $isApproved,
                'redirect_url' => $response->getParsedPath('attributes.url_authentication'),
                'digitable_line' => $digitableLine,
                'link' => $response->getParsedPath('attributes.boleto.link'),
                'status_payment' => $statusPayment,
            ];

        } catch (HttpException $e) {

            // Gera os logs de erro
            Log::error('ERRO NO BOLETO DO IPAG', [
                'errors' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'status_payment' => 'canceled',
                'status_gateway' => 'canceled',
                'status_acquirer' => 'canceled',
                'boleto' => [
                    'error' => 'Erro ao gerar Boleto: ' . json_encode($e->getErrors())
                ]
            ];

        }

    }

    /**
     * Metodo responsavel por retornar o parcelamento
     * @param int $amountCents
     * @return array[]
     */
    public function getInstallments(int $amountCents): array
    {

        // Chaves (API_ID, API_KEY) armazenadas em config ou .env
        $apiId = config('services.ipag.api_id');
        $apiKey = config('services.ipag.api_key');
        $cacheKey = "ipag_installments_{$amountCents}";

        // Tenta recuperar do cache por 5 minutos
        $installments = Cache::remember($cacheKey, now()->addMinutes(5), function() use ($amountCents, $apiId, $apiKey) {
            try {
                // Chamada GET com Basic Auth, timeout e tentativas
                $response = Http::withBasicAuth($apiId, $apiKey)
                    ->retry(3, 1000)   // até 3 tentativas, 1s de delay
                    ->timeout(5)       // timeout de 5s
                    ->get('https://api.ipag.com.br/service/v2/checkout/installments', [
                        'amount' => $amountCents
                    ]);
            } catch (\Throwable $e) {
                Log::error("IPag installments error: {$e->getMessage()}");
                return [];
            }

            if (!$response->successful()) {
                Log::error("IPag installments response not OK: HTTP " . $response->status());
                return [];
            }

            $data = $response->json();

            $list = [];
            foreach ($data ?? [] as $item) {

                $list[] = [
                    'value'    => (int) $item['installment'],   // número de parcelas
                    'label'    => $item['description'],         // Descrição das parcelas
                    'amount'   => (int) $item['amount'],        // valor por parcela (centavos)
                    'interest' => (int) $item['interest'],                 // juros (centavos ou reais dependendo da API)
                ];
            }
            return $list;
        });

        // Se a API não retornar nada, forneça parcelamento padrão 1x sem juros
        if (empty($installments)) {
            return [[
                'value'    => 1,
                'label'    => '1x de R$ ' . number_format($amountCents, 2, ',', '.'),
                'amount'   => $amountCents,
                'total'    => $amountCents,
                'interest' => 0,
            ]];
        }

        return $installments;

    }

    /**
     * Metodo responsavel por consultar um pagamento
     */
    public function consult(SalesOrder $salesOrder, $transactionId)
    {

        // Realiza a consulta do pagamento do cartão
        $responsePayment = $this->ipagClient->payment()->getById($transactionId);

        // Retorna os dados do pagamento
        $data = $responsePayment->getData();

        // Valida o status do pagamento
        $salesOrderStatus = $this->checkPayment(
            transactionId: $transactionId
        );

        // Valida o status Cancelado
        if ($salesOrderStatus->status == 'canceled') {

            // Comentario padrao do sistema
            $historyComment = "Nao identificado o motivo do cancelamento";

            // Retorna a mensagem do gateway de pagamento
            if (!empty($data['attributes']['gateway']['message'])) {
                $historyComment = $data['attributes']['gateway']['message'];
            }

            // Cria o historico do pedido
            SalesOrderHistoryRespository::createHistory(
                salesOrder: $salesOrder,
                attributes: [
                    'is_customer_notified' => false,
                    'is_visible_on_front' => false,
                    'comment' => $historyComment,
                    'status_code' => $salesOrderStatus->status
                ]
            );

        } else if ($salesOrderStatus->status == 'approved') {
            // Cria o historico do pedido
            SalesOrderHistoryRespository::createHistory(
                salesOrder: $salesOrder,
                attributes: [
                    'is_customer_notified' => false,
                    'is_visible_on_front' => false,
                    'comment' => 'Pedido aprovado com sucesso',
                    'status_code' => $salesOrderStatus->status
                ]
            );

        }

        // Retorna o status do pedido
        return $salesOrderStatus;

    }

}
