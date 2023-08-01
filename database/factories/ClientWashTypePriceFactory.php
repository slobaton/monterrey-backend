<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\WashType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ClientWashTypePriceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'wash_type_id' => WashType::factory(),
            'client_id' => Client::factory(),
            'price' => fake()->numerify('####.##')
        ];
    }
}
