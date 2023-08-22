<?php

namespace Database\Seeders;

use App\Models\WashType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WashTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WashType::insert([
            ['name' => 'Enzima'],
            ['name' => 'Casual'],
            ['name' => 'Celeste'],
            ['name' => 'Maiz'],
            ['name' => 'Grafo'],
            ['name' => 'Negro'],
            ['name' => 'Plomo Oscuro'],
            ['name' => 'Plomo Claro'],
            ['name' => 'Azul Noche'],
            ['name' => 'Normal'],
            ['name' => 'Tabaco'],
            ['name' => 'Verde'],
            ['name' => 'Marengo'],
            ['name' => 'Oxido'],
            ['name' => 'Cafe'],
            ['name' => 'Uva'],
            ['name' => 'Acero'],
            ['name' => 'Celeste Matizado'],
            ['name' => 'Enzina(plomo)'],
            ['name' => 'Plomo'],
            ['name' => 'Ceniza'],
            ['name' => 'Cemento'],
            ['name' => 'Cobre'],
            ['name' => 'Ojal'],
            ['name' => 'Hielo'],
            ['name' => 'Castaño'],
            ['name' => 'Fijado Indigo'],
            ['name' => 'Menta'],
            ['name' => 'Enzima Matizado'],
            ['name' => 'Petroleo'],
            ['name' => 'Verde Oxido'],
            ['name' => 'Plomo Hielo'],
            ['name' => 'Humo'],
            ['name' => 'Celeste Sucio'],
            ['name' => 'Plomo Azulado'],
            ['name' => 'Crudo'],
            ['name' => 'Acero Claro'],
            ['name' => 'Azulon'],
            ['name' => 'Verde Susiño'],
            ['name' => 'Celeste Blis'],
            ['name' => 'Amarillo'],
            ['name' => 'Arena'],
            ['name' => 'Turqueza'],
            ['name' => 'Rosado'],
            ['name' => 'Chocolate'],
            ['name' => 'Rojo'],
            ['name' => 'Teñido'],
            ['name' => 'Al agua'],
            ['name' => 'Pigmentado Castaño'],
            ['name' => 'Pigmentado Maiz'],
            ['name' => 'Pigmentado Verde'],
            ['name' => 'Pigmentado Saneston'],
            ['name' => 'Ezima Pigmentado']
        ]);
    }
}
