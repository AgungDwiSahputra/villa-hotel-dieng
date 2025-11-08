<x-app-landing-layout>
    <section class="relative py-16 sm:py-20 bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold font-display mb-4">Semua Villa</h1>
                <p class="text-base sm:text-lg lg:text-xl text-gray-200">Jelajahi seluruh koleksi villa dengan filter kategori dan pencarian untuk menemukan pilihan terbaik.</p>
                @if($searchQuery || ($bookingDate && $nightsCount) || $isPromo)
                    <div class="mt-6 inline-flex items-center px-4 py-2 bg-white/10 border border-white/20 rounded-full text-sm sm:text-base">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>
                            @if($isPromo)
                                <span class="inline-flex items-center px-2 py-1 bg-red-500 text-white text-xs font-semibold rounded-full mr-2">PROMO</span>
                            @endif
                            @if($searchQuery)
                                Hasil pencarian untuk "{{ $searchQuery }}"
                                @if($bookingDate && $nightsCount || $isPromo) - @endif
                            @endif
                            @if($bookingDate && $nightsCount)
                                Tersedia pada {{ \Carbon\Carbon::parse($bookingDate)->format('d M Y') }} untuk {{ $nightsCount === '8+' ? '8+' : $nightsCount }} malam
                                @if($isPromo) - @endif
                            @endif
                            @if($isPromo && !$searchQuery && !($bookingDate && $nightsCount))
                                Menampilkan semua villa dengan promo spesial
                            @endif
                        </span>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="py-16 sm:py-20 bg-gray-50" id="all-products">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-lg p-6 sm:p-8 mb-8">
                <form method="GET" action="{{ route('produk.all') }}" class="space-y-4 lg:space-y-6">
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                        <div>
                            <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Cari Villa</label>
                            <div class="relative">
                                <input id="search" type="text" name="search" value="{{ $searchQuery ?? '' }}" placeholder="Cari berdasarkan nama, lokasi, atau label" class="w-full pl-4 pr-12 py-3 text-sm sm:text-base text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <button type="submit" class="absolute inset-y-0 right-0 flex items-center justify-center w-12 text-gray-500 hover:text-primary-600 transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div>
                            <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                            <select id="category" name="category" class="w-full px-4 py-3 text-sm sm:text-base text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Semua Kategori</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->slug }}" {{ $activeCategory === $category->slug ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                        <div>
                            <label for="booking_date" class="block text-sm font-medium text-gray-700 mb-2">Tanggal Booking</label>
                            <input id="booking_date" type="date" name="booking_date" value="{{ $bookingDate ?? '' }}" class="w-full px-4 py-3 text-sm sm:text-base text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        </div>
                        <div>
                            <label for="nights" class="block text-sm font-medium text-gray-700 mb-2">Jumlah Malam</label>
                            <select id="nights" name="nights" class="w-full px-4 py-3 text-sm sm:text-base text-gray-900 bg-gray-50 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                                <option value="">Pilih jumlah malam</option>
                                <option value="1" {{ ($nightsCount ?? '') == '1' ? 'selected' : '' }}>1 Malam</option>
                                <option value="2" {{ ($nightsCount ?? '') == '2' ? 'selected' : '' }}>2 Malam</option>
                                <option value="3" {{ ($nightsCount ?? '') == '3' ? 'selected' : '' }}>3 Malam</option>
                                <option value="4" {{ ($nightsCount ?? '') == '4' ? 'selected' : '' }}>4 Malam</option>
                                <option value="5" {{ ($nightsCount ?? '') == '5' ? 'selected' : '' }}>5 Malam</option>
                                <option value="6" {{ ($nightsCount ?? '') == '6' ? 'selected' : '' }}>6 Malam</option>
                                <option value="7" {{ ($nightsCount ?? '') == '7' ? 'selected' : '' }}>7 Malam</option>
                                <option value="8+" {{ ($nightsCount ?? '') == '8+' ? 'selected' : '' }}>8+ Malam</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="flex items-center justify-between">
                        <div class="flex gap-3">
                            @if($searchQuery || $activeCategory || $bookingDate || $nightsCount || $isPromo)
                                <a href="{{ route('produk.all') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Reset Semua
                                </a>
                            @endif
                            
                            <!-- Quick Promo Button -->
                            @if(!$isPromo)
                                <a href="{{ route('produk.all', array_filter(['search' => $searchQuery, 'category' => $activeCategory, 'booking_date' => $bookingDate, 'nights' => $nightsCount, 'promo' => 'true'])) }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-red-600 hover:text-red-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-3 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Lihat Promo
                                </a>
                            @endif
                        </div>
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Telusuri
                        </button>
                    </div>
                </form>
            </div>

            <div class="flex items-center justify-between flex-wrap gap-3 mb-6">
                <div>
                    <p class="text-sm sm:text-base text-gray-600">
                        @if($isPromo)
                            Menampilkan {{ $produks->firstItem() ?? 0 }} - {{ $produks->lastItem() ?? 0 }} dari {{ $produks->total() }} villa promo
                        @else
                            Menampilkan {{ $produks->firstItem() ?? 0 }} - {{ $produks->lastItem() ?? 0 }} dari {{ $produks->total() }} villa
                        @endif
                    </p>
                </div>
                <div class="flex gap-3">
                    @if($activeCategory)
                        <a href="{{ route('produk.all', array_filter(['search' => $searchQuery, 'booking_date' => $bookingDate, 'nights' => $nightsCount, 'promo' => $isPromo ? 'true' : null])) }}" class="text-sm font-medium text-primary-600 hover:text-primary-700">Reset Kategori</a>
                    @endif
                    @if($isPromo)
                        <a href="{{ route('produk.all', array_filter(['search' => $searchQuery, 'category' => $activeCategory, 'booking_date' => $bookingDate, 'nights' => $nightsCount])) }}" class="text-sm font-medium text-red-600 hover:text-red-700">Reset Promo</a>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 lg:gap-6">
                @forelse ($produks as $produk)
                    <x-villa-card :villa="$produk" />
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-16 bg-white rounded-2xl shadow">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada penginapan yang ditemukan</h3>
                            <p class="text-gray-600 mb-6">Coba ubah kata kunci pencarian atau pilih kategori lain.</p>
                            <a href="{{ route('produk.all') }}" class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Reset Pencarian
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>

            @if ($produks->lastPage() > 1)
                <nav aria-label="Pagination" class="mt-12">
                    <div class="flex items-center justify-center space-x-2">
                        @if(!$produks->onFirstPage())
                            <a href="{{ $produks->previousPageUrl() }}" class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 text-gray-700 hover:bg-primary-600 hover:text-white transition-colors" aria-label="Sebelumnya">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </a>
                        @else
                            <span class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </span>
                        @endif

                        @for ($i = 1; $i <= $produks->lastPage(); $i++)
                            @if($i == $produks->currentPage())
                                <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-600 text-white font-medium">{{ $i }}</span>
                            @elseif(abs($i - $produks->currentPage()) <= 2 || $i == 1 || $i == $produks->lastPage())
                                <a href="{{ $produks->url($i) }}" class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 text-gray-700 hover:bg-primary-600 hover:text-white transition-colors" aria-label="Halaman {{ $i }}">{{ $i }}</a>
                            @elseif(abs($i - $produks->currentPage()) == 3)
                                <span class="flex items-center justify-center w-10 h-10 text-gray-400">...</span>
                            @endif
                        @endfor

                        @if($produks->hasMorePages())
                            <a href="{{ $produks->nextPageUrl() }}" class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 text-gray-700 hover:bg-primary-600 hover:text-white transition-colors" aria-label="Berikutnya">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        @else
                            <span class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 text-gray-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </span>
                        @endif
                    </div>
                </nav>
            @endif
        </div>
    </section>
</x-app-landing-layout>
