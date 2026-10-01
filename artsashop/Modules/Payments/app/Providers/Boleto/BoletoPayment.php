<?php

namespace Modules\Payments\Providers\Boleto;

use App\Models\SalesOrder;
use Modules\Payments\Contracts\PaymentMethodInterface;

class BoletoPayment implements PaymentMethodInterface
{

    public function code(): string
    {
        return 'boleto';
    }

    public function label(): string
    {
        return 'Boleto';
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
            'qr_code' => '...',
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
        return 'payments::boleto.callout';
    }

    public function viewData(array $context = []): array
    {
        return [
            'message' => 'Ao finalizar a compra, o link do boleto será apresentado para impressão',
        ];
    }

}
