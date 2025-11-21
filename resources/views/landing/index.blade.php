<x-app-landing-layout>
    <!-- Hero Section dengan Promo Banner -->
    <section class="relative min-h-screen bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 text-white overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <!-- Floating Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
            <div class="absolute top-40 right-20 w-32 h-32 bg-white/5 rounded-full animate-float" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-20 left-1/4 w-16 h-16 bg-white/10 rounded-full animate-float" style="animation-delay: 2s;"></div>
        </div>

        <div class="relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 py-12 sm:py-16 lg:py-24 max-w-5xl">
            <!-- Hero Content - Centered with Max Width -->
            <div class="text-center space-y-6 lg:space-y-8 animate-fade-in-up mb-12 lg:mb-16">
                    {{-- <div class="inline-flex items-center space-x-2 bg-accent-500/20 backdrop-blur-sm px-4 py-2 sm:px-6 sm:py-3 rounded-full border border-accent-400/30">
                        <span class="relative flex h-3 w-3">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent-400 opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-3 w-3 bg-accent-500"></span>
                        </span>
                        <span class="text-accent-300 text-xs sm:text-sm font-medium">Promo Spesial Terbatas</span>
                    </div> --}}

                    <!-- Main Heading -->
                    <h1 class="text-3xl sm:text-4xl lg:text-5xl xl:text-7xl font-bold font-display leading-tight mb-4 lg:mb-6">
                        <span class="block text-white mb-1 lg:mb-2">Penginapan Mewah di</span>
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-accent-400 via-accent-300 to-accent-200 text-4xl sm:text-5xl lg:text-6xl xl:text-8xl pb-2 lg:pb-3">
                            Dieng
                        </span>
                    </h1>

                    <!-- Description -->
                    <p class="block text-base sm:text-lg lg:text-xl text-gray-300 leading-relaxed max-w-3xl mx-auto mb-6 lg:mb-8">
                        Nikmati pengalaman menginap tak terlupakan dengan pemandangan alam yang memukau dan fasilitas premium di kawasan wisata Dieng.
                    </p>

                    {{-- <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center mb-6 lg:mb-8">
                        <a href="#villas"
                           class="inline-flex items-center justify-center px-6 py-3 sm:px-8 sm:py-4 bg-accent-600 hover:bg-accent-700 text-white font-semibold rounded-full transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl text-sm sm:text-base">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Jelajahi Villa
                        </a>
                        <a href="tel:{{ $settings['contact_phone'] ?? '+6282162622680' }}"
                           class="inline-flex items-center justify-center px-6 py-3 sm:px-8 sm:py-4 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white font-semibold rounded-full transition-all duration-200 border border-white/20 text-sm sm:text-base">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Hubungi Kami
                        </a>
                    </div> --}}

                    {{-- <!-- Trust Indicators -->
                    <div class="grid grid-cols-3 gap-3 lg:gap-6 xl:gap-8">
                        <div class="text-center p-3 lg:p-4 bg-white/5 backdrop-blur-sm rounded-lg lg:rounded-xl border border-white/10">
                            <div class="text-2xl sm:text-3xl lg:text-4xl font-bold text-accent-400 mb-1">1,250+</div>
                            <div class="text-xs sm:text-sm text-gray-300">Tamu Puas</div>
                        </div>
                        <div class="text-center p-3 lg:p-4 bg-white/5 backdrop-blur-sm rounded-lg lg:rounded-xl border border-white/10">
                            <div class="text-2xl sm:text-3xl lg:text-4xl font-bold text-accent-400 mb-1">4.8/5</div>
                            <div class="text-xs sm:text-sm text-gray-300">Rating</div>
                        </div>
                        <div class="text-center p-3 lg:p-4 bg-white/5 backdrop-blur-sm rounded-lg lg:rounded-xl border border-white/10">
                            <div class="text-2xl sm:text-3xl lg:text-4xl font-bold text-accent-400 mb-1">5+</div>
                            <div class="text-xs sm:text-sm text-gray-300">Pengalaman (Tahun)</div>
                        </div>
                    </div> --}}
            </div>

            {{-- <!-- Hero Image with Slider - Full Width -->
            <div class="relative animate-fade-in-up mb-12 lg:mb-16" style="animation-delay: 0.4s;">
                    <div class="relative rounded-2xl lg:rounded-3xl overflow-hidden shadow-2xl border-2 border-white/10 max-w-4xl mx-auto">
                        <!-- Image Slider Container -->
                        <div class="relative w-full h-auto max-h-[60vh] lg:max-h-[80vh]" id="hero-slider">
                            <!-- Slide 1 -->
                            <div class="hero-slide relative">
                                <img src="{{ asset('assets/images/vhd.webp') }}"
                                     alt="Villa mewah di Dieng dengan pemandangan indah"
                                     class="w-full h-auto max-h-[60vh] lg:max-h-[80vh] object-cover">

                                <!-- Overlay Gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>

                                <!-- Floating Badge -->
                                <div class="absolute top-4 right-4 lg:top-6 lg:right-6 bg-gradient-to-r from-accent-600 to-accent-700 text-white px-3 py-2 lg:px-6 lg:py-3 rounded-full font-semibold animate-bounce-gentle shadow-lg">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343.895 3 2 3 .895 3 2-3 .895-3 2z"></path>
                                        </svg>
                                        <span class="text-sm lg:text-base">Diskon 30%</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 2 -->
                            <div class="hero-slide relative">
                                <img src="{{ asset('assets/images/vhd2.webp') }}"
                                     alt="Villa mewah di Dieng dengan fasilitas lengkap"
                                     class="w-full h-auto max-h-[60vh] lg:max-h-[80vh] object-cover">

                                <!-- Overlay Gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>

                                <!-- Floating Badge -->
                                <div class="absolute top-4 right-4 lg:top-6 lg:right-6 bg-gradient-to-r from-accent-600 to-accent-700 text-white px-3 py-2 lg:px-6 lg:py-3 rounded-full font-semibold animate-bounce-gentle shadow-lg">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343.895 3 2 3 .895 3 2-3 .895-3 2z"></path>
                                        </svg>
                                        <span class="text-sm lg:text-base">Fasilitas Lengkap</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Slide 3 -->
                            <div class="hero-slide relative">
                                <img src="{{ asset('assets/images/vhd3.webp') }}"
                                     alt="Villa mewah di Dieng dengan pemandangan sunrise"
                                     class="w-full h-auto max-h-[60vh] lg:max-h-[80vh] object-cover">

                                <!-- Overlay Gradient -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-black/30 to-transparent"></div>

                                <!-- Floating Badge -->
                                <div class="absolute top-4 right-4 lg:top-6 lg:right-6 bg-gradient-to-r from-accent-600 to-accent-700 text-white px-3 py-2 lg:px-6 lg:py-3 rounded-full font-semibold animate-bounce-gentle shadow-lg">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-1 lg:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343.895 3 2 3 .895 3 2-3 .895-3 2z"></path>
                                        </svg>
                                        <span class="text-sm lg:text-base">Pemandangan Sunrise</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Slider Controls -->
                        <button id="prev-slide" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-white/80 backdrop-blur-sm text-gray-800 p-2 rounded-full shadow-lg hover:bg-white transition-colors duration-200 z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 lg:w-5 lg:h-5" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M15.2071 6.29289C15.5976 6.68342 15.5976 7.31658 15.2071 7.70711L10.9142 12L15.2071 16.2929C15.5976 16.6834 15.5976 17.3166 15.2071 17.7071C14.8166 18.0976 14.1834 18.0976 13.7929 17.7071L8.79289 12.7071C8.40237 12.3166 8.40237 11.6834 8.79289 11.2929L13.7929 6.29289C14.1834 5.90237 14.8166 5.90237 15.2071 6.29289Z" fill="#000000"/>
                            </svg>
                        </button>
                        <button id="next-slide" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-white/80 backdrop-blur-sm text-gray-800 p-2 rounded-full shadow-lg hover:bg-white transition-colors duration-200 z-10">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 lg:w-5 lg:h-5" viewBox="0 0 24 24" fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8.79289 6.29289C9.18342 5.90237 9.81658 5.90237 10.2071 6.29289L15.2071 11.2929C15.5976 11.6834 15.5976 12.3166 15.2071 12.7071L10.2071 17.7071C9.81658 18.0976 9.18342 18.0976 8.79289 17.7071C8.40237 17.3166 8.40237 16.6834 8.79289 16.2929L13.0858 12L8.79289 7.70711C8.40237 7.31658 8.40237 6.68342 8.79289 6.29289Z" fill="#000000"/>
                            </svg>
                        </button>

                        <!-- Image Gallery Indicators -->
                        <div class="absolute bottom-3 left-3 lg:bottom-4 lg:left-4 flex gap-2 z-10">
                            <button class="slider-dot w-2 h-2 bg-white rounded-full transition-all duration-200" data-slide="0"></button>
                            <button class="slider-dot w-2 h-2 bg-white/50 rounded-full transition-all duration-200" data-slide="1"></button>
                            <button class="slider-dot w-2 h-2 bg-white/50 rounded-full transition-all duration-200" data-slide="2"></button>
                        </div>
                    </div>
                </div>
            </div> --}}

            <!-- Booking Search Section -->
            <div class="relative z-10 animate-fade-in-up" style="animation-delay: 0.8s;">
                <div class="bg-white/10 backdrop-blur-md rounded-2xl lg:rounded-3xl p-6 lg:p-8 border border-white/20 shadow-2xl mx-auto hero-search-form">
                    <div class="text-center mb-6 lg:mb-8">
                        <h3 class="text-xl lg:text-2xl font-bold text-white mb-2">Cari Penginapan Impian Anda</h3>

                        <!-- Category and Promo Buttons -->
                        <div class="relative z-10 mt-4 lg:mt-6">
                            <div class="flex flex-wrap justify-center gap-3 lg:gap-4">
                                <!-- Category Buttons -->
                                @if($categories->count() > 0)
                                    @foreach ($categories as $category)
                                    <a href="{{ route('produk.all', ['category' => $category->slug]) }}"
                                    class="inline-flex items-center px-4 py-2.5 lg:px-6 lg:py-3 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white font-medium rounded-full transition-all duration-200 border border-white/20 text-sm lg:text-base transform hover:scale-105">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        {{ $category->name }}
                                    </a>
                                    @endforeach
                                @endif

                                <!-- Promo Button -->
                                <a href="{{ route('produk.all', ['promo' => 'true']) }}"
                                class="inline-flex items-center px-4 py-2.5 lg:px-6 lg:py-3 bg-gradient-to-r from-red-600 to-pink-600 hover:from-red-700 hover:to-pink-700 text-white font-semibold rounded-full transition-all duration-200 border-0 text-sm lg:text-base transform hover:scale-105 shadow-lg hover:shadow-xl animate-pulse-gentle">
                                    <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-3 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Promo Spesial
                                </a>
                            </div>
                        </div>

                        <p class="text-gray-300 text-sm lg:text-base mt-4 lg:mt-6">Pilih tanggal booking dan durasi menginap untuk menemukan penginapan yang tersedia</p>
                    </div>

                    <form id="heroSearchForm" class="space-y-4 lg:space-y-6">
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 lg:gap-6">
                            <!-- Tanggal Booking -->
                            <div class="lg:col-span-1">
                                <label for="bookingDate" class="block text-sm font-medium text-white mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    Tanggal Booking
                                </label>
                                <input type="text"
                                       id="bookingDate"
                                       name="booking_date"
                                       class="w-full px-4 py-3 lg:py-4 text-gray-900 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 text-sm lg:text-base placeholder-gray-500 hero-search-input"
                                       placeholder="Pilih tanggal booking"
                                       readonly>
                            </div>

                            <!-- Nights Selection -->
                            <div class="lg:col-span-1">
                                <label for="nightsCount" class="block text-sm font-medium text-white mb-2">
                                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Jumlah Malam
                                </label>
                                <select id="nightsCount"
                                        name="nights_count"
                                        class="w-full px-4 py-3 lg:py-4 text-gray-900 bg-white border border-gray-300 rounded-xl focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200 text-sm lg:text-base hero-search-input">
                                    <option value="">Pilih jumlah malam</option>
                                    <option value="1">1 Malam</option>
                                    <option value="2">2 Malam</option>
                                    <option value="3">3 Malam</option>
                                    <option value="4">4 Malam</option>
                                    <option value="5">5 Malam</option>
                                    <option value="6">6 Malam</option>
                                    <option value="7">7 Malam</option>
                                    <option value="8+">8+ Malam</option>
                                </select>
                            </div>
                        </div>

                        <!-- Search Button -->
                        <div class="flex justify-center mt-5">
                            <button type="submit"
                                    id="searchVillasBtn"
                                    class="inline-flex items-center justify-center px-8 py-4 lg:px-12 lg:py-5 bg-gradient-to-r from-accent-600 to-accent-700 hover:from-accent-700 hover:to-accent-800 text-white font-semibold rounded-xl transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl text-base lg:text-lg disabled:opacity-50 disabled:cursor-not-allowed disabled:transform-none hero-search-button">
                                <svg class="w-5 h-5 lg:w-6 lg:h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Cari Penginapan Sekarang
                            </button>
                        </div>
                    </form>

                    <!-- Advanced Filter Section -->
                    <div class="mt-6 lg:mt-8">
                        <div class="flex items-center justify-center mb-4">
                            <button id="toggleAdvancedFilter" class="inline-flex items-center text-white/90 hover:text-white font-medium text-sm lg:text-base transition-colors duration-200">
                                <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                                </svg>
                                <span id="advancedFilterToggleText">Permudah pencarian dengan filter</span>
                                <svg class="w-4 h-4 lg:w-5 lg:h-5 ml-2 transform transition-transform" id="advancedFilterToggleIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                        </div>

                        <div id="advancedFilterContent" class="overflow-hidden transition-all duration-300" style="max-height: 0; opacity: 0;">
                            <div class="bg-white/5 backdrop-blur-sm rounded-xl lg:rounded-2xl p-4 lg:p-6 border border-white/10">
                                <h4 class="text-white font-medium mb-4 lg:mb-6 text-center">Filter Pencarian</h4>

                                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                                    <!-- Price Range Filter -->
                                    <div>
                                        <label for="priceRangeFilter" class="block text-sm font-medium text-white/90 mb-2">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-3 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            Rentang Harga
                                        </label>
                                        <select id="priceRangeFilter" name="price_range" class="w-full px-3 py-2.5 lg:py-3 text-sm text-gray-900 bg-white/90 backdrop-blur-sm border border-white/20 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200">
                                            <option value="">Semua Harga</option>
                                            <option value="0-500000">Rp 0 - 500.000</option>
                                            <option value="500000-1000000">Rp 500.000 - 1.000.000</option>
                                            <option value="1000000-2000000">Rp 1.000.000 - 2.000.000</option>
                                            <option value="2000000+">Di atas Rp 2.000.000</option>
                                        </select>
                                    </div>

                                    <!-- Capacity Filter -->
                                    <div>
                                        <label for="capacityFilter" class="block text-sm font-medium text-white/90 mb-2">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                            </svg>
                                            Kapasitas
                                        </label>
                                        <select id="capacityFilter" name="capacity" class="w-full px-3 py-2.5 lg:py-3 text-sm text-gray-900 bg-white/90 backdrop-blur-sm border border-white/20 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200">
                                            <option value="">Semua Kapasitas</option>
                                            <option value="1-2">1-2 Orang</option>
                                            <option value="3-4">3-4 Orang</option>
                                            <option value="5-8">5-8 Orang</option>
                                            <option value="9+">9+ Orang</option>
                                        </select>
                                    </div>

                                    <!-- Rooms Filter -->
                                    <div>
                                        <label for="roomsFilter" class="block text-sm font-medium text-white/90 mb-2">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                            Jumlah Kamar
                                        </label>
                                        <select id="roomsFilter" name="rooms" class="w-full px-3 py-2.5 lg:py-3 text-sm text-gray-900 bg-white/90 backdrop-blur-sm border border-white/20 rounded-lg focus:ring-2 focus:ring-accent-500 focus:border-accent-500 transition-all duration-200">
                                            <option value="">Semua Kamar</option>
                                            <option value="1">1 Kamar</option>
                                            <option value="2">2 Kamar</option>
                                            <option value="3">3 Kamar</option>
                                            <option value="4+">4+ Kamar</option>
                                        </select>
                                    </div>

                                    <!-- Near Attractions Filter -->
                                    <div>
                                        <label for="attractionsFilter" class="block text-sm font-medium text-white/90 mb-2">
                                            <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            Dekat Wisata
                                        </label>
                                        <select id="attractionsFilter" name="attractions" class="w-full px-3 py-2.5 lg:py-3 text-sm text-gray-900 bg-white/90 backdrop-blur-sm border border-white/20 rounded-lg focus:ring-2 ring:ring-accent-500 focus:border-accent-500 transition-all duration-200">
                                            <option value="">Semua Lokasi</option>
                                            @foreach($wisataList as $wisata)
                                                <option value="{{ Str::slug($wisata) }}">{{ $wisata }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="flex flex-col sm:flex-row gap-3 mt-6">
                                    <button type="button" id="applyAdvancedFilter" class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 bg-accent-600 hover:bg-accent-700 text-white font-medium rounded-lg transition-all duration-200 text-sm">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                        Terapkan Filter
                                    </button>
                                    <button type="button" id="resetAdvancedFilter" class="flex-1 sm:flex-none inline-flex items-center justify-center px-6 py-3 bg-white/10 hover:bg-white/20 text-white font-medium rounded-lg transition-all duration-200 text-sm border border-white/20">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                        </svg>
                                        Reset
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main id="main-content" role="main" class="bg-gray-50 mx-auto">
        <!-- Popular Villas Section -->
        <x-popular-villas :villas="$popularVillas" />

        <!-- Best Villas Section -->
        <x-best-villas :villas="$bestVillas" />

        <!-- All Villas Section with Enhanced Design -->
        <section class="py-16 lg:py-24 bg-white" id="villas" aria-labelledby="all-villas-heading">
            <div class="mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                <header class="text-center mb-12">
                    <div class="inline-flex items-center space-x-2 bg-primary-100 text-primary-800 px-4 py-2 rounded-full mb-4">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span class="text-sm font-medium">Semua Villa Tersedia</span>
                    </div>

                    <h2 id="all-villas-heading" class="text-3xl lg:text-4xl font-bold font-display text-gray-900 mb-4">
                        Temukan Villa Impian Anda
                    </h2>

                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Jelajahi koleksi lengkap villa kami untuk liburan tak terlupakan di Dieng
                    </p>

                    <div class="w-24 h-1 bg-gradient-to-r from-primary-600 to-accent-600 mx-auto mt-6 rounded-full"></div>
                </header>

                <!-- Advanced Filter Section -->
                <div class="bg-gray-50 rounded-xl lg:rounded-2xl p-4 sm:p-6 mb-6 lg:mb-8 max-w-4xl mx-auto">
                    <div class="flex items-center justify-between mb-4 lg:mb-6">
                        <h3 class="text-base lg:text-lg font-semibold text-gray-900 flex items-center">
                            <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Filter Pencarian
                        </h3>
                        <button class="lg:hidden flex items-center text-primary-600 hover:text-primary-700 font-medium" id="toggleFilter">
                            <span id="filterToggleText">Tampilkan Filter</span>
                            <svg class="w-5 h-5 ml-2 transform transition-transform" id="filterToggleIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 lg:gap-4" id="filterContent">
                        <div>
                            <label for="priceRange" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 lg:mb-2">Rentang Harga</label>
                            <select class="w-full px-3 py-2 lg:px-4 lg:py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200" id="priceRange">
                                <option value="">Semua Harga</option>
                                <option value="0-500000">Rp 0 - 500.000</option>
                                <option value="500000-1000000">Rp 500.000 - 1.000.000</option>
                                <option value="1000000-2000000">Rp 1.000.000 - 2.000.000</option>
                                <option value="2000000+">Di atas Rp 2.000.000</option>
                            </select>
                        </div>

                        <div>
                            <label for="guestCount" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 lg:mb-2">Jumlah Tamu</label>
                            <select class="w-full px-3 py-2 lg:px-4 lg:py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200" id="guestCount">
                                <option value="">Semua Kapasitas</option>
                                <option value="1-2">1-2 Orang</option>
                                <option value="3-4">3-4 Orang</option>
                                <option value="5-8">5-8 Orang</option>
                                <option value="9+">9+ Orang</option>
                            </select>
                        </div>

                        <div>
                            <label for="roomCount" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 lg:mb-2">Jumlah Kamar</label>
                            <select class="w-full px-3 py-2 lg:px-4 lg:py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200" id="roomCount">
                                <option value="">Semua Kamar</option>
                                <option value="1">1 Kamar</option>
                                <option value="2">2 Kamar</option>
                                <option value="3">3 Kamar</option>
                                <option value="4+">4+ Kamar</option>
                            </select>
                        </div>

                        <div>
                            <label for="sortBy" class="block text-xs sm:text-sm font-medium text-gray-700 mb-1 lg:mb-2">Urutkan</label>
                            <select class="w-full px-3 py-2 lg:px-4 lg:py-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200" id="sortBy">
                                <option value="relevance">Relevansi</option>
                                <option value="price-low">Harga Terendah</option>
                                <option value="price-high">Harga Tertinggi</option>
                                <option value="rating">Rating Tertinggi</option>
                                <option value="name">Nama A-Z</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col sm:flex-row gap-2 lg:gap-3 mt-4 lg:mt-6">
                        <button class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2 lg:px-6 lg:py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors duration-200 text-sm" id="applyFilter">
                            <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Terapkan Filter
                        </button>
                        <button class="flex-1 sm:flex-none inline-flex items-center justify-center px-4 py-2 lg:px-6 lg:py-3 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium rounded-lg transition-colors duration-200 text-sm" id="resetFilter">
                            <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Reset
                        </button>
                    </div>
                </div>

                <!-- Category Tabs -->
                @if($categories->count() > 0)
                <div class="mb-6 lg:mb-8 max-w-4xl mx-auto">
                    <div class="flex flex-wrap justify-center gap-2" role="tablist">
                        @foreach ($categories as $category)
                        <a href="{{ route('index', ['category' => $category->slug]) }}"
                           class="inline-flex items-center px-3 py-2 sm:px-4 sm:py-2.5 lg:px-6 lg:py-3 rounded-full text-sm sm:text-base font-medium transition-all duration-200 {{ $activeCategory === $category->slug ? 'bg-primary-600 text-white shadow-lg' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                           role="tab"
                           aria-selected="{{ $activeCategory === $category->slug ? 'true' : 'false' }}"
                           aria-controls="category-{{ $category->slug }}">
                            {{ $category->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Villa Grid -->
                <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 md:gap-4 lg:gap-6 max-w-4xl mx-auto px-2 md:px-0" id="villaGrid">
                    @forelse ($produks as $produk)
                    <x-villa-card :villa="$produk" :availableUnits="$produk->unit" />
                    @empty
                        <div class="col-span-full">
                            <div class="text-center py-16">
                                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada penginapan yang ditemukan</h3>
                                <p class="text-gray-600 mb-6">Coba ubah filter atau kata kunci pencarian Anda</p>
                                <button class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors duration-200" onclick="resetAllFilters()">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Reset Filter
                                </button>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Enhanced Pagination -->
                @if ($produks->lastPage() > 1)
                <nav aria-label="Villa pagination" class="mt-12">
                    <div class="flex items-center justify-center space-x-2">
                        <!-- Previous -->
                        @if(!$produks->onFirstPage())
                        <a href="{{ $produks->previousPageUrl() }}"
                           class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 text-gray-700 hover:bg-primary-600 hover:text-white hover:border-primary-600 transition-colors duration-200"
                           aria-label="Previous page">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </a>
                        @else
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 text-gray-400 cursor-not-allowed">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                            </svg>
                        </span>
                        @endif

                        <!-- Page Numbers -->
                        @for ($i = 1; $i <= $produks->lastPage(); $i++)
                        @if($i == $produks->currentPage())
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg bg-primary-600 text-white font-medium">
                            {{ $i }}
                        </span>
                        @elseif(abs($i - $produks->currentPage()) <= 2 || $i == 1 || $i == $produks->lastPage())
                        <a href="{{ $produks->url($i) }}"
                           class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 text-gray-700 hover:bg-primary-600 hover:text-white hover:border-primary-600 transition-colors duration-200"
                           aria-label="Go to page {{ $i }}">
                            {{ $i }}
                        </a>
                        @elseif(abs($i - $produks->currentPage()) == 3)
                        <span class="flex items-center justify-center w-10 h-10 text-gray-400">...</span>
                        @endif
                        @endfor

                        <!-- Next -->
                        @if($produks->hasMorePages())
                        <a href="{{ $produks->nextPageUrl() }}"
                           class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-300 text-gray-700 hover:bg-primary-600 hover:text-white hover:border-primary-600 transition-colors duration-200"
                           aria-label="Next page">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                        @else
                        <span class="flex items-center justify-center w-10 h-10 rounded-lg border border-gray-200 text-gray-400 cursor-not-allowed">
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

        <!-- Testimonials Section -->
        <x-testimonials :testimonials="$testimonials" />
    </main>

    <!-- Install App Button -->
    <div id="installBtn" style="display: none;" role="button" tabindex="0" aria-label="Install application">
        <button class="fixed bottom-6 right-6 w-14 h-14 bg-primary-600 hover:bg-primary-700 text-white rounded-full shadow-lg hover:shadow-xl transform hover:scale-110 transition-all duration-200 flex items-center justify-center z-50">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
            </svg>
        </button>
    </div>

    <!-- Quick View Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <div class="flex items-center justify-between p-6 border-b">
                    <h3 class="text-xl font-semibold text-gray-900" id="quickViewModalLabel">Quick View Villa</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors duration-200" onclick="closeQuickView()" aria-label="Close">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
                <div class="p-6">
                    <!-- Content will be loaded dynamically -->
                    <div class="text-center py-8">
                        <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600" role="status">
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@push('js')
<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/themes/airbnb.css">

<style>
/* Custom styles for hero search form */
.hero-search-form {
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}

.hero-search-input {
    transition: all 0.3s ease;
}

.hero-search-input:focus {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px -5px rgba(0, 0, 0, 0.1);
}

.hero-search-button {
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
}

.hero-search-button::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
    transition: left 0.5s;
}

.hero-search-button:hover::before {
    left: 100%;
}

/* Flatpickr customizations */
.flatpickr-calendar {
    border-radius: 12px;
    box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
    border: none;
}

.flatpickr-day.selected {
    background: linear-gradient(135deg, #f59e0b, #f97316) !important;
    border-color: #f97316 !important;
}

.flatpickr-day.startRange,
.flatpickr-day.endRange {
    background: linear-gradient(135deg, #f59e0b, #f97316) !important;
    border-color: #f97316 !important;
}

.flatpickr-day.inRange {
    background: rgba(245, 158, 11, 0.1) !important;
    border-color: rgba(245, 158, 11, 0.2) !important;
}

/* Warning message animation */
@keyframes slideInUp {
    from {
        transform: translateY(20px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

.animate-fade-in-up {
    animation: slideInUp 0.5s ease-out;
}

/* Mobile optimizations */
@media (max-width: 768px) {
    .hero-search-form {
        margin: 0 16px;
        border-radius: 16px;
    }

    .hero-search-input {
        font-size: 16px; /* Prevent zoom on iOS */
        padding: 16px;
    }

    .flatpickr-calendar {
        font-size: 14px;
    }
}

/* Touch-friendly improvements */
@media (hover: none) and (pointer: coarse) {
    .hero-search-input {
        min-height: 48px;
    }

    .hero-search-button {
        min-height: 48px;
        padding: 12px 24px;
    }
}

/* Loading state */
.hero-search-loading {
    position: relative;
    color: transparent !important;
}

.hero-search-loading::after {
    content: '';
    position: absolute;
    width: 20px;
    height: 20px;
    top: 50%;
    left: 50%;
    margin-left: -10px;
    margin-top: -10px;
    border: 2px solid #ffffff;
    border-radius: 50%;
    border-top-color: transparent;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Gentle pulse animation for promo button */
@keyframes pulse-gentle {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.8;
    }
}

.animate-pulse-gentle {
    animation: pulse-gentle 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}

/* Villa Card Mobile Optimizations (< 768px) */
@media (max-width: 767px) {
    /* Adjust villa card content padding for 2-column layout */
    #villaGrid article > div:last-child {
        padding: 0.75rem !important; /* Reduce from p-4 (1rem) to 0.75rem */
    }

    /* Reduce image height slightly on mobile */
    #villaGrid article .relative.overflow-hidden {
        height: 10rem !important; /* 160px instead of 192px (h-48) */
    }

    /* Optimize title font size */
    #villaGrid article h3 {
        font-size: 0.875rem; /* text-sm instead of text-base */
        line-height: 1.25rem;
        margin-bottom: 0.5rem;
    }

    /* Reduce rating icon size */
    #villaGrid article .flex.text-yellow-400 svg {
        width: 0.875rem; /* 14px instead of 16px */
        height: 0.875rem;
    }

    /* Optimize facility icons and text */
    #villaGrid article .flex.items-center.gap-4 {
        gap: 0.5rem;
        font-size: 0.75rem; /* text-xs */
    }

    #villaGrid article .flex.items-center.gap-4 svg {
        width: 0.875rem;
        height: 0.875rem;
    }

    /* Reduce unit info text size */
    #villaGrid article .text-sm {
        font-size: 0.75rem; /* text-xs */
    }

    #villaGrid article .text-sm svg {
        width: 0.875rem;
        height: 0.875rem;
    }

    /* Optimize price section */
    #villaGrid article .text-lg {
        font-size: 1rem; /* text-base instead of text-lg */
    }

    #villaGrid article .text-xs {
        font-size: 0.625rem; /* smaller text-xs */
        line-height: 1rem;
    }

    /* Optimize button */
    #villaGrid article a[href*="/produk/"] {
        padding: 0.5rem 0.75rem;
        font-size: 0.75rem; /* text-xs */
    }

    /* Reduce badge sizes */
    #villaGrid article .absolute.top-2.left-2 span {
        padding: 0.25rem 0.5rem;
        font-size: 0.625rem;
    }

    #villaGrid article .absolute.top-2.left-2 svg {
        width: 0.625rem;
        height: 0.625rem;
        margin-right: 0.25rem;
    }

    /* Adjust divider margin */
    #villaGrid article .border-t {
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
    }

    /* Reduce spacing between elements */
    #villaGrid article .mb-3 {
        margin-bottom: 0.5rem;
    }

    /* Ensure text doesn't overflow */
    #villaGrid article p,
    #villaGrid article span {
        word-wrap: break-word;
        overflow-wrap: break-word;
    }
}

