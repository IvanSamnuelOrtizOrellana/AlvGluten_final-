<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    //  Definimos las constantes para no equivocarnos nunca al escribir
    const ROLE_ADMIN = 'admin';
    const ROLE_USER = 'usuario';

    // Creamos una pregunta auxiliar inteligente
    public function isAdmin()
    {
        return $this->rol === self::ROLE_ADMIN;
    }

    public function cartProducts()
    {
        // el belongstomany nos ayuda a relacion de muchos a muchos
        return $this->belongsToMany(Product::class, 'product_user')
            ->withTimestamps();
    }
}
