<?php

namespace App\Models\JeepTrip;

use App\Models\User;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JeepTripBooking extends Model
{
    use Loggable;

    protected $fillable = ['user_id', 'kode_booking', 'total_harga', 'status', 'payment_ref'];

    public $incrementing = false;
    protected $keyType = 'string';

    protected $casts = [
        'total_harga' => 'decimal:2',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
            if (empty($model->kode_booking)) {
                $model->kode_booking = 'JEEP-' . strtoupper(Str::random(8));
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function bookingItems()
    {
        return $this->hasMany(JeepTripBookingItem::class, 'jeep_trip_booking_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    // Helper Methods
    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isPaid()
    {
        return $this->status === 'paid';
    }

    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    public function markAsPaid($paymentRef = null)
    {
        $updateData = ['status' => 'paid'];
        if ($paymentRef) {
            $updateData['payment_ref'] = $paymentRef;
        }
        return $this->update($updateData);
    }

    public function markAsCancelled()
    {
        return $this->update(['status' => 'cancelled']);
    }

    public function getTotalJeepCount()
    {
        return $this->bookingItems->sum('jumlah_jeep');
    }

    public function getFormattedTotalHarga()
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }
}