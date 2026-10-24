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
