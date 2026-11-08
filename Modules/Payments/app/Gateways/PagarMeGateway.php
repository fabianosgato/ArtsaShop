<?php

namespace Modules\Payments\Gateways;

use Modules\Payments\Concerns\CustomerPayload;
use Modules\Payments\Concerns\ItensPayload;
use Modules\Payments\Contracts\GatewayConfigInterface;
use Modules\Payments\Contracts\GatewayInterface;
use Modules\Payments\Gateways\Pagarme\Core\PagarmeClient;
use Modules\Payments\Methods\PagarMeBoletoMethod;
use Modules\Payments\Methods\PagarMeCreditCardMethod;
use Modules\Payments\Methods\PagarMePixMethod;

class PagarMeGateway extends AbstractGateway implements GatewayInterface
{
    use CustomerPayload, ItensPayload;

    protected PagarmeClient $client;

    public function __construct(GatewayConfigInterface $config)
    {

        $this->client = new PagarmeClient(
            secretKey: $config->secretKey(),
            baseUrl: $config->baseUrl()
        );

        parent::__construct($config);
    }

    protected function registerMethods(): void
    {
        $this->methods = [
            'pix' => new PagarMePixMethod($this->client, $this->code()),
            'credit_card' => new PagarMeCreditCardMethod($this->client, $this->code()),
            'boleto' => new PagarMeBoletoMethod($this->client, $this->code()),
        ];
    }

    public function code(): string
    {
        return 'pagarme';
    }

    public function label(): string
    {
        return 'Pagar.me';
    }

    public function createOrder(array $payload): array
    {
        $response = $this->client->post('/orders', $payload);
        return $response->json();
    }

    public function refund(array $paymentInformation): array
    {
        $chargeId = $paymentInformation['charge_id'] ?? ($paymentInformation['charges'][0]['id'] ?? null);

        if (!$chargeId) {
            throw new \InvalidArgumentException('Charge ID não encontrado para estorno');
        }

        $amount = $paymentInformation['amount'] ?? $paymentInformation['paid_amount'] ?? 0;

        $response = $this->client->post("/charges/{$chargeId}/refund", [
            'amount' => $amount,
        ]);

        return $response->json();
    }

    public function getRecipients(): array
    {
        $response = $this->client->get('/recipients');
        return $response->json()['data'] ?? [];
    }

    public function validateWebhook(\Illuminate\Http\Request $request): bool
    {
        $signature = $request->header('X-PagarMe-Signature');

        if (empty($signature)) {
            return false;
        }

        $payload = $request->getContent();
        $secret = $this->config->webhookSecret();

        if (empty($secret)) {
            return false;
        }

        $expected = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expected, $signature);
    }

    public function handleWebhook(array $payload): array
    {
        // Normaliza o payload do webhook do Pagar.me
        return [
            'event' => $payload['type'] ?? null,
            'order_id' => $payload['order']['id'] ?? null,
            'order_code' => $payload['order']['code'] ?? null,
            'status' => $payload['order']['status'] ?? null,
            'charges' => $payload['order']['charges'] ?? [],
        ];
    }

    public function checkTransaction(string $transactionId): ?array
    {
        $response = $this->client->get("/charges/{$transactionId}");
        return $response->json();
    }
}