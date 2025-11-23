<?php

namespace App\Models\JeepTrip;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JeepTripSlot extends Model
{
    use HasFactory, Loggable;

    protected $fillable = ['jeep_trip_id', 'nama_slot', 'jam_mulai', 'jam_selesai', 'is_active'];

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'is_active' => 'boolean',
        'jam_mulai' => 'datetime:H:i',
        'jam_selesai' => 'datetime:H:i',
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

    public function jeepTrip()
    {
        return $this->belongsTo(JeepTrip::class, 'jeep_trip_id');
    }

    public function availabilities()
    {
        return $this->hasMany(JeepTripAvailability::class, 'jeep_trip_slot_id');
    }

    public function bookingItems()
    {
        return $this->hasMany(JeepTripBookingItem::class, 'jeep_trip_slot_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper Methods
    public function getFormattedTimeRange()
    {
        return $this->jam_mulai->format('H:i') . ' - ' . $this->jam_selesai->format('H:i');
    }

    public function getAvailabilityForDate($date)
    {
        return $this->availabilities()->where('tanggal', $date)->first();
    }

    public function isAvailableOnDate($date, $jumlahJeep = 1)
    {
        $availability = $this->getAvailabilityForDate($date);

        if (!$availability || $availability->is_closed) {
            return false;
        }

        return ($availability->quota_jeep - $availability->quota_terpakai) >= $jumlahJeep;
    }
}