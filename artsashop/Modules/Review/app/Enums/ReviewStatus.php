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
namespace Modules\Review\Enums;

enum ReviewStatus: int
{

    case PENDING = 1;
    case APPROVED = 2;
    case REJECTED = 3;

    public function hasDefaultValue(): bool
    {
        return match ($this) {
            self::PENDING,
            self::APPROVED,
            self::REJECTED => true
        };
    }





}
