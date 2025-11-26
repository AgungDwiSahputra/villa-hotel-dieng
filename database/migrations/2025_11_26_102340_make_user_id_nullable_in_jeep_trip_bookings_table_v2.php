<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Use raw SQL to modify the column to be nullable
        DB::statement('ALTER TABLE jeep_trip_bookings MODIFY user_id CHAR(36) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Make user_id not nullable again
        DB::statement('ALTER TABLE jeep_trip_bookings MODIFY user_id CHAR(36) NOT NULL');
    }
};
