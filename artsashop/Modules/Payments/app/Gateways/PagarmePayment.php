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
declare(strict_types=1);

namespace Modules\Payments\Gateways;

use App\Models\SalesOrder;
use Modules\Payments\Gateways\Pagarme\Core\PagarmeClient;
use Modules\Payments\Gateways\Pagarme\Order\PagarmeOrder;
use Modules\Payments\Gateways\Pagarme\Order\PagarmeRefund;
use Modules\Payments\Gateways\Pagarme\Types\PagarmeCreditCard;
use Modules\Payments\Gateways\Pagarme\Types\PagarmePix;

class PagarmePayment
{

    /**
     * Client da API Pagar.me
     */
    public PagarmeClient $pagarmeClient;

    /**
     * Ambiente atual do Pagar.me.
     */
    protected string $environment;

    public function __construct()
    {

        if (!boolval(getConfigData('payments/pagarme/active'))) {
            throw new \RuntimeException(
                'O módulo de pagamento Pagar.me está desabilitado.'
            );
        }

        $this->environment = strtoupper(
            (string)getConfigData('payments/pagarme/environment')
        );

        $this->pagarmeClient = new PagarmeClient(
            secretKey: $this->getConfig('secret_key'),
            baseUrl: (string)getConfigData('payments/pagarme/base_url')
        );

    }

    /**
     * Retorna uma configuração do Pagar.me
     * de acordo com o ambiente configurado.
     */
    private function getConfig(string $key): mixed
    {

        $environment = strtolower($this->environment);

        return getConfigData(
            "payments/pagarme/{$environment}_{$key}"
        );

    }

    /**
     * Retorna os recebedores cadastrados no Pagar.me.
     */
    public function getRecipients(): array
    {
        $response = $this->pagarmeClient->get(
            uri: '/recipients',
            query: [
                'page' => 1,
                'size' => 10,
            ]
        );

        return $response->json();
    }

    /**
     * Realzia o cancelamento da compra
     * @param array $paymentInformation
     * @return array
     */
    public function refund(
        array $paymentInformation
    ): array {

        $pagarmeRefund = new PagarmeRefund(
            client: $this->pagarmeClient
        );

        return $pagarmeRefund->create(
            paymentInformation: $paymentInformation
        );

    }

    /**
     * Retorna a instância do PagarmePix
     * @return \Modules\Payments\Gateways\Pagarme\Types\PagarmePix
     */
    protected function getPagarmePix(): PagarmePix
    {
        return new PagarmePix(
            order: new PagarmeOrder(
                client: $this->pagarmeClient
            )
        );
    }

    /**
     * Retorna a instância do PagarmePix
     * @return \Modules\Payments\Gateways\Pagarme\Types\PagarmeCreditCard
     */
    protected function getPagarmeCreditCard(): PagarmeCreditCard
    {
        return new PagarmeCreditCard(
            order: new PagarmeOrder(
                client: $this->pagarmeClient
            )
        );
    }

    public function processPayment(
        SalesOrder $salesOrder,
        string $paymentType,
        array $paymentPayload
    ): array
    {

        return match (strtoupper($paymentType)) {

            // Realiza a chamada do método de pagamento PIX
            'PIX' => $this->getPagarmePix()->create(
                salesOrder: $salesOrder
            ),

            // Realiza a chamada do método de pagamento CreditCard
            'CC' => $this->getPagarmeCreditCard()->create(
                salesOrder: $salesOrder,
                cardToken: $paymentPayload['card_token'],
                holderName: $paymentPayload['card_holder'],
                installments: intval($paymentPayload['card_installments'])
            ),

            default => throw new \InvalidArgumentException(
                "Meio de pagamento não suportado: {$paymentType}"
            ),

        };

    }

}
