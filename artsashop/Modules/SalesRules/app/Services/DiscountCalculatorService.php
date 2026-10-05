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
namespace Modules\SalesRules\Services;

use App\Models\SalesDiscountRule;

class DiscountCalculatorService
{
    /**
     * Realiza o calculo do descono aplicado
     * @param float $subtotal
     * @param \App\Models\SalesDiscountRule $rule
     * @return float
     */
    public function calculate(float $subtotal, SalesDiscountRule $rule): float
    {

        if ($rule->is_active && $rule->discount_value > 0) {
            if ($rule->discount_type === 'percent') {
                return round($subtotal * ($rule->discount_value / 100), 2);
            } else if ($rule->discount_type === 'fixed') {
                return min($rule->discount_value, $subtotal);
            }
        }

        return 0;

    }

}
