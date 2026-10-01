<?php

namespace Idea\Framework\Services\Payments\Ipag\Http\Client;

use Idea\Framework\Services\Payments\Ipag\Http\MakesRequestInterface;

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
