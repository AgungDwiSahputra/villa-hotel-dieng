<x-app-landing-layout title="{{ $jeepTrip->nama_paket }} - Jeep Trip Adventure" subTitle="Petualangan Jeep Dieng">
    @push('css')
        <style>
            .rating-stars {
                color: #fbbf24;
            }
            .slot-card {
                transition: all 0.3s ease;
            }
            .slot-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            }
            .slot-selected {
                border-color: #3b82f6;
                background-color: #eff6ff;
            }

            /* Optimized Mobile Responsive Adjustments */
            @media (max-width: 768px) {
                .fc-toolbar-title {
                    font-size: 0.9em !important;
                }
                .fc-col-header-cell-cushion, .fc-daygrid-day-number {
                    font-size: 14px !important;
                }
            }
        </style>
    @endpush

    <!-- Hero Section -->
    <section class="relative py-5 lg:py-12 bg-gradient-to-br from-blue-50 via-white to-green-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-8">
                <div class="bg-white rounded-2xl shadow-xl p-2 lg:p-8 border border-gray-100 animate-fade-in-up">
                    <div class="relative mb-8">

                        <div class="main-carousel rounded-2xl overflow-hidden shadow-2xl" data-flickity='{ "cellAlign": "center", "contain": true, "prevNextButtons": true, "pageDots": true, "autoPlay": 5000, "pauseAutoPlayOnHover": false, "wrapAround": true, "adaptiveHeight": false, "imagesLoaded": true }'>
                            @forelse ($jeepTrip->images as $image)
                                <div class="carousel-cell relative">
                                    <div class="relative aspect-[4/3]">
                                        <a href="{{ asset('storage/' . $image->image_path) }}" class="glightbox block group" data-gallery="gallery1">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->name ?? $jeepTrip->nama_paket }}"
                                                class="w-full min-h-[413px] lg:min-h-[530px] h-full object-cover object-center transition-transform duration-700 group-hover:scale-105">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="carousel-cell relative">
                                    <div class="relative aspect-[4/3]">
                                        <a href="{{ asset('images/jeep-trip/default.jpg') }}" class="glightbox block group" data-gallery="gallery1">
                                            <img src="{{ asset('images/jeep-trip/default.jpg') }}" alt="Gambar Default Produk"
                                                class="w-full min-h-[413px] lg:min-h-[530px] h-full object-cover object-center transition-transform duration-700 group-hover:scale-105">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        </a>
                                    </div>
                                </div>
                            @endforelse
                        </div>

                    </div>

                    @if($jeepTrip->zona)
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs lg:text-sm font-medium bg-blue-100 text-blue-800 mb-3">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            {{ ucfirst($jeepTrip->zona) }}
                        </div>
                    @endif

                    <h4 class="text-lg sm:text-3xl font-bold mb-2 lg:mb-6 text-gray-900 leading-tight">{{ $jeepTrip->nama_paket }}</h4>

                    <div class="space-y-2">
                        <!-- Product Details Grid -->
                        <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-3 lg:p-6">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="flex items-start space-x-3">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">Durasi Trip</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $jeepTrip->durasi_jam }} Jam</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">Kapasitas per Jeep</p>
                                        <p class="text-sm font-semibold text-gray-900">Maksimal {{ $jeepTrip->kapasitas_ideal_per_jeep }} orang</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3">

                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">Unit Jeep Tersedia</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $jeepTrip->unit_jeep ?? 'Tersedia' }} unit</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rating Section -->
                        @if($jeepTrip->rating)
                            <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-3 py-2 lg:p-6">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <span class="text-sm font-medium text-gray-700">Rating</span>
                                    </div>
                                    <div class="flex items-center space-x-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-5 h-5 {{ $i <= $jeepTrip->rating ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                            </svg>
                                        @endfor
                                        <span class="ml-2 text-sm font-semibold text-gray-900">{{ number_format($jeepTrip->rating, 1) }}/5</span>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Description Section -->
                        <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-3 lg:p-6">
                            <div class="flex items-center space-x-3 mb-2">
                                <div class="flex-shrink-0 w-8 h-8 bg-gray-50 rounded-full flex items-center justify-center">
                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <h5 class="text-sm font-semibold text-gray-900">Deskripsi</h5>
                            </div>
                            <p class="text-xs lg:text-sm text-gray-700 leading-relaxed">{{ $jeepTrip->deskripsi_lengkap ?? $jeepTrip->deskripsi_singkat ?? 'Belum ada deskripsi yang tersedia.' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Fasilitas -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden animate-fade-in-up">
                    <div class="bg-gray-50 border-b border-gray-200">
                        <nav class="flex">
                            <button class="tab-button active flex-1 py-2 lg:py-4 px-6 text-center font-semibold text-xs lg:text-sm transition-all duration-200 border-b-2 border-blue-500 text-blue-600 bg-white"
                                    id="destinasi-tab" data-bs-toggle="tab" data-bs-target="#destinasi"
                                    type="button" role="tab" aria-controls="destinasi" aria-selected="true">
                                <svg class="w-5 h-5 mx-auto mb-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                                Destinasi
                            </button>
                            <button class="tab-button flex-1 py-2 lg:py-4 px-6 text-center font-semibold text-xs lg:text-sm transition-all duration-200 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100"
                                    id="includes-tab" data-bs-toggle="tab" data-bs-target="#includes"
                                    type="button" role="tab" aria-controls="includes" aria-selected="false">
                                <svg class="w-5 h-5 mx-auto mb-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                                Include/Exclude
                            </button>
                            <button class="tab-button flex-1 py-2 lg:py-4 px-6 text-center font-semibold text-xs lg:text-sm transition-all duration-200 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100"
                                    id="slots-tab" data-bs-toggle="tab" data-bs-target="#slots"
                                    type="button" role="tab" aria-controls="slots" aria-selected="false">
                                <svg class="w-5 h-5 mx-auto mb-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                </svg>
                                Slot Waktu
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        {{-- Destinasi --}}
                        <div class="tab-pane fade show active p-2 lg:p-8" id="destinasi" role="tabpanel" aria-labelledby="destinasi-tab">
                            @if ($jeepTrip->destinations->isNotEmpty())
                                <div class="grid grid-cols-2 gap-2" id="destinasi-list">
                                    @foreach ($jeepTrip->destinations as $index => $destination)
                                        <div class="flex items-center p-2 lg:p-3 bg-gray-50 rounded-lg {{ $index >= 6 ? 'hidden extra-fasilitas' : '' }} transition-all duration-200 hover:bg-gray-100">
                                            <div class="flex-shrink-0 w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <span class="text-xs lg:text-sm font-medium text-gray-700">{{ $destination->nama_destinasi }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($jeepTrip->destinations->count() > 10)
                                    <div class="mt-2 lg:mt-4 text-center">
                                        <button class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200 inline-flex items-center"
                                            onclick="toggleItems('destinasi')">
                                            <span class="text-xs lg:text-sm toggle-text">Lihat Selengkapnya</span>
                                            <svg class="w-4 h-4 ml-1 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"></path>
                                    </svg>
                                    <p class="italic">Belum ada informasi destinasi.</p>
                                </div>
                            @endif
                        </div>

                        {{-- Include/Exclude --}}
                        <div class="tab-pane fade p-2 lg:p-8 hidden" id="includes" role="tabpanel" aria-labelledby="includes-tab">
                            <div class="space-y-2 lg:space-y-6">
                                {{-- Includes --}}
                                @if ($jeepTrip->includes->isNotEmpty())
                                    <div>
                                        <h6 class="text-sm lg:text-lg font-semibold text-green-700 mb-2 lg:mb-4 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Termasuk dalam paket
                                        </h6>
                                        <div class="grid grid-cols-2 gap-2" id="includes-list">
                                            @foreach ($jeepTrip->includes as $index => $include)
                                                <div class="flex items-center p-2 lg:p-3 bg-gray-50 rounded-lg {{ $index >= 6 ? 'hidden extra-wisata' : '' }} transition-all duration-200 hover:bg-gray-100">
                                                    <div class="flex-shrink-0 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="text-xs lg:text-sm font-medium text-gray-700">{{ $include->nama_item }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if ($jeepTrip->includes->count() > 10)
                                            <div class="mt-2 lg:mt-4 text-center">
                                                <button class="text-xs lg:text-sm text-green-600 hover:text-green-800 font-medium transition-colors duration-200 inline-flex items-center"
                                                    onclick="toggleItems('includes')">
                                                    <span class="text-xs lg:text-sm toggle-text">Lihat Selengkapnya</span>
                                                    <svg class="w-4 h-4 ml-1 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    <div class="text-center py-8 text-gray-500">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="italic">Belum ada informasi include.</p>
                                    </div>
                                @endif

                                {{-- Excludes --}}
                                @if ($jeepTrip->excludes->isNotEmpty())
                                    <div>
                                        <h6 class="text-sm lg:text-lg font-semibold text-red-700 mb-2 lg:mb-4 flex items-center">
                                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                            </svg>
                                            Tidak termasuk dalam paket
                                        </h6>
                                        <div class="grid grid-cols-2 gap-2" id="includes-list">
                                            @foreach ($jeepTrip->excludes as $index => $exclude)
                                                <div class="flex items-center p-2 lg:p-3 bg-gray-50 rounded-lg {{ $index >= 6 ? 'hidden extra-wisata' : '' }} transition-all duration-200 hover:bg-gray-100">
                                                    <div class="flex-shrink-0 w-5 h-5 bg-red-500 rounded-full flex items-center justify-center mr-3">
                                                        <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                                        </svg>
                                                    </div>
                                                    <span class="text-xs lg:text-sm font-medium text-gray-700">{{ $exclude->nama_item }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                        @if ($jeepTrip->excludes->count() > 10)
                                            <div class="mt-2 lg:mt-4 text-center">
                                                <button class="text-xs lg:text-sm text-red-600 hover:text-red-800 font-medium transition-colors duration-200 inline-flex items-center"
                                                    onclick="toggleItems('excludes')">
                                                    <span class="text-xs lg:text-sm toggle-text">Lihat Selengkapnya</span>
                                                    <svg class="w-4 h-4 ml-1 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                                    </svg>
                                                </button>
                                            </div>
                                        @endif
                                    </div>
                                @endif

                                @if ($jeepTrip->includes->isEmpty() && $jeepTrip->excludes->isEmpty())
                                    <div class="text-center py-8 text-gray-500">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="italic">Belum ada informasi include/exclude.</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Slot Waktu --}}
                        <div class="tab-pane fade p-2 lg:p-8 hidden" id="slots" role="tabpanel" aria-labelledby="slots-tab">
                            @if ($jeepTrip->slots->isNotEmpty())
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2" id="slots-list">
                                    @foreach ($jeepTrip->slots as $index => $slot)
                                        <div class="slot-card flex items-center p-2 lg:p-4 bg-gray-50 rounded-xl border-2 border-gray-200 {{ $index >= 6 ? 'hidden extra-slots' : '' }}">
                                            <div class="w-5 h-5 lg:w-10 lg:h-10 bg-blue-500 rounded-full flex items-center justify-center mr-2 lg:mr-4 flex-shrink-0">
                                                <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <div class="flex-1">
                                                <h6 class="text-sm lg:text-base font-semibold text-gray-900">{{ $slot->nama_slot }}</h6>
                                                <p class="text-xs lg:text-sm text-gray-600">{{ \Carbon\Carbon::parse($slot->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->jam_selesai)->format('H:i') }}</p>
                                            </div>
                                            <div class="text-right">
                                                <div class="text-xs lg:text-sm text-gray-500">Kapasitas</div>
                                                <div class="text-sm lg:text-base font-semibold text-gray-900">{{ $slot->kapasitas_jeep ?? 'Tersedia' }} jeep</div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($jeepTrip->slots->count() > 6)
                                    <div class="mt-2 lg:mt-4 text-center">
                                        <button class="text-xs text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200 flex items-center mx-auto"
                                            onclick="toggleItems('slots')">
                                            <span class="text-xs lg:text-sm toggle-text">Lihat Selengkapnya</span>
                                            <svg class="w-4 h-4 ml-2 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-4 lg:py-8 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="italic">Belum ada informasi slot waktu.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 pt-0 bg-gradient-to-br from-gray-50 to-blue-50 animate-fade-in-up">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-8">
                <div class="bg-white rounded-2xl shadow-xl p-2 lg:p-8 border border-gray-100">
                    <h5 class="text-sm sm:text-2xl font-bold mb-2 lg:mb-6 text-gray-900 flex items-center">
                        <svg class="w-5 h-5 lg:w-6 lg:h-6 mr-2 lg:mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        Pilih Tanggal
                    </h5>
                    <div id="calendar" class="bg-white rounded-xl border border-gray-200 overflow-hidden"></div>
                </div>

                <div class="space-y-4 lg:space-y-6">
                    <form action="{{ route('jeep-trip.booking') }}" method="POST" id="bookingForm">
                        @csrf
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-2 lg:p-8 border border-blue-200" id="bookingInfoText">
                            <div class="text-center">
                                <div class="w-12 h-12 lg:w-16 lg:h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2 lg:mb-4">
                                    <svg class="w-6 h-6 lg:w-8 lg:h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm sm:text-lg font-semibold text-gray-900 mb-2">Cara Booking Jeep Trip</h3>
                                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                    Pilih tanggal trip pada kalender, kemudian pilih slot waktu dan jumlah jeep yang diinginkan.
                                </p>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-xl p-2 lg:p-8 border border-gray-100 hidden" id="bookingSummary">
                            <h5 class="text-sm sm:text-2xl font-bold mb-2 lg:mb-6 text-gray-900 flex items-center">
                                <svg class="w-5 h-5 lg:w-6 lg:h-6 mr-2 lg:mr-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Ringkasan Booking
                            </h5>
                            <div class="space-y-2 lg:space-y-4">
                                <div class="flex justify-between items-center p-2 lg:p-4 bg-gray-50 rounded-xl">
                                    <span class="text-xs lg:text-sm font-medium text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Tanggal Trip
                                    </span>
                                    <input type="date" name="tanggal_trip" id="tanggalTripInput"
                                           class="px-3 lg:px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs lg:text-sm font-medium" readonly>
                                </div>

                                <div class="p-2 lg:p-4 bg-gray-50 rounded-xl">
                                    <label class="text-xs lg:text-sm font-medium text-gray-700 mb-3 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Pilih Slot Waktu
                                    </label>
                                    <div class="grid grid-cols-1 gap-3" id="slotSelection">
                                        @forelse($jeepTrip->slots as $slot)
                                            <div class="slot-option flex items-center p-3 border-2 border-gray-200 rounded-lg cursor-pointer hover:border-blue-300 transition-colors"
                                                 data-slot-id="{{ $slot->id }}"
                                                 data-slot-name="{{ $slot->nama_slot }}"
                                                 data-jam-mulai="{{ $slot->jam_mulai }}"
                                                 data-jam-selesai="{{ $slot->jam_selesai }}">
                                                <input type="radio" name="slot_id" value="{{ $slot->id }}" class="mr-3 w-4 h-4 text-blue-600 focus:ring-blue-500" required>
                                                <div class="flex-1">
                                                    <div class="text-sm lg:text-md font-medium text-gray-900">{{ $slot->nama_slot }}</div>
                                                    <div class="text-xs lg:text-sm text-gray-600">{{ \Carbon\Carbon::parse($slot->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($slot->jam_selesai)->format('H:i') }}</div>
                                                </div>
                                                {{-- <div class="text-right">
                                                    <div class="text-sm text-gray-500">Kapasitas</div>
                                                    <div class="font-semibold text-gray-900">{{ $slot->kapasitas_jeep ?? 'Tersedia' }}</div>
                                                </div> --}}
                                            </div>
                                        @empty
                                            <div class="text-center py-4 lg:py-8 text-gray-500">
                                                <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"></path>
                                                </svg>
                                                <p class="italic">Belum ada slot waktu yang tersedia untuk paket ini.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                    <span class="text-xs lg:text-sm font-medium text-gray-700 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                        </svg>
                                        Jumlah Jeep
                                    </span>
                                    <div class="flex items-center space-x-2">
                                        <button type="button" id="decreaseJeep" class="w-4 h-4 lg:w-8 lg:h-8 bg-gray-200 hover:bg-gray-300 rounded-full flex items-center justify-center transition-colors" disabled>
                                            <svg class="w-3 h-3 lg:w-4 lg:h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                            </svg>
                                        </button>
                                        <input type="number" name="jumlah_jeep" id="jumlahJeep" min="1" max="10" value="1"
                                               class="px-3 py-2 border border-gray-300 rounded-lg text-xs lg:text-sm font-medium w-16 text-center focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                        <button type="button" id="increaseJeep" class="w-4 h-4 lg:w-8 lg:h-8 bg-blue-500 hover:bg-blue-600 text-white rounded-full flex items-center justify-center transition-colors">
                                            <svg class="w-3 h-3 lg:w-4 lg:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center p-2 lg:p-4 bg-green-50 rounded-xl">
                                    <span class="text-xs lg:text-sm font-bold text-gray-900 flex items-center">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582z"></path>
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.51-1.31c-.562-.649-1.413-1.076-2.353-1.253V5z" clip-rule="evenodd"></path>
                                        </svg>
                                        Total Harga
                                    </span>
                                    <input type="number" name="total_harga" id="totalHargaInput"
                                           class="px-3 lg:px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm lg:text-lg font-bold text-green-600 w-40 text-right" readonly>
                                </div>
                            </div>
                            <div class="mt-6 lg:mt-8">
                                <input type="hidden" name="jeep_trip_id" value="{{ $jeepTrip->id }}">
                                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-2 lg:py-4 px-6 lg:px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <span class="text-xs lg:text-sm flex items-center justify-center">
                                        <svg class="w-5 h-5 lg:w-6 lg:h-6 mr-2 lg:mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 16a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"></path>
                                        </svg>
                                        Booking Jeep Trip
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="bg-white rounded-2xl shadow-xl p-2 lg:p-8 border border-gray-100">
                        <h5 class="text-sm sm:text-lg font-semibold mb-2 lg:mb-6 text-gray-900 flex items-center">
                            <svg class="w-5 h-5 lg:w-6 lg:h-6 mr-2 lg:mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            Informasi Penting
                        </h5>
                        <ul class="space-y-2 lg:space-y-4">
                            <li class="flex items-start p-3 lg:p-4 bg-blue-50 rounded-xl">
                                <div class="w-6 h-6 lg:w-8 lg:h-8 bg-blue-500 rounded-full flex items-center justify-center mr-2 lg:mr-3 flex-shrink-0">
                                    <svg class="w-3 h-3 lg:w-4 lg:h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-xs sm:text-base text-gray-700">Pembayaran dilakukan setelah booking melalui Midtrans</span>
                            </li>
                            <li class="flex items-start p-3 lg:p-4 bg-blue-50 rounded-xl">
                                <div class="w-6 h-6 lg:w-8 lg:h-8 bg-green-500 rounded-full flex items-center justify-center mr-2 lg:mr-3 flex-shrink-0">
                                    <svg class="w-3 h-3 lg:w-4 lg:h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M13 11H7v4h5v-4zm0-6H7v9h5V5z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs sm:text-base text-gray-700">Pilih tanggal dan slot waktu yang tersedia</span>
                            </li>
                            <li class="flex items-start p-3 lg:p-4 bg-blue-50 rounded-xl">
                                <div class="w-6 h-6 lg:w-8 lg:h-8 bg-purple-500 rounded-full flex items-center justify-center mr-2 lg:mr-3 flex-shrink-0">
                                    <svg class="w-3 h-3 lg:w-4 lg:h-4    text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs sm:text-base text-gray-700">Konfirmasi booking akan dikirim melalui WhatsApp</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white animate-fade-in-up">
        <div class="container mx-auto px-0 sm:px-6 lg:px-8 max-w-5xl">
            <h5 class="text-sm sm:text-3xl font-bold mb-3 lg:mb-8 text-gray-900 text-center flex items-center justify-center">
                <svg class="w-6 h-6 lg:w-8 lg:h-8 mr-2 lg:mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                Rekomendasi Lainnya
            </h5>
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-2 sm:gap-4 lg:gap-6 xl:gap-8 max-w-4xl mx-auto px-2 md:px-0">
                @forelse($recommendedTrips as $trip)
                    <x-jeep-card :jeepTrip="$trip" />
                @empty
                    <div class="col-span-full text-center py-12">
                        <div class="max-w-md mx-auto">
                            <i class="bx bx-car text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-900 mb-2">Tidak ada rekomendasi jeep trip</h3>
                            <p class="text-gray-600 mb-6">Cek jeep trip lainnya yang tersedia.</p>
                            <a href="{{ route('jeep-trip.index') }}" class="bg-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:bg-blue-700 transition-colors">
                                Lihat Semua Jeep Trip
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" />
        <style>
            .fc-header-toolbar {
                background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
                color: white;
            }

            .fc-button {
                background-color: transparent !important;
                border: none !important;
                color: white !important;
            }

            .fc-toolbar-title {
                color: white !important;
                font-weight: bold;
            }

            .fc-col-header {
                font-weight: bold;
            }

            .fc-daygrid-day-number {
                position: static !important;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100%;
                height: 100%;
                font-size: 16px;
                font-weight: bold;
                z-index: 2;
            }

            .fc-daygrid-day-frame {
                aspect-ratio: 1;
                padding: 0 !important;
                position: relative;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .fc-daygrid-day {
                border: 1px solid #e0e0e0;
                box-sizing: border-box;
            }

            #calendar .fc-scroller,
            #calendar .fc-daygrid-body,
            #calendar .fc-scrollgrid {
                overflow-y: hidden !important;
            }

            .disabled-date {
                background: #fee2e2 !important;
                color: #dc2626 !important;
                pointer-events: none;
                opacity: 0.6;
            }

            .close-date {
                background: #4F545A !important;
                color: #4F545A !important;
                pointer-events: none;
                opacity: 0.6;
            }

            .fc-daygrid-day.selected-date {
                background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
                position: relative;
            }

            .fc-daygrid-day.selected-date .fc-daygrid-day-number {
                border-radius: 50%;
                width: 75px;
                height: 75px;
                display: flex;
                justify-content: center;
                align-items: center;
                position: relative;
                z-index: 2;
                color: #fff;
            }

            .fc-daygrid-day.selected-date .fc-daygrid-day-frame {
                background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
                color: #fff;
                border-radius: 50%;
            }

            .fc-daygrid-day-frame {
                display: flex;
                justify-content: center;
                align-items: center;
                border: none !important;
            }

            .fc-daygrid-day-events {
                display: none;
            }

            .fc-day {
                border: none !important;
            }

            .animate-fade-in-up {
                opacity: 0;
                transform: translateY(20px);
                transition: all 0.6s ease-out;
            }

            .animate-fade-in-up.animate-fade-in-up-active {
                opacity: 1;
                transform: translateY(0);
                animation: slideInUp 0.6s ease-out;
            }

            @keyframes slideInUp {
                from {
                    transform: translateY(30px);
                    opacity: 0;
                }
                to {
                    transform: translateY(0);
                    opacity: 1;
                }
            }

            .slot-option.selected {
                border-color: #3b82f6;
                background-color: #eff6ff;
            }

            @media (max-width: 640px) {
                .fc-daygrid-day.selected-date .fc-daygrid-day-number {
                    width: 50px;
                    height: 50px;
                    font-size: 14px;
                }
            }
        </style>
    @endpush

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize GLightbox
                if (typeof GLightbox !== 'undefined') {
                    const lightbox = GLightbox({
                        selector: '.glightbox'
                    });
                }

                // Initialize Flickity carousel
                if (typeof Flickity !== 'undefined' && $('.main-carousel').length) {
                    try {
                        var flkty = new Flickity('.main-carousel', {
                            cellAlign: 'center',
                            contain: true,
                            prevNextButtons: true,
                            pageDots: true,
                            autoPlay: 5000,
                            pauseAutoPlayOnHover: false,
                            wrapAround: true,
                            adaptiveHeight: false,
                            imagesLoaded: true,
                        });
                    } catch (e) {
                        console.warn('Flickity initialization error:', e);
                    }
                }

                let selectedDate = null;
                let selectedSlotId = null;
                let calendar = null;

                const jeepTripId = `{{ $jeepTrip->id }}`;
                const hargaWeekday = {{ $jeepTrip->harga_weekday }};
                const hargaWeekend = {{ $jeepTrip->harga_weekend }};

                // Utility functions
                function isWeekend(date) {
                    const day = date.getDay();
                    return day === 0 || day === 6;
                }

                function calculatePrice(date, jumlahJeep) {
                    const price = isWeekend(date) ? hargaWeekend : hargaWeekday;
                    return price * jumlahJeep;
                }

                function updateTotalHarga() {
                    if (selectedDate && selectedSlotId) {
                        const jumlahJeep = parseInt($('#jumlahJeep').val()) || 1;
                        const total = calculatePrice(selectedDate, jumlahJeep);
                        $('#totalHargaInput').val(total);
                    }
                }

                function showBookingSummary() {
                    $('#bookingSummary').removeClass('hidden');
                    $('#bookingInfoText').addClass('hidden');
                }

                function hideBookingSummary() {
                    $('#bookingSummary').addClass('hidden');
                    $('#bookingInfoText').removeClass('hidden');
                }

                // Initialize FullCalendar
                if (typeof FullCalendar !== 'undefined' && $('#calendar').length) {
                    try {
                        calendar = new FullCalendar.Calendar($('#calendar')[0], {
                            locale: 'id',
                            initialView: 'dayGridMonth',
                            fixedWeekCount: false,
                            height: 'auto',
                            headerToolbar: {
                                left: 'prev',
                                center: 'title',
                                right: 'next'
                            },
                            validRange: function(nowDate) {
                                return {
                                    start: nowDate.toISOString().slice(0, 10)
                                };
                            },
                            dateClick: function(info) {
                                const clickedDate = new Date(info.dateStr + 'T12:00:00');

                                // Remove previous selection
                                $('.fc-daygrid-day').removeClass('selected-date');

                                // Add selection to clicked date
                                $(info.dayEl).addClass('selected-date');

                                selectedDate = clickedDate;
                                $('#tanggalTripInput').val(info.dateStr);

                                // Reset slot selection when date changes
                                $('.slot-option').removeClass('selected');
                                $('.slot-option input[type="radio"]').prop('checked', false);
                                $('.slot-status').remove(); // Remove availability status
                                selectedSlotId = null;

                                // Reset jumlah jeep to default
                                $('#jumlahJeep').attr('max', 10).val(1);
                                updateJeepButtons(1);

                                showBookingSummary();
                                updateTotalHarga();
                            },
                            dayCellDidMount: function(info) {
                                // Add availability checking logic here if needed
                                // This would require AJAX call to check availability for each date
                            }
                        });

                        calendar.render();
                    } catch (e) {
                        console.warn('Calendar initialization error:', e);
                    }
                }

                // Slot selection with improved logic
                $('.slot-option').on('click', function(e) {
                    // Don't trigger if clicking on radio button itself
                    if ($(e.target).is('input[type="radio"]')) return;

                    const slotId = $(this).data('slot-id');
                    const radioBtn = $(this).find('input[type="radio"]');

                    // Remove selection from all slots
                    $('.slot-option').removeClass('selected');
                    $('.slot-option input[type="radio"]').prop('checked', false);

                    // Add selection to clicked slot
                    $(this).addClass('selected');
                    radioBtn.prop('checked', true);

                    selectedSlotId = slotId;

                    // Get availability data for selected slot and date
                    if (selectedDate) {
                        getAvailabilityData(slotId, selectedDate);
                    }

                    updateTotalHarga();
                });

                // Handle radio button change directly
                $('.slot-option input[type="radio"]').on('change', function() {
                    const slotOption = $(this).closest('.slot-option');
                    const slotId = slotOption.data('slot-id');

                    $('.slot-option').removeClass('selected');
                    slotOption.addClass('selected');

                    selectedSlotId = slotId;

                    // Get availability data for selected slot and date
                    if (selectedDate) {
                        getAvailabilityData(slotId, selectedDate);
                    }

                    updateTotalHarga();
                });

                // Jumlah jeep input handler
                $('#jumlahJeep').on('input', function() {
                    const value = parseInt($(this).val()) || 1;
                    updateJeepButtons(value);
                    updateTotalHarga();
                });

                // Jeep quantity buttons
                $('#increaseJeep').on('click', function() {
                    const input = $('#jumlahJeep');
                    const currentValue = parseInt(input.val()) || 1;
                    const maxValue = parseInt(input.attr('max')) || 10;
                    const newValue = Math.min(currentValue + 1, maxValue);
                    input.val(newValue);
                    updateJeepButtons(newValue);
                    updateTotalHarga();
                });

                $('#decreaseJeep').on('click', function() {
                    const input = $('#jumlahJeep');
                    const currentValue = parseInt(input.val()) || 1;
                    const minValue = parseInt(input.attr('min')) || 1;
                    const newValue = Math.max(currentValue - 1, minValue);
                    input.val(newValue);
                    updateJeepButtons(newValue);
                    updateTotalHarga();
                });

                // Get availability data from API
                function getAvailabilityData(slotId, date) {
                    const dateStr = date.toISOString().split('T')[0]; // Format to YYYY-MM-DD

                    $.get(`/api/jeep-trip/availability?slot_id=${slotId}&tanggal=${dateStr}`)
                        .done(function(data) {
                            if (data.available) {
                                // Update max attribute based on available quota
                                $('#jumlahJeep').attr('max', data.quota_tersedia);

                                // Reset current value if it exceeds new max
                                const currentValue = parseInt($('#jumlahJeep').val()) || 1;
                                if (currentValue > data.quota_tersedia) {
                                    $('#jumlahJeep').val(data.quota_tersedia);
                                }

                                // Update button states
                                updateJeepButtons(parseInt($('#jumlahJeep').val()) || 1);

                                // Show availability info
                                showAvailabilityInfo(data);
                            } else {
                                // No availability, set max to 0
                                $('#jumlahJeep').attr('max', 0);
                                $('#jumlahJeep').val(0);
                                updateJeepButtons(0);
                                showAvailabilityInfo({quota_jeep: 0, quota_terpakai: 0, quota_tersedia: 0, is_closed: true, message: data.message});
                            }
                        })
                        .fail(function(xhr) {
                            console.error('Failed to get availability data:', xhr);
                            // Fallback: set max to default
                            $('#jumlahJeep').attr('max', 10);
                            updateJeepButtons(parseInt($('#jumlahJeep').val()) || 1);
                        });
                }

                // Show availability information
                function showAvailabilityInfo(data) {
                    let statusClass = 'text-green-600';
                    let statusText = 'Tersedia';

                    if (data.is_closed) {
                        statusClass = 'text-red-600';
                        statusText = 'Ditutup';
                    } else if (data.quota_tersedia === 0) {
                        statusClass = 'text-orange-600';
                        statusText = 'Penuh';
                    } else if (data.quota_tersedia <= 2) {
                        statusClass = 'text-yellow-600';
                        statusText = 'Hampir Penuh';
                    }

                    // Update slot status display
                    const selectedSlot = $(`.slot-option[data-slot-id="${selectedSlotId}"]`);
                    if (selectedSlot.length) {
                        // Remove existing status
                        selectedSlot.find('.slot-status').remove();

                        // Add new status
                        selectedSlot.append(`
                            <div class="slot-status mt-2 text-xs ${statusClass} font-medium">
                                ${statusText} (${data.quota_tersedia} jeep)
                            </div>
                        `);
                    }
                }

                function updateJeepButtons(value) {
                    const minValue = parseInt($('#jumlahJeep').attr('min')) || 1;
                    const maxValue = parseInt($('#jumlahJeep').attr('max')) || 10;

                    $('#decreaseJeep').prop('disabled', value <= minValue);
                    $('#increaseJeep').prop('disabled', value >= maxValue);

                    // Update button styles
                    if (value <= minValue) {
                        $('#decreaseJeep').addClass('opacity-50 cursor-not-allowed').removeClass('hover:bg-gray-300');
                    } else {
                        $('#decreaseJeep').removeClass('opacity-50 cursor-not-allowed').addClass('hover:bg-gray-300');
                    }

                    if (value >= maxValue) {
                        $('#increaseJeep').addClass('opacity-50 cursor-not-allowed').removeClass('hover:bg-blue-600');
                    } else {
                        $('#increaseJeep').removeClass('opacity-50 cursor-not-allowed').addClass('hover:bg-blue-600');
                    }
                }

                // Initialize jeep buttons
                updateJeepButtons(1);

                // Tab functionality with improved logic
                $('.tab-button').on('click', function() {
                    const target = $(this).data('bs-target');
                    if (!target) return;

                    // Update tab buttons
                    $('.tab-button').removeClass('active border-blue-500 text-blue-600 bg-white').addClass('border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100');
                    $(this).removeClass('border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100').addClass('active border-blue-500 text-blue-600 bg-white');

                    // Update tab panes
                    $('.tab-pane').removeClass('show active').addClass('hidden');
                    $(target).removeClass('hidden').addClass('show active');
                });

                // Animation system with Intersection Observer for better performance
                const animateOnScroll = () => {
                    const elements = document.querySelectorAll('.animate-fade-in-up:not(.animate-fade-in-up-active)');

                    elements.forEach(element => {
                        const elementTop = element.getBoundingClientRect().top;
                        const elementBottom = element.getBoundingClientRect().bottom;
                        const windowHeight = window.innerHeight;

                        // Trigger animation when element is in viewport
                        if (elementTop < windowHeight * 0.9 && elementBottom > 0) {
                            element.classList.add('animate-fade-in-up-active');
                        }
                    });
                };

                // Initial check
                animateOnScroll();

                // Throttled scroll listener
                let scrollTimeout;
                window.addEventListener('scroll', function() {
                    clearTimeout(scrollTimeout);
                    scrollTimeout = setTimeout(animateOnScroll, 16); // ~60fps
                });

                // Fallback animation trigger
                setTimeout(() => {
                    const elementsInView = document.querySelectorAll('.animate-fade-in-up:not(.animate-fade-in-up-active)');
                    elementsInView.forEach(element => {
                        const rect = element.getBoundingClientRect();
                        if (rect.top < window.innerHeight && rect.bottom > 0) {
                            element.classList.add('animate-fade-in-up-active');
                        }
                    });
                }, 100);

                // Form validation before submit
                $('#bookingForm').on('submit', function(e) {
                    // Clear previous error messages
                    $('.error-message').remove();
                    $('.border-red-500').removeClass('border-red-500');

                    let hasErrors = false;
                    let firstErrorElement = null;

                    // Validate date selection
                    if (!selectedDate) {
                        showError('calendar', 'Silakan pilih tanggal trip terlebih dahulu.');
                        if (!firstErrorElement) firstErrorElement = $('#calendar')[0];
                        hasErrors = true;
                    }

                    // Validate slot selection
                    if (!selectedSlotId) {
                        showError('slotSelection', 'Silakan pilih slot waktu terlebih dahulu.');
                        if (!firstErrorElement) firstErrorElement = $('#slotSelection')[0];
                        hasErrors = true;
                    }

                    // Validate jumlah jeep
                    const jumlahJeep = parseInt($('#jumlahJeep').val()) || 0;
                    if (jumlahJeep < 1) {
                        showError('jumlahJeep', 'Jumlah jeep minimal 1.');
                        if (!firstErrorElement) firstErrorElement = $('#jumlahJeep')[0];
                        hasErrors = true;
                    }

                    if (hasErrors) {
                        e.preventDefault();
                        if (firstErrorElement) {
                            firstErrorElement.scrollIntoView({ behavior: 'smooth', block: 'center' });
                        }
                        return false;
                    }

                    // Show loading state
                    const submitBtn = $(this).find('button[type="submit"]');
                    const originalText = submitBtn.html();
                    submitBtn.prop('disabled', true).html(`
                        <div class="flex items-center justify-center">
                            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Memproses...
                        </div>
                    `);

                    // Re-enable button after 10 seconds as fallback
                    setTimeout(() => {
                        submitBtn.prop('disabled', false).html(originalText);
                    }, 10000);
                });

                function showError(elementId, message) {
                    const element = $('#' + elementId);
                    element.addClass('border-red-500');

                    const errorDiv = $('<div class="error-message text-red-600 text-sm mt-1">' + message + '</div>');
                    element.after(errorDiv);

                    // Auto-hide error after 5 seconds
                    setTimeout(() => {
                        errorDiv.fadeOut(() => errorDiv.remove());
                        element.removeClass('border-red-500');
                    }, 5000);
                }

                // Smooth scroll for floating price button
                $('a[href="#calendar"]').on('click', function(e) {
                    e.preventDefault();
                    const target = $('#calendar');
                    if (target.length) {
                        target[0].scrollIntoView({ behavior: 'smooth', block: 'center' });
                    }
                });
            });
        </script>
    @endpush

    <script>
        function toggleItems(type) {
            const extraItems = document.querySelectorAll('.extra-' + type);
            const button = document.querySelector('button[onclick="toggleItems(\'' + type + '\')"]');

            if (!extraItems.length || !button) return;

            const icon = button.querySelector('svg');
            const text = button.querySelector('.toggle-text');

            const isHidden = extraItems[0].classList.contains('hidden');

            extraItems.forEach(item => {
                if (isHidden) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });

            if (text) {
                text.textContent = isHidden ? 'Tampilkan Lebih Sedikit' : 'Lihat Selengkapnya';
            }

            if (icon) {
                icon.style.transform = isHidden ? 'rotate(180deg)' : 'rotate(0deg)';
            }
        }

        // Additional utility functions
        function formatCurrency(amount) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(amount);
        }

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
    </script>

    <!-- Enhanced Floating Price Section -->
    <div class="fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-sm border-t border-gray-200 shadow-2xl z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-3 sm:py-4 gap-3 sm:gap-0">
                <div class="flex-1 min-w-0">
                    <div class="text-xs sm:text-sm text-gray-600 font-medium">Harga mulai dari</div>
                    <div class="text-lg sm:text-xl font-bold text-gray-900 truncate">
                        Rp {{ number_format(min($jeepTrip->harga_weekday, $jeepTrip->harga_weekend), 0, ',', '.') }}/jeep
                    </div>
                    <div class="text-xs text-gray-500 mt-1 hidden sm:block">
                        Weekday: Rp {{ number_format($jeepTrip->harga_weekday, 0, ',', '.') }} |
                        Weekend: Rp {{ number_format($jeepTrip->harga_weekend, 0, ',', '.') }}
                    </div>
                </div>
                <div class="sm:ml-4 w-full sm:w-auto">
                    <a href="#calendar" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-2 lg:py-3 px-6 sm:px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg inline-block w-full sm:w-auto text-center">
                        <span class="flex items-center justify-center text-xs lg:text-sm">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 16a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"></path>
                            </svg>
                            Pesan Sekarang
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <style>
        body {
            padding-bottom: 120px;
        }
        @media (max-width: 640px) {
            body {
                padding-bottom: 76px;
            }
        }

        html {
            scroll-behavior: smooth;
        }
    </style>
</x-app-landing-layout>