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
        Schema::create('jeep_trips', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('kode', 50)->nullable()->unique();
            $table->string('slug', 150)->unique();
            $table->string('nama_paket', 150);
            $table->text('deskripsi_singkat')->nullable();
            $table->longText('deskripsi_lengkap')->nullable();
            $table->string('zona', 50)->nullable();
            $table->unsignedInteger('durasi_jam')->nullable();
            $table->time('jam_berangkat_default')->nullable();
            $table->unsignedInteger('kapasitas_ideal_per_jeep')->default(4);
            $table->unsignedInteger('kapasitas_max_per_jeep')->default(4);
            $table->decimal('harga_weekday', 15, 2);
            $table->decimal('harga_weekend', 15, 2);
            $table->decimal('rating', 3, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jeep_trips');
    }
};
