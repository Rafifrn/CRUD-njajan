<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Minuman extends Model
{
    protected $table = 'minumen';

    protected $fillable = ['name', 'slug', 'description', 'image', 'price', 'region'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
