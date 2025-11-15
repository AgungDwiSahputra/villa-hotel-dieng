<?php

namespace Database\Seeders\Produk;

use App\Models\Produk\Produk;
use App\Models\Produk\ProdukCategory;
use App\Models\Produk\ProdukFasilitas;
use App\Models\Produk\ProdukImage;
use App\Models\Produk\ProdukSyarat;
use App\Models\Produk\ProdukWisata;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Get all categories
        $categories = ProdukCategory::all();

        // Define location variations in Dieng area
        $locations = [
            'Desa Dieng Kulon',
            'Dieng Karangsari',
            'Dieng Wonosobo',
            'Dieng Plateau',
            'Desa Dieng Wetan',
            'Dieng Banjarnegara',
            'Dieng Kejajar',
            'Dieng Patak Banteng',
            'Dieng Sikunir',
            'Dieng Telaga Warna',
            'Dieng Batu Ratapan Angin',
            'Dieng Kawah Sikidang',
            'Dieng Candi Arjuna',
            'Dieng Sikidang Crater',
            'Dieng Color Lake'
        ];

        // Define facility variations
        $facilityTemplates = [
            ['Kamar mandi dalam', 'Water heater', 'Dapur lengkap', 'Alat masak', 'TV Android', 'Free WiFi', 'Parkir mobil', 'Balkon pribadi', 'Teh, gula, kopi'],
            ['Kamar mandi dalam', 'Water heater', 'Dapur minimalis', 'Alat masak', 'TV LED', 'Free WiFi', 'Parkir motor', 'Teras outdoor', 'Sarapan pagi'],
            ['Kamar mandi dalam & luar', 'Water heater', 'Dapur modern', 'Alat masak lengkap', 'TV Smart', 'Free WiFi premium', 'Parkir luas', 'Balkon view gunung', 'Minuman selamat datang'],
            ['Kamar mandi dalam', 'Water heater elektrik', 'Dapur sederhana', 'Alat masak', 'TV kabel', 'Free WiFi', 'Parkir aman', 'Taman kecil', 'Teh herbal'],
            ['Kamar mandi dalam', 'Water heater gas', 'Dapur kompor', 'Alat masak', 'TV satelit', 'Free WiFi', 'Parkir basement', 'Ruang tamu', 'Kopi instant'],
            ['Kamar mandi dalam', 'Water heater solar', 'Dapur lengkap', 'Alat masak modern', 'TV LCD', 'Free WiFi unlimited', 'Parkir carport', 'Balkon sunrise', 'Sarapan tradisional'],
            ['Kamar mandi dalam', 'Water heater listrik', 'Dapur minimal', 'Alat masak', 'TV digital', 'Free WiFi', 'Parkir area', 'Teras pribadi', 'Teh hijau'],
            ['Kamar mandi dalam & jacuzzi', 'Water heater premium', 'Dapur gourmet', 'Alat masak profesional', 'Home theater', 'Free WiFi 5G', 'Parkir VIP', 'Balkon infinity', 'Champagne welcome drink'],
            ['Kamar mandi dalam', 'Water heater', 'Dapur praktis', 'Alat masak', 'TV HD', 'Free WiFi', 'Parkir motor', 'Halaman belakang', 'Jus buah segar'],
            ['Kamar mandi dalam', 'Water heater hemat energi', 'Dapur modern', 'Alat masak elektrik', 'Smart TV', 'Free WiFi mesh', 'Parkir otomatis', 'Roof garden', 'Smoothie bowl']
        ];

        // Define wisata variations with distances
        $wisataTemplates = [
            ['Candi Arjuna 5 menit', 'Kawah Sikidang 7 menit', 'Sekunir 15 menit', 'Telaga Warna 6 menit', 'Batu Ratapan Angin 6 menit'],
            ['Candi Arjuna 3 menit', 'Kawah Sikidang 10 menit', 'Telaga Warna 8 menit', 'Batu Ratapan Angin 4 menit', 'Dieng Plateau 2 menit'],
            ['Candi Arjuna 8 menit', 'Kawah Sikidang 5 menit', 'Sekunir 12 menit', 'Telaga Warna 10 menit', 'Batu Ratapan Angin 8 menit'],
            ['Candi Arjuna 6 menit', 'Kawah Sikidang 9 menit', 'Telaga Warna 4 menit', 'Batu Ratapan Angin 7 menit', 'Dieng Culture 3 menit'],
            ['Candi Arjuna 4 menit', 'Kawah Sikidang 6 menit', 'Sekunir 18 menit', 'Telaga Warna 9 menit', 'Batu Ratapan Angin 5 menit'],
            ['Candi Arjuna 7 menit', 'Kawah Sikidang 8 menit', 'Telaga Warna 5 menit', 'Batu Ratapan Angin 6 menit', 'Dieng Tourism 4 menit'],
            ['Candi Arjuna 9 menit', 'Kawah Sikidang 4 menit', 'Sekunir 14 menit', 'Telaga Warna 11 menit', 'Batu Ratapan Angin 9 menit'],
            ['Candi Arjuna 2 menit', 'Kawah Sikidang 11 menit', 'Telaga Warna 7 menit', 'Batu Ratapan Angin 3 menit', 'Dieng Heritage 1 menit'],
            ['Candi Arjuna 10 menit', 'Kawah Sikidang 3 menit', 'Sekunir 16 menit', 'Telaga Warna 12 menit', 'Batu Ratapan Angin 10 menit'],
            ['Candi Arjuna 5 menit', 'Kawah Sikidang 8 menit', 'Telaga Warna 6 menit', 'Batu Ratapan Angin 5 menit', 'Dieng Nature 3 menit']
        ];

        // Define syarat variations
        $syaratTemplates = [
            ['Dilarang membawa minuman keras', 'Dilarang membawa hewan peliharaan', 'Check-in pukul 14:00, check-out pukul 12:00'],
            ['Dilarang membawa minuman keras', 'Dilarang membawa hewan peliharaan', 'Wajib menjaga kebersihan'],
            ['Dilarang membawa minuman keras', 'Dilarang membawa hewan peliharaan', 'Tidak boleh merokok di dalam ruangan'],
            ['Dilarang membawa minuman keras', 'Dilarang membawa hewan peliharaan', 'Harap menjaga ketenangan'],
            ['Dilarang membawa minuman keras', 'Dilarang membawa hewan peliharaan', 'Dilarang membuat kegaduhan'],
            ['Dilarang membawa minuman keras', 'Dilarang membawa hewan peliharaan', 'Wajib mematuhi jam malam'],
            ['Dilarang membawa minuman keras', 'Dilarang membawa hewan peliharaan', 'Harap menghormati tetangga'],
            ['Dilarang membawa minuman keras', 'Dilarang membawa hewan peliharaan', 'Dilarang membawa tamu tambahan'],
            ['Dilarang membawa minuman keras', 'Dilarang membawa hewan peliharaan', 'Wajib menggunakan sandal di dalam rumah'],
            ['Dilarang membawa minuman keras', 'Dilarang membawa hewan peliharaan', 'Harap menjaga keamanan bersama']
        ];

        // Generate 80 diverse products
        for ($i = 0; $i < 80; $i++) {
            $category = $categories->random();
            $isPremium = $faker->boolean(20); // 20% chance of being premium
            $isPopular = $faker->boolean(30); // 30% chance of being high-priced (popular)

            // Generate name based on category
            $namePrefixes = [
                'Villa' => ['Villa', 'Rumah', 'Omah', 'Bungalow', 'Cottage', 'Lodge', 'Residence', 'Mansion', 'Palace', 'Haven'],
                'Hotel' => ['Hotel', 'Inn', 'Lodge', 'Resort', 'Suites', 'Plaza', 'Grand', 'Royal', 'Elite', 'Premier'],
                'Homestay' => ['Homestay', 'Guest House', 'Family Home', 'Traditional House', 'Cozy Home', 'Warm Stay', 'Home Away', 'Family Lodge', 'Comfort Home', 'Welcoming Home'],
                'Glamping' => ['Glamping', 'Luxury Tent', 'Safari Tent', 'Dome', 'Bubble', 'Treehouse', 'Yurt', 'Eco Lodge', 'Nature Dome', 'Starlight Tent'],
                'Resort' => ['Resort', 'Spa Resort', 'Mountain Resort', 'Boutique Resort', 'Luxury Resort', 'Wellness Resort', 'Hill Resort', 'Valley Resort', 'Peak Resort', 'Summit Resort']
            ];

            $prefix = $faker->randomElement($namePrefixes[$category->name] ?? ['Property']);
            $suffix = $faker->randomElement(['Dieng', 'Mountain', 'View', 'Sunrise', 'Sunset', 'Paradise', 'Retreat', 'Haven', 'Oasis', 'Bliss', 'Serenity', 'Tranquil', 'Peaceful', 'Majestic', 'Grand']);
            $number = $faker->numberBetween(1, 99);
            $name = $prefix . ' ' . $suffix . ' ' . $number;

            // Generate pricing based on category and premium status
            $basePriceWeekday = [
                'Villa' => $faker->numberBetween(800000, 2500000),
                'Hotel' => $faker->numberBetween(500000, 1800000),
                'Homestay' => $faker->numberBetween(300000, 800000),
                'Glamping' => $faker->numberBetween(600000, 1500000),
                'Resort' => $faker->numberBetween(1200000, 3500000)
            ][$category->name];

            if ($isPremium) $basePriceWeekday *= 1.5;
            if ($isPopular) $basePriceWeekday *= 1.8;

            $hargaWeekday = round($basePriceWeekday / 100000) * 100000; // Round to nearest 100k
            $hargaWeekend = $hargaWeekday * 1.2; // 20% more for weekends

            // Generate capacity
            $kamar = $faker->numberBetween(1, 5);
            $orang = $kamar * $faker->numberBetween(2, 4);
            $maksOrang = $orang + $faker->numberBetween(0, 2);
            $unit = $faker->numberBetween(1, 3);

            // Generate rating (higher for premium/popular)
            $baseRating = $faker->randomFloat(1, 3.5, 5.0);
            if ($isPremium) $baseRating = min(5.0, $baseRating + 0.5);
            if ($isPopular) $baseRating = min(5.0, $baseRating + 0.3);
            $rating = round($baseRating * 2) / 2; // Round to nearest 0.5

            $productData = [
                'category_id' => $category->id,
                'owner' => $faker->name(),
                'name' => $name,
                'slug' => Str::slug($name),
                'unit' => $unit,
                'kamar' => $kamar,
                'orang' => $orang,
                'maks_orang' => $maksOrang,
                'lokasi' => $faker->randomElement($locations),
                'harga_weekday' => $hargaWeekday,
                'harga_weekend' => $hargaWeekend,
                'label' => $isPremium ? 'Premium' : ($faker->boolean(30) ? 'Favorit' : null),
                'rating' => $rating,
                'status' => 'publish',
                'urutan' => $i + 1
            ];

            $product = Produk::updateOrCreate(
                ['slug' => $productData['slug']],
                $productData
            );

            // Add facilities
            $selectedFacilities = $faker->randomElement($facilityTemplates);
            ProdukFasilitas::where('produk_id', $product->id)->delete();
            foreach ($selectedFacilities as $facility) {
                ProdukFasilitas::create([
                    'id' => (string) Str::uuid(),
                    'produk_id' => $product->id,
                    'name' => $facility,
                ]);
            }

            // Add wisata
            $selectedWisata = $faker->randomElement($wisataTemplates);
            ProdukWisata::where('produk_id', $product->id)->delete();
            foreach ($selectedWisata as $wisata) {
                ProdukWisata::create([
                    'id' => (string) Str::uuid(),
                    'produk_id' => $product->id,
                    'name' => $wisata,
                ]);
            }

            // Add syarat
            $selectedSyarat = $faker->randomElement($syaratTemplates);
            ProdukSyarat::where('produk_id', $product->id)->delete();
            foreach ($selectedSyarat as $syarat) {
                ProdukSyarat::create([
                    'id' => (string) Str::uuid(),
                    'produk_id' => $product->id,
                    'name' => $syarat,
                ]);
            }

            // Add sample images (placeholder URLs)
            ProdukImage::where('produk_id', $product->id)->delete();
            $imageCount = $faker->numberBetween(3, 8);
            for ($j = 1; $j <= $imageCount; $j++) {
                ProdukImage::create([
                    'id' => (string) Str::uuid(),
                    'produk_id' => $product->id,
                    'name' => "Image {$j} for {$name}",
                    'image' => "https://picsum.photos/800/600?random=" . ($i * 10 + $j),
                    'urutan' => $j
                ]);
            }
        }
    }
}
