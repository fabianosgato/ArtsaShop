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
