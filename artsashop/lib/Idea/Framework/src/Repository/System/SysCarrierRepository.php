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

namespace Idea\Framework\Repository\System;

use App\Models\SysCarrier;
use Idea\Framework\Repository\AbstractRepository;

class SysCarrierRepository extends AbstractRepository
{

    protected static $model = SysCarrier::class;

    public static function updateOrCreate(?int $id, array $values = []): SysCarrier
    {

        return self::getData()->updateOrCreate(
            attributes: [
                'carrier_id' => $id
            ],
            values: $values
        );

    }

}
