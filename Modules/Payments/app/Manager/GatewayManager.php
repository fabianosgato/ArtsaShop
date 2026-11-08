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
namespace Modules\Payments\Manager;

use Modules\Payments\Contracts;
use Modules\Payments\Gateways\IpagGateway;
use Modules\Payments\Gateways\PagarMeConfig;
use Modules\Payments\Gateways\PagarMeGateway;
use function getConfigData;

class GatewayManager
{
    protected array $gateways = [];
    protected ?string $activeGateway = null;

    public function __construct()
    {
        $this->registerGateways();
    }

    protected function registerGateways(): void
    {
        // Verifica se Pagar.me está ativo no banco
        $pagarmeActive = getConfigData('payments/pagarme/active') ?? config('payments.pagarme.active', false);
        if ($pagarmeActive) {
            $config = new PagarMeConfig();
            if ($config->isActive()) {
                $this->register('pagarme', new PagarMeGateway($config));
            }
        }

        // Verifica se IPag está ativo no banco
        $ipagActive = getConfigData('payments/ipag/active') ?? config('ipag.active', false);
        $ipagApiId = getConfigData('payments/ipag/ipag_merchantid') ?? config('services.ipag.api_id');
        $ipagApiKey = getConfigData('payments/ipag/production_ipag_key') ?? config('services.ipag.api_key');
        
        if (!empty($ipagApiId) && !empty($ipagApiKey) && $ipagActive) {
            $config = new \Modules\Payments\Gateways\IpagConfig();
            if ($config->isActive()) {
                $this->register('ipag', new IpagGateway($config));
            }
        }
    }

    public function register(string $code, Contracts\GatewayInterface $gateway): void
    {
        $this->gateways[$code] = $gateway;
    }

    public function getActive(): ?Contracts\GatewayInterface
    {
        if ($this->activeGateway && isset($this->gateways[$this->activeGateway])) {
            return $this->gateways[$this->activeGateway];
        }

        // Carrega gateway padrão do banco de dados
        $activeCode = getConfigData('payments/gateway/default') ?? config('payments.gateway.default', 'pagarme');

        if (isset($this->gateways[$activeCode]) && $this->gateways[$activeCode]->isAvailable()) {
            $this->activeGateway = $activeCode;
            return $this->gateways[$activeCode];
        }

        // Fallback: primeiro gateway disponível
        foreach ($this->gateways as $code => $gateway) {
            if ($gateway->isAvailable()) {
                $this->activeGateway = $code;
                return $gateway;
            }
        }

        return null;
    }

    public function setActive(string $code): void
    {
        if (!isset($this->gateways[$code])) {
            throw new \InvalidArgumentException("Gateway {$code} não registrado");
        }
        if (!$this->gateways[$code]->isAvailable()) {
            throw new \InvalidArgumentException("Gateway {$code} não está disponível");
        }
        $this->activeGateway = $code;
    }

    public function get(string $code): Contracts\GatewayInterface
    {
        if (!isset($this->gateways[$code])) {
            throw new \InvalidArgumentException("Gateway {$code} não registrado");
        }
        return $this->gateways[$code];
    }

    public function all(): array
    {
        return array_filter($this->gateways, fn($g) => $g->isAvailable());
    }

    public function getRegisteredCodes(): array
    {
        return array_keys($this->gateways);
    }
}