/* Best Villas Section Mobile Optimizations (< 768px) */
@media (max-width: 767px) {
    /* Adjust best-villas card padding */
    section[aria-labelledby="best-villas-heading"] .group.relative > div:last-child article > div:last-child {
        padding: 0.75rem !important;
    }

    /* Reduce image height for best-villas */
    section[aria-labelledby="best-villas-heading"] .group.relative article .relative.overflow-hidden {
        height: 12rem !important; /* 192px instead of 320px (h-80) */
    }

    /* Optimize header card with badges */
    section[aria-labelledby="best-villas-heading"] .group.relative > div:first-child {
        padding: 0.75rem !important;
    }

    section[aria-labelledby="best-villas-heading"] .group.relative > div:first-child span {
        padding: 0.375rem 0.625rem !important;
        font-size: 0.625rem !important;
    }

    section[aria-labelledby="best-villas-heading"] .group.relative > div:first-child svg {
        width: 0.75rem !important;
        height: 0.75rem !important;
    }

    section[aria-labelledby="best-villas-heading"] .group.relative > div:first-child button {
        width: 1.75rem !important;
        height: 1.75rem !important;
    }

    section[aria-labelledby="best-villas-heading"] .group.relative > div:first-child button svg {
        width: 0.875rem !important;
        height: 0.875rem !important;
    }

    /* Optimize thumbnail gallery overlay */
    section[aria-labelledby="best-villas-heading"] .group.relative .absolute.top-28.right-4 > div {
        width: 2rem !important;
        height: 2rem !important;
    }

    /* Optimize premium features section */
    section[aria-labelledby="best-villas-heading"] .group.relative .bg-white.rounded-b-3xl {
        padding: 0.75rem !important;
    }

    /* Optimize text sizes in best-villas */
    section[aria-labelledby="best-villas-heading"] article h3 {
        font-size: 0.875rem !important;
        line-height: 1.25rem !important;
    }

    section[aria-labelledby="best-villas-heading"] article .text-lg {
        font-size: 1rem !important;
    }

    section[aria-labelledby="best-villas-heading"] article .text-sm {
        font-size: 0.75rem !important;
    }

    /* Optimize buttons in premium features */
    section[aria-labelledby="best-villas-heading"] .bg-white.rounded-b-3xl a {
        padding: 0.5rem 0.75rem !important;
        font-size: 0.75rem !important;
    }

    section[aria-labelledby="best-villas-heading"] .bg-white.rounded-b-3xl svg {
        width: 0.875rem !important;
        height: 0.875rem !important;
    }
}

