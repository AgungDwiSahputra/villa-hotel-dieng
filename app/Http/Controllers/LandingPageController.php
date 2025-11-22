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
use Illuminate\Support\Facades\Log;

class LandingPageController extends Controller
{
    public function index(Request $request)
    {
        $categories = ProdukCategory::orderBy('urutan')->get();
        $searchQuery = $request->get('search');
        $activeCategory = $request->get('category');
        $selectedCategory = null;

        $produksQuery = Produk::with('images', 'category')
            ->where('produks.status', 'publish')
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

        // Get popular villas (based on booking count and rating) - dengan cache
        $popularVillas = Cache::remember('landing_popular_villas', 3600, function () {
            return Produk::with('images', 'category')
                ->withCount(['transaksi_details as booking_count' => function ($query) {
                    $query->where('transaksi_details.status', '!=', 'REJECTED'); // Exclude rejected bookings
                }])
                ->where('produks.status', 'publish')
                ->orderBy('booking_count', 'desc') // Prioritize by booking count
                ->orderBy('rating', 'desc') // Then by rating
                ->orderBy('harga_weekday', 'desc') // Finally by price
                ->limit(6)
                ->get();
        });

        // Get best villas (high-rated properties with rating >= 4.5) - dengan cache
        $bestVillas = Cache::remember('landing_best_villas', 3600, function () {
            return Produk::with('images', 'category', 'fasilitases')
                ->where('produks.status', 'publish')
                ->where('rating', '>=', 4.5) // High rated products
                ->orderBy('rating', 'desc')
                ->orderBy('harga_weekday', 'desc') // Then by price
                ->limit(4)
                ->get();
        });

        // Get testimonials data
        $testimonials = [
            [
                'name' => 'Budi Santoso',
                'avatar' => asset('images/default-avatar.svg'),
                'rating' => 5,
                'content' => 'Liburan keluarga kami di FULL HOUSE BEST VIEW benar-benar luar biasa! Dari check-in yang mudah hingga check-out yang lancar, semuanya sempurna. Villa sangat bersih, perabotan lengkap, dan pemandangan sunrise dari balkon membuat kami terkesima. Anak-anak sangat senang dengan taman bermain yang luas. Pelayanan staff sangat ramah dan responsif. Pasti akan kembali lagi tahun depan!',
                'date' => '2 minggu lalu',
                'villa' => 'FULL HOUSE BEST VIEW'
            ],
            [
                'name' => 'Sarah Wijaya',
                'avatar' => asset('images/default-avatar.svg'),
                'rating' => 5,
                'content' => 'Saya mencari tempat untuk healing dari penatnya rutinitas kota, dan Sunflowers Cabin Dieng ini adalah jawabannya! Udara Dieng yang segar, pemandangan perbukitan yang hijau, dan ketenangan yang benar-benar jauh dari hiruk pikuk metropolitan. Villa dilengkapi dengan semua yang saya butuhkan, dari dapur lengkap hingga WiFi kencang. Malam hari dengan duduk di teras sambil minum teh dan melihat bintang adalah pengalaman tak terlupakan.',
                'date' => '1 bulan lalu',
                'villa' => 'Sunflowers Cabin Dieng'
            ],
            [
                'name' => 'Ahmad Fauzi',
                'avatar' => asset('images/default-avatar.svg'),
                'rating' => 5,
                'content' => 'Lokasi 1 Lantai Best View Di Lantai 2 benar-benar strategis! Hanya 10 menit ke Kawah Sikidang dan 15 menit ke Candi Arjuna. Villa persis seperti di foto, bahkan lebih bagus secara langsung. Kamar tidur nyaman dengan selimut hangat, dapur bersih dengan peralatan lengkap, dan ruang keluarga yang cozy untuk berkumpul. Harga sangat worth it dengan fasilitas dan lokasi yang didapat. Highly recommended!',
                'date' => '3 minggu lalu',
                'villa' => '1 Lantai Best View Di Lantai 2'
            ],
            [
                'name' => 'Maya Putri',
                'avatar' => asset('images/default-avatar.svg'),
                'rating' => 5,
                'content' => 'Customer service-nya luar biasa! Saya booking mendadak karena ada perubahan rencana, team Villa Hotel Dieng sangat membantu menemukan villa yang tersedia dan memproses booking dengan cepat. Saat check-in, staff sudah menunggu dan memberikan penjelasan detail tentang villa dan rekomendasi tempat wisata. Mereka bahkan membantu mengatur transportasi lokal. Service level ini jarang saya temukan di tempat lain!',
                'date' => '2 bulan lalu',
                'villa' => '1 Kamar Best View Lantai 3'
            ],
            [
                'name' => 'Rizki Pratama',
                'avatar' => asset('images/default-avatar.svg'),
                'rating' => 5,
                'content' => 'Kami rombongan keluarga besar (15 orang) menginap di Sunflower Private Pool dan semuanya sempurna! Villa memiliki 4 kamar tidur yang luas, 3 kamar mandi, ruang keluarga yang besar, dan yang paling disukai anak-anak adalah taman bermain dengan ayunan dan perosotan. Dapur lengkap memudahkan kami masak untuk seluruh keluarga. Pemandangan gunung dari balkon utama sangat spektakuler, apalagi saat sunrise. Best family vacation ever!',
                'date' => '1 minggu lalu',
                'villa' => 'Sunflower Private Pool'
            ],
            [
                'name' => 'Dewi Lestari',
                'avatar' => asset('images/default-avatar.svg'),
                'rating' => 5,
                'content' => 'FULL HOUSE BEST VIEW exceeded all my expectations! Saya solo traveler yang mencari ketenangan, dan villa ini memberikan lebih dari itu. Interior designnya modern namun tetap cozy, tempat tidur super nyaman dengan bantal dan selimut berkualitas, kamar mandi bersih dengan water heater yang works perfectly. Yang saya suka: ada coffee maker, mini library dengan buku-buku menarik, dan teras kecil yang sempurna untuk morning coffee. Safety juga sangat terjamin dengan CCTV dan security 24 jam.',
                'date' => '4 minggu lalu',
                'villa' => 'FULL HOUSE BEST VIEW'
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
        Log::info('allProducts: Starting product listing process', [
            'request_params' => $request->all(),
            'user_agent' => $request->userAgent(),
            'ip' => $request->ip()
        ]);

        $categories = ProdukCategory::orderBy('urutan')->get();
        Log::info('allProducts: Retrieved categories', ['categories_count' => $categories->count()]);

        $searchQuery = $request->get('search');
        $activeCategory = $request->get('category');
        $isPromo = $request->get('promo') === 'true';
        $bookingDate = $request->get('booking_date');
        $nightsCount = $request->get('nights');

        // Advanced filter parameters
        $priceRange = $request->get('price_range');
        $capacity = $request->get('capacity');
        $rooms = $request->get('rooms');
        $attractions = $request->get('attractions');
        $sortBy = $request->get('sort');

        Log::info('allProducts: Parsed request parameters', [
            'searchQuery' => $searchQuery,
            'activeCategory' => $activeCategory,
            'isPromo' => $isPromo,
            'bookingDate' => $bookingDate,
            'nightsCount' => $nightsCount,
            'priceRange' => $priceRange,
            'capacity' => $capacity,
            'rooms' => $rooms,
            'attractions' => $attractions,
            'sortBy' => $sortBy
        ]);

        $produksQuery = Produk::with('images', 'category', 'wisatas')
            ->where('produks.status', 'publish');
        Log::info('allProducts: Initialized produk query with eager loading');

        if ($activeCategory) {
            $selectedCategory = ProdukCategory::where('slug', $activeCategory)->firstOrFail();
            $produksQuery->where('produks.category_id', $selectedCategory->id);
            Log::info('allProducts: Applied category filter', [
                'category_slug' => $activeCategory,
                'category_id' => $selectedCategory->id,
                'category_name' => $selectedCategory->name
            ]);
        }

        if ($isPromo) {
            Log::info('allProducts: Applying promo filter');
            // Filter produk yang memiliki active promo dari sistem baru
            $produksQuery->where(function ($query) {
                $query->where('produks.has_active_promo', true)
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
            Log::info('allProducts: Applying search filter', ['search_query' => $searchQuery]);
            $produksQuery->where(function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('lokasi', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('label', 'LIKE', '%' . $searchQuery . '%');
            });
        }

        // Price range filter
        if ($priceRange) {
            Log::info('allProducts: Applying price range filter', ['price_range' => $priceRange]);
            if ($priceRange === '0-500000') {
                $produksQuery->whereBetween('produks.harga_weekday', [0, 500000]);
            } elseif ($priceRange === '500000-1000000') {
                $produksQuery->whereBetween('produks.harga_weekday', [500000, 1000000]);
            } elseif ($priceRange === '1000000-2000000') {
                $produksQuery->whereBetween('produks.harga_weekday', [1000000, 2000000]);
            } elseif ($priceRange === '2000000+') {
                $produksQuery->where('produks.harga_weekday', '>', 2000000);
            }
        }

        // Capacity filter (minimum requirement)
        if ($capacity) {
            Log::info('allProducts: Applying capacity filter', ['capacity' => $capacity]);
            if ($capacity === '1-2') {
                $produksQuery->where('produks.maks_orang', '>=', 1);
            } elseif ($capacity === '3-4') {
                $produksQuery->where('produks.maks_orang', '>=', 3);
            } elseif ($capacity === '5-8') {
                $produksQuery->where('produks.maks_orang', '>=', 5);
            } elseif ($capacity === '9+') {
                $produksQuery->where('produks.maks_orang', '>=', 9);
            }
        }

        // Rooms filter (minimum requirement)
        if ($rooms) {
            Log::info('allProducts: Applying rooms filter', ['rooms' => $rooms]);
            if ($rooms === '1') {
                $produksQuery->where('produks.kamar', '>=', 1);
            } elseif ($rooms === '2') {
                $produksQuery->where('produks.kamar', '>=', 2);
            } elseif ($rooms === '3') {
                $produksQuery->where('produks.kamar', '>=', 3);
            } elseif ($rooms === '4+') {
                $produksQuery->where('produks.kamar', '>=', 4);
            }
        }

        // Attractions filter (using produk_wisatas table relationship)
        if ($attractions) {
            Log::info('allProducts: Applying attractions filter', ['attractions_slug' => $attractions]);
            // Convert slug back to title case for matching
            $attractionName = str_replace('-', ' ', $attractions);
            $attractionName = ucwords($attractionName);
            Log::info('allProducts: Converted attraction name', ['attraction_name' => $attractionName]);

            $produksQuery->whereHas('wisatas', function ($query) use ($attractionName) {
                $query->where('name', 'LIKE', '%' . $attractionName . '%');
            });
        }

        // Sort by
        if ($sortBy) {
            Log::info('allProducts: Applying sorting', ['sort_by' => $sortBy]);
            if ($sortBy === 'price-low') {
                $produksQuery->orderBy('produks.harga_weekday', 'asc');
            } elseif ($sortBy === 'price-high') {
                $produksQuery->orderBy('produks.harga_weekday', 'desc');
            } elseif ($sortBy === 'rating') {
                $produksQuery->orderBy('produks.rating', 'desc');
            } elseif ($sortBy === 'name') {
                $produksQuery->orderBy('produks.name', 'asc');
            } else {
                $produksQuery->orderBy('produks.urutan');
            }
        } else {
            Log::info('allProducts: Using default sorting by urutan');
            $produksQuery->orderBy('produks.urutan');
        }

        // Filter berdasarkan ketersediaan tanggal booking
        $availability = [];
        $fullyBookedProductIds = [];

        if ($bookingDate && $nightsCount) {
            Log::info('allProducts: Applying availability filter', [
                'booking_date' => $bookingDate,
                'nights_count' => $nightsCount
            ]);

            $startDate = Carbon::parse($bookingDate);
            Log::info('allProducts: Parsed start date', ['start_date' => $startDate->format('Y-m-d')]);

            // Handle nilai "8+" menjadi 8 hari
            $daysToAdd = $nightsCount === '8+' ? 8 : (int)$nightsCount;
            $endDate = $startDate->copy()->addDays($daysToAdd);
            Log::info('allProducts: Calculated date range', [
                'start_date' => $startDate->format('Y-m-d'),
                'end_date' => $endDate->format('Y-m-d'),
                'days_to_add' => $daysToAdd
            ]);

            // Filter produk yang tidak fully booked menggunakan left join
            // Berdasarkan dokumentasi: status di transaksi_details bisa 'PENDING','APPROVED','REJECTED'
            Log::info('allProducts: Applying availability join filter');
            $produksQuery->leftJoin('transaksi_details', function ($join) use ($startDate, $endDate) {
                $join->on('produks.id', '=', 'transaksi_details.produk_id')
                     ->where('transaksi_details.status', '!=', 'REJECTED') // Exclude cancelled bookings
                     ->whereBetween('transaksi_details.date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')]);
            })
            ->select('produks.*')
            ->where('produks.status', 'publish')
            ->groupBy('produks.id')
            ->havingRaw('COALESCE(MAX(transaksi_details.unit), 0) < produks.unit');
        }

        Log::info('allProducts: Executing paginated query');
        $produks = $produksQuery->paginate(12)->withQueryString();
        Log::info('allProducts: Query executed', [
            'total_products' => $produks->total(),
            'current_page' => $produks->currentPage(),
            'per_page' => $produks->perPage(),
            'products_count' => $produks->count()
        ]);

        // Hitung ketersediaan untuk setiap produk jika ada filter tanggal
        if ($bookingDate && $nightsCount) {
            Log::info('allProducts: Calculating availability for products');
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
            Log::info('allProducts: Availability calculation completed', [
                'products_processed' => count($availability),
                'availability_data' => $availability
            ]);
        }

        // Get unique wisata list for filter dropdown
        Log::info('allProducts: Fetching wisata list for filter dropdown');
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
        Log::info('allProducts: Wisata list processed', ['wisata_count' => $wisataList->count()]);

        Log::info('allProducts: Returning view with all data', [
            'categories_count' => $categories->count(),
            'products_total' => $produks->total(),
            'wisata_list_count' => $wisataList->count(),
            'availability_count' => count($availability)
        ]);

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
        $rekomendasis = Produk::with('images')->where('id', '!=', $produk->id)->where('produks.status', 'publish')->inRandomOrder()->limit(3)->get();

        // mengambil data semua produk yang memiliki koordinat untuk peta
        $produkData = Produk::whereNotNull('latitude')
            ->whereNotNull('longitude')
            ->with('category')
            ->select(['id', 'name', 'lokasi', 'latitude', 'longitude', 'harga_weekday', 'harga_weekend', 'slug'])
            ->get();

        // mengirimkan data ke view
        return view('landing.produk', [
            'produk' => $produk,
            'booked' => $booked,
            'rekomendasis' => $rekomendasis,
            'produkData' => $produkData,
        ]);
    }
    public function produkBooking(Request $request)
    {
        $produk = Produk::findOrFail($request->produk_id);

        // Calculate original total using original prices based on actual dates
        // Promo codes will be applied at checkout
        $bookingData = $request->all();

        // Calculate total price based on weekday/weekend pricing for the date range
        $originalTotal = $produk->calculateTotalPriceForRange(
            $request->start_date,
            $request->end_date,
            $request->unit
        );

        // Calculate original DP based on original total
        $dpPercentage = $request->dp / $request->total;
        $originalDp = $originalTotal * $dpPercentage;

        // Calculate number of nights
        $startDate = Carbon::parse($request->start_date);
        $endDate = Carbon::parse($request->end_date);
        $nights = $startDate->diffInDays($endDate);

        // Override with calculated prices
        $bookingData['total'] = $originalTotal;
        $bookingData['dp'] = $originalDp;
        $bookingData['night'] = $nights;

        // Add price breakdown for display
        $bookingData['price_breakdown'] = $produk->getPriceBreakdownForRange(
            $request->start_date,
            $request->end_date,
            $request->unit
        );

        // Store booking data in session temporarily for checkout page
        // TODO: Remove session usage in future refactoring
        session()->put('produk_booking', $bookingData);
        return redirect()->route('produk.checkout');
    }
    public function checkout()
    {
        if (!session('produk_booking')) {
            return back()->withErrors('Permintaan tidak bisa diproses');
        }

        $rekenings = Rekening::orderBy('bank')->get();
        $produk = Produk::find(session('produk_booking')['produk_id']);
        $bookingData = session('produk_booking');

        return view('landing.checkout', compact('rekenings', 'produk', 'bookingData'));
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
        // Use the same calculation method as booking process
        return $produk->calculateTotalPriceForRange($startDate, $endDate, $unit);
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

    public function getActivePromos()
    {
        $promos = \App\Models\Promo\Promo::where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now())
            ->where(function ($query) {
                $query->where('usage_limit', '>', DB::raw('usage_count'))
                    ->orWhereNull('usage_limit');
            })
            ->select(['id', 'name', 'promo_code', 'description', 'discount_type', 'discount_value', 'applicable_to'])
            ->get()
            ->map(function ($promo) {
                // Generate meaningful description if null
                $description = $promo->description;
                if (!$description) {
                    if ($promo->discount_type === 'percentage') {
                        $description = "Diskon {$promo->discount_value}%";
                    } else {
                        $description = "Potongan Rp " . number_format($promo->discount_value, 0, ',', '.');
                    }

                    // Add applicability info
                    if ($promo->applicable_to === 'all') {
                        $description .= " untuk semua produk";
                    } elseif ($promo->applicable_to === 'category') {
                        $description .= " untuk kategori tertentu";
                    } else { // product
                        $description .= " untuk produk tertentu";
                    }
                }

                return [
                    'code' => $promo->promo_code,
                    'name' => $promo->name,
                    'description' => $description,
                    'discount_type' => $promo->discount_type,
                    'discount_value' => $promo->discount_value,
                    'applicable_to' => $promo->applicable_to,
                ];
            });

        return response()->json($promos);
    }

    public function previewPromo(Request $request)
    {
        $request->validate([
            'promo_code' => 'required|string|max:20',
            'produk_id' => 'required|uuid|exists:produks,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'unit' => 'required|integer|min:1',
            'night' => 'required|integer|min:1',
            'total' => 'required|numeric|min:0',
            'dp' => 'required|numeric|min:0',
        ]);

        try {
            $produk = \App\Models\Produk\Produk::findOrFail($request->produk_id);

            // Find promo
            $promo = \App\Models\Promo\Promo::where('promo_code', $request->promo_code)
                ->where('is_active', true)
                ->first();

            if (!$promo) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Kode promo tidak valid atau tidak aktif.'
                ], 422);
            }

            // Validate promo
            if (!$promo->isValid()) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Kode promo sudah tidak berlaku atau sudah mencapai batas penggunaan.'
                ], 422);
            }

            // Check if promo is applicable to this product
            if (!$promo->isApplicableToProduct($produk)) {
                return response()->json([
                    'valid' => false,
                    'message' => 'Kode promo tidak berlaku untuk produk ini.'
                ], 422);
            }

            // Calculate discount (same logic as BookingController)
            $discountConfig = $promo->getEffectiveDiscountForProduct($produk);

            // Calculate total price based on actual date range (weekday/weekend pricing)
            $totalPrice = $produk->calculateTotalPriceForRange(
                $request->start_date,
                $request->end_date,
                $request->unit
            );

            if ($discountConfig['type'] === 'percentage') {
                $discountAmount = $totalPrice * ($discountConfig['value'] / 100);
            } else {
                $discountAmount = min($discountConfig['value'], $totalPrice);
            }

            $finalTotal = max(0, $totalPrice - $discountAmount);

            // Recalculate DP based on discount (same as BookingController)
            $dpPercentage = $request->dp / $request->total;
            $finalDp = $finalTotal * $dpPercentage;

            return response()->json([
                'valid' => true,
                'promo' => [
                    'name' => $promo->name,
                    'code' => $promo->promo_code,
                    'discount_type' => $discountConfig['type'],
                    'discount_value' => $discountConfig['value'],
                ],
                'calculation' => [
                    'original_total' => $totalPrice, // Use calculated original total, not from request
                    'original_dp' => $request->dp,
                    'discount_amount' => $discountAmount,
                    'final_total' => $finalTotal,
                    'final_dp' => $finalDp,
                ],
                'message' => 'Kode promo valid! Diskon akan diterapkan.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'valid' => false,
                'message' => 'Terjadi kesalahan saat memvalidasi promo: ' . $e->getMessage()
            ], 500);
        }
    }
}
