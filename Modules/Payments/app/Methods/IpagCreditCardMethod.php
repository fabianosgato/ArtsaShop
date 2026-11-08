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
use Illuminate\Support\Facades\Log;
use Modules\Payments\Concerns\CustomerPayload;
use Modules\Payments\Concerns\ItensPayload;
use Modules\Payments\Gateways\Ipag\Core\Enums\AcquirerStatus;
use Modules\Payments\Gateways\Ipag\Core\Enums\GatewayStatus;
use Modules\Payments\Gateways\Ipag\Core\Enums\PaymentStatus;
use Modules\Payments\Gateways\Ipag\Core\IpagClient;
use Modules\Payments\Gateways\Ipag\Exception\HttpException;

class IpagCreditCardMethod extends AbstractMethod
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
        return 'credit_card';
    }

    public function label(): string
    {
        return 'Cartão de Crédito';
    }

    public function authorize(SalesOrder $order, array $data): array
    {
        $paymentTransaction = new \Modules\Payments\Gateways\Ipag\Model\PaymentTransaction([
            'amount' => $order->base_grand_total,
            'callback_url' => route('payments.callback'),
            'redirect_url' => route('payments.redirect'),
            'order_id' => $order->increment_id,
            'payment' => $this->paymentDataCreditCard($data),
            'customer' => $this->createCustomerPayload($order->order_id),
            'products' => $this->createPayloadOrderItens($order),
        ]);

        try {
            $response = $this->client->payment()->create($paymentTransaction);
            $data = $response->getData();

            $statusPayment = $data['attributes']['status']['code'] ?? null;
            $statusGateway = $data['attributes']['gateway']['code'] ?? null;
            $statusAcquirer = $data['attributes']['acquirer']['code'] ?? null;
            $urlAuthentication = $data['attributes']['url_authentication'] ?? null;

            $isApproved = in_array($statusPayment, [
                PaymentStatus::CAPTURED,
                PaymentStatus::PRE_AUTHORIZED
            ]) &&
            $statusGateway === GatewayStatus::SUCCEED &&
            $statusAcquirer === AcquirerStatus::APPROVED_OR_COMPLETED_SUCCESSFULLY;

            return [
                'success' => $isApproved,
                'requires_3ds' => !empty($urlAuthentication),
                'redirect_url' => $urlAuthentication,
                'status_payment' => $statusPayment,
                'additional_information' => [
                    'requires_3ds' => !empty($urlAuthentication),
                    'redirect_url' => $urlAuthentication,
                ],
            ];

        } catch (HttpException $e) {
            Log::error('ERRO NO CREDIT CARD DO IPAG', [
                'errors' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'requires_3ds' => false,
                'redirect_url' => null,
                'status_payment' => 'error',
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
        return 'payments::creditcard.callout';
    }

    public function viewData(array $context = []): array
    {
        $orderTotal = $context['quote']['grand_total'] ?? 0;

        // Usar o serviço existente do IPag para buscar parcelas
        $installments = app(\Modules\Payments\Gateways\Ipag\IpagPayment::class)
            ->getInstallments($context['quote']['grand_total'] ?? 0);

        return [
            'installments' => $installments,
        ];
    }

    public function isAvailable(array $context = []): bool
    {
        return true;
    }
}
