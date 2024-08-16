<?php

namespace Database\Seeders;

use App\Models\SystemParameter;
use Illuminate\Database\Seeder;

class ParametersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemParameter::insert([
            ['code' => SystemParameter::FOCALIZADO_PRICE, 'name' => 'Precio Focalizado', 'description' => 'precio general para focalizado', 'value' => 3],
            ['code' => SystemParameter::NEVADO_PRICE, 'name' => 'Precio Nevado', 'description' => 'precio general para nevado', 'value' => 2],
            ['code' => SystemParameter::BUTTONHOLE_PRICE, 'name' => 'Hojal Precio Unitario', 'description' => 'precio unitario por hojal', 'value' => 0.5],
            ['code' => SystemParameter::BUTTONHOLE_MIN, 'name' => 'Num. Hojales Regalo', 'description' => 'numero minimo de hojales de regalo', 'value' => 1],
            ['code' => SystemParameter::CURRENCY_CHANGE_RATE, 'name' => 'Valor Tipo de Cambio', 'description' => 'valor tipo de cambio dolar a boliviano', 'value' => 6.96]
        ]);
    }
}
