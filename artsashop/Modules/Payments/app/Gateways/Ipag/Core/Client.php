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

use JsonSerializable;
use Modules\Payments\Gateways\Ipag\Exception\HttpException;
use Modules\Payments\Gateways\Ipag\Http\Client\BaseHttpClient;
use Modules\Payments\Gateways\Ipag\Http\Response;
use Modules\Payments\Gateways\Ipag\IO\SerializerInterface;
use Modules\Payments\Gateways\Ipag\Path\CompositePathInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use Throwable;

abstract class Client implements CompositePathInterface
{
    private static int $requestCounter = 0;

    protected Environment $environment;
    protected BaseHttpClient $httpClient;
    protected ?SerializerInterface $defaultSerializer;
    protected ?LoggerInterface $logger;

    public function __construct(Environment $environment, BaseHttpClient $httpClient, ?SerializerInterface $defaultSerializer = null, ?LoggerInterface $logger = null)
    {
        $this->environment = $environment;
        $this->httpClient = $httpClient;
        $this->defaultSerializer = $defaultSerializer;
        $this->logger = $logger ?? new NullLogger();
    }

    //

    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    //

    public function getParent(): ?CompositePathInterface
    {
        return $this->environment->getParent();
    }

    //

    public function setParent(?CompositePathInterface $parent): void
    {
        $this->environment->setParent($parent);
    }

    public function getPath(): string
    {
        return $this->environment->getPath();
    }

    //

    protected function get(string $path, array $query = [], array $header = []): Response
    {
        return $this->request(__FUNCTION__, $this->joinPath($path), null, $query, $header);
    }

    public function request(
        string               $method,
        string               $url,
                             $body,
        array                $query = [],
        array                $header = [],
        ?SerializerInterface $inputSerializer = null,
        ?SerializerInterface $outputSerializer = null
    ): Response
    {
        $requestId = $this->incrementRequestCounter();

        $outputSerializer ??= $this->defaultSerializer;
        $inputSerializer ??= $this->defaultSerializer;

        if ($inputSerializer) {
            $header['Content-Type'] = $header['Content-Type'] ?? $inputSerializer->getContentType();
        }

        if ($outputSerializer) {
            $header['Accept'] = $header['Accept'] ?? $outputSerializer->getContentType();
        }

        $this->logger->debug("({$requestId}) {$method} {$url} : Sending request", ['body' => $body, 'query' => $query, 'header' => $header]);

        try {
            $response = $this->httpClient->request(
                $method,
                $url,
                $this->serialize($body, $inputSerializer),
                $query,
                $header
            ) ?? '';

            $response = Response::from($response, $this->httpClient->lastResponseHeaders(), $this->httpClient->lastResponseStatusCode());
            $response->setSerializer($outputSerializer);

            $this->logger->debug("({$requestId}) {$method} {$url} : Read successful", ['response' => $response->getBody()]);
            return $this->responseReceived($response) ?? $response;
        } catch (HttpException $e) {
            $response = $e->getResponse();
            $this->logger->error("({$requestId}) {$method} {$url} : Read failed with status code {$e->getStatusCode()} {$e->getStatusMessage()}", ['exception' => strval($e), 'response' => $response ? $response->getBody() : null]);

            if ($response) {
                $response->setSerializer($outputSerializer);
            }

            $this->exceptionThrown($e);
        } catch (Throwable $e) {
            $this->logger->error("({$requestId}) {$method} {$url} : Read failed with unhandled exception", ['exception' => strval($e)]);
            $this->exceptionThrown($e);
        }
    }

    private function incrementRequestCounter(): int
    {
        return ++self::$requestCounter;
    }

    protected function serialize($body, ?SerializerInterface $serializer = null): ?string
    {
        $serializer ??= $this->defaultSerializer;

        if (!$serializer) {
            return $body;
        }

        if ($body instanceof JsonSerializable) {
            $body = $body->jsonSerialize();
        }

        if (is_array($body) && $serializer) {
            $body = $serializer->serialize($body);
        }

        if (is_object($body) && $serializer) {
            $body = $serializer->serialize(get_object_vars($body));
        }

        return $body;
    }

    protected function responseReceived(Response $response): Response
    {
        return $response->unSerialize();
    }

    /**
     * @throws \Throwable
     */
    protected function exceptionThrown(Throwable $e): void
    {
        throw $e;
    }

    public function joinPath(string $relative): string
    {
        if (filter_var($relative, FILTER_VALIDATE_URL)) {
            // If it's a valid URL, that means it's not a relative path, so
            // don't append it to our base.
            return $relative;
        }

        return $this->environment->joinPath($relative);
    }

    //

    protected function post(string $path, $body, array $query = [], array $header = []): Response
    {
        return $this->request(__FUNCTION__, $this->joinPath($path), $body, $query, $header);
    }

    protected function put(string $path, $body, array $query = [], array $header = []): Response
    {
        return $this->request(__FUNCTION__, $this->joinPath($path), $body, $query, $header);
    }

    protected function patch(string $path, $body, array $query = [], array $header = []): Response
    {
        return $this->request(__FUNCTION__, $this->joinPath($path), $body, $query, $header);
    }

    protected function delete(string $path, $body, array $query = [], array $header = []): Response
    {
        return $this->request(__FUNCTION__, $this->joinPath($path), $body, $query, $header);
    }

    protected function head(string $path, array $query = [], array $header = []): Response
    {
        return $this->request(__FUNCTION__, $this->joinPath($path), null, $query, $header);
    }
}
