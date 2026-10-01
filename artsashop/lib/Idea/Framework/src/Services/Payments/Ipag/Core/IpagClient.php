<?php

namespace Idea\Framework\Services\Payments\Ipag\Core;

use Idea\Framework\Services\Payments\Ipag\Endpoint\ChargeEndpoint;
use Idea\Framework\Services\Payments\Ipag\Endpoint\CheckoutEndpoint;
use Idea\Framework\Services\Payments\Ipag\Endpoint\CustomerEndpoint;
use Idea\Framework\Services\Payments\Ipag\Endpoint\EstablishmentEndpoint;
use Idea\Framework\Services\Payments\Ipag\Endpoint\PaymentEndpoint;
use Idea\Framework\Services\Payments\Ipag\Endpoint\PaymentLinksEndpoint;
use Idea\Framework\Services\Payments\Ipag\Endpoint\SellerEndpoint;
use Idea\Framework\Services\Payments\Ipag\Endpoint\SplitRulesEndpoint;
use Idea\Framework\Services\Payments\Ipag\Endpoint\SubscriptionEndpoint;
use Idea\Framework\Services\Payments\Ipag\Endpoint\SubscriptionPlanEndpoint;
use Idea\Framework\Services\Payments\Ipag\Endpoint\TokenEndpoint;
use Idea\Framework\Services\Payments\Ipag\Endpoint\TransactionEndpoint;
use Idea\Framework\Services\Payments\Ipag\Endpoint\TransferEndpoint;
use Idea\Framework\Services\Payments\Ipag\Endpoint\VoucherEndpoint;
use Idea\Framework\Services\Payments\Ipag\Endpoint\WebhookEndpoint;
use Idea\Framework\Services\Payments\Ipag\Http\Client\GuzzleHttpClient;
use Idea\Framework\Services\Payments\Ipag\IO\JsonSerializer;
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
     * @param string Ambiente de execução (IpagEnvironment::SANDBOX | IpagEnvironment::PRODUCTION).
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
