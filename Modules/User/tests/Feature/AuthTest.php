<?php

namespace Modules\User\Tests\Feature;

use Modules\User\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use PHPUnit\Framework\Attributes\Test;

class AuthTest extends TestCase
{
    #[Test]
    public function it_registers_a_user_and_returns_correct_response()
    {
        // Arrange
        $userData = [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'Password123',
            'password_confirmation' => 'Password123',
        ];

        // Act
        $response = $this->postJson('/api/register', $userData);

        // Assert
        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'body' => [
                    'user' => [
                        'id',
                        'firstName',
                        'lastName',
                        'email',
                        'createdAt' => [
                            'timestamp',
                            'formatted',
                            'human',
                            'dateTime',
                            'date',
                        ],
                        'updatedAt' => [
                            'timestamp',
                            'formatted',
                            'human',
                            'dateTime',
                            'date',
                        ],
                    ],
                    'accessToken',
                ],
            ])
            ->assertJson([
                'status' => true,
                'message' => null,
                'body' => [
                    'user' => [
                        'firstName' => 'John',
                        'lastName' => 'Doe',
                        'email' => 'john.doe@example.com',
                    ],
                ],
            ]);
    }

    #[Test]
    public function user_cannot_register_with_invalid_data()
    {
        $invalidData = [
            'first_name' => '',
            'last_name' => '',
            'email' => 'invalid-email',
            'password' => '',
        ];

        $response = $this->postJson('/api/register', $invalidData);

        $response->assertStatus(422) // Unprocessable Entity
        ->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'password']);
    }

    #[Test]
    public function user_can_login_with_correct_credentials()
    {
        User::factory()->create([
            'email' => 'john.doe@example.com',
            'password' => 'Password123',
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'john.doe@example.com',
            'password' => 'Password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'body' => [
                    'accessToken'
                ]
            ]);
    }

    #[Test]
    public function user_cannot_login_with_invalid_credentials()
    {
        $user = User::factory()->create([
            'email' => 'john.doe@example.com',
            'password' => Hash::make('Password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => 'john.doe@example.com',
            'password' => 'wrongpassword',
        ]);

        $response->assertStatus(400) // Unauthorized
        ->assertJson([
            'status' => false,
            'message' => 'Invalid login credentials',
        ]);
    }

    #[Test]
    public function authenticated_user_can_logout()
    {
        $user = User::factory()->create();

        $token = $user->createToken('TestToken')->accessToken;

        $response = $this->withHeaders([
            'Authorization' => 'Bearer ' . $token,
        ])->postJson('/api/logout');

        $response->assertStatus(200)
            ->assertJson([
                'status' => true,
                'message' => 'Logged out successfully',
            ]);
    }

    #[Test]
    public function guest_cannot_logout()
    {
        $response = $this->postJson('/api/logout');

        $response->assertStatus(401);
    }
}
