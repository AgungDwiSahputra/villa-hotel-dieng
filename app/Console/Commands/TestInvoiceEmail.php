<?php

namespace App\Console\Commands;

use App\Mail\InvoiceNotification;
use App\Models\Produk\Produk;
use App\Models\Transaksi\Transaksi;
use App\Services\ProductUserService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestInvoiceEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-invoice-email {email?} {--admin : Send admin copy}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test pengiriman email invoice';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email') ?? 'test@example.com';
        $isAdminCopy = $this->option('admin');

        $this->info('Testing invoice email...');

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
            'order_id' => 'INV-' . uniqid(),
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
            Mail::to($email)->send(new InvoiceNotification($dummyTransaksi, $isAdminCopy));

            $type = $isAdminCopy ? 'admin' : 'customer';
            $this->info("✅ Invoice email ({$type}) berhasil dikirim ke: {$email}");
            $this->info("📧 Cek inbox Mailtrap untuk melihat email invoice test");

            // Also test getting admin emails if not admin copy
            if (!$isAdminCopy) {
                $productUserService = new ProductUserService();
                $adminEmails = $productUserService->getProductAdminEmails($produk->id);

                if (!empty($adminEmails)) {
                    $this->info("📋 Admin emails untuk produk ini: " . implode(', ', $adminEmails));
                    $this->info("💡 Untuk test email admin, gunakan: php artisan app:test-invoice-email admin@example.com --admin");
                } else {
                    $this->warn("⚠️  Tidak ada admin emails ditemukan untuk produk ini");
                }
            }

        } catch (\Exception $e) {
            $this->error("❌ Gagal mengirim email invoice: " . $e->getMessage());
        }
    }
}
