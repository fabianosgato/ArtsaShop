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
namespace Modules\Payments\Enums;

enum PaymentTypes
{

    public const string CARD = 'card';
    public const string DEBIT_CARD = 'card';
    public const string BOLETO = 'boleto';
    public const string PIX = 'pix';

    public function getLabel(): string
    {
        return match ($this) {
            self::CARD => 'Cartão de Crédito',
            self::DEBIT_CARD => 'Cartão de débito',
            self::BOLETO => 'Boleto bancário',
            self::PIX => 'Pix',
            default => self::PIX
        };
    }

}
