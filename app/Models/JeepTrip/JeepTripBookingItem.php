<?php

namespace App\Models\JeepTrip;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JeepTripBookingItem extends Model
{
    use Loggable;

    protected $fillable = [
        'jeep_trip_booking_id', 'jeep_trip_id', 'jeep_trip_slot_id',
        'tanggal_trip', 'jumlah_jeep', 'harga_satuan', 'subtotal'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'tanggal_trip' => 'date',
        'jumlah_jeep' => 'integer',
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
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

    public function booking()
    {
        return $this->belongsTo(JeepTripBooking::class, 'jeep_trip_booking_id');
    }

    public function jeepTrip()
    {
        return $this->belongsTo(JeepTrip::class, 'jeep_trip_id');
    }

    public function slot()
    {
        return $this->belongsTo(JeepTripSlot::class, 'jeep_trip_slot_id');
    }

    // Helper Methods
    public function getFormattedHargaSatuan()
    {
        return 'Rp ' . number_format($this->harga_satuan, 0, ',', '.');
    }

    public function getFormattedSubtotal()
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }

    public function getFormattedTanggalTrip()
    {
        return $this->tanggal_trip->locale('id')->isoFormat('dddd, D MMMM YYYY');
    }

    public function getSlotTimeRange()
    {
        return $this->slot ? $this->slot->getFormattedTimeRange() : 'Slot tidak tersedia';
    }
}