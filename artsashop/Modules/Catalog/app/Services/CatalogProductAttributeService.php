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

namespace Modules\Catalog\Services;

use Idea\Framework\Repository\Catalog\CatalogProductAttributeRepository;
use Idea\Framework\Repository\Eav\EavAttributesRepository;

class CatalogProductAttributeService
{

    /**
     * Metodo responsavel por atualizar os atributos de um produto
     * @param int $productId
     * @param int $attributeSetId
     * @param array $payloadAttributes
     * @return void
     */
    public static function saveProductAttributeValues(int $productId, int $attributeSetId, array $payloadAttributes): void
    {

        // Retorna os atributos do grupo de atributos a serem criados/atualizados
        $eavAttributes = EavAttributesRepository::getAttributesBySetId($attributeSetId)->get();

        if ($eavAttributes) {

            foreach ($eavAttributes->toArray() as $eavAttribute) {

                foreach ($payloadAttributes as $payloadAttribute) {

                    if ($eavAttribute['attribute_code'] == $payloadAttribute['attributeCode']) {

                        CatalogProductAttributeRepository::updateAttributes(
                            productId: $productId,
                            atributeSetId: $attributeSetId,
                            attributeCode: $eavAttribute['attribute_code'],
                            value: $payloadAttribute['attributeValue']
                        );
                    }

                }

            }

        }

    }

}
