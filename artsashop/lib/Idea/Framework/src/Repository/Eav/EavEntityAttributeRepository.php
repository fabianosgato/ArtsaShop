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

namespace Idea\Framework\Repository\Eav;

use App\Models\EavEntityAttribute;
use Idea\Framework\Repository\AbstractRepository;

class EavEntityAttributeRepository extends AbstractRepository
{

    protected static $model = EavEntityAttribute::class;

    public static function deleteEntityAttribute(
        int $attributeSetId,
        int $attributeId
    ): void
    {

        // Inicializa a query
        $query = self::getData();

        // Filtra pelo Grupo de atributo
        $query->where(
            column: 'attribute_set_id',
            operator: '=',
            value:$attributeSetId
        );

        // Filtra pelo atributo
        $query->where(
            column: 'attribute_id',
            operator: '=',
            value:$attributeId
        );

        if ($query->exists()) {
            // Exclui as opções do atributo se existirem
            EavEntityAttributeOptionRepository::deleteAttributeOptions(
                attributeSetId: $attributeSetId,
                attributeId: $attributeId,
                entityAttributeId: $query->first()->entity_attribute_id
            );

            // Exlui o atributo
            $query->delete();

        }

    }

    /**
     * Insere/Atualiza os dados do Atributo
     * @param $attributeEntityData
     * @return \App\Models\EavEntityAttribute|null
     */
    public static function saveOrUpdate($attributeEntityData): ?EavEntityAttribute
    {

        // Insere/Atualiza os dados dos Valores do Atributo
        return self::getData()->updateOrCreate(
            attributes: [
                'attribute_id' => $attributeEntityData['attribute_id'],
                'attribute_set_id' => $attributeEntityData['attribute_set_id'],

            ],
            values: $attributeEntityData
        );

    }

    /**
     * Retorna os valores de um atributo
     * @param int $attributeId
     * @param int $attributeSetId
     * @return array
     */
    public static function getAttributeValues(
        int $attributeId,
        int $attributeSetId
    ): array
    {

        $query = self::getData();

        $query->where(
            column: 'attribute_set_id',
            operator: '=',
            value:$attributeSetId
        );

        $query->where(
            column: 'attribute_id',
            operator: '=',
            value:$attributeId
        );

        return $query->get()->first()->toArray();

    }

}
