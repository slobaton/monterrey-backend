<?php

namespace Database\Seeders;

use App\Enums\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $role = \App\Models\Role::create([
            'name' => Roles::ADMIN
        ]);
        $secreRole = \App\Models\Role::create([
            'name' => Roles::SECRETARY
        ]);
        $admin = \App\Models\User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => 'password'
        ]);
        $secre = \App\Models\User::create([
            'name' => 'Secretary',
            'username' => 'secre',
            'password' => 'password'
        ]);
        $admin->roles()->attach($role);
        $secre->roles()->attach($secreRole);
        \App\Models\User::factory(100)->create();
        // \App\Models\Client::factory(100)->create();
        // \App\Models\WashType::factory(100)->create();
        \App\Models\ClothType::factory(100)->create();
        // \App\Models\Effect::factory(100)->create();
        \App\Models\ClothSize::factory(100)->create();

        $this->call([
            ClientSeeder::class,
            EffectSeeder::class,
            WashTypeSeeder::class,
        ]);
    }
}
