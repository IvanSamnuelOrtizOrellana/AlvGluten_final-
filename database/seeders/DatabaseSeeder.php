<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::firstOrCreate(
        ['email' => 'admin@alvgluten.com'],
        [
            'name'               => 'Admin Alvgluten',
            'password'           => bcrypt('password'),//crea un hash en la base de datos para encriptar la contraseña
            'rol'               => User::ROLE_ADMIN, //constante del rol en
            'email_verified_at' =>now(),

        ]);

        User::firstOrCreate(
            ['email' => 'cliente@alvgluten.com'],
            [
                'name'               => 'Cliente Prueba',
                'password'           => bcrypt('password'),
                'rol'               => User::ROLE_USER,
                'email_verified_at' =>now(),

            ]);

        // Fabrica 5 categorías y las guardamos en una variable
        $categories = \App\Models\Category::factory(5)->create();

        // Recorremos cada categoría que se acaba de crear
        foreach ($categories as $category) {

            // 3. Y por cada una, le fabricamos 10 productos amarrados a su ID
            \App\Models\Product::factory(10)->create([
                'category_id' => $category->id
            ]);

        }


    }
}