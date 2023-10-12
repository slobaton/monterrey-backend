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
            ['name' => 'Casual', 'price' => 2.5],
            ['name' => 'Celeste', 'price' => 1],
            ['name' => 'Maiz', 'price' => 3.5],
            ['name' => 'Grafo', 'price' => 3],
            ['name' => 'Negro', 'price' => 4],
            ['name' => 'Plomo Oscuro', 'price' => 1],
            ['name' => 'Plomo Claro', 'price' => 1.5],
            ['name' => 'Azul Noche', 'price' => 2.5],
            ['name' => 'Normal', 'price' => 2],
            ['name' => 'Tabaco', 'price' => 3],
            ['name' => 'Verde', 'price' => 4],
            ['name' => 'Marengo', 'price' => 5],
            ['name' => 'Oxido', 'price' => 5.5],
            ['name' => 'Cafe', 'price' => 2],
            ['name' => 'Uva', 'price' => 3.5],
            ['name' => 'Acero', 'price' => 1],
            ['name' => 'Celeste Matizado', 'price' => 2.5],
            ['name' => 'Enzina(plomo)', 'price' => 1],
            ['name' => 'Plomo', 'price' => 1.5],
            ['name' => 'Ceniza', 'price' => 3],
            ['name' => 'Cemento', 'price' => 4.5],
            ['name' => 'Cobre', 'price' => 4],
            ['name' => 'Ojal', 'price' => 3],
            ['name' => 'Hielo', 'price' => 5],
            ['name' => 'Castaño', 'price' => 5.5],
            ['name' => 'Fijado Indigo', 'price' => 2],
            ['name' => 'Menta', 'price' => 2],
            ['name' => 'Enzima Matizado', 'price' => 2],
            ['name' => 'Petroleo', 'price' => 2],
            ['name' => 'Verde Oxido', 'price' => 2],
            ['name' => 'Plomo Hielo', 'price' => 2],
            ['name' => 'Humo', 'price' => 2.5],
            ['name' => 'Celeste Sucio', 'price' => 3],
            ['name' => 'Plomo Azulado', 'price' => 4],
            ['name' => 'Crudo', 'price' => 3],
            ['name' => 'Acero Claro', 'price' => 2],
            ['name' => 'Azulon', 'price' => 1],
            ['name' => 'Verde Susiño', 'price' => 2],
            ['name' => 'Celeste Blis', 'price' => 1],
            ['name' => 'Amarillo', 'price' => 1.5],
            ['name' => 'Arena', 'price' => 2],
            ['name' => 'Turqueza', 'price' => 2.5],
            ['name' => 'Rosado', 'price' => 3],
            ['name' => 'Chocolate', 'price' => 2],
            ['name' => 'Rojo', 'price' => 4],
            ['name' => 'Teñido', 'price' => 2],
            ['name' => 'Al agua', 'price' => 4.5],
            ['name' => 'Pigmentado Castaño', 'price' => 5],
            ['name' => 'Pigmentado Maiz', 'price' => 5.5],
            ['name' => 'Pigmentado Verde', 'price' => 5],
            ['name' => 'Pigmentado Saneston', 'price' => 3],
            ['name' => 'Ezima Pigmentado', 'price' => 3.5]
        ]);
    }
}
