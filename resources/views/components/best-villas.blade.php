{{--
    Komponen untuk menampilkan Villa Terbaik (Premium)
    Features: Fasilitas lengkap, galeri berkualitas, ulasan tamu, fitur perbandingan
    Accessibility: WCAG 2.1 compliant
    SEO: Structured data markup
--}}
@props([
    'villas' => [],
    'title' => 'Villa Terbaik'
])

{{-- <!-- Structured Data for SEO -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ItemList",
    "name": "{{ $title }}",
    "itemListElement": [
        @foreach($villas as $index => $villa)
        {
            "@type": "ListItem",
            "position": {{ $index + 1 }},
            "item": {
                "@type": "LodgingBusiness",
                "name": "{{ $villa->name }}",
                "description": "{{ Str::limit($villa->label ?? 'Villa premium mewah dengan fasilitas lengkap', 150) }}",
                "image": "{{ asset('storage/'.$villa->images?->first()?->image ?? 'images/default-avatar.jpg') }}",
                "url": "{{ route('produk', $villa->slug) }}",
                "address": {
                    "@type": "PostalAddress",
                    "addressLocality": "{{ $villa->lokasi }}"
                },
                "priceRange": "Rp {{ number_format($villa->harga_weekday, 0, ',', '.') }} - Rp {{ number_format($villa->harga_weekend, 0, ',', '.') }}",
                "telephone": "{{ $settings['phone'] ?? '' }}",
                "aggregateRating": {
                    "@type": "AggregateRating",
                    "ratingValue": "4.8",
                    "reviewCount": "256"
                }
            }
        }@if(!$loop->last),@endif
        @endforeach
    ]
}
</script> --}}

<section class="py-16 lg:py-24 bg-gradient-to-br from-gray-50 to-white" aria-labelledby="best-villas-heading">
    <div class="max-w-5xl container mx-auto px-4 sm:px-6 lg:px-8">
        <header class="text-center mb-12">
            <div class="inline-flex items-center space-x-2 bg-primary-100 text-primary-800 px-4 py-2 rounded-full mb-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314-9.894 8 8 0 01-1.314 9.894z"></path>
                </svg>
                <span class="text-sm font-medium">{{ $title }}</span>
            </div>
            <h2 id="best-villas-heading" class="text-3xl lg:text-4xl font-bold font-display text-gray-900 mb-4">
                {{ $title }}
            </h2>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                Pengalaman menginap mewah dengan fasilitas premium dan pelayanan terbaik
            </p>
            <div class="w-24 h-1 bg-gradient-to-r from-primary-600 to-accent-600 mx-auto mt-6 rounded-full"></div>
        </header>

        @if(empty($villas))
            {{-- <div class="text-center py-16">
                <svg class="w-24 h-24 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                </svg>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">Villa Terbaik Belum Tersedia</h3>
                <p class="text-gray-600 mb-6">Saat ini belum ada villa yang ditandai sebagai terbaik. Silakan lihat semua villa yang tersedia.</p>
                <a href="{{ route('produk.all') }}"
                   class="inline-flex items-center px-6 py-3 bg-primary-600 hover:bg-primary-700 text-white font-medium rounded-lg transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H6zM14 16a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z"></path>
                    </svg>
                    Lihat Semua Villa
                </a>
            </div> --}}
        @else
            <div class="best-villas-carousel flickity" role="list" aria-label="Villa Terbaik Carousel">
                @foreach($villas as $villa)
                <div class="carousel-cell" role="listitem" aria-label="{{ $villa->name }}">
                    <!-- Villa Card Component dengan Badge Terintegrasi -->
                    <x-villa-card
                        :villa="$villa"
                        :showCategory="false"
                        :showRating="true"
                        :showPrice="true"
                        :showButton="true"
                        :buttonText="'Pesan Sekarang'"
                        :showPopularBadge="true"
                        :showAvailabilityStatus="true"
                        :availabilityText="'Tersedia'"
                        :availabilityClass="'bg-green-500'"
                        :cardClass="'group bg-white rounded-lg shadow-md hover:shadow-lg transition-all duration-300 overflow-hidden'"
                        :imageHeight="'h-48'"
                        :contentPadding="'p-4'"
                    />
                </div>
                @endforeach
            </div>
        @endif

        <!-- View All Button -->
        <div class="text-center mt-20">
            <a href="{{ route('produk.all') }}"
               class="inline-flex items-center px-8 py-3 border-2 border-primary-600 text-primary-600 hover:bg-primary-600 hover:text-white font-semibold rounded-full transition-all duration-200 transform hover:scale-105"
               role="button">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H6zM14 16a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2h-2z"></path>
                </svg>
                Lihat Semua Villa
            </a>
        </div>
    </div>
</section>

<!-- Quick View Modal -->
<div class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden" id="quickViewModal" tabindex="-1" aria-labelledby="quickViewModalLabel" aria-hidden="true">
    <div class="flex items-center justify-center min-h-screen p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-4xl w-full max-h-[90vh] overflow-y-auto">
            <div class="flex items-center justify-between p-6 border-b">
                <h3 class="text-xl font-semibold text-gray-900" id="quickViewModalLabel">Quick View Villa</h3>
                <button type="button" class="text-gray-400 hover:text-gray-600 transition-colors duration-200" onclick="document.getElementById('quickViewModal').classList.add('hidden')" aria-label="Close">
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
