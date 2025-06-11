<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dessert extends Model
{
    //mass assignment
    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
