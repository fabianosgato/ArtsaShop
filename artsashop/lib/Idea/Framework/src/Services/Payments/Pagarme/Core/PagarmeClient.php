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

namespace Idea\Framework\Services\Payments\Pagarme\Core;

use Idea\Framework\Services\Payments\Pagarme\Exception\PagarmeException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class PagarmeClient
{

    /**
     * URL base da API.
     */
    protected string $baseUrl;

    /**
     * Chave secreta da API.
     */
    protected string $secretKey;

    /**
     * Timeout da requisição em segundos.
     */
    protected int $timeout;

    /**
     * Timeout da conexão em segundos.
     */
    protected int $connectTimeout;

    /**
     * Inicializa o Client da API Pagar.me.
     */
    public function __construct(
        string $secretKey,
        string $baseUrl,
        int    $timeout = 10,
        int    $connectTimeout = 5,
    )
    {

        $this->secretKey = $secretKey;

        $this->baseUrl = rtrim(
            $baseUrl,
            '/'
        );

        $this->timeout = $timeout;

        $this->connectTimeout = $connectTimeout;

    }

    /**
     * Cria uma requisição configurada para a API Pagar.me.
     */
    protected function request(): PendingRequest
    {

        return Http::baseUrl($this->baseUrl)
            ->withBasicAuth(
                username: $this->secretKey,
                password: ''
            )
            ->acceptJson()
            ->asJson()
            ->timeout($this->timeout)
            ->connectTimeout($this->connectTimeout);
    }

    /**
     * Executa uma requisição GET.
     */
    public function get(
        string $uri,
        array  $query = []
    ): Response
    {

        return $this->validateResponse(
            response: $this->request()->get(
                url: $uri,
                query: $query
            )
        );

    }

    /**
     * Executa uma requisição POST.
     */
    public function post(
        string $uri,
        array  $data = []
    ): Response
    {
        return $this->validateResponse(
            response: $this->request()->post(
                url: $uri,
                data: $data
            )
        );
    }

    /**
     * Executa uma requisição PUT.
     */
    public function put(
        string $uri,
        array  $data = []
    ): Response
    {

        return $this->validateResponse(
            $this->request()->put(
                url: $uri,
                data: $data
            )
        );

    }

    /**
     * Executa uma requisição PATCH.
     */
    public function patch(
        string $uri,
        array  $data = []
    ): Response
    {

        return $this->validateResponse(
            $this->request()->patch(
                url: $uri,
                data: $data
            )
        );

    }

    /**
     * Executa uma requisição DELETE.
     */
    public function delete(
        string $uri,
        array  $data = []
    ): Response
    {

        return $this->validateResponse(
            $this->request()->delete(
                url: $uri,
                data: $data
            )
        );

    }

    /**
     * Valida a resposta retornada pela API.
     */
    protected function validateResponse(Response $response): Response
    {

        if ($response->failed()) {

            throw PagarmeException::fromResponse(
                response: $response
            );

        }

        return $response;

    }
}
