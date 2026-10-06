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
namespace Modules\Payments\Gateways\Ipag\Http\Client;


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
     * @throws \RuntimeException
     * @throws \Modules\Payments\Gateways\Ipag\Exception\HttpTransferException
     * @throws \Modules\Payments\Gateways\Ipag\Exception\HttpClientException
     * @throws \Modules\Payments\Gateways\Ipag\Exception\HttpServerException
     *
     */
    public abstract function request(string $method, string $url, ?string $body, array $query = [], array $header = []): ?string;

    public abstract function lastResponseHeaders(): ?array;

    public abstract function lastResponseStatusCode(): ?int;
}
