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
namespace Modules\Payments\Contracts;

use Illuminate\Http\Request;

interface GatewayInterface
{
    /**
     * Código único do gateway (ex: 'pagarme', 'ipag', 'stripe')
     */
    public function code(): string;

    /**
     * Nome amigável do gateway
     */
    public function label(): string;

    /**
     * Verifica se o gateway está disponível (credenciais configuradas, ativo)
     */
    public function isAvailable(): bool;

    /**
     * Verifica se o gateway suporta um método de pagamento específico
     */
    public function supports(string $methodCode): bool;

    /**
     * Retorna a instância do método de pagamento
     */
    public function getMethod(string $methodCode): PaymentMethodInterface;

    /**
     * Retorna todos os métodos de pagamento disponíveis neste gateway
     */
    public function getAvailableMethods(): array;

    /**
     * Cria um pedido no gateway
     */
    public function createOrder(array $payload): array;

    /**
     * Processa estorno
     */
    public function refund(array $paymentInformation): array;

    /**
     * Retorna recebedores (para split/marketplace)
     */
    public function getRecipients(): array;

    /**
     * Valida assinatura do webhook
     */
    public function validateWebhook(Request $request): bool;

    /**
     * Processa webhook e retorna dados normalizados
     */
    public function handleWebhook(array $payload): array;

    /**
     * Consulta status de uma transação
     */
    public function checkTransaction(string $transactionId): ?array;
}
