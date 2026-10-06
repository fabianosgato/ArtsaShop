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
namespace Modules\Payments\Factories;

use Modules\Payments\Gateways\IpagPayment;
use Modules\Payments\Gateways\PagarmePayment;
use Modules\Payments\Providers\PaymentManager;

class PaymentGatewayFactory
{
    public function __construct(
        protected PaymentManager $paymentManager
    ) {
    }

    public function make(): IpagPayment|PagarmePayment
    {

        return match ($this->paymentManager->gateway()) {
            'ipag' => app(IpagPayment::class),
            'pagarme' => app(PagarmePayment::class),

            default => throw new \RuntimeException(
                'Gateway de pagamento não encontrado.'
            ),
        };
    }
}
