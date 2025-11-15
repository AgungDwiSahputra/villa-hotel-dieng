<?php

namespace App\Models\Transaksi;

use App\Models\Produk\Produk;
use App\Models\Promo\Promo;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaksi extends Model
{
    use Loggable;
    protected $fillable  = ['produk_id', 'order_id', 'start_date', 'end_date', 'night', 'unit', 'total', 'name', 'email', 'no_wa', 'image', 'status', 'payment_status', 'promo_id', 'promo_code', 'discount_amount', 'original_total'];

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'discount_amount' => 'decimal:2',
        'original_total' => 'decimal:2',
    ];

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

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }
}
