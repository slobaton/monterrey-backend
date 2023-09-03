<?php

namespace Database\Seeders;

use App\Models\Effect;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EffectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        Effect::insert([
            ['id' => $faker->uuid(), 'name' => 'Focalizado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Raspado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Piedra', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Bronceado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Trapeado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Stonado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Piedra Focalizado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Arrugado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Suavizado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Lijado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Brocesdo y stoneado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Focalizado solo pinos', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Stoner Pawer', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Lijado stoneado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Stoner 2 arrugado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Bronceado Focalizado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Reacron Stoneado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Reacron', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Reacron Focalizado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Bronceado Stonado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Stonado Entero', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Bisturí y Corte de bota', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Piedra stonado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Planchado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Foc Lijado Bisturí y Corte de bota', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Arreglado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Re-lavado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Pigmentado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Doble Trapeado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Amarrado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Stonado arrugado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Stonado por Partes', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Pestañas', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Focalizado c/ pestañas', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Lijado focalizado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Stonado c/ pestañas', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Lijado Stonado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Lijado Bronceado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Focalizado Parchado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Bronceado Parchado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Stonado Parchado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Parchado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Lijado Foc. Parchado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Lijado Parchado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Secado Parchado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Apañado Focalizado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Apañado Foc,lijado,parchado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Lijado Apañado Focalizado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Apañado Lijado Focalizado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Apañado lijado Parchado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Lijado Apañado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Apañado Lijado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Nevado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Nevado Granizado', 'price' => 1]
        ]);
    }
}
