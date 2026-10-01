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
