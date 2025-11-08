{{-- 
    Komponen untuk menampilkan Banner Promosi dan Indikator Urgensi
    Features: Banner dinamis, countdown timer, promo flash, CTA buttons
    Accessibility: WCAG 2.1 compliant
    SEO: Structured data markup
--}}
@props([
    'promo' => [
        'title' => 'Promo Spesial Liburan',
        'subtitle' => 'Diskon hingga 30% untuk pemesanan minggu ini',
        'discount' => '30%',
        'valid_until' => '2024-12-31 23:59:59',
        'code' => 'LIBURAN2024'
    ]
])

{{-- <!-- Structured Data for SEO -->
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "Offer",
    "name": "{{ $promo['title'] }}",
    "description": "{{ $promo['subtitle'] }}",
    "discount": "{{ $promo['discount'] }}",
    "discountCode": "{{ $promo['code'] }}",
    "validFrom": "{{ now()->format('Y-m-d') }}",
    "validThrough": "{{ $promo['valid_until'] }}",
    "availability": "https://schema.org/InStock",
    "priceCurrency": "IDR",
    "eligibleRegion": "ID"
}
</script> --}}

<section class="promo-banner-section elegant-section" aria-labelledby="promo-heading">
    <!-- Main Promo Banner -->
    <div class="promo-banner-main">
        <div class="tf-container elegant-container">
            <div class="promo-content-wrapper">
                <div class="promo-content">
                    <header class="promo-header">
                        <div class="promo-badges">
                            <span class="badge-flash-sale" aria-label="Flash Sale">
                                <i class="fas fa-bolt me-1"></i>FLASH SALE
                            </span>
                            <span class="badge-limited" aria-label="Terbatas">
                                <i class="fas fa-clock me-1"></i>TERBATAS
                            </span>
                        </div>
                        
                        <h1 id="promo-heading" class="promo-title h1 fw-bold text-white mb-3">
                            {{ $promo['title'] }}
                        </h1>
                        
                        <p class="promo-subtitle lead text-white-90 mb-4">
                            {{ $promo['subtitle'] }}
                        </p>
                    </header>

                    <div class="promo-details">
                        <!-- Discount Display -->
                        <div class="discount-display mb-4">
                            <div class="discount-circle">
                                <span class="discount-text">{{ $promo['discount'] }}</span>
                                <span class="discount-label">OFF</span>
                            </div>
                        </div>

                        <!-- Countdown Timer -->
                        <div class="countdown-timer mb-4" role="timer" aria-live="polite">
                            <h3 class="countdown-label h6 text-white-90 mb-2">Berakhir dalam:</h3>
                            <div class="countdown-display" id="promoCountdown">
                                <div class="time-unit">
                                    <span class="time-value" id="days">00</span>
                                    <span class="time-label">Hari</span>
                                </div>
                                <div class="time-separator">:</div>
                                <div class="time-unit">
                                    <span class="time-value" id="hours">00</span>
                                    <span class="time-label">Jam</span>
                                </div>
                                <div class="time-separator">:</div>
                                <div class="time-unit">
                                    <span class="time-value" id="minutes">00</span>
                                    <span class="time-label">Menit</span>
                                </div>
                                <div class="time-separator">:</div>
                                <div class="time-unit">
                                    <span class="time-value" id="seconds">00</span>
                                    <span class="time-label">Detik</span>
                                </div>
                            </div>
                        </div>

                        <!-- Promo Code -->
                        <div class="promo-code-section mb-4">
                            <div class="code-display">
                                <span class="code-label">Gunakan Kode:</span>
                                <span class="code-value" id="promoCode">{{ $promo['code'] }}</span>
                                <button class="copy-code-btn" 
                                        onclick="copyPromoCode('{{ $promo['code'] }}')"
                                        aria-label="Salin kode promo"
                                        title="Salin kode">
                                    <i class="fas fa-copy"></i>
                                </button>
                            </div>
                            <div class="copy-feedback" id="copyFeedback" style="display: none;">
                                <i class="fas fa-check-circle me-1"></i>
                                <span>Kode disalin!</span>
                            </div>
                        </div>

                        <!-- CTA Buttons -->
                        <div class="promo-cta">
                            <a href="{{ route('index') }}" 
                               class="elegant-btn btn btn-light btn-lg me-3"
                               role="button"
                               aria-label="Pesan sekarang dengan promo">
                                <i class="fas fa-calendar-check me-2"></i>
                                Pesan Sekarang
                            </a>
                            <a href="{{ route('tentang-kami') }}" 
                               class="elegant-btn btn btn-outline-light btn-lg"
                               role="button"
                               aria-label="Lihat syarat dan ketentuan">
                                <i class="fas fa-info-circle me-2"></i>
                                Syarat & Ketentuan
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Visual Elements -->
                <div class="promo-visual">
                    <div class="floating-elements">
                        <div class="float-element float-1">
                            <i class="fas fa-percentage"></i>
                        </div>
                        <div class="float-element float-2">
                            <i class="fas fa-gift"></i>
                        </div>
                        <div class="float-element float-3">
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Urgency Indicators Bar -->
    <div class="urgency-bar">
        <div class="tf-container elegant-container">
            <div class="urgency-content">
                <div class="urgency-stats">
                    <div class="stat-item">
                        <i class="fas fa-fire text-warning me-2"></i>
                        <span class="stat-text"><strong>245</strong> orang melihat promo ini</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-users text-info me-2"></i>
                        <span class="stat-text"><strong>18</strong> Villa tersisa</span>
                    </div>
                    <div class="stat-item">
                        <i class="fas fa-clock text-danger me-2"></i>
                        <span class="stat-text">Promo berakhir dalam <strong id="urgencyHours">2</strong> jam</span>
                    </div>
                </div>
                
                <div class="urgency-actions">
                    <button class="elegant-btn btn-urgency btn-sm" onclick="scrollToVillas()">
                        <i class="fas fa-arrow-down me-1"></i>
                        Pilih Villa
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sticky Promo Banner (Mobile) -->
    <div class="sticky-promo-mobile" id="stickyPromoMobile">
        <div class="sticky-content">
            <div class="sticky-info">
                <span class="sticky-discount">{{ $promo['discount'] }} OFF</span>
                <span class="sticky-text">Flash Sale - Berakhir Segera!</span>
            </div>
            <button class="elegant-btn sticky-cta btn btn-sm" onclick="scrollToVillas()">
                Pesan
            </button>
            <button class="sticky-close" onclick="closeStickyPromo()" aria-label="Tutup promo">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
