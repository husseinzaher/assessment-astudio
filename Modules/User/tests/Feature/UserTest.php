<?php

namespace Modules\User\Tests\Feature;

use App\Enums\Guard;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\Passport;
use Modules\User\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class UserTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        Passport::actingAs($user, guard: Guard::User->value);
    }

    private string $endpoint = '/api/users'; // Change route as needed

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_fetch_all_users()
    {
        User::truncate();

        User::factory()->count(3)->create();

        $response = $this->getJson($this->endpoint);

        $response->assertStatus(200)->assertJsonCount(3, 'body.users.data'); // Check response count
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_can_fetch_a_single_user()
    {
        $user = User::factory()->create();

        $response = $this->getJson("{$this->endpoint}/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
                'body' => [
                    'user' => ['id' => $user->id]
                ]
            ]);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function it_returns_404_for_non_existing_user()
    {
        $response = $this->getJson("{$this->endpoint}/99999");

        $response->assertStatus(404);
    }


    #[Test]
    public function user_can_be_created()
    {
        $response = $this->postJson('/api/users', [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'email' => 'john.doe@example.com',
            'password' => 'Password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'body' => ['user' => ['id', 'firstName', 'lastName', 'email', 'createdAt', 'updatedAt']],
            ]);
    }

    #[Test]
    public function user_cannot_be_created_with_invalid_data()
    {
        $response = $this->postJson('/api/users', [
            'first_name' => '',
            'last_name' => '',
            'email' => 'invalid-email',
            'password' => '',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['first_name', 'last_name', 'email', 'password']);
    }

    #[Test]
    public function users_can_be_listed_with_pagination()
    {
        User::factory(10)->create();

        $response = $this->getJson('/api/users');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'status',
                'message',
                'body' => ['users' => [
                    'data' => [
                        '*' => ['id', 'firstName', 'lastName', 'email', 'createdAt', 'updatedAt'],
                    ],
                    'paginate' => ['links', 'count', 'total'],
                ]],
            ]);
    }

    #[Test]
    public function it_returns_404_when_updating_non_existing_user()
    {
        $response = $this->putJson("{$this->endpoint}/99999", ['name' => 'Test']);

        $response->assertStatus(404);
    }

    #[Test]
    public function it_can_delete_a_user()
    {
        $user = User::factory()->create();

        $response = $this->deleteJson("{$this->endpoint}/{$user->id}");

        $response->assertStatus(200);

        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    #[Test]
    public function it_returns_404_when_deleting_non_existing_user()
    {
        $response = $this->deleteJson("{$this->endpoint}/99999");

        $response->assertStatus(404);
    }
}
