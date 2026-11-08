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
namespace Modules\Payments\Gateways\Ipag\Mock;

use Modules\Payments\Gateways\Ipag\Core\Client;
use Modules\Payments\Gateways\Ipag\Core\IpagClient;
use Modules\Payments\Gateways\Ipag\Core\IpagEnvironment;
use Modules\Payments\Gateways\Ipag\Http\Client\BaseHttpClient;
use Modules\Payments\Gateways\Ipag\Http\Client\GuzzleHttpClient;
use Modules\Payments\Gateways\Ipag\IO\JsonSerializer;

final class IpagClientMock extends IpagClient
{
    public function __construct(string $apiID, string $apiKey, string $environment, string $version = '2', ?array $configGuzzle = [])
    {
        Client::__construct(
            new IpagEnvironment($environment),
            new GuzzleHttpClient(
                array_merge(
                    [
                        'headers' => [
                            'Authorization' => 'Basic ' . base64_encode("$apiID:$apiKey"),
                            'Content-Type' => 'application/json',
                            'x-api-version' => $version,
                        ],
                    ],
                    $configGuzzle
                )
            ),
            new JsonSerializer()
        );
    }

    public function getHttpClient(): BaseHttpClient
    {
        return $this->httpClient;
    }

}
