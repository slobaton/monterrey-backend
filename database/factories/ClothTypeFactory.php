<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClothType>
 */
class ClothTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => 'washtype-' . fake()->unique()->name(),
            'description' => fake()->text(),
            'is_active' => fake()->boolean()
        ];
    }
}
