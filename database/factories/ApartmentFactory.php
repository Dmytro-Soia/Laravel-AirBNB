<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
                'description' => fake()->sentence(),
                'photos' => fake()->name . '.jpg',
                'rooms' => 12,
                'max_people' => 12,
                'price' => 12,
                'country' => fake()->country,
                'city' => fake()->city,
                'street' => fake()->address,
        ];
    }
}
