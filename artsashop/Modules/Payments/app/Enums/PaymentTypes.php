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
