<?php

namespace Modules\EntityAttribute\Tests\Feature;

use App\Enums\Guard;
use Laravel\Passport\Passport;
use Modules\EntityAttribute\Models\Attribute;
use Modules\EntityAttribute\Enums\AttributeType;
use Modules\User\Models\User;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AttributeTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create();

        Passport::actingAs($user, guard: Guard::User->value);
    }

    #[Test]
    public function it_can_create_an_attribute()
    {
        $data = [
            'name' => 'Color',
            'type' => AttributeType::Select,
            'options' => [
                ['label' => 'Red', 'value' => 'red'],
                ['label' => 'Blue', 'value' => 'blue'],
            ],
        ];

        $response = $this->postJson('/api/attributes', $data);

        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'message',
            'body' => [
                'attribute' => [
                    'id', 'name', 'type', 'options' => [['id', 'label', 'value']],
                    'createdAt' => ['timestamp', 'formatted', 'human', 'dateTime', 'date'],
                    'updatedAt' => ['timestamp', 'formatted', 'human', 'dateTime', 'date']
                ]
            ]
        ]);
    }

    #[Test]
    public function it_can_update_an_attribute()
    {
        $attribute = Attribute::factory()->create();
        $data = ['name' => 'Updated Name', 'type' => AttributeType::Text];

        $response = $this->putJson("/api/attributes/{$attribute->id}", $data);

        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'message',
            'body' => [
                'attribute' => ['id', 'name', 'type', 'options', 'createdAt', 'updatedAt']
            ]
        ]);

        $this->assertDatabaseHas('attributes', ['id' => $attribute->id, 'name' => 'Updated Name']);
    }

    #[Test]
    public function it_can_delete_an_attribute()
    {
        $attribute = Attribute::factory()->create();

        $response = $this->deleteJson("/api/attributes/{$attribute->id}");

        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'message',
            'body'
        ]);

        $this->assertDatabaseMissing('attributes', ['id' => $attribute->id]);
    }

    #[Test]
    public function it_can_list_attributes()
    {
        Attribute::factory()->count(3)->create();

        $response = $this->getJson('/api/attributes');

        $response->assertStatus(200)->assertJsonStructure([
            'status',
            'message',
            'body' => [
                'attributes' => [['id', 'name', 'type', 'options', 'createdAt', 'updatedAt']]
            ]
        ]);
    }

    #[Test]
    public function it_validates_attribute_creation()
    {
        $response = $this->postJson('/api/attributes', []);

        $response->assertStatus(422)->assertJsonStructure([
            'message',
            'errors' => ['name', 'type']
        ]);
    }
}
