<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tenant_id',
        'kode',
        'payment_group',
        'items',
        'total',
        'status',
        'payment_status',
        'order_date',
    ];

    protected $casts = [
        'items' => 'array',
        'order_date' => 'datetime',
        'total' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_group', 'group_code');
    }

    public function getIsAktifAttribute(): bool
    {
        return in_array($this->status, ['pending', 'diproses']);
    }
}
