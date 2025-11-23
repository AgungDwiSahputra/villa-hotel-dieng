<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add 'draft' status to the enum
        DB::statement("ALTER TABLE jeep_trip_bookings MODIFY COLUMN status ENUM('draft', 'pending', 'paid', 'cancelled', 'expired', 'done') DEFAULT 'draft'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Remove 'draft' status from the enum (back to original)
        DB::statement("ALTER TABLE jeep_trip_bookings MODIFY COLUMN status ENUM('pending', 'paid', 'cancelled', 'expired', 'done') DEFAULT 'pending'");
    }
};
