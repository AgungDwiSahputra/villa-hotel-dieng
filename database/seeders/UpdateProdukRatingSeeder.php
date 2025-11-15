<?php

namespace Database\Seeders;

use App\Models\Produk\Produk;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UpdateProdukRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Seeder ini digunakan untuk mengisi rating default pada produk
     * dengan nilai random antara 3.5 - 5.0 untuk keperluan testing
     */
    public function run(): void
    {
        $this->command->info('Starting to update product ratings...');

        $produks = Produk::all();
        $count = 0;

        foreach ($produks as $produk) {
            // Generate random rating between 3.5 - 5.0 (35 - 50, divided by 10)
            $rating = rand(35, 50) / 10;

            $produk->rating = $rating;
            $produk->save();

            $count++;
            $this->command->info("Updated {$produk->name} with rating: {$rating}");
        }

        $this->command->info("Successfully updated {$count} products with ratings!");
    }
}
