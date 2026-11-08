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

use Illuminate\Http\Request;
use Modules\Payments\Contracts\GatewayConfigInterface;
use Modules\Payments\Contracts\GatewayInterface;
use Modules\Payments\Contracts\PaymentMethodInterface;
use Modules\Payments\Exceptions\GatewayException;

abstract class AbstractGateway implements GatewayInterface
{
    protected array $methods = [];
    protected GatewayConfigInterface $config;

    public function __construct(GatewayConfigInterface $config)
    {
        $this->config = $config;
        $this->registerMethods();
    }

    abstract protected function registerMethods(): void;

    public function isAvailable(): bool
    {
        return $this->config->isActive();
    }

    public function supports(string $methodCode): bool
    {
        return isset($this->methods[$methodCode]);
    }

    public function getMethod(string $methodCode): PaymentMethodInterface
    {
        if (!$this->supports($methodCode)) {
            throw new \InvalidArgumentException("Método {$methodCode} não suportado pelo gateway " . $this->code());
        }
        return $this->methods[$methodCode];
    }

    public function getAvailableMethods(): array
    {
        return array_values($this->methods);
    }

    public function createOrder(array $payload): array
    {
        throw new \BadMethodCallException('Método createOrder não implementado no gateway ' . $this->code());
    }

    public function refund(array $paymentInformation): array
    {
        throw new \BadMethodCallException('Método refund não implementado no gateway ' . $this->code());
    }

    public function getRecipients(): array
    {
        throw new \BadMethodCallException('Método getRecipients não implementado no gateway ' . $this->code());
    }

    public function validateWebhook(Request $request): bool
    {
        throw new \BadMethodCallException('Método validateWebhook não implementado no gateway ' . $this->code());
    }

    public function handleWebhook(array $payload): array
    {
        throw new \BadMethodCallException('Método handleWebhook não implementado no gateway ' . $this->code());
    }

    public function checkTransaction(string $transactionId): ?array
    {
        throw new \BadMethodCallException('Método checkTransaction não implementado no gateway ' . $this->code());
    }

    protected function validateResponse(array $response): void
    {
        if (isset($response['errors']) && !empty($response['errors'])) {
            $message = $response['errors'][0]['message'] ?? 'Erro no gateway';
            throw new GatewayException(
                message: $message,
                gatewayCode: $this->code(),
                responseData: $response
            );
        }
    }
}
