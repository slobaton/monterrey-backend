<?php

namespace Database\Seeders;

use App\Enums\Roles;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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
        $receptionistRole = \App\Models\Role::create([
            'name' => Roles::RECEPTIONIST
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
        $receptionist = \App\Models\User::create([
            'name' => 'Receptionist',
            'username' => 'recep',
            'password' => 'password'
        ]);

        $admin->roles()->attach($role);
        $secre->roles()->attach($secreRole);
        $receptionist->roles()->attach($receptionistRole);

        \App\Models\User::factory(100)->create();

        $this->call([
            ParametersSeeder::class,
            ClientSeeder::class,
            EffectSeeder::class,
            WashTypeSeeder::class,
            ClothTypeSeeder::class,
            ClothSizeSeeder::class,
        ]);
    }
}
