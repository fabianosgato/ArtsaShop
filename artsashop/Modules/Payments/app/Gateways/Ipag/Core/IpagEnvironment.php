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
