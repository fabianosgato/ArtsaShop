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
namespace Modules\Payments\Providers\CreditCard;

use Illuminate\Support\ServiceProvider;
use Modules\Payments\Providers\PaymentManager;

class CreditCardServiceProvider extends ServiceProvider
{

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/config/payment.php', 'payments.creditcard');
    }

    public function boot(PaymentManager $manager): void
    {
        $manager->register(new CreditCardPayment());
    }

}