/* Popular Villas Carousel Mobile Optimizations (< 768px) */
@media (max-width: 767px) {
    /* Set carousel cell width to display 2 cards */
    .popular-villas-carousel .carousel-cell {
        width: calc(50% - 0.25rem) !important;
    }

    /* Adjust popular-villas card padding */
    .popular-villas-carousel .carousel-cell article > div:last-child {
        padding: 0.75rem !important;
    }

    /* Reduce image height for popular-villas */
    .popular-villas-carousel .carousel-cell article .relative.overflow-hidden {
        height: 10rem !important; /* 160px instead of 192px (h-48) */
    }

    /* Optimize text sizes in popular-villas */
    .popular-villas-carousel .carousel-cell article h3 {
        font-size: 0.875rem !important;
        line-height: 1.25rem !important;
    }

    .popular-villas-carousel .carousel-cell article .text-lg {
        font-size: 1rem !important;
    }

    .popular-villas-carousel .carousel-cell article .text-sm {
        font-size: 0.75rem !important;
    }

    .popular-villas-carousel .carousel-cell article .text-xs {
        font-size: 0.625rem !important;
    }

    /* Reduce badge sizes */
    .popular-villas-carousel .carousel-cell article .absolute.top-2.left-2 span {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.625rem !important;
    }

    .popular-villas-carousel .carousel-cell article .absolute.top-2.left-2 svg {
        width: 0.625rem !important;
        height: 0.625rem !important;
        margin-right: 0.25rem !important;
    }

    /* Optimize button */
    .popular-villas-carousel .carousel-cell article a[href*="/produk/"] {
        padding: 0.5rem 0.75rem !important;
        font-size: 0.75rem !important;
    }

    /* Reduce spacing */
    .popular-villas-carousel .carousel-cell article .mb-3 {
        margin-bottom: 0.5rem !important;
    }

    .popular-villas-carousel .carousel-cell article .border-t {
        margin-top: 0.5rem !important;
        margin-bottom: 0.5rem !important;
    }
}

