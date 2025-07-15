<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Availability extends Model
{
    protected $fillable = [
        'id',
        'id_calendar',
        'produk_id',
        'date',
        'is_available',
    ];
}
