<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_type',
        'product_id',
        'name',
        'price',
        'qty',
        'subtotal',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->product_type === 'makanan'
            ? $this->belongsTo(Makanan::class, 'product_id')
            : $this->belongsTo(Minuman::class, 'product_id');
    }
}
