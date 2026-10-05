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

declare(strict_types=1);

namespace Idea\Framework\Services\Payments\Pagarme\Exception;

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
     * Cria uma nova exceção do Pagar.me.
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
