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

namespace Modules\Payments\Gateways\Ipag\Http;

use Modules\Payments\Gateways\Ipag\IO\SerializerInterface;
use Modules\Payments\Gateways\Ipag\Util\ArrayUtil;

class Response
{
    protected ?SerializerInterface $serializer;
    protected ?array $data;
    protected ?string $raw;

    protected ?array $headers;

    protected ?int $statusCode;

    protected function __construct(?SerializerInterface $serializer, ?string $body, ?array $headers, ?int $statusCode)
    {
        $this->raw = $body;
        $this->serializer = $serializer;
        $this->data = null;
        $this->headers = $headers;
        $this->statusCode = $statusCode;
    }

    public static function from(?string $data, ?array $headers = null, ?int $statusCode = null): self
    {
        return new static(null, $data, $headers, $statusCode);
    }

    public function getParsedPath(string $dotNotation, $default = null)
    {
        return ArrayUtil::get('data.' . $dotNotation, $this->getParsed(), $default);
    }

    public function getParsed(): ?array
    {
        $this->unSerialize();

        return [
            'data' => $this->data,
            'headers' => $this->headers,
            'statusCode' => $this->statusCode
        ];
    }

    public function unSerialize(): self
    {
        if (empty($this->raw) || gettype(json_decode($this->raw)) === 'string')
            $this->data = ['data' => $this->raw];
        else
            $this->data = $this->serializer?->unserialize($this->raw);

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->raw;
    }

    public function getHeaders(): ?array
    {
        return $this->headers;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function getData(): ?array
    {
        return $this->data;
    }

    //

    public function setSerializer(?SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }
}
