<?php

namespace Modules\EntityAttribute\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\EntityAttribute\Models\AttributeOption;

/**
 * @extends Factory<AttributeOption>
 */
class AttributeOptionFactory extends Factory
{
    protected $model = AttributeOption::class;

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
        ];
    }
}
