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

namespace Idea\Framework\Repository\Eav;

use App\Models\EavAttributeOptionsValue;
use App\Models\EavEntityAttributeOption;
use Idea\Framework\Repository\AbstractRepository;

class EavAttributeOptionValueRepository extends AbstractRepository
{

    protected static $model = EavEntityAttributeOption::class;

    /**
     * Retorna as opções dos atributos selects
     * @param $attributeCode
     * @return array|null
     */
    public static function getOptionsArray($attributeCode): ?array
    {

        $query = self::loadModel()::query();

        $query->addSelect([
            'eav_entity_attribute_options.attribute_id',
            'eav_entity_attribute_options.option_name',
            'eav_entity_attribute_options.option_value',
            'eav_entity_attribute_options.sort_order',
            'eav_entity_attribute_options.is_default',
        ])->join(
            table:'eav_attributes',
            first:'eav_attributes.attribute_id',
            operator:'=',
            second:'eav_entity_attribute_options.attribute_id'
        )->where(
            column: 'eav_attributes.attribute_code',
            operator: '=',
            value:$attributeCode
        )->groupBy([
            'eav_entity_attribute_options.option_value'
        ]);

        if ($query->exists()) {
            return $query->get()->toArray();
        }

        return null;

    }

}
