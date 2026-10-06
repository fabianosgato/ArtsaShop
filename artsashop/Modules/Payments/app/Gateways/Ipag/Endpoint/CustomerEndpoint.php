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
use Modules\Payments\Gateways\Ipag\Model\Customer;

/**
 * CustomerEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Customer.
 */
class CustomerEndpoint extends Endpoint
{
    protected string $location = '/service/resources/customers';

    /**
     * Endpoint para criar um recurso Customer
     *
     * @param Customer $customer
     * @return Response
     */
    public function create(Customer $customer): Response
    {
        return $this->_POST($customer->jsonSerialize());
    }

    /**
     * Endpoint para atualizar um recurso Customer
     *
     * @param Customer $customer
     * @param integer $id
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function update(Customer $customer, int $id): Response
    {
        return $this->_PUT($customer, ['id' => $id]);
    }

    /**
     * Endpoint para obter um recurso Customer
     *
     * @param integer $id
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function get(int $id): Response
    {
        return $this->_GET(['id' => $id]);
    }

    /**
     * Endpoint para deletar um recurso Customer
     *
     * @param integer $id
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function delete(int $id): Response
    {
        return $this->_DELETE(['id' => $id]);
    }

    /**
     * Endpoint para listar recursos Customer
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
}
