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
