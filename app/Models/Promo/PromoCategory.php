<?php

namespace App\Models\Promo;

use App\Models\Produk\ProdukCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PromoCategory extends Model
{
    protected $fillable = [
        'promo_id', 'category_id', 'discount_type', 'discount_value', 'enabled'
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

    public function category()
    {
        return $this->belongsTo(ProdukCategory::class, 'category_id');
    }
}