<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserEducation>
 */
class UserEducationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'school_name' => fake()->company().' School',
            'type' => fake()->randomElement(['high_school', 'college', 'university']),
            'degree' => fake()->word(),
            'field_of_study' => fake()->word(),
            'start_date' => fake()->date(),
            'end_date' => fake()->optional()->date(),
            'is_current' => fake()->boolean(),
        ];
    }
}
