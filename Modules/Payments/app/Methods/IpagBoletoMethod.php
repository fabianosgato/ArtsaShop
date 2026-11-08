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
namespace Modules\Payments\Methods;

use App\Models\SalesOrder;
use Modules\Payments\Concerns\CustomerPayload;
use Modules\Payments\Concerns\ItensPayload;
use Modules\Payments\Gateways\Ipag\Core\Enums\AcquirerStatus;
use Modules\Payments\Gateways\Ipag\Core\Enums\GatewayStatus;
use Modules\Payments\Gateways\Ipag\Core\Enums\PaymentStatus;
use Modules\Payments\Gateways\Ipag\Core\IpagClient;
use Modules\Payments\Gateways\Ipag\Exception\HttpException;
use Modules\Payments\Gateways\Ipag\Model\PaymentTransaction;

class IpagBoletoMethod extends AbstractMethod
{
    use CustomerPayload, ItensPayload;

    protected IpagClient $client;

    public function __construct(IpagClient $client, string $gatewayCode)
    {
        parent::__construct($gatewayCode);
        $this->client = $client;
    }

    public function code(): string
    {
        return 'boleto';
    }

    public function label(): string
    {
        return 'Boleto';
    }

    public function authorize(SalesOrder $order, array $data): array
    {
        $paymentTransaction = new PaymentTransaction([
            'amount' => $order->base_grand_total,
            'callback_url' => route('payments.callback'),
            'redirect_url' => route('payments.redirect'),
            'order_id' => $order->increment_id,
            'payment' => $this->paymentDataBoleto($data),
            'customer' => $this->createCustomerPayload($order->order_id),
            'products' => $this->createPayloadOrderItens($order),
        ]);

        try {
            $response = $this->client->payment()->create($paymentTransaction);
            $data = $response->getData();

            $statusPayment = $data['attributes']['status']['code'] ?? null;
            $statusGateway = $data['attributes']['gateway']['code'] ?? null;
            $statusAcquirer = $data['attributes']['acquirer']['code'] ?? null;

            $isApproved = in_array($statusPayment, [
                PaymentStatus::CAPTURED,
                PaymentStatus::PRE_AUTHORIZED
            ]) &&
            $statusGateway === GatewayStatus::SUCCEED &&
            $statusAcquirer === AcquirerStatus::APPROVED_OR_COMPLETED_SUCCESSFULLY;

            return [
                'success' => $isApproved,
                'redirect_url' => $data['attributes']['url_authentication'] ?? null,
                'digitable_line' => $data['attributes']['boleto']['digitable_line'] ?? null,
                'link' => $data['attributes']['boleto']['link'] ?? null,
                'status_payment' => $statusPayment,
            ];

        } catch (HttpException $e) {
            \Illuminate\Support\Facades\Log::error('ERRO NO BOLETO DO IPAG', [
                'errors' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'status_payment' => 'canceled',
            ];
        }
    }

    public function capture(SalesOrder $order): array
    {
        return ['status' => 'paid'];
    }

    public function refund(SalesOrder $order, float $amount): array
    {
        return ['status' => 'refunded'];
    }

    public function view(): string
    {
        return 'payments::boleto.callout';
    }

    public function viewData(array $context = []): array
    {
        return [
            'message' => 'Ao finalizar a compra, o link do boleto será apresentado para impressão',
        ];
    }

    public function isAvailable(array $context = []): bool
    {
        return true;
    }

    private function paymentDataBoleto(array $data)
    {
    }
}
