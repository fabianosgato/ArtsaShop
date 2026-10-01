<?php

namespace Idea\Framework\Services\Payments\Ipag\Core;

use Idea\Framework\Services\Payments\Ipag\Exception\HttpClientException;
use Idea\Framework\Services\Payments\Ipag\Http\Response;
use Idea\Framework\Services\Payments\Ipag\IO\SerializerInterface;
use Idea\Framework\Services\Payments\Ipag\Path\CompositePathInterface;
use Idea\Framework\Services\Payments\Ipag\Util\ArrayUtil;
use Idea\Framework\Services\Payments\Ipag\Util\PathUtil;
use Throwable;

abstract class Endpoint implements CompositePathInterface
{
    protected Client $client;
    protected CompositePathInterface $parent;
    protected ?SerializerInterface $serializer;
    protected string $location;

    public function __construct(Client $client, CompositePathInterface $parent, ?string $location = null, ?SerializerInterface $serializer = null)
    {
        $this->client = $client;
        $this->parent = $parent;
        $this->location = $this->location ?? $location;
        $this->serializer = $serializer;
    }

    //

    public static function make(Client $client, CompositePathInterface $parent, ?string $location = null, ?SerializerInterface $serializer = null)
    {
        return new static($client, $parent, $location, $serializer);
    }

    protected function _GET(array $query = [], array $header = [], ?string $relativeUrl = null): Response
    {
        return $this->request(__FUNCTION__, null, $query, $header, $relativeUrl);
    }

    protected function request(string $method, $body, array $query = [], array $header = [], ?string $relativeUrl = null): Response
    {
        try {
            return $this->client->request(
                strtoupper(substr($method, 1)),
                $relativeUrl ? $this->joinPath($relativeUrl) : $this->getPath(),
                $body,
                $query,
                $header,
                $this->serializer
            );
        } catch (HttpClientException $e) {

            $errorsSanitized = $this->sanitizeErrorMessage($e->getResponse());

            $this->exceptionThrown(
                new HttpClientException(
                    'response message: ' . json_encode(implode(' | ', $errorsSanitized)) . " (status code: {$e->getCode()})",
                    $e->getCode(),
                    $e,
                    $e->getResponse(),
                    null,
                    null,
                    $errorsSanitized
                )
            );

        } catch (Throwable $th) {
            $this->exceptionThrown($th);
        }
    }

    public function joinPath(string $relative): string
    {
        return implode(PathUtil::PATH_SEPARATOR, [$this->getPath(), ltrim($relative, PathUtil::PATH_SEPARATOR)]);
    }

    public function getPath(): string
    {
        return $this->getParent()->joinPath($this->location);
    }

    public function getParent(): ?CompositePathInterface
    {
        return $this->parent;
    }

    //

    public function setParent(?CompositePathInterface $parent): void
    {
        $this->parent = $parent;
    }

    private function sanitizeErrorMessage(Response $response): ?array
    {

        $responseData = $response->getParsedPath('message');

        if (is_string($responseData))
            return [$responseData];

        if (is_array($responseData))
            return ArrayUtil::extractStrings($responseData);

        $responseData = $response->getParsedPath('error');

        if (is_array($responseData))
            return ArrayUtil::extractStrings($responseData);

        $responseData = $response->getParsedPath('data');

        if (is_array($responseData))
            return ArrayUtil::extractStrings($responseData);

        return [];

    }

    protected function exceptionThrown(Throwable $e): void
    {
        throw $e;
    }

    protected function _POST($body, array $query = [], array $header = [], ?string $relativeUrl = null): Response
    {
        return $this->request(__FUNCTION__, $body, $query, $header, $relativeUrl);
    }

    protected function _PUT($body, array $query = [], array $header = [], ?string $relativeUrl = null): Response
    {
        return $this->request(__FUNCTION__, $body, $query, $header, $relativeUrl);
    }

    //

    protected function _PATCH($body, array $query = [], array $header = [], ?string $relativeUrl = null): Response
    {
        return $this->request(__FUNCTION__, $body, $query, $header, $relativeUrl);
    }

    protected function _DELETE(array $query = [], array $header = [], ?string $relativeUrl = null): Response
    {
        return $this->request(__FUNCTION__, null, $query, $header, $relativeUrl);
    }

    protected function _HEAD(array $query = [], array $header = [], ?string $relativeUrl = null): Response
    {
        return $this->request(__FUNCTION__, null, $query, $header, $relativeUrl);
    }

}
