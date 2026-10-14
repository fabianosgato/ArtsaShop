<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Auth;

use App\Models\User;
use Idea\Framework\Interfaces\Auth\AccessTokenIssuerInterface;
use Idea\Framework\Interfaces\Auth\UserAuthenticatorInterface;
use Idea\Framework\Services\Auth\SanctumAccessTokenIssuer;
use Idea\Framework\Services\Auth\TokenService;
use Idea\Framework\Services\Auth\UserAuthenticator;
use Mockery;
use Tests\TestCase;

class TokenServiceTest extends TestCase
{
    public function test_issues_access_token_for_valid_credentials(): void
    {
        // Arrange
        $email = 'fabiano@example.com';
        $password = 'password123';
        $deviceName = 'web';

        $user = new User();

        $userAuthenticator = Mockery::mock(
            UserAuthenticator::class
        );

        $userAuthenticator
            ->shouldReceive('authenticate')
            ->once()
            ->with($email, $password)
            ->andReturn($user);

        $tokenIssuer = Mockery::mock(
            SanctumAccessTokenIssuer::class
        );

        $tokenIssuer
            ->shouldReceive('issue')
            ->once()
            ->with($user, $deviceName)
            ->andReturn('test-token-123');

        $tokenService = new TokenService(
            $userAuthenticator,
            $tokenIssuer
        );

        // Act
        $token = $tokenService->issueToken(
            $email,
            $password,
            $deviceName
        );

        // Assert
        $this->assertSame(
            'test-token-123',
            $token
        );
    }

    public function test_does_not_issue_token_when_authentication_fails(): void
    {
        // Arrange
        $email = 'fabiano@example.com';
        $password = 'wrong-password';
        $deviceName = 'web';

        $userAuthenticator = Mockery::mock(
            UserAuthenticatorInterface::class
        );

        $userAuthenticator
            ->shouldReceive('authenticate')
            ->once()
            ->with($email, $password)
            ->andThrow(
                new \Illuminate\Auth\AuthenticationException(
                    'Credenciais inválidas.'
                )
            );

        $tokenIssuer = Mockery::mock(
            AccessTokenIssuerInterface::class
        );

        $tokenIssuer
            ->shouldNotReceive('issue');

        $tokenService = new TokenService(
            $userAuthenticator,
            $tokenIssuer
        );

        // Act + Assert
        $this->expectException(
            \Illuminate\Auth\AuthenticationException::class
        );

        $tokenService->issueToken(
            $email,
            $password,
            $deviceName
        );
    }

}
