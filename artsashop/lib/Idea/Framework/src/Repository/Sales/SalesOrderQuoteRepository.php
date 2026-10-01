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
namespace Idea\Framework\Repository\Sales;

use App\Models\SalesOrderQuote;
use Idea\Framework\Repository\AbstractRepository;

class SalesOrderQuoteRepository extends AbstractRepository
{

    protected static $model = SalesOrderQuote::class;

    /**
     * Atualiza o ID da sessao do Quote
     * @param int $quoteId
     * @param string $sessionId
     * @return void
     */
    public static function updateQuoteSession(int $quoteId, string $sessionId): void
    {
        // Atualiza o SalesQuote do cliente
        self::loadModel()::query()
            ->find($quoteId)
            ->update([
                'session_id' => $sessionId
            ]);

    }

    /**
     * Insere/Atualiza os dados do SalesQuote
     * @param $attributeValues
     * @return \App\Models\SalesOrderQuote
     */
    public static function saveOrUpdate($attributeValues): SalesOrderQuote
    {

        // Retorna a sessao pelo ID
        $salesQuote = self::loadModel()::query()
            ->where(
                column: 'session_id',
                operator: '=',
                value: $attributeValues['session_id']
            )
            ->where(
                column: 'is_active',
                operator:'=',
                value:true
            );

        // Valida se o quote existe na base
        if ($salesQuote->exists()) {

            // Valida se o quote está ativo
            if ($salesQuote->first()->is_active) {
                // Atualiza o SalesQuote do cliente
                self::loadModel()::query()
                    ->find($salesQuote->first()->quote_id)
                    ->update($attributeValues);

                return self::loadModel()::query()
                    ->find($salesQuote->first()->quote_id);

            } else {

                return self::loadModel()::query()->updateOrCreate(
                    attributes: [
                        'quote_id' => $salesQuote->first()->quote_id
                    ],
                    values: $attributeValues
                );

            }

        } else {
            // Cria o Quote do cliente
            return self::loadModel()::query()->firstOrCreate(
                attributes: [
                    'session_id' => $attributeValues['session_id']
                ],
                values: $attributeValues
            );

        }

    }

    /**
     * Retorna a quote ativa pelo ID da sessao
     * @param $sessionId
     * @return \App\Models\SalesOrderQuote|null
     */
    public static function getActiveQuote($sessionId): ?SalesOrderQuote
    {

        // Retorna a quote ativa atualmente pelo sessionId
        return SalesOrderQuoteRepository::loadModel()::query()
            ->where(
                column: 'session_id',
                operator: '=',
                value: $sessionId)
            ->where(
                column: 'is_active',
                operator: '=',
                value: true)
            ->with('items')
            ->latest('quote_id')
            ->first();

    }

    /**
     * Retorna o quote pelo CustomerId
     * @param int $customerId
     * @return \App\Models\SalesOrderQuote|null
     */
    public static function getActiveQuoteByCustomer(
        int $customerId
    ): ?SalesOrderQuote {

        return self::loadModel()::query()
            ->select('sales_order_quote.*')
            ->join(
                table:'sales_order_quote_customer',
                first: 'sales_order_quote.quote_id',
                operator: '=',
                second: 'sales_order_quote_customer.quote_id'
            )
            ->where(
                column: 'sales_order_quote_customer.customer_id',
                operator: '=',
                value: $customerId)
            ->where(
                column: 'sales_order_quote.is_active',
                operator: '=',
                value: true)
            ->with('items')
            ->latest('sales_order_quote.quote_id')
            ->first();
    }

    /**
     * Deleta a quote
     * @param $quoteId
     * @return void
     */
    public static function deleteQuote($quoteId): void
    {
        self::loadModel()::query()
            ->find($quoteId)
            ->delete();
    }

}
