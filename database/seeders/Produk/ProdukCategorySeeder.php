<?php

namespace Database\Seeders\Produk;

use App\Models\Produk\ProdukCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProdukCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Villa',
                'slug' => 'villa',
                'urutan' => 1,
            ],
            [
                'name' => 'Hotel',
                'slug' => 'hotel',
                'urutan' => 2,
            ],
        ];

        foreach ($categories as $category) {
            ProdukCategory::updateOrCreate(
                ['slug' => $category['slug']], // unique identifier
                $category
            );
        }
    }
}