/* Best Villas Carousel Mobile Optimizations (< 768px) */
@media (max-width: 767px) {
    /* Set carousel cell width to display 2 cards */
    .best-villas-carousel .carousel-cell {
        width: calc(50% - 0.25rem) !important;
    }

    /* Adjust best-villas card padding */
    .best-villas-carousel .carousel-cell article > div:last-child {
        padding: 0.75rem !important;
    }

    /* Reduce image height for best-villas */
    .best-villas-carousel .carousel-cell article .relative.overflow-hidden {
        height: 10rem !important; /* 160px instead of 192px (h-48) */
    }

    /* Optimize text sizes in best-villas */
    .best-villas-carousel .carousel-cell article h3 {
        font-size: 0.875rem !important;
        line-height: 1.25rem !important;
    }

    .best-villas-carousel .carousel-cell article .text-lg {
        font-size: 1rem !important;
    }

    .best-villas-carousel .carousel-cell article .text-sm {
        font-size: 0.75rem !important;
    }

    .best-villas-carousel .carousel-cell article .text-xs {
        font-size: 0.625rem !important;
    }

    /* Reduce badge sizes */
    .best-villas-carousel .carousel-cell article .absolute.top-2.left-2 span {
        padding: 0.25rem 0.5rem !important;
        font-size: 0.625rem !important;
    }

    .best-villas-carousel .carousel-cell article .absolute.top-2.left-2 svg {
        width: 0.625rem !important;
        height: 0.625rem !important;
        margin-right: 0.25rem !important;
    }

    /* Optimize button */
    .best-villas-carousel .carousel-cell article a[href*="/produk/"] {
        padding: 0.5rem 0.75rem !important;
        font-size: 0.75rem !important;
    }

    /* Reduce spacing */
    .best-villas-carousel .carousel-cell article .mb-3 {
        margin-bottom: 0.5rem !important;
    }

    .best-villas-carousel .carousel-cell article .border-t {
        margin-top: 0.5rem !important;
        margin-bottom: 0.5rem !important;
    }
}
</style>

