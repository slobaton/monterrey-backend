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
            ['name' => 'G'],
            ['name' => 'J'],
            ['name' => 'P'],
        ]);
    }
}
