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
        Schema::create('jeep_trip_destinations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('jeep_trip_id');
            $table->string('nama_destinasi', 150);
            $table->unsignedInteger('urutan')->default(1);
            $table->timestamps();

            $table->foreign('jeep_trip_id')->references('id')->on('jeep_trips')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jeep_trip_destinations');
    }
};
