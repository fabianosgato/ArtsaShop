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
use Modules\Payments\Gateways\Pagarme\Exception\PagarmeException;

class PagarMeCreditCardMethod extends AbstractMethod
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
        return 'credit_card';
    }

    public function label(): string
    {
        return 'Cartão de Crédito';
    }

    public static function getCreditCardToken(array $cardData, string $publicKey): array
    {
        $response = \Illuminate\Support\Facades\Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("https://api.pagar.me/core/v5/tokens?appId={$publicKey}", [
            'type' => 'card',
            'card' => $cardData
        ]);

        return $response->json();
    }

    public function authorize(SalesOrder $order, array $data): array
    {
        $payload = [
            'closed' => true,
            'code' => $order->increment_code,
            'customer' => $this->createCustomerPayload($order->order_id),
            'items' => $this->createPayloadOrderItens($order),
            'payments' => [
                [
                    'payment_method' => 'credit_card',
                    'credit_card' => [
                        'operation_type' => $data['operation_type'] ?? 'auth_and_capture',
                        'installments' => $data['installments'] ?? 1,
                        'statement_descriptor' => $data['statement_descriptor'] ?? 'EXAMIX',
                        'card_token' => $data['card_token'],
                        'card' => [
                            'holder_name' => $data['card_holder'] ?? '',
                            'billing_address' => $this->createCustomerPayload($order->order_id)['address'] ?? [],
                        ],
                    ],
                ],
            ],
        ];

        try {
            // Realiza o post na API do Pagarme
            $response = $this->client->post(
                uri: '/orders',
                data: $payload
            )->json();

            // Adiciona payment_method para identificação no checkResultPayment
            $response['payment_method'] = 'credit_card';

            return $response;

        } catch (PagarmeException $e) {
            // Trata erro de token inválido
            if (str_contains($e->getMessage(), 'Token not found')) {
                throw new \InvalidArgumentException(
                    'Token do cartão inválido ou expirado. Por favor, tente novamente.'
                );
            }

            // Re-lança outros erros do Pagar.me
            throw $e;
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

        return [
            'installments' => $this->getInstallments($orderTotal),
        ];
    }

    /**
     * Retorna opções de parcelamento para cartão de crédito.
     * 
     * NOTA: A API Pagar.me v5 não expõe endpoint público de parcelas (/installments retorna 404).
     * O parcelamento é configurado no dashboard do Pagar.me e/ou via regras de negócio.
     * Este método usa fallback baseado na configuração do sistema.
     *
     * @param int $amount Valor em centavos
     * @param string|null $brand Bandeira do cartão (opcional, para futura integração)
     * @return array
     */
    public function getInstallments(int $amount, ?string $brand = null): array
    {
        return $this->getDefaultInstallments($amount);
    }

    /**
     * Parcelamento padrão baseado na configuração do sistema
     */
    private function getDefaultInstallments(int $amount): array
    {
        $installments = [];
        $maxInstallments = config('payments.methods.credit_card.max_installments', 12);
        $minInstallmentValue = config('payments.methods.credit_card.min_installment_value', 20000);
        
        for ($i = 1; $i <= $maxInstallments; $i++) {
            $installmentAmount = $i === 1 ? $amount : (int) ceil($amount / $i);
            
            // Pula parcelas onde o valor da parcela é menor que o mínimo configurado
            if ($i > 1 && $installmentAmount < $minInstallmentValue) {
                continue;
            }
            
            $total = $installmentAmount * $i;
            
            $installments[] = [
                'value' => $i,
                'label' => $i . 'x de ' . number_format($installmentAmount / 100, 2, ',', '.')
                    . ($i === 1 ? ' (à vista)' : ' (com juros)')
                    . ' = Total: ' . number_format($total / 100, 2, ',', '.'),
            ];
        }

        return $installments;
    }

    public function isAvailable(array $context = []): bool
    {
        return true;
    }
}