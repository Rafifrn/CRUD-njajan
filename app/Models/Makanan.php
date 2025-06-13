<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Makanan extends Model
{
    protected $table = 'makanans';

    protected $fillable = ['name', 'slug', 'description', 'image', 'price', 'region'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
