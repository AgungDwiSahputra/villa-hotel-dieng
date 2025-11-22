<?php

namespace App\Models\Produk;

use App\Models\Promo\Promo;
use App\Models\Transaksi\Transaksi;
use App\Models\Transaksi\TransaksiDetail;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Produk extends Model
{
    use Loggable, SoftDeletes;

    protected $fillable  = ['category_id', 'owner', 'name', 'slug', 'unit', 'kamar', 'orang', 'maks_orang', 'lokasi', 'fasilitas', 'gluten', 'latitude', 'longitude', 'rating', 'status', 'has_active_promo', 'promo_price_weekday', 'promo_price_weekend', 'promo_discount_type', 'promo_discount_percentage', 'promo_calculated_at', 'label','urutan'];

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
    public function transaksi_details()
    {
        return $this->hasManyThrough(
            TransaksiDetail::class,
            Transaksi::class,
            'produk_id',
            'transaksi_id'
        );
    }

    // Promo Relationships
    public function promos()
    {
        return $this->belongsToMany(Promo::class, 'promo_products', 'produk_id', 'promo_id')
                    ->withPivot(['discount_type', 'discount_value', 'enabled'])
                    ->wherePivot('enabled', true);
    }

    // Scopes for Promo filtering
    public function scopeWithPromo($query)
    {
        return $query->where('has_active_promo', true);
    }

    public function scopeHasActivePromo($query)
    {
        return $query->where('has_active_promo', true)
                    ->where('status', 'publish');
    }

    // Promo Methods
    public function getActivePromos()
    {
        return Promo::active()
                   ->valid()
                   ->notExpired()
                   ->applicableToProduct($this)
                   ->get();
    }

    public function getBestPromo()
    {
        $activePromos = $this->getActivePromos();

        if ($activePromos->isEmpty()) {
            return null;
        }

        return $activePromos->sortByDesc(function ($promo) {
            $weekdayDiscount = $promo->calculateDiscount($this->harga_weekday);
            $weekendDiscount = $promo->calculateDiscount($this->harga_weekend);
            $totalDiscount = $weekdayDiscount + $weekendDiscount;
            return $totalDiscount;
        })->first();
    }

    public function hasActivePromo()
    {
        return $this->has_active_promo &&
               $this->promo_calculated_at &&
               \Carbon\Carbon::parse($this->promo_calculated_at)->gt(now()->subHours(1));
    }

    public function getPromoPriceWeekday()
    {
        if (!$this->hasActivePromo()) {
            return $this->calculatePromoPriceWeekday();
        }
        return $this->promo_price_weekday;
    }

    public function getPromoPriceWeekend()
    {
        if (!$this->hasActivePromo()) {
            return $this->calculatePromoPriceWeekend();
        }
        return $this->promo_price_weekend;
    }

    public function getPromoDiscountPercentage()
    {
        if (!$this->hasActivePromo()) {
            return $this->calculatePromoDiscountPercentage();
        }
        return $this->promo_discount_percentage;
    }

    public function calculatePromoPriceWeekday()
    {
        $bestPromo = $this->getBestPromo();
        if (!$bestPromo) {
            return $this->harga_weekday;
        }

        $discountConfig = $bestPromo->getEffectiveDiscountForProduct($this);
        if ($discountConfig['type'] === 'percentage') {
            return $this->harga_weekday * (1 - $discountConfig['value'] / 100);
        } else {
            return max(0, $this->harga_weekday - $discountConfig['value']);
        }
    }

    public function calculatePromoPriceWeekend()
    {
        $bestPromo = $this->getBestPromo();
        if (!$bestPromo) {
            return $this->harga_weekend;
        }

        $discountConfig = $bestPromo->getEffectiveDiscountForProduct($this);
        if ($discountConfig['type'] === 'percentage') {
            return $this->harga_weekend * (1 - $discountConfig['value'] / 100);
        } else {
            return max(0, $this->harga_weekend - $discountConfig['value']);
        }
    }

    public function calculatePromoDiscountPercentage()
    {
        $bestPromo = $this->getBestPromo();
        if (!$bestPromo) {
            return 0;
        }

        $discountConfig = $bestPromo->getEffectiveDiscountForProduct($this);
        if ($discountConfig['type'] === 'percentage') {
            return $discountConfig['value'];
        } else {
            // Calculate average percentage from fixed amount
            $avgPrice = ($this->harga_weekday + $this->harga_weekend) / 2;
            return $avgPrice > 0 ? round(($discountConfig['value'] / $avgPrice) * 100, 2) : 0;
        }
    }

    public function updatePromoCache()
    {
        $bestPromo = $this->getBestPromo();

        if ($bestPromo) {
            $this->update([
                'has_active_promo' => true,
                'promo_price_weekday' => $this->calculatePromoPriceWeekday(),
                'promo_price_weekend' => $this->calculatePromoPriceWeekend(),
                'promo_discount_percentage' => $this->calculatePromoDiscountPercentage(),
                'promo_calculated_at' => now()
            ]);
        } else {
            $this->update([
                'has_active_promo' => false,
                'promo_price_weekday' => null,
                'promo_price_weekend' => null,
                'promo_discount_percentage' => null,
                'promo_calculated_at' => null
            ]);
        }
    }

    // Helper method to check if product has any active promo (legacy support)
    public function isPromo()
    {
        // Check cache first (fast)
        if ($this->hasActivePromo()) {
            return true;
        }

        // If cache not available or expired, check directly
        $bestPromo = $this->getBestPromo();
        if ($bestPromo) {
            return true;
        }

        // Fallback to label check (legacy support)
        return $this->label && str_contains(strtolower($this->label), 'promo');
    }

    // Availability Methods - Konsisten untuk semua controller
    public function getBookedDates()
    {
        return TransaksiDetail::where('produk_id', $this->id)
            ->where('status', '!=', 'REJECTED') // Berdasarkan dokumentasi: exclude cancelled bookings
            ->select('date', DB::raw('SUM(unit) as total'))
            ->groupBy('date')
            ->pluck('total', 'date');
    }

    public function isFullyBookedForRange($startDate, $endDate)
    {
        $bookingsPerDate = TransaksiDetail::where('produk_id', $this->id)
            ->where('status', '!=', 'REJECTED') // Berdasarkan dokumentasi: exclude cancelled bookings
            ->whereBetween('date', [$startDate, $endDate])
            ->select('date', DB::raw('SUM(unit) as daily_booked'))
            ->groupBy('date')
            ->get();

        $maxBookedInRange = $bookingsPerDate->max('daily_booked') ?? 0;
        $isFullyBooked = $maxBookedInRange >= $this->unit;

        // Debug logging
        Log::info("Produk {$this->id} ({$this->name}) availability check: unit={$this->unit}, max_booked={$maxBookedInRange}, range={$startDate} to {$endDate}, fully_booked=" . ($isFullyBooked ? 'YES' : 'NO'));

        return $isFullyBooked;
    }

    public function getAvailableUnitsForRange($startDate, $endDate)
    {
        $bookingsPerDate = TransaksiDetail::where('produk_id', $this->id)
            ->where('status', '!=', 'REJECTED') // Berdasarkan dokumentasi: exclude cancelled bookings
            ->whereBetween('date', [$startDate, $endDate])
            ->select('date', DB::raw('SUM(unit) as daily_booked'))
            ->groupBy('date')
            ->get();

        $maxBookedInRange = $bookingsPerDate->max('daily_booked') ?? 0;
        return max(0, $this->unit - $maxBookedInRange);
    }

    /**
     * Calculate total price for date range based on weekday/weekend pricing
     */
    public function calculateTotalPriceForRange($startDate, $endDate, $unit = 1)
    {
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);
        $totalPrice = 0;

        $currentDate = $start->copy();
        while ($currentDate->lt($end)) {
            // Check if it's weekend (Saturday = 6, Sunday = 0)
            $dayOfWeek = $currentDate->dayOfWeek;
            $isWeekend = ($dayOfWeek === 0 || $dayOfWeek === 6);

            if ($isWeekend) {
                $price = $this->isPromo() ? $this->getPromoPriceWeekend() : $this->harga_weekend;
            } else {
                $price = $this->isPromo() ? $this->getPromoPriceWeekday() : $this->harga_weekday;
            }

            $totalPrice += $price;
            $currentDate->addDay();
        }

        return $totalPrice * $unit;
    }

    /**
     * Get price breakdown for date range
     */
    public function getPriceBreakdownForRange($startDate, $endDate, $unit = 1)
    {
        $start = \Carbon\Carbon::parse($startDate);
        $end = \Carbon\Carbon::parse($endDate);
        $breakdown = [];

        $currentDate = $start->copy();
        while ($currentDate->lt($end)) {
            $dayOfWeek = $currentDate->dayOfWeek;
            $isWeekend = ($dayOfWeek === 0 || $dayOfWeek === 6);
            $dayName = $currentDate->locale('id')->dayName;

            if ($isWeekend) {
                $price = $this->isPromo() ? $this->getPromoPriceWeekend() : $this->harga_weekend;
                $priceType = 'weekend';
            } else {
                $price = $this->isPromo() ? $this->getPromoPriceWeekday() : $this->harga_weekday;
                $priceType = 'weekday';
            }

            $breakdown[] = [
                'date' => $currentDate->format('Y-m-d'),
                'day_name' => $dayName,
                'price_type' => $priceType,
                'price_per_unit' => $price,
                'total_for_day' => $price * $unit
            ];

            $currentDate->addDay();
        }

        return $breakdown;
    }
}
