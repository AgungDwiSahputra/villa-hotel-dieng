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
        Schema::create('promo_categories', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('promo_id')->constrained('promos')->onDelete('cascade');
            $table->foreignUuid('category_id')->constrained('produk_categories')->onDelete('cascade');
            $table->enum('discount_type', ['percentage', 'fixed'])->nullable(); // override if needed
            $table->decimal('discount_value', 10, 2)->nullable(); // override if needed
            $table->boolean('enabled')->default(true);
            $table->timestamps();

            $table->unique(['promo_id', 'category_id']);
            $table->index('enabled');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promo_categories');
    }
};