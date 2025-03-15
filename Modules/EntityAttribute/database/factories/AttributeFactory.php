<?php

namespace Modules\EntityAttribute\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\EntityAttribute\Enums\AttributeType;
use Modules\EntityAttribute\Models\Attribute;

/**
 * @extends Factory<Attribute>
 */
class AttributeFactory extends Factory
{
    protected $model = Attribute::class;

    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'type' => AttributeType::Text
        ];
    }
}
