<?php

namespace Tests\Unit\Payments\Gateways;

use Idea\Framework\Repository\Sales\SalesOrderRepository;
use Modules\Payments\Gateways\PagarmePayment;
use Tests\TestCase;

class PagarmePaymentTest extends TestCase
{

    // Preparação
    // Execução
    // Verificação

    public function test_payment_pix(): void
    {
        if (!boolval(getConfigData('payments/pagarme/active'))) {
            throw new \RuntimeException(
                'O módulo de pagamento Pagar.me está desabilitado.'
            );
        }

        // Retorna o Pedido do sistema
        $salesOrder = SalesOrderRepository::getOrder(
            orderId: 215
        )->first();

        // Retorna os dados do PagamentoPix
        $pagarmePayment = app(PagarmePayment::class)->paymentPix(
            $salesOrder
        );

        $this->assertIsArray($pagarmePayment);

    }

}
