<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{

    use HasFactory, SoftDeletes;
    // Relación Inversa (1 a Muchos)
    protected $fillable = [
        'category_id', 'name', 'description',
        'price', 'is_gluten_free', 'image_path',
    ];

    // Accessor: URL completa de la imagen o placeholder
    public function getImageUrlAttribute(): string
    {
        return $this->image_path
            ? Storage::url($this->image_path)
            : 'https://placehold.co/400x300/e8f5e9/2d6a2d?text=Sin+imagen';
    }
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
