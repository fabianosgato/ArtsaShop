<?php

namespace Modules\Payments\Gateways\Ipag\Http\Client;

use Modules\Payments\Gateways\Ipag\Ipag\Http\Client\HttpClientException;
use Modules\Payments\Gateways\Ipag\Ipag\Http\Client\HttpServerException;
use Modules\Payments\Gateways\Ipag\Ipag\Http\Client\HttpTransferException;
use Modules\Payments\Gateways\Ipag\Ipag\Http\Client\RuntimeException;
use Modules\Payments\Gateways\Ipag\Ipag\Http\MakesRequestInterface;

abstract class BaseHttpClient
{
    /**
     * Uses the current http client wrapper to do a request.
     *
     * @param string $method
     * @param string $url
     * @param string|null $body
     * @param array $query
     * @param array $header
     * @return string|null
     * @throws RuntimeException
     * @throws HttpTransferException
     * @throws HttpClientException
     * @throws HttpServerException
     *
     */
    public abstract function request(string $method, string $url, ?string $body, array $query = [], array $header = []): ?string;

    public abstract function lastResponseHeaders(): ?array;

    public abstract function lastResponseStatusCode(): ?int;
}
