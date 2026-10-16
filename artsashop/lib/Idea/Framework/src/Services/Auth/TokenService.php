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

use Idea\Framework\Contracts\Auth\TokenServiceInterface;
use Laravel\Sanctum\PersonalAccessToken;

class TokenService implements TokenServiceInterface
{

    public function __construct(
        private readonly UserAuthenticator $userAuthenticator,
        private readonly SanctumAccessTokenIssuer $tokenIssuer,
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

    /**
     * Metodo usado para deletar um Token
     * @return void
     */
    public function deleteToken(?string $bearerToken)
    {
        if ($bearerToken === null) {
            return;
        }

        $token = PersonalAccessToken::findToken($bearerToken);
        $token?->delete();

    }

}
