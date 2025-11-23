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
        Schema::create('jeep_trip_includes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('jeep_trip_id');
            $table->string('nama_item', 150);
            $table->timestamps();

            $table->foreign('jeep_trip_id')->references('id')->on('jeep_trips')->onDelete('cascade');
        });

        Schema::create('jeep_trip_excludes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('jeep_trip_id');
            $table->string('nama_item', 150);
            $table->timestamps();

            $table->foreign('jeep_trip_id')->references('id')->on('jeep_trips')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jeep_trip_excludes');
        Schema::dropIfExists('jeep_trip_includes');
    }
};
