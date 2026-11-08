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
namespace Modules\Payments\Gateways;

use Modules\Payments\Concerns\CustomerPayload;
use Modules\Payments\Concerns\ItensPayload;
use Modules\Payments\Contracts\GatewayConfigInterface;
use Modules\Payments\Contracts\GatewayInterface;
use Modules\Payments\Methods\IpagBoletoMethod;
use Modules\Payments\Methods\IpagCreditCardMethod;
use Modules\Payments\Methods\IpagPixMethod;

class IpagGateway extends AbstractGateway implements GatewayInterface
{
    use CustomerPayload, ItensPayload;

    protected Ipag\Core\IpagClient $client;

    public function __construct(GatewayConfigInterface $config)
    {
        $this->client = new Ipag\Core\IpagClient(
            apiID: $config->apiId(),
            apiKey: $config->apiKey(),
            environment: $config->environment() === 'sandbox'
                ? Ipag\Core\IpagEnvironment::SANDBOX
                : Ipag\Core\IpagEnvironment::PRODUCTION
        );
        
        parent::__construct($config);
    }

    protected function registerMethods(): void
    {
        $this->methods = [
            'pix' => new IpagPixMethod($this->client, $this->code()),
            'credit_card' => new IpagCreditCardMethod($this->client, $this->code()),
            'boleto' => new IpagBoletoMethod($this->client, $this->code()),
        ];
    }

    public function code(): string
    {
        return 'ipag';
    }

    public function label(): string
    {
        return 'IPag';
    }

    public function createOrder(array $payload): array
    {
        $transaction = new Ipag\Model\PaymentTransaction($payload);
        $response = $this->client->payment()->create($transaction);
        return $response->getData();
    }

    public function refund(array $paymentInformation): array
    {
        $transactionId = $paymentInformation['transaction_id'] ?? $paymentInformation['id'] ?? null;

        if (!$transactionId) {
            throw new \InvalidArgumentException('Transaction ID não encontrado para estorno');
        }

        $response = $this->client->payment()->refund($transactionId, [
            'amount' => $paymentInformation['amount'] ?? $paymentInformation['paid_amount'] ?? 0,
        ]);

        return $response->getData();
    }

    public function getRecipients(): array
    {
        // IPag não tem conceito de recipients como Pagar.me
        return [];
    }

    public function validateWebhook(\Illuminate\Http\Request $request): bool
    {
        $signature = $request->header('X-Ipag-Signature');

        if (empty($signature)) {
            return false;
        }

        $payload = $request->getContent();
        $secret = $this->config->webhookSecret();

        if (empty($secret)) {
            return false;
        }

        $expected = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expected, $signature);
    }

    public function handleWebhook(array $payload): array
    {
        return [
            'event' => $payload['attributes']['status']['code'] ?? null,
            'order_id' => $payload['attributes']['order_id'] ?? null,
            'transaction_id' => $payload['id'] ?? null,
            'status' => $payload['attributes']['status']['code'] ?? null,
        ];
    }

    public function checkTransaction(string $transactionId): ?array
    {
        $response = $this->client->transaction()->get($transactionId);
        return $response->getData();
    }
}
