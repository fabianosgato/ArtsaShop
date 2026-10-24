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

namespace Idea\Framework\Repository\Catalog;

use App\Models\CatalogProductStatus;
use Idea\Framework\Repository\AbstractRepository;

class CatalogProductStatusRepository extends AbstractRepository
{

    protected static $model = CatalogProductStatus::class;

    /**
     * Atualiza os dados do módulo
     * @param int|null $id
     * @param array $values
     * @return CatalogProductStatus
     */
    public static function updateOrCreate(?int $id, array $values = []): CatalogProductStatus
    {

        return self::getData()->updateOrCreate(
            attributes: [
                'status_id' => $id
            ],
            values: $values
        );

    }
}
