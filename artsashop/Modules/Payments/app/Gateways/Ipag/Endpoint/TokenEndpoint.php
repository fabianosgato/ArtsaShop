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
use Modules\Payments\Gateways\Ipag\Model\Token;

/**
 * TokenEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Token.
 */
class TokenEndpoint extends Endpoint
{
    protected string $location = '/service/resources/card_tokens';

    /**
     * Endpoint para criar um recurso Token Card
     *
     * @param Token $token
     * @return Response
     */
    public function create(Token $token): Response
    {
        return $this->_POST($token->jsonSerialize());
    }

    /**
     * Endpoint para consultar um recurso Token Card
     *
     * @param string $token
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function get(string $token): Response
    {
        return $this->_GET(['token' => $token]);
    }

}
