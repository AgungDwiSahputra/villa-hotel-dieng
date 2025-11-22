@props([
    'villa' => null,
    'showCategory' => true,
    'showRating' => true,
    'showPrice' => true,
    'showButton' => true,
    'buttonText' => 'Pesan Sekarang',
    'cardClass' => 'group bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden',
    'imageHeight' => 'h-56 sm:h-48',
    'contentPadding' => 'p-3 sm:p-4',
    'showPopularBadge' => false,
    'showAvailabilityStatus' => false,
    'availabilityText' => 'Tersedia',
    'availabilityClass' => 'bg-green-500',
    'showUnitInfo' => true,
    'availableUnits' => null
])

@if($villa)
@php
    // Get promo information from the new system
    // Check for best promo first to ensure we have promo data
    $bestPromo = $villa->getBestPromo();
    $isPromo = $bestPromo !== null;

    if ($isPromo && $bestPromo) {
        // Use dynamic promo pricing from the new system
        $discountPercentage = $villa->getPromoDiscountPercentage();
        $originalPrice = $villa->harga_weekday;
        $promoPriceWeekday = $villa->getPromoPriceWeekday();
        $promoPriceWeekend = $villa->getPromoPriceWeekend();

        // Get additional promo info
        $promoEndDate = $bestPromo->end_date ?? null;
        $isLimited = $bestPromo->usage_limit !== null &&
                     $bestPromo->usage_count >= ($bestPromo->usage_limit - 5);
    } else {
        // Fallback for non-promo products
        $discountPercentage = 0;
        $originalPrice = $villa->harga_weekday;
        $promoPriceWeekday = $villa->harga_weekday;
        $promoPriceWeekend = $villa->harga_weekend;
        $promoEndDate = null;
        $isLimited = false;
        $bestPromo = null;
    }

    // Prepare image path for better readability and maintainability
    $imagePath = $villa->images?->first()?->image ?? 'images/produk/default.jpg';
    $imageUrl = asset('storage/' . $imagePath);

    // Prepare alt text with fallback for accessibility
    $altText = trim(($villa->name ?? 'Villa') . ' - ' . ($villa->lokasi ?? 'Lokasi tidak tersedia'));
