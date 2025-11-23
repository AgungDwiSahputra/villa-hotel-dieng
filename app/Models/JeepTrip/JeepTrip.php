<?php

namespace App\Models\JeepTrip;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class JeepTrip extends Model
{
    use HasFactory, Loggable;

    protected $fillable = [
        'kode', 'slug', 'nama_paket', 'deskripsi_singkat', 'deskripsi_lengkap',
        'zona', 'durasi_jam', 'kapasitas_ideal_per_jeep',
        'kapasitas_max_per_jeep', 'harga_weekday', 'harga_weekend', 'rating', 'is_active'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'harga_weekday' => 'decimal:2',
        'harga_weekend' => 'decimal:2',
        'rating' => 'decimal:2',
        'is_active' => 'boolean',
        'kapasitas_ideal_per_jeep' => 'integer',
        'kapasitas_max_per_jeep' => 'integer',
        'durasi_jam' => 'integer',
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

    // Relationships
    public function destinations()
    {
        return $this->hasMany(JeepTripDestination::class, 'jeep_trip_id')->orderBy('urutan');
    }

    public function includes()
    {
        return $this->hasMany(JeepTripInclude::class, 'jeep_trip_id');
    }

    public function excludes()
    {
        return $this->hasMany(JeepTripExclude::class, 'jeep_trip_id');
    }

    public function images()
    {
        return $this->hasMany(JeepTripImage::class, 'jeep_trip_id')->orderBy('urutan');
    }

    public function slots()
    {
        return $this->hasMany(JeepTripSlot::class, 'jeep_trip_id');
    }

    public function bookingItems()
    {
        return $this->hasMany(JeepTripBookingItem::class, 'jeep_trip_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Helper Methods
    public function getMainImage()
    {
        return $this->images()->first();
    }

    public function getAvailableSlotsForDate($date)
    {
        return $this->slots()
            ->whereHas('availabilities', function ($query) use ($date) {
                $query->where('tanggal', $date)
                      ->where('is_closed', false)
                      ->whereRaw('quota_terpakai < quota_jeep');
            })
            ->with(['availabilities' => function ($query) use ($date) {
                $query->where('tanggal', $date);
            }])
            ->get();
    }

    public function getSlotAvailability($slotId, $date)
    {
        $availability = JeepTripAvailability::where('jeep_trip_slot_id', $slotId)
            ->where('tanggal', $date)
            ->first();

        if (!$availability) {
            return null;
        }

        return [
            'quota_total' => $availability->quota_jeep,
            'quota_terpakai' => $availability->quota_terpakai,
            'quota_tersedia' => max(0, $availability->quota_jeep - $availability->quota_terpakai),
            'is_closed' => $availability->is_closed,
        ];
    }

    public function checkAvailability($slotId, $date, $jumlahJeep)
    {
        $availability = $this->getSlotAvailability($slotId, $date);

        if (!$availability || $availability['is_closed']) {
            return false;
        }

        return $availability['quota_tersedia'] >= $jumlahJeep;
    }

    public function calculatePrice($date, $jumlahJeep = 1)
    {
        $dayOfWeek = \Carbon\Carbon::parse($date)->dayOfWeek;
        $isWeekend = ($dayOfWeek === 0 || $dayOfWeek === 6); // Sunday = 0, Saturday = 6

        $hargaSatuan = $isWeekend ? $this->harga_weekend : $this->harga_weekday;
        $total = $hargaSatuan * $jumlahJeep;

        return [
            'harga_satuan' => $hargaSatuan,
            'jumlah_jeep' => $jumlahJeep,
            'total' => $total,
            'is_weekend' => $isWeekend,
            'date' => $date,
        ];
    }

    public function getFormattedDuration()
    {
        if (!$this->durasi_jam) {
            return 'Durasi tidak ditentukan';
        }

        $hours = floor($this->durasi_jam);
        $minutes = ($this->durasi_jam - $hours) * 60;

        if ($minutes > 0) {
            return "{$hours} jam {$minutes} menit";
        }

        return "{$hours} jam";
    }

    public function getCapacityText()
    {
        if ($this->kapasitas_ideal_per_jeep === $this->kapasitas_max_per_jeep) {
            return "{$this->kapasitas_ideal_per_jeep} orang per jeep";
        }

        return "{$this->kapasitas_ideal_per_jeep}-{$this->kapasitas_max_per_jeep} orang per jeep";
    }
}