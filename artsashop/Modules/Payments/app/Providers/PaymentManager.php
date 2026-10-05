<?php

namespace Modules\Payments\Providers;

use Modules\Payments\Contracts\PaymentMethodInterface;

class PaymentManager
{

    protected array $methods = [];

    public function gateway(): string
    {
        if (getConfigData('payments/ipag/active')) {
            return 'ipag';
        }

        if (getConfigData('payments/pagarme/active')) {
            return 'pagarme';
        }

        throw new \RuntimeException(
            'Nenhum gateway de pagamento está ativo.'
        );
    }

    public function register(PaymentMethodInterface $method): void
    {
        $this->methods[$method->code()] = $method;
    }

    public function all(array $context = []): array
    {

        return array_filter(
            $this->methods,
            fn($method) => $method->isAvailable($context)
        );
    }

    public function get(string $code): PaymentMethodInterface
    {
        if (!isset($this->methods[$code])) {
            throw new \InvalidArgumentException("Método de pagamento inválido");
        }

        return $this->methods[$code];
    }

}
