<?php

namespace App\Models\JeepTrip;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JeepTripAvailability extends Model
{
    use Loggable;

    protected $fillable = ['jeep_trip_slot_id', 'tanggal', 'quota_jeep', 'quota_terpakai', 'is_closed'];

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'tanggal' => 'date',
        'quota_jeep' => 'integer',
        'quota_terpakai' => 'integer',
        'is_closed' => 'boolean',
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

    public function slot()
    {
        return $this->belongsTo(JeepTripSlot::class, 'jeep_trip_slot_id');
    }

    public function jeepTrip()
    {
        return $this->hasOneThrough(JeepTrip::class, JeepTripSlot::class, 'id', 'id', 'jeep_trip_slot_id', 'jeep_trip_id');
    }

    // Helper Methods
    public function getQuotaTersedia()
    {
        return max(0, $this->quota_jeep - $this->quota_terpakai);
    }

    public function isFullyBooked()
    {
        return $this->quota_terpakai >= $this->quota_jeep;
    }

    public function canBook($jumlahJeep)
    {
        return !$this->is_closed && ($this->getQuotaTersedia() >= $jumlahJeep);
    }

    public function reserveQuota($jumlahJeep)
    {
        if (!$this->canBook($jumlahJeep)) {
            return false;
        }

        $this->increment('quota_terpakai', $jumlahJeep);
        return true;
    }

    public function releaseQuota($jumlahJeep)
    {
        $this->decrement('quota_terpakai', min($jumlahJeep, $this->quota_terpakai));
        return true;
    }

    public function getStatusText()
    {
        if ($this->is_closed) {
            return 'Ditutup';
        }

        $tersedia = $this->getQuotaTersedia();

        if ($tersedia === 0) {
            return 'Penuh';
        } elseif ($tersedia <= 2) {
            return 'Hampir Penuh';
        } else {
            return 'Tersedia';
        }
    }
}