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
        $datas = [
            [
                'id' => (string) Str::uuid(),
                'name' => 'Villa',
                'slug' => 'villa',
                'urutan' => 1,
            ],
            [
                'id' => (string) Str::uuid(),
                'name' => 'Hotel',
                'slug' => 'hotel',
                'urutan' => 2,
            ],
        ];

        ProdukCategory::insert($datas);
    }
}
