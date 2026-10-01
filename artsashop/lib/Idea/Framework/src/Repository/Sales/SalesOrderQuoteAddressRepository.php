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

use App\Models\SalesOrderQuoteAddress;
use Idea\Framework\Repository\AbstractRepository;

class SalesOrderQuoteAddressRepository extends AbstractRepository
{

    protected static $model = SalesOrderQuoteAddress::class;

    /**
     * Metodo responsavel por retornar um array comn os endereços da compra no Quote
     * @param int $quoteId
     * @return array|null
     */
    public static function getQuoteAddressByQuote(int $quoteId): ?array
    {

        $address = self::getData()->where(
            column: 'quote_id',
            operator: '=',
            value: $quoteId
        );

        if ($address->exists())
            return $address->get()->toArray();

        return null;

    }

    public static function getQuoteAddress(int $quoteId, string $addressType)
    {

        $address = self::getData()->where(
            column: 'quote_id',
            operator: '=',
            value: $quoteId
        )->where(
            column: 'address_type',
            operator: '=',
            value: $addressType
        );

        if ($address->exists())
            return $address->first()->toArray();

        return null;

    }

    public static function saveQuoteAddress(int $quoteId, array $addressData): void
    {

        $address = self::getData()->where(
            column: 'quote_id',
            operator: '=',
            value: $quoteId
        )->where(
            column: 'address_type',
            operator: '=',
            value: $addressData['address_type']
        );

        if ($address->exists()) {
            // Atualiza os endereços do cliente
            self::getData()
                ->find($address->first()->address_id)
                ->update($addressData);

        } else {
            // Cria o endereço do pedido
            self::getData()->firstOrCreate($addressData);

        }

    }

}
