<?php

namespace App\Models\Produk;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class ProdukCategory extends Model
{
    use Loggable;

    protected $fillable  = ['name','slug','urutan'];
    
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

    public function produks(){
        return $this->hasMany(Produk::class,'category_id')->where('status', 'publish')->orderBy('urutan');
    }

    public function getActivePromos()
    {
        $promoIds = \App\Models\Promo\PromoCategory::where('category_id', $this->id)
            ->pluck('promo_id')
            ->toArray();

        return \App\Models\Promo\Promo::active()
            ->whereIn('id', $promoIds)
            ->get();
    }
}
