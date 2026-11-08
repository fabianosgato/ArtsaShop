<?php

namespace Modules\Payments\Methods;

use App\Models\SalesOrder;
use Modules\Payments\Concerns\CustomerPayload;
use Modules\Payments\Concerns\ItensPayload;
use Modules\Payments\Gateways\Pagarme\Core\PagarmeClient;

class PagarMeBoletoMethod extends AbstractMethod
{
    use CustomerPayload, ItensPayload;

    protected PagarmeClient $client;

    public function __construct(PagarmeClient $client, string $gatewayCode)
    {
        parent::__construct($gatewayCode);
        $this->client = $client;
    }

    public function code(): string
    {
        return 'boleto';
    }

    public function label(): string
    {
        return 'Boleto';
    }

    public function authorize(SalesOrder $order, array $data): array
    {
        return [
            'success' => false,
            'message' => 'Boleto não disponível no momento',
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
            'message' => 'Boleto não disponível no momento',
        ];
    }

    public function isAvailable(array $context = []): bool
    {
        return false;
    }
}
