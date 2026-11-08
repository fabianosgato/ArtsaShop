<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * Não editar ou acrescentar a este arquivo se você quiser fazer o upgrade para versões
 * mais recentes no futuro.
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
namespace Modules\Payments\Gateways;

use Modules\Payments\Contracts\GatewayConfigInterface;
use function getConfigData;

class PagarMeConfig implements GatewayConfigInterface
{
    public function environment(): string
    {
        return strtolower(getConfigData('payments/pagarme/environment') ?? config('payments.pagarme.environment', 'sandbox'));
    }

    public function baseUrl(): string
    {
        return getConfigData('payments/pagarme/base_url') ?? config('payments.pagarme.base_url', 'https://api.pagar.me/core/v5');
    }

    public function secretKey(): string
    {
        $env = $this->environment();
        $key = $env === 'production' ? 'production_secret_key' : 'sandbox_secret_key';
        return getConfigData("payments/pagarme/{$key}") ?? config("payments.pagarme.{$key}");
    }

    public function publicKey(): string
    {
        $env = $this->environment();
        $key = $env === 'production' ? 'production_public_key' : 'sandbox_public_key';
        return getConfigData("payments/pagarme/{$key}") ?? config("payments.pagarme.{$key}");
    }

    public function accountId(): string
    {
        $env = $this->environment();
        $key = $env === 'production' ? 'production_account_id' : 'sandbox_account_id';
        return getConfigData("payments/pagarme/{$key}") ?? config("payments.pagarme.{$key}");
    }

    public function webhookSecret(): string
    {
        return getConfigData('payments/pagarme/webhook_secret') ?? config('payments.pagarme.webhook_secret');
    }

    /**
     * ID da API (para Pagar.me)
     */
    public function apiId(): string
    {
        return $this->accountId();
    }

    /**
     * Chave da API (para Pagar.me)
     */
    public function apiKey(): string
    {
        return $this->secretKey();
    }

    public function isActive(): bool
    {
        $active = getConfigData('payments/pagarme/active') ?? config('payments.pagarme.active', false);
        return (bool) $active && !empty($this->secretKey());
    }
}