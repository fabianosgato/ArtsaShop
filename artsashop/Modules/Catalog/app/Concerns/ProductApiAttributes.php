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

namespace Modules\Catalog\Concerns;

use Idea\Framework\Repository\Catalog\CatalogProductAttributeRepository;

trait ProductApiAttributes
{

    /**
     * Retorna os atributos do produto que possuem valores
     * @param int $productId
     * @return array
     */
    protected function getProductAttributes(int $productId)
    {

        $eavAttributes = CatalogProductAttributeRepository::getAttributes($productId)
            ->get()->toArray();

        $attributes = [];

        foreach ($eavAttributes as $eavAttribute) {
            if ($eavAttribute['value'] != '') {
                $attributes[] = [
                    'attributeCode' => $eavAttribute['attribute_code'],
                    'attributeLabel' => $eavAttribute['attribute_label'],
                    'value' => $eavAttribute['value'],
                ];
            }
        }

        return $attributes;

    }

}
