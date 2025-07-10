<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Hewan\Hewan;
use App\Models\Jaringan\JaringanAksesoris;
use App\Models\Jaringan\Jaringan;
use App\Models\Jaringan\JaringanUnitSr;
use App\Models\Produksi\Produksi;
use App\Models\Transaction\Transaction;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasFactory, Notifiable, Loggable, HasRoles, SoftDeletes;

    protected $fillable  = ['name','email','password','no_hp','role','image'];
    protected $hidden    = ['password','remember_token'];
    
    protected $keyType   = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) Str::uuid();
        });
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function produksi(){
        return $this->hasMany(Produksi::class,'user_id')->orderBy('created_at','desc');
    }
    public function jaringan(){
        return $this->hasMany(Jaringan::class,'user_id')->orderBy('created_at','desc');
    }
    public function unitSr(){
        return $this->hasMany(JaringanUnitSr::class,'user_id')->orderBy('created_at','desc');
    }
    public function aksesoris(){
        return $this->hasMany(JaringanAksesoris::class,'user_id')->orderBy('created_at','desc');
    }
}
