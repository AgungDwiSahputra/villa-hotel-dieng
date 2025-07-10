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
        Schema::create('produks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('category_id');
            $table->string('name')->unique();
            $table->string('slug')->unique();
            $table->integer('unit');
            $table->integer('kamar');
            $table->integer('orang');
            $table->integer('maks_orang');
            $table->string('lokasi');
            $table->integer('harga_weekday');
            $table->integer('harga_weekend');
            $table->string('label')->nullable();
            $table->integer('urutan')->default(0);
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('produk_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
