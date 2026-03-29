<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // User needs to provide imageable_id and imageable_type normally
            'type' => 'default',
            'path' => fake()->imageUrl(),
            'disk' => 'public',
            'file_name' => fake()->word().'.jpg',
            'mime_type' => 'image/jpeg',
            'size' => fake()->randomNumber(5),
            'order_column' => fake()->optional()->randomDigit(),
        ];
    }
}
