<?php

namespace Idea\Framework\Services\Payments\Ipag\Endpoint;

use Idea\Framework\Services\Payments\Ipag\Core\Endpoint;
use Idea\Framework\Services\Payments\Ipag\Http\Response;

/**
 * TransactionEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Transaction.
 */
class TransactionEndpoint extends Endpoint
{
    protected string $location = '/service/resources/transactions';

    /**
     * Endpoint para obter um recurso Transaction
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
     * Endpoint para listar recursos Transaction
     *
     * @param array|null $filters
     * @return Response
     *
     */
    public function list(?array $filters = []): Response
    {
        return $this->_GET($filters ?? []);
    }

    /**
     * Endpoint para liberar recebíveis de recurso Transaction
     *
     * @param integer $sellerId
     * @param integer $transactionId
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function releaseReceivables(int $sellerId, int $transactionId): Response
    {
        return $this->_POST(['seller_id' => $sellerId, 'transaction_id' => $transactionId]);
    }

}
