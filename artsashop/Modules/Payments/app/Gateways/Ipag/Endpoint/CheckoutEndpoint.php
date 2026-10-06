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
namespace Modules\Payments\Gateways\Ipag\Endpoint;

use Modules\Payments\Gateways\Ipag\Core\Endpoint;
use Modules\Payments\Gateways\Ipag\Http\Response;
use Modules\Payments\Gateways\Ipag\Model\Checkout;

/**
 * CheckoutEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Checkout.
 */
class CheckoutEndpoint extends Endpoint
{
    protected string $location = '/service/resources/checkout';

    /**
     * Endpoint para criar um recurso Checkout.
     *
     * @param Checkout $checkout
     * @return Response
     */
    public function create(Checkout $checkout): Response
    {
        return $this->_POST($checkout->jsonSerialize());
    }
}
