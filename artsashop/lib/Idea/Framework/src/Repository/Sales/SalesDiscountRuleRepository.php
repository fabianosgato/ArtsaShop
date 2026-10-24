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

}
