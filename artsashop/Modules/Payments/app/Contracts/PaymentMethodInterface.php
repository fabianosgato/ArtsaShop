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
