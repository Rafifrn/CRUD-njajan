<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Makanan extends Model
{
    //mass assignment
    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // relationships
    public function harga(): HasMany
    {
        return $this->hasMany(Harga::class);
    }
}