<script>
// Enhanced JavaScript for Modern Landing Page
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Date Picker with Flatpickr
    initializeDatePicker();

    // Initialize Search Form
    initializeSearchForm();

    // Hero Slider Implementation
    const heroSlider = {
        currentSlide: 0,
        slides: document.querySelectorAll('.hero-slide'),
        dots: document.querySelectorAll('.slider-dot'),
        prevBtn: document.getElementById('prev-slide'),
        nextBtn: document.getElementById('next-slide'),
        slideInterval: null,

        init() {
            if (this.slides.length > 0) {
                // Set initial display for all slides
                this.slides.forEach((slide, index) => {
                    slide.style.display = index === 0 ? 'block' : 'none';
                });
                this.setupEventListeners();
                this.startAutoSlide();
            }
        },

        setupEventListeners() {
            // Previous button
            if (this.prevBtn) {
                this.prevBtn.addEventListener('click', () => this.prevSlide());
            }

            // Next button
            if (this.nextBtn) {
                this.nextBtn.addEventListener('click', () => this.nextSlide());
            }

            // Dot indicators
            this.dots.forEach((dot, index) => {
                dot.addEventListener('click', () => this.goToSlide(index));
            });

            // Pause on hover
            const sliderContainer = document.getElementById('hero-slider');
            if (sliderContainer) {
                sliderContainer.addEventListener('mouseenter', () => this.stopAutoSlide());
                sliderContainer.addEventListener('mouseleave', () => this.startAutoSlide());
            }
        },

        showSlide(index) {
            // Hide all slides
            this.slides.forEach(slide => slide.style.display = 'none');

            // Show current slide
            if (this.slides[index]) {
                this.slides[index].style.display = 'block';
            }

            // Update dots
            this.dots.forEach((dot, i) => {
                if (i === index) {
                    dot.classList.remove('bg-white/50');
                    dot.classList.add('bg-white');
                } else {
                    dot.classList.remove('bg-white');
                    dot.classList.add('bg-white/50');
                }
            });

            this.currentSlide = index;
        },

        nextSlide() {
            const nextIndex = (this.currentSlide + 1) % this.slides.length;
            this.showSlide(nextIndex);
        },

        prevSlide() {
            const prevIndex = (this.currentSlide - 1 + this.slides.length) % this.slides.length;
            this.showSlide(prevIndex);
        },

        goToSlide(index) {
            this.showSlide(index);
        },

        startAutoSlide() {
            this.stopAutoSlide();
            this.slideInterval = setInterval(() => this.nextSlide(), 5000);
        },

        stopAutoSlide() {
            if (this.slideInterval) {
                clearInterval(this.slideInterval);
            }
        }
    };

    // Initialize hero slider
    heroSlider.init();

    // Lazy Loading Implementation with Intersection Observer
    const lazyImages = document.querySelectorAll('.lazy-load');

    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy-load');
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.01
        });

        lazyImages.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback for older browsers
        lazyImages.forEach(img => {
            img.src = img.dataset.src;
            img.classList.remove('lazy-load');
            img.classList.add('loaded');
        });
    }

    // Smooth Scroll Implementation
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });

    // Advanced Filter Toggle (Mobile)
    const toggleFilter = document.getElementById('toggleFilter');
    const filterContent = document.getElementById('filterContent');
    const filterToggleText = document.getElementById('filterToggleText');
    const filterToggleIcon = document.getElementById('filterToggleIcon');

    if (toggleFilter && filterContent) {
        // Hide filter on mobile by default
        if (window.innerWidth < 1024) {
            filterContent.style.display = 'none';
        }

        toggleFilter.addEventListener('click', function() {
            const isHidden = filterContent.style.display === 'none';
            filterContent.style.display = isHidden ? 'grid' : 'none';

            if (filterToggleText) {
                filterToggleText.textContent = isHidden ? 'Sembunyikan Filter' : 'Tampilkan Filter';
            }

            if (filterToggleIcon) {
                filterToggleIcon.classList.toggle('rotate-180', isHidden);
            }
        });
    }

    // Apply Filter Function
    const applyFilter = document.getElementById('applyFilter');
    if (applyFilter) {
        applyFilter.addEventListener('click', function() {
            const priceRange = document.getElementById('priceRange').value;
            const guestCount = document.getElementById('guestCount').value;
            const roomCount = document.getElementById('roomCount').value;
            const sortBy = document.getElementById('sortBy').value;

            // Build URL with filters
            const params = new URLSearchParams(window.location.search);
            if (priceRange) params.set('price', priceRange);
            if (guestCount) params.set('guests', guestCount);
            if (roomCount) params.set('rooms', roomCount);
            if (sortBy) params.set('sort', sortBy);

            // Show loading state
            applyFilter.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" /></path>
                </svg>
                Mencari...
            `;
            applyFilter.disabled = true;

            // Redirect with filters
            setTimeout(() => {
                window.location.href = `${window.location.pathname}?${params.toString()}`;
            }, 500);
        });
    }

    // Reset Filter Function
    const resetFilter = document.getElementById('resetFilter');
    if (resetFilter) {
        resetFilter.addEventListener('click', function() {
            // Reset all filter values
            document.getElementById('priceRange').value = '';
            document.getElementById('guestCount').value = '';
            document.getElementById('roomCount').value = '';
            document.getElementById('sortBy').value = 'relevance';

            // Show loading state
            resetFilter.innerHTML = `
                <svg class="animate-spin h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" /></path>
                </svg>
                Reset...
            `;
            resetFilter.disabled = true;

            // Redirect without filters
            setTimeout(() => {
                window.location.href = window.location.pathname;
            }, 500);
        });
    }

    // Reset All Filters Function
    window.resetAllFilters = function() {
        window.location.href = window.location.pathname;
    };

    // Parallax Effect for Hero Section
    window.addEventListener('scroll', function() {
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.parallax');

        parallaxElements.forEach(element => {
            const speed = element.dataset.speed || 0.5;
            const yPos = -(scrolled * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
    });

    // Install App Prompt
    let deferredPrompt;
    window.addEventListener('beforeinstallprompt', (event) => {
        event.preventDefault();
        deferredPrompt = event;
        const installBtn = document.getElementById('installBtn');

        if (installBtn) {
            installBtn.style.display = 'block';
            installBtn.addEventListener('click', () => {
                if (deferredPrompt) {
                    deferredPrompt.prompt();
                    deferredPrompt.userChoice.then(choiceResult => {
                        console.log(choiceResult.outcome === 'accepted' ?
                            'User accepted the install prompt' :
                            'User dismissed the install prompt');
                        deferredPrompt = null;
                        installBtn.style.display = 'none';
                    });
                }
            });
        }
    });

    // Keyboard Navigation Support
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Tab') {
            document.body.classList.add('keyboard-nav');
        }
    });

    document.addEventListener('mousedown', function() {
        document.body.classList.remove('keyboard-nav');
    });

    // Animate elements on scroll
    const animateOnScroll = () => {
        const elements = document.querySelectorAll('.animate-fade-in-up');

        elements.forEach(element => {
            const elementTop = element.getBoundingClientRect().top;
            const elementBottom = element.getBoundingClientRect().bottom;

            if (elementTop < window.innerHeight && elementBottom > 0) {
                element.classList.add('animate-fade-in-up-active');
            }
        });
    };

    window.addEventListener('scroll', animateOnScroll);
    animateOnScroll(); // Initial check
});

// AJAX Search Implementation with Enhanced UX
function performSearch(query, filters = {}) {
    const params = new URLSearchParams({
        search: query,
        ...filters
    });

    // Show loading state
    const villaGrid = document.getElementById('villaGrid');
    if (villaGrid) {
        villaGrid.innerHTML = `
            <div class="col-span-full flex items-center justify-center py-16">
                <div class="text-center">
                    <svg class="animate-spin h-12 w-12 text-primary-600 mx-auto mb-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" /></path>
                    </svg>
                    <p class="text-gray-600">Mencari villa...</p>
                </div>
            </div>
        `;
    }

    fetch(`{{ route('index') }}?${params.toString()}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'text/html'
        }
    })
    .then(response => response.text())
    .then(html => {
        const parser = new DOMParser();
        const doc = parser.parseFromString(html, 'text/html');
        const newGrid = doc.querySelector('#villaGrid');

        if (newGrid && villaGrid) {
            villaGrid.innerHTML = newGrid.innerHTML;

            // Re-initialize lazy loading for new content
            const newImages = villaGrid.querySelectorAll('.lazy-load');
            newImages.forEach(img => {
                img.src = img.dataset.src;
                img.classList.remove('lazy-load');
                img.classList.add('loaded');
            });

            // Re-initialize animations
            const newElements = villaGrid.querySelectorAll('.animate-fade-in-up');
            newElements.forEach(element => {
                element.classList.add('animate-fade-in-up-active');
            });
        }
    })
    .catch(error => {
        console.error('Search failed:', error);
        if (villaGrid) {
            villaGrid.innerHTML = `
                <div class="col-span-full text-center py-16">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">Terjadi kesalahan</h3>
                    <p class="text-gray-600">Silakan coba lagi atau hubungi kami jika masalah berlanjut.</p>
                </div>
            `;
        }
    });
}

