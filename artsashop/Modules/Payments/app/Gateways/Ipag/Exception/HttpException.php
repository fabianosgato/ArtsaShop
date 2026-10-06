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
namespace Modules\Payments\Gateways\Ipag\Exception;

use Modules\Payments\Gateways\Ipag\Http\Response;
use Throwable;

abstract class HttpException extends BaseException
{
    protected ?Response $response;
    protected ?int $statusCode;
    protected ?string $statusMessage;
    protected ?array $errors;

    public function __construct(
        string     $message = '',
        int        $code = 0,
        ?Throwable $previous = null,
        ?Response  $response = null,
        ?int       $statusCode = null,
        ?string    $statusMessage = null,
        ?array     $errors = []
    )
    {
        parent::__construct($message, $code, $previous);

        $this->response = $response;
        $this->statusCode = $statusCode;
        $this->statusMessage = $statusMessage;
        $this->errors = $errors;
    }

    public function getResponse(): ?Response
    {
        return $this->response;
    }

    public function getStatusCode(): ?int
    {
        return $this->statusCode;
    }

    public function getStatusMessage(): ?string
    {
        return $this->statusMessage;
    }

    public function getErrors(): ?array
    {
        return $this->errors;
    }
}
