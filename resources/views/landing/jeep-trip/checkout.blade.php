<x-app-landing-layout title="Checkout Jeep Trip - {{ $jeepTrip->nama_paket }}" subTitle="Selesaikan Pembayaran Jeep Trip">
    @push('css')
        <style>
            .checkout-form {
                max-width: 800px;
                margin: 0 auto;
            }
            .order-summary {
                background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
                border-radius: 12px;
                padding: 2rem;
            }
            .price-breakdown {
                background: white;
                border-radius: 8px;
                padding: 1.5rem;
                margin-top: 1rem;
            }
        </style>
    @endpush

    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="flex mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('index') }}" class="text-gray-700 hover:text-blue-600">Beranda</a>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="bx bx-chevron-right text-gray-400 mx-1"></i>
                        <a href="{{ route('jeep-trip.index') }}" class="text-gray-700 hover:text-blue-600">Jeep Trip</a>
                    </div>
                </li>
                <li>
                    <div class="flex items-center">
                        <i class="bx bx-chevron-right text-gray-400 mx-1"></i>
                        <a href="{{ route('jeep-trip.show', $jeepTrip->slug) }}" class="text-gray-700 hover:text-blue-600">{{ $jeepTrip->nama_paket }}</a>
                    </div>
                </li>
                <li aria-current="page">
                    <div class="flex items-center">
                        <i class="bx bx-chevron-right text-gray-400 mx-1"></i>
                        <span class="text-gray-500">Checkout</span>
                    </div>
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Left Column - Customer Information -->
            <div>
                <div class="bg-white rounded-lg shadow-sm border p-6">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Informasi Pemesan</h2>

                    <form action="{{ route('jeep-trip.final') }}" method="POST" id="checkout-form">
                        @csrf

                        <!-- Hidden fields -->
                        <input type="hidden" name="total" value="{{ $dpAmount }}">

                        <!-- Customer Information -->
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="no_wa" class="block text-sm font-medium text-gray-700 mb-2">Nomor WhatsApp *</label>
                                <input type="text" id="no_wa" name="no_wa" value="{{ old('no_wa', auth()->user()->no_hp ?? '') }}"
                                       placeholder="081234567890"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                       required>
                                @error('no_wa')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>


                            <!-- Terms and Conditions -->
                            <div class="flex items-start">
                                <input type="checkbox" id="terms" name="terms" class="mt-1 mr-3" required>
                                <label for="terms" class="text-sm text-gray-600 cursor-pointer">
                                    Saya telah membaca dan menyetujui
                                    <a href="{{ route('sk') }}" target="_blank" class="text-blue-600 hover:text-blue-800">syarat dan ketentuan</a>
                                    yang berlaku.
                                </label>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Right Column - Order Summary -->
            <div>
                <div class="order-summary">
                    <h2 class="text-xl font-semibold text-gray-900 mb-6">Ringkasan Pesanan</h2>

                    <!-- Jeep Trip Info -->
                    <div class="bg-white rounded-lg p-4 mb-6">
                        <div class="flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                @if($jeepTrip->images->count() > 0)
                                    <img src="{{ asset('storage/' . $jeepTrip->images->first()->image_path) }}"
                                         alt="{{ $jeepTrip->nama_paket }}"
                                         class="w-16 h-16 object-cover rounded-lg">
                                @else
                                    <div class="w-16 h-16 bg-gray-200 rounded-lg flex items-center justify-center">
                                        <i class="bx bx-car text-gray-400 text-xl"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $jeepTrip->nama_paket }}</h3>
                                @if($jeepTrip->zona)
                                    <p class="text-sm text-gray-600">{{ ucfirst($jeepTrip->zona) }}</p>
                                @endif
                                <p class="text-sm text-gray-600">{{ $jeepTrip->durasi_jam }} jam</p>
                            </div>
                        </div>
                    </div>

                    <!-- Booking Details -->
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Tanggal Trip</span>
                            <span class="font-medium text-gray-900">
                                {{ \Carbon\Carbon::parse($bookingData['tanggal_trip'])->locale('id')->isoFormat('DD MMMM YYYY') }}
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Slot Waktu</span>
                            <span class="font-medium text-gray-900">
                                {{ $bookingData['slot_info']['nama_slot'] }}
                                ({{ date('H:i', strtotime($bookingData['slot_info']['jam_mulai'])) }} -
                                 {{ date('H:i', strtotime($bookingData['slot_info']['jam_selesai'])) }})
                            </span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Jumlah Jeep</span>
                            <span class="font-medium text-gray-900">{{ $bookingData['jumlah_jeep'] }} jeep</span>
                        </div>

                        <div class="flex justify-between">
                            <span class="text-gray-600">Harga per Jeep</span>
                            <span class="font-medium text-gray-900">
                                Rp {{ number_format($bookingData['harga_per_jeep'], 0, ',', '.') }}
                                @if($bookingData['is_weekend'])
                                    <span class="text-xs text-orange-600">(Weekend)</span>
                                @else
                                    <span class="text-xs text-green-600">(Weekday)</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Price Breakdown -->
                    <div class="price-breakdown">
                        <div class="flex justify-between items-center mb-3">
                            <span class="text-gray-600">Subtotal ({{ $bookingData['jumlah_jeep'] }} jeep)</span>
                            <span class="font-medium text-gray-900">
                                Rp {{ number_format($bookingData['total_harga'], 0, ',', '.') }}
                            </span>
                        </div>

                        <!-- DP Section -->
                        <div class="bg-blue-50 rounded-lg p-3 mb-4">
                            <div class="flex justify-between items-center">
                                <span class="text-sm text-gray-600">DP (Down Payment) {{ $dpPercentage }}%</span>
                                <span class="font-semibold text-blue-600">
                                    Rp {{ number_format($dpAmount, 0, ',', '.') }}
                                </span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                Bayar DP sekarang, pelunasan saat trip berlangsung
                            </p>
                        </div>

                        <hr class="my-3">

                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-900">Total Pembayaran</span>
                            <span class="text-xl font-bold text-blue-600">
                                Rp {{ number_format($dpAmount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <!-- Payment Instructions -->
                    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mt-6">
                        <div class="flex items-start">
                            <i class="bx bx-info-circle text-yellow-600 mt-0.5 mr-3"></i>
                            <div>
                                <h3 class="font-medium text-yellow-800 mb-2">Instruksi Pembayaran</h3>
                                <ul class="text-sm text-yellow-700 space-y-1">
                                    <li>• Bayar DP {{ $dpPercentage }}% melalui Midtrans</li>
                                    <li>• Pilih metode pembayaran yang tersedia (GoPay, Bank Transfer)</li>
                                    <li>• Konfirmasi pembayaran otomatis</li>
                                    <li>• Pelunasan dilakukan saat trip berlangsung</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Book Button -->
                    <button type="button" id="pay-button"
                            class="w-full bg-blue-600 text-white py-4 px-6 rounded-lg font-semibold text-lg hover:bg-blue-700 transition-colors mt-6 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="bx bx-credit-card mr-2"></i>Bayar DP & Pesan Jeep Trip
                    </button>

                    <!-- Back Button -->
                    <a href="{{ route('jeep-trip.show', $jeepTrip->slug) }}"
                       class="w-full bg-gray-200 text-gray-700 py-3 px-6 rounded-lg font-medium text-center hover:bg-gray-300 transition-colors mt-3 inline-block">
                        <i class="bx bx-arrow-back mr-2"></i>Kembali ke Detail
                    </a>

                    <!-- Error Recovery Section (hidden by default) -->
                    <div id="error-recovery" class="hidden mt-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <h4 class="font-medium text-red-800 mb-2">Mengalami Masalah?</h4>
                        <div class="flex space-x-2">
                            <button type="button" onclick="window.location.reload()"
                                    class="bg-blue-600 text-white px-4 py-2 rounded text-sm hover:bg-blue-700">
                                <i class="bx bx-refresh mr-1"></i>Refresh Halaman
                            </button>
                            <a href="{{ route('jeep-trip.booking') }}?restart=1"
                               class="bg-gray-600 text-white px-4 py-2 rounded text-sm hover:bg-gray-700">
                                <i class="bx bx-restart mr-1"></i>Mulai Ulang Booking
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <!-- Midtrans Snap.js -->
        @if(config('midtrans.is_production'))
            <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        @else
            <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
        @endif
        
        <script>
            let snapToken = null;

            // Form validation and booking creation
            document.getElementById('pay-button').addEventListener('click', function(e) {
                e.preventDefault();

                const termsCheckbox = document.getElementById('terms');
                if (!termsCheckbox.checked) {
                    alert('Anda harus menyetujui syarat dan ketentuan terlebih dahulu.');
                    return false;
                }

                // Validate DP amount before submission
                const expectedDpAmount = {{ $dpAmount }};
                const formTotal = parseFloat(document.getElementById('checkout-form').total.value);

                console.log('DP Amount validation:', {
                    expected: expectedDpAmount,
                    received: formTotal,
                    totalHarga: {{ $bookingData['total_harga'] }},
                    dpPercentage: {{ $dpPercentage }}
                });

                if (Math.abs(formTotal - expectedDpAmount) > 0.01) {
                    console.error('DP Amount validation failed:', {
                        expected: expectedDpAmount,
                        received: formTotal,
                        difference: Math.abs(formTotal - expectedDpAmount)
                    });
                    alert('Terjadi kesalahan pada perhitungan DP. Silakan refresh halaman.');
                    return false;
                }

                // Show loading state
                const button = this;
                button.disabled = true;
                button.innerHTML = '<i class="bx bx-loader-alt bx-spin mr-2"></i>Memproses Booking...';

                // Get form data
                const formData = new FormData(document.getElementById('checkout-form'));

                // Create booking first
                fetch('{{ route("jeep-trip.final") }}', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log('Booking response:', data);

                    if (data.status === 'success') {
                        snapToken = data.snap_token;

                        // Open Midtrans Snap payment
                        snap.pay(snapToken, {
                            onSuccess: function(result) {
                                console.log('Payment success:', result);
                                window.location.href = '{{ route("jeep-trip.index") }}' + '?success=1&order_id=' + data.order_id;
                            },
                            onPending: function(result) {
                                console.log('Payment pending:', result);
                                window.location.href = '{{ route("jeep-trip.index") }}' + '?pending=1&order_id=' + data.order_id;
                            },
                            onError: function(result) {
                                console.log('Payment error:', result);
                                alert('Pembayaran gagal. Silakan coba lagi.');
                                window.location.reload();
                            },
                            onClose: function() {
                                console.log('Payment popup closed');
                                // Optional: handle when user closes payment popup
                            }
                        });
                    } else {
                        console.error('Booking failed:', data);
                        alert(data.message || 'Terjadi kesalahan saat memproses booking.');

                        // Show error recovery options for specific errors
                        if (data.message && (data.message.includes('DP') || data.message.includes('sesi'))) {
                            document.getElementById('error-recovery').classList.remove('hidden');
                        }

                        button.disabled = false;
                        button.innerHTML = '<i class="bx bx-credit-card mr-2"></i>Bayar DP & Pesan Jeep Trip';
                    }
                })
                .catch(error => {
                    console.error('Network/JS Error:', error);
                    alert('Terjadi kesalahan jaringan. Silakan coba lagi.');

                    // Show error recovery for network errors
                    document.getElementById('error-recovery').classList.remove('hidden');

                    button.disabled = false;
                    button.innerHTML = '<i class="bx bx-credit-card mr-2"></i>Bayar DP & Pesan Jeep Trip';
                });
            });

            // Phone number formatting
            document.getElementById('no_wa').addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.startsWith('0')) {
                    value = '62' + value.substring(1);
                }
                e.target.value = value;
            });
        </script>
    @endpush
</x-app-landing-layout>