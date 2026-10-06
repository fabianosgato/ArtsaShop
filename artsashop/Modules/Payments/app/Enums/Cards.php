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
