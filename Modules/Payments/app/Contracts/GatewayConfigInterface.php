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
namespace Modules\Payments\Contracts;

interface GatewayConfigInterface
{
    /**
     * Código do ambiente (sandbox, production)
     */
    public function environment(): string;

    /**
     * URL base da API
     */
    public function baseUrl(): string;

    /**
     * Chave secreta
     */
    public function secretKey(): string;

    /**
     * Chave pública
     */
    public function publicKey(): string;

    /**
     * ID da conta (account_id)
     */
    public function accountId(): string;

    /**
     * Chave secreta do webhook
     */
    public function webhookSecret(): string;

    /**
     * ID da API (para IPag)
     */
    public function apiId(): string;

    /**
     * Chave da API (para IPag)
     */
    public function apiKey(): string;

    /**
     * Verifica se o gateway está ativo
     */
    public function isActive(): bool;

}
