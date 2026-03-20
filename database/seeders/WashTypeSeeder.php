<?php

namespace Database\Seeders;

use App\Models\WashType;
use Illuminate\Database\Seeder;

class WashTypeSeeder extends Seeder
{
    public function run(): void
    {
        WashType::insert([
            ['name' => 'Azul Noches',    'price' => 0],
            ['name' => 'Ezima',          'price' => 0],
            ['name' => 'Castaño',        'price' => 0],
            ['name' => 'Grafo',          'price' => 0],
            ['name' => 'Azulon',         'price' => 0],
            ['name' => 'Celeste',        'price' => 0],
            ['name' => 'Celeste Hielo',  'price' => 0],
            ['name' => 'Verde Oscuro',   'price' => 0],
            ['name' => 'Verde Botella',  'price' => 0],
            ['name' => 'Negro',          'price' => 0],
        ]);
    }
}
