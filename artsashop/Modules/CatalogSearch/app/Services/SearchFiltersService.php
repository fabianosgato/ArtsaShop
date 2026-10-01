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

namespace Modules\CatalogSearch\Services;

use Idea\Framework\Repository\Catalog\CatalogCategoryRepository;
use Idea\Framework\Repository\Eav\EavAttributeOptionValueRepository;
use Idea\Framework\Repository\Eav\EavAttributesRepository;
use Modules\CatalogSearch\DTO\PriceRangeDTO;

class SearchFiltersService
{
    /**
     * Monta as faixas de preço para os filtros da pesquisa.
     *
     * Utiliza uma distribuição logarítmica para evitar que uma
     * grande diferença entre o menor e o maior preço produza
     * faixas muito grandes no início.
     */
    public function buildPriceRanges(
        PriceRangeDTO $priceRange,
        int           $steps = 4
    ): array
    {

        if (!$priceRange->hasPrices()) {
            return [];
        }

        if ($priceRange->maxPrice <= 0 || $steps < 2) {
            return [];
        }

        $min = max(0, floor($priceRange->minPrice));
        $max = ceil($priceRange->maxPrice);

        if ($max <= $min) {
            return [];
        }

        /*
         * Para que a primeira faixa comece no preço mínimo
         * encontrado e a última termine no preço máximo.
         */
        $ranges = [];

        /*
         * Trabalhamos com uma escala logarítmica.
         *
         * O objetivo é distribuir melhor os valores quando
         * existe uma grande diferença entre MIN e MAX.
         */
        $logMin = log(max($min, 1));
        $logMax = log($max);

        $from = $min;

        for ($i = 1; $i <= $steps; $i++) {

            /*
             * Última faixa:
             * garante que o limite superior seja exatamente
             * o maior preço encontrado.
             */
            if ($i === $steps) {

                $ranges[] = [
                    'label' => sprintf(
                        'R$ %s a R$ %s',
                        number_format($from, 0, ',', '.'),
                        number_format($max, 0, ',', '.')
                    ),
                    'from' => $from,
                    'to' => $max,
                ];

                continue;
            }

            /*
             * Calcula a posição da faixa dentro da escala
             * logarítmica.
             */
            $position = $i / $steps;

            $value = exp(
                $logMin + (($logMax - $logMin) * $position)
            );

            /*
             * Arredonda o limite para um valor comercial.
             */
            $to = $this->roundPrice($value);

            /*
             * Garante que a faixa sempre avance.
             */
            if ($to <= $from) {
                $to = $from + $this->minimumStep($from);
            }

            /*
             * Nunca ultrapassa o preço máximo.
             */
            $to = min($to, $max);

            /*
             * Se chegamos ao máximo antes da última faixa,
             * encerramos a geração.
             */
            if ($to >= $max) {

                $ranges[] = [
                    'label' => sprintf(
                        'R$ %s a R$ %s',
                        number_format($from, 0, ',', '.'),
                        number_format($max, 0, ',', '.')
                    ),
                    'from' => $from,
                    'to' => $max,
                ];

                break;
            }

            /*
             * Primeira faixa.
             */
            if ($i === 1) {

                $ranges[] = [
                    'label' => 'Até R$ ' . number_format($to, 0, ',', '.'),
                    'from' => $min,
                    'to' => $to,
                ];

                $from = $to;

                continue;
            }

            /*
             * Faixas intermediárias.
             */
            $ranges[] = [
                'label' => sprintf(
                    'R$ %s a R$ %s',
                    number_format($from, 0, ',', '.'),
                    number_format($to, 0, ',', '.')
                ),
                'from' => $from,
                'to' => $to,
            ];

            $from = $to;
        }

        return $ranges;
    }

    /**
     * Arredonda o limite da faixa para um valor comercial.
     */
    private function roundPrice(float $value): int
    {
        if ($value <= 100) {
            return (int)ceil($value / 10) * 10;
        }

        if ($value <= 500) {
            return (int)ceil($value / 25) * 25;
        }

        if ($value <= 1_000) {
            return (int)ceil($value / 50) * 50;
        }

        if ($value <= 5_000) {
            return (int)ceil($value / 100) * 100;
        }

        if ($value <= 10_000) {
            return (int)ceil($value / 500) * 500;
        }

        if ($value <= 50_000) {
            return (int)ceil($value / 1_000) * 1_000;
        }

        if ($value <= 100_000) {
            return (int)ceil($value / 5_000) * 5_000;
        }

        if ($value <= 500_000) {
            return (int)ceil($value / 10_000) * 10_000;
        }

        return (int)ceil($value / 50_000) * 50_000;
    }

    /**
     * Define o incremento mínimo quando o arredondamento
     * produzir duas faixas com o mesmo limite.
     */
    private function minimumStep(float $value): int
    {
        if ($value <= 100) {
            return 10;
        }

        if ($value <= 500) {
            return 25;
        }

        if ($value <= 1_000) {
            return 50;
        }

        if ($value <= 5_000) {
            return 100;
        }

        if ($value <= 10_000) {
            return 500;
        }

        if ($value <= 50_000) {
            return 1_000;
        }

        if ($value <= 100_000) {
            return 5_000;
        }

        return 10_000;
    }


    private function getCategories(int $categoryId): array
    {
        if ($categoryId == 0) {

            $data = CatalogCategoryRepository::getCategoriesTree(
                level: 1,
                parentId: 1
            );

        } else {

            $data[] = CatalogCategoryRepository::getCategoryByParentId(
                parentId: $categoryId
            )->toArray();
        }

        return $data;
    }


    private function getAttributes($categoryId): array
    {
        $resultSet = [];

        $attributeSet = CatalogCategoryRepository::getCategoryAttributeSet(
            categoryId: $categoryId
        );

        if ($attributeSet) {

            $attributes = EavAttributesRepository::getAttributesBySetId(
                attributeSetId: $attributeSet->attribute_set_id
            )->where(
                column: 'is_filterable',
                operator: '=',
                value: true
            )->get();

            if ($attributes) {

                foreach ($attributes as $attribute) {

                    $resultSet[] = [
                        'category_id' => $categoryId,
                        'attribute_id' => $attribute->attribute_id,
                        'attribute_code' => $attribute->attribute_code,
                        'attribute_label' => $attribute->attribute_label,
                        'frontend_input' => $attribute->frontend_input,
                        'options' => EavAttributeOptionValueRepository::getOptionsArray(
                            $attribute->attribute_code
                        )
                    ];
                }
            }
        }

        return $resultSet;
    }


    public function resultFilters(int $categoryId): array
    {
        // Cria o array a ser retornado para o filtro
        $categoriesAttributes = [];

        // Retorna as categorias
        $categories = $this->getCategories($categoryId);

        if ($categories) {

            foreach ($categories as $category) {

                // Retorna a categoria filha
                $childrens = CatalogCategoryRepository::getCategoriesByParentId(
                    parentId: $category['entity_id']
                )->toArray();

                foreach ($childrens as $children) {

                    // Retorna as categorias filhas
                    $categoriesAttributes[] = [
                        'filterName' => "Exames de {$category['category']} - {$children['category']}",
                        'attributes' => $this->getAttributes(
                            categoryId: $children['entity_id']
                        )
                    ];
                }
            }
        }

        return $categoriesAttributes;
    }
}

