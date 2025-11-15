<?php

namespace App\Http\Controllers;

use App\Http\Requests\Landing\ProdukFinalRequest;
use App\Models\ActivityLog;
use App\Models\Availability;
use App\Models\Produk\Produk;
use App\Models\Produk\ProdukCategory;
use App\Models\Produk\ProdukWisata;
use App\Models\Rekening;
use App\Models\Transaksi\Transaksi;
use App\Models\Transaksi\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProdukCategory::orderBy('urutan')->get();
        $searchQuery = $request->get('search');
        $activeCategory = $request->get('category');
        $selectedCategory = null;

        $produksQuery = Produk::with('images', 'category')
            ->where('status', 'publish')
            ->orderBy('urutan');

        if ($activeCategory) {
            $selectedCategory = ProdukCategory::where('slug', $activeCategory)->firstOrFail();
            $produksQuery->where('category_id', $selectedCategory->id);
        } elseif ($categories->isNotEmpty()) {
            $selectedCategory = $categories->first();
            if (!$searchQuery) {
                $activeCategory = $selectedCategory->slug;
                $produksQuery->where('category_id', $selectedCategory->id);
            }
        }

        if ($searchQuery) {
            $produksQuery->where(function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('lokasi', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('label', 'LIKE', '%' . $searchQuery . '%');
            });
        }

        $produks = $produksQuery->paginate(12);

        // Get popular villas (based on rating, bookings, or views) - dengan cache
        $popularVillas = Cache::remember('landing_popular_villas', 3600, function () {
            return Produk::with('images', 'category')
                ->where('status', 'publish')
                ->orderBy('harga_weekday', 'desc') // You can change this to actual popularity logic
                ->limit(6)
                ->get();
        });

        // Get best villas (premium properties with high ratings) - dengan cache
        $bestVillas = Cache::remember('landing_best_villas', 3600, function () {
            return Produk::with('images', 'category', 'fasilitases')
                ->where('status', 'publish')
                ->where('label', 'LIKE', '%premium%') // or any other criteria for best villas
                ->inRandomOrder()
                ->limit(4)
                ->get();
        });

        // Get testimonials data
        $testimonials = [
            [
                'name' => 'Budi Santoso',
                'avatar' => asset('images/default-avatar.svg'),
                'rating' => 5,
                'content' => 'Liburan keluarga kami di Villa Premium Dieng benar-benar luar biasa! Dari check-in yang mudah hingga check-out yang lancar, semuanya sempurna. Villa sangat bersih, perabotan lengkap, dan pemandangan sunrise dari balkon membuat kami terkesima. Anak-anak sangat senang dengan taman bermain yang luas. Pelayanan staff sangat ramah dan responsif. Pasti akan kembali lagi tahun depan!',
                'date' => '2 minggu lalu',
                'villa' => 'Villa Premium Dieng'
            ],
            [
                'name' => 'Sarah Wijaya',
                'avatar' => asset('images/default-avatar.svg'),
                'rating' => 5,
                'content' => 'Saya mencari tempat untuk healing dari penatnya rutinitas kota, dan Villa Keluarga ini adalah jawabannya! Udara Dieng yang segar, pemandangan perbukitan yang hijau, dan ketenangan yang benar-benar jauh dari hiruk pikuk metropolitan. Villa dilengkapi dengan semua yang saya butuhkan, dari dapur lengkap hingga WiFi kencang. Malam hari dengan duduk di teras sambil minum teh dan melihat bintang adalah pengalaman tak terlupakan.',
                'date' => '1 bulan lalu',
                'villa' => 'Villa Keluarga'
            ],
            [
                'name' => 'Ahmad Fauzi',
                'avatar' => asset('images/default-avatar.svg'),
                'rating' => 5,
                'content' => 'Lokasi Villa View benar-benar strategis! Hanya 10 menit ke Kawah Sikidang dan 15 menit ke Candi Arjuna. Villa persis seperti di foto, bahkan lebih bagus secara langsung. Kamar tidur nyaman dengan selimut hangat, dapur bersih dengan peralatan lengkap, dan ruang keluarga yang cozy untuk berkumpul. Harga sangat worth it dengan fasilitas dan lokasi yang didapat. Highly recommended!',
                'date' => '3 minggu lalu',
                'villa' => 'Villa View'
            ],
            [
                'name' => 'Maya Putri',
                'avatar' => asset('images/default-avatar.svg'),
                'rating' => 5,
                'content' => 'Customer service-nya luar biasa! Saya booking mendadak karena ada perubahan rencana, team Villa Hotel Dieng sangat membantu menemukan villa yang tersedia dan memproses booking dengan cepat. Saat check-in, staff sudah menunggu dan memberikan penjelasan detail tentang villa dan rekomendasi tempat wisata. Mereka bahkan membantu mengatur transportasi lokal. Service level ini jarang saya temukan di tempat lain!',
                'date' => '2 bulan lalu',
                'villa' => 'Villa Executive'
            ],
            [
                'name' => 'Rizki Pratama',
                'avatar' => asset('images/default-avatar.svg'),
                'rating' => 5,
                'content' => 'Kami rombongan keluarga besar (15 orang) menginap di Villa Garden dan semuanya sempurna! Villa memiliki 4 kamar tidur yang luas, 3 kamar mandi, ruang keluarga yang besar, dan yang paling disukai anak-anak adalah taman bermain dengan ayunan dan perosotan. Dapur lengkap memudahkan kami masak untuk seluruh keluarga. Pemandangan gunung dari balkon utama sangat spektakuler, apalagi saat sunrise. Best family vacation ever!',
                'date' => '1 minggu lalu',
                'villa' => 'Villa Garden'
            ],
            [
                'name' => 'Dewi Lestari',
                'avatar' => asset('images/default-avatar.svg'),
                'rating' => 5,
                'content' => 'Villa Cozy exceeded all my expectations! Saya solo traveler yang mencari ketenangan, dan villa ini memberikan lebih dari itu. Interior designnya modern namun tetap cozy, tempat tidur super nyaman dengan bantal dan selimut berkualitas, kamar mandi bersih dengan water heater yang works perfectly. Yang saya suka: ada coffee maker, mini library dengan buku-buku menarik, dan teras kecil yang sempurna untuk morning coffee. Safety juga sangat terjamin dengan CCTV dan security 24 jam.',
                'date' => '4 minggu lalu',
                'villa' => 'Villa Cozy'
            ]
        ];

        // Get unique wisata list for filter dropdown
        $wisataList = ProdukWisata::select('name')
            ->distinct()
            ->orderBy('name', 'asc')
            ->pluck('name')
            ->map(function ($name) {
                // Remove pattern like "6 menit", "10 menit", etc from the end
                return preg_replace('/\s+\d+\s+menit$/i', '', $name);
            })
            ->unique()
            ->sort()
            ->values();

        return view('landing.index', compact('categories', 'selectedCategory', 'produks', 'activeCategory', 'popularVillas', 'bestVillas', 'testimonials', 'wisataList'));
    }

    public function allProducts(Request $request)
    {
        $categories = ProdukCategory::orderBy('urutan')->get();
        $searchQuery = $request->get('search');
        $activeCategory = $request->get('category');
        $isPromo = $request->get('promo') === 'true';
        $bookingDate = $request->get('booking_date');
        $nightsCount = $request->get('nights_count');

        // Advanced filter parameters
        $priceRange = $request->get('price_range');
        $capacity = $request->get('capacity');
        $rooms = $request->get('rooms');
        $attractions = $request->get('attractions');
        $sortBy = $request->get('sort');

        $produksQuery = Produk::with('images', 'category', 'wisatas')
            ->where('status', 'publish');

        if ($activeCategory) {
            $selectedCategory = ProdukCategory::where('slug', $activeCategory)->firstOrFail();
            $produksQuery->where('category_id', $selectedCategory->id);
        }

        if ($isPromo) {
            // Filter produk yang memiliki active promo dari sistem baru
            $produksQuery->where(function ($query) {
                $query->where('has_active_promo', true)
                    // Fallback ke legacy label system
                    ->orWhere(function ($subQuery) {
                        $subQuery->where('label', 'LIKE', '%promo%')
                            ->orWhere('label', 'LIKE', '%diskon%')
                            ->orWhere('label', 'LIKE', '%discount%')
                            ->orWhere('label', 'LIKE', '%sale%');
                    });
            });
        }

        if ($searchQuery) {
            $produksQuery->where(function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('lokasi', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('label', 'LIKE', '%' . $searchQuery . '%');
            });
        }

        // Price range filter
        if ($priceRange) {
            if ($priceRange === '0-500000') {
                $produksQuery->whereBetween('harga_weekday', [0, 500000]);
            } elseif ($priceRange === '500000-1000000') {
                $produksQuery->whereBetween('harga_weekday', [500000, 1000000]);
            } elseif ($priceRange === '1000000-2000000') {
                $produksQuery->whereBetween('harga_weekday', [1000000, 2000000]);
            } elseif ($priceRange === '2000000+') {
                $produksQuery->where('harga_weekday', '>', 2000000);
            }
        }

        // Capacity filter (minimum requirement)
        if ($capacity) {
            if ($capacity === '1-2') {
                $produksQuery->where('maks_orang', '>=', 1);
            } elseif ($capacity === '3-4') {
                $produksQuery->where('maks_orang', '>=', 3);
            } elseif ($capacity === '5-8') {
                $produksQuery->where('maks_orang', '>=', 5);
            } elseif ($capacity === '9+') {
                $produksQuery->where('maks_orang', '>=', 9);
            }
        }

        // Rooms filter (minimum requirement)
        if ($rooms) {
            if ($rooms === '1') {
                $produksQuery->where('kamar', '>=', 1);
            } elseif ($rooms === '2') {
                $produksQuery->where('kamar', '>=', 2);
            } elseif ($rooms === '3') {
                $produksQuery->where('kamar', '>=', 3);
            } elseif ($rooms === '4+') {
                $produksQuery->where('kamar', '>=', 4);
            }
        }

        // Attractions filter (using produk_wisatas table relationship)
        if ($attractions) {
            // Convert slug back to title case for matching
            $attractionName = str_replace('-', ' ', $attractions);
            $attractionName = ucwords($attractionName);

            $produksQuery->whereHas('wisatas', function ($query) use ($attractionName) {
                $query->where('name', 'LIKE', '%' . $attractionName . '%');
            });
        }

        // Sort by
        if ($sortBy) {
            if ($sortBy === 'price-low') {
                $produksQuery->orderBy('harga_weekday', 'asc');
            } elseif ($sortBy === 'price-high') {
                $produksQuery->orderBy('harga_weekday', 'desc');
            } elseif ($sortBy === 'rating') {
                $produksQuery->orderBy('rating', 'desc');
            } elseif ($sortBy === 'name') {
                $produksQuery->orderBy('name', 'asc');
            } else {
                $produksQuery->orderBy('urutan');
            }
        } else {
            $produksQuery->orderBy('urutan');
        }

        // Filter berdasarkan ketersediaan tanggal booking
        $availability = [];
        $fullyBookedProductIds = [];

        if ($bookingDate && $nightsCount) {
            $startDate = Carbon::parse($bookingDate);

            // Handle nilai "8+" menjadi 8 hari
            $daysToAdd = $nightsCount === '8+' ? 8 : (int)$nightsCount;
            $endDate = $startDate->copy()->addDays($daysToAdd);

            // Ambil semua produk yang ada booking di range tanggal
            $productsWithBookings = TransaksiDetail::where('status', '!=', 'REJECTED')
                ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                ->select('produk_id')
                ->distinct()
                ->pluck('produk_id');

            // Cek setiap produk apakah fully booked menggunakan method konsisten
            foreach ($productsWithBookings as $produkId) {
                $produk = Produk::find($produkId);
                if (!$produk) continue;

                // Gunakan method baru untuk cek fully booked
                if ($produk->isFullyBookedForRange($startDate->format('Y-m-d'), $endDate->format('Y-m-d'))) {
                    $fullyBookedProductIds[] = $produkId;
                }
            }

            // Filter hanya produk yang fully booked
            if (!empty($fullyBookedProductIds)) {
                $produksQuery->whereNotIn('id', $fullyBookedProductIds);
            }
        }

        $produks = $produksQuery->paginate(12)->withQueryString();

        // Hitung ketersediaan untuk setiap produk jika ada filter tanggal
        if ($bookingDate && $nightsCount) {
            $startDate = Carbon::parse($bookingDate);
            $daysToAdd = $nightsCount === '8+' ? 8 : (int)$nightsCount;
            $endDate = $startDate->copy()->addDays($daysToAdd);

            foreach ($produks as $produk) {
                // Gunakan method konsisten untuk hitung available units
                $availableUnits = $produk->getAvailableUnitsForRange($startDate->format('Y-m-d'), $endDate->format('Y-m-d'));
                $maxBookedInRange = $produk->unit - $availableUnits;

                $availability[$produk->id] = [
                    'total' => $produk->unit,
                    'booked' => $maxBookedInRange,  // Max booking di salah satu tanggal
                    'available' => $availableUnits,
                    'percentage' => $produk->unit > 0 ? round(($availableUnits / $produk->unit) * 100) : 0
                ];
            }
        }

        // Get unique wisata list for filter dropdown
        $wisataList = ProdukWisata::select('name')
            ->distinct()
            ->orderBy('name', 'asc')
            ->pluck('name')
            ->map(function ($name) {
                // Remove pattern like "6 menit", "10 menit", etc from the end
                return preg_replace('/\s+\d+\s+menit$/i', '', $name);
            })
            ->unique()
            ->sort()
            ->values();

        return view('landing.all-products', [
            'categories' => $categories,
            'produks' => $produks,
            'activeCategory' => $activeCategory,
            'isPromo' => $isPromo,
            'searchQuery' => $searchQuery,
            'bookingDate' => $bookingDate,
            'nightsCount' => $nightsCount,
            'priceRange' => $priceRange,
            'capacity' => $capacity,
            'rooms' => $rooms,
            'attractions' => $attractions,
            'sortBy' => $sortBy,
            'availability' => $availability,
            'wisataList' => $wisataList,
        ]);
    }

    public function produk($slug)
    {
        // mengambil data produk berdasarkan slug yang dikirimkan
        // beserta relasinya yaitu gambar, fasilitas, wisata dan syarat
        $produk = Produk::with('images', 'fasilitases', 'wisatas', 'syarats')->where('slug', $slug)->firstOrFail();

        // menghitung total unit yang sudah dibooking per tanggal menggunakan method konsisten
        $booked = $produk->getBookedDates();

        // if ($availableProduk) {
        //     $booked = $booked->merge($availableProduk);
        // }

        // mengambil data produk lainnya secara acak
        // dengan batas 3 produk dan tidak sama dengan produk yang sedang dibuka
        $rekomendasis = Produk::with('images')->where('id', '!=', $produk->id)->where('status', 'publish')->inRandomOrder()->limit(3)->get();

        // mengirimkan data ke view
        return view('landing.produk', [
            'produk' => $produk,
            'booked' => $booked,
            'rekomendasis' => $rekomendasis,
        ]);
    }
    public function produkBooking(Request $request)
    {
        session()->put('produk_booking', $request->all());
        return redirect()->route('produk.checkout');
    }
    public function checkout()
    {
        if (!session('produk_booking')) {
            return back()->withErrors('Permintaan tidak bisa diproses');
        }
        $rekenings = Rekening::orderBy('bank')->get();
        $produk = Produk::find(session('produk_booking')['produk_id']);
        return view('landing.checkout', compact('rekenings', 'produk'));
    }
    public function final(ProdukFinalRequest $request)
    {
        $produk = Produk::find(session('produk_booking')['produk_id']);
        if (!$produk) {
            return back()->withErrors('Produk tidak ditemukan.');
        }

        // Validasi konsistensi: Pastikan produk masih available untuk tanggal yang dipilih
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $unit = $request->unit;

        $availableUnits = $produk->getAvailableUnitsForRange($startDate, $endDate);
        if ($availableUnits < $unit) {
            // Log inkonsistensi availability
            ActivityLog::create([
                'log_date' => now(),
                'table_name' => 'produks',
                'log_type' => 'INCONSISTENCY_AVAILABILITY',
                'data' => json_encode([
                    'produk_id' => $produk->id,
                    'produk_name' => $produk->name,
                    'requested_units' => $unit,
                    'available_units' => $availableUnits,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'user_email' => $request->email,
                ]),
            ]);
            return back()->withErrors('Maaf, unit yang tersedia tidak mencukupi untuk tanggal yang dipilih. Silakan pilih tanggal lain.');
        }

        // Validasi harga konsisten
        $expectedTotal = $this->calculateExpectedTotal($produk, $startDate, $endDate, $unit);
        if (abs($request->total - $expectedTotal) > 0.01) { // Toleransi kecil untuk floating point
            // Log inkonsistensi harga
            ActivityLog::create([
                'log_date' => now(),
                'table_name' => 'produks',
                'log_type' => 'INCONSISTENCY_PRICE',
                'data' => json_encode([
                    'produk_id' => $produk->id,
                    'produk_name' => $produk->name,
                    'submitted_total' => $request->total,
                    'expected_total' => $expectedTotal,
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'unit' => $unit,
                    'user_email' => $request->email,
                ]),
            ]);
            return back()->withErrors('Harga total tidak sesuai. Silakan refresh halaman dan coba lagi.');
        }

        $datas = Arr::except($request->validated(), ['image']);
        if ($request->image) {
            $datas['image'] = storeImage($request, 'image', 'Transaksi\Transaksi');
        }
        $transaksi = Transaksi::create($datas);
        $start = Carbon::parse($transaksi->start_date);
        $end = Carbon::parse($transaksi->end_date);

        for ($date = $start; $date->lt($end); $date->addDay()) {
            TransaksiDetail::create([
                'transaksi_id' => $transaksi->id,
                'produk_id' => session('produk_booking')['produk_id'],
                'date' => $date->format('Y-m-d'),
                'unit' => session('produk_booking')['unit'],
            ]);
        }
        session()->forget('produk_booking');
        return redirect()->route('index')->with('success', 'Booking berhasil! Tunggu konfirmasi admin.');
    }

    private function calculateExpectedTotal(Produk $produk, $startDate, $endDate, $unit)
    {
        $start = Carbon::parse($startDate);
        $end = Carbon::parse($endDate);
        $nights = $start->diffInDays($end);
        $pricePerNight = $produk->isPromo() ? $produk->getPromoPriceWeekday() : $produk->harga_weekday; // Simplified, assuming weekday pricing
        return $pricePerNight * $nights * $unit;
    }
    public function about()
    {
        return view('landing.about', [
            'categories' => ProdukCategory::with('produks.images')->orderBy('name')->get(),
        ]);
    }
    public function terms()
    {
        return view('landing.terms', [
            'categories' => ProdukCategory::with('produks.images')->orderBy('name')->get(),
        ]);
    }
}
