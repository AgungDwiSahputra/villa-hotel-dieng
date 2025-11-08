@props([
    'villa' => null,
    'showCategory' => true,
    'showRating' => true,
    'showPrice' => true,
    'showButton' => true,
    'buttonText' => 'Pesan Sekarang',
    'cardClass' => 'group bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden',
    'imageHeight' => 'h-48',
    'contentPadding' => 'p-4',
    'showPopularBadge' => false,
    'showAvailabilityStatus' => false,
    'availabilityText' => 'Tersedia',
    'availabilityClass' => 'bg-green-500'
])

@if($villa)
@php
    // Calculate discount price (30% off)
    $discountPercentage = 30;
    $originalPrice = $villa->harga_weekday;
    $discountedPrice = $originalPrice * (1 - $discountPercentage / 100);
    
    // Determine if this is a promo product
    $isPromo = $villa->label && str_contains(strtolower($villa->label), 'promo');
@endphp
<article class="{{ $cardClass }}" data-villa-id="{{ $villa->id }}">
    <!-- Villa Image -->
    <div class="relative overflow-hidden {{ $imageHeight }}">
        <a href="{{ route('produk', $villa->slug) }}"
           class="block w-full h-full"
           aria-label="{{ $villa->name }} - {{ $villa->lokasi }}">
            <img src="{{ asset('storage/'.$villa->images?->first()?->image ?? '') }}"
                 data-src="{{ asset('storage/'.$villa->images?->first()?->image ?? '') }}"
                 alt="{{ $villa->name }} - {{ $villa->lokasi }}"
                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105 lazy-load"
                 loading="lazy">

            <!-- Badge System - Top Left -->
            <div class="absolute top-2 left-2 z-20 flex flex-col gap-1">
                <!-- Popular Badge -->
                @if($showPopularBadge)
                <span class="inline-flex items-center px-2 py-1 bg-accent-600 text-white text-xs font-semibold rounded">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    Populer
                </span>
                @endif

                <!-- Promo Badge -->
                @if($isPromo)
                <span class="inline-flex items-center px-2 py-1 bg-red-600 text-white text-xs font-bold rounded animate-pulse">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41 1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    Promo
                </span>
                @endif
            </div>

            <!-- Availability Status - Bottom Left -->
            @if($showAvailabilityStatus)
            <div class="absolute bottom-2 left-2 z-20">
                <span class="inline-flex items-center px-2 py-1 {{ $availabilityClass }} text-white text-xs font-medium rounded">
                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                    </svg>
                    {{ $availabilityText }}
                </span>
            </div>
            @endif
        </a>
    </div>
    
    <!-- Villa Content -->
    <div class="{{ $contentPadding }}">
        <!-- Title -->
        <h3 class="text-base font-semibold text-gray-900 mb-2 line-clamp-2">
            <a href="{{ route('produk', $villa->slug) }}"
               class="hover:text-primary-600 transition-colors duration-200">
                {{ $villa->name }}
            </a>
        </h3>

        <!-- Location -->
        <div class="flex items-center text-gray-600 text-sm mb-3">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314-9.894 8 8 0 01-1.314 9.894z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            {{ $villa->lokasi }}
        </div>

        <!-- Rating -->
        @if($showRating)
        <div class="flex items-center mb-3">
            <div class="flex text-yellow-400">
                @for($i = 1; $i <= 5; $i++)
                <svg class="w-4 h-4 {{ $i <= 4 ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                </svg>
                @endfor
            </div>
            <span class="ml-2 text-sm text-gray-600">({{ rand(10, 50) }})</span>
        </div>
        @endif

        <!-- Villa Facilities -->
        <div class="flex items-center gap-4 text-sm text-gray-600 mb-3">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                {{ $villa->kamar }} Kamar
            </div>
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                {{ $villa->maks_orang }} Orang
            </div>
        </div>

        <!-- Unit Availability -->
        <div class="flex items-center justify-between mb-3">
            <div class="flex items-center text-sm text-gray-600">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span class="font-medium">{{ rand(1, 5) }} Unit Tersedia</span>
            </div>
            @if($isPromo)
            <span class="text-red-600 text-xs font-bold animate-pulse">
                Terbatas!
            </span>
            @endif
        </div>

        <!-- Divider -->
        <div class="border-t border-gray-100 my-3"></div>

        <!-- Price Section -->
        @if($showPrice)
        <div class="flex items-center justify-between mb-3">
            @if($isPromo)
            <!-- Promo Price -->
            <div>
                <p class="text-xs text-gray-500 line-through">Rp {{ number_format($villa->harga_weekday, 0, ',', '.') }}/malam</p>
                <p class="text-lg font-bold text-red-600">Rp {{ number_format($discountedPrice, 0, ',', '.') }}/malam</p>
            </div>
            <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded font-semibold">
                {{ $discountPercentage }}% OFF
            </span>
            @else
            <!-- Regular Weekday Price -->
            <div>
                <p class="text-xs text-gray-500">Harga Weekday</p>
                <p class="text-lg font-bold text-gray-900">Rp {{ number_format($villa->harga_weekday, 0, ',', '.') }}/malam</p>
            </div>
            @endif
        </div>
        @endif

        <!-- CTA Button -->
        @if($showButton)
        <a href="{{ route('produk', $villa->slug) }}"
           class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded transition-colors duration-200">
            {{ $buttonText }}
        </a>
        @endif
    </div>
</article>
@endif

<script>
// Toggle favorite function
function toggleFavorite(villaId, button) {
    // Toggle heart icon
    const svg = button.querySelector('svg');
    const isFavorited = svg.classList.contains('text-red-500');
    
    if (isFavorited) {
        svg.classList.remove('text-red-500', 'fill-current');
        svg.classList.add('text-gray-700');
    } else {
        svg.classList.remove('text-gray-700');
        svg.classList.add('text-red-500', 'fill-current');
    }
    
    // Here you can add AJAX call to save/remove favorite
    // For now, just toggle the visual state
    console.log('Toggle favorite for villa:', villaId);
}
</script>