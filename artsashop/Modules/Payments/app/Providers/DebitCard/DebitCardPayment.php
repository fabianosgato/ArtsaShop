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
namespace Modules\Payments\Providers\DebitCard;

use App\Models\SalesOrder;
use Modules\Payments\Contracts\PaymentMethodInterface;

class DebitCardPayment implements PaymentMethodInterface
{

    public function code(): string
    {
        return 'debit_card';
    }

    public function label(): string
    {
        return "Cartão de Débito";
    }

    public function isAvailable(array $context = []): bool
    {
        return true; // regras: valor mínimo, país, etc
    }

    public function authorize(SalesOrder $order, array $data): array
    {
        // gera QRCode
        return [
            'status' => 'authorized',
        ];
    }

    public function capture(SalesOrder $order): array
    {
        return ['status' => 'paid'];
    }

    public function refund(SalesOrder $order, float $amount): array
    {
        return ['status' => 'refunded'];
    }

    public function view(): string
    {
        return 'payments::debitcard.callout';
    }

    public function viewData(array $context = []): array
    {
        return [
            'message' => 'Ao finalizar a compra, um QR Code PIX será exibido para pagamento.',
        ];
    }

}
