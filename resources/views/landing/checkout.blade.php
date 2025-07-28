<x-app-landing-layout>
    <section class="py-2 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="card shadow-sm p-3 mb-3">
                        <h5 class="mb-3">Detail Pesanan</h5>
                        <table class="table table-striped mb-0">
                            <tbody>
                                <tr>
                                    <th scope="row">Check-in</th>
                                    <td>{{ session('produk_booking')['start_date'] }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Check-out</th>
                                    <td>{{ session('produk_booking')['end_date'] }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Jumlah malam</th>
                                    <td>{{ session('produk_booking')['night'] }} Malam</td>
                                </tr>
                                <tr>
                                    <th scope="row">Jumlah Unit</th>
                                    <td>{{ session('produk_booking')['unit'] }} Unit</td>
                                </tr>
                                <tr>
                                    <th scope="row">Total Dp ({{ $settings['dp'] ?? null }})</th>
                                    <td>Rp. {{ number_format(session('produk_booking')['dp'], 0, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <th scope="row">Total harga</th>
                                    <td>Rp. {{ number_format(session('produk_booking')['total'], 0, ',', '.') }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    {{-- <div class="card shadow-sm p-3">
                        <h5 class="mb-3 fw-semibold">Rekening Pembayaran</h5>
                        @foreach ($rekenings as $rekening)
                            <div
                                class="d-flex align-items-center justify-content-between border rounded p-3 bg-light mb-3">
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset('storage/' . $rekening->image) }}" alt="Logo Bank" class="me-3"
                                        style="width: 70px; height: auto;">
                                    <div>
                                        <div class="fw-bold mb-1">No Rekening:
                                            <span id="rekening-{{ $loop->index }}">{{ $rekening->no_rekening }}</span>
                                        </div>
                                        <div class="text-muted small">a.n. {{ $rekening->name }}</div>
                                    </div>
                                </div>
                                <button class="btn btn-success btn-sm copy-btn"
                                    data-target="rekening-{{ $loop->index }}">
                                    Salin
                                </button>
                            </div>
                        @endforeach
                    </div> --}}
                </div>
                <div class="col-lg-6">
                    <div class="card shadow-sm p-4">
                        <h5 class="mb-4">Detail Pemesan</h5>
                        <form id="booking-form">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ session('produk_booking')['produk_id'] }}">
                            <input type="hidden" name="start_date"
                                value="{{ session('produk_booking')['start_date'] }}">
                            <input type="hidden" name="end_date" value="{{ session('produk_booking')['end_date'] }}">
                            <input type="hidden" name="night" value="{{ session('produk_booking')['night'] }}">
                            <input type="hidden" name="unit" value="{{ session('produk_booking')['unit'] }}">
                            <input type="hidden" name="dp" value="{{ session('produk_booking')['dp'] }}">
                            <input type="hidden" name="total" value="{{ session('produk_booking')['total'] }}">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Nama Lengkap*</label>
                                <input type="text" id="name" name="name" class="form-control"
                                    style="height: 40px;">
                            </div>

                            <div class="mb-3">
                                <label for="whatsapp" class="form-label">Nomor Whatsapp*</label>
                                <input type="text" id="no_wa" name="no_wa" class="form-control"
                                    style="height: 40px;">
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Alamat Email*</label>
                                <input type="text" id="email" name="email" class="form-control"
                                    style="height: 40px;">
                            </div>

                            {{-- <div class="mb-4">
                                <label for="bukti_pembayaran" class="form-label">Bukti Pembayaran*</label>
                                <input type="file" id="image" name="image" class="form-control"
                                    style="height: 40px;">
                            </div> --}}

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary px-4" id="booking-button">Booking</button>
                            </div>
                        </form>
                    </div>
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
