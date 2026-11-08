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
namespace Modules\Payments\Gateways\Ipag\Concerns;

use App\Models\SalesOrder;
use Carbon\Carbon;
use Modules\Payments\Enums\PaymentTypes;
use Modules\Payments\Gateways\Ipag\Core\Enums\BankSlips;

trait BankSlip
{

    public function paymentDataBoleto(SalesOrder $salesOrder): array
    {

        return [
            "type" => PaymentTypes::BOLETO,
            "method" => (config('app.env') == 'production' ? BankSlips::PAGSEGURO : BankSlips::SIMULADO),
            "boleto" => [
                "due_date" => Carbon::now()->addWeekdays(5)->format('Y-m-d'),
                "instructions" => [
                    "Sr. Caixa não receber após o vencimento",
                    "Boleto referente ao pedido #{$salesOrder->increment_id}"
                ]
            ]
        ];

    }

}
