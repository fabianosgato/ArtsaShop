<?php

namespace Idea\Framework\Services\Payments\Ipag\Endpoint;

use Idea\Framework\Services\Payments\Ipag\Core\Endpoint;
use Idea\Framework\Services\Payments\Ipag\Http\Response;
use Idea\Framework\Services\Payments\Ipag\Model\Customer;

/**
 * CustomerEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Customer.
 */
class CustomerEndpoint extends Endpoint
{
    protected string $location = '/service/resources/customers';

    /**
     * Endpoint para criar um recurso `Customer`
     *
     * @param Customer $customer
     * @return Response
     */
    public function create(Customer $customer): Response
    {
        return $this->_POST($customer->jsonSerialize());
    }

    /**
     * Endpoint para atualizar um recurso `Customer`
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
     * Endpoint para obter um recurso `Customer`
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
     * Endpoint para deletar um recurso `Customer`
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
     * Endpoint para listar recursos `Customer`
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
