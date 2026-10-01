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

namespace Idea\Framework\Repository\Sales;

use App\Models\SalesOrderStatus;
use Idea\Framework\Repository\AbstractRepository;

class SalesOrderStatusRepository extends AbstractRepository
{

    protected static $model = SalesOrderStatus::class;

    public static function getByCode($code): ?SalesOrderStatus
    {

        $status =  self::getData()->where(
            column: 'status',
            operator: '=',
            value: $code
        );

        if ($status)
            return $status->first();

        return null;

    }

}
