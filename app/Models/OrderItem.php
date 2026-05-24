<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'product_name', 'unit_price', 'quantity'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //el subtotal de los productos
    public function getSubtotalAttribute(): float
    {
        return  $this->unit_price * $this->quantity;
    }
}
