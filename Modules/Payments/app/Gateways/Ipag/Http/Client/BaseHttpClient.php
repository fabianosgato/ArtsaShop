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
