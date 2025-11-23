<?php

namespace App\Models\JeepTrip;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JeepTripInclude extends Model
{
    use Loggable;

    protected $fillable = ['jeep_trip_id', 'nama_item'];

    public $incrementing = false;
    protected $keyType = 'string';

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function jeepTrip()
    {
        return $this->belongsTo(JeepTrip::class, 'jeep_trip_id');
    }
}