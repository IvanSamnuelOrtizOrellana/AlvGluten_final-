<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    // Relación Inversa (1 a Muchos)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function users()
    {
        // indica que tiene una relacion de muchos a muchos con products
        return $this->belogsTomany(User::class, 'product_user')
            ->withTimestamps();
    }
}
