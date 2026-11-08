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

abstract class Interval
{
    public const string DAY = 'day';
    public const string WEEK = 'week';
    public const string MONTH = 'month';
    public const string YEAR = 'year';

    public const string DAILY = 'daily';
    public const string WEEKLY = 'weekly';
    public const string MONTHLY = 'monthly';


}
