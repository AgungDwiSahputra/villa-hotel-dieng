<?php

namespace App\Console\Commands;

use App\Mail\PaymentSuccess;
use App\Models\Produk\Produk;
use App\Models\Transaksi\Transaksi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestPaymentEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-payment-email {email?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test pengiriman email konfirmasi pembayaran berhasil';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'test@example.com';

        $this->info('Testing payment success email...');

        // Get first produk for testing
        $produk = Produk::first();
        if (!$produk) {
            $this->error('Tidak ada produk ditemukan. Pastikan database sudah di-seed.');
            return;
        }

        // Create dummy transaction data
        $dummyTransaksi = new Transaksi([
            'id' => 999,
            'produk_id' => $produk->id,
            'order_id' => 'TEST-' . uniqid(),
            'start_date' => now()->addDays(1)->format('Y-m-d'),
            'end_date' => now()->addDays(3)->format('Y-m-d'),
            'night' => 2,
            'unit' => 1,
            'total' => 500000,
            'original_total' => 500000,
            'discount_amount' => 0,
            'promo_id' => null,
            'promo_code' => null,
            'name' => 'Test User',
            'email' => $email,
            'no_wa' => '081234567890',
            'status' => 'success',
        ]);

        // Attach produk relationship
        $dummyTransaksi->produk = $produk;

        try {
            Mail::to($email)->send(new PaymentSuccess($dummyTransaksi));
            $this->info("✅ Email berhasil dikirim ke: {$email}");
            $this->info("📧 Cek inbox Mailtrap untuk melihat email test");
        } catch (\Exception $e) {
            $this->error("❌ Gagal mengirim email: " . $e->getMessage());
        }
    }
}
