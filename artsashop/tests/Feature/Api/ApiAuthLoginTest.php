<?php
namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ApiAuthLoginTest extends TestCase
{
    public function test_user_can_login_and_receive_an_api_token(): void
    {
        // Arrange
        $email = 'api-login-test@example.com';
        $password = 'password123';

        $user = User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password),
            'status' => true,
        ]);

        // Act
        $response = $this->postJson('/api/auth/login', [
            'email' => $email,
            'password' => $password,
            'device_name' => 'web'
        ]);

        // Assert
        $response
            ->assertOk()
            ->assertJsonStructure([
                'token',
            ]);

        $this->assertDatabaseHas('sys_personal_access_tokens', [
            'tokenable_type' => User::class,
            'tokenable_id' => $user->getKey(),
        ]);

    }

    public function test_user_disable_can_login_and_receive_an_api_token(): void
    {
        // Arrange
        $email = 'api-login-test2@example.com';
        $password = 'password123';

        $user = User::factory()->create([
            'email' => $email,
            'password' => Hash::make($password),
            'status' => false,
        ]);

        // Act
        $response = $this->postJson('/api/auth/login', [
            'email' => $email,
            'password' => $password,
            'device_name' => 'web'
        ]);

        // Assert
        $response->assertUnauthorized();

    }



}
