<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = \App\Models\Category::factory(5)->create(); //crea 5 categorias
        foreach ($categories as $category){ //crea las categorias hasta acabar
            \App\Models\Product::factory(10)->create([ //cada categoria tiene 10 productos
                'category_id' => $category->id
            ]);
        }
    }
}
