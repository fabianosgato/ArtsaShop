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

enum Cards: string
{
    case VISA = 'visa';
    case MASTERCARD = 'mastercard';
    case ELO = 'elo';
    case AMEX = 'amex';
    case DINERS = 'diners';
    case DISCOVER = 'discover';
    case HIPERCARD = 'hipercard';
    case HIPER = 'hiper';
    case JCB = 'jcb';
    case AURA = 'aura';
    case VISA_ELECTRON = 'visaelectron';
    case MAESTRO = 'maestro';

    public function getLabel(): string
    {
        return match ($this) {
            self::VISA => 'Cartão Visa',
            self::VISA_ELECTRON => 'Cartão Visa Débito',
            self::MASTERCARD => 'Cartão Mastercard',
            self::ELO => 'Cartão Elo',
            self::DINERS => 'Cartão Diners',
            self::DISCOVER => 'Cartão Discover',
            self::HIPERCARD => 'Cartão Hipercard',
            self::HIPER => 'Cartão Hiper',
            self::JCB => 'Cartão JCB',
            self::AURA => 'Cartão Aura',
            self::MAESTRO => 'Cartão Maestro',
            default => throw new \Exception('Nenhum cartão configurado'),
        };
    }
}
