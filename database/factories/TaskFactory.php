<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'status' => $this->faker->numberBetween(0, 1),
            'date' => Carbon::now()->addDays($this->faker->numberBetween(1, 365))->format('Y-m-d'),
            'user_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
