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
namespace Idea\Framework\Services\Payments\Concerns;

use App\Models\SalesOrder;
use Carbon\Carbon;
use Idea\Framework\Services\Payments\Ipag\Core\Enums\BankSlips;
use Idea\Framework\Services\Payments\Ipag\Core\Enums\PaymentTypes;

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
