<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Str;
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
        $admin = \App\Models\User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);
        $secre = \App\Models\User::create([
            'name' => 'Secretary',
            'username' => 'secre',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        ]);
        $admin->roles()->attach($role);
        $secre->roles()->attach($secreRole);
        \App\Models\User::factory(100)->create();
        \App\Models\Client::factory(100)->create();
    }
}
