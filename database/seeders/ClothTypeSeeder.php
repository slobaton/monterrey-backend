<?php

namespace Database\Seeders;

use App\Models\ClothType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClothTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClothType::insert([
            ['name' => 'Pant'],
            ['name' => 'Jardinera'],
            ['name' => 'Overol'],
            ['name' => 'Camisa'],
            ['name' => 'Chaleco'],
            ['name' => 'Buso'],
            ['name' => 'Chamarra'],
            ['name' => 'Conjunto'],
            ['name' => 'Panta.Chama'],
            ['name' => 'Short'],
            ['name' => 'Capri'],
            ['name' => 'Conjunto de 3 pieza'],
            ['name' => 'Prenda O'],
            ['name' => 'Short Corto'],
            ['name' => 'Pant. Amarrado'],
            ['name' => 'Falda'],
            ['name' => 'Jhamper'],
            ['name' => 'Chamarra Especial'],
            ['name' => 'Tela'],
            ['name' => 'Gabardina'],
            ['name' => 'Calza'],
            ['name' => 'A.P.T.'],
        ]);
    }
}
