<x-app-landing-layout>
    <section class="relative py-16 sm:py-20 bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 text-white overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>
        <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
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
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
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

                    <!-- Advanced Filter Section -->
                    <div class="mt-6">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-base lg:text-lg font-semibold text-gray-900 flex items-center">
                                <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                </svg>
                                Filter Pencarian Lanjutan
                            </h3>
                            <button class="lg:hidden flex items-center text-primary-600 hover:text-primary-700 font-medium" id="toggleAdvancedFilterMobile">
                                <span id="filterToggleTextMobile">Tampilkan Filter</span>
                                <svg class="w-5 h-5 ml-2 transform transition-transform" id="filterToggleIconMobile" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4" id="advancedFilterContentMobile">
                            <div>
                                <label for="price_range" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 lg:mb-2">Rentang Harga</label>
                                <select name="price_range" id="price_range" class="w-full px-3 py-2 lg:px-4 lg:py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                    <option value="">Semua Harga</option>
                                    <option value="0-500000" {{ ($priceRange ?? '') == '0-500000' ? 'selected' : '' }}>Rp 0 - 500.000</option>
                                    <option value="500000-1000000" {{ ($priceRange ?? '') == '500000-1000000' ? 'selected' : '' }}>Rp 500.000 - 1.000.000</option>
                                    <option value="1000000-2000000" {{ ($priceRange ?? '') == '1000000-2000000' ? 'selected' : '' }}>Rp 1.000.000 - 2.000.000</option>
                                    <option value="2000000+" {{ ($priceRange ?? '') == '2000000+' ? 'selected' : '' }}>Di atas Rp 2.000.000</option>
                                </select>
                            </div>

                            <div>
                                <label for="capacity" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 lg:mb-2">Kapasitas</label>
                                <select name="capacity" id="capacity" class="w-full px-3 py-2 lg:px-4 lg:py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                    <option value="">Semua Kapasitas</option>
                                    <option value="1-2" {{ ($capacity ?? '') == '1-2' ? 'selected' : '' }}>1-2 Orang</option>
                                    <option value="3-4" {{ ($capacity ?? '') == '3-4' ? 'selected' : '' }}>3-4 Orang</option>
                                    <option value="5-8" {{ ($capacity ?? '') == '5-8' ? 'selected' : '' }}>5-8 Orang</option>
                                    <option value="9+" {{ ($capacity ?? '') == '9+' ? 'selected' : '' }}>9+ Orang</option>
                                </select>
                            </div>

                            <div>
                                <label for="rooms" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 lg:mb-2">Jumlah Kamar</label>
                                <select name="rooms" id="rooms" class="w-full px-3 py-2 lg:px-4 lg:py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                    <option value="">Semua Kamar</option>
                                    <option value="1" {{ ($rooms ?? '') == '1' ? 'selected' : '' }}>1 Kamar</option>
                                    <option value="2" {{ ($rooms ?? '') == '2' ? 'selected' : '' }}>2 Kamar</option>
                                    <option value="3" {{ ($rooms ?? '') == '3' ? 'selected' : '' }}>3 Kamar</option>
                                    <option value="4+" {{ ($rooms ?? '') == '4+' ? 'selected' : '' }}>4+ Kamar</option>
                                </select>
                            </div>

                            <div>
                                <label for="attractions" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 lg:mb-2">Dekat Wisata</label>
                                <select name="attractions" id="attractions" class="w-full px-3 py-2 lg:px-4 lg:py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                    <option value="">Semua Lokasi</option>
                                    @foreach($wisataList as $wisata)
                                        <option value="{{ Str::slug($wisata) }}" {{ ($attractions ?? '') == Str::slug($wisata) ? 'selected' : '' }}>{{ $wisata }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="flex items-center gap-2 mt-4 lg:mt-6">
                            <label for="sort" class="text-xs sm:text-sm font-medium text-gray-700">Urutkan:</label>
                            <select name="sort" id="sort" class="px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                                <option value="relevance" {{ ($sortBy ?? '') == 'relevance' ? 'selected' : '' }}>Relevansi</option>
                                <option value="price-low" {{ ($sortBy ?? '') == 'price-low' ? 'selected' : '' }}>Harga Terendah</option>
                                <option value="price-high" {{ ($sortBy ?? '') == 'price-high' ? 'selected' : '' }}>Harga Tertinggi</option>
                                <option value="rating" {{ ($sortBy ?? '') == 'rating' ? 'selected' : '' }}>Rating Tertinggi</option>
                                <option value="name" {{ ($sortBy ?? '') == 'name' ? 'selected' : '' }}>Nama A-Z</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mt-6 pt-6 border-t border-gray-200">
                        <div class="flex flex-wrap gap-3">
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
                        <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-semibold rounded-xl transition-colors duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari & Terapkan Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Availability Info Banner - Show when date filter is active -->
            @if($bookingDate && $nightsCount)
            <div class="bg-gradient-to-r from-blue-50 to-primary-50 border border-blue-200 rounded-xl p-4 mb-6 shadow-sm">
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0 mt-0.5">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h4 class="text-sm font-semibold text-gray-900 mb-1">Menampilkan villa yang tersedia untuk tanggal yang dipilih</h4>
                        <p class="text-sm text-gray-700">
                            <span class="font-medium">Check-in:</span> {{ \Carbon\Carbon::parse($bookingDate)->format('d M Y') }} •
                            <span class="font-medium">Durasi:</span> {{ $nightsCount === '8+' ? '8+' : $nightsCount }} malam
                        </p>
                        <div class="flex flex-wrap gap-2 mt-3">
                            <span class="inline-flex items-center px-2.5 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-lg">
                                <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                                Banyak Unit
                            </span>
                            <span class="inline-flex items-center px-2.5 py-1 bg-orange-100 text-orange-800 text-xs font-medium rounded-lg">
                                <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                                </svg>
                                Hampir Penuh
                            </span>
                            <span class="inline-flex items-center px-2.5 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-lg">
                                <svg class="w-3.5 h-3.5 mr-1" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                </svg>
                                Habis
                            </span>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <a href="{{ route('produk.all', array_filter(['search' => $searchQuery, 'category' => $activeCategory, 'price_range' => $priceRange, 'capacity' => $capacity, 'rooms' => $rooms, 'attractions' => $attractions, 'sort' => $sortBy, 'promo' => $isPromo ? 'true' : null])) }}"
                           class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 font-medium">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Hapus Filter Tanggal
                        </a>
                    </div>
                </div>
            </div>
            @endif

            <div class="flex items-center justify-between flex-wrap gap-3 mb-6">
                <div>
                    <p class="text-sm sm:text-base text-gray-600">
                        @if($isPromo)
                            Menampilkan {{ $produks->firstItem() ?? 0 }} - {{ $produks->lastItem() ?? 0 }} dari {{ $produks->total() }} villa promo
                        @else
                            Menampilkan {{ $produks->firstItem() ?? 0 }} - {{ $produks->lastItem() ?? 0 }} dari {{ $produks->total() }} villa
                        @endif
                        @if($bookingDate && $nightsCount)
                            <span class="text-primary-600 font-medium">tersedia</span>
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
                    @php
                        $hasAvailabilityFilter = $bookingDate && $nightsCount;
                        $availabilityData = $hasAvailabilityFilter && isset($availability[$produk->id]) ? $availability[$produk->id] : null;

                        // Determine badge color based on available units
                        $badgeClass = 'bg-green-600'; // Default: tersedia
                        if ($availabilityData) {
                            $available = $availabilityData['available'];
                            if ($available == 0) {
                                $badgeClass = 'bg-red-600'; // Habis
                            } elseif ($available <= 2) {
                                $badgeClass = 'bg-orange-600'; // Hampir penuh (1-2 unit)
                            } elseif ($availabilityData['percentage'] <= 30) {
                                $badgeClass = 'bg-orange-600'; // Hampir penuh (< 30%)
                            }
                        }

                        $badgeText = $availabilityData
                            ? ($availabilityData['available'] > 0
                                ? 'Tersedia ' . $availabilityData['available'] . ' unit'
                                : 'Habis')
                            : 'Tersedia';
                    @endphp
                    <x-villa-card
                        :villa="$produk"
                        :showAvailabilityStatus="$hasAvailabilityFilter"
                        :availabilityText="$badgeText"
                        :availabilityClass="$badgeClass"
                        :availableUnits="$availabilityData ? $availabilityData['available'] : $produk->unit"
                    />
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

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Advanced Filter Toggle (Mobile)
        const toggleAdvancedFilterMobile = document.getElementById('toggleAdvancedFilterMobile');
        const advancedFilterContentMobile = document.getElementById('advancedFilterContentMobile');
        const filterToggleTextMobile = document.getElementById('filterToggleTextMobile');
        const filterToggleIconMobile = document.getElementById('filterToggleIconMobile');

        if (toggleAdvancedFilterMobile && advancedFilterContentMobile) {
            // Hide filter on mobile by default
            if (window.innerWidth < 1024) {
                advancedFilterContentMobile.style.display = 'none';
            }

            toggleAdvancedFilterMobile.addEventListener('click', function() {
                const isHidden = advancedFilterContentMobile.style.display === 'none';
                advancedFilterContentMobile.style.display = isHidden ? 'grid' : 'none';

                if (filterToggleTextMobile) {
                    filterToggleTextMobile.textContent = isHidden ? 'Sembunyikan Filter' : 'Tampilkan Filter';
                }

                if (filterToggleIconMobile) {
                    filterToggleIconMobile.classList.toggle('rotate-180', isHidden);
                }
            });
        }
    });
    </script>
</x-app-landing-layout>
