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
 * TransferEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Transfer.
 *
 */
class TransferEndpoint extends Endpoint
{
    protected string $location = '/service/resources/transfers';

    /**
     * Endpoint para listar recursos Transfer
     *
     * @param array|null $filters
     * @return Response
     */
    public function list(?array $filters = []): Response
    {
        return $this->_GET($filters ?? []);
    }

    /**
     * Endpoint para obter um recurso Transfer
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
     * Endpoint SellerTransfer do recurso Transfer.
     *
     * @return SellerTransferEndpoint
     *
     * @codeCoverageIgnore
     */
    public function seller(): SellerTransferEndpoint
    {
        return SellerTransferEndpoint::make($this->parent, $this->parent);
    }

    /**
     * Endpoint FutureTransfer do recurso Transfer.
     *
     * @return FutureTransferEndpoint
     *
     * @codeCoverageIgnore
     */
    public function future(): FutureTransferEndpoint
    {
        return FutureTransferEndpoint::make($this->parent, $this->parent);
    }

}
