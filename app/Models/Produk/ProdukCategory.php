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
        return $this->hasMany(Produk::class,'category_id')->orderBy('urutan');
    }
}
