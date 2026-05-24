<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'total', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //una orden puede tener muchos productos
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    //funcion que ayuda a cambiar el color del estado de la orden en la vista
    public function statusColor(): string
    {
       return match($this->status)
    {
            'pendiente'  => 'yellow',
            'confirmado' => 'lime',
            'enviado'    => 'blue',
            'entregado'  => 'green',
            default      => 'gray',
    };
    }
}
