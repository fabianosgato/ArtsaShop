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
use Modules\Payments\Gateways\Pagarme\Core\PagarmeClient;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PagarMePixMethod extends AbstractMethod
{
    use CustomerPayload, ItensPayload;

    protected PagarmeClient $client;

    public function __construct(PagarmeClient $client, string $gatewayCode)
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
        $payload = [
            'closed' => true,
            'customer' => $this->createCustomerPayload($order->order_id),
            'items' => $this->createPayloadOrderItens($order),
            'payments' => [
                [
                    'payment_method' => 'pix',
                    'pix' => [
                        'expires_in' => '1800',
                        'additional_information' => [
                            [
                                'name' => 'information',
                                'value' => 'number',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        // Realiza o post na API do Pagarme
        $response = $this->client->post(
            uri: '/orders',
            data: $payload
        )->json();

        // Extrai dados do QR Code PIX da resposta da API
        // Estrutura: charges[0].last_transaction.qr_code e qr_code_url
        $lastTransaction = $response['charges'][0]['last_transaction'] ?? [];
        $pixQrCode = $lastTransaction['qr_code'] ?? null;
        $pixQrCodeUrl = $lastTransaction['qr_code_url'] ?? null;
        $expiresAt = $lastTransaction['expires_at'] ?? null;

        // Gera QRCode base64 a partir do qr_code_url se disponível, senão usa o qr_code
        $pixQrCodeBase64 = null;
        if ($pixQrCodeUrl) {
            try {
                $qrResponse = $this->client->get($pixQrCodeUrl);
                if ($qrResponse->successful()) {
                    $pixQrCodeBase64 = "data:image/png;base64," . base64_encode($qrResponse->body());
                }
            } catch (\Throwable $e) {
                // Se falhar ao baixar, tenta gerar localmente
            }
        }

        if (!$pixQrCodeBase64 && $pixQrCode) {
            $qrcode = base64_encode(
                QrCode::format('png')
                    ->size(300)
                    ->generate($pixQrCode)
            );
            $pixQrCodeBase64 = "data:image/png;base64," . $qrcode;
        }

        // Adiciona as informações do PIX
        $response['pix'] = [
            'link' => $pixQrCodeUrl, // URL para obter o QR code
            'qrcode' => $pixQrCode, // Código PIX (emoji format)
            'qrcode_base64' => $pixQrCodeBase64, // QR code em base64
            'expires_at' => $expiresAt, // Data de expiração
        ];

        $response['additional_information'] = [
            'requires_3ds' => false,
        ];

        // Adiciona payment_method para identificação no checkResultPayment
        $response['payment_method'] = 'pix';

        return $response;
    }

    public function capture(SalesOrder $order): array
    {
        // PIX não tem capture separado, já é autorizado e capturado junto
        return ['status' => 'paid'];
    }

    public function refund(SalesOrder $order, float $amount): array
    {
        // Implementar estorno via SDK
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