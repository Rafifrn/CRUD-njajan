<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Harga extends Model
{
    //mass assignment
    protected $guarded = ['id'];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    // relationships
    public function makanan() : BelongsTo
    {
        return $this->belongsTo(Makanan::class);
    }

    public function minuman() : BelongsTo
    {
        return $this->belongsTo(Minuman::class);
    }
}
