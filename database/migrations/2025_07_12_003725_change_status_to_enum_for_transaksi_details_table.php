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
        // Update existing status values to match ENUM values
        \DB::table('transaksi_details')->where('status', 'Menunggu Konfiramsi')->update(['status' => 'PENDING']);
        // Add more updates here if there are other possible values
    
        Schema::table('transaksi_details', function (Blueprint $table) {
            $table->enum('status', ['PENDING', 'APPROVED', 'REJECTED'])->default('PENDING')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revert ENUM values back to original string values if needed
        \DB::table('transaksi_details')->where('status', 'PENDING')->update(['status' => 'Menunggu Konfiramsi']);
        // Add more revert updates here if there are other possible values

        Schema::table('transaksi_details', function (Blueprint $table) {
            $table->string('status')->default('Menunggu Konfiramsi')->change();
        });
    }
};
