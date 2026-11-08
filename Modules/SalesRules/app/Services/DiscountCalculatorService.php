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
