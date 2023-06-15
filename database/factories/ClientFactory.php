<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nit' => fake()->numerify('#############'),
            'name' => fake()->name(),
            'paternal_surname' => fake()->lastName(),
            'maternal_surname' => fake()->lastName(),
            'phone' => fake()->phoneNumber(),
            'cellphone' => fake()->phoneNumber(),
            'address' => fake()->address(),
            'observations' => fake()->text(),
        ];
    }
}
