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

use App\Models\EavEntityAttributeOption;
use Idea\Framework\Repository\AbstractRepository;

class EavEntityAttributeOptionRepository extends AbstractRepository
{

    protected static $model = EavEntityAttributeOption::class;

    /**
     * Insere/Atualiza as opções de um Atributo
     * @param $attributeOptionsData
     * @return \App\Models\EavEntityAttributeOption
     */
    public static function saveOrUpdate($attributeOptionsData): EavEntityAttributeOption
    {

        return self::getData()->updateOrCreate(
            attributes: [
                'attribute_set_id' => $attributeOptionsData['attribute_set_id'] ?? null,
                'entity_attribute_id' => $attributeOptionsData['entity_attribute_id'] ?? null,
                'eav_attribute_option_id' => $attributeOptionsData['eav_attribute_option_id'] ?? null,
            ],
            values: $attributeOptionsData
        );

    }

    public static function sync(
        int   $entityAttributeId,
        array $options
    ): void
    {

        // IDs enviados pelo formulário
        $formIds = collect($options)
            ->pluck('eav_attribute_option_id')
            ->filter()
            ->values();

        // Remove as opções excluídas
        self::getData()
            ->where('entity_attribute_id', $entityAttributeId)
            ->when(
                $formIds->isNotEmpty(),
                fn($query) => $query->whereNotIn(
                    'eav_attribute_option_id',
                    $formIds
                ),
                fn($query) => $query
            )
            ->delete();

        // Atualiza / Insere
        foreach ($options as $option) {
            self::saveOrUpdate($option);
        }

    }

    /**
     * Retorna as opções de um campo SELECT OU MULTI-SELECT em um Array para o Cadastro do Produto
     * @param $entityAttributeId
     * @param $attributeId
     * @return array
     */
    public static function getOptionsArray($entityAttributeId, $attributeId): array
    {

        // Inicializa o array de opcoes
        $optionsData = [];

        $query = self::getData()
            ->where(
                column: 'entity_attribute_id',
                operator: '=',
                value: $entityAttributeId
            )
            ->where(
                column: 'attribute_id',
                operator: '=',
                value: $attributeId
            );

        $attributeValues = $query->get()->toArray();

        foreach ($attributeValues as $attributeValue) {
            $optionsData[$attributeValue['option_value']] = $attributeValue['option_name'];
        }

        return $optionsData;

    }

    /**
     * Retorna as opções de um atributo do tipo "select" ou "select-options"
     * @param $entityAttributeId
     * @param $attributeId
     * @return array
     */
    public static function getAtributeOptions($entityAttributeId, $attributeId): array
    {

        return self::getData()
            ->where(
                column: 'entity_attribute_id',
                operator: '=',
                value: $entityAttributeId
            )
            ->where(
                column: 'attribute_id',
                operator: '=',
                value: $attributeId
            )
            ->orderBy('sort_order')
            ->get([
                'eav_attribute_option_id',
                'option_name',
                'option_value',
                'sort_order',
                'is_default',
            ])
            ->toArray();

    }

    /**
     * Retorna os dados da opção pelo valor passado
     * @param int $entityAttributeId
     * @param int $attributeId
     * @param string $value
     * @return array
     */
    public static function getAtributeOptionValue(
        int $entityAttributeId,
        int $attributeId,
        string $value
    ): array
    {

        return self::getData()
            ->where(
                column: 'entity_attribute_id',
                operator: '=',
                value: $entityAttributeId
            )
            ->where(
                column: 'attribute_id',
                operator: '=',
                value: $attributeId
            )
            ->where(
                column: 'option_value',
                operator: '=',
                value: $value
            )
            ->first([
                'eav_attribute_option_id',
                'option_name',
                'option_value',
                'sort_order',
                'is_default',
            ])
            ->toArray();

    }

    /**
     * Exclui as opções de um atributo se houver
     * @param int $entityAttributeId
     * @param int $attributeId
     * @return void
     */
    public static function deleteAttributeOptions(
        int $attributeSetId,
        int $attributeId,
        int $entityAttributeId,
    ): void
    {

        $attributeOptions = self::getData()
            ->where(
                column: 'attribute_set_id',
                operator: '=',
                value: $attributeSetId
            )
            ->where(
                column: 'attribute_id',
                operator: '=',
                value: $attributeId
            )
            ->where(
                column: 'entity_attribute_id',
                operator: '=',
                value: $entityAttributeId
            );

        if ($attributeOptions->exists())
            $attributeOptions->delete();

    }

}
