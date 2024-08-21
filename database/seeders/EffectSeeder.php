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
            ['id' => $faker->uuid(), 'name' => 'Raspado', 'price' => 2],
            ['id' => $faker->uuid(), 'name' => 'Piedra', 'price' => 3],
            ['id' => $faker->uuid(), 'name' => 'Bronceado', 'price' => 5],
            ['id' => $faker->uuid(), 'name' => 'Trapeado', 'price' => 5.5],
            ['id' => $faker->uuid(), 'name' => 'Stonado', 'price' => 1.5],
            ['id' => $faker->uuid(), 'name' => 'Piedra Focalizado', 'price' => 2],
            ['id' => $faker->uuid(), 'name' => 'Arrugado', 'price' => 2.5],
            ['id' => $faker->uuid(), 'name' => 'Suavizado', 'price' => 3],
            ['id' => $faker->uuid(), 'name' => 'Lijado', 'price' => 3.5],
            ['id' => $faker->uuid(), 'name' => 'Broceado y Stoneado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Focalizado Solo Pinos', 'price' => 2],
            ['id' => $faker->uuid(), 'name' => 'Stoner Pawer', 'price' => 2],
            ['id' => $faker->uuid(), 'name' => 'Lijado Stoneado', 'price' => 2.5],
            ['id' => $faker->uuid(), 'name' => 'Stoner 2 Arrugado', 'price' => 3],
            ['id' => $faker->uuid(), 'name' => 'Bronceado Focalizado', 'price' => 4.5],
            ['id' => $faker->uuid(), 'name' => 'Reacron Stoneado', 'price' => 4],
            ['id' => $faker->uuid(), 'name' => 'Reacron', 'price' => 5],
            ['id' => $faker->uuid(), 'name' => 'Reacron Focalizado', 'price' => 6],
            ['id' => $faker->uuid(), 'name' => 'Bronceado Stonado', 'price' => 6],
            ['id' => $faker->uuid(), 'name' => 'Stonado Entero', 'price' => 6.5],
            ['id' => $faker->uuid(), 'name' => 'Bisturí y Corte de Bota', 'price' => 3],
            ['id' => $faker->uuid(), 'name' => 'Piedra Stonado', 'price' => 2],
            ['id' => $faker->uuid(), 'name' => 'Planchado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Foc Lijado Bisturí y Corte de Bota', 'price' => 2],
            ['id' => $faker->uuid(), 'name' => 'Arreglado', 'price' => 2.5],
            ['id' => $faker->uuid(), 'name' => 'Re-lavado', 'price' => 1.5],
            ['id' => $faker->uuid(), 'name' => 'Pigmentado', 'price' => 2],
            ['id' => $faker->uuid(), 'name' => 'Doble Trapeado', 'price' => 3],
            ['id' => $faker->uuid(), 'name' => 'Amarrado', 'price' => 3],
            ['id' => $faker->uuid(), 'name' => 'Stonado Arrugado', 'price' => 4],
            ['id' => $faker->uuid(), 'name' => 'Stonado por Partes', 'price' => 4],
            ['id' => $faker->uuid(), 'name' => 'Pestañas', 'price' => 5],
            ['id' => $faker->uuid(), 'name' => 'Focalizado c/ pestañas', 'price' => 5.5],
            ['id' => $faker->uuid(), 'name' => 'Lijado Focalizado', 'price' => 6],
            ['id' => $faker->uuid(), 'name' => 'Stonado c/ Pestañas', 'price' => 6],
            ['id' => $faker->uuid(), 'name' => 'Lijado Stonado', 'price' => 6.5],
            ['id' => $faker->uuid(), 'name' => 'Lijado Bronceado', 'price' => 7],
            ['id' => $faker->uuid(), 'name' => 'Focalizado Parchado', 'price' => 2],
            ['id' => $faker->uuid(), 'name' => 'Bronceado Parchado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Stonado Parchado', 'price' => 2],
            ['id' => $faker->uuid(), 'name' => 'Parchado', 'price' => 3],
            ['id' => $faker->uuid(), 'name' => 'Lijado Foc. Parchado', 'price' => 5],
            ['id' => $faker->uuid(), 'name' => 'Lijado Parchado', 'price' => 4],
            ['id' => $faker->uuid(), 'name' => 'Secado Parchado', 'price' => 2],
            ['id' => $faker->uuid(), 'name' => 'Apañado Focalizado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Apañado Foc,Lijado,Parchado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Lijado Apañado Focalizado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Apañado Lijado Focalizado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Apañado Lijado Parchado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Lijado Apañado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Apañado Lijado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Nevado', 'price' => 1],
            ['id' => $faker->uuid(), 'name' => 'Nevado Granizado', 'price' => 1]
        ]);
    }
}
