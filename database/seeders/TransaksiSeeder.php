<?php

namespace Database\Seeders;

use App\Models\Produk\Produk;
use App\Models\Transaksi\Transaksi;
use App\Models\Transaksi\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TransaksiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first available product
        $produk = Produk::where('status', 'aktif')->first();

        if (!$produk) {
            $this->command->warn('No active products found. Skipping transaksi seeding.');
            return;
        }

        // Create sample transactions with different statuses
        $transactions = [
            [
                'produk_id' => $produk->id,
                'order_id' => 'TXN-' . uniqid(),
                'start_date' => Carbon::now()->addDays(1)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(3)->format('Y-m-d'),
                'night' => 2,
                'unit' => 1,
                'total' => 500000,
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'no_wa' => '081234567890',
                'status' => 'Pending',
            ],
            [
                'produk_id' => $produk->id,
                'order_id' => 'TXN-' . uniqid(),
                'start_date' => Carbon::now()->addDays(5)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(7)->format('Y-m-d'),
                'night' => 2,
                'unit' => 2,
                'total' => 1000000,
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'no_wa' => '081234567891',
                'status' => 'success',
            ],
            [
                'produk_id' => $produk->id,
                'order_id' => 'TXN-' . uniqid(),
                'start_date' => Carbon::now()->addDays(10)->format('Y-m-d'),
                'end_date' => Carbon::now()->addDays(12)->format('Y-m-d'),
                'night' => 2,
                'unit' => 1,
                'total' => 600000,
                'name' => 'Bob Johnson',
                'email' => 'bob@example.com',
                'no_wa' => '081234567892',
                'status' => 'failed',
            ],
        ];

        foreach ($transactions as $transactionData) {
            $transaksi = Transaksi::create($transactionData);

            // Create transaction details for each night
            $start = Carbon::parse($transaksi->start_date);
            $end = Carbon::parse($transaksi->end_date);

            for ($date = $start; $date->lt($end); $date->addDay()) {
                TransaksiDetail::create([
                    'transaksi_id' => $transaksi->id,
                    'produk_id' => $produk->id,
                    'date' => $date->format('Y-m-d'),
                    'unit' => $transaksi->unit,
                    'status' => $transaksi->status === 'success' ? 'APPROVED' :
                               ($transaksi->status === 'failed' ? 'REJECTED' : 'PENDING'),
                ]);
            }
        }

        $this->command->info('Transaksi seeder completed successfully!');
    }
}