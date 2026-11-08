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

abstract class BankSlips
{
    const string ZOOP = "boletozoop";
    const string PAGSEGURO = "boletopagseguro";
    const string SICOB = "boletosicoob";
    const string SICREDI = "boletosicredi";
    const string SANTANDER = "boleto_banespasantander";
    const string BANCO_BB = "boletobb";
    const string ITAU = "boletoitaushopline";
    const string BRADESCO = "boletoshopfacil";
    const string BRADESCO_NET = "boletobradesconet";
    const string SIMULADO = "boletosimulado";
}
