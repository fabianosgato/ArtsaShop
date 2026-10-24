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
namespace Modules\Payments\Gateways\Ipag\Core;

use UnexpectedValueException;

final class IpagEnvironment extends Environment
{
    public const string VERSION = '2';
    public const string LOCAL = 'api.ipag.test';
    public const string PRODUCTION = 'https://api.ipag.com.br';
    public const string SANDBOX = 'https://sandbox.ipag.com.br';

    private string $serviceUrl;

    public function __construct(string $environment)
    {
        if (!$this->isValidEnv($environment))
            throw new UnexpectedValueException("The environment must be valid");

        parent::__construct($environment);
    }

    private function isValidEnv(string $value)
    {
        return $value === self::LOCAL || $value === self::SANDBOX || $value === self::PRODUCTION;
    }

}
