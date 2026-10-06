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
use Modules\Payments\Gateways\Ipag\Model\Subscription;

/**
 * SubscriptionEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Subscription.
 */
class SubscriptionEndpoint extends Endpoint
{
    protected string $location = '/service/resources/subscriptions';

    /**
     * Endpoint para criar um recurso Subscription
     *
     * @param Subscription $subscription
     * @return Response
     */
    public function create(Subscription $subscription): Response
    {
        return $this->_POST($subscription->jsonSerialize());
    }

    /**
     * Endpoint para atualizar um recurso Subscription
     *
     * @param Subscription $subscription
     * @param integer $id
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function update(Subscription $subscription, int $id): Response
    {
        return $this->_PUT($subscription, ['id' => $id]);
    }

    /**
     * Endpoint para obter um recurso Subscription
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
     * Endpoint para listar recursos Subscription
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
     * Endpoint para Desvincular Token de um recurso Subscription
     *
     * @param integer $id
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function unlinkToken(int $id): Response
    {
        $this->location = "/service/subscriptions/{$id}/card_token";
        return $this->_DELETE(['id' => $id]);
    }

    /**
     * Disparo de ações de parcelas de um recurso Subscription
     *
     * @param integer $subscription_id
     * @param integer $invoice_number
     * @param string $action
     * @return Response
     *
     * @codeCoverageIgnore
     */
    private function _actionsInstallmentPayment(int $subscription_id, int $invoice_number, string $action)
    {
        $this->location = '/service/resources/invoice_installments';

        return $this->_POST(
            ['subscription_id' => $subscription_id, 'invoice_number' => $invoice_number, 'action' => $action],
            ['subscription_id' => $subscription_id, 'invoice_number' => $invoice_number, 'action' => $action]
        );
    }

    /**
     * Endpoint para quitar uma parcela de um recurso Subscription
     *
     * @param integer $subscription_id
     * @param integer $invoice_number
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function payOffInstallment(int $subscription_id, int $invoice_number): Response
    {
        return $this->_actionsInstallmentPayment($subscription_id, $invoice_number, 'pay');
    }

    /**
     * Endpoint para agendar pagamento de uma parcela de um recurso Subscription
     *
     * @param integer $subscription_id
     * @param integer $invoice_number
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function scheduleInstallmentPayment(int $subscription_id, int $invoice_number): Response
    {
        return $this->_actionsInstallmentPayment($subscription_id, $invoice_number, 'schedule');
    }

}
