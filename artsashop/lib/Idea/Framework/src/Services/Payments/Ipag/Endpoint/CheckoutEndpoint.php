<?php

namespace Idea\Framework\Services\Payments\Ipag\Endpoint;

use Idea\Framework\Services\Payments\Ipag\Core\Endpoint;
use Idea\Framework\Services\Payments\Ipag\Http\Response;
use Idea\Framework\Services\Payments\Ipag\Model\Checkout;

/**
 * CheckoutEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Checkout.
 */
class CheckoutEndpoint extends Endpoint
{
    protected string $location = '/service/resources/checkout';

    /**
     * Endpoint para criar um recurso `Checkout`.
     *
     * @param Checkout $checkout
     * @return Response
     */
    public function create(Checkout $checkout): Response
    {
        return $this->_POST($checkout->jsonSerialize());
    }
}
