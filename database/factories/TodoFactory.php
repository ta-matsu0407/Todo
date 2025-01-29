<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => rand(1, User::count()),
            'homework' => fake()->realText(20),
            'memo' => fake()->realText(50),
            'status' => fake()->numberBetween(0, 1),
            'deadline' => fake()->dateTimeThisYear(),

        ];
    }
}
