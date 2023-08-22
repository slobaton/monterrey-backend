<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        Client::insert([
            ['id' => $faker->uuid(), 'name' => 'Dieter', 'paternal_surname' => 'Cayoja'],
            ['id' => $faker->uuid(), 'name' => 'Erwin', 'paternal_surname' => 'Cayoja'],
            ['id' => $faker->uuid(), 'name' => 'Douglas', 'paternal_surname' => 'Achocalla'],
            ['id' => $faker->uuid(), 'name' => 'Maruja', 'paternal_surname' => 'Mamani'],
            ['id' => $faker->uuid(), 'name' => 'Deyvi', 'paternal_surname' => 'Villca'],
            ['id' => $faker->uuid(), 'name' => 'Fernando', 'paternal_surname' => 'Viraca'],
            ['id' => $faker->uuid(), 'name' => 'Nelson', 'paternal_surname' => 'Eugenio'],
            ['id' => $faker->uuid(), 'name' => 'Miyler', 'paternal_surname' => 'Villca'],
            ['id' => $faker->uuid(), 'name' => 'Noemi', 'paternal_surname' => 'Zeballos'],
            ['id' => $faker->uuid(), 'name' => 'Jonathan', 'paternal_surname' => 'Viraca'],
            ['id' => $faker->uuid(), 'name' => 'Roxana', 'paternal_surname' => 'Herrera'],
            ['id' => $faker->uuid(), 'name' => 'Patricia', 'paternal_surname' => 'Valdivia'],
            ['id' => $faker->uuid(), 'name' => 'Jorge Luis', 'paternal_surname' => 'villca'],
            ['id' => $faker->uuid(), 'name' => 'Wili', 'paternal_surname' => 'Martines'],
            ['id' => $faker->uuid(), 'name' => 'Daniela', 'paternal_surname' => 'Gutierrez'],
            ['id' => $faker->uuid(), 'name' => 'Janeth', 'paternal_surname' => 'Bedoya'],
            ['id' => $faker->uuid(), 'name' => 'Lourdes', 'paternal_surname' => 'Mamani'],
            ['id' => $faker->uuid(), 'name' => 'Willy', 'paternal_surname' => 'Manjares'],
            ['id' => $faker->uuid(), 'name' => 'Antonio', 'paternal_surname' => 'Quispe'],
            ['id' => $faker->uuid(), 'name' => 'Amalia', 'paternal_surname' => 'Choque'],
            ['id' => $faker->uuid(), 'name' => 'Yhony', 'paternal_surname' => 'Herrera'],
            ['id' => $faker->uuid(), 'name' => 'Yhony ', 'paternal_surname' => 'Herrera'],
            ['id' => $faker->uuid(), 'name' => 'ANDEPA', 'paternal_surname' => 'SRL'],
            ['id' => $faker->uuid(), 'name' => 'Carolina ', 'paternal_surname' => 'Magne'],
            ['id' => $faker->uuid(), 'name' => 'Fausto ', 'paternal_surname' => 'Silvestre'],
            ['id' => $faker->uuid(), 'name' => 'Juan ', 'paternal_surname' => 'Vasquez'],
            ['id' => $faker->uuid(), 'name' => 'Lila', 'paternal_surname' => 'Alarcon'],
            ['id' => $faker->uuid(), 'name' => 'Victor ', 'paternal_surname' => 'Salas '],
            ['id' => $faker->uuid(), 'name' => 'Dioni ', 'paternal_surname' => 'Ipurani'],
            ['id' => $faker->uuid(), 'name' => 'Carlos ', 'paternal_surname' => 'Salamanca'],
            ['id' => $faker->uuid(), 'name' => 'Rocio ', 'paternal_surname' => 'Rodriguez'],
            ['id' => $faker->uuid(), 'name' => 'Raul ', 'paternal_surname' => 'Orellana'],
            ['id' => $faker->uuid(), 'name' => 'Frank', 'paternal_surname' => 'Huanca'],
            ['id' => $faker->uuid(), 'name' => 'Carlos ', 'paternal_surname' => 'Salamanca'],
            ['id' => $faker->uuid(), 'name' => 'Maribel ', 'paternal_surname' => 'Flores '],
            ['id' => $faker->uuid(), 'name' => 'Jhovana', 'paternal_surname' => 'Gandarillas'],
            ['id' => $faker->uuid(), 'name' => 'Richar ', 'paternal_surname' => 'Matias '],
            ['id' => $faker->uuid(), 'name' => 'Jose Luis ', 'paternal_surname' => 'Matias '],
            ['id' => $faker->uuid(), 'name' => 'Elias ', 'paternal_surname' => 'Ramos'],
            ['id' => $faker->uuid(), 'name' => 'Gualberto', 'paternal_surname' => 'Sipe'],
            ['id' => $faker->uuid(), 'name' => 'Mirian ', 'paternal_surname' => 'Mamani'],
            ['id' => $faker->uuid(), 'name' => 'Patricia ', 'paternal_surname' => 'Salinas '],
            ['id' => $faker->uuid(), 'name' => 'Griselda', 'paternal_surname' => 'Iba?ez'],
            ['id' => $faker->uuid(), 'name' => 'Miguel', 'paternal_surname' => 'Mamani'],
            ['id' => $faker->uuid(), 'name' => 'Sabina ', 'paternal_surname' => 'Ramos'],
            ['id' => $faker->uuid(), 'name' => 'Erminia ', 'paternal_surname' => 'Trujillo'],
            ['id' => $faker->uuid(), 'name' => 'Efrain', 'paternal_surname' => 'Marca'],
            ['id' => $faker->uuid(), 'name' => 'Moises ', 'paternal_surname' => 'Navarro'],
            ['id' => $faker->uuid(), 'name' => 'Deco', 'paternal_surname' => 'Checa'],
            ['id' => $faker->uuid(), 'name' => 'Bladimir', 'paternal_surname' => 'Romero'],
            ['id' => $faker->uuid(), 'name' => 'Rosa ', 'paternal_surname' => 'Choque'],
            ['id' => $faker->uuid(), 'name' => 'Deco ', 'paternal_surname' => 'Checa'],
            ['id' => $faker->uuid(), 'name' => 'Vanesa ', 'paternal_surname' => 'Santos '],
            ['id' => $faker->uuid(), 'name' => 'Maria Elena ', 'paternal_surname' => 'Moreno'],
            ['id' => $faker->uuid(), 'name' => 'Sofia ', 'paternal_surname' => 'Blanco'],
            ['id' => $faker->uuid(), 'name' => 'Benita', 'paternal_surname' => 'Garcia']
        ]);
    }
}
