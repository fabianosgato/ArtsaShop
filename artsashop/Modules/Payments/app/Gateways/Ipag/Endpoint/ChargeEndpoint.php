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
use Modules\Payments\Gateways\Ipag\Model\Charge;

/**
 * ChargeEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Charge.
 */
class ChargeEndpoint extends Endpoint
{
    protected string $location = '/service/resources/charges';

    /**
     * Endpoint para criar um recurso Charge
     *
     * @param Charge $charge
     * @return Response
     */
    public function create(Charge $charge): Response
    {
        return $this->_POST($charge->jsonSerialize());
    }

    /**
     * Endpoint para atualizar um recurso Charge
     *
     * @param Charge $charge
     * @param integer $id
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function update(Charge $charge, int $id): Response
    {
        return $this->_PUT($charge, ['id' => $id]);
    }

    /**
     * Endpoint para obter um recurso Charge
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
     * Endpoint para listar recursos Charge
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
