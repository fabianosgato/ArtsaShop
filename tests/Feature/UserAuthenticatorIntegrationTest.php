<?php
declare(strict_types=1);

namespace Tests\Feature;

use App\Models\User;
use Idea\Framework\Services\Auth\UserAuthenticator;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserAuthenticatorIntegrationTest extends TestCase
{
    use DatabaseTransactions;

    public function test_authenticates_an_active_user_with_valid_credentials(): void
    {
        // Arrange: cria um usuário real no banco de testes.
        $password = 'correct-password';

        $user = User::factory()->create([
            'status' => true,
            'password' => Hash::make($password),
        ]);

        // Valida se o usuário foi criado no banco de dados.
        $this->assertDatabaseHas('sys_users', [
            'user_id' => $user->user_id,
            'email' => $user->email,
        ]);

        // Act: utiliza o provider real configurado no Laravel.
        $authenticator = new UserAuthenticator();

        $authenticatedUser = $authenticator->authenticate(
            $user->email,
            $password
        );

        // Assert: verifica se a autenticação retornou o usuário correto.
        $this->assertInstanceOf(User::class, $authenticatedUser);

        $this->assertSame(
            $user->user_id,
            $authenticatedUser->user_id
        );

    }
    public function test_rejects_invalid_password_with_real_user_provider(): void
    {
        // Arrange: cria um usuário real no banco.
        $correctPassword = 'correct-password';

        $user = User::factory()->create([
            'status' => true,
            'password' => Hash::make($correctPassword),
        ]);

        // Act + Assert: a senha incorreta deve gerar uma exceção.
        $authenticator = new UserAuthenticator();

        $this->expectException(
            \Illuminate\Auth\AuthenticationException::class
        );

        $authenticator->authenticate(
            $user->email,
            'wrong-password'
        );

    }

    public function test_rejects_nonexistent_user(): void
    {
        // Arrange: define credenciais de um usuário inexistente.
        $email = 'nonexistent-user@example.com';
        $password = 'any-password';

        // Act + Assert: a autenticação deve ser rejeitada.
        $authenticator = new UserAuthenticator();

        $this->expectException(
            \Illuminate\Auth\AuthenticationException::class
        );

        $authenticator->authenticate(
            $email,
            $password
        );
    }

    public function test_rejects_status_user(): void
    {
        // Arrange: cria um usuário real no banco.
        $correctPassword = 'correct-password';

        $user = User::factory()->create([
            'status' => false,
            'password' => Hash::make($correctPassword),
        ]);

        // Act + Assert: a senha incorreta deve gerar uma exceção.
        $authenticator = new UserAuthenticator();

        $this->expectException(
            \Illuminate\Auth\AuthenticationException::class
        );

        $authenticator->authenticate(
            $user->email,
            'correct-password'
        );

    }

}

