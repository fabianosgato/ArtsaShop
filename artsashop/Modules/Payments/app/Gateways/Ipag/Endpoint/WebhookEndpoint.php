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
use Modules\Payments\Gateways\Ipag\Model\Webhook;


/**
 * WebhookEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Webhook.
 *
 */
class WebhookEndpoint extends Endpoint
{

    protected string $location = '/service/resources/webhooks';

    /**
     * Endpoint para criar um recurso webhook
     *
     * @param Webhook $webhook
     * @return Response
     */
    public function create(Webhook $webhook): Response
    {
        return $this->_POST($webhook->jsonSerialize());
    }

    /**
     * Endpoint para obter um recurso webhook
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
     * Endpoint para listar recursos webhook
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
     * Endpoint para deletar um recurso webhook
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

}
