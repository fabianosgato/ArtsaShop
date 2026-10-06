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
