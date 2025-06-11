<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Minuman extends Model
{
    //mass assignment
    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
