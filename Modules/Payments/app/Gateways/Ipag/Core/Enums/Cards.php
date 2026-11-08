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
namespace Modules\Payments\Gateways\Ipag\Core\Enums;

abstract class Cards
{
    const string VISA = 'visa';
    const string MASTERCARD = 'mastercard';
    const string ELO = 'elo';
    const string AMEX = 'amex';
    const string DINERS = 'diners';
    const string DISCOVER = 'discover';
    const string HIPERCARD = 'hipercard';
    const string HIPER = 'hiper';
    const string JCB = 'jcb';
    const string AURA = 'aura';
    const string VISA_ELECTRON = 'visaelectron';
    const string MAESTRO = 'maestro';
}
