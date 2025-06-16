<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Apartment>
 */
class ApartmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->name,
            'description' => fake()->sentence(20),
            'rooms' => fake()->numberBetween(1, 5),
            'max_people' => fake()->numberBetween(2, 10),
            'price' => fake()->numberBetween(100, 1000),
            'country' => fake()->country,
            'city' => fake()->city,
            'street' => fake()->address,
            'lat' => fake()->latitude,
            'lon' => fake()->longitude,
        ];
    }
}
