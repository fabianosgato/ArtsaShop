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
namespace Modules\Payments\Gateways\Ipag\Util;

use DateTime;
use DateTimeInterface;
use InvalidArgumentException;

abstract class DateUtil
{
    public const string ISO_DATE_FORMAT = 'Y-m-d';

    public static function parseDate($date, string $format = self::ISO_DATE_FORMAT): DateTimeInterface
    {
        $date = self::tryParseDate($date, $format);

        if (!$date) {
            throw new InvalidArgumentException("Invalid date format ($date does not conform to $format)");
        }

        return $date;
    }

    public static function tryParseDate($date, string $format = self::ISO_DATE_FORMAT): ?DateTimeInterface
    {
        if (is_null($date) || $date instanceof DateTimeInterface) {
            return $date;
        }

        return DateTime::createFromFormat($format, $date) ?: null;
    }
}
