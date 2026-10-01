<?php

namespace Idea\Framework\Services\Payments\Ipag\Endpoint;

use Idea\Framework\Services\Payments\Ipag\Core\Endpoint;
use Idea\Framework\Services\Payments\Ipag\Http\Response;
use Idea\Framework\Services\Payments\Ipag\Model\SplitRules;

/**
 * SplitRulesEndpoint class
 *
 * Classe responsável pelo controle dos endpoints do recurso Split Rules.
 */
class SplitRulesEndpoint extends Endpoint
{
    protected string $location = '/service/resources/split_rules';

    /**
     * Endpoint para criar um recurso `Split Rules`
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
     * Endpoint para obter um recurso `Split Rules`
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
     * Endpoint para listar os recursos `Split Rules`
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
     * Endpoint para deletar um recurso `Split Rules`
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
