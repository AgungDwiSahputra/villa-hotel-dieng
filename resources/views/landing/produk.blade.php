<x-app-landing-layout>
    <section class="relative py-12 bg-gradient-to-br from-blue-50 via-white to-green-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 animate-fade-in-up">
                    <div class="relative mb-8">
                        <div class="main-carousel rounded-2xl overflow-hidden shadow-2xl" data-flickity='{ "cellAlign": "center", "contain": true, "prevNextButtons": true, "pageDots": true, "autoPlay": 5000, "pauseAutoPlayOnHover": false, "wrapAround": true, "adaptiveHeight": false, "imagesLoaded": true }'>
                            @foreach ($produk->images as $image)
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
                                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">
                                            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    @if(isset($produk->category))
                        <div class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-6">
                            <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                            </svg>
                            {{ $produk->category->name }}
                        </div>
                    @endif
                    
                    <h4 class="text-3xl font-bold mb-6 text-gray-900 leading-tight">{{ $produk->name }}</h4>
                    
                    <div class="space-y-4">
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Ideal Untuk</p>
                                <p class="font-semibold text-gray-900">{{ $produk->orang }} orang</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Kapasitas Maksimal</p>
                                <p class="font-semibold text-gray-900">{{ $produk->maks_orang }} orang</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-purple-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Jumlah Kamar</p>
                                <p class="font-semibold text-gray-900">{{ $produk->kamar }} kamar</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-4">
                                <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Lokasi</p>
                                <p class="font-semibold text-gray-900">{{ $produk->lokasi }}</p>
                            </div>
                        </div>

                        <div class="flex items-center p-4 bg-yellow-50 rounded-xl">
                            <div class="flex text-yellow-400 mr-4">
                                @for ($i = 1; $i <= 5; $i++)
                                    <svg class="w-6 h-6 {{ $i <= $produk->rating ? 'fill-current' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                @endfor
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $produk->rating }}/5</p>
                                {{-- <p class="text-sm text-gray-600">{{ $produk->review_count ?? 0 }} ulasan</p> --}}
                            </div>
                        </div>

                        <div class="border-t pt-6 mt-6">
                            <h5 class="text-lg font-semibold text-gray-900 mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                </svg>
                                Deskripsi
                            </h5>
                            <p class="text-gray-700 leading-relaxed">{{ $produk->deskripsi ?? 'Belum ada deskripsi yang tersedia.' }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden animate-fade-in-up">
                    <div class="bg-gray-50 border-b border-gray-200">
                        <nav class="flex">
                            <button class="tab-button active flex-1 py-4 px-6 text-center font-semibold text-sm transition-all duration-200 border-b-2 border-blue-500 text-blue-600 bg-white"
                                    id="fasilitas-tab" data-bs-toggle="tab" data-bs-target="#fasilitas"
                                    type="button" role="tab" aria-controls="fasilitas" aria-selected="true">
                                <svg class="w-5 h-5 mx-auto mb-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3z"></path>
                                </svg>
                                Fasilitas
                            </button>
                            <button class="tab-button flex-1 py-4 px-6 text-center font-semibold text-sm transition-all duration-200 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100"
                                    id="wisata-tab" data-bs-toggle="tab" data-bs-target="#wisata"
                                    type="button" role="tab" aria-controls="wisata" aria-selected="false">
                                <svg class="w-5 h-5 mx-auto mb-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                                Wisata
                            </button>
                            <button class="tab-button flex-1 py-4 px-6 text-center font-semibold text-sm transition-all duration-200 border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100"
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
                        <div class="tab-pane fade show active p-8" id="fasilitas" role="tabpanel"
                            aria-labelledby="fasilitas-tab">
                            @if ($produk->fasilitases->isNotEmpty())
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="fasilitas-list">
                                    @foreach ($produk->fasilitases as $index => $fasilitas)
                                        <div class="flex items-start p-4 bg-blue-50 rounded-xl {{ $index >= 6 ? 'hidden extra-fasilitas' : '' }} transition-all duration-200 hover:bg-blue-100">
                                            <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $fasilitas->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($produk->fasilitases->count() > 6)
                                    <div class="mt-6 text-center">
                                        <button class="text-blue-600 hover:text-blue-800 font-medium transition-colors duration-200 flex items-center mx-auto"
                                            onclick="toggleItems('fasilitas')">
                                            <span class="toggle-text">Lihat Selengkapnya</span>
                                            <svg class="w-4 h-4 ml-2 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
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
                        <div class="tab-pane fade p-8 hidden" id="wisata" role="tabpanel" aria-labelledby="wisata-tab">
                            @if ($produk->wisatas->isNotEmpty())
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4" id="wisata-list">
                                    @foreach ($produk->wisatas as $index => $wisata)
                                        <div class="flex items-start p-4 bg-green-50 rounded-xl {{ $index >= 6 ? 'hidden extra-wisata' : '' }} transition-all duration-200 hover:bg-green-100">
                                            <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                                </svg>
                                            </div>
                                            <span class="font-medium text-gray-800">{{ $wisata->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($produk->wisatas->count() > 6)
                                    <div class="mt-6 text-center">
                                        <button class="text-green-600 hover:text-green-800 font-medium transition-colors duration-200 flex items-center mx-auto"
                                            onclick="toggleItems('wisata')">
                                            <span class="toggle-text">Lihat Selengkapnya</span>
                                            <svg class="w-4 h-4 ml-2 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
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
                        <div class="tab-pane fade p-8 hidden" id="syarat" role="tabpanel" aria-labelledby="syarat-tab">
                            <div class="space-y-3" id="syarat-list">
                                @forelse ($produk->syarats as $index => $syarat)
                                    <div class="flex items-start p-4 bg-yellow-50 rounded-xl {{ $index >= 6 ? 'hidden extra-syarat' : '' }} transition-all duration-200 hover:bg-yellow-100">
                                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                            <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"></path>
                                            </svg>
                                        </div>
                                        <span class="font-medium text-gray-800">{{ $syarat->name }}</span>
                                    </div>
                                @empty
                                    <div class="text-center py-8 text-gray-500">
                                        <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 8a6 6 0 01-7.743 5.743L10 14l-1 1-1 1H6v2H2v-4l4.257-4.257A6 6 0 1118 8zm-6-4a1 1 0 100 2 2 2 0 012 2 1 1 0 102 0 4 4 0 00-4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        <p class="italic">Belum ada informasi syarat & ketentuan.</p>
                                    </div>
                                @endforelse
                            </div>
                            @if ($produk->syarats->count() > 6)
                                <div class="mt-6 text-center">
                                    <button class="text-yellow-600 hover:text-yellow-800 font-medium transition-colors duration-200 flex items-center mx-auto"
                                        onclick="toggleItems('syarat')">
                                        <span class="toggle-text">Lihat Selengkapnya</span>
                                        <svg class="w-4 h-4 ml-2 transition-transform duration-200" fill="currentColor" viewBox="0 0 20 20">
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

    <section class="py-12 bg-gradient-to-br from-gray-50 to-blue-50 animate-fade-in-up">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                    <h5 class="text-2xl font-bold mb-6 text-gray-900 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                        </svg>
                        Pilih Tanggal
                    </h5>
                    <div id="calendar" class="bg-white rounded-xl border border-gray-200 overflow-hidden"></div>
                </div>

                <div class="space-y-6">
                    <form action="{{ route('produk.booking') }}" method="POST" id="bookingForm">
                        @csrf
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-8 border border-blue-200" id="bookingInfoText">
                            <div class="text-center">
                                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <svg class="w-8 h-8 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">Cara Booking</h3>
                                <p class="text-gray-600 text-sm leading-relaxed">
                                    Pilih tanggal check-in dan check-out untuk melihat info harga sesuai tanggal,
                                    kemudian klik <span class="font-bold text-blue-600">"Booking Sekarang"</span>
                                </p>
                            </div>
                        </div>

                        <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100 hidden" id="bookingSummary">
                            <h5 class="text-2xl font-bold mb-6 text-gray-900 flex items-center">
                                <svg class="w-6 h-6 mr-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                </svg>
                                Ringkasan Booking
                            </h5>
                            <div class="space-y-4">
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                    <span class="font-medium text-gray-700 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Check-in
                                    </span>
                                    <input type="date" name="start_date" id="startDateInput"
                                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium" readonly>
                                </div>
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                    <span class="font-medium text-gray-700 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                        Check-out
                                    </span>
                                    <input type="date" name="end_date" id="endDateInput"
                                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium" readonly>
                                </div>
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                    <span class="font-medium text-gray-700 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                                        </svg>
                                        Jumlah Malam
                                    </span>
                                    <input type="number" name="night" id="nightInput"
                                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium w-20 text-center" readonly>
                                </div>
                                <div class="flex justify-between items-center p-4 bg-gray-50 rounded-xl">
                                    <span class="font-medium text-gray-700 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-indigo-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3z"></path>
                                        </svg>
                                        Jumlah Unit
                                    </span>
                                    <input type="number" name="unit" id="unit" min="1" value="1"
                                           class="px-4 py-2 border border-gray-300 rounded-lg text-sm font-medium w-20 text-center focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                </div>
                                <div class="flex justify-between items-center p-4 bg-yellow-50 rounded-xl">
                                    <span class="font-medium text-gray-700 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z"></path>
                                        </svg>
                                        DP ({{ $settings['dp'] ?? null }} %)
                                    </span>
                                    <input type="number" name="dp" id="dpInput"
                                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-sm font-medium w-32 text-right" readonly>
                                </div>
                                <div class="flex justify-between items-center p-4 bg-green-50 rounded-xl">
                                    <span class="font-bold text-gray-900 flex items-center">
                                        <svg class="w-5 h-5 mr-2 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582z"></path>
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.51-1.31c-.562-.649-1.413-1.076-2.353-1.253V5z" clip-rule="evenodd"></path>
                                        </svg>
                                        Total Harga
                                    </span>
                                    <input type="number" name="total" id="totalInput"
                                            class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-lg font-bold text-green-600 w-40 text-right" readonly>
                                </div>
                            </div>
                            <div class="mt-8">
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-4 px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg">
                                    <span class="flex items-center justify-center">
                                        <svg class="w-6 h-6 mr-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 16a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"></path>
                                        </svg>
                                        Booking Sekarang
                                    </span>
                                </button>
                            </div>
                        </div>
                    </form>

                    <div class="bg-white rounded-2xl shadow-xl p-8 border border-gray-100">
                        <h5 class="text-lg font-semibold mb-6 text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                            </svg>
                            Informasi Penting
                        </h5>
                        <ul class="space-y-4">
                            <li class="flex items-start p-4 bg-blue-50 rounded-xl">
                                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700">Pemesanan akan dikenakan <span class="font-bold text-blue-600">DP sebesar {{ $settings['dp'] ?? '25' }}%</span> dari total harga</span>
                            </li>
                            <li class="flex items-start p-4 bg-green-50 rounded-xl">
                                <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700">Pilih tanggal check in dan check out pada kalender kemudian klik tombol <span class="font-bold text-green-600">Booking Sekarang</span> untuk pemesanan</span>
                            </li>
                            <li class="flex items-start p-4 bg-purple-50 rounded-xl">
                                <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                    </svg>
                                </div>
                                <span class="text-gray-700">Setelah pembayaran, Anda selaku pemesan akan mendapatkan notifikasi melalui <span class="font-bold text-purple-600">Whatsapp Admin</span></span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-12 bg-white animate-fade-in-up">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <h5 class="text-3xl font-bold mb-8 text-gray-900 text-center flex items-center justify-center">
                <svg class="w-8 h-8 mr-3 text-blue-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                </svg>
                Rekomendasi Lainnya
            </h5>
            <div class="grid grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6 lg:gap-8 max-w-4xl mx-auto px-2 md:px-0">
                @foreach ($rekomendasis as $item)
                    <x-villa-card :villa="$item" :show-category="true" :show-rating="true" :show-price="true" :show-button="true" />
                @endforeach
            </div>
        </div>
    </section>

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" />
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

            /* Optimized Mobile Responsive Adjustments */
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
        <script>
            // Wait for all libraries to be loaded
            document.addEventListener('DOMContentLoaded', function() {
                // Safe GLightbox initialization
                if (typeof GLightbox !== 'undefined') {
                    const lightbox = GLightbox({
                        selector: '.glightbox'
                    });
                }
                
                // Initialize data
                const produkUnit = {{ $produk->unit }};
                const promoWeekday = {{ $produk->isPromo() ? 'true' : 'false' }};
                const hargaWeekday = {{ $produk->isPromo() ? $produk->getPromoPriceWeekday() : $produk->harga_weekday }};
                const hargaWeekend = {{ $produk->isPromo() ? $produk->getPromoPriceWeekend() : $produk->harga_weekend }};
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
                    <div class="text-xs sm:text-sm text-gray-600 font-medium">Harga mulai dari</div>
                    <div class="text-lg sm:text-xl font-bold text-gray-900 truncate">
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
                    <a href="#calendar" class="bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white font-bold py-3 px-6 sm:px-8 rounded-xl transition-all duration-300 transform hover:scale-105 shadow-lg inline-block w-full sm:w-auto text-center">
                        <span class="flex items-center justify-center">
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
                padding-bottom: 140px; 
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
</x-app-landing-layout>
