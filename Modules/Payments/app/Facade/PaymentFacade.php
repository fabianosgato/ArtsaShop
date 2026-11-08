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
namespace Modules\Payments\Facade;

use App\Models\SalesOrder;
use Modules\Payments\Contracts;
use Modules\Payments\Manager\GatewayManager;

class PaymentFacade
{
    protected GatewayManager $manager;

    public function __construct(GatewayManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Retorna o gateway ativo (ou específico se código fornecido)
     */
    public function gateway(?string $code = null): Contracts\GatewayInterface
    {
        if ($code) {
            return $this->manager->get($code);
        }
        return $this->manager->getActive();
    }

    /**
     * Verifica se um método é suportado pelo gateway ativo
     */
    public function supports(string $methodCode, ?string $gatewayCode = null): bool
    {
        $gateway = $this->gateway($gatewayCode);
        return $gateway->supports($methodCode);
    }

    /**
     * Retorna instância do método de pagamento
     */
    public function method(string $methodCode, ?string $gatewayCode = null): \Modules\Payments\Contracts\PaymentMethodInterface
    {
        $gateway = $this->gateway($gatewayCode);
        return $gateway->getMethod($methodCode);
    }

    /**
     * Cria um pedido no gateway
     */
    public function createOrder(string $methodCode, array $payload, ?string $gatewayCode = null): array
    {
        $gateway = $this->gateway($gatewayCode);

        if (!$gateway->supports($methodCode)) {
            throw new \InvalidArgumentException("Método {$methodCode} não suportado pelo gateway ativo");
        }

        return $gateway->createOrder($payload);
    }

    /**
     * Processa pagamento (autoriza)
     */
    public function processPayment(
        SalesOrder $order,
        string $methodCode,
        array $data,
        ?string $gatewayCode = null
    ): array
    {
        $gateway = $this->gateway($gatewayCode);

        if (!$gateway->supports($methodCode)) {
            throw new \InvalidArgumentException("Método {$methodCode} não suportado pelo gateway ativo");
        }

        $method = $gateway->getMethod($methodCode);
        return $method->authorize($order, $data);
    }

    /**
     * Captura pagamento autorizado
     */
    public function capture(SalesOrder $order, string $methodCode, ?string $gatewayCode = null): array
    {
        $gateway = $this->gateway($gatewayCode);
        $method = $gateway->getMethod($methodCode);
        return $method->capture($order);
    }

    /**
     * Realiza estorno
     */
    public function refund(SalesOrder $order, float $amount, string $methodCode, ?string $gatewayCode = null): array
    {
        $gateway = $this->gateway($gatewayCode);
        $method = $gateway->getMethod($methodCode);
        return $method->refund($order, $amount);
    }

    /**
     * Estorno via gateway (para estorno direto no gateway)
     */
    public function gatewayRefund(array $paymentInformation, ?string $gatewayCode = null): array
    {
        $gateway = $this->gateway($gatewayCode);
        return $gateway->refund($paymentInformation);
    }

    /**
     * Retorna recebedores (para split/marketplace)
     */
    public function getRecipients(?string $gatewayCode = null): array
    {
        $gateway = $this->gateway($gatewayCode);
        return $gateway->getRecipients();
    }

    /**
     * Valida webhook
     */
    public function validateWebhook(\Illuminate\Http\Request $request, ?string $gatewayCode = null): bool
    {
        $gateway = $this->gateway($gatewayCode);
        return $gateway->validateWebhook($request);
    }

    /**
     * Processa webhook
     */
    public function handleWebhook(array $payload, ?string $gatewayCode = null): array
    {
        $gateway = $this->gateway($gatewayCode);
        return $gateway->handleWebhook($payload);
    }

    /**
     * Consulta transação
     */
    public function checkTransaction(string $transactionId, ?string $gatewayCode = null): ?array
    {
        $gateway = $this->gateway($gatewayCode);
        return $gateway->checkTransaction($transactionId);
    }

    /**
     * Retorna todos os gateways disponíveis
     */
    public function getAvailableGateways(): array
    {
        return $this->manager->all();
    }

    /**
     * Retorna métodos disponíveis do gateway ativo
     */
    public function getAvailableMethods(?string $gatewayCode = null): array
    {
        $gateway = $this->gateway($gatewayCode);
        return $gateway->getAvailableMethods();
    }

    /**
     * Define gateway ativo
     */
    public function setActiveGateway(string $code): void
    {
        $this->manager->setActive($code);
    }

    /**
     * Retorna código do gateway ativo
     */
    public function getActiveGatewayCode(): ?string
    {
        $gateway = $this->manager->getActive();
        return $gateway ? $gateway->code() : null;
    }
}
