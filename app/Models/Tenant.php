<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'logo',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function makanans()
    {
        return $this->hasMany(Makanan::class);
    }

    public function minumen()
    {
        return $this->hasMany(Minuman::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
