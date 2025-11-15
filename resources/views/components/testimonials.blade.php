{{--
    Komponen untuk menampilkan Testimonial dan Social Proof
    Features: Ulasan tamu, rating, lencana kepercayaan, statistik
    Accessibility: WCAG 2.1 compliant
    SEO: Structured data markup
    Mobile First Design dengan Tailwind CSS
--}}
@props([
    'testimonials' => [],
    'title' => 'Apa Kata Tamu Kami'
])

{{-- <!-- Structured Data for SEO -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "AggregateRating",
    "itemReviewed": {
        "@type": "LocalBusiness",
        "name": "Villa Hotel Dieng"
    },
    "ratingValue": "4.7",
    "reviewCount": "1250",
    "bestRating": "5",
    "worstRating": "1"
}
</script> --}}

<section class="relative py-16 lg:py-24 bg-gradient-to-br from-primary-900 via-primary-800 to-primary-900 text-white overflow-hidden" aria-labelledby="testimonials-heading">
    <!-- Background Pattern -->
    <div class="max-w-5xl absolute inset-0 opacity-10">
        <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60" viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg fill="%23ffffff" fill-opacity="0.4"%3E%3Cpath d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
    </div>

    <!-- Floating Elements -->
    <div class="max-w-5xl absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute top-20 left-10 w-20 h-20 bg-white/10 rounded-full animate-float"></div>
        <div class="absolute top-40 right-20 w-32 h-32 bg-white/5 rounded-full animate-float" style="animation-delay: 1s;"></div>
        <div class="absolute bottom-20 left-1/4 w-16 h-16 bg-white/10 rounded-full animate-float" style="animation-delay: 2s;"></div>
    </div>

    <div class="max-w-5xl relative z-10 container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
        <header class="text-center mb-12 lg:mb-16">
            <div class="inline-flex items-center space-x-2 bg-accent-500/20 backdrop-blur-sm px-4 py-2 sm:px-6 sm:py-3 rounded-full border border-accent-400/30 mb-6 lg:mb-8">
                <span class="relative flex h-3 w-3">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-accent-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-3 w-3 bg-accent-500"></span>
                </span>
                <span class="text-accent-300 text-xs sm:text-sm font-medium">Testimonial Nyata</span>
            </div>

            <h2 id="testimonials-heading" class="text-3xl sm:text-4xl lg:text-5xl xl:text-6xl font-bold font-display text-white mb-4 lg:mb-6">
                {{ $title }}
            </h2>

            <p class="text-base sm:text-lg lg:text-xl xl:text-2xl text-gray-300 leading-relaxed max-w-3xl mx-auto mb-6 lg:mb-8">
                Dengarkan pengalaman nyata dari tamu yang telah menginap di Villa kami
            </p>

            <div class="w-24 h-1 bg-gradient-to-r from-accent-400 to-accent-600 mx-auto rounded-full"></div>
        </header>

        <!-- Statistics Overview -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6 mb-12 lg:mb-16">
            <div class="text-center p-4 lg:p-6 bg-white/5 backdrop-blur-sm rounded-xl lg:rounded-2xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                <div class="text-2xl sm:text-3xl lg:text-4xl font-bold text-accent-400 mb-1 lg:mb-2">1,250+</div>
                <div class="text-xs sm:text-sm text-gray-300">Tamu Puas</div>
            </div>
            <div class="text-center p-4 lg:p-6 bg-white/5 backdrop-blur-sm rounded-xl lg:rounded-2xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                <div class="text-2xl sm:text-3xl lg:text-4xl font-bold text-accent-400 mb-1 lg:mb-2">4.8/5</div>
                <div class="text-xs sm:text-sm text-gray-300">Rating Rata-rata</div>
            </div>
            <div class="text-center p-4 lg:p-6 bg-white/5 backdrop-blur-sm rounded-xl lg:rounded-2xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                <div class="text-2xl sm:text-3xl lg:text-4xl font-bold text-accent-400 mb-1 lg:mb-2">98%</div>
                <div class="text-xs sm:text-sm text-gray-300">Tingkat Kepuasan</div>
            </div>
            <div class="text-center p-4 lg:p-6 bg-white/5 backdrop-blur-sm rounded-xl lg:rounded-2xl border border-white/10 hover:bg-white/10 transition-all duration-300">
                <div class="text-2xl sm:text-3xl lg:text-4xl font-bold text-accent-400 mb-1 lg:mb-2">5+</div>
                <div class="text-xs sm:text-sm text-gray-300">Tahun Pengalaman</div>
            </div>
        </div>

        <!-- Testimonials Carousel -->
        <div class="mb-12 lg:mb-16" role="region" aria-label="Testimonial carousel">
            <!-- Carousel Navigation -->
            <div class="flex items-center justify-between mb-6 lg:mb-8">
                <h3 class="text-xl lg:text-2xl font-semibold text-white">Ulasan Terbaru</h3>
            </div>

            <div class="testimonial-slider testimonials-carousel flickity" role="region" aria-label="Testimonial carousel">
                @foreach($testimonials as $testimonial)
                <div class="testimonial-slide carousel-cell px-2 sm:px-3 lg:px-4" aria-label="Testimonial dari {{ $testimonial['name'] ?? 'Anonymous' }}">
                        <div class="bg-white/5 backdrop-blur-sm rounded-xl lg:rounded-2xl p-6 lg:p-8 border border-white/10 hover:bg-white/10 transition-all duration-300 h-full">
                            <!-- Rating Stars -->
                            <div class="flex items-center mb-4 lg:mb-6">
                                <div class="flex text-accent-400" aria-label="Rating {{ $testimonial['rating'] ?? 5 }} dari 5">
                                    @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-4 h-4 lg:w-5 lg:h-5 {{ $i <= ($testimonial['rating'] ?? 5) ? 'text-accent-400' : 'text-white/30' }}" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
                                    </svg>
                                    @endfor
                                </div>
                                <span class="ml-2 text-sm text-gray-300">{{ $testimonial['rating'] ?? 5 }}.0</span>
                            </div>

                            <!-- Testimonial Content -->
                            <blockquote class="text-gray-200 mb-6 lg:mb-8 text-sm sm:text-base lg:text-lg leading-relaxed" itemprop="reviewBody">
                                <svg class="w-6 h-6 lg:w-8 lg:h-8 text-accent-400/30 mb-3 lg:mb-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z" />
                                </svg>
                                {{ $testimonial['content'] ?? 'Pengalaman menginap yang luar biasa! Villa sangat bersih, pemandangan indah, dan pelayanan yang ramah. Sangat direkomendasikan untuk liburan keluarga.' }}
                            </blockquote>

                            <!-- Author Info -->
                            <div class="flex items-center">
                                <div class="author-avatar mr-3 lg:mr-4">
                                    <img src="{{ $testimonial['avatar'] ?? asset('images/default-avatar.svg') }}"
                                         alt="{{ $testimonial['name'] ?? 'Anonymous' }}"
                                         class="w-12 h-12 lg:w-14 lg:h-14 rounded-full object-cover border-2 border-accent-400/30"
                                         itemprop="image">
                                </div>
                                <div class="author-info">
                                    <div class="author-name font-semibold text-white text-sm sm:text-base lg:text-lg" itemprop="author">
                                        {{ $testimonial['name'] ?? 'Anonymous' }}
                                    </div>
                                    <div class="author-details text-gray-400 text-xs sm:text-sm">
                                        <span itemprop="datePublished">{{ $testimonial['date'] ?? 'November 2024' }}</span>
                                        <span class="mx-2">•</span>
                                        <span>{{ $testimonial['villa'] ?? 'Villa Premium' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                @endforeach
            </div>

        </div>

        <!-- Trust Badges -->
        <div class="trust-badges mt-32 mb-12 lg:mb-16">
            <header class="text-center mb-8 lg:mb-10">
                <h3 class="text-xl lg:text-2xl font-semibold text-white mb-3 lg:mb-4">Mengapa Memilih Kami</h3>
                <p class="text-gray-300 text-sm sm:text-base lg:text-lg">Terpercaya oleh ribuan tamu dari seluruh Indonesia</p>
            </header>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 lg:gap-6">
                <div class="text-center p-4 lg:p-6 bg-white/5 backdrop-blur-sm rounded-xl lg:rounded-2xl border border-white/10 hover:bg-white/10 transition-all duration-300 group">
                    <div class="badge-icon mb-3 lg:mb-4 flex justify-center">
                        <div class="w-12 h-12 lg:w-16 lg:h-16 bg-accent-500/20 rounded-full flex items-center justify-center group-hover:bg-accent-500/30 transition-colors duration-200">
                            <i class="fas fa-shield-alt text-accent-400 text-lg lg:text-xl"></i>
                        </div>
                    </div>
                    <h4 class="badge-title font-semibold text-white text-sm sm:text-base lg:text-lg mb-2">Garansi Harga Terbaik</h4>
                    <p class="badge-desc text-gray-400 text-xs sm:text-sm">Harga kompetitif dengan nilai terbaik</p>
                </div>
                <div class="text-center p-4 lg:p-6 bg-white/5 backdrop-blur-sm rounded-xl lg:rounded-2xl border border-white/10 hover:bg-white/10 transition-all duration-300 group">
                    <div class="badge-icon mb-3 lg:mb-4 flex justify-center">
                        <div class="w-12 h-12 lg:w-16 lg:h-16 bg-accent-500/20 rounded-full flex items-center justify-center group-hover:bg-accent-500/30 transition-colors duration-200">
                            <i class="fas fa-award text-accent-400 text-lg lg:text-xl"></i>
                        </div>
                    </div>
                    <h4 class="badge-title font-semibold text-white text-sm sm:text-base lg:text-lg mb-2">Tersertifikasi</h4>
                    <p class="badge-desc text-gray-400 text-xs sm:text-sm">Terdaftar resmi sebagai akomodasi wisata</p>
                </div>
                <div class="text-center p-4 lg:p-6 bg-white/5 backdrop-blur-sm rounded-xl lg:rounded-2xl border border-white/10 hover:bg-white/10 transition-all duration-300 group">
                    <div class="badge-icon mb-3 lg:mb-4 flex justify-center">
                        <div class="w-12 h-12 lg:w-16 lg:h-16 bg-accent-500/20 rounded-full flex items-center justify-center group-hover:bg-accent-500/30 transition-colors duration-200">
                            <i class="fas fa-headset text-accent-400 text-lg lg:text-xl"></i>
                        </div>
                    </div>
                    <h4 class="badge-title font-semibold text-white text-sm sm:text-base lg:text-lg mb-2">Support 24/7</h4>
                    <p class="badge-desc text-gray-400 text-xs sm:text-sm">Tim siap membantu kapan saja</p>
                </div>
                <div class="text-center p-4 lg:p-6 bg-white/5 backdrop-blur-sm rounded-xl lg:rounded-2xl border border-white/10 hover:bg-white/10 transition-all duration-300 group">
                    <div class="badge-icon mb-3 lg:mb-4 flex justify-center">
                        <div class="w-12 h-12 lg:w-16 lg:h-16 bg-accent-500/20 rounded-full flex items-center justify-center group-hover:bg-accent-500/30 transition-colors duration-200">
                            <i class="fas fa-lock text-accent-400 text-lg lg:text-xl"></i>
                        </div>
                    </div>
                    <h4 class="badge-title font-semibold text-white text-sm sm:text-base lg:text-lg mb-2">Pembayaran Aman</h4>
                    <p class="badge-desc text-gray-400 text-xs sm:text-sm">Transaksi terenkripsi dan terjamin</p>
                </div>
            </div>
        </div>

        <!-- Call to Action -->
        <div class="text-center mt-20">
            <h3 class="text-xl lg:text-2xl font-semibold text-white mb-4 lg:mb-6">Siap Bergabung dengan Tamu Puas Lainnya?</h3>
            <p class="text-gray-300 text-sm sm:text-base lg:text-lg mb-6 lg:mb-8 max-w-2xl mx-auto">Pesan Villa impian Anda sekarang juga dan rasakan pengalaman menginap yang tak terlupakan</p>
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4 justify-center">
                <a href="{{ route('index') }}"
                   class="inline-flex items-center justify-center px-6 py-3 sm:px-8 sm:py-4 bg-accent-600 hover:bg-accent-700 text-white font-semibold rounded-full transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    Cari Villa
                </a>
                <a href="tel:{{ $settings['contact_phone'] ?? '+628123456789' }}"
                   class="inline-flex items-center justify-center px-6 py-3 sm:px-8 sm:py-4 bg-white/10 backdrop-blur-sm hover:bg-white/20 text-white font-semibold rounded-full transition-all duration-200 border border-white/20 text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    Hubungi Kami
                </a>
            </div>
        </div>
    </div>
</section>

<style>
/* Testimonial Carousel Styles */
.testimonial-track {
    display: flex;
    transition: transform 0.5s ease-in-out;
}

.testimonial-slide {
    flex: 0 0 100%;
}

.testimonial-dot {
    transition: all 0.3s ease;
}

.testimonial-dot.active {
    background-color: rgb(251 191 36);
    width: 1.5rem;
}

/* Floating Animation */
@keyframes float {
    0%, 100% {
        transform: translateY(0px);
    }
    50% {
        transform: translateY(-20px);
    }
}

.animate-float {
    animation: float 6s ease-in-out infinite;
}

/* Mobile Optimizations */
@media (max-width: 640px) {
    .testimonial-slide {
        padding: 0 0.5rem;
    }

    .testimonial-card {
        padding: 1.5rem;
    }

    .trust-badges .grid {
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
    }

    .badge-item {
        padding: 1rem;
    }
}

/* Touch-friendly improvements */
@media (pointer: coarse) {
    .testimonial-dot,
    #testimonial-prev,
    #testimonial-next {
        min-height: 44px;
        min-width: 44px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Testimonial Carousel
    const testimonialTrack = document.getElementById('testimonialTrack');
    const testimonialDots = document.querySelectorAll('.testimonial-dot');
    const prevBtn = document.getElementById('testimonial-prev');
    const nextBtn = document.getElementById('testimonial-next');

    let currentSlide = 0;
    const totalSlides = testimonialDots.length;

    function goToSlide(slideIndex) {
        if (slideIndex < 0) slideIndex = totalSlides - 1;
        if (slideIndex >= totalSlides) slideIndex = 0;

        currentSlide = slideIndex;
        const offset = -slideIndex * 100;
        testimonialTrack.style.transform = `translateX(${offset}%)`;

        // Update dots
        testimonialDots.forEach((dot, index) => {
            if (index === slideIndex) {
                dot.classList.add('active', 'bg-accent-400', 'w-6', 'lg:w-8');
                dot.classList.remove('bg-white/30');
            } else {
                dot.classList.remove('active', 'bg-accent-400', 'w-6', 'lg:w-8');
                dot.classList.add('bg-white/30');
            }
        });
    }

    // Event listeners
    prevBtn.addEventListener('click', () => goToSlide(currentSlide - 1));
    nextBtn.addEventListener('click', () => goToSlide(currentSlide + 1));

    testimonialDots.forEach((dot, index) => {
        dot.addEventListener('click', () => goToSlide(index));
    });

    // Auto-play carousel
    setInterval(() => {
        goToSlide(currentSlide + 1);
    }, 5000);

    // Touch/swipe support for mobile
    let touchStartX = 0;
    let touchEndX = 0;

    testimonialTrack.addEventListener('touchstart', (e) => {
        touchStartX = e.changedTouches[0].screenX;
    });

    testimonialTrack.addEventListener('touchend', (e) => {
        touchEndX = e.changedTouches[0].screenX;
        handleSwipe();
    });

    function handleSwipe() {
        if (touchEndX < touchStartX - 50) {
            goToSlide(currentSlide + 1); // Swipe left, go to next
        }
        if (touchEndX > touchStartX + 50) {
            goToSlide(currentSlide - 1); // Swipe right, go to prev
        }
    }
});
</script>
