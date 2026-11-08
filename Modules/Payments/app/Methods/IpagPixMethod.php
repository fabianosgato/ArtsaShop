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
use Modules\Payments\Gateways\Ipag\Core\Enums\Others;
use Modules\Payments\Gateways\Ipag\Core\Enums\PaymentTypes;
use Modules\Payments\Gateways\Ipag\Core\IpagClient;
use Modules\Payments\Gateways\Ipag\Exception\HttpException;
use Modules\Payments\Gateways\Ipag\Model\PaymentTransaction;

class IpagPixMethod extends AbstractMethod
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
        return 'pix';
    }

    public function label(): string
    {
        return 'PIX';
    }

    public function authorize(SalesOrder $order, array $data): array
    {
        $paymentTransaction = new PaymentTransaction([
            'amount' => $order->base_grand_total,
            'callback_url' => route('payments.callback'),
            'redirect_url' => route('payments.redirect'),
            'order_id' => $order->increment_id,
            'payment' => [
                'type' => PaymentTypes::PIX,
                'method' => Others::PIX,
                'pix_expires_in' => 60
            ],
            'customer' => $this->createCustomerPayload($order->order_id),
            'products' => $this->createPayloadOrderItens($order),
        ]);

        try {
            $response = $this->client->payment()->create($paymentTransaction);
            $data = $response->getData();

            $pixQrCodeBase64 = $data['attributes']['pix']['qrcode_base64'] ?? null;

            if (!$pixQrCodeBase64) {
                $qrcode = base64_encode(
                    \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')
                        ->size(300)
                        ->generate($data['attributes']['pix']['qrcode'])
                );
                $pixQrCodeBase64 = "data:image/png;base64," . $qrcode;
            } else {
                $pixQrCodeBase64 = $data['attributes']['pix']['qrcode_base64'];
            }

            return [
                'status' => $data['attributes']['status']['code'] ?? 'pending_payment',
                'pix' => [
                    'link' => $data['attributes']['pix']['link'] ?? null,
                    'qrcode' => $data['attributes']['pix']['qrcode'] ?? null,
                    'qrcode_base64' => $pixQrCodeBase64,
                ],
                'additional_information' => [
                    'requires_3ds' => false,
                ],
            ];

        } catch (HttpException $e) {
            \Illuminate\Support\Facades\Log::error('ERRO NO PIX DO IPAG', [
                'errors' => $e->getMessage(),
            ]);

            return [
                'status' => 'canceled',
                'pix' => [
                    'error' => 'Erro ao gerar PIX: ' . json_encode($e->getErrors())
                ]
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
        return 'payments::pix.callout';
    }

    public function viewData(array $context = []): array
    {
        return [
            'message' => 'Ao finalizar a compra, um QR Code PIX será exibido para pagamento.',
        ];
    }

    public function isAvailable(array $context = []): bool
    {
        return true;
    }
}
