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
            ['name' => 'Enzima', 'price' => 2],
            ['name' => 'Casual', 'price' => 2],
            ['name' => 'Celeste', 'price' => 2],
            ['name' => 'Maiz', 'price' => 2],
            ['name' => 'Grafo', 'price' => 2],
            ['name' => 'Negro', 'price' => 2],
            ['name' => 'Plomo Oscuro', 'price' => 2],
            ['name' => 'Plomo Claro', 'price' => 2],
            ['name' => 'Azul Noche', 'price' => 2],
            ['name' => 'Normal', 'price' => 2],
            ['name' => 'Tabaco', 'price' => 2],
            ['name' => 'Verde', 'price' => 2],
            ['name' => 'Marengo', 'price' => 2],
            ['name' => 'Oxido', 'price' => 2],
            ['name' => 'Cafe', 'price' => 2],
            ['name' => 'Uva', 'price' => 2],
            ['name' => 'Acero', 'price' => 2],
            ['name' => 'Celeste Matizado', 'price' => 2],
            ['name' => 'Enzina(plomo)', 'price' => 2],
            ['name' => 'Plomo', 'price' => 2],
            ['name' => 'Ceniza', 'price' => 2],
            ['name' => 'Cemento', 'price' => 2],
            ['name' => 'Cobre', 'price' => 2],
            ['name' => 'Ojal', 'price' => 2],
            ['name' => 'Hielo', 'price' => 2],
            ['name' => 'Castaño', 'price' => 2],
            ['name' => 'Fijado Indigo', 'price' => 2],
            ['name' => 'Menta', 'price' => 2],
            ['name' => 'Enzima Matizado', 'price' => 2],
            ['name' => 'Petroleo', 'price' => 2],
            ['name' => 'Verde Oxido', 'price' => 2],
            ['name' => 'Plomo Hielo', 'price' => 2],
            ['name' => 'Humo', 'price' => 2],
            ['name' => 'Celeste Sucio', 'price' => 2],
            ['name' => 'Plomo Azulado', 'price' => 2],
            ['name' => 'Crudo', 'price' => 2],
            ['name' => 'Acero Claro', 'price' => 2],
            ['name' => 'Azulon', 'price' => 2],
            ['name' => 'Verde Susiño', 'price' => 2],
            ['name' => 'Celeste Blis', 'price' => 2],
            ['name' => 'Amarillo', 'price' => 2],
            ['name' => 'Arena', 'price' => 2],
            ['name' => 'Turqueza', 'price' => 2],
            ['name' => 'Rosado', 'price' => 2],
            ['name' => 'Chocolate', 'price' => 2],
            ['name' => 'Rojo', 'price' => 2],
            ['name' => 'Teñido', 'price' => 2],
            ['name' => 'Al agua', 'price' => 2],
            ['name' => 'Pigmentado Castaño', 'price' => 2],
            ['name' => 'Pigmentado Maiz', 'price' => 2],
            ['name' => 'Pigmentado Verde', 'price' => 2],
            ['name' => 'Pigmentado Saneston', 'price' => 2],
            ['name' => 'Ezima Pigmentado', 'price' => 2]
        ]);
    }
}