// Enhanced Debounce function for search
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Enhanced Search with Debounce
const debouncedSearch = debounce(performSearch, 300);

// Villa Card Enhanced Functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize favorite functionality
    initializeFavoriteButtons();

    // Initialize lazy loading for villa cards
    initializeLazyLoading();

    // Initialize card animations
    initializeCardAnimations();

    // Initialize quick view functionality
    initializeQuickView();
});

// Initialize Favorite Buttons
function initializeFavoriteButtons() {
    const favoriteButtons = document.querySelectorAll('button[onclick*="toggleFavorite"]');

    favoriteButtons.forEach(button => {
        // Check if villa is already favorited (from localStorage)
        const villaId = button.getAttribute('data-villa-id');
        if (villaId && localStorage.getItem(`favorite_${villaId}`)) {
            const svg = button.querySelector('svg');
            svg.classList.add('text-red-500', 'fill-current');
            svg.classList.remove('text-gray-700');
        }
    });
}

// Toggle Favorite Function
function toggleFavorite(villaId, button) {
    const svg = button.querySelector('svg');
    const isFavorited = svg.classList.contains('text-red-500');

    if (isFavorited) {
        // Remove from favorites
        svg.classList.remove('text-red-500', 'fill-current');
        svg.classList.add('text-gray-700');
        localStorage.removeItem(`favorite_${villaId}`);

        // Show notification
        showNotification('Dihapus dari favorit', 'info');
    } else {
        // Add to favorites
        svg.classList.remove('text-gray-700');
        svg.classList.add('text-red-500', 'fill-current');
        localStorage.setItem(`favorite_${villaId}`, 'true');

        // Add animation
        button.classList.add('active');
        setTimeout(() => button.classList.remove('active'), 600);

        // Show notification
        showNotification('Ditambahkan ke favorit', 'success');
    }

    // Update favorite count in header if exists
    updateFavoriteCount();
}

// Update Favorite Count
function updateFavoriteCount() {
    const favoriteCount = Object.keys(localStorage).filter(key => key.startsWith('favorite_')).length;
    const countElement = document.getElementById('favoriteCount');

    if (countElement) {
        countElement.textContent = favoriteCount;
        countElement.style.display = favoriteCount > 0 ? 'inline' : 'none';
    }
}

