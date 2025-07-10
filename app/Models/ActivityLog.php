<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;

class ActivityLog extends Model
{
    use HasFactory;
    protected $table='logs';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'log_date',
        'table_name',
        'log_type',
        'data'
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id')->withTrashed();
    }
}
