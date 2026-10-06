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
use Modules\Payments\Gateways\Ipag\Model\PaymentLink;

/**
 * PaymentLinksEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Payment Links.
 */
class PaymentLinksEndpoint extends Endpoint
{
    protected string $location = '/service/resources/payment_links';

    /**
     * Endpoint para criar um recurso Payment Link
     *
     * @param PaymentLink $paymentLink
     * @return Response
     */
    public function create(PaymentLink $paymentLink): Response
    {
        return $this->_POST($paymentLink->jsonSerialize());
    }

    /**
     * Endpoint para obter um recurso Payment Link
     *
     * @param integer $id
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function getById(int $id): Response
    {
        return $this->_GET(['id' => $id]);
    }

    /**
     * Endpoint para obter um recurso Payment Link pelo Código Externo
     *
     * @param integer $externalCode
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function getByExternalCode(int $externalCode): Response
    {
        return $this->_GET(['external_code' => $externalCode]);
    }
}
