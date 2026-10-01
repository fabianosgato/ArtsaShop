<?php

namespace Idea\Framework\Services\Payments\Ipag\Core;

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
