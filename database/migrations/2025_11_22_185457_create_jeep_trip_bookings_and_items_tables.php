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
        Schema::create('jeep_trip_bookings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id');
            $table->string('kode_booking', 50)->unique();
            $table->decimal('total_harga', 15, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled', 'expired', 'done'])->default('pending');
            $table->string('payment_ref', 100)->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('jeep_trip_booking_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('jeep_trip_booking_id');
            $table->uuid('jeep_trip_id');
            $table->uuid('jeep_trip_slot_id');
            $table->date('tanggal_trip');
            $table->unsignedInteger('jumlah_jeep');
            $table->decimal('harga_satuan', 15, 2);
            $table->decimal('subtotal', 15, 2);
            $table->timestamps();

            $table->foreign('jeep_trip_booking_id')->references('id')->on('jeep_trip_bookings')->onDelete('cascade');
            $table->foreign('jeep_trip_id')->references('id')->on('jeep_trips');
            $table->foreign('jeep_trip_slot_id')->references('id')->on('jeep_trip_slots');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jeep_trip_booking_items');
        Schema::dropIfExists('jeep_trip_bookings');
    }
};
