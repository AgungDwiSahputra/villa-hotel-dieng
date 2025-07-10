<?php

namespace App\Models\Produk;

use App\Models\Transaksi\TransaksiDetail;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Produk extends Model
{
    use Loggable;

    protected $fillable  = ['category_id', 'name', 'slug', 'unit', 'kamar', 'orang', 'maks_orang', 'lokasi', 'harga_weekday', 'harga_weekend', 'label','urutan'];

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

    public function category()
    {
        return $this->belongsTo(ProdukCategory::class, 'category_id');
    }
    public function images()
    {
        return $this->hasMany(ProdukImage::class, 'produk_id')->orderBy('urutan');
    }
    public function fasilitases()
    {
        return $this->hasMany(ProdukFasilitas::class, 'produk_id');
    }
    public function wisatas()
    {
        return $this->hasMany(ProdukWisata::class, 'produk_id');
    }
    public function syarats()
    {
        return $this->hasMany(ProdukSyarat::class, 'produk_id');
    }
    public function transaksi()
    {
        return $this->hasMany(TransaksiDetail::class, 'produk_id');
    }
}