</section>

@push('js')
<script>
// Countdown Timer with Performance Optimization
document.addEventListener('DOMContentLoaded', function() {
    // Cache DOM elements
    const elements = {
        countdown: document.getElementById('promoCountdown'),
        days: document.getElementById('days'),
        hours: document.getElementById('hours'),
        minutes: document.getElementById('minutes'),
        seconds: document.getElementById('seconds'),
        urgencyHours: document.getElementById('urgencyHours'),
        stickyPromo: document.getElementById('stickyPromoMobile'),
        promoSection: document.querySelector('.promo-banner-section'),
        copyFeedback: document.getElementById('copyFeedback')
    };
    
    // Set end date
    const endDate = new Date('{{ $promo['valid_until'] }}').getTime();
    let countdownInterval;
    
    // Optimized countdown function
    function updateCountdown() {
        const now = new Date().getTime();
        const distance = endDate - now;
        
        // Check if countdown expired
        if (distance < 0) {
            if (elements.countdown) {
                elements.countdown.innerHTML = '<div class="expired-message">Promo telah berakhir</div>';
            }
            // Clear interval to save resources
            if (countdownInterval) {
                clearInterval(countdownInterval);
            }
            return;
        }
        
        // Calculate time units
        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
        
        // Update DOM with null checks
        if (elements.days) elements.days.textContent = String(days).padStart(2, '0');
        if (elements.hours) {
            elements.hours.textContent = String(hours).padStart(2, '0');
            if (elements.urgencyHours) elements.urgencyHours.textContent = hours;
        }
        if (elements.minutes) elements.minutes.textContent = String(minutes).padStart(2, '0');
        if (elements.seconds) elements.seconds.textContent = String(seconds).padStart(2, '0');
    }
    
    // Initial update
    updateCountdown();
    
    // Set interval with reference for cleanup
    countdownInterval = setInterval(updateCountdown, 1000);
    
    // Cleanup on page unload
    window.addEventListener('beforeunload', function() {
        if (countdownInterval) {
            clearInterval(countdownInterval);
        }
    });
});