// Initialize Lazy Loading
function initializeLazyLoading() {
    const lazyImages = document.querySelectorAll('.lazy-load');

    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy-load');
                    img.classList.add('loaded');
                    observer.unobserve(img);
                }
            });
        }, {
            rootMargin: '50px 0px',
            threshold: 0.01
        });

        lazyImages.forEach(img => imageObserver.observe(img));
    } else {
        // Fallback for older browsers
        lazyImages.forEach(img => {
            img.src = img.dataset.src;
            img.classList.remove('lazy-load');
            img.classList.add('loaded');
        });
    }
}

// Initialize Card Animations
function initializeCardAnimations() {
    const cards = document.querySelectorAll('.villa-card');

    cards.forEach((card, index) => {
        // Add staggered animation on load
        setTimeout(() => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease';

            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 50);
        }, index * 100);

        // Add hover effect listeners
        card.addEventListener('mouseenter', function() {
            this.style.zIndex = '10';
        });

        card.addEventListener('mouseleave', function() {
            this.style.zIndex = '1';
        });
    });
}

// Initialize Quick View
function initializeQuickView() {
    const quickViewButtons = document.querySelectorAll('[data-quick-view]');

    quickViewButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const villaId = this.getAttribute('data-villa-id');
            openQuickView(villaId);
        });
    });
}

// Open Quick View Modal
function openQuickView(villaId) {
    const modal = document.getElementById('quickViewModal');
    if (!modal) return;

    // Show loading state
    modal.classList.remove('hidden');
    modal.querySelector('.p-6').innerHTML = `
        <div class="text-center py-8">
            <div class="inline-block animate-spin rounded-full h-8 w-8 border-b-2 border-primary-600" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    `;

    // Load villa data (simulated)
    setTimeout(() => {
        modal.querySelector('.p-6').innerHTML = `
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <img src="https://picsum.photos/seed/villa${villaId}/600/400.jpg"
                         alt="Villa ${villaId}"
                         class="w-full h-64 object-cover rounded-lg">
                </div>
                <div>
                    <h3 class="text-xl font-bold mb-2">Villa ${villaId}</h3>
                    <p class="text-gray-600 mb-4">Deskripsi singkat villa ${villaId} dengan fasilitas lengkap dan pemandangan indah.</p>
                    <div class="flex gap-2">
                        <a href="/produk/villa-${villaId}"
                           class="flex-1 bg-primary-600 text-white px-4 py-2 rounded-lg text-center hover:bg-primary-700 transition">
                            Lihat Detail
                        </a>
                        <button onclick="closeQuickView()"
                                class="px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        `;
    }, 1000);
}

