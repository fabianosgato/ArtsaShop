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

use App\Models\SalesOrderQuoteItem;
use Idea\Framework\Repository\AbstractRepository;

class SalesOrderQuoteItemRepository extends AbstractRepository
{

    protected static $model = SalesOrderQuoteItem::class;

    public static function saveOrUpdate($attributes): void
    {

        // Insere/Atualiza um item do carrinho
        $salesQuoteItem = self::loadModel()::query()
            ->where('quote_id', '=', $attributes['quote_id'])
            ->where('product_id', '=', $attributes['product_id'])
            ->first();

        if ($salesQuoteItem) {
            // Atualiza o SalesQuoteItem do cliente
            self::loadModel()::query()->find($salesQuoteItem->item_id)
                ->update($attributes);

        } else {
            // Insere o SalesOrderQuoteItem do cliente
            self::loadModel()::query()->firstOrCreate($attributes);

        }

    }

    /**
     * Remove um item do Quote
     * @param int $quoteId
     * @param int $productId
     * @return void
     */
    public static function deleteQuoteItem(int $quoteId, int $productId): void
    {

        // Remove o item do produto do Carrinnho
        self::loadModel()::query()
            ->where('quote_id', '=', $quoteId)
            ->where('product_id', '=', $productId)
            ->delete();

    }

    /**
     * Remove Todos os itens do Quote
     * @param int $quoteId
     * @return void
     */
    public static function deleteQuoteItens(int $quoteId): void
    {

        // Remove os itens da Quote
        self::loadModel()::query()
            ->where('quote_id', '=', $quoteId)
            ->delete();

    }

}
