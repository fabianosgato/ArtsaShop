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
