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
namespace Modules\Payments\Methods;

use App\Models\SalesOrder;
use Modules\Payments\Contracts\PaymentMethodInterface;

abstract class AbstractMethod implements PaymentMethodInterface
{
    protected string $gatewayCode;

    public function __construct(string $gatewayCode)
    {
        $this->gatewayCode = $gatewayCode;
    }

    public function capture(SalesOrder $order): array
    {
        throw new \BadMethodCallException('Método capture não implementado no método ' . $this->code());
    }

    public function refund(SalesOrder $order, float $amount): array
    {
        throw new \BadMethodCallException('Método refund não implementado no método ' . $this->code());
    }

    public function viewData(array $context = []): array
    {
        return [];
    }
}
