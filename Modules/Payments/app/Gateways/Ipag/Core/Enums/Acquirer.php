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

abstract class Acquirer
{
    public const string CIELO = 'cielo';
    public const string EREDE = 'erede';
    public const string SIPAG = 'sipag';
    public const string BIN = 'bin';
    public const string ZOOP = 'zoop';
    public const string STONE = 'stone';
    public const string GLOBAL_PAYMENTS = 'globalpayments';
    public const string GETNET2 = 'getnet2';
    public const string ADIQ = 'adiq';
}
