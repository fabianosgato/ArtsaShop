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

use App\Models\SysAddressState;
use Idea\Framework\Repository\AbstractRepository;

class SysAddressStateRepository extends AbstractRepository
{

    protected static $model = SysAddressState::class;

    public static function getStateByUf($uf)
    {

        $addressRegion = self::getData()
            ->where(
                column: 'uf_initials',
                operator: '=',
                value: $uf
            );

        if ($addressRegion->exists())
           return $addressRegion->first()->uf_description;

        return '';

    }

}
