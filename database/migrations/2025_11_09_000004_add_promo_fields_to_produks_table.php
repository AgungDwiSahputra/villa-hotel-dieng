<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            // Add computed promo cache fields for performance
            $table->boolean('has_active_promo')->default(false)->index();
            $table->decimal('promo_price_weekday', 10, 2)->nullable();
            $table->decimal('promo_price_weekend', 10, 2)->nullable();
            $table->decimal('promo_discount_percentage', 5, 2)->nullable();
            $table->timestamp('promo_calculated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produks', function (Blueprint $table) {
            $table->dropColumn([
                'has_active_promo',
                'promo_price_weekday',
                'promo_price_weekend',
                'promo_discount_percentage',
                'promo_calculated_at'
            ]);
        });
    }
};