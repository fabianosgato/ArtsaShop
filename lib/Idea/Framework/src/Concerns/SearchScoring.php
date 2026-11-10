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

namespace Idea\Framework\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait SearchScoring
{
    /**
     * Pesos de relevância para o score customizado
     * @var array<int, array<string, int>>
     */
    private static array $relevanceWeights = [
        0 => [
            'name_starts' => 150,  // 100 + 50
            'name_contains' => 100,
            'description' => 30,
            'sku' => 120,
        ],
        'default' => [
            'name_starts' => 65,   // 15 + 50
            'name_contains' => 15,
            'description' => 5,
            'sku' => 25,
        ],
    ];

    /**
     * Aplica score de relevância customizado à query de busca
     *
     * @param Builder $query
     * @param array $terms Termos de busca já processados (filtrados, únicos)
     * @param string $search String de busca FULLTEXT (ex: '+termo1 termo2')
     * @return void
     */
    protected static function applyRelevanceScoring(Builder $query, array $terms, string $search): void
    {
        if (empty($terms)) {
            return;
        }

        $scoreSql = [];
        $bindings = [];

        foreach ($terms as $index => $term) {
            $weights = $index === 0
                ? self::$relevanceWeights[0]
                : self::$relevanceWeights['default'];

            // Nome começando com termo
            $scoreSql[] = "
                CASE
                    WHEN catalog_product.name LIKE ? THEN ?
                    ELSE 0
                END
            ";
            $bindings[] = $term . '%';
            $bindings[] = $weights['name_starts'];

            // Nome contendo termo
            $scoreSql[] = "
                CASE
                    WHEN catalog_product.name LIKE ? THEN ?
                    ELSE 0
                END
            ";
            $bindings[] = '%' . $term . '%';
            $bindings[] = $weights['name_contains'];

            // Description
            $scoreSql[] = "
                CASE
                    WHEN catalog_product.description LIKE ? THEN ?
                    ELSE 0
                END
            ";
            $bindings[] = '%' . $term . '%';
            $bindings[] = $weights['description'];

            // SKU
            $scoreSql[] = "
                CASE
                    WHEN catalog_product.sku LIKE ? THEN ?
                    ELSE 0
                END
            ";
            $bindings[] = '%' . $term . '%';
            $bindings[] = $weights['sku'];
        }

        $scoreExpression = implode(' + ', $scoreSql);

        // Score FULLTEXT do MySQL
        $query->selectRaw(
            "(
                MATCH(
                    catalog_product.name,
                    catalog_product.description,
                    catalog_product.sku
                ) AGAINST(? IN BOOLEAN MODE)
            ) as fulltext_score",
            [$search]
        );

        // Score customizado (agora com bindings seguros para os pesos)
        $query->selectRaw(
            "({$scoreExpression}) as relevance_score",
            $bindings
        );
    }

    /**
     * Processa a string de busca e retorna os termos e a string FULLTEXT
     *
     * @param string $word
     * @return array{terms: array<int, string>, search: string}
     */
    protected static function processSearchTerms(string $word): array
    {
        $word = trim($word);

        $terms = collect(
            preg_split('/\s+/', $word)
        )->filter()->values()->all();

        if (empty($terms)) {
            return ['terms' => [], 'search' => ''];
        }

        $mainTerm = $terms[0];
        $search = '+' . $mainTerm;

        foreach (array_slice($terms, 1) as $term) {
            $search .= ' ' . $term;
        }

        return ['terms' => $terms, 'search' => $search];
    }
}