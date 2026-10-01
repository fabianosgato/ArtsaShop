<?php

namespace Idea\Framework\Services\Payments\Ipag\Mock;

use Idea\Framework\Services\Payments\Ipag\Core\Client;
use Idea\Framework\Services\Payments\Ipag\Core\IpagClient;
use Idea\Framework\Services\Payments\Ipag\Core\IpagEnvironment;
use Idea\Framework\Services\Payments\Ipag\Http\Client\BaseHttpClient;
use Idea\Framework\Services\Payments\Ipag\Http\Client\GuzzleHttpClient;
use Idea\Framework\Services\Payments\Ipag\IO\JsonSerializer;

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
                            'Authorization' => 'Basic ' . base64_encode("{$apiID}:{$apiKey}"),
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
