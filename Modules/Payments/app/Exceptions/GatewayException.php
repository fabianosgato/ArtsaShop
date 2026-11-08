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
namespace Modules\Payments\Exceptions;

use Exception;
use Illuminate\Http\Client\Response;

class GatewayException extends Exception
{
    protected ?int $statusCode;
    protected ?array $responseData;
    protected ?string $gatewayCode;

    public function __construct(
        string $message = 'Erro no gateway de pagamento.',
        ?int $statusCode = null,
        ?array $responseData = null,
        ?string $gatewayCode = null,
        int $code = 0,
        ?\Throwable $previous = null
    ) {
        parent::__construct(
            message: $message,
            code: $code,
            previous: $previous
        );

        $this->statusCode = $statusCode;
        $this->responseData = $responseData;
        $this->gatewayCode = $gatewayCode;
    }

    public static function fromResponse(Response $response, string $gatewayCode): self
    {
        $responseData = $response->json();

        $message = $responseData['message']
            ?? $responseData['error']
            ?? $responseData['errors'][0]['message'] ?? 'Erro retornado pelo gateway de pagamento.';

        return new self(
            message: $message,
            statusCode: $response->status(),
            responseData: is_array($responseData) ? $responseData : null,
            gatewayCode: $gatewayCode
        );
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function getResponseData(): ?array
    {
        return $this->responseData;
    }

    public function getGatewayCode(): ?string
    {
        return $this->gatewayCode;
    }
}
