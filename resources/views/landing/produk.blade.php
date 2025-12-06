<x-app-landing-layout>
    <section class="relative py-5 lg:py-12 bg-gradient-to-br from-blue-50 via-white to-green-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-5 lg:gap-8">
                <!-- Detail Unit -->
                <div class="bg-white rounded-2xl shadow-xl p-2 lg:p-8 border border-gray-100 animate-fade-in-up">
                    <div class="relative mb-8">
                        <div class="main-carousel rounded-2xl overflow-hidden shadow-2xl max-h-48 lg:max-h-64" data-flickity='{ "cellAlign": "center", "contain": true, "prevNextButtons": true, "pageDots": true, "autoPlay": 5000, "pauseAutoPlayOnHover": false, "wrapAround": true, "adaptiveHeight": false, "imagesLoaded": true }'>
                            @forelse ($produk->images as $image)
                                <div class="carousel-cell relative">
                                    <div class="relative aspect-[4/3]">
                                        @if($produk->isPromo())
                                            <div class="absolute top-3 left-3 z-20">
                                                <span class="bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-bold px-4 py-2 rounded-full shadow-xl animate-pulse">
                                                    {{ $produk->getPromoDiscountPercentage() > 0 ? 'PROMO ' . $produk->getPromoDiscountPercentage() . '%' : 'PROMO' }}
                                                </span>
                                            </div>
                                        @endif
                                        <a href="{{ asset('storage/' . $image->image) }}" class="glightbox block group" data-gallery="gallery1">
                                            <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->name }}"
                                                class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        </a>
                                    </div>
                                </div>
                            @empty
                                <div class="carousel-cell relative">
                                    <div class="relative aspect-[4/3]">
                                        @if($produk->isPromo())
                                            <div class="absolute top-3 left-3 z-20">
                                                <span class="bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-bold px-4 py-2 rounded-full shadow-xl animate-pulse">
                                                    {{ $produk->getPromoDiscountPercentage() > 0 ? 'PROMO ' . $produk->getPromoDiscountPercentage() . '%' : 'PROMO' }}
                                                </span>
                                            </div>
                                        @endif
                                        <a href="{{ asset('images/produk/default.jpg') }}" class="glightbox block group" data-gallery="gallery1">
                                            <img src="{{ asset('images/produk/default.jpg') }}" alt="Gambar Default Produk"
                                                class="w-full h-full object-cover object-center transition-transform duration-700 group-hover:scale-105">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        </a>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                    </div>
                    
                    @if(isset($produk->category))
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-xs lg:text-sm font-medium bg-blue-100 text-blue-800 mb-3">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            {{ $produk->category->name }}
                        </div>
                    @endif
                    
                    <h4 class="text-lg sm:text-3xl font-bold mb-2 lg:mb-6 text-gray-900 leading-tight">{{ $produk->name }}</h4>
                    
                    <div class="space-y-2">
                        <!-- Product Details Grid -->
                        <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-3 lg:p-6">
                            <div class="grid grid-cols-2 gap-6">
                                <div class="flex items-start space-x-3">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">Ideal Untuk</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $produk->orang }} orang</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3">
                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">Kapasitas Maksimal</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $produk->maks_orang }} orang</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3">

                                    <div>
                                        <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">Jumlah Kamar</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $produk->kamar }} kamar</p>
                                    </div>
                                </div>

                                <div class="flex items-start space-x-3">
                                    <div class="flex-1">
                                        <p class="text-xs text-gray-500 uppercase tracking-wider font-medium">Lokasi</p>
                                        <p class="text-sm font-semibold text-gray-900">{{ $produk->lokasi }}</p>
                                        <button onclick="showMapModal()" class="mt-1 text-xs text-blue-600 hover:text-blue-800 underline transition-colors duration-200">
                                            Lihat di Peta
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rating Section -->
                        <div class="bg-white rounded-lg border border-gray-100 shadow-sm p-3 py-2 lg:p-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <span class="text-sm font-medium text-gray-700">Rating</span>
                                </div>
                                <div class="flex items-center space-x-1">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <svg class="w-5 h-5 {{ $i <= $produk->rating ? 'text-yellow-400 fill-current' : 'text-gray-300' }}" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endfor
                                    <span class="ml-2 text-sm font-semibold text-gray-900">{{ $produk->rating }}/5</span>
                                </div>
                            </div>
                        </div>

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
                            <p class="text-xs lg:text-sm text-gray-700 leading-relaxed">{{ $produk->deskripsi ?? 'Belum ada deskripsi yang tersedia.' }}</p>
                        </div>
                    </div>
                </div>

                <!-- Informasi Fasilitas -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden animate-fade-in-up">
                    <div class="bg-gray-50 border-b border-gray-200">
                        <nav class="flex">
                            <button class="tab-button active flex-1 py-2 lg:py-4 px-6 text-center font-semibold text-xs lg:text-sm transition-all duration-200 border-b-2 border-blue-500 text-blue-600 bg-white"
                                    id="fasilitas-tab" data-bs-toggle="tab" data-bs-target="#fasilitas"
                                    type="button" role="tab" aria-controls="fasilitas" aria-selected="true">
                                <svg class="w-5 h-5 mx-auto mb-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"></path>
                                </svg>
                                Fasilitas
                            </button>
                            <button class="tab-button flex-1 py-2 lg:py-4 px-6 text-center font-semibold text-xs lg:text-sm transition-all duration-200 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100"
                                    id="wisata-tab" data-bs-toggle="tab" data-bs-target="#wisata"
                                    type="button" role="tab" aria-controls="wisata" aria-selected="false">
                                <svg class="w-5 h-5 mx-auto mb-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                                Wisata
                            </button>
                            <button class="tab-button flex-1 py-2 lg:py-4 px-6 text-center font-semibold text-xs lg:text-sm transition-all duration-200 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100"
                                    id="syarat-tab" data-bs-toggle="tab" data-bs-target="#syarat"
                                    type="button" role="tab" aria-controls="syarat" aria-selected="false">
                                <svg class="w-5 h-5 mx-auto mb-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"></path>
                                </svg>
                                S & K
                            </button>
                        </nav>
                    </div>

                    <!-- Enhanced Tab Content -->
                    <div class="tab-content">
                        {{-- Fasilitas --}}
                        <div class="tab-pane fade show active p-2 lg:p-8" id="fasilitas" role="tabpanel"
                            aria-labelledby="fasilitas-tab">
                            @if ($produk->fasilitases->isNotEmpty())
                                <div class="grid grid-cols-2 gap-2" id="fasilitas-list">
                                    @foreach ($produk->fasilitases as $index => $fasilitas)
                                        <div class="flex items-center p-2 lg:p-3 bg-gray-50 rounded-lg {{ $index >= 6 ? 'hidden extra-fasilitas' : '' }} transition-all duration-200 hover:bg-gray-100">
                                            <div class="flex-shrink-0 w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center mr-3">
                                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <span class="text-xs lg:text-sm font-medium text-gray-700">{{ $fasilitas->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($produk->fasilitases->count() > 10)
                                    <div class="mt-2 lg:mt-4 text-center">
                                        <button class="text-sm text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200 inline-flex items-center"
                                            onclick="toggleItems('fasilitas')">
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
                                    <p class="italic">Belum ada informasi fasilitas.</p>
                                </div>
                            @endif
                        </div>

                        {{-- Wisata --}}
                        <div class="tab-pane fade p-2 lg:p-8 hidden" id="wisata" role="tabpanel" aria-labelledby="wisata-tab">
                            @if ($produk->wisatas->isNotEmpty())
                                <div class="grid grid-cols-2 gap-2" id="wisata-list">
                                    @foreach ($produk->wisatas as $index => $wisata)
                                        <div class="flex items-center p-2 lg:p-3 bg-gray-50 rounded-lg {{ $index >= 6 ? 'hidden extra-wisata' : '' }} transition-all duration-200 hover:bg-gray-100">
                                            <div class="flex-shrink-0 w-5 h-5 bg-green-500 rounded-full flex items-center justify-center mr-3">
                                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <span class="text-xs lg:text-sm font-medium text-gray-700">{{ $wisata->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($produk->wisatas->count() > 10)
                                    <div class="mt-2 lg:mt-4 text-center">
                                        <button class="text-xs lg:text-sm text-green-600 hover:text-green-800 font-medium transition-colors duration-200 inline-flex items-center"
                                            onclick="toggleItems('wisata')">
                                            <span class="toggle-text">Lihat Selengkapnya</span>
                                            <svg class="w-4 h-4 ml-1 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                            </svg>
                                        </button>
                                    </div>
                                @endif
                            @else
                                <div class="text-center py-8 text-gray-500">
                                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <p class="italic">Belum ada informasi wisata terdekat.</p>
                                </div>
                            @endif
                        </div>

                        {{-- Syarat --}}
                        <div class="tab-pane fade p-2 lg:p-8 hidden" id="syarat" role="tabpanel" aria-labelledby="syarat-tab">
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-2" id="syarat-list">
                                @forelse ($produk->syarats as $index => $syarat)
                                    <div class="flex items-center p-2 lg:p-3 bg-gray-50 rounded-lg {{ $index >= 6 ? 'hidden extra-syarat' : '' }} transition-all duration-200 hover:bg-gray-100">
                                        <div class="flex-shrink-0 w-5 h-5 bg-yellow-500 rounded-full flex items-center justify-center mr-3">
                                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <span class="text-xs lg:text-sm font-medium text-gray-700">{{ $syarat->name }}</span>
                                    </div>
                                @empty
                                    <div class="col-span-full text-center py-6 text-gray-500">
                                        <svg class="w-8 h-8 mx-auto mb-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="text-sm italic">Belum ada informasi syarat & ketentuan.</p>
                                    </div>
                                @endforelse
                            </div>
                            @if ($produk->syarats->count() > 10)
                                <div class="mt-2 lg:mt-4 text-center">
                                    <button class="text-xs lg:text-sm text-yellow-600 hover:text-yellow-800 font-medium transition-colors duration-200 inline-flex items-center"
                                        onclick="toggleItems('syarat')">
                                        <span class="toggle-text">Lihat Selengkapnya</span>
                                        <svg class="w-4 h-4 ml-1 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path>
                                        </svg>
                                    </button>
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
                    <form action="{{ route('produk.booking') }}" method="POST" id="bookingForm">
                        @csrf
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-2 lg:p-8 border border-blue-200" id="bookingInfoText">
                            <div class="text-center">
                                <div class="w-12 h-12 lg:w-16 lg:h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-2 lg:mb-4">
                                    <svg class="w-6 h-6 lg:w-8 lg:h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h3 class="text-sm sm:text-lg font-semibold text-gray-900 mb-2">Cara Booking</h3>
                                <p class="text-xs sm:text-sm text-gray-600 leading-relaxed">
                                    Pilih tanggal check-in dan check-out untuk melihat info harga sesuai tanggal,
                                    kemudian klik <span class="font-bold text-blue-600">"Booking Sekarang"</span>
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
                                        Check-in
                                    </span>
                                    <input type="date" name="start_date" id="startDateInput" class="px-3 lg:px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs lg:text-sm font-medium" readonly="">
                                </div>
                                <div class="flex justify-between items-center p-2 lg:p-4 bg-gray-50 rounded-xl">
                                    <span class="text-xs lg:text-sm font-medium text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Check-out
                                    </span>
                                    <input type="date" name="end_date" id="endDateInput" class="px-3 lg:px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs lg:text-sm font-medium" readonly="">
                                </div>
                                <div class="flex justify-between items-center p-2 lg:p-4 bg-gray-50 rounded-xl">
                                    <span class="text-xs lg:text-sm font-medium text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                        </svg>
                                        Jumlah Malam
                                    </span>
                                    <input type="number" name="night" id="nightInput" class="px-3 lg:px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs lg:text-sm font-medium w-16 lg:w-20 text-center" readonly="">
                                </div>
                                <div class="flex justify-between items-center p-2 lg:p-4 bg-gray-50 rounded-xl">
                                    <span class="text-xs lg:text-sm font-medium text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                        </svg>
                                        Jumlah Unit
                                    </span>
                                    <input type="number" name="unit" id="unit" min="1" value="1" class="px-3 lg:px-4 py-2 border border-gray-300 rounded-lg text-xs lg:text-sm font-medium w-16 lg:w-20 text-center focus:ring-2 focus:ring-blue-500 focus:border-transparent" max="3">
                                </div>
                                <div class="flex justify-between items-center p-2 lg:p-4 bg-yellow-50 rounded-xl">
                                    <span class="text-xs lg:text-sm font-medium text-gray-700 flex items-center">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                        </svg>
                                        DP (25 %)
                                    </span>
                                    <input type="number" name="dp" id="dpInput" class="px-3 lg:px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs lg:text-sm font-medium w-24 lg:w-32 text-right" readonly="">
                                </div>
                                <div class="flex justify-between items-center p-2 lg:p-4 bg-green-50 rounded-xl">
                                    <span class="text-xs lg:text-sm font-bold text-gray-900 flex items-center">
                                        <svg class="w-4 h-4 lg:w-5 lg:h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582z"></path>
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.51-1.31c-.562-.649-1.413-1.076-2.353-1.253V5z" clip-rule="evenodd"></path>
                                        </svg>
                                        Total Harga
                                    </span>
                                    <input type="number" name="total" id="totalInput" class="px-3 lg:px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm lg:text-lg font-bold text-green-600 w-32 lg:w-40 text-right" readonly="">
                                </div>
                            </div>
                            <div class="mt-6 lg:mt-8">
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-2 lg:py-4 px-6 lg:px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <span class="text-xs lg:text-sm flex items-center justify-center">
                                        <svg class="w-5 h-5 lg:w-6 lg:h-6 mr-2 lg:mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 16a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"></path>
                                        </svg>
                                        Booking Sekarang
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
                                <span class="text-xs sm:text-base text-gray-700">Pemesanan akan dikenakan <span class="font-bold text-blue-600">DP sebesar {{ $settings['dp'] ?? '25' }}%</span> dari total harga</span>
                            </li>
                            <li class="flex items-start p-3 lg:p-4 bg-green-50 rounded-xl">
                                <div class="w-6 h-6 lg:w-8 lg:h-8 bg-green-500 rounded-full flex items-center justify-center mr-2 lg:mr-3 flex-shrink-0">
                                    <svg class="w-3 h-3 lg:w-4 lg:h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-xs sm:text-base text-gray-700">Pilih tanggal check in dan check out pada kalender kemudian klik tombol <span class="font-bold text-green-600">Booking Sekarang</span> untuk pemesanan</span>
                            </li>
                            <li class="flex items-start p-3 lg:p-4 bg-purple-50 rounded-xl">
                                <div class="w-6 h-6 lg:w-8 lg:h-8 bg-purple-500 rounded-full flex items-center justify-center mr-2 lg:mr-3 flex-shrink-0">
                                    <svg class="w-3 h-3 lg:w-4 lg:h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                </div>
                                <span class="text-xs sm:text-base text-gray-700">Setelah pembayaran, Anda selaku pemesan akan mendapatkan notifikasi melalui <span class="font-bold text-purple-600">Whatsapp Admin</span></span>
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
            <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 lg:gap-6 xl:gap-8 max-w-4xl mx-auto px-2 md:px-0">
                @foreach ($rekomendasis as $item)
                    <x-villa-card :villa="$item" :show-category="true" :show-rating="true" :show-price="true" :show-button="true" />
                @endforeach
            </div>
        </div>
    </section>

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
        <style>
            .glightbox-clean .gclose {
                position: fixed !important;
                top: 1rem;
                right: 1rem;
                z-index: 9999 !important;
                background: none !important;
                border: none !important;
                color: white !important;
                font-size: 2rem;
                line-height: 1;
                padding: 0;
                cursor: pointer;
            }

            .glightbox-clean .gclose::before {
                content: "✕";
                font-size: 2rem;
                display: block;
            }

            /* Enhanced Calendar Styles */
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

            .fc-daygrid-day.selected-start,
            .fc-daygrid-day.in-range,
            .fc-daygrid-day.selected-end {
                background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
                position: relative;
            }

            .fc-daygrid-day.selected-start {
                border-top-left-radius: 50px;
                border-bottom-left-radius: 50px;
            }

            .fc-daygrid-day.selected-end {
                border-top-right-radius: 50px;
                border-bottom-right-radius: 50px;
            }

            .fc-daygrid-day.selected-start .fc-daygrid-day-number,
            .fc-daygrid-day.in-range .fc-daygrid-day-number,
            .fc-daygrid-day.selected-end .fc-daygrid-day-number {
                border-radius: 50%;
                width: 75px;
                height: 75px;
                display: flex;
                justify-content: center;
                align-items: center;
                position: relative;
                z-index: 2;
            }

            .fc-daygrid-day.in-range .fc-daygrid-day-number {
                background-color: transparent;
                color: #fff;
            }

            .fc-daygrid-day.selected-start .fc-daygrid-day-frame,
            .fc-daygrid-day.selected-end .fc-daygrid-day-frame {
                background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);
                color: #fff;
                border-radius: 50%;
            }

            .fc-daygrid-day.selected-start .fc-daygrid-day-number,
            .fc-daygrid-day.selected-end .fc-daygrid-day-number {
                color: #fff;
            }

            .fc-daygrid-day.selected-start.selected-end {
                background-color: transparent;
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

            .fc-daygrid-day.in-range::before {
                display: none !important;
            }

            /* Enhanced Tab Styles */
            .tab-button.active {
                background: white;
                border-color: #3b82f6;
                color: #3b82f6;
            }

            .tab-button:not(.active) {
                border-color: transparent;
                color: #6b7280;
            }

            .tab-button:not(.active):hover {
                border-color: #d1d5db;
                color: #374151;
                background: #f9fafb;
            }

            /* Custom Animations - Standardized with index.blade.php */
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

            /* Fallback untuk memastikan elemen tetap terlihat */
            body.no-js .animate-fade-in-up {
                opacity: 1 !important;
                transform: translateY(0) !important;
                animation: none !important;
            }

            /* Fallback untuk elemen yang tidak teranimasi */
            @media (prefers-reduced-motion: reduce) {
                .animate-fade-in-up,
                .animate-fade-in-up-active {
                    opacity: 1 !important;
                    transform: translateY(0) !important;
                    animation: none !important;
                    transition: none !important;
                }
            }

            /* Custom Scrollbar */
            .custom-scrollbar::-webkit-scrollbar {
                width: 6px;
            }

            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f1f5f9;
                border-radius: 10px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #cbd5e1;
                border-radius: 10px;
            }

            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #94a3b8;
            }

            /* Flickity Custom */
            .flickity-page-dots .dot {
                color: white;
                background: white;
            }
            @media (max-width:768px){
                .flickity-button.flickity-prev-next-button.next,
                .flickity-button.flickity-prev-next-button.previous {
                    scale: 0.7;
                }
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
            @media (max-width: 640px) {
                .fc-daygrid-day.selected-start .fc-daygrid-day-number,
                .fc-daygrid-day.in-range .fc-daygrid-day-number,
                .fc-daygrid-day.selected-end .fc-daygrid-day-number {
                    width: 50px;
                    height: 50px;
                    font-size: 14px;
                }
            }
        </style>
    @endpush

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
        <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
        <script>
            // Wait for all libraries to be loaded
            document.addEventListener('DOMContentLoaded', function() {
                // Safe GLightbox initialization
                if (typeof GLightbox !== 'undefined') {
                    const lightbox = GLightbox({
                        selector: '.glightbox'
                    });
                }
                
                // Initialize data - Always send original prices to checkout for promo code flexibility
                const produkUnit = {{ $produk->unit }};
                const promoWeekday = {{ $produk->isPromo() ? 'true' : 'false' }};
                // Always use original prices for checkout calculation (promo code will be applied there)
                // Even if product has active promo, send original prices to checkout
                const hargaWeekday = {{ $produk->isPromo() ? $produk->getPromoPriceWeekday() : $produk->harga_weekday }};
                const hargaWeekend = {{ $produk->isPromo() ? $produk->getPromoPriceWeekend() : $produk->harga_weekend }};
                // const hargaWeekday = {{ $produk->harga_weekday }};
                // const hargaWeekend = {{ $produk->harga_weekend }};
                const originalWeekday = {{ $produk->harga_weekday }};
                const originalWeekend = {{ $produk->harga_weekend }};
                const bookedPerDate = @json($booked);
                
                let startDate = null,
                    endDate = null,
                    basePrice = 0;

                const isWeekend = d => [0, 6].includes(d.getDay());

                const calculatePrice = (start, end) => {
                    let total = 0,
                        days = (end - start) / 86400000;
                    for (let i = 0; i < days; i++) {
                        let d = new Date(start);
                        d.setDate(start.getDate() + i);
                        total += isWeekend(d) ? hargaWeekend : hargaWeekday;
                    }
                    return {
                        nights: days,
                        price: total
                    };
                };

                const updateMaxUnit = (start, end) => {
                    let min = produkUnit;
                    for (let d = new Date(start); d < end; d.setDate(d.getDate() + 1)) {
                        let sisa = produkUnit - (bookedPerDate[d.toISOString().slice(0, 10)] || 0);
                        min = Math.min(min, sisa);
                    }
                    $('#unit').attr('max', min).val(function(_, val) {
                        return Math.min(val || 1, min);
                    });
                };

                const containsFull = (start, end) => {
                    for (let d = new Date(start); d < end; d.setDate(d.getDate() + 1)) {
                        if ((bookedPerDate[d.toISOString().slice(0, 10)] || 0) >= produkUnit) return true;
                    }
                    return false;
                };

                function changeUnit() {
                    const dpPercent = {{ intval($settings['dp'] ?? 0) }};
                    const unit = parseInt($('#unit').val()) || 0;
                    const total = unit * basePrice;
                    const dp = total * dpPercent / 100;

                    // Always send original price to checkout for promo code flexibility
                    $('#totalInput').val(total);
                    $('#dpInput').val(dp);
                }

                function highlightRange(start, end) {
                    $('.fc-daygrid-day').removeClass('selected-start selected-end in-range').each(function() {
                        const dateStr = $(this).data('date');
                        if (!dateStr) return;
                        const date = new Date(dateStr + 'T12:00:00');
                        if (date.getTime() === start.getTime()) $(this).addClass('selected-start');
                        else if (date.getTime() === end.getTime()) $(this).addClass('selected-end');
                        else if (date > start && date < end) $(this).addClass('in-range');
                    });
                }

                function initializeComponents() {
                    // Safe Flickity initialization
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

                    // Safe Calendar initialization
                    if (typeof FullCalendar !== 'undefined' && $('#calendar').length) {
                        try {
                            const calendar = new FullCalendar.Calendar($('#calendar')[0], {
                                locale: 'id',
                                initialView: 'dayGridMonth',
                                fixedWeekCount: false,
                                height: 'auto',
                                headerToolbar: {
                                    left: 'prev',
                                    center: 'title',
                                    right: 'next'
                                },
                                validRange: now => ({
                                    start: now.toISOString().slice(0, 10)
                                }),
                                dateClick: ({
                                    dateStr
                                }) => {
                                    const clicked = new Date(dateStr + 'T12:00:00');
                                    const sisa = produkUnit - (bookedPerDate[dateStr] || 0);

                                    if (sisa <= 0 && (!startDate || endDate)) return;

                                    if (!startDate || endDate || clicked < startDate) {
                                        startDate = clicked;
                                        endDate = null;
                                        basePrice = 0;
                                        $('#bookingSummary').addClass('hidden');
                                        $('#bookingInfoText').removeClass('hidden');
                                        $('#unit').attr('max', sisa);
                                        changeUnit();
                                        highlightRange(startDate, startDate);
                                    } else {
                                        if (containsFull(startDate, clicked)) return alert(
                                            'Tanggal termasuk yang penuh.');
                                        endDate = clicked;
                                        highlightRange(startDate, endDate);

                                        const {
                                            nights,
                                            price
                                        } = calculatePrice(startDate, endDate);
                                        basePrice = price;
                                        changeUnit();
                                        updateMaxUnit(startDate, endDate);

                                        $('#nightInput').val(nights);
                                        $('#startDateInput').val(startDate.toISOString().slice(0, 10));
                                        $('#endDateInput').val(endDate.toISOString().slice(0, 10));
                                        $('#bookingSummary').removeClass('hidden');
                                        $('#bookingInfoText').addClass('hidden');
                                    }
                                },
                                dayCellDidMount: ({
                                    el,
                                    date
                                }) => {
                                    const dateStr = date.toISOString().slice(0, 10);
                                    const nextDate = new Date(date.getTime());
                                    nextDate.setDate(nextDate.getDate() + 1);
                                    const nextDateStr = nextDate.toISOString().slice(0, 10);

                                    if ((bookedPerDate[nextDateStr] || 0) >= produkUnit) {
                                        $(el).addClass('disabled-date').css({
                                            backgroundColor: '#fee2e2',
                                            color: '#dc2626',
                                            pointerEvents: 'none',
                                            cursor: 'not-allowed',
                                            position: 'relative'
                                        }).append(
                                            `<div style="position:absolute;bottom:0;left:50%;transform:translateX(-50%);font-size:0.75em;font-weight:bold;color:#dc2626;margin-bottom:-5px;">Penuh</div>`
                                        );
                                    }
                                }
                            });

                            calendar.render();
                            $('#unit').on('input', changeUnit);
                        } catch (e) {
                            console.warn('Calendar initialization error:', e);
                        }
                    }

                    // Safe Tab functionality
                    $('.tab-button').on('click', function() {
                        const target = $(this).data('bs-target');
                        if (!target) return;
                        
                        // Remove active class from all tabs
                        $('.tab-button').removeClass('active border-blue-500 text-blue-600 bg-white').addClass('border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100');
                        
                        // Add active class to clicked tab
                        $(this).removeClass('border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100').addClass('active border-blue-500 text-blue-600 bg-white');
                        
                        // Hide all tab panes
                        $('.tab-pane').removeClass('show active').addClass('hidden');
                        
                        // Show target tab pane
                        $(target).removeClass('hidden').addClass('show active');
                    });

                    // Enhanced animation system - same as index.blade.php
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

                    // Initial call
                    animateOnScroll();
                    
                    // Add scroll listener
                    window.addEventListener('scroll', animateOnScroll);

                    // Force activate animations for elements already in viewport
                    setTimeout(() => {
                        const elementsInView = document.querySelectorAll('.animate-fade-in-up');
                        elementsInView.forEach(element => {
                            const rect = element.getBoundingClientRect();
                            if (rect.top < window.innerHeight && rect.bottom > 0) {
                                element.classList.add('animate-fade-in-up-active');
                            }
                        });
                    }, 100);

                    // Fallback: Add fallback-visible class if animations cause issues
                    setTimeout(() => {
                        const unactivatedElements = document.querySelectorAll('.animate-fade-in-up:not(.animate-fade-in-up-active)');
                        if (unactivatedElements.length > 5) {
                            document.body.classList.add('no-js');
                            console.log(`Added no-js class. ${unactivatedElements.length} elements not activated.`);
                        }
                    }, 2000);
                }

                // Initialize when libraries are ready
                if (document.readyState === 'loading') {
                    document.addEventListener('DOMContentLoaded', initializeComponents);
                } else {
                    initializeComponents();
                }
            });
        </script>

        <!-- Leaflet Map Modal Script -->
        <script>
            let produkMap = null;
            let produkMarkers = [];

            // Data produk dengan koordinat dari controller
            const produkData = @json($produkData);

            function showMapModal() {
                const modal = document.getElementById('mapModal');
                modal.classList.remove('hidden');

                // Initialize map after modal is shown
                setTimeout(() => {
                    initializeProdukMap();
                }, 100);

                // Prevent body scroll when modal is open
                document.body.style.overflow = 'hidden';
            }

            function closeMapModal() {
                const modal = document.getElementById('mapModal');
                modal.classList.add('hidden');

                // Restore body scroll
                document.body.style.overflow = 'auto';

                // Clean up map
                if (produkMap) {
                    produkMap.remove();
                    produkMap = null;
                    produkMarkers = [];
                }
            }

            function initializeProdukMap() {
                if (produkMap) return; // Prevent re-initialization

                // Default center (Indonesia)
                const defaultLat = -7.7956;
                const defaultLng = 110.3695;

                // Initialize map
                produkMap = L.map('produkMap').setView([defaultLat, defaultLng], 8);

                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(produkMap);

                // Create custom icon for markers
                const customIcon = L.icon({
                    iconUrl: '{{ asset("assets/images/home-location.svg") }}',
                    iconSize: [32, 32], // Size of the icon
                    iconAnchor: [16, 32], // Point of the icon which corresponds to marker's location
                    popupAnchor: [0, -32], // Point from which the popup should open relative to the iconAnchor
                    shadowUrl: null, // No shadow
                    shadowSize: null,
                    shadowAnchor: null
                });

                // Add markers for each product
                let bounds = [];
                produkData.forEach(produk => {
                    if (produk.latitude && produk.longitude) {
                        const marker = L.marker([produk.latitude, produk.longitude], {
                            icon: customIcon
                        })
                            .addTo(produkMap)
                            .bindPopup(`
                                <div class="p-3 max-w-xs">
                                    <h3 class="font-bold text-gray-900 text-sm mb-2">${produk.name}</h3>
                                    <p class="text-xs text-gray-600 mb-2">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314-9.894 8 8 0 01-1.314 9.894z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                        </svg>
                                        ${produk.lokasi}
                                    </p>
                                    <div class="text-xs text-gray-600 mb-3">
                                        <div class="flex justify-between">
                                            <span>Weekday:</span>
                                            <span class="font-medium">Rp ${produk.harga_weekday.toLocaleString('id-ID')}</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span>Weekend:</span>
                                            <span class="font-medium">Rp ${produk.harga_weekend.toLocaleString('id-ID')}</span>
                                        </div>
                                    </div>
                                    <a href="${window.location.origin}/produk/${produk.slug}"
                                       class="inline-block w-full text-center bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium py-2 px-3 rounded transition-colors">
                                        Lihat Detail
                                    </a>
                                </div>
                            `);

                        produkMarkers.push(marker);
                        bounds.push([produk.latitude, produk.longitude]);
                    }
                });

                // Fit map to show all markers if there are any
                if (bounds.length > 0) {
                    produkMap.fitBounds(bounds, { padding: [20, 20] });
                }

                // Add current product highlight if it has coordinates
                const currentProduk = @json($produk);
                if (currentProduk.latitude && currentProduk.longitude) {
                    // Create special icon for current product (highlighted version)
                    const currentIcon = L.icon({
                        iconUrl: '{{ asset("assets/images/home-location.svg") }}',
                        iconSize: [40, 40], // Slightly larger for current product
                        iconAnchor: [20, 40], // Adjusted anchor point
                        popupAnchor: [0, -40], // Adjusted popup anchor
                        shadowUrl: null,
                        shadowSize: null,
                        shadowAnchor: null,
                        className: 'current-product-marker' // Custom class for styling
                    });

                    // Add a special marker for current product
                    const currentMarker = L.marker([currentProduk.latitude, currentProduk.longitude], {
                        icon: currentIcon
                    })
                    .addTo(produkMap)
                    .bindPopup(`
                        <div class="p-3 max-w-xs">
                            <div class="flex items-center mb-2">
                                <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                                <h3 class="font-bold text-gray-900 text-sm">Lokasi Saat Ini</h3>
                            </div>
                            <h4 class="font-semibold text-gray-800 text-sm mb-1">${currentProduk.name}</h4>
                            <p class="text-xs text-gray-600">${currentProduk.lokasi}</p>
                        </div>
                    `);

                    // Open popup for current product
                    setTimeout(() => {
                        currentMarker.openPopup();
                    }, 500);
                }
            }

            // Close modal when clicking outside
            document.getElementById('mapModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeMapModal();
                }
            });

            // Close modal on Escape key
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && !document.getElementById('mapModal').classList.contains('hidden')) {
                    closeMapModal();
                }
            });
        </script>

        <style>
            /* Custom marker styles */
            .custom-marker {
                background: transparent !important;
                border: none !important;
            }

            /* Leaflet popup custom styles */
            .leaflet-popup-content-wrapper {
                border-radius: 12px !important;
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
            }

            .leaflet-popup-content {
                margin: 0 !important;
            }

            .leaflet-popup-tip {
                background-color: white !important;
            }

            /* Modal backdrop blur effect */
            #mapModal {
                backdrop-filter: blur(4px);
            }

            /* Custom marker styling for current product */
            .current-product-marker {
                filter: drop-shadow(0 0 8px rgba(239, 68, 68, 0.6)) !important;
                animation: pulse-glow 2s infinite;
            }

            @keyframes pulse-glow {
                0%, 100% {
                    filter: drop-shadow(0 0 8px rgba(239, 68, 68, 0.6));
                }
                50% {
                    filter: drop-shadow(0 0 12px rgba(239, 68, 68, 0.8));
                }
            }

            /* Responsive map height */
            @media (max-width: 768px) {
                #produkMap {
                    height: 300px !important;
                }
            }
        </style>
    @endpush

    <script>
        function toggleItems(type) {
            const extraItems = $('.extra-' + type);
            const button = $('button[onclick="toggleItems(\'' + type + '\')"]');
            
            if (!extraItems.length || !button.length) return;
            
            const icon = button.find('svg');
            const text = button.find('.toggle-text');

            if (extraItems.hasClass('hidden')) {
                extraItems.removeClass('hidden');
                if (text.length) text.text('Tampilkan Lebih Sedikit');
                if (icon.length) icon.css('transform', 'rotate(180deg)');
            } else {
                extraItems.addClass('hidden');
                if (text.length) text.text('Lihat Selengkapnya');
                if (icon.length) icon.css('transform', 'rotate(0deg)');
            }
        }
    </script>

    <!-- Enhanced Floating Price Section -->
    <div class="fixed bottom-0 left-0 right-0 bg-white/95 backdrop-blur-sm border-t border-gray-200 shadow-2xl z-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between py-3 sm:py-4 gap-3 sm:gap-0">
                <div class="flex-1 min-w-0">
                    <div class="text-xs text-gray-600 font-medium">Harga mulai dari</div>
                    <div class="text-sm sm:text-lg md:text-xl font-bold text-gray-900 truncate">
                        @if($produk->isPromo())
                            Rp {{ number_format(min($produk->getPromoPriceWeekday(), $produk->getPromoPriceWeekend()), 0, ',', '.') }}/malam
                            @if($produk->getPromoDiscountPercentage() > 0)
                                <span class="bg-gradient-to-r from-red-500 to-red-600 text-white text-xs font-bold px-2 py-1 sm:px-3 sm:py-1 rounded-full ml-1 sm:ml-2 animate-pulse">
                                    PROMO {{ $produk->getPromoDiscountPercentage() }}%
                                </span>
                            @endif
                        @else
                            Rp {{ number_format(min($produk->harga_weekday, $produk->harga_weekend), 0, ',', '.') }}/malam
                        @endif
                    </div>
                    <div class="text-xs text-gray-500 mt-1 hidden sm:block">
                        @if($produk->isPromo())
                            Weekday: Rp {{ number_format($produk->getPromoPriceWeekday(), 0, ',', '.') }}
                            <span class="text-gray-400 line-through">{{ number_format($produk->harga_weekday, 0, ',', '.') }}</span> |
                            Weekend: Rp {{ number_format($produk->getPromoPriceWeekend(), 0, ',', '.') }}
                            <span class="text-gray-400 line-through">{{ number_format($produk->harga_weekend, 0, ',', '.') }}</span>
                        @else
                            Weekday: Rp {{ number_format($produk->harga_weekday, 0, ',', '.') }} |
                            Weekend: Rp {{ number_format($produk->harga_weekend, 0, ',', '.') }}
                        @endif
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
    
    <!-- Enhanced Padding Bottom -->
    <style>
        body { 
            padding-bottom: 120px; 
        }
        @media (max-width: 640px) {
            body { 
                padding-bottom: 76px; 
            }
        }
        
        /* Enhanced Scroll Behavior */
        html {
            scroll-behavior: smooth;
        }
        
        /* Enhanced Loading Animation */
        @keyframes shimmer {
            0% {
                background-position: -200px 0;
            }
            100% {
                background-position: calc(200px + 100%) 0;
            }
        }
        
        .shimmer {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200px 100%;
            animation: shimmer 1.5s infinite;
        }
    </style>

    <!-- Add fallback for missing favicon -->
    <link rel="icon" type="image/x-icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🏨</text></svg>">

    <!-- Modal Peta LeafletJS -->
    <div id="mapModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-hidden">
                <!-- Modal Header -->
                <div class="flex items-center justify-between p-6 border-b border-gray-200">
                    <h3 class="text-sm sm:text-xl font-bold text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"></path>
                        </svg>
                        Peta Lokasi Villa & Hotel
                    </h3>
                    <button onclick="closeMapModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <div id="produkMap" class="w-full h-96 rounded-xl border border-gray-200"></div>

                    <!-- Map Info -->
                    <div class="mt-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                        <div class="flex items-start">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <p class="text-sm text-blue-800 font-medium">Informasi Peta</p>
                                <p class="text-xs sm:text-sm text-blue-700 mt-1">
                                    Klik pada marker untuk melihat detail villa/hotel. Peta menampilkan semua lokasi yang tersedia di Villa Hotel Dieng.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-landing-layout>

