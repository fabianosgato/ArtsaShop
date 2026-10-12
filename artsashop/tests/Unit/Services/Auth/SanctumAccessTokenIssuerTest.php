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

namespace Tests\Unit\Services\Auth;

use Idea\Framework\Services\Auth\SanctumAccessTokenIssuer;
use Illuminate\Contracts\Auth\Authenticatable;
use LogicException;
use Tests\TestCase;

class SanctumAccessTokenIssuerTest extends TestCase
{
    public function test_rejects_user_that_does_not_support_sanctum(): void
    {
        // Arrange
        $user = $this->createMock(Authenticatable::class);

        $issuer = new SanctumAccessTokenIssuer();

        // Act + Assert
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage(
            'O usuário não suporta emissão de tokens via Sanctum.'
        );

        $issuer->issue(
            $user,
            'test-device'
        );
    }

    public function test_issues_sanctum_access_token(): void
    {
        // Arrange
        $issuer = new SanctumAccessTokenIssuer();

        // Act
        $token = $issuer->issue(
            new class implements Authenticatable {
                public function getAuthIdentifierName()
                {
                    return 'id';
                }

                public function getAuthIdentifier()
                {
                    return 1;
                }

                public function getAuthPasswordName()
                {
                    return 'password';
                }

                public function getAuthPassword()
                {
                    return 'password';
                }

                public function getRememberToken()
                {
                    return null;
                }

                public function setRememberToken($value): void
                {
                }

                public function getRememberTokenName()
                {
                    return 'remember_token';
                }

                public function createToken(string $deviceName): object
                {
                    return (object)[
                        'plainTextToken' => 'test-token-123',
                    ];
                }
            },
            'test-device'
        );

        // Assert
        $this->assertSame(
            'test-token-123',
            $token
        );
    }
}
