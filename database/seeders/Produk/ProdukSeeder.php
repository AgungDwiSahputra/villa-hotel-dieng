<?php

namespace Database\Seeders\Produk;

use App\Models\Produk\Produk;
use App\Models\Produk\ProdukCategory;
use App\Models\Produk\ProdukFasilitas;
use App\Models\Produk\ProdukSyarat;
use App\Models\Produk\ProdukWisata;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $hotel = ProdukCategory::where('name','Hotel')->first();
        $villa = ProdukCategory::where('name','Villa')->first();
        
        $products = [
            [
                'category_id' => $hotel->id,
                'name' => 'Calla cabin 1',
                'slug' => Str::slug('Calla cabin 1'),
                'unit' => 4,
                'kamar' => 2,
                'orang' => 6,
                'maks_orang' => 7,
                'lokasi' => 'Desa dieng kulon karangsari',
                'harga_weekday' => 1100000,
                'harga_weekend' => 1200000,
                'label' => 'Favorit'
            ],
            [
                'category_id' => $hotel->id,
                'name' => 'Calla glamping',
                'slug' => Str::slug('Calla glamping'),
                'unit' => 4,
                'kamar' => 2,
                'orang' => 4,
                'maks_orang' => 6,
                'lokasi' => 'Dieng karangsari',
                'harga_weekday' => 850000,
                'harga_weekend' => 950000,
                'label' => 'Favorit'
            ],
            [
                'category_id' => $villa->id,
                'name' => 'Asoka villa',
                'slug' => Str::slug('Asoka villa'),
                'unit' => 1,
                'kamar' => 2,
                'orang' => 18,
                'maks_orang' => 19,
                'lokasi' => 'Dieng kulon',
                'harga_weekday' => 3500000,
                'harga_weekend' => 3600000,
                'label' => 'Favorit'
            ],
            [
                'category_id' => $villa->id,
                'name' => 'Omah dieng 2 view candi arjuna',
                'slug' => Str::slug('Omah dieng 2 view candi arjuna'),
                'unit' => 1,
                'kamar' => 2,
                'orang' => 9,
                'maks_orang' => 9,
                'lokasi' => 'Desa dieng kulon',
                'harga_weekday' => 2100000,
                'harga_weekend' => 2200000,
                'label' => 'Favorit'
            ]
        ];
        
        foreach ($products as $productData) {
            $product = Produk::updateOrCreate(
                ['slug' => $productData['slug']], // unique identifier
                $productData
            );

            $dataFasilitas = [
                'Kamar mandi dalam',
                'Waterheater',
                'Dapur',
                'Alat masak',
                'Tv android',
                'Free wifi',
                'Parkir',
                'Balkon',
                'Teh gula kopi',
            ];

            // Hapus fasilitas lama dan insert baru (untuk update data)
            ProdukFasilitas::where('produk_id', $product->id)->delete();
            foreach ($dataFasilitas as $name) {
                ProdukFasilitas::create([
                    'id' => (string) Str::uuid(),
                    'produk_id' => $product->id,
                    'name' => $name,
                ]);
            }
            
            $dataWisatas = [
                'Candi arjuan 5 menit',
                'Kawah sikidang 7 meni',
                'Sekunir 15 menit',
                'Telaga warna 6 menit',
                'Batu ratapan angin 6 menit',
            ];

            // Hapus wisata lama dan insert baru (untuk update data)
            ProdukWisata::where('produk_id', $product->id)->delete();
            foreach ($dataWisatas as $name) {
                ProdukWisata::create([
                    'id' => (string) Str::uuid(),
                    'produk_id' => $product->id,
                    'name' => $name,
                ]);
            }
      
            $dataSyarat = [
                'Dilarang membawa minuman keras',
                'Dilarang membawa hewan peliharaan',
            ];

            // Hapus syarat lama dan insert baru (untuk update data)
            ProdukSyarat::where('produk_id', $product->id)->delete();
            foreach ($dataSyarat as $name) {
                ProdukSyarat::create([
                    'id' => (string) Str::uuid(),
                    'produk_id' => $product->id,
                    'name' => $name,
                ]);
            }
        }
    }
}
