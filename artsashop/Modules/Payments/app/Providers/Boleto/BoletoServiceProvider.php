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

namespace Modules\Payments\Providers\Boleto;

use Illuminate\Support\ServiceProvider;
use Modules\Payments\Providers\PaymentManager;

class BoletoServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/payment.php', 'payments.boleto');
    }

    public function boot(PaymentManager $manager): void
    {
        $manager->register(new BoletoPayment());
    }

}
