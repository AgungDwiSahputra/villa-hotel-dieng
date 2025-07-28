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
        $activeCategory = $request->get('category') ?? $categories->first()->slug;
        $selectedCategory = ProdukCategory::with('produks.images')->where('slug', $activeCategory)->firstOrFail();
        $produks = $selectedCategory->produks()->paginate(12);
        return view('landing.index', compact('categories', 'selectedCategory', 'produks', 'activeCategory'));
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
