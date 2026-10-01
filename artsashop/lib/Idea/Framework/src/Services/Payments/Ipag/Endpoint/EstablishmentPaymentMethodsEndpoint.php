<?php

namespace Idea\Framework\Services\Payments\Ipag\Endpoint;

use Idea\Framework\Services\Payments\Ipag\Core\Endpoint;
use Idea\Framework\Services\Payments\Ipag\Http\Response;
use Idea\Framework\Services\Payments\Ipag\Model\PaymentMethod;

/**
 * EstablishmentPaymentMethodsEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Establishment Payment Methods.
 *
 */
class EstablishmentPaymentMethodsEndpoint extends Endpoint
{
    protected string $location = '/service/v2/establishments';

    /**
     * Endpoint para configuração de métodos de pagamento
     *
     * @param PaymentMethod $paymentMethod
     * @param string $establishmentUuid
     * @return Response
     */
    public function config(PaymentMethod $paymentMethod, string $establishmentUuid): Response
    {
        return $this->_POST(
            $paymentMethod->jsonSerialize(),
            [],
            [],
            "/{$establishmentUuid}/payment_methods"
        );
    }

}
