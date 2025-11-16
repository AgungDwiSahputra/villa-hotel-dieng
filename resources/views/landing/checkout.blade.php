<x-app-landing-layout>
    <section class="py-12 bg-gray-50 min-h-screen">
        <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Detail Pesanan -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Detail Pesanan</h2>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600 font-medium">Check-in</span>
                            <span class="text-gray-900" id="checkin-date">{{ $bookingData['start_date'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600 font-medium">Check-out</span>
                            <span class="text-gray-900" id="checkout-date">{{ $bookingData['end_date'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600 font-medium">Jumlah malam</span>
                            <span class="text-gray-900" id="night-count">{{ $bookingData['night'] }} Malam</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600 font-medium">Jumlah Unit</span>
                            <span class="text-gray-900" id="unit-count">{{ $bookingData['unit'] }} Unit</span>
                        </div>

                        <!-- Price Breakdown -->
                        <div id="price-breakdown" class="space-y-3">
                            <!-- Price Breakdown by Date -->
                            @if(isset($bookingData['price_breakdown']) && count($bookingData['price_breakdown']) > 0)
                                <div class="bg-gray-50 p-4 rounded-lg">
                                    <h4 class="text-sm font-semibold text-gray-700 mb-3">Rincian Harga per Hari</h4>
                                    <div class="space-y-2">
                                        @foreach($bookingData['price_breakdown'] as $day)
                                            <div class="flex justify-between items-center text-sm">
                                                <span class="text-gray-600">
                                                    {{ \Carbon\Carbon::parse($day['date'])->locale('id')->isoFormat('DD MMM YYYY') }}
                                                    ({{ $day['day_name'] }})
                                                    <span class="text-xs text-gray-500">
                                                        - {{ $day['price_type'] === 'weekend' ? 'Weekend' : 'Weekday' }}
                                                    </span>
                                                </span>
                                                <span class="text-gray-900 font-medium">
                                                    Rp. {{ number_format($day['total_for_day'], 0, ',', '.') }}
                                                </span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Original Price -->
                            <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                <span class="text-gray-600 font-medium">Total Harga</span>
                                <span id="original-price" class="text-gray-900">Rp. {{ number_format($bookingData['total'], 0, ',', '.') }}</span>
                            </div>

                            <!-- Store original price for JavaScript calculations -->
                            <input type="hidden" id="original-total" value="{{ $bookingData['total'] }}">
                            <input type="hidden" id="original-dp" value="{{ $bookingData['dp'] }}">

                            <!-- Discount (hidden by default) -->
                            <div id="discount-row" class="flex justify-between items-center py-2 border-b border-gray-200 hidden">
                                <span class="text-green-600 font-medium">
                                    <span id="discount-label">Diskon</span>
                                    <span id="promo-name" class="text-sm text-gray-500 block"></span>
                                </span>
                                <span id="discount-amount" class="text-green-600 font-semibold">-Rp. 0</span>
                            </div>

                            <!-- Final Price -->
                            <div class="flex justify-between items-center py-3 bg-gray-50 -mx-6 px-6 rounded-b-lg">
                                <span class="text-gray-900 font-bold text-lg">Total Pembayaran (DP)</span>
                                <span id="final-price" class="text-gray-900 font-bold text-xl">Rp. {{ number_format($bookingData['dp'], 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <!-- Promo Status Message -->
                        <div id="promo-status" class="mt-4 p-3 rounded-lg hidden">
                            <div id="promo-success" class="text-green-700 bg-green-50 border border-green-200 p-3 rounded-lg hidden">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span id="promo-success-message"></span>
                                </div>
                            </div>
                            <div id="promo-error" class="text-red-700 bg-red-50 border border-red-200 p-3 rounded-lg hidden">
                                <div class="flex items-center">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span id="promo-error-message"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Detail Pemesan -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Detail Pemesan</h2>
                    <form id="booking-form" class="space-y-6">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ $bookingData['produk_id'] }}">
                        <input type="hidden" name="start_date" value="{{ $bookingData['start_date'] }}">
                        <input type="hidden" name="end_date" value="{{ $bookingData['end_date'] }}">
                        <input type="hidden" name="night" value="{{ $bookingData['night'] }}">
                        <input type="hidden" name="unit" value="{{ $bookingData['unit'] }}">
                        <input type="hidden" id="dp_input" name="dp" value="{{ $bookingData['dp'] }}">
                        <input type="hidden" id="total_input" name="total" value="{{ $bookingData['total'] }}">

                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap*</label>
                            <input type="text" id="name" name="name" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                        </div>

                        <div>
                            <label for="no_wa" class="block text-sm font-medium text-gray-700 mb-2">Nomor Whatsapp*</label>
                            <input type="text" id="no_wa" name="no_wa" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Alamat Email*</label>
                            <input type="email" id="email" name="email" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" required>
                        </div>

                        <!-- Promo Code Section -->
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                            <h3 class="text-lg font-semibold text-blue-900 mb-3">Kode Promo (Opsional)</h3>

                            <div class="mb-4">
                                <label for="promo_code" class="block text-sm font-medium text-gray-700 mb-2">Masukkan Kode Promo</label>
                                <div class="flex gap-2">
                                    <input type="text" id="promo_code" name="promo_code" class="flex-1 px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors" placeholder="Contoh: PROMO-ABC123">
                                    <button type="button" id="apply_promo_btn" class="px-4 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                        Terapkan
                                    </button>
                                    <button type="button" id="remove_promo_btn" class="px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors hidden">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <!-- Available Promo Codes -->
                            <div class="mb-4">
                                <div class="flex items-center justify-between mb-3">
                                    <p class="text-sm font-medium text-gray-700">Kode Promo Tersedia:</p>
                                    {{-- <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                        Aktif
                                    </span> --}}
                                </div>
                                <div id="promo-list-container" class="space-y-3">
                                    <!-- Promo codes will be loaded here via JavaScript -->
                                    <div class="flex items-center justify-center py-8">
                                        <div class="animate-spin rounded-full h-6 w-6 border-b-2 border-blue-600"></div>
                                        <span class="ml-2 text-sm text-gray-600">Memuat promo...</span>
                                    </div>
                                </div>
                            </div>

                            <p class="text-xs text-gray-500">* Kode promo bersifat opsional dan dapat digunakan jika tersedia</p>
                        </div>

                        <div class="pt-4">
                            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed" id="booking-button">
                                Booking Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    @push('js')
        @if (env('MIDTRANS_IS_PRODUCTION'))
            <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
            </script>
        @else
            <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}">
            </script>
        @endif

        <style>
            /* Custom animations for promo cards */
            @keyframes pulse-gentle {
                0%, 100% { transform: scale(1); }
                50% { transform: scale(1.02); }
            }

            @keyframes shimmer {
                0% { background-position: -200px 0; }
                100% { background-position: calc(200px + 100%) 0; }
            }

            .promo-card-active {
                animation: pulse-gentle 2s infinite;
                box-shadow: 0 10px 25px -5px rgba(59, 130, 246, 0.3);
            }

            .promo-card-hover {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .promo-card-hover:hover {
                transform: translateY(-4px) scale(1.02);
                box-shadow: 0 20px 40px -10px rgba(59, 130, 246, 0.4);
            }

            /* Mobile touch improvements */
            @media (max-width: 640px) {
                .promo-card-hover:active {
                    transform: scale(0.98);
                    transition-duration: 0.1s;
                }

                .promo-card-hover {
                    transform: none;
                }
            }

            /* Loading animation */
            .promo-loading {
                background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
                background-size: 200px 100%;
                animation: shimmer 1.5s infinite;
            }

            /* Success animation */
            @keyframes checkmark {
                0% { transform: scale(0) rotate(45deg); opacity: 0; }
                50% { transform: scale(1.2) rotate(45deg); opacity: 1; }
                100% { transform: scale(1) rotate(0deg); opacity: 1; }
            }

            .checkmark-animation {
                animation: checkmark 0.6s ease-out;
            }
        </style>

        <script>
            // Global variables for booking data - get from PHP variable instead of session
            const bookingData = @json($bookingData);
            const produkData = @json($produk);
            let appliedPromo = null;

            // Global variables for touch interactions
            let touchStartTime = 0;
            let touchStartX = 0;
            let touchStartY = 0;

            // Load active promo codes on page load
            document.addEventListener('DOMContentLoaded', function() {
                loadActivePromos();
                setupPromoValidation();
                autoApplyProductPromo();
            });

            async function loadActivePromos() {
                try {
                    const response = await fetch('/api/promos/active');
                    const promos = await response.json();

                    const promoListContainer = document.getElementById('promo-list-container');
                    if (promos.length > 0) {
                        const promoHtml = promos.map(promo => {
                            let discountText = '';
                            let discountBadge = '';
                            let cardGradient = 'from-blue-50 to-indigo-50';
                            let iconColor = 'text-blue-600';

                            if (promo.discount_type === 'percentage') {
                                discountText = `${promo.discount_value}%`;
                                discountBadge = `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-green-100 text-green-800 border border-green-200">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                    Diskon ${promo.discount_value}%
                                </span>`;
                                cardGradient = 'from-green-50 to-emerald-50';
                                iconColor = 'text-green-600';
                            } else {
                                discountText = `Rp ${formatNumber(promo.discount_value)}`;
                                discountBadge = `<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-bold bg-orange-100 text-orange-800 border border-orange-200">
                                    <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"></path>
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"></path>
                                    </svg>
                                    Potongan Rp ${formatNumber(promo.discount_value)}
                                </span>`;
                                cardGradient = 'from-orange-50 to-amber-50';
                                iconColor = 'text-orange-600';
                            }

                            return `
                                <div class="group relative bg-gradient-to-r ${cardGradient} border border-gray-200 rounded-xl p-4 cursor-pointer promo-card-hover"
                                     onclick="applyPromoCodeWithFeedback('${promo.code}')"
                                     ontouchstart="handleTouchStart(event, '${promo.code}')"
                                     ontouchend="handleTouchEnd(event)">
                                    <!-- Ribbon for special offers -->
                                    <div class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-2 py-1 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                        Klik untuk pakai
                                    </div>

                                    <!-- Main Content -->
                                    <div class="flex items-start justify-between mb-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="flex-shrink-0 w-10 h-10 bg-white rounded-full flex items-center justify-center shadow-sm">
                                                <svg class="w-5 h-5 ${iconColor}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                                                </svg>
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900 text-lg font-mono tracking-wider">${promo.code}</h4>
                                                <p class="text-sm text-gray-600 font-medium">${promo.name}</p>
                                            </div>
                                        </div>
                                        <div class="flex-shrink-0">
                                            ${discountBadge}
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div class="text-sm text-gray-700 leading-relaxed mb-3">
                                        ${promo.description}
                                    </div>

                                    <!-- Action Indicator -->
                                    <div class="flex items-center justify-between pt-2 border-t border-gray-200">
                                        <span class="text-xs text-gray-500 flex items-center">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                            </svg>
                                            Klik untuk menerapkan
                                        </span>
                                        <svg class="w-4 h-4 text-blue-600 group-hover:text-blue-800 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </div>

                                    <!-- Hover Effect Overlay -->
                                    <div class="absolute inset-0 bg-blue-400 opacity-0 group-hover:opacity-5 rounded-xl transition-opacity duration-300 pointer-events-none"></div>
                                </div>
                            `;
                        }).join('');

                        promoListContainer.innerHTML = promoHtml;
                    } else {
                        promoListContainer.innerHTML = `
                            <div class="text-center py-8">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada promo aktif</h3>
                                <p class="mt-1 text-sm text-gray-500">Promo akan muncul di sini saat tersedia.</p>
                            </div>
                        `;
                    }
                } catch (error) {
                    console.error('Error loading promos:', error);
                    document.getElementById('promo-list-container').innerHTML = '<div class="text-red-500 text-sm">Gagal memuat promo</div>';
                }
            }

            function setupPromoValidation() {
                const promoInput = document.getElementById('promo_code');
                const applyBtn = document.getElementById('apply_promo_btn');
                const removeBtn = document.getElementById('remove_promo_btn');

                // Apply button click handler
                applyBtn.addEventListener('click', async function() {
                    const promoCode = promoInput.value.trim().toUpperCase();
                    if (promoCode) {
                        await validatePromoCode(promoCode);
                    }
                });

                // Remove button click handler
                removeBtn.addEventListener('click', function() {
                    removePromoCode();
                });

                // Enter key handler for promo input
                promoInput.addEventListener('keypress', function(e) {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        const promoCode = this.value.trim().toUpperCase();
                        if (promoCode) {
                            validatePromoCode(promoCode);
                        }
                    }
                });

                // Real-time validation on input change
                promoInput.addEventListener('input', debounce(async function() {
                    const promoCode = this.value.trim().toUpperCase();
                    this.value = promoCode; // Convert to uppercase

                    if (promoCode.length === 0) {
                        resetPromoDisplay();
                        return;
                    }

                    if (promoCode.length >= 3) {
                        await validatePromoCode(promoCode);
                    }
                }, 500));

                // Clear promo on focus if empty
                promoInput.addEventListener('focus', function() {
                    if (this.value.trim() === '') {
                        resetPromoDisplay();
                    }
                });
            }

            async function validatePromoCode(promoCode) {
                try {
                    const response = await fetch('/api/promos/preview', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            promo_code: promoCode,
                            produk_id: bookingData.produk_id,
                            start_date: bookingData.start_date,
                            end_date: bookingData.end_date,
                            unit: bookingData.unit,
                            night: bookingData.night,
                            total: bookingData.total,
                            dp: bookingData.dp
                        })
                    });

                    const result = await response.json();

                    if (result.valid) {
                        showPromoSuccess(result);
                        appliedPromo = result;
                    } else {
                        showPromoError(result.message);
                        appliedPromo = null;
                    }
                } catch (error) {
                    console.error('Error validating promo:', error);
                    showPromoError('Terjadi kesalahan saat memvalidasi promo');
                    appliedPromo = null;
                }
            }

            function showPromoSuccess(result) {
                // Hide error, show success
                document.getElementById('promo-error').classList.add('hidden');
                document.getElementById('promo-success').classList.remove('hidden');
                document.getElementById('promo-status').classList.remove('hidden');

                // Update success message
                document.getElementById('promo-success-message').textContent = result.message;

                // Show discount row
                document.getElementById('discount-row').classList.remove('hidden');

                // Update discount info
                document.getElementById('promo-name').textContent = `(${result.promo.name})`;
                document.getElementById('discount-label').textContent =
                    result.promo.discount_type === 'percentage'
                        ? `Diskon ${result.promo.discount_value}%`
                        : 'Diskon Fixed';

                // Update prices
                document.getElementById('discount-amount').textContent =
                    `-Rp. ${formatNumber(result.calculation.discount_amount)}`;
                document.getElementById('final-price').textContent =
                    `Rp. ${formatNumber(result.calculation.final_dp)}`;

                // Update hidden form inputs with discounted values
                // document.getElementById('dp_input').value = result.calculation.final_dp;
                // document.getElementById('total_input').value = result.calculation.final_total;

                // Add success styling to input
                document.getElementById('promo_code').classList.remove('border-red-300');
                document.getElementById('promo_code').classList.add('border-green-300');

                // Show remove button, hide apply button
                document.getElementById('apply_promo_btn').classList.add('hidden');
                document.getElementById('remove_promo_btn').classList.remove('hidden');
            }

            function showPromoError(message) {
                // Hide success, show error
                document.getElementById('promo-success').classList.add('hidden');
                document.getElementById('promo-error').classList.remove('hidden');
                document.getElementById('promo-status').classList.remove('hidden');

                // Update error message
                document.getElementById('promo-error-message').textContent = message;

                // Hide discount row
                document.getElementById('discount-row').classList.add('hidden');

                // Reset final price to original
                const originalDp = document.getElementById('original-dp').value;
                const originalTotal = document.getElementById('original-total').value;
                document.getElementById('final-price').textContent =
                    `Rp. ${formatNumber(originalDp)}`;

                // Reset hidden form inputs to original values
                // document.getElementById('dp_input').value = originalDp;
                // document.getElementById('total_input').value = originalTotal;

                // Add error styling to input
                document.getElementById('promo_code').classList.remove('border-green-300');
                document.getElementById('promo_code').classList.add('border-red-300');
            }

            function resetPromoDisplay() {
                // Hide all status messages
                document.getElementById('promo-status').classList.add('hidden');
                document.getElementById('promo-success').classList.add('hidden');
                document.getElementById('promo-error').classList.add('hidden');

                // Hide discount row
                document.getElementById('discount-row').classList.add('hidden');

                // Reset prices to original (use stored original values)
                const originalDp = document.getElementById('original-dp').value;
                const originalTotal = document.getElementById('original-total').value;
                document.getElementById('final-price').textContent =
                    `Rp. ${formatNumber(originalDp)}`;

                // Reset hidden form inputs to original values
                // document.getElementById('dp_input').value = originalDp;
                // document.getElementById('total_input').value = originalTotal;

                // Reset input styling
                document.getElementById('promo_code').classList.remove('border-red-300', 'border-green-300');

                // Show apply button, hide remove button
                document.getElementById('apply_promo_btn').classList.remove('hidden');
                document.getElementById('remove_promo_btn').classList.add('hidden');

                appliedPromo = null;
            }

            function applyPromoCode(promoCode) {
                document.getElementById('promo_code').value = promoCode;
                validatePromoCode(promoCode);
            }

            function removePromoCode() {
                document.getElementById('promo_code').value = '';
                resetPromoDisplay();
                // Hide remove button, show apply button
                document.getElementById('remove_promo_btn').classList.add('hidden');
                document.getElementById('apply_promo_btn').classList.remove('hidden');
            }

            // Auto-apply product-specific promo codes
            async function autoApplyProductPromo() {
                // Define product-specific auto-apply promo codes
                const productPromoCodes = {
                    '38c27416-26a2-4449-a0bf-936ee555a0e7': 'AGUNG_ULTAH' // Product ID -> Promo Code mapping
                };

                const productId = bookingData.produk_id;
                const autoPromoCode = productPromoCodes[productId];

                if (autoPromoCode) {
                    // Auto-apply the promo code
                    document.getElementById('promo_code').value = autoPromoCode;
                    await validatePromoCode(autoPromoCode);

                    // Note: Input hidden values will be updated by showPromoSuccess function
                    // which is called by validatePromoCode when promo is successfully applied

                    // Show info that promo was auto-applied
                    setTimeout(() => {
                        showPromoInfo(`Kode promo "${autoPromoCode}" telah otomatis diterapkan untuk produk ini.`);
                    }, 1000);
                }
            }

            function showPromoInfo(message) {
                // Create temporary info message
                const infoDiv = document.createElement('div');
                infoDiv.className = 'text-blue-700 bg-blue-50 border border-blue-200 p-3 rounded-lg mb-4';
                infoDiv.innerHTML = `
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                        </svg>
                        <span>${message}</span>
                    </div>
                `;

                const promoSection = document.querySelector('.bg-blue-50');
                promoSection.insertBefore(infoDiv, promoSection.firstChild);

                // Auto-remove after 5 seconds
                setTimeout(() => {
                    if (infoDiv.parentNode) {
                        infoDiv.remove();
                    }
                }, 5000);
            }

            function formatNumber(num) {
                return new Intl.NumberFormat('id-ID').format(num);
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

            // Touch interaction handlers for mobile
            function handleTouchStart(event, promoCode) {
                touchStartTime = Date.now();
                touchStartX = event.touches[0].clientX;
                touchStartY = event.touches[0].clientY;

                // Add visual feedback
                event.currentTarget.classList.add('scale-95');
                event.currentTarget.style.transition = 'transform 0.1s ease-out';
            }

            function handleTouchEnd(event) {
                const touchEndTime = Date.now();
                const touchDuration = touchEndTime - touchStartTime;

                // Remove visual feedback
                event.currentTarget.classList.remove('scale-95');
                event.currentTarget.style.transition = 'transform 0.2s ease-out';

                // Check if it's a valid tap (not a swipe)
                if (touchDuration < 300) { // Less than 300ms
                    const touchEndX = event.changedTouches[0].clientX;
                    const touchEndY = event.changedTouches[0].clientY;
                    const deltaX = Math.abs(touchEndX - touchStartX);
                    const deltaY = Math.abs(touchEndY - touchStartY);

                    // If movement is minimal, consider it a tap
                    if (deltaX < 10 && deltaY < 10) {
                        // Get promo code from onclick attribute
                        const onclickAttr = event.currentTarget.getAttribute('onclick');
                        const promoCodeMatch = onclickAttr.match(/applyPromoCodeWithFeedback\('([^']+)'\)/);
                        if (promoCodeMatch) {
                            applyPromoCodeWithFeedback(promoCodeMatch[1]);
                        }
                    }
                }
            }

            // Enhanced promo application with visual feedback
            function applyPromoCodeWithFeedback(promoCode) {
                // Find the promo card and add success animation
                const promoCards = document.querySelectorAll('[onclick*="applyPromoCode"]');
                promoCards.forEach(card => {
                    if (card.onclick.toString().includes(promoCode)) {
                        card.classList.add('promo-card-active');

                        // Add checkmark animation
                        const checkmark = document.createElement('div');
                        checkmark.className = 'absolute inset-0 flex items-center justify-center bg-green-500 bg-opacity-90 rounded-xl checkmark-animation';
                        checkmark.innerHTML = `
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path>
                            </svg>
                        `;
                        card.appendChild(checkmark);

                        // Remove animation after 1 second
                        setTimeout(() => {
                            card.classList.remove('promo-card-active');
                            checkmark.remove();
                        }, 1000);
                    }
                });

                // Apply the promo code
                applyPromoCode(promoCode);
            }
        </script>
        <script>
            $(document).ready(function() {
                $('.copy-btn').on('click', function() {
                    const targetId = $(this).data('target');
                    const rekeningText = $('#' + targetId).text().trim();

                    // Salin ke clipboard
                    const tempInput = $("<input>");
                    $("body").append(tempInput);
                    tempInput.val(rekeningText).select();
                    document.execCommand("copy");
                    tempInput.remove();

                    // Feedback tombol
                    const originalText = $(this).html();
                    $(this).html('Disalin!');
                    const btn = $(this);
                    setTimeout(function() {
                        btn.html(originalText);
                    }, 1500);
                });
            });
        </script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const bookingForm = document.getElementById('booking-form');
                const bookingButton = document.getElementById('booking-button');

                bookingButton.addEventListener('click', async function(e) {
                    e.preventDefault();

                    // Validate promo code before submission
                    const promoInput = document.getElementById('promo_code');
                    const promoCode = promoInput.value.trim();

                    if (promoCode && !appliedPromo) {
                        // User entered promo code but it's not validated
                        showPromoError('Silakan validasi kode promo terlebih dahulu atau hapus kode promo yang tidak valid.');
                        promoInput.focus();
                        return;
                    }

                    bookingButton.disabled = true;
                    bookingButton.innerHTML = 'Processing...';

                    const formData = new FormData(bookingForm);

                    // Only send promo code if it's validated and applied
                    if (appliedPromo) {
                        formData.set('promo_code', appliedPromo.promo.code);
                        // Update total and dp with discounted values
                        formData.set('total', appliedPromo.calculation.original_total);
                        formData.set('dp', appliedPromo.calculation.original_dp);
                        // console.log('Sending promo data:', {
                        //     promo_code: appliedPromo.promo.code,
                        //     total: appliedPromo.calculation.original_total,
                        //     dp: appliedPromo.calculation.original_dp,
                        //     applied: appliedPromo
                        // });
                    } else {
                        console.log('No promo applied, sending original values');
                    }

                    try {
                        const response = await fetch('/booking/process', {
                            method: 'POST',
                            body: formData,
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        });

                        const data = await response.json();

                        if (response.ok && data.status === 'success' && data.snap_token) {
                            await payWithSnap(data.snap_token);
                        } else {
                            throw new Error(data.message || 'Terjadi kesalahan');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
                    } finally {
                        resetButton();
                    }
                });

                async function payWithSnap(snapToken) {
                    try {
                        await window.snap.pay(snapToken, {
                            onSuccess: function(result) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Pembayaran Berhasil',
                                    text: "Terima kasih, transaksi Anda telah berhasil.",
                                    showConfirmButton: true
                                }).then(() => {
                                    window.location.href = document.referrer;
                                });
                            },
                            onPending: function(result) {
                                resetButton();
                            },
                            onError: function(result) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Pembayaran Gagal',
                                    text: "Pembayaran Anda gagal. Silakan coba lagi.",
                                    showConfirmButton: true
                                })
                                resetButton();
                            },
                            onClose: function() {
                                resetButton();
                            }
                        });
                    } catch (error) {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan koneksi. Silakan coba lagi.');
                        resetButton();
                    }
                }

                function resetButton() {
                    bookingButton.disabled = false;
                    bookingButton.innerHTML = 'Booking Sekarang';
                }
            });
        </script>
    @endpush
</x-app-landing-layout>
