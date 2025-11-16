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
                            <span class="text-gray-900">{{ session('produk_booking')['start_date'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600 font-medium">Check-out</span>
                            <span class="text-gray-900">{{ session('produk_booking')['end_date'] }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600 font-medium">Jumlah malam</span>
                            <span class="text-gray-900">{{ session('produk_booking')['night'] }} Malam</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600 font-medium">Jumlah Unit</span>
                            <span class="text-gray-900">{{ session('produk_booking')['unit'] }} Unit</span>
                        </div>
                        <div class="flex justify-between items-center py-3 border-b border-gray-200">
                            <span class="text-gray-600 font-medium">Total DP ({{ $settings['dp'] ?? null }})</span>
                            <span class="text-gray-900 font-semibold">Rp. {{ number_format(session('produk_booking')['dp'], 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center py-3">
                            <span class="text-gray-600 font-medium">Total harga</span>
                            <span class="text-gray-900 font-bold text-lg">Rp. {{ number_format(session('produk_booking')['total'], 0, ',', '.') }}</span>
                        </div>
                    </div>
                </div>

                <!-- Detail Pemesan -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">Detail Pemesan</h2>
                    <form id="booking-form" class="space-y-6">
                        @csrf
                        <input type="hidden" name="produk_id" value="{{ session('produk_booking')['produk_id'] }}">
                        <input type="hidden" name="start_date" value="{{ session('produk_booking')['start_date'] }}">
                        <input type="hidden" name="end_date" value="{{ session('produk_booking')['end_date'] }}">
                        <input type="hidden" name="night" value="{{ session('produk_booking')['night'] }}">
                        <input type="hidden" name="unit" value="{{ session('produk_booking')['unit'] }}">
                        <input type="hidden" name="dp" value="{{ session('produk_booking')['dp'] }}">
                        <input type="hidden" name="total" value="{{ session('produk_booking')['total'] }}">

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

                    bookingButton.disabled = true;
                    bookingButton.innerHTML = 'Processing...';

                    const formData = new FormData(bookingForm);

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
                    bookingButton.innerHTML = 'Booking';
                }
            });
        </script>
    @endpush
</x-app-landing-layout>
