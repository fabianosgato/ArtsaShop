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
use Modules\Payments\Gateways\Ipag\Model\Establishment;

/**
 * EstablishmentEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Establishment.
 *
 */
class EstablishmentEndpoint extends Endpoint
{
    protected string $location = '/service/resources/establishments';

    /**
     * Endpoint para criar um recurso Establishment
     *
     * @param Establishment $establishment
     * @return Response
     */
    public function create(Establishment $establishment): Response
    {
        return $this->_POST($establishment->jsonSerialize());
    }

    /**
     * Endpoint para atualizar um recurso Establishment
     *
     * @param Establishment $establishment
     * @param string $uuid
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function update(Establishment $establishment, string $uuid): Response
    {
        return $this->_PUT($establishment, ['id' => $uuid]);
    }

    /**
     * Endpoint para obter um recurso Establishment
     *
     * @param string $uuid
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function get(string $uuid): Response
    {
        return $this->_GET(['id' => $uuid]);
    }

    /**
     * Endpoint para listar recursos Establishment
     *
     * @param array|null $filters
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function list(?array $filters = []): Response
    {
        return $this->_GET($filters ?? []);
    }

    /**
     * Endpoint Transaction do recurso Establishment.
     *
     * @return EstablishmentTransactionEndpoint
     *
     * @codeCoverageIgnore
     */
    public function transaction(): EstablishmentTransactionEndpoint
    {
        return EstablishmentTransactionEndpoint::make($this->parent, $this->parent);
    }

    /**
     * Endpoint PaymentMethods do recurso Establishment.
     *
     * @return EstablishmentPaymentMethodsEndpoint
     *
     * @codeCoverageIgnore
     */
    public function paymentMethods(): EstablishmentPaymentMethodsEndpoint
    {
        return EstablishmentPaymentMethodsEndpoint::make($this->parent, $this->parent);
    }

    /**
     * Endpoint Antifraud do recurso Establishment.
     *
     * @return EstablishmentAntifraudEndpoint
     *
     * @codeCoverageIgnore
     */
    public function antifraud(): EstablishmentAntifraudEndpoint
    {
        return EstablishmentAntifraudEndpoint::make($this->parent, $this->parent);
    }
}
