<?php

namespace Database\Seeders\Promo;

use App\Models\Promo\Promo;
use App\Models\Promo\PromoCategory;
use App\Models\Promo\PromoProduct;
use App\Models\Produk\Produk;
use App\Models\Produk\ProdukCategory;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class PromoSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample promos
        $promos = [
            [
                'name' => 'Liburan Akhir Tahun',
                'description' => 'Diskon spesial untuk liburan akhir tahun dengan minimum 2 malam menginap',
                'discount_type' => 'percentage',
                'discount_value' => 25,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(30),
                'is_active' => true,
                'applicable_to' => 'category',
            ],
            [
                'name' => 'Early Bird Special',
                'description' => 'Booking 14 hari sebelum check-in dapatkan harga spesial',
                'discount_type' => 'percentage',
                'discount_value' => 15,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(60),
                'is_active' => true,
                'applicable_to' => 'all',
            ],
            [
                'name' => 'Weekend Getaway',
                'description' => 'Promo khusus weekend untuk selected villas',
                'discount_type' => 'fixed',
                'discount_value' => 100000,
                'start_date' => Carbon::now(),
                'end_date' => Carbon::now()->addDays(45),
                'is_active' => true,
                'applicable_to' => 'product',
            ],
        ];

        foreach ($promos as $promoData) {
            $promo = Promo::create($promoData);

            // Assign categories for category-based promo
            if ($promo->applicable_to === 'category') {
                $categories = ProdukCategory::take(2)->get();
                foreach ($categories as $category) {
                    PromoCategory::create([
                        'promo_id' => $promo->id,
                        'category_id' => $category->id,
                    ]);
                }
            }

            // Assign products for product-based promo
            if ($promo->applicable_to === 'product') {
                $products = Produk::where('status', 'publish')->take(3)->get();
                foreach ($products as $product) {
                    PromoProduct::create([
                        'promo_id' => $promo->id,
                        'produk_id' => $product->id,
                    ]);
                }
            }

            // Update promo cache for affected products
            if ($promo->applicable_to === 'all') {
                Produk::where('status', 'publish')->get()->each->updatePromoCache();
            } elseif ($promo->applicable_to === 'category') {
                $promo->categories->each(function ($promoCategory) {
                    $promoCategory->category->produks()->where('status', 'publish')->get()->each->updatePromoCache();
                });
            } else {
                $promo->products->each(function ($promoProduct) {
                    $promoProduct->produk->updatePromoCache();
                });
            }
        }

        $this->command->info('Sample promos created successfully!');
    }
}