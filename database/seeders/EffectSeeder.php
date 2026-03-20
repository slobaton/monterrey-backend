<?php

namespace Database\Seeders;

use App\Models\Effect;
use Illuminate\Database\Seeder;

class EffectSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        Effect::insert([
            // Proceso extra
            ['id' => $faker->uuid(), 'name' => 'Nevado',     'price' => 0],
            ['id' => $faker->uuid(), 'name' => 'Focalizado', 'price' => 0],
            ['id' => $faker->uuid(), 'name' => 'Fronceado',  'price' => 0],
            // Efectos - Desgastes
            ['id' => $faker->uuid(), 'name' => 'Motor',      'price' => 0],
            ['id' => $faker->uuid(), 'name' => 'Lijado',     'price' => 0],
            ['id' => $faker->uuid(), 'name' => 'Bigote',     'price' => 0],
            ['id' => $faker->uuid(), 'name' => 'Esmeril',    'price' => 0],
        ]);
    }
}
