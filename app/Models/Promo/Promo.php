<?php

namespace App\Models\Promo;

use App\Models\Produk\Produk;
use App\Models\Produk\ProdukCategory;
use App\Models\User;
use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Promo extends Model
{
    use Loggable, SoftDeletes;

    protected $fillable = [
        'name', 'description', 'discount_type', 'discount_value',
        'start_date', 'end_date', 'is_active', 'usage_limit', 'usage_count',
        'applicable_to', 'promo_code', 'metadata', 'created_by', 'updated_by'
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
        'metadata' => 'array'
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = (string) Str::uuid();
            }
            if (empty($model->promo_code)) {
                $model->promo_code = self::generatePromoCode();
            }
        });
    }

    // Relationships
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function categories()
    {
        return $this->hasMany(PromoCategory::class);
    }

    public function products()
    {
        return $this->hasMany(PromoProduct::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeValid($query)
    {
        $now = Carbon::now();
        return $query->where(function ($q) use ($now) {
            $q->whereNull('start_date')
              ->orWhere('start_date', '<=', $now);
        })->where(function ($q) use ($now) {
            $q->whereNull('end_date')
              ->orWhere('end_date', '>=', $now);
        });
    }

    public function scopeNotExpired($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('usage_limit')
              ->orWhereColumn('usage_count', '<', 'usage_limit');
        });
    }

    public function scopeApplicableToProduct($query, Produk $product)
    {
        return $query->where(function ($q) use ($product) {
            $q->where('applicable_to', 'all')
              ->orWhere(function ($subQ) use ($product) {
                  $subQ->where('applicable_to', 'category')
                       ->whereHas('categories', function ($categoryQ) use ($product) {
                           $categoryQ->where('category_id', $product->category_id)
                                    ->where('enabled', true);
                       });
              })
              ->orWhere(function ($subQ) use ($product) {
                  $subQ->where('applicable_to', 'product')
                       ->whereHas('products', function ($productQ) use ($product) {
                           $productQ->where('produk_id', $product->id)
                                   ->where('enabled', true);
                       });
              });
        });
    }

    // Helper Methods
    public static function generatePromoCode()
    {
        do {
            $code = 'PROMO-' . strtoupper(Str::random(6));
        } while (self::where('promo_code', $code)->exists());

        return $code;
    }

    public function isValid()
    {
        if (!$this->is_active) return false;

        $now = Carbon::now();

        if ($this->start_date && $now->lt($this->start_date)) return false;
        if ($this->end_date && $now->gt($this->end_date)) return false;
        if ($this->usage_limit && $this->usage_count >= $this->usage_limit) return false;

        return true;
    }

    public function isApplicableToProduct(Produk $product)
    {
        return $this->applicableToProduct($product)->exists();
    }

    public function calculateDiscount($originalPrice)
    {
        if ($this->discount_type === 'percentage') {
            return $originalPrice * ($this->discount_value / 100);
        } else {
            return min($this->discount_value, $originalPrice);
        }
    }

    public function applyDiscount($originalPrice)
    {
        $discount = $this->calculateDiscount($originalPrice);
        return max(0, $originalPrice - $discount);
    }

    public function getDiscountPercentage($originalPrice)
    {
        if ($this->discount_type === 'percentage') {
            return $this->discount_value;
        } else {
            return $originalPrice > 0 ? round(($this->discount_value / $originalPrice) * 100, 2) : 0;
        }
    }

    public function incrementUsage()
    {
        $this->increment('usage_count');
    }

    // For specific product/category overrides
    public function getEffectiveDiscountForProduct(Produk $product)
    {
        // Check for product-specific override
        $productPromo = $this->products()
                           ->where('produk_id', $product->id)
                           ->where('enabled', true)
                           ->first();

        if ($productPromo && $productPromo->discount_type && $productPromo->discount_value) {
            return [
                'type' => $productPromo->discount_type,
                'value' => $productPromo->discount_value
            ];
        }

        // Check for category-specific override
        $categoryPromo = $this->categories()
                            ->where('category_id', $product->category_id)
                            ->where('enabled', true)
                            ->first();

        if ($categoryPromo && $categoryPromo->discount_type && $categoryPromo->discount_value) {
            return [
                'type' => $categoryPromo->discount_type,
                'value' => $categoryPromo->discount_value
            ];
        }

        // Return default promo settings
        return [
            'type' => $this->discount_type,
            'value' => $this->discount_value
        ];
    }
}