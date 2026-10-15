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

use App\Models\SalesOrderQuote;
use App\Models\SalesOrderQuoteCustomer;
use Idea\Framework\Repository\AbstractRepository;

class SalesOrderQuoteCustomerRepository extends AbstractRepository
{

    protected static $model = SalesOrderQuoteCustomer::class;

    /**
     * Atualiza o quote com o ID da Session
     * @param string $sessionId
     * @param int $customerId
     * @return \App\Models\SalesOrderQuote|null
     */
    public static function updateQuoteCustomer(string $sessionId, int $customerId): ?SalesOrderQuote
    {

        // Retorna a ultima quote ativa do cliente
        $quote = SalesOrderQuoteRepository::getActiveQuoteByCustomer($customerId);

        // Valida se existe uma quote ativa para o cliente
        if ($quote) {

            // Retorna as informações da Quote
            SalesOrderQuoteRepository::updateQuoteSession(
                quoteId: $quote->quote_id,
                sessionId: $sessionId
            );

            // Retorna o quote do cliente
            return SalesOrderQuoteRepository::getActiveQuoteByCustomer($customerId);

        }

        return null;

    }

    /**
     * Vincula o quote atual ao cliente e retorna os dados
     * @param int $quoteId
     * @param int $customerId
     * @return \App\Models\SalesOrderQuote|null
     */
    public static function createQuoteCustomer(int $quoteId, int $customerId): ?SalesOrderQuote
    {

        // Cadastra a quote no sistema
        $salesOrderQuoteCustomer = self::loadModel()::query()
            ->firstOrCreate(
                attributes: ['quote_id' => $quoteId],
                values: ['customer_id' => $customerId]
            );

        if ($salesOrderQuoteCustomer)
            // Retorna o quote do cliente
            return SalesOrderQuoteRepository::getActiveQuoteByCustomer($customerId);

        return null;

    }

}