@endphp
<article class="{{ $cardClass }}" data-villa-id="{{ $villa->id }}">
    <!-- Villa Image -->
    <div class="relative overflow-hidden {{ $imageHeight }}">
        <a href="{{ route('produk', $villa->slug) }}"
           class="block w-full h-full"
           aria-label="{{ $altText }}">
            <img src="{{ $imageUrl }}"
                 data-src="{{ $imageUrl }}"
                 alt="{{ $altText }}"
                 class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105 lazy-load"
                 loading="lazy"
                 decoding="async">

            <!-- Badge System - Top Left -->
            <div class="absolute top-2 left-2 z-20 flex flex-col gap-1.5 sm:gap-1">
                <!-- Popular Badge -->
                {{-- @if($showPopularBadge)
                <span class="inline-flex items-center px-2.5 py-1.5 sm:px-2 sm:py-1 bg-accent-600 text-white text-xs font-semibold rounded">
                    <svg class="w-3.5 h-3.5 sm:w-3 sm:h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                    </svg>
                    Populer
                </span>
                @endif --}}

                <!-- Promo Badge -->
                @if($isPromo)
                <div class="flex flex-col gap-1.5 sm:gap-1">
                    <span class="inline-flex items-center px-2.5 py-1.5 sm:px-2 sm:py-1 bg-red-600 text-white text-xs font-bold rounded animate-pulse">
                        <svg class="w-3.5 h-3.5 sm:w-3 sm:h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41 1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                        </svg>
                        PROMO {{ $discountPercentage > 0 ? number_format($discountPercentage, 0) . '%' : '' }}
                    </span>

                    @if($isLimited)
                    <span class="inline-flex items-center px-2.5 py-1.5 sm:px-2 sm:py-1 bg-orange-600 text-white text-xs font-semibold rounded">
                        <svg class="w-3.5 h-3.5 sm:w-3 sm:h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                        Terbatas!
                    </span>
                    @endif
                </div>
                @endif

                <!-- Availability Badge -->
                @if($showAvailabilityStatus)
                <span class="inline-flex items-center px-2.5 py-1.5 sm:px-2 sm:py-1 {{ $availabilityClass }} text-white text-xs font-semibold rounded">
                    @if($availabilityClass === 'bg-red-600')
                        <svg class="w-3.5 h-3.5 sm:w-3 sm:h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                        </svg>
                    @elseif($availabilityClass === 'bg-orange-600')
                        <svg class="w-3.5 h-3.5 sm:w-3 sm:h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
                        </svg>
                    @else
                        <svg class="w-3.5 h-3.5 sm:w-3 sm:h-3 mr-1" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                    @endif
                    {{ $availabilityText }}
                </span>
                @endif
            </div>
        </a>
    </div>

    <!-- Villa Content -->
    <div class="{{ $contentPadding }}">
        <!-- Title -->
        <h3 class="text-base font-semibold text-gray-900 mb-2 line-clamp-2 leading-tight">
            <a href="{{ route('produk', $villa->slug) }}"
               class="hover:text-primary-600 transition-colors duration-200">
                {{ $villa->name }}
            </a>
        </h3>

        <!-- Location -->
        <!--  <div class="flex items-center text-gray-600 text-sm mb-3">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314-9.894 8 8 0 01-1.314 9.894z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            {{ $villa->lokasi }}
        </div> -->

        <!-- Rating -->
        @if($showRating)
        <div class="flex items-center mb-2.5 sm:mb-3">
            <div class="flex text-yellow-400">
                @for($i = 1; $i <= 5; $i++)
                <svg class="w-4 h-4 {{ $i <= $villa->rating ? 'text-yellow-400' : 'text-gray-300' }}" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                </svg>
                @endfor
            </div>
            <span class="ml-1.5 sm:ml-2 text-xs sm:text-sm text-gray-600">({{ $villa->rating }}/5.00)</span>
        </div>
        @endif

        <!-- Villa Facilities -->
        <div class="flex items-center gap-3 sm:gap-4 text-xs sm:text-sm text-gray-600 mb-2.5 sm:mb-3">
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
                <span class="whitespace-nowrap">{{ $villa->kamar }} Kamar</span>
            </div>
            <div class="flex items-center">
                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                </svg>
                <span class="whitespace-nowrap">{{ $villa->maks_orang }} Orang</span>
            </div>
        </div>

        <!-- Unit Availability -->
        @if($showUnitInfo)
        <div class="flex items-center justify-between mb-2.5 sm:mb-3">
            <div class="flex items-center text-xs sm:text-sm text-gray-600">
                <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
                <span class="font-medium">{{ $availableUnits ?? $villa->unit }} Unit Tersedia</span>
            </div>
            @if($isPromo)
            <span class="text-red-600 text-xs font-bold animate-pulse whitespace-nowrap">
                Terbatas!
            </span>
            @endif
        </div>
        @endif

        <!-- Divider -->
        <div class="border-t border-gray-100 my-2.5 sm:my-3"></div>

        <!-- Price Section -->
        @if($showPrice)
        <div class="flex items-center justify-between mb-2.5 sm:mb-3">
            @if($isPromo)
            <!-- Dynamic Promo Price -->
            <div class="flex-1 min-w-0">
                <p class="text-xs text-gray-500 line-through truncate">Rp {{ number_format($villa->harga_weekday, 0, ',', '.') }}</p>
                <p class="text-base sm:text-lg font-bold text-red-600 truncate">Rp {{ number_format($promoPriceWeekday, 0, ',', '.') }}</p>
                @if($villa->harga_weekend != $villa->harga_weekday)
                <p class="text-xs text-gray-500 truncate">Weekend: Rp {{ number_format($promoPriceWeekend, 0, ',', '.') }}</p>
                @endif
                @if($promoEndDate && $promoEndDate instanceof \Carbon\Carbon)
                <p class="text-xs text-orange-600 truncate">Berakhir: {{ $promoEndDate->format('d M Y') }}</p>
                @endif
            </div>
            {{-- <div class="text-right">
                <span class="bg-red-100 text-red-700 text-xs px-2 py-1 rounded font-semibold">
                    {{ $discountPercentage > 0 ? number_format($discountPercentage, 0) . '%' : '' }} OFF
                </span>
            </div> --}}
            @else
            <!-- Regular Pricing -->
            <div class="flex-1 min-w-0">
                <p class="text-xs text-gray-500">Harga Weekday</p>
                <p class="text-base sm:text-lg font-bold text-gray-900 truncate">Rp {{ number_format($villa->harga_weekday, 0, ',', '.') }}</p>
                @if($villa->harga_weekend != $villa->harga_weekday)
                <p class="text-xs text-gray-500 truncate">Weekend: Rp {{ number_format($villa->harga_weekend, 0, ',', '.') }}</p>
                @endif
            </div>
            @endif
        </div>
        @endif

        <!-- CTA Button -->
        @if($showButton)
        <a href="{{ route('produk', $villa->slug) }}"
           class="w-full inline-flex items-center justify-center px-4 py-3 sm:py-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white text-sm font-medium rounded transition-colors duration-200 touch-manipulation min-h-[44px] sm:min-h-0">
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
