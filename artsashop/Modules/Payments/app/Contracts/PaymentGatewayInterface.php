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
namespace Modules\Payments\Contracts;

use App\Models\SalesOrder;

interface PaymentGatewayInterface
{

    public function paymentPix(
        SalesOrder $salesOrder
    ): array;

    public function paymentCreditCard(
        SalesOrder $salesOrder,
        array $paymentCard
    ): array;

    public function paymentBankSlips(
        SalesOrder $salesOrder
    ): array;

    public function checkPayment(
        string $transactionId
    );

    public function consult(
        SalesOrder $salesOrder,
        string $transactionId
    );


}
