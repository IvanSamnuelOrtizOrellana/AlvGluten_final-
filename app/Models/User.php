<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
      'password',
      'remember_token',
    ];

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
            ->withPivot('quantity')   
            ->withTimestamps();
    }
    public function orders()
    {
      return $this->hasmany(Order::class)->latest();
    }
}
