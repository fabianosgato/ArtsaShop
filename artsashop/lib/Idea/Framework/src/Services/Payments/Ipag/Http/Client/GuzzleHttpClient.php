<?php

namespace Idea\Framework\Services\Payments\Ipag\Http\Client;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\ServerException;
use Idea\Framework\Services\Payments\Ipag\Exception\HttpClientException;
use Idea\Framework\Services\Payments\Ipag\Exception\HttpServerException;
use Idea\Framework\Services\Payments\Ipag\Exception\HttpTransferException;
use Idea\Framework\Services\Payments\Ipag\Http\Response;
use RuntimeException;

class GuzzleHttpClient extends BaseHttpClient
{
    private const DEFAULT_USER_AGENT = 'IPag SDK for PHP';

    protected Client $client;

    protected ?array $headers = null;

    protected ?int $statusCode = null;

    public function __construct(array $config = [])
    {
        static $default = [
            'allow_redirects' => false,
            'timeout' => 60.00,
            'connect_timeout' => 10.00,
            'http_errors' => true,
            'headers' => [
                'User-Agent' => self::DEFAULT_USER_AGENT
            ],
        ];

        $this->client = new Client(array_merge($default, $config));
    }

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
    public function request(string $method, string $url, ?string $body, array $query = [], array $header = []): ?string
    {
        try {
            $response = $this->client->request($method, $url, [
                'headers' => $header,
                'query' => $query,
                'body' => $body,
            ]);

            $this->headers = $response->getHeaders();
            $this->statusCode = $response->getStatusCode();

            return $response->getBody()->getContents();
        } catch (ConnectException $e) {
            // Networking error
            throw new HttpTransferException("An networking error ocurred while trying to connect to `$url`", $e->getCode(), $e);
        } catch (ServerException $e) {
            // Server-side error 5xx
            throw new HttpServerException(
                "An server-side error ocurred with status {$e->getResponse()->getStatusCode()} from `$url`",
                $e->getCode(),
                $e,
                // If this fails, an RuntimeException will be thrown
                Response::from($e->getResponse()->getBody()->getContents(), $e->getResponse()->getHeaders(), $e->getResponse()->getStatusCode()),
                $e->getResponse()->getStatusCode(),
                $e->getResponse()->getReasonPhrase()
            );
        } catch (ClientException $e) {
            // Client-side error 4xx
            throw new HttpClientException(
                "An client-side error ocurred with status {$e->getResponse()->getStatusCode()} from `$url`",
                $e->getCode(),
                $e,
                // If this fails, an RuntimeException will be thrown
                Response::from($e->getResponse()->getBody()->getContents(), $e->getResponse()->getHeaders(), $e->getResponse()->getStatusCode()),
                $e->getResponse()->getStatusCode(),
                $e->getResponse()->getReasonPhrase()
            );
        } catch (RuntimeException $e) {
            // Stream error
            throw $e;
        }
    }

    public function lastResponseHeaders(): ?array
    {
        return $this->headers;
    }

    public function lastResponseStatusCode(): ?int
    {
        return $this->statusCode;
    }

}
