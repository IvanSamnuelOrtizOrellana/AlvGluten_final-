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
        // Fabrica 5 categorías y las guardamos en una variable
        $categories = \App\Models\Category::factory(5)->create();

        // Recorremos cada categoría que se acaba de crear
        foreach ($categories as $category) {

            // 3. Y por cada una, le fabricamos 10 productos amarrados a su ID
            \App\Models\Product::factory(10)->create([
                'category_id' => $category->id
            ]);

        } // <--- ¡ESTA ES LA LLAVE QUE TE FALTABA MANITO!

        // Creamos tu usuario de prueba
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}