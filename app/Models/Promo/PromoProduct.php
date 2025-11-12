<?php

namespace App\Models\Promo;

use App\Models\Produk\Produk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PromoProduct extends Model
{
    protected $fillable = [
        'promo_id', 'produk_id', 'discount_type', 'discount_value', 'enabled'
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'enabled' => 'boolean'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function promo()
    {
        return $this->belongsTo(Promo::class);
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}