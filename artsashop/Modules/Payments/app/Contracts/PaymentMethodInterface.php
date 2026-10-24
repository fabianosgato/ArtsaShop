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

interface PaymentMethodInterface
{
    public function code(): string;

    public function label(): string;

    public function isAvailable(array $context = []): bool;

    public function authorize(SalesOrder $order, array $data): array;

    public function capture(SalesOrder $order): array;

    public function refund(SalesOrder $order, float $amount): array;

    public function view(): string;

    public function viewData(array $context = []): array;

}
