<?php

namespace App\Http\Controllers;

use App\Http\Requests\Landing\ProdukFinalRequest;
use App\Models\Availability;
use App\Models\Produk\Produk;
use App\Models\Produk\ProdukCategory;
use App\Models\Rekening;
use App\Models\Transaksi\Transaksi;
use App\Models\Transaksi\TransaksiDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
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
        
        // Get popular villas (based on rating, bookings, or views)
        $popularVillas = Produk::with('images', 'category')
            ->where('status', 'publish')
            ->orderBy('harga_weekday', 'desc') // You can change this to actual popularity logic
            ->limit(6)
            ->get();
            
        // Get best villas (premium properties with high ratings)
        $bestVillas = Produk::with('images', 'category', 'fasilitases')
            ->where('status', 'publish')
            ->where('label', 'LIKE', '%premium%') // or any other criteria for best villas
            ->inRandomOrder()
            ->limit(4)
            ->get();
            
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
        
        return view('landing.index', compact('categories', 'selectedCategory', 'produks', 'activeCategory', 'popularVillas', 'bestVillas', 'testimonials'));
    }

    public function allProducts(Request $request)
    {
        $categories = ProdukCategory::orderBy('urutan')->get();
        $searchQuery = $request->get('search');
        $activeCategory = $request->get('category');
        $isPromo = $request->get('promo') === 'true';
        $bookingDate = $request->get('booking_date');
        $nightsCount = $request->get('nights');

        $produksQuery = Produk::with('images', 'category')
            ->where('status', 'publish')
            ->orderBy('urutan');

        if ($activeCategory) {
            $selectedCategory = ProdukCategory::where('slug', $activeCategory)->firstOrFail();
            $produksQuery->where('category_id', $selectedCategory->id);
        }

        if ($isPromo) {
            // Filter produk yang memiliki label promo atau diskon
            $produksQuery->where(function ($query) {
                $query->where('label', 'LIKE', '%promo%')
                    ->orWhere('label', 'LIKE', '%diskon%')
                    ->orWhere('label', 'LIKE', '%discount%')
                    ->orWhere('label', 'LIKE', '%sale%');
            });
        }

        if ($searchQuery) {
            $produksQuery->where(function ($query) use ($searchQuery) {
                $query->where('name', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('lokasi', 'LIKE', '%' . $searchQuery . '%')
                    ->orWhere('label', 'LIKE', '%' . $searchQuery . '%');
            });
        }

        // Filter berdasarkan ketersediaan tanggal booking
        if ($bookingDate && $nightsCount) {
            $startDate = Carbon::parse($bookingDate);
            
            // Handle nilai "8+" menjadi 8 hari
            $daysToAdd = $nightsCount === '8+' ? 8 : (int)$nightsCount;
            $endDate = $startDate->copy()->addDays($daysToAdd);
            
            // Ambil ID produk yang tidak tersedia untuk tanggal yang dipilih
            $unavailableProductIds = TransaksiDetail::where('status', '!=', 'REJECTED')
                ->whereBetween('date', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
                ->pluck('produk_id')
                ->unique();
            
            // Filter produk yang tersedia
            if ($unavailableProductIds->isNotEmpty()) {
                $produksQuery->whereNotIn('id', $unavailableProductIds);
            }
        }

        $produks = $produksQuery->paginate(12)->withQueryString();

        return view('landing.all-products', [
            'categories' => $categories,
            'produks' => $produks,
            'activeCategory' => $activeCategory,
            'isPromo' => $isPromo,
            'searchQuery' => $searchQuery,
            'bookingDate' => $bookingDate,
            'nightsCount' => $nightsCount,
        ]);
    }

    public function produk($slug)
    {
        // mengambil data produk berdasarkan slug yang dikirimkan
        // beserta relasinya yaitu gambar, fasilitas, wisata dan syarat
        $produk = Produk::with('images', 'fasilitases', 'wisatas', 'syarats')->where('slug', $slug)->firstOrFail();

        // menghitung total unit yang sudah dibooking per tanggal
        // berdasarkan status yang tidak sama dengan "REJECTED"
        $booked = TransaksiDetail::where('produk_id', $produk->id)->where('status', '!=', 'REJECTED')->select('date', DB::raw('SUM(unit) as total'))->groupBy('date')->pluck('total', 'date');
        
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
