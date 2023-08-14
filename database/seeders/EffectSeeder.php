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
            ['id' => $faker->uuid(), 'name' => 'Focalizado'],
            ['id' => $faker->uuid(), 'name' => 'Raspado'],
            ['id' => $faker->uuid(), 'name' => 'Piedra'],
            ['id' => $faker->uuid(), 'name' => 'Bronceado'],
            ['id' => $faker->uuid(), 'name' => 'Trapeado'],
            ['id' => $faker->uuid(), 'name' => 'Stonado'],
            ['id' => $faker->uuid(), 'name' => 'Piedra Focalizado'],
            ['id' => $faker->uuid(), 'name' => 'Arrugado'],
            ['id' => $faker->uuid(), 'name' => 'Suavizado'],
            ['id' => $faker->uuid(), 'name' => 'Lijado'],
            ['id' => $faker->uuid(), 'name' => 'Brocesdo y stoneado'],
            ['id' => $faker->uuid(), 'name' => 'Focalizado solo pinos'],
            ['id' => $faker->uuid(), 'name' => 'Stoner Pawer'],
            ['id' => $faker->uuid(), 'name' => 'Lijado stoneado'],
            ['id' => $faker->uuid(), 'name' => 'Stoner 2 arrugado'],
            ['id' => $faker->uuid(), 'name' => 'Bronceado Focalizado'],
            ['id' => $faker->uuid(), 'name' => 'Reacron Stoneado'],
            ['id' => $faker->uuid(), 'name' => 'Reacron'],
            ['id' => $faker->uuid(), 'name' => 'Reacron Focalizado'],
            ['id' => $faker->uuid(), 'name' => 'Bronceado Stonado'],
            ['id' => $faker->uuid(), 'name' => 'Stonado Entero'],
            ['id' => $faker->uuid(), 'name' => 'Bisturí y Corte de bota'],
            ['id' => $faker->uuid(), 'name' => 'Piedra stonado'],
            ['id' => $faker->uuid(), 'name' => 'Planchado'],
            ['id' => $faker->uuid(), 'name' => 'Foc Lijado Bisturí y Corte de bota'],
            ['id' => $faker->uuid(), 'name' => 'Arreglado'],
            ['id' => $faker->uuid(), 'name' => 'Re-lavado'],
            ['id' => $faker->uuid(), 'name' => 'Pigmentado'],
            ['id' => $faker->uuid(), 'name' => 'Doble Trapeado'],
            ['id' => $faker->uuid(), 'name' => 'Amarrado'],
            ['id' => $faker->uuid(), 'name' => 'Stonado arrugado'],
            ['id' => $faker->uuid(), 'name' => 'Stonado por Partes'],
            ['id' => $faker->uuid(), 'name' => 'Pestañas'],
            ['id' => $faker->uuid(), 'name' => 'Focalizado c/ pestañas'],
            ['id' => $faker->uuid(), 'name' => 'Lijado focalizado'],
            ['id' => $faker->uuid(), 'name' => 'Stonado c/ pestañas'],
            ['id' => $faker->uuid(), 'name' => 'Lijado Stonado'],
            ['id' => $faker->uuid(), 'name' => 'Lijado Bronceado'],
            ['id' => $faker->uuid(), 'name' => 'Focalizado Parchado'],
            ['id' => $faker->uuid(), 'name' => 'Bronceado Parchado'],
            ['id' => $faker->uuid(), 'name' => 'Stonado Parchado'],
            ['id' => $faker->uuid(), 'name' => 'Parchado'],
            ['id' => $faker->uuid(), 'name' => 'Lijado Foc. Parchado'],
            ['id' => $faker->uuid(), 'name' => 'Lijado Parchado'],
            ['id' => $faker->uuid(), 'name' => 'Secado Parchado'],
            ['id' => $faker->uuid(), 'name' => 'Apañado Focalizado'],
            ['id' => $faker->uuid(), 'name' => 'Apañado Foc,lijado,parchado'],
            ['id' => $faker->uuid(), 'name' => 'Lijado Apañado Focalizado'],
            ['id' => $faker->uuid(), 'name' => 'Apañado Lijado Focalizado'],
            ['id' => $faker->uuid(), 'name' => 'Apañado lijado Parchado'],
            ['id' => $faker->uuid(), 'name' => 'Lijado Apañado'],
            ['id' => $faker->uuid(), 'name' => 'Apañado Lijado'],
            ['id' => $faker->uuid(), 'name' => 'Nevado'],
            ['id' => $faker->uuid(), 'name' => 'Nevado Granizado']
        ]);
    }
}
