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

declare(strict_types=1);

namespace Modules\Payments\Gateways\Pagarme\Exception;

use Exception;
use Illuminate\Http\Client\Response;

class PagarmeException extends Exception
{

    /**
     * Código HTTP retornado pela API.
     */
    protected ?int $statusCode;

    /**
     * Resposta original da API.
     */
    protected ?array $responseData;

    /**
     * Cria uma exceção do Pagar.me
     */
    public function __construct(
        string $message = 'Erro na comunicação com o Pagar.me.',
        ?int $statusCode = null,
        ?array $responseData = null,
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

    }

    /**
     * Cria uma exceção a partir de uma resposta da API.
     */
    public static function fromResponse(
        Response $response
    ): self {

        $responseData = $response->json();

        $message = $responseData['message']
            ?? $responseData['error']
            ?? 'Erro retornado pela API do Pagar.me.';

        return new self(
            message: $message,
            statusCode: $response->status(),
            responseData: is_array($responseData)
                ? $responseData
                : null
        );

    }

    /**
     * Retorna o código HTTP.
     */
    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    /**
     * Retorna os dados retornados pela API.
     */
    public function getResponseData(): ?array
    {
        return $this->responseData;
    }

}
