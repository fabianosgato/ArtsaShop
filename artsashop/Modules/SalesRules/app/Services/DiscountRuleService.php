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
use Carbon\Carbon;
use Idea\Framework\Repository\Sales\SalesDiscountRuleRepository;
use Idea\Framework\Repository\Sales\SalesOrderRepository;

class DiscountRuleService
{

    /**
     * Retorna uma regra de promoção pelo desconto
     * @param $discountCode
     * @return \App\Models\SalesDiscountRule|null
     */
    public function getRuleByCoupon($discountCode): ?\App\Models\SalesDiscountRule
    {

        return SalesDiscountRuleRepository::getRuleByCode(
            code: $discountCode
        );

    }

    public function hasUsageAvailable(SalesDiscountRule $rule): bool
    {

        if ($rule->max_usage === 0) {
            return true;
        }

        $usage = SalesOrderRepository::countByCouponCode(
            couponCode: $rule->code
        );

        return $usage < $rule->max_usage;
    }

    /**
     * Retorna as regras de desconto
     * @param string $paymentMethod
     * @param float $subtotal
     * @return mixed
     */
    public function getRulesForPayment(string $paymentMethod, float $subtotal)
    {
        return SalesDiscountRuleRepository::getData()
            ->where(
                column: 'rule_type',
                operator: '=',
                value: 'payment'
            )
            ->where(
                column: 'is_active',
                operator: '=',
                value: 1
            )
            ->where(function ($q) use ($paymentMethod) {
                $q->whereNull('payment_method')
                    ->orWhere('payment_method', $paymentMethod);
            })
            ->where(function ($q) use ($subtotal) {
                $q->whereNull('min_subtotal')
                    ->orWhere('min_subtotal', '<=', $subtotal);
            })
            ->where(function ($q) use ($subtotal) {
                $q->whereNull('max_subtotal')
                    ->orWhere('max_subtotal', '>=', $subtotal);
            })
            ->where(function ($q) {
                $now = Carbon::now();
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', $now);
                $q->whereNull('ends_at')->orWhere('ends_at', '>=', $now);
            })
            ->orderByDesc('priority')
            ->get();
    }

    public function getDiscountRule(int $ruleId)
    {

        $rule = SalesDiscountRuleRepository::find($ruleId);

        if ($rule) {
            return [
                'rule_id' => $rule->rule_id,
                'label' => $rule->label,
            ];
        }

    }

}
