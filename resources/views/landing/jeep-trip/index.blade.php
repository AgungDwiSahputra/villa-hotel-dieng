<x-app-landing-layout title="Jeep Trip - Petualangan Jeep Dieng" subTitle="Jelajahi Keindahan Dieng dengan Jeep Adventure">
    @push('css')
        <style>
            :root {
                --primary-color: #1e3a8a;
                --primary-light: #3b82f6;
                --primary-dark: #1e40af;
                --accent-color: #f59e0b;
            }

            .hero-gradient {
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            }

            .filter-card {
                background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(255,255,255,0.9) 100%);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255,255,255,0.2);
            }

            .rating-stars {
                color: #fbbf24;
            }

            .filter-toggle {
                transition: all 0.3s ease;
            }

            .filter-toggle.active {
                transform: rotate(180deg);
            }

            .filter-overlay {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(4px);
                z-index: 55;
                opacity: 0;
                visibility: hidden;
                transition: all 0.3s ease;
            }

            .filter-overlay.active {
                opacity: 1;
                visibility: visible;
            }

            .mobile-filter {
                position: fixed;
                top: 0;
                left: 0;
                right: 0;
                background: white;
                z-index: 60;
                transform: translateY(-100%);
                transition: transform 0.3s ease;
                max-height: 90vh;
                overflow-y: auto;
                opacity: 0;
                visibility: hidden;
            }

            .mobile-filter.active {
                transform: translateY(0);
                opacity: 1;
                visibility: visible;
            }

            .animate-fade-in {
                opacity: 0;
                transform: translateY(20px);
                animation: fadeInUp 0.6s ease-out forwards;
            }

            .animate-fade-in.delay-1 { animation-delay: 0.1s; }
            .animate-fade-in.delay-2 { animation-delay: 0.2s; }
            .animate-fade-in.delay-3 { animation-delay: 0.3s; }

            @keyframes fadeInUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .glass-effect {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }

            .stats-card {
                background: linear-gradient(135deg, rgba(30, 58, 138, 0.1) 0%, rgba(30, 64, 175, 0.1) 100%);
                border: 1px solid rgba(30, 58, 138, 0.2);
            }

            @media (max-width: 768px) {
                .hero-section {
                    padding: 3rem 1rem;
                }

                .filter-section {
                    position: relative;
                    background: transparent;
                    border: none;
                    padding: 0;
                }

                .filter-card {
                    padding: 1.5rem;
                    margin: 1rem;
                    border-radius: 1rem;
                }

                .packages-section {
                    padding-top: 6rem;
                }

                .packages-section {
                    padding-top: 2rem;
                }
            }

            @media (min-width: 769px) {
                .mobile-filter-toggle,
                .filter-overlay {
                    display: none !important;
                }
            }

        </style>
    @endpush

    <!-- Hero Section -->
    <section class="hero-gradient text-white relative overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <!-- Floating Elements -->
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute top-20 left-10 w-20 h-20 glass-effect rounded-full animate-pulse"></div>
            <div class="absolute top-40 right-20 w-32 h-32 glass-effect rounded-full animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute bottom-20 left-1/4 w-16 h-16 glass-effect rounded-full animate-pulse" style="animation-delay: 2s;"></div>
        </div>

        <div class="hero-section relative z-10 max-w-5xl mx-auto py-16 lg:py-24">
            <div class="text-center animate-fade-in">
                <!-- Badge -->
                <div class="inline-flex items-center px-4 py-2 rounded-full bg-white/10 backdrop-blur-sm border border-white/20 mb-6">
                    <svg class="w-5 h-5 mr-2 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <span class="text-sm font-medium">Petualangan Jeep Terbaik</span>
                </div>

                <!-- Main Heading -->
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                    <span class="block mb-2">Jelajahi Dieng dengan</span>
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-orange-400">
                        Jeep
                    </span>
                </h1>

                <!-- Description -->
                {{-- <p class="text-lg sm:text-xl text-blue-100 max-w-3xl mx-auto mb-8 leading-relaxed">
                    Rasakan pengalaman petualangan unik menjelajahi keindahan Dieng Plateau dengan jeep adventure.
                    Dari sunrise hingga zona favorit, semua paket tersedia untuk Anda.
                </p> --}}

                <!-- Stats -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 max-w-2xl mx-auto mb-8">
                    <div class="stats-card rounded-xl p-4 text-center animate-fade-in delay-1">
                        <div class="text-2xl font-bold text-white mb-1">500+</div>
                        <div class="text-sm text-blue-200">Pelanggan Puas</div>
                    </div>
                    <div class="stats-card rounded-xl p-4 text-center animate-fade-in delay-2">
                        <div class="text-2xl font-bold text-white mb-1">4.8/5</div>
                        <div class="text-sm text-blue-200">Rating Rata-rata</div>
                    </div>
                    {{-- <div class="stats-card rounded-xl p-4 text-center animate-fade-in delay-3">
                        <div class="text-2xl font-bold text-white mb-1">10+</div>
                        <div class="text-sm text-blue-200">Destinasi</div>
                    </div> --}}
                    <div class="stats-card rounded-xl p-4 text-center animate-fade-in delay-3">
                        <div class="text-2xl font-bold text-white mb-1">5+</div>
                        <div class="text-sm text-blue-200">Tahun Pengalaman</div>
                    </div>
                </div>

                <!-- CTA Button -->
                <div class="animate-fade-in delay-3">
                    <a href="#packages" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-semibold rounded-full transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                        </svg>
                        Jelajahi Paket Jeep
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <main class="bg-gray-50">
        <!-- Filter Section - Desktop -->
        <section class="hidden lg:block py-8 bg-white border-b border-gray-200 top-0 z-40" id="filter-section">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="filter-card rounded-2xl p-6 lg:p-8 shadow-lg">
                    <!-- Filter Header -->
                    <div class="flex items-center justify-between mb-6">
                        <div class="flex items-center">
                            <svg class="w-6 h-6 mr-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            <h2 class="text-xl font-bold text-gray-900">Filter & Cari Paket</h2>
                        </div>
                    </div>

                    <!-- Filter Form -->
                    <form method="GET" action="{{ route('jeep-trip.index') }}" class="space-y-6">
                        <!-- Filter Grid -->
                        <div class="filter-grid grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Search -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                    Cari Paket
                                </label>
                                <input type="text" name="search" value="{{ $searchQuery }}"
                                       placeholder="Nama paket atau zona..."
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 text-gray-900 placeholder-gray-500">
                            </div>

                            <!-- Zona Filter -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314-9.894 8 8 0 01-1.314 9.894z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    Zona
                                </label>
                                <select name="zona" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 text-gray-900">
                                    <option value="">Semua Zona</option>
                                    @foreach($zonaList as $zonaOption)
                                        <option value="{{ $zonaOption }}" {{ $zona == $zonaOption ? 'selected' : '' }}>
                                            {{ ucfirst($zonaOption) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Durasi Filter -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Durasi
                                </label>
                                <select name="durasi" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 text-gray-900">
                                    <option value="">Semua Durasi</option>
                                    <option value="1-2" {{ $durasi == '1-2' ? 'selected' : '' }}>1-2 Jam</option>
                                    <option value="3-4" {{ $durasi == '3-4' ? 'selected' : '' }}>3-4 Jam</option>
                                    <option value="5+" {{ $durasi == '5+' ? 'selected' : '' }}>5+ Jam</option>
                                </select>
                            </div>

                            <!-- Sort By -->
                            <div class="space-y-2">
                                <label class="flex items-center text-sm font-medium text-gray-700">
                                    <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                    </svg>
                                    Urutkan
                                </label>
                                <select name="sort" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 text-gray-900">
                                    <option value="rating" {{ $sortBy == 'rating' ? 'selected' : '' }}>⭐ Rating Tertinggi</option>
                                    <option value="price-low" {{ $sortBy == 'price-low' ? 'selected' : '' }}>💰 Harga Terendah</option>
                                    <option value="price-high" {{ $sortBy == 'price-high' ? 'selected' : '' }}>💎 Harga Tertinggi</option>
                                    <option value="name" {{ $sortBy == 'name' ? 'selected' : '' }}>📝 Nama A-Z</option>
                                </select>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-3 justify-center pt-4 border-t border-gray-200">
                            <button type="submit" class="inline-flex items-center justify-center px-8 py-3 bg-[#1e3a8a] hover:bg-primary-dark text-white font-semibold rounded-xl transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Cari Paket Jeep
                            </button>

                            @if($searchQuery || $zona || $durasi || $sortBy != 'rating')
                                <a href="{{ route('jeep-trip.index') }}" class="inline-flex items-center justify-center px-8 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl transition-all duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                    </svg>
                                    Reset Filter
                                </a>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </section>

        <!-- Mobile Filter Toggle Button -->
        <div class="lg:hidden fixed bottom-20 right-4 z-50" id="mobileFilterToggleContainer">
            <button class="mobile-filter-toggle bg-primary hover:bg-primary-dark text-white p-4 rounded-full shadow-lg transform hover:scale-110 transition-all duration-200" id="mobileFilterToggle" aria-label="Buka filter pencarian">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                </svg>
            </button>
        </div>

        <!-- Mobile Filter Modal -->
        <div class="filter-overlay" id="filterOverlay"></div>
        <div class="mobile-filter" id="mobileFilter">
            <div class="p-6">
                <!-- Mobile Filter Header -->
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-xl font-bold text-gray-900">Filter & Cari Paket</h2>
                    <button class="text-gray-400 hover:text-gray-600 transition-colors" id="closeMobileFilter">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Mobile Filter Form -->
                <form method="GET" action="{{ route('jeep-trip.index') }}" class="space-y-6">
                    <!-- Filter Grid -->
                    <div class="space-y-4">
                        <!-- Search -->
                        <div class="space-y-2">
                            <label class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Cari Paket
                            </label>
                            <input type="text" name="search" value="{{ $searchQuery }}"
                                   placeholder="Nama paket atau zona..."
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 text-gray-900 placeholder-gray-500">
                        </div>

                        <!-- Zona Filter -->
                        <div class="space-y-2">
                            <label class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314-9.894 8 8 0 01-1.314 9.894z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                Zona
                            </label>
                            <select name="zona" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 text-gray-900">
                                <option value="">Semua Zona</option>
                                @foreach($zonaList as $zonaOption)
                                    <option value="{{ $zonaOption }}" {{ $zona == $zonaOption ? 'selected' : '' }}>
                                        {{ ucfirst($zonaOption) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Durasi Filter -->
                        <div class="space-y-2">
                            <label class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Durasi
                            </label>
                            <select name="durasi" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 text-gray-900">
                                <option value="">Semua Durasi</option>
                                <option value="1-2" {{ $durasi == '1-2' ? 'selected' : '' }}>1-2 Jam</option>
                                <option value="3-4" {{ $durasi == '3-4' ? 'selected' : '' }}>3-4 Jam</option>
                                <option value="5+" {{ $durasi == '5+' ? 'selected' : '' }}>5+ Jam</option>
                            </select>
                        </div>

                        <!-- Sort By -->
                        <div class="space-y-2">
                            <label class="flex items-center text-sm font-medium text-gray-700">
                                <svg class="w-4 h-4 mr-2 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"></path>
                                </svg>
                                Urutkan
                            </label>
                            <select name="sort" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-primary focus:border-primary transition-all duration-200 text-gray-900">
                                <option value="rating" {{ $sortBy == 'rating' ? 'selected' : '' }}>⭐ Rating Tertinggi</option>
                                <option value="price-low" {{ $sortBy == 'price-low' ? 'selected' : '' }}>💰 Harga Terendah</option>
                                <option value="price-high" {{ $sortBy == 'price-high' ? 'selected' : '' }}>💎 Harga Tertinggi</option>
                                <option value="name" {{ $sortBy == 'name' ? 'selected' : '' }}>📝 Nama A-Z</option>
                            </select>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex flex-col gap-3 pt-6 border-t border-gray-200 bg-[#1e3a8a]">
                        <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                            Cari Paket Jeep
                        </button>

                        @if($searchQuery || $zona || $durasi || $sortBy != 'rating')
                            <a href="{{ route('jeep-trip.index') }}" class="w-full inline-flex items-center justify-center px-6 py-3 bg-gray-200 hover:bg-gray-300 text-gray-700 font-semibold rounded-xl transition-all duration-200">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                Reset Filter
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>

        <!-- Jeep Trip Packages Section -->
        <section class="packages-section py-16 lg:py-24" id="packages">
            <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
                <!-- Section Header -->
                {{-- <div class="text-center mb-16 animate-fade-in">
                    <div class="inline-flex items-center px-4 py-2 rounded-full bg-primary/10 text-primary font-medium text-sm mb-4">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                        Paket Jeep Trip
                    </div>

                    <h2 class="text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                        Pilih Petualangan Jeep Anda
                    </h2>

                    <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                        Temukan paket jeep trip yang sesuai dengan preferensi Anda.
                        Dari petualangan singkat hingga eksplorasi seharian penuh.
                    </p>

                    <div class="w-24 h-1 bg-gradient-to-r from-primary to-primary-dark mx-auto mt-6 rounded-full"></div>
                </div> --}}

                <!-- Results Info -->
                @if($jeepTrips->count() > 0)
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-8 animate-fade-in delay-1">
                        <div class="text-gray-600 mb-4 sm:mb-0">
                            Menampilkan <span class="font-semibold text-primary">{{ $jeepTrips->count() }}</span> dari <span class="font-semibold">{{ $jeepTrips->total() }}</span> paket jeep trip
                        </div>

                        @if($searchQuery || $zona || $durasi)
                            <div class="flex flex-wrap gap-2">
                                @if($searchQuery)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-primary/10 text-primary">
                                        Cari: "{{ $searchQuery }}"
                                        <a href="{{ route('jeep-trip.index', array_merge(request()->query(), ['search' => null])) }}" class="ml-2 hover:text-primary-dark">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </a>
                                    </span>
                                @endif
                                @if($zona)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-primary/10 text-primary">
                                        Zona: {{ ucfirst($zona) }}
                                        <a href="{{ route('jeep-trip.index', array_merge(request()->query(), ['zona' => null])) }}" class="ml-2 hover:text-primary-dark">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </a>
                                    </span>
                                @endif
                                @if($durasi)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-primary/10 text-primary">
                                        Durasi: {{ $durasi }} Jam
                                        <a href="{{ route('jeep-trip.index', array_merge(request()->query(), ['durasi' => null])) }}" class="ml-2 hover:text-primary-dark">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                            </svg>
                                        </a>
                                    </span>
                                @endif
                            </div>
                        @endif
                    </div>
                @endif

                <!-- Jeep Trip Cards -->
                <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-2 mb-16">
                    @forelse($jeepTrips as $jeepTrip)
                        <div class="animate-fade-in" style="animation-delay: {{ ($loop->index % 6) * 0.1 }}s">
                            <x-jeep-card :jeepTrip="$jeepTrip" :showDetailedPrice="false" :buttonText="'Lihat Detail & Booking'" />
                        </div>
                    @empty
                        <!-- Empty State -->
                        <div class="col-span-full">
                            <div class="text-center py-20 animate-fade-in">
                                <div class="max-w-md mx-auto">
                                    <div class="w-24 h-24 bg-gradient-to-br from-primary/10 to-primary/5 rounded-full flex items-center justify-center mx-auto mb-6">
                                        <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                        </svg>
                                    </div>

                                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Tidak ada paket jeep trip ditemukan</h3>
                                    <p class="text-gray-600 mb-8 leading-relaxed">
                                        Coba ubah kriteria pencarian atau filter untuk menemukan paket jeep trip yang sesuai dengan preferensi Anda.
                                    </p>

                                    <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                        <a href="{{ route('jeep-trip.index') }}" class="inline-flex items-center justify-center px-6 py-3 bg-primary hover:bg-primary-dark text-white font-semibold rounded-xl transform hover:scale-105 transition-all duration-200">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                            </svg>
                                            Lihat Semua Paket
                                        </a>

                                        <a href="#filter-section" class="inline-flex items-center justify-center px-6 py-3 bg-white border-2 border-primary text-primary hover:bg-primary hover:text-white font-semibold rounded-xl transition-all duration-200">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                                            </svg>
                                            Ubah Filter
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($jeepTrips->hasPages())
                    <div class="flex justify-center animate-fade-in delay-2">
                        <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-4">
                            {{ $jeepTrips->appends(request()->query())->links() }}
                        </div>
                    </div>
                @endif
            </div>
        </section>

        <!-- Call to Action Section -->
        <section class="py-16 bg-gradient-to-r from-primary to-primary-dark text-black">
            <div class="max-w-4xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                <div class="animate-fade-in">
                    <h2 class="text-3xl lg:text-4xl font-bold mb-4">
                        Siap Memulai Petualangan?
                    </h2>
                    <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                        Hubungi kami untuk informasi lebih lanjut atau booking langsung.
                        Tim kami siap membantu Anda merencanakan petualangan jeep terbaik di Dieng.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="tel:+6282162622680" class="inline-flex items-center justify-center px-8 py-4 bg-white text-primary hover:bg-gray-50 font-semibold rounded-xl transform hover:scale-105 transition-all duration-200 shadow-lg">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                            Hubungi Kami
                        </a>

                        <a href="https://wa.me/6282162622680" class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-yellow-500 to-orange-500 hover:from-yellow-600 hover:to-orange-600 text-white font-semibold rounded-xl transform hover:scale-105 transition-all duration-300 shadow-lg hover:shadow-xl">
                            <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                            </svg>
                            WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    @push('js')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Mobile filter modal functionality
                const mobileFilterToggle = document.getElementById('mobileFilterToggle');
                const mobileFilter = document.getElementById('mobileFilter');
                const filterOverlay = document.getElementById('filterOverlay');
                const closeMobileFilter = document.getElementById('closeMobileFilter');

                function openMobileFilter() {
                    if (mobileFilter) {
                        mobileFilter.classList.add('active');
                    }

                    if (filterOverlay) {
                        filterOverlay.classList.add('active');
                    }

                    document.body.style.overflow = 'hidden';

                    // Hide scroll-to-top button when filter is open
                    const scrollTopBtn = document.getElementById('scroll-top');
                    if (scrollTopBtn) {
                        scrollTopBtn.style.display = 'none';
                    }
                }

                function closeMobileFilterModal() {
                    if (mobileFilter) mobileFilter.classList.remove('active');
                    if (filterOverlay) filterOverlay.classList.remove('active');
                    document.body.style.overflow = '';

                    // Show scroll-to-top button when filter is closed
                    const scrollTopBtn = document.getElementById('scroll-top');
                    if (scrollTopBtn) {
                        scrollTopBtn.style.display = '';
                    }
                }

                if (mobileFilterToggle) {
                    mobileFilterToggle.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        openMobileFilter();
                    });
                }

                if (closeMobileFilter) {
                    closeMobileFilter.addEventListener('click', function(e) {
                        e.preventDefault();
                        e.stopPropagation();
                        closeMobileFilterModal();
                    });
                }

                if (filterOverlay) {
                    filterOverlay.addEventListener('click', function(e) {
                        if (e.target === filterOverlay) {
                            closeMobileFilterModal();
                        }
                    });
                }

                // Close modal on escape key
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && mobileFilter && mobileFilter.classList.contains('active')) {
                        closeMobileFilterModal();
                    }
                });

                // Fallback: Try to initialize after a short delay in case elements load late
                setTimeout(function() {
                    if (!mobileFilterToggle) {
                        const retryToggle = document.getElementById('mobileFilterToggle');
                        if (retryToggle) {
                            retryToggle.addEventListener('click', function(e) {
                                e.preventDefault();
                                e.stopPropagation();
                                openMobileFilter();
                            });
                        }
                    }
                }, 1000);

                // Smooth scroll for anchor links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function (e) {
                        e.preventDefault();
                        const target = document.querySelector(this.getAttribute('href'));
                        if (target) {
                            // Close mobile filter if open
                            if (mobileFilter.classList.contains('active')) {
                                closeMobileFilterModal();
                            }

                            target.scrollIntoView({
                                behavior: 'smooth',
                                block: 'start'
                            });
                        }
                    });
                });

                // Animate elements on scroll
                const observerOptions = {
                    threshold: 0.1,
                    rootMargin: '0px 0px -50px 0px'
                };

                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            entry.target.classList.add('animate-fade-in');
                        }
                    });
                }, observerOptions);

                // Observe elements that should animate in
                document.querySelectorAll('.animate-fade-in').forEach(el => {
                    observer.observe(el);
                });

                // Add loading state to all filter forms
                document.querySelectorAll('form[action*="jeep-trip"]').forEach(form => {
                    form.addEventListener('submit', function() {
                        const submitBtn = this.querySelector('button[type="submit"]');
                        if (submitBtn) {
                            const originalText = submitBtn.innerHTML;
                            submitBtn.innerHTML = `
                                <svg class="animate-spin w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Mencari...
                            `;
                            submitBtn.disabled = true;

                            // Close mobile filter
                            closeMobileFilterModal();

                            // Re-enable after 3 seconds as fallback
                            setTimeout(() => {
                                submitBtn.innerHTML = originalText;
                                submitBtn.disabled = false;
                            }, 3000);
                        }
                    });
                });

                // Prevent body scroll when mobile filter is open
                const preventScroll = (e) => {
                    if (mobileFilter.classList.contains('active')) {
                        e.preventDefault();
                    }
                };

                // Add/remove scroll prevention
                const mutationObserver = new MutationObserver((mutations) => {
                    mutations.forEach((mutation) => {
                        if (mutation.type === 'attributes' && mutation.attributeName === 'class') {
                            if (mobileFilter.classList.contains('active')) {
                                document.addEventListener('touchmove', preventScroll, { passive: false });
                                document.addEventListener('wheel', preventScroll, { passive: false });
                            } else {
                                document.removeEventListener('touchmove', preventScroll);
                                document.removeEventListener('wheel', preventScroll);
                            }
                        }
                    });
                });

                mutationObserver.observe(mobileFilter, {
                    attributes: true,
                    attributeFilter: ['class']
                });
            });
        </script>
    @endpush
</x-app-landing-layout>