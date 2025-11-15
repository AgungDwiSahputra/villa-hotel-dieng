<?php

namespace App\Console\Commands;

use App\Models\Produk\Produk;
use App\Models\Promo\Promo;
use Illuminate\Console\Command;

class UpdatePromoCache extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promo:update-cache {--promo= : Specific promo ID to update} {--all : Update all products}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update promo cache for products. Use --promo=ID to update specific promo, or --all to update all products.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $promoId = $this->option('promo');
        $all = $this->option('all');

        $this->info('Starting promo cache update...');

        if ($promoId) {
            // Update cache for specific promo
            $promo = Promo::find($promoId);
            
            if (!$promo) {
                $this->error("Promo with ID {$promoId} not found.");
                return 1;
            }

            $this->info("Updating cache for promo: {$promo->name} ({$promo->promo_code})");
            $this->updatePromoCache($promo);
            $this->info("Cache updated successfully for promo: {$promo->name}");
            
        } elseif ($all) {
            // Update cache for all products
            $this->info('Updating cache for all products...');
            $products = Produk::where('status', 'publish')->get();
            $bar = $this->output->createProgressBar($products->count());
            $bar->start();

            foreach ($products as $product) {
                $product->updatePromoCache();
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
            $this->info("Cache updated successfully for {$products->count()} products.");
            
        } else {
            // Update cache for all active promos
            $this->info('Updating cache for all active promos...');
            $promos = Promo::where('is_active', true)->get();
            $bar = $this->output->createProgressBar($promos->count());
            $bar->start();

            foreach ($promos as $promo) {
                $this->updatePromoCache($promo);
                $bar->advance();
            }

            $bar->finish();
            $this->newLine();
            $this->info("Cache updated successfully for {$promos->count()} promos.");
        }

        return 0;
    }

    /**
     * Update promo cache for affected products
     */
    private function updatePromoCache(Promo $promo)
    {
        $affectedProducts = $this->getAffectedProducts($promo);
        
        foreach ($affectedProducts as $product) {
            $product->updatePromoCache();
        }
    }

    /**
     * Get products affected by promo
     */
    private function getAffectedProducts(Promo $promo)
    {
        if ($promo->applicable_to === 'all') {
            return Produk::where('status', 'publish')->get();
        } elseif ($promo->applicable_to === 'category') {
            $categoryIds = $promo->categories()->pluck('category_id');
            return Produk::whereIn('category_id', $categoryIds)
                         ->where('status', 'publish')
                         ->get();
        } else { // product
            $productIds = $promo->products()->pluck('produk_id');
            return Produk::whereIn('id', $productIds)
                         ->where('status', 'publish')
                         ->get();
        }
    }
}
