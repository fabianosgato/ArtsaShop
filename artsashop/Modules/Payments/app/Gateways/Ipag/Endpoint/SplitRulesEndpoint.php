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
use Modules\Payments\Gateways\Ipag\Model\SplitRules;

/**
 * SplitRulesEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Split Rules.
 */
class SplitRulesEndpoint extends Endpoint
{
    protected string $location = '/service/resources/split_rules';

    /**
     * Endpoint para criar um recurso Split Rules
     *
     * @param SplitRules $splitRules
     * @param integer $transaction_id
     * @return Response
     */
    public function create(SplitRules $splitRules, int $transaction_id): Response
    {
        return $this->_POST($splitRules->jsonSerialize(), ['transaction' => $transaction_id]);
    }

    /**
     * Endpoint para obter um recurso Split Rules
     *
     * @param integer $split_rule_id
     * @param integer $transaction_id
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function get(int $split_rule_id, int $transaction_id): Response
    {
        return $this->_GET([
            'id' => $split_rule_id,
            'transaction' => $transaction_id
        ]);
    }

    /**
     * Endpoint para listar os recursos Split Rules
     *
     * @param integer $transaction_id
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function list(int $transaction_id): Response
    {
        return $this->_GET(['transaction' => $transaction_id]);
    }

    /**
     * Endpoint para deletar um recurso Split Rules
     *
     * @param integer $split_rule_id
     * @param integer $transaction_id
     * @return Response
     *
     * @codeCoverageIgnore
     */
    public function delete(int $split_rule_id, int $transaction_id): Response
    {
        return $this->_DELETE([
            'id' => $split_rule_id,
            'transaction' => $transaction_id
        ]);
    }

}