// Close Quick View Modal
function closeQuickView() {
    const modal = document.getElementById('quickViewModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Show Notification
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 z-50 px-4 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300`;

    // Set color based on type
    const colors = {
        success: 'bg-green-500 text-white',
        error: 'bg-red-500 text-white',
        info: 'bg-blue-500 text-white',
        warning: 'bg-yellow-500 text-white'
    };

    notification.className += ` ${colors[type] || colors.info}`;
    notification.textContent = message;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
    }, 100);

    // Remove after 3 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            document.body.removeChild(notification);
        }, 300);
    }, 3000);
}

// Enhanced Filter Functionality
function applyVillaFilters() {
    const priceRange = document.getElementById('priceRange')?.value;
    const guestCount = document.getElementById('guestCount')?.value;
    const roomCount = document.getElementById('roomCount')?.value;
    const sortBy = document.getElementById('sortBy')?.value;

    // Show loading state
    const villaGrid = document.getElementById('villaGrid');
    if (villaGrid) {
        villaGrid.style.opacity = '0.5';
        villaGrid.style.pointerEvents = 'none';
    }

    // Simulate filter application
    setTimeout(() => {
        if (villaGrid) {
            villaGrid.style.opacity = '1';
            villaGrid.style.pointerEvents = 'auto';
            showNotification('Filter diterapkan', 'success');
        }
    }, 500);
}

// Keyboard Navigation for Villa Cards
document.addEventListener('keydown', function(e) {
    if (e.key === 'Tab') {
        const focusedElement = document.activeElement;
        const villaCard = focusedElement.closest('.villa-card');

        if (villaCard) {
            villaCard.classList.add('ring-2', 'ring-primary-500', 'ring-offset-2');
        }

        // Remove ring from other cards
        document.querySelectorAll('.villa-card').forEach(card => {
            if (card !== villaCard) {
                card.classList.remove('ring-2', 'ring-primary-500', 'ring-offset-2');
            }
        });
    }
});

// Performance optimization: Debounce scroll events
let scrollTimeout;
window.addEventListener('scroll', function() {
    if (scrollTimeout) {
        window.cancelAnimationFrame(scrollTimeout);
    }

    scrollTimeout = window.requestAnimationFrame(function() {
        // Parallax effects or other scroll-based animations
        const scrolled = window.pageYOffset;
        const parallaxElements = document.querySelectorAll('.parallax');

        parallaxElements.forEach(element => {
            const speed = element.dataset.speed || 0.5;
            const yPos = -(scrolled * speed);
            element.style.transform = `translateY(${yPos}px)`;
        });
    });
});

// Initialize Date Picker Function
function initializeDatePicker() {
    const bookingInput = document.getElementById('bookingDate');
    const nightsSelect = document.getElementById('nightsCount');

    if (!bookingInput || !nightsSelect) return;

    // Set minimum date to today
    const today = new Date();
    today.setHours(0, 0, 0, 0);

    // Initialize booking date picker
    const bookingPicker = flatpickr(bookingInput, {
        minDate: today,
        dateFormat: 'Y-m-d',
        locale: {
            firstDayOfWeek: 1,
            weekdays: {
                shorthand: ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                longhand: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu']
            },
            months: {
                shorthand: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
                longhand: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember']
            }
        },
        onChange: function(selectedDates, dateStr, instance) {
            // Enable nights select when date is selected
            if (selectedDates.length > 0) {
                nightsSelect.disabled = false;
            } else {
                nightsSelect.disabled = true;
                nightsSelect.value = '';
            }
        }
    });
}

// Initialize Search Form Function
function initializeSearchForm() {
    const searchForm = document.getElementById('heroSearchForm');
    const searchBtn = document.getElementById('searchVillasBtn');
    const bookingInput = document.getElementById('bookingDate');
    const nightsSelect = document.getElementById('nightsCount');

    if (!searchForm || !searchBtn) return;

    searchForm.addEventListener('submit', function(e) {
        e.preventDefault();

        // Validate form
        if (!bookingInput.value) {
            showNotification('Silakan pilih tanggal booking terlebih dahulu', 'warning');
            return;
        }

        if (!nightsSelect.value) {
            showNotification('Silakan pilih jumlah malam menginap', 'warning');
            return;
        }

        // Show loading state
        const originalBtnContent = searchBtn.innerHTML;
        searchBtn.innerHTML = `
            <svg class="animate-spin h-5 w-5 lg:h-6 lg:w-6 mr-3" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" /></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z" /></path>
            </svg>
            Mencari Villa...
        `;
        searchBtn.disabled = true;

        // Build search parameters
        const params = new URLSearchParams({
            booking_date: bookingInput.value,
            nights: nightsSelect.value
        });

        // Redirect to all products page with search parameters
        setTimeout(() => {
            window.location.href = `/all-produk?${params.toString()}`;
        }, 1000);
    });
}

// Enhanced Notification Function (Override existing)
function showNotification(message, type = 'info') {
    // Remove existing notifications
    const existingNotifications = document.querySelectorAll('.hero-notification');
    existingNotifications.forEach(notif => notif.remove());

    const notification = document.createElement('div');
    notification.className = `hero-notification fixed top-4 right-4 z-50 px-6 py-4 rounded-xl shadow-2xl transform translate-x-full transition-all duration-300 max-w-sm`;

    // Set color and icon based on type
    const configs = {
        success: {
            bg: 'bg-green-500',
            icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>'
        },
        error: {
            bg: 'bg-red-500',
            icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>'
        },
        warning: {
            bg: 'bg-yellow-500',
            icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>'
        },
        info: {
            bg: 'bg-blue-500',
            icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
        }
    };

    const config = configs[type] || configs.info;

    notification.innerHTML = `
        <div class="${config.bg} text-white rounded-xl p-4 flex items-start">
            <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                ${config.icon}
            </svg>
            <div class="flex-1">
                <p class="text-sm font-medium">${message}</p>
            </div>
            <button onclick="this.parentElement.parentElement.remove()" class="ml-3 text-white/80 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;

    document.body.appendChild(notification);

    // Animate in
    setTimeout(() => {
        notification.classList.remove('translate-x-full');
        notification.classList.add('translate-x-0');
    }, 100);

    // Auto remove after 5 seconds
    setTimeout(() => {
        notification.classList.add('translate-x-full');
        setTimeout(() => {
            if (notification.parentNode) {
                notification.parentNode.removeChild(notification);
            }
        }, 300);
    }, 5000);
}

// Enhanced Category and Promo Button Handling
document.addEventListener('DOMContentLoaded', function() {
    // Add smooth transitions for category and promo buttons
    const categoryButtons = document.querySelectorAll('a[href*="category"]');
    const promoButton = document.querySelector('a[href*="promo=true"]');

    // Add loading state to category buttons
    categoryButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            // Add loading state
            const originalContent = this.innerHTML;
            this.innerHTML = `
                <svg class="animate-spin w-4 h-4 lg:w-5 lg:h-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Memuat...
            `;
            this.classList.add('opacity-75', 'cursor-not-allowed');
            this.style.pointerEvents = 'none';

            // Restore original content after a delay (in case navigation is slow)
            setTimeout(() => {
                this.innerHTML = originalContent;
                this.classList.remove('opacity-75', 'cursor-not-allowed');
                this.style.pointerEvents = 'auto';
            }, 3000);
        });
    });

    // Add special handling for promo button
    if (promoButton) {
        promoButton.addEventListener('click', function(e) {
            // Add enhanced loading state with animation
            const originalContent = this.innerHTML;
            this.innerHTML = `
                <svg class="animate-spin w-4 h-4 lg:w-5 lg:h-5 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mencari Promo Terbaik...
            `;
            this.classList.add('opacity-75', 'cursor-not-allowed');
            this.style.pointerEvents = 'none';

            // Add pulse effect while loading
            this.style.animation = 'pulse-gentle 1s cubic-bezier(0.4, 0, 0.6, 1) infinite';

            // Restore original content after a delay
            setTimeout(() => {
                this.innerHTML = originalContent;
                this.classList.remove('opacity-75', 'cursor-not-allowed');
                this.style.pointerEvents = 'auto';
                this.style.animation = '';
            }, 3000);
        });
    }

    // Add hover effects for better UX
    const allButtons = document.querySelectorAll('a[href*="category"], a[href*="promo=true"]');
    allButtons.forEach(button => {
        button.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px) scale(1.05)';
        });

        button.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Advanced Filter Toggle Functionality
    const toggleAdvancedFilter = document.getElementById('toggleAdvancedFilter');
    const advancedFilterContent = document.getElementById('advancedFilterContent');
    const advancedFilterToggleText = document.getElementById('advancedFilterToggleText');
    const advancedFilterToggleIcon = document.getElementById('advancedFilterToggleIcon');

    if (toggleAdvancedFilter && advancedFilterContent) {
        toggleAdvancedFilter.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const isHidden = advancedFilterContent.style.maxHeight === '0px' || advancedFilterContent.style.maxHeight === '';

            if (isHidden) {
                // Show filter
                advancedFilterContent.style.maxHeight = '2000px';
                advancedFilterContent.style.opacity = '1';

                if (advancedFilterToggleText) advancedFilterToggleText.textContent = 'Sembunyikan filter';
                if (advancedFilterToggleIcon) advancedFilterToggleIcon.classList.add('rotate-180');
            } else {
                // Hide filter
                advancedFilterContent.style.maxHeight = '0';
                advancedFilterContent.style.opacity = '0';

                if (advancedFilterToggleText) advancedFilterToggleText.textContent = 'Permudah pencarian dengan filter';
                if (advancedFilterToggleIcon) advancedFilterToggleIcon.classList.remove('rotate-180');
            }
        });
    }

    // Apply Advanced Filter Function
    const applyAdvancedFilter = document.getElementById('applyAdvancedFilter');
    if (applyAdvancedFilter) {
        applyAdvancedFilter.addEventListener('click', function() {
            const priceRange = document.getElementById('priceRangeFilter').value;
            const capacity = document.getElementById('capacityFilter').value;
            const rooms = document.getElementById('roomsFilter').value;
            const attractions = document.getElementById('attractionsFilter').value;
            const bookingDate = document.getElementById('bookingDate').value;
            const nightsCount = document.getElementById('nightsCount').value;

            // Show loading state
            const originalBtnContent = this.innerHTML;
            this.innerHTML = `
                <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Menerapkan Filter...
            `;
            this.disabled = true;

            // Build search parameters
            const params = new URLSearchParams();

            // Add basic search parameters
            if (bookingDate) params.set('booking_date', bookingDate);
            if (nightsCount) params.set('nights_count', nightsCount);

            // Add advanced filter parameters
            if (priceRange) params.set('price_range', priceRange);
            if (capacity) params.set('capacity', capacity);
            if (rooms) params.set('rooms', rooms);
            if (attractions) params.set('attractions', attractions);

            // Redirect to all products page with filters
            setTimeout(() => {
                window.location.href = `/all-produk?${params.toString()}`;
            }, 800);
        });
    }

    // Reset Advanced Filter Function
    const resetAdvancedFilter = document.getElementById('resetAdvancedFilter');
    if (resetAdvancedFilter) {
        resetAdvancedFilter.addEventListener('click', function() {
            // Reset all filter values
            document.getElementById('priceRangeFilter').value = '';
            document.getElementById('capacityFilter').value = '';
            document.getElementById('roomsFilter').value = '';
            document.getElementById('attractionsFilter').value = '';

            // Show loading state
            const originalBtnContent = this.innerHTML;
            this.innerHTML = `
                <svg class="animate-spin w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Reset...
            `;
            this.disabled = true;

            // Redirect without filters
            setTimeout(() => {
                window.location.href = '/all-produk';
            }, 500);
        });
    }
});
</script>

<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

<script>
// Simple & Efficient Flickity Implementation
document.addEventListener('DOMContentLoaded', function() {
    // Popular Villas Carousel
    const popularCarousel = document.querySelector('.popular-villas-carousel');
    if (popularCarousel) {
        new Flickity(popularCarousel, {
            cellAlign: 'left',
            contain: true,
            wrapAround: false,
            prevNextButtons: true,
            pageDots: true,
            groupCells: window.innerWidth > 767 ? 4 : 2, // Show 2 cards on mobile, 4 on desktop
            // autoPlay: 5000,
            // pauseAutoPlayOnHover: true,
            // draggable: window.innerWidth > 767,
            lazyLoad: 2
        });
    }

    // Best Villas Carousel
    const bestCarousel = document.querySelector('.best-villas-carousel');
    if (bestCarousel) {
        new Flickity(bestCarousel, {
            cellAlign: 'left',
            contain: true,
            wrapAround: false,
            prevNextButtons: true,
            pageDots: true,
            groupCells: window.innerWidth > 767 ? 4 : 2, // Show 2 cards on mobile, 4 on desktop
            // autoPlay: 5000,
            // pauseAutoPlayOnHover: true,
            // draggable: window.innerWidth > 767,
            lazyLoad: 2
        });
    }

    // Testimonials Carousel
    const testimonialsCarousel = document.querySelector('.testimonials-carousel');
    if (testimonialsCarousel) {
        new Flickity(testimonialsCarousel, {
            cellAlign: 'center',
            contain: true,
            wrapAround: false,
            prevNextButtons: true,
            pageDots: true,
            autoPlay: 6000,
            pauseAutoPlayOnHover: true,
            adaptiveHeight: true,
            lazyLoad: 1
        });
    }

    // Fallback for browsers without Flickity
    if (typeof Flickity === 'undefined') {
        console.warn('Flickity not loaded. Using fallback scroll.');
        document.querySelectorAll('.popular-villas-carousel, .testimonials-carousel').forEach(carousel => {
            carousel.style.overflowX = 'auto';
            carousel.style.scrollBehavior = 'smooth';
        });
    }
});
</script>
@endpush
</x-app-landing-layout>
