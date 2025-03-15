<?php

namespace Modules\Timesheet\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Project\Models\Project;
use Modules\Timesheet\Models\Timesheet;
use Modules\User\Models\User;

/**
 * @extends Factory<Timesheet>
 */
class TimesheetFactory extends Factory
{
    protected $model = Timesheet::class;

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
            'task_name' => fake()->slug(),
            'date' => fake()->date(),
            'hours' => fake()->numberBetween(1, 500),
            'project_id' => Project::factory(),
            'user_id' => User::factory()->create(),
        ];
    }
}
