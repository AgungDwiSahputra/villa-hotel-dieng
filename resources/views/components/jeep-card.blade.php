@props([
    'jeepTrip' => null,
    'showRating' => true,
    'showPrice' => true,
    'showDetailedPrice' => false,
    'showButton' => true,
    'buttonText' => 'Lihat Detail',
    'cardClass' => 'jeep-card bg-white rounded-xl shadow-lg overflow-hidden',
    'imageHeight' => 'h-48',
    'contentPadding' => 'p-3 md:p-6'
])

@if($jeepTrip)
@php
    // Prepare image path
    $imagePath = $jeepTrip->images?->first()?->image_path ?? 'images/jeep-trip/default.jpg';
    $imageUrl = asset('storage/' . $imagePath);

    // Prepare alt text
    $altText = $jeepTrip->nama_paket ?? 'Jeep Trip';
@endphp

<style>
    .jeep-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .jeep-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15);
    }
    .rating-stars {
        color: #fbbf24;
    }
</style>

<div class="{{ $cardClass }}">
    <!-- Jeep Image -->
    <div class="relative {{ $imageHeight }} bg-gray-200">
        @if($jeepTrip->images->count() > 0)
            <img src="{{ $imageUrl }}"
                 alt="{{ $altText }}"
                 class="w-full h-full object-cover">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-blue-500 to-purple-600">
                <svg class="w-14 h-14 lg:w-16 lg:h-16 mr-2 text-white" fill="#fff" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Capa_1" viewBox="0 0 297 297" xml:space="preserve">
                    <g>
                        <path d="M66.96,146.77c-14.442,0-26.191,11.749-26.191,26.191s11.749,26.191,26.191,26.191c14.442,0,26.191-11.749,26.191-26.191   S81.402,146.77,66.96,146.77z M66.96,179.386c-3.542,0-6.424-2.882-6.424-6.424c0-3.542,2.882-6.425,6.424-6.425   s6.424,2.883,6.424,6.425C73.384,176.504,70.502,179.386,66.96,179.386z"/>
                        <path d="M230.038,146.77c-14.442,0-26.191,11.749-26.191,26.191s11.749,26.191,26.191,26.191s26.191-11.749,26.191-26.191   S244.48,146.77,230.038,146.77z M230.038,179.386c-3.542,0-6.424-2.882-6.424-6.424c0-3.542,2.882-6.425,6.424-6.425   c3.542,0,6.424,2.883,6.424,6.425C236.462,176.504,233.58,179.386,230.038,179.386z"/>
                        <path d="M181.115,138.616c-5.458,0-9.883,4.426-9.883,9.884v48.924c0,5.458,4.425,9.883,9.883,9.883   c5.458,0,9.884-4.425,9.884-9.883V148.5C190.999,143.042,186.573,138.616,181.115,138.616z"/>
                        <path d="M148.5,138.616c-5.458,0-9.884,4.426-9.884,9.884v48.924c0,5.458,4.426,9.883,9.884,9.883s9.884-4.425,9.884-9.883V148.5   C158.384,143.042,153.958,138.616,148.5,138.616z"/>
                        <path d="M115.885,138.616c-5.458,0-9.884,4.426-9.884,9.884v48.924c0,5.458,4.426,9.883,9.884,9.883   c5.458,0,9.883-4.425,9.883-9.883V148.5C125.768,143.042,121.343,138.616,115.885,138.616z"/>
                        <path d="M288.846,91.423V42.499c0-5.458-4.425-9.884-9.883-9.884h-22.733v-6.918C256.229,11.527,244.702,0,230.532,0H66.467   C52.297,0,40.77,11.527,40.77,25.697v6.918H18.037c-5.458,0-9.883,4.426-9.883,9.884v48.924c0,5.458,4.425,9.884,9.883,9.884   h16.614c-15.56,6.629-26.496,22.074-26.496,40.027v63.255c0,13.7,6.374,25.933,16.306,33.91v32.804   c0,14.17,11.527,25.697,25.697,25.697h17.298c14.169,0,25.696-11.527,25.696-25.697v-23.227h110.693v23.227   c0,14.17,11.527,25.697,25.697,25.697h17.297c14.17,0,25.697-11.527,25.697-25.697v-32.802c9.933-7.977,16.309-20.21,16.309-33.912   v-63.255c0-17.953-10.936-33.398-26.496-40.027h16.613C284.421,101.307,288.846,96.881,288.846,91.423z M66.467,19.767h164.065   c3.214,0,5.93,2.717,5.93,5.931v72.149H60.538l-0.002-72.149C60.536,22.483,63.253,19.767,66.467,19.767z M27.921,52.383H40.77   v29.156H27.921V52.383z M73.385,271.303c0,3.214-2.715,5.93-5.929,5.93H50.158c-3.214,0-5.931-2.716-5.931-5.93v-23.872   c2.411,0.416,4.886,0.646,7.415,0.646h21.742V271.303z M252.77,271.303c0,3.214-2.717,5.93-5.931,5.93h-17.297   c-3.214,0-5.93-2.716-5.93-5.93v-23.227h21.745c2.528,0,5.001-0.229,7.412-0.645V271.303z M269.079,204.589   c0,13.079-10.642,23.721-23.721,23.721H51.643c-13.079,0-23.721-10.642-23.721-23.721v-63.255c0-13.079,10.642-23.72,23.721-23.72   h193.716c13.079,0,23.721,10.641,23.721,23.72V204.589z M269.079,81.539H256.23V52.383h12.849V81.539z"/>
                    </g>
                </svg>
            </div>
        @endif

        @if($jeepTrip->zona)
            <div class="absolute top-4 left-4 bg-blue-500 text-white px-3 py-1 rounded-full text-xs md:text-sm font-medium">
                {{ ucfirst($jeepTrip->zona) }}
            </div>
        @endif

        @if($jeepTrip->rating && $showRating)
            <div class="absolute top-4 right-4 bg-white px-2 py-1 rounded-lg shadow">
                <div class="flex items-center space-x-1">
                    {{-- <div class="rating-stars">
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $jeepTrip->rating)
                                <i class="bx bxs-star"></i>
                            @elseif($i - 0.5 <= $jeepTrip->rating)
                                <i class="bx bxs-star-half"></i>
                            @else
                                <i class="bx bx-star"></i>
                            @endif
                        @endfor
                    </div> --}}
                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                    </svg>
                    <span class="text-xs md:text-sm font-medium text-gray-700">{{ number_format($jeepTrip->rating, 1) }}</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Jeep Content -->
    <div class="{{ $contentPadding }}">
        <h3 class="text-base md:text-xl font-bold text-gray-900 mb-2">{{ $jeepTrip->nama_paket }}</h3>

        @if($jeepTrip->deskripsi_singkat)
            <p class="text-gray-600 text-xs md:text-sm mb-4 line-clamp-2">{{ $jeepTrip->deskripsi_singkat }}</p>
        @endif

        <div class="space-y-2 mb-4">
            @if($jeepTrip->durasi_jam)
                <div class="flex items-center text-xs md:text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="12" cy="12" r="10"></circle>
                        <polyline points="12,6 12,12 16,14"></polyline>
                    </svg>
                    <span>{{ $jeepTrip->durasi_jam }} Jam</span>
                </div>
            @endif

            @if($jeepTrip->kapasitas_ideal_per_jeep)
                <div class="flex items-center text-xs md:text-sm text-gray-600">
                    <svg class="w-4 h-4 mr-2 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    <span>Maksimal {{ $jeepTrip->kapasitas_ideal_per_jeep }} orang per jeep</span>
                </div>
            @endif
        </div>

        @if($showPrice)
        <div class="mb-4">
            <div class="flex items-center justify-between">
                <div>
                    <span class="text-xs md:text-sm text-gray-500">Mulai dari</span>
                    <div class="text-lg md:text-2xl font-bold text-blue-600">
                        Rp {{ number_format(min($jeepTrip->harga_weekday, $jeepTrip->harga_weekend), 0, ',', '.') }}
                    </div>
                </div>
                @if($showDetailedPrice)
                <div class="text-right text-xs md:text-sm text-gray-500">
                    <div>Weekday: Rp {{ number_format($jeepTrip->harga_weekday, 0, ',', '.') }}</div>
                    <div>Weekend: Rp {{ number_format($jeepTrip->harga_weekend, 0, ',', '.') }}</div>
                </div>
                @endif
            </div>
        </div>
        @endif

        @if($showButton)
        <a href="{{ route('jeep-trip.show', $jeepTrip->slug) }}"
           class="w-full bg-blue-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-blue-700 transition-colors text-center block text-sm md:text-base">
            {{ $buttonText }}
        </a>
        @endif
    </div>
</div>
@endif