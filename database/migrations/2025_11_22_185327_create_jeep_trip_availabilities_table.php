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
        Schema::create('jeep_trip_availabilities', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('jeep_trip_slot_id');
            $table->date('tanggal');
            $table->unsignedInteger('quota_jeep');
            $table->unsignedInteger('quota_terpakai')->default(0);
            $table->boolean('is_closed')->default(false);
            $table->timestamps();

            $table->unique(['jeep_trip_slot_id', 'tanggal'], 'uniq_slot_tanggal');
            $table->foreign('jeep_trip_slot_id')->references('id')->on('jeep_trip_slots')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jeep_trip_availabilities');
    }
};
