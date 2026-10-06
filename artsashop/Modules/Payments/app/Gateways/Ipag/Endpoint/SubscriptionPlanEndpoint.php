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
use Modules\Payments\Gateways\Ipag\Model\SubscriptionPlan;

/**
 * SubscriptionPlanEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Subscription Plan.
 */
class SubscriptionPlanEndpoint extends Endpoint
{
    protected string $location = '/service/resources/plans';

    /**
     * Endpoint para criar um recurso Subscription Plan
     *
     * @param SubscriptionPlan $subscriptionPlan
     * @return Response
     */
    public function create(SubscriptionPlan $subscriptionPlan): Response
    {
        return $this->_POST($subscriptionPlan->jsonSerialize());
    }

    /**
     * Endpoint para atualizar um recurso Subscription Plan
     *
     * @param SubscriptionPlan $subscriptionPlan
     * @param integer $id
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function update(SubscriptionPlan $subscriptionPlan, int $id): Response
    {
        return $this->_PUT($subscriptionPlan, ['id' => $id]);
    }

    /**
     * Endpoint para obter um recurso Subscription Plan
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
     * Endpoint para deletar um recurso Subscription Plan
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
     * Endpoint para listar recursos Subscription Plan
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
