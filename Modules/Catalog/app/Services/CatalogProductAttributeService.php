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
namespace Modules\Catalog\Services;

use Idea\Framework\Repository\Catalog\CatalogProductAttributeRepository;

class CatalogProductAttributeService
{

    /**
     * Metodo responsavel por atualizar os atributos de um produto (batch)
     * @param int $productId
     * @param int $attributeSetId
     * @param array $payloadAttributes  Formato: [['attributeCode' => 'cor', 'attributeValue' => 'vermelho'], ...]
     * @return void
     */
    public static function saveProductAttributeValues(int $productId, int $attributeSetId, array $payloadAttributes): void
    {
        if (empty($payloadAttributes)) {
            return;
        }

        // Converter formato para o batch
        $attributes = array_map(
            fn($a) => ['code' => $a['attributeCode'], 'value' => $a['attributeValue']],
            $payloadAttributes
        );

        CatalogProductAttributeRepository::updateAttributesBatch(
            productId: $productId,
            attributeSetId: $attributeSetId,
            attributes: $attributes
        );
    }

}
