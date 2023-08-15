<?php

namespace Database\Seeders;

use App\Models\ClothSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClothSizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClothSize::insert([
            ['name' => 'G', 'wash_price' => 0.8],
            ['name' => 'J', 'wash_price' => 0.6],
            ['name' => 'P', 'wash_price' => 0.5],
        ]);
    }
}
