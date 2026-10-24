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
