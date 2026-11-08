<?php
/**
 * Fabiano Gato
 *
 * NOTICE OF LICENSE
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 *
 * É concedida permissão, gratuitamente, a qualquer pessoa que obtenha uma cópia
 * deste software e arquivos de documentação associados
 *
 *****************************************************
 *
 * @copyright    Copyright (c) Fabiano Gato
 * @author       Fabiano Gato <fabianogattoti@gmail.com>
 *
 */
namespace Modules\Payments\Gateways\Ipag\Endpoint;

use Modules\Payments\Gateways\Ipag\Core\Endpoint;
use Modules\Payments\Gateways\Ipag\Http\Response;

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
