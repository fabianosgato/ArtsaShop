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
