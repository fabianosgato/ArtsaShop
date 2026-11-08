<?php

namespace Modules\Payments\Gateways;

use Modules\Payments\Contracts\GatewayConfigInterface;
use function getConfigData;

class IpagConfig implements GatewayConfigInterface
{
    public function environment(): string
    {
        return strtolower(getConfigData('payments/ipag/environment') ?? config('services.ipag.api_env', 'sandbox'));
    }

    public function baseUrl(): string
    {
        $env = $this->environment();
        $key = $env === 'production' ? 'production_base_url' : 'sandbox_base_url';
        return getConfigData("payments/ipag/{$key}") ?? ($env === 'sandbox'
            ? 'https://api.ipag.com.br/sandbox'
            : 'https://api.ipag.com.br/production');
    }

    public function secretKey(): string
    {
        return getConfigData('payments/ipag/production_ipag_key') ?? config('services.ipag.api_key');
    }

    public function publicKey(): string
    {
        return getConfigData('payments/ipag/ipag_merchantid') ?? config('services.ipag.api_id');
    }

    /**
     * ID da API (para IPag)
     */
    public function apiId(): string
    {
        return $this->publicKey();
    }

    /**
     * Chave da API (para IPag)
     */
    public function apiKey(): string
    {
        return $this->secretKey();
    }

    public function accountId(): string
    {
        return $this->publicKey();
    }

    public function webhookSecret(): string
    {
        return getConfigData('payments/ipag/webhook_secret') ?? config('services.ipag.webhook_secret');
    }

    public function isActive(): bool
    {
        $active = getConfigData('payments/ipag/active') ?? config('ipag.active', false);
        return (bool) $active && !empty($this->apiId()) && !empty($this->apiKey());
    }
}