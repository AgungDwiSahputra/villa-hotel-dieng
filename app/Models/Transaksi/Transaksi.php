<?php

namespace App\Models\Transaksi;

use App\Models\Produk\Produk;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaksi extends Model
{
    use Loggable;
    protected $fillable  = ['produk_id', 'order_id', 'start_date', 'end_date', 'night', 'unit', 'total', 'name', 'email', 'no_wa', 'image', 'status', 'payment_status'];

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

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