// Optimized Copy Promo Code with better error handling
function copyPromoCode(code) {
    // Fallback for older browsers
    const fallbackCopy = function(text) {
        const textArea = document.createElement('textarea');
        textArea.value = text;
        textArea.style.position = 'fixed';
        textArea.style.left = '-999999px';
        textArea.style.top = '-999999px';
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        
        try {
            document.execCommand('copy');
            showCopyFeedback();
        } catch (err) {
            console.error('Fallback copy failed:', err);
        }
        
        document.body.removeChild(textArea);
    };
    
    // Show feedback function
    const showCopyFeedback = function() {
        const feedback = document.getElementById('copyFeedback');
        if (feedback) {
            feedback.style.display = 'block';
            feedback.setAttribute('aria-live', 'polite');
            
            // Auto-hide after 3 seconds
            setTimeout(function() {
                feedback.style.display = 'none';
            }, 3000);
        }
    };
    
    // Try modern clipboard API first
    if (navigator.clipboard && navigator.clipboard.writeText) {
        navigator.clipboard.writeText(code)
            .then(showCopyFeedback)
            .catch(function(err) {
                console.error('Clipboard API failed:', err);
                fallbackCopy(code);
            });
    } else {
        // Use fallback for older browsers
        fallbackCopy(code);
    }
}

// Optimized Scroll to Villas with better error handling
function scrollToVillas() {
    try {
        const villasSection = document.querySelector('.popular-villas-section');
        if (villasSection) {
            villasSection.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        } else {
            console.warn('Popular villas section not found');
        }
    } catch (err) {
        console.error('Scroll to villas failed:', err);
    }
}

// Optimized Close Sticky Promo
function closeStickyPromo() {
    try {
        const stickyPromo = document.getElementById('stickyPromoMobile');
        if (stickyPromo) {
            stickyPromo.style.display = 'none';
            // Add animation for better UX
            stickyPromo.classList.add('hide-animation');
        }
    } catch (err) {
        console.error('Close sticky promo failed:', err);
    }
}

// Optimized scroll handler with throttling
let scrollTimeout;
window.addEventListener('scroll', function() {
    // Clear previous timeout
    if (scrollTimeout) {
        clearTimeout(scrollTimeout);
    }
    
    // Throttle scroll events for better performance
    scrollTimeout = setTimeout(function() {
        try {
            const stickyPromo = document.getElementById('stickyPromoMobile');
            const promoSection = document.querySelector('.promo-banner-section');
            
            if (stickyPromo && promoSection) {
                const promoBottom = promoSection.offsetTop + promoSection.offsetHeight;
                const isVisible = window.pageYOffset > promoBottom && window.pageYOffset < promoBottom + 500;
                
                if (isVisible) {
                    stickyPromo.style.display = 'block';
                    stickyPromo.classList.add('show-animation');
                    stickyPromo.classList.remove('hide-animation');
                } else {
                    stickyPromo.style.display = 'none';
                }
            }
        } catch (err) {
            console.error('Scroll handler failed:', err);
        }
    }, 100); // Throttle to 100ms for better performance
});

// Add keyboard navigation support
document.addEventListener('keydown', function(e) {
    // ESC key to close sticky promo
    if (e.key === 'Escape') {
        closeStickyPromo();
    }
    
    // Ctrl/Cmd + C to copy promo code when promo code is focused
    if ((e.ctrlKey || e.metaKey) && e.key === 'c') {
        const promoCode = document.getElementById('promoCode');
        if (promoCode && document.activeElement === promoCode) {
            e.preventDefault();
            copyPromoCode('{{ $promo['code'] }}');
        }
    }
});
</script>
@endpush