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

namespace Idea\Framework\Services\Auth;

use Idea\Framework\Interfaces\Auth\AccessTokenIssuerInterface;
use Idea\Framework\Interfaces\Auth\TokenServiceInterface;
use Idea\Framework\Interfaces\Auth\UserAuthenticatorInterface;

class TokenService implements TokenServiceInterface
{
    public function __construct(
        private readonly UserAuthenticatorInterface $userAuthenticator,
        private readonly AccessTokenIssuerInterface $tokenIssuer,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function issueToken(
        string $email,
        string $password,
        string $deviceName
    ): string {

        $user = $this->userAuthenticator->authenticate(
            $email,
            $password
        );

        return $this->tokenIssuer->issue(
            $user,
            $deviceName
        );

    }

}
