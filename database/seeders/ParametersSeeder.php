<?php

namespace Database\Seeders;

use App\Models\ChargeParameter;
use Illuminate\Database\Seeder;

class ParametersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ChargeParameter::insert([
            ['name' => 'focalizado_price', 'description' => 'precio general para focalizado', 'price' => 25],
            ['name' => 'nevado_price', 'description' => 'precio general para nevado', 'price' => 35]
        ]);
    }
}
