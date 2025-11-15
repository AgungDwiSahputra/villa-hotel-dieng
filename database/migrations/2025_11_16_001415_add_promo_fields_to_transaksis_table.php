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
        Schema::table('transaksis', function (Blueprint $table) {
            $table->uuid('promo_id')->nullable()->after('produk_id');
            $table->string('promo_code')->nullable()->after('promo_id');
            $table->decimal('discount_amount', 10, 2)->default(0)->after('total');
            $table->decimal('original_total', 10, 2)->nullable()->after('discount_amount');
            
            $table->foreign('promo_id')->references('id')->on('promos')->nullOnDelete();
            $table->index('promo_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksis', function (Blueprint $table) {
            $table->dropForeign(['promo_id']);
            $table->dropIndex(['promo_code']);
            $table->dropColumn(['promo_id', 'promo_code', 'discount_amount', 'original_total']);
        });
    }
};
