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
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Dieter', 'paternal_surname' => 'Cayoja'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Erwin', 'paternal_surname' => 'Cayoja'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Douglas', 'paternal_surname' => 'Achocalla'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Maruja', 'paternal_surname' => 'Mamani'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Deyvi', 'paternal_surname' => 'Villca'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Fernando', 'paternal_surname' => 'Viraca'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Nelson', 'paternal_surname' => 'Eugenio'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Miyler', 'paternal_surname' => 'Villca'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Noemi', 'paternal_surname' => 'Zeballos'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Jonathan', 'paternal_surname' => 'Viraca'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Roxana', 'paternal_surname' => 'Herrera'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Patricia', 'paternal_surname' => 'Valdivia'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Jorge Luis', 'paternal_surname' => 'villca'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Wili', 'paternal_surname' => 'Martines'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Daniela', 'paternal_surname' => 'Gutierrez'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Janeth', 'paternal_surname' => 'Bedoya'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Lourdes', 'paternal_surname' => 'Mamani'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Willy', 'paternal_surname' => 'Manjares'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Antonio', 'paternal_surname' => 'Quispe'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Amalia', 'paternal_surname' => 'Choque'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Yhony', 'paternal_surname' => 'Herrera'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Yhony ', 'paternal_surname' => 'Herrera'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'ANDEPA', 'paternal_surname' => 'SRL'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Carolina ', 'paternal_surname' => 'Magne'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Fausto ', 'paternal_surname' => 'Silvestre'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Juan ', 'paternal_surname' => 'Vasquez'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Lila', 'paternal_surname' => 'Alarcon'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Victor ', 'paternal_surname' => 'Salas '],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Dioni ', 'paternal_surname' => 'Ipurani'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Carlos ', 'paternal_surname' => 'Salamanca'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Rocio ', 'paternal_surname' => 'Rodriguez'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Raul ', 'paternal_surname' => 'Orellana'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Frank', 'paternal_surname' => 'Huanca'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Carlos ', 'paternal_surname' => 'Salamanca'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Maribel ', 'paternal_surname' => 'Flores '],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Jhovana', 'paternal_surname' => 'Gandarillas'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Richar ', 'paternal_surname' => 'Matias '],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Jose Luis ', 'paternal_surname' => 'Matias '],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Elias ', 'paternal_surname' => 'Ramos'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Gualberto', 'paternal_surname' => 'Sipe'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Mirian ', 'paternal_surname' => 'Mamani'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Patricia ', 'paternal_surname' => 'Salinas '],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Griselda', 'paternal_surname' => 'Iba?ez'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Miguel', 'paternal_surname' => 'Mamani'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Sabina ', 'paternal_surname' => 'Ramos'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Erminia ', 'paternal_surname' => 'Trujillo'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Efrain', 'paternal_surname' => 'Marca'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Moises ', 'paternal_surname' => 'Navarro'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Deco', 'paternal_surname' => 'Checa'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Bladimir', 'paternal_surname' => 'Romero'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Rosa ', 'paternal_surname' => 'Choque'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Deco ', 'paternal_surname' => 'Checa'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Vanesa ', 'paternal_surname' => 'Santos '],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Maria Elena ', 'paternal_surname' => 'Moreno'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Sofia ', 'paternal_surname' => 'Blanco'],
            ['id' => $faker->uuid(), 'nit' => $faker->numerify('#########'), 'name' => 'Benita', 'paternal_surname' => 'Garcia']
        ]);
    }
}
