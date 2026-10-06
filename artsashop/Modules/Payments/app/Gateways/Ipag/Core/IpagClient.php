<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the EULA
 * that is bundled with this package in the file LICENSE.txt.
 *
 * Não editar ou acrescentar à este arquivo se você quiser fazer o upgrade para versões
 * mais recentes no futuro.
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
namespace Modules\Payments\Gateways\Ipag\Core;

use Modules\Payments\Gateways\Ipag\Endpoint\ChargeEndpoint;
use Modules\Payments\Gateways\Ipag\Endpoint\CheckoutEndpoint;
use Modules\Payments\Gateways\Ipag\Endpoint\CustomerEndpoint;
use Modules\Payments\Gateways\Ipag\Endpoint\EstablishmentEndpoint;
use Modules\Payments\Gateways\Ipag\Endpoint\PaymentEndpoint;
use Modules\Payments\Gateways\Ipag\Endpoint\PaymentLinksEndpoint;
use Modules\Payments\Gateways\Ipag\Endpoint\SellerEndpoint;
use Modules\Payments\Gateways\Ipag\Endpoint\SplitRulesEndpoint;
use Modules\Payments\Gateways\Ipag\Endpoint\SubscriptionEndpoint;
use Modules\Payments\Gateways\Ipag\Endpoint\SubscriptionPlanEndpoint;
use Modules\Payments\Gateways\Ipag\Endpoint\TokenEndpoint;
use Modules\Payments\Gateways\Ipag\Endpoint\TransactionEndpoint;
use Modules\Payments\Gateways\Ipag\Endpoint\TransferEndpoint;
use Modules\Payments\Gateways\Ipag\Endpoint\VoucherEndpoint;
use Modules\Payments\Gateways\Ipag\Endpoint\WebhookEndpoint;
use Modules\Payments\Gateways\Ipag\Http\Client\GuzzleHttpClient;
use Modules\Payments\Gateways\Ipag\IO\JsonSerializer;
use Psr\Log\LoggerInterface;

/**
 * IpagClient Class
 *
 * Classe principal do SDK. Responsável por instanciar os endpoint da API do IPag.
 */
class IpagClient extends Client
{

    /**
     * @param string $apiID API ID é a identificação do usuário.
     * @param string $apiKey API Key é a chave de acesso do usuário.
     * @param string $environment Ambiente de execução (IpagEnvironment::SANDBOX | IpagEnvironment::PRODUCTION).
     * @param string $version Versão da API (valor padrão = '2').
     */
    public function __construct(string $apiID, string $apiKey, string $environment, ?LoggerInterface $logger = null, string $version = IpagEnvironment::VERSION)
    {
        parent::__construct(
            new IpagEnvironment($environment),
            new GuzzleHttpClient(
                [
                    'headers' => [
                        'x-api-version' => $version,
                    ],
                    'auth' => [$apiID, $apiKey]
                ]
            ),
            new JsonSerializer(),
            $logger
        );
    }

    public function IpagClient()
    {
    }

    public function customer(): CustomerEndpoint
    {
        return CustomerEndpoint::make($this, $this);
    }

    public function subscriptionPlan(): SubscriptionPlanEndpoint
    {
        return SubscriptionPlanEndpoint::make($this, $this);
    }

    public function subscription(): SubscriptionEndpoint
    {
        return SubscriptionEndpoint::make($this, $this);
    }

    public function transaction(): TransactionEndpoint
    {
        return TransactionEndpoint::make($this, $this);
    }

    public function token(): TokenEndpoint
    {
        return TokenEndpoint::make($this, $this);
    }

    public function charge(): ChargeEndpoint
    {
        return ChargeEndpoint::make($this, $this);
    }

    public function establishment(): EstablishmentEndpoint
    {
        return EstablishmentEndpoint::make($this, $this);
    }

    public function transfer(): TransferEndpoint
    {
        return TransferEndpoint::make($this, $this);
    }

    public function paymentLinks(): PaymentLinksEndpoint
    {
        return PaymentLinksEndpoint::make($this, $this);
    }

    public function webhook(): WebhookEndpoint
    {
        return WebhookEndpoint::make($this, $this);
    }

    public function seller(): SellerEndpoint
    {
        return SellerEndpoint::make($this, $this);
    }

    public function splitRules(): SplitRulesEndpoint
    {
        return SplitRulesEndpoint::make($this, $this);
    }

    public function voucher(): VoucherEndpoint
    {
        return VoucherEndpoint::make($this, $this);
    }

    public function checkout(): CheckoutEndpoint
    {
        return CheckoutEndpoint::make($this, $this);
    }

    public function payment(): PaymentEndpoint
    {
        return PaymentEndpoint::make($this, $this);
    }

}
