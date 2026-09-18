<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'group_code',
        'xendit_invoice_id',
        'status',
        'method',
        'payment_channel',
        'amount',
        'invoice_url',
        'paid_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'payment_group', 'group_code');
    }
}
