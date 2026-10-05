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
declare(strict_types=1);

namespace Idea\Framework\Repository\Sales;

use App\Models\SalesDiscountRule;
use Idea\Framework\Repository\AbstractRepository;

class SalesDiscountRuleRepository extends AbstractRepository
{

    protected static $model = SalesDiscountRule::class;

    /**
     * Retorna a regra pelo cupom de desconto
     * @param string $code
     * @return \App\Models\SalesDiscountRule|null
     */
    public static function getRuleByCode(string $code): ?SalesDiscountRule
    {

        $dicountRule = self::loadModel()::query()
            ->where(
                column: 'code',
                operator: '=',
                value: $code
            )
            ->where(
                column: 'is_active',
                operator: '=',
                value: true
            );

        if ($dicountRule->exists())
            return $dicountRule->first();

        return null;

    }

    public static function getRuleById($ruleId): ?SalesDiscountRule
    {
        return self::loadModel()::query()->find($ruleId);
    }

    /**
     * Insere/Atualiza uma categoria
     * @param $data
     * @return \App\Models\SalesDiscountRule
     */
    public static function updateOrCreate($data): SalesDiscountRule
    {
        return self::getData()->updateOrCreate(
            attributes: [
                'rule_id' => $data['rule_id']
            ],
            values: $data
        );
    }

}
