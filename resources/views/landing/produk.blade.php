<x-app-landing-layout>
    <section class="py-2 bg-light">
        <div class="container">
            <!-- Slider -->
            <div class="swiper mySwiper position-relative mb-4">
                <div class="swiper-wrapper">
                    @foreach ($produk->images as $image)
                        <div class="swiper-slide p-2" style="width: 100%">
                            <a href="{{ asset('storage/' . $image->image) }}" class="glightbox" data-gallery="gallery1">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $image->name }}"
                                    class="w-100 shadow-sm"
                                    style="height: 280px; object-fit: cover; border-radius: 0.75rem;">
                            </a>
                        </div>
                    @endforeach
                </div>
                <div class="swiper-pagination mt-3"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <div class="card shadow-sm p-3">
                        <h4 class="mb-3">{{ $produk->name }}</h4>
                        <p><strong>Ideal Orang:</strong> {{ $produk->orang }}</p>
                        <p><strong>Maks. Orang:</strong> {{ $produk->maks_orang }}</p>
                        <p><strong>Harga Weekday:</strong> <span class="text-primary fw-bold">Rp
                                {{ number_format($produk->harga_weekday, 0, ',', '.') }}</span></p>
                        <p><strong>Harga Weekend:</strong> <span class="text-danger fw-bold">Rp
                                {{ number_format($produk->harga_weekend, 0, ',', '.') }}</span></p>
                        <p><strong>Lokasi:</strong> {{ $produk->lokasi }}</p>
                    </div>
                </div>
                <div class="col-lg-6 mb-2">
                    <ul class="nav nav-tabs" id="produkTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="fasilitas-tab" data-bs-toggle="tab"
                                data-bs-target="#fasilitas" type="button" role="tab" aria-controls="fasilitas"
                                aria-selected="true">Fasilitas</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="wisata-tab" data-bs-toggle="tab" data-bs-target="#wisata"
                                type="button" role="tab" aria-controls="wisata"
                                aria-selected="false">Wisata</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="syarat-tab" data-bs-toggle="tab" data-bs-target="#syarat"
                                type="button" role="tab" aria-controls="syarat" aria-selected="false">S &
                                K</button>
                        </li>
                    </ul>

                    <div class="tab-content px-4 border border-top-0 rounded-bottom shadow-sm">
                        {{-- Fasilitas --}}
                        <div class="tab-pane fade show active" id="fasilitas" role="tabpanel"
                            aria-labelledby="fasilitas-tab">
                            @if ($produk->fasilitases->isNotEmpty())
                                <div class="row row-cols-1 row-cols-md-2 g-3" id="fasilitas-list">
                                    @foreach ($produk->fasilitases as $index => $fasilitas)
                                        <div
                                            class="col d-flex align-items-start text-secondary {{ $index >= 6 ? 'd-none extra-fasilitas' : '' }}">
                                            <i class="icon-checkmark-outline text-primary me-2 mt-2"></i>
                                            <span class="fw-medium">{{ $fasilitas->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($produk->fasilitases->count() > 6)
                                    <div class="mt-3">
                                        <button class="p-0 text-muted"
                                            style="background: none; border: none; box-shadow: none;"
                                            onmouseover="this.style.background='none'"
                                            onmouseout="this.style.background='none'"
                                            onclick="toggleItems('fasilitas')">
                                            Lihat Selengkapnya
                                        </button>
                                    </div>
                                @endif
                            @else
                                <div class="text-muted fst-italic">Belum ada informasi fasilitas.</div>
                            @endif
                        </div>

                        {{-- Wisata --}}
                        <div class="tab-pane fade" id="wisata" role="tabpanel" aria-labelledby="wisata-tab">
                            @if ($produk->wisatas->isNotEmpty())
                                <div class="row row-cols-1 row-cols-md-2 g-3" id="wisata-list">
                                    @foreach ($produk->wisatas as $index => $wisata)
                                        <div
                                            class="col d-flex align-items-start text-secondary {{ $index >= 6 ? 'd-none extra-wisata' : '' }}">
                                            <i class="icon-checkmark-outline text-primary me-2 mt-2"></i>
                                            <span class="fw-medium">{{ $wisata->name }}</span>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($produk->wisatas->count() > 6)
                                    <div class="mt-3">
                                        <button class="p-0 text-muted"
                                            style="background: none; border: none; box-shadow: none;"
                                            onmouseover="this.style.background='none'"
                                            onmouseout="this.style.background='none'" onclick="toggleItems('wisata')">
                                            Lihat Selengkapnya
                                        </button>
                                    </div>
                                @endif
                            @else
                                <div class="text-muted fst-italic">Belum ada informasi wisata terdekat.</div>
                            @endif
                        </div>

                        {{-- Syarat --}}
                        <div class="tab-pane fade" id="syarat" role="tabpanel" aria-labelledby="syarat-tab">
                            @forelse ($produk->syarats as $index => $syarat)
                                <div
                                    class="d-flex align-items-start mb-2 text-secondary {{ $index >= 6 ? 'd-none extra-syarat' : '' }}">
                                    <i class="icon-checkmark-outline text-primary me-2 mt-2"></i>
                                    <span class="fw-medium">{{ $syarat->name }}</span>
                                </div>
                            @empty
                                <div class="text-muted fst-italic">Belum ada informasi syarat & ketentuan.</div>
                            @endforelse
                            @if ($produk->syarats->count() > 6)
                                <div class="mt-3">
                                    <button class="p-0 text-muted"
                                        style="background: none; border: none; box-shadow: none;"
                                        onmouseover="this.style.background='none'"
                                        onmouseout="this.style.background='none'" onclick="toggleItems('syarat')">
                                        Lihat Selengkapnya
                                    </button>
                                </div>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="py-2 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 mb-2">
                    <div id="calendar"></div>
                </div>

                <div class="col-lg-6 mb-2">
                    <form action="{{ route('produk.booking') }}" method="POST" id="bookingForm">
                        @csrf
                        <div class="card shadow-sm p-3" id="bookingInfoText">
                            <p class="text-muted">
                                Pilih tanggal check-in dan check-out untuk info harga sesuai tanggal,
                            </p>
                            <p class="text-muted">
                                kemudian klik <span class="fw-bold"> "Booking Sekarang" </span>
                            </p>
                        </div>
                        <div class="card shadow-sm p-3" id="bookingSummary" style="display:none;">
                            <h5 class="mb-3">Ringkasan Booking</h5>
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th scope="row">Check-in</th>
                                        <td><input type="date" name="start_date" id="startDateInput"
                                                style="height: 10px; background-color:rgb(209, 209, 209)" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Check-out</th>
                                        <td><input type="date" name="end_date" id="endDateInput"
                                                style="height: 10px; background-color:rgb(209, 209, 209)" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Jumlah malam</th>
                                        <td><input type="number" name="night" id="nightInput"
                                                style="height: 10px; background-color:rgb(209, 209, 209)" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Jumlah Unit</th>
                                        <td> <input type="number" name="unit" id="unit" min="1"
                                                value="1" style="height: 10px;"> </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">DP ({{ $settings['dp'] ?? null }} %)</th>
                                        <td> <input type="number" name="dp" id="dpInput"
                                                style="height: 10px; background-color:rgb(209, 209, 209)" readonly>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row">Total harga</th>
                                        <td> <input type="number" name="total" id="totalInput"
                                                style="height: 10px; background-color:rgb(209, 209, 209)" readonly>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-end mt-3">
                                <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                                <button type="submit" class="btn btn-primary">Booking Sekarang</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-12">
                    <div class="card shadow-sm p-3">
                        <ul class="list-icon mb-37">
                            <li>
                                <i class="icon-Group-13"></i> <span>Pemesanan akan dikenakan <span>DP sebesar
                                        25%</span> dari total harga</span>
                            </li>
                            <li>
                                <i class="icon-Group-13"></i> <span>Pilih tanggal check in dan check out pada kalender
                                    diatas kemudian klik tombol <span class="pw-bold">Booking Sekarang</span> untuk
                                    pemesanan</span>
                            </li>
                            <li>
                                <i class="icon-Group-13"></i> <span>Setelah pembayaran, Anda selaku pemesan akan
                                    mendapatkan notifikasi melalui Whatsapp Admin</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-2 bg-light">
        <div class="container">
            <h5 class="mb-3">Rekomendasi Lainnya</h5>
            <div class="row">
                @foreach ($rekomendasis as $item)
                    <div class="col-lg-4">
                        <div class="tour-listing wow fadeInUp animated" data-wow-delay="0.1s">
                            <a href="{{ route('produk', $item->slug) }}" class="tour-listing-image">
                                <div class="badge-top flex-two">
                                    <span class="feature">{{ $item->category->name }}</span>
                                    <div class="badge-media flex-five">
                                        <span class="media">
                                            <i class="icon-Group-1000002909"></i>
                                            {{ $item->images->count() }}
                                        </span>
                                    </div>
                                </div>
                                <img src="{{ asset('storage/' . $item->images?->first()?->image ?? '') }}"
                                    alt="Image Listing">
                            </a>
                            <div class="tour-listing-content">
                                <span class="map"><i class="icon-Vector4"></i>{{ $item->lokasi }}</span>
                                <h3 class="title-tour-list">
                                    <a href="{{ route('produk', $item->slug) }}">{{ $item->name }}</a>
                                </h3>
                                <div class="review">
                                    <i class="icon-Star"></i><i class="icon-Star"></i>
                                    <i class="icon-Star"></i><i class="icon-Star"></i>
                                    <i class="icon-Star"></i>
                                </div>
                                <div class="icon-box flex-three" style="justify-content: flex-end;">
                                    <div class="icons flex-three"
                                        style="display: flex; align-items: center; gap: 15px;">
                                        <!-- Icon Orang -->
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <svg width="21" height="16" viewBox="0 0 21 16" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M4.34766 4.79761C4.34766 2.94013 5.85346 1.43433 7.71094 1.43433C9.56841 1.43433 11.0742 2.94013 11.0742 4.79761C11.0742 6.65508 9.56841 8.16089 7.71094 8.16089C5.85346 8.16089 4.34766 6.65508 4.34766 4.79761Z"
                                                    stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path
                                                    d="M9.5977 15.1797H2.46098C1.34827 15.1797 0.558268 14.0954 0.898984 13.0362C1.80408 10.222 4.57804 8.18566 7.69301 8.18566C9.17897 8.18566 10.5566 8.64906 11.6895 9.43922"
                                                    stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <path d="M17.1035 15.1797V9.02734" stroke="currentColor"
                                                    stroke-width="1.7" stroke-miterlimit="10" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M20.1797 12.1035H14.0273" stroke="currentColor"
                                                    stroke-width="1.7" stroke-miterlimit="10" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                            <span>{{ $item->orang }} - {{ $item->maks_orang }} Orang</span>
                                        </div>

                                        <!-- Icon Kamar -->
                                        <div style="display: flex; align-items: center; gap: 5px;">
                                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M4 3H20V21H4V3Z" stroke="currentColor" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                                <circle cx="16" cy="12" r="1" fill="currentColor" />
                                            </svg>
                                            <span>{{ $item->kamar }} Kamar</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex-two">
                                    <div class="price-box flex-three">
                                        <p class="d-flex justify-content-between w-100 mb-1">
                                            <span>Weekday</span>
                                            <span class="price-sale">Rp.
                                                {{ number_format($item->harga_weekday, 0, ',', '.') }}</span>
                                        </p>
                                        <p class="d-flex justify-content-between w-100 mb-0">
                                            <span>Weekend</span>
                                            <span class="price-sale">Rp.
                                                {{ number_format($item->harga_weekend, 0, ',', '.') }}</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @push('css')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
        <style>
            .glightbox-clean .gclose {
                position: fixed !important;
                top: 1rem;
                right: 1rem;
                z-index: 9999 !important;
                background: none !important;
                border: none !important;
                color: white !important;
                font-size: 2rem;
                line-height: 1;
                padding: 0;
                cursor: pointer;
            }

            /* Pastikan X muncul */
            .glightbox-clean .gclose::before {
                content: "✕";
                font-size: 2rem;
                display: block;
            }
        </style>
        <style>
            .fc-header-toolbar {
                background-color: #0f99e6
            }

            .fc-button {
                background-color: transparent !important;
                border: none !important
            }

            .fc-toolbar-title {
                color: white !important;
            }

            .fc-col-header {
                font-weight: bold;
            }

            .fc-daygrid-day-number {
                position: static !important;
                display: flex;
                justify-content: center;
                align-items: center;
                width: 100%;
                height: 100%;
                font-size: 16px;
                font-weight: bold;
                z-index: 2;
            }

            .fc-daygrid-day-frame {
                aspect-ratio: 1;
                padding: 0 !important;
                position: relative;
                display: flex;
                justify-content: center;
                align-items: center;
            }

            .fc-daygrid-day {
                border: 1px solid #e0e0e0;
                box-sizing: border-box;
            }

            /* Nonaktifkan scroll vertical */
            #calendar .fc-scroller,
            #calendar .fc-daygrid-body,
            #calendar .fc-scrollgrid {
                overflow-y: hidden !important;
            }

            /* Tanggal yang dinonaktifkan */
            .disabled-date {
                background: #e0a9ad !important;
                color: #e2e2e2 !important;
                pointer-events: none;
                opacity: 0.6;
            }
            .close-date {
                background: #4F545A !important;
                color: #4F545A !important;
                pointer-events: none;
                opacity: 0.6;
            }

            .fc-daygrid-day.selected-start,
            .fc-daygrid-day.in-range,
            .fc-daygrid-day.selected-end {
                background-color: #1a22382b;
                position: relative;
            }


            .fc-daygrid-day.selected-start {
                border-top-left-radius: 50px;
                border-bottom-left-radius: 50px;
            }

            .fc-daygrid-day.selected-end {
                border-top-right-radius: 50px;
                border-bottom-right-radius: 50px;
            }

            .fc-daygrid-day.selected-start .fc-daygrid-day-number,
            .fc-daygrid-day.in-range .fc-daygrid-day-number,
            .fc-daygrid-day.selected-end .fc-daygrid-day-number {
                border-radius: 50%;
                width: 75px;
                height: 75px;
                display: flex;
                justify-content: center;
                align-items: center;
                position: relative;
                z-index: 2;
            }

            .fc-daygrid-day.in-range .fc-daygrid-day-number {
                background-color: transparent;
                color: #fff;
            }

            .fc-daygrid-day.selected-start .fc-daygrid-day-frame,
            .fc-daygrid-day.selected-end .fc-daygrid-day-frame {
                background-color: #1a2238;
                color: #fff;
                border-radius: 50%;
            }

            .fc-daygrid-day.selected-start .fc-daygrid-day-number,
            .fc-daygrid-day.selected-end .fc-daygrid-day-number {
                color: #fff;
            }

            .fc-daygrid-day.selected-start.selected-end {
                background-color: transparent;
            }


            .fc-daygrid-day-frame {
                display: flex;
                justify-content: center;
                align-items: center;
                border: none !important;
            }

            .fc-daygrid-day-events {
                display: none;
            }

            .fc-day {
                border: none !important;
            }

            .fc-daygrid-day.in-range::before {
                display: none !important;
            }

            /* Tombol Swiper */
            .swiper-button-next,
            .swiper-button-prev {
                width: 40px;
                height: 40px;
                background: #12acff;
                border-radius: 50%;
                box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
                color: #fff;
                top: 50%;
                transform: translateY(-50%);
                transition: background 0.3s;
            }

            .swiper-button-next:hover,
            .swiper-button-prev:hover {
                background: #0f99e6;
            }

            .swiper-button-prev {
                left: 10px;
            }

            .swiper-button-next {
                right: 10px;
            }

            /* Pagination Swiper */
            .swiper-pagination-bullet {
                background: #1f2937;
                opacity: 0.7;
            }

            .swiper-pagination-bullet-active {
                background: #111827;
            }
        </style>
    @endpush

    @push('js')
        <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
        <script>
            // Init GLightbox
            const lightbox = GLightbox({
                selector: '.glightbox'
            });
            const produkUnit = {{ $produk->unit }};
            const hargaWeekday = {{ $produk->harga_weekday }};
            const hargaWeekend = {{ $produk->harga_weekend }};
            const bookedPerDate = @json($booked);
            const availableProducts = @json($availableProducts);
            // console.log(hargaWeekday);
            // console.log(hargaWeekend);
            let startDate = null,
                endDate = null,
                basePrice = 0;

            const isWeekend = d => [0, 6].includes(d.getDay());

            const calculatePrice = (start, end) => {
                let total = 0,
                    days = (end - start) / 86400000;
                for (let i = 0; i < days; i++) {
                    let d = new Date(start);
                    d.setDate(start.getDate() + i);
                    total += isWeekend(d) ? hargaWeekend : hargaWeekday;
                }
                return {
                    nights: days,
                    price: total
                };
            };

            const updateMaxUnit = (start, end) => {
                let min = produkUnit;
                for (let d = new Date(start); d < end; d.setDate(d.getDate() + 1)) {
                    let sisa = produkUnit - (bookedPerDate[d.toISOString().slice(0, 10)] || 0);
                    min = Math.min(min, sisa);
                }
                $('#unit').attr('max', min).val(function(_, val) {
                    return Math.min(val || 1, min);
                });
            };

            const containsFull = (start, end) => {
                for (let d = new Date(start); d < end; d.setDate(d.getDate() + 1)) {
                    if ((bookedPerDate[d.toISOString().slice(0, 10)] || 0) >= produkUnit) return true;
                }
                return false;
            };

            function changeUnit() {
                const dpPercent = {{ intval($settings['dp'] ?? 0) }};
                const unit = parseInt($('#unit').val()) || 0;
                const total = unit * basePrice;
                const dp = total * dpPercent / 100;

                $('#totalInput').val(total);
                $('#dpInput').val(dp);
            }


            function highlightRange(start, end) {
                $('.fc-daygrid-day').removeClass('selected-start selected-end in-range').each(function() {
                    const dateStr = $(this).data('date');
                    const date = new Date(dateStr + 'T12:00:00');
                    if (date.getTime() === start.getTime()) $(this).addClass('selected-start');
                    else if (date.getTime() === end.getTime()) $(this).addClass('selected-end');
                    else if (date > start && date < end) $(this).addClass('in-range');
                });
            }

            $(function() {
                var swiper = new Swiper(".mySwiper", {
                    slidesPerView: 1,
                    // spaceBetween: 10,
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                    navigation: {
                        nextEl: ".swiper-button-next",
                        prevEl: ".swiper-button-prev",
                    },
                    breakpoints: {
                        // Saat lebar layar >= 768px (tablet ke atas)
                        768: {
                            slidesPerView: 2,
                            spaceBetween: 20,
                        },
                        // Saat lebar layar >= 1024px (desktop)
                        1024: {
                            slidesPerView: 3,
                            spaceBetween: 30,
                        },
                    },
                });

                const calendar = new FullCalendar.Calendar($('#calendar')[0], {
                    locale: 'id',
                    initialView: 'dayGridMonth',
                    fixedWeekCount: false,
                    height: 'auto',
                    headerToolbar: {
                        left: 'prev',
                        center: 'title',
                        right: 'next'
                    },
                    validRange: now => ({
                        start: now.toISOString().slice(0, 10)
                    }),
                    dateClick: ({
                        dateStr
                    }) => {
                        const clicked = new Date(dateStr + 'T12:00:00');
                        const sisa = produkUnit - (bookedPerDate[dateStr] || 0);

                        if (sisa <= 0 && (!startDate || endDate)) return;

                        if (!startDate || endDate || clicked < startDate) {
                            startDate = clicked;
                            endDate = null;
                            basePrice = 0;
                            $('#bookingSummary').hide();
                            $('#bookingInfoText').show();
                            $('#unit').attr('max', sisa);
                            changeUnit();
                            highlightRange(startDate, startDate);
                        } else {
                            if (containsFull(startDate, clicked)) return alert(
                                'Tanggal termasuk yang penuh.');
                            endDate = clicked;
                            highlightRange(startDate, endDate);

                            const {
                                nights,
                                price
                            } = calculatePrice(startDate, endDate);
                            basePrice = price;
                            changeUnit();
                            updateMaxUnit(startDate, endDate);

                            $('#nightInput').val(nights);
                            $('#startDateInput').val(startDate.toISOString().slice(0, 10));
                            $('#endDateInput').val(endDate.toISOString().slice(0, 10));
                            $('#bookingSummary').show();
                            $('#bookingInfoText').hide();
                        }
                    },
                    dayCellDidMount: ({
                        el,
                        date
                    }) => {
                        const dateStr = date.toISOString().slice(0, 10);
                        if ((bookedPerDate[dateStr] || 0) >= produkUnit) {
                            $(el).addClass('disabled-date').css({
                                backgroundColor: '#f8d7da',
                                color: '#721c24',
                                pointerEvents: 'none',
                                cursor: 'not-allowed',
                                position: 'relative'
                            }).append(
                                `<div style="position:absolute;bottom:0;left:50%;transform:translateX(-50%);font-size:0.75em;font-weight:bold;color:#000;margin-bottom:-5px;">Penuh</div>`
                            );
                        }
                        if(availableProducts[dateStr]) {
                            $(el).addClass('close-date').css({
                                backgroundColor: '#f8d7da',
                                color: '#721c24',
                                pointerEvents: 'none',
                                cursor: 'not-allowed',
                                position: 'relative'
                            }).append(
                                `<div style="position:absolute;bottom:0;left:50%;transform:translateX(-50%);font-size:0.75em;font-weight:bold;color:#000;margin-bottom:-5px;">Tutup</div>`
                            );
                        }
                    }
                });

                calendar.render();
                $('#unit').on('input', changeUnit);
            });
        </script>
    @endpush

    <script>
        function toggleItems(type) {
            const extraItems = $('.extra-' + type);
            const button = $('button[onclick="toggleItems(\'' + type + '\')"]');

            if (extraItems.hasClass('d-none')) {
                extraItems.removeClass('d-none');
                button.text('Tampilkan Lebih Sedikit');
            } else {
                extraItems.addClass('d-none');
                button.text('Lihat Selengkapnya');
            }
        }

        // Optional: Reset items when switching tabs (only show first 6 again)
        $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function(e) {
            ['fasilitas', 'wisata', 'syarat'].forEach(function(type) {
                $('.extra-' + type).addClass('d-none');
                $('button[onclick="toggleItems(\'' + type + '\')"]').text('Lihat Selengkapnya');
            });
        });
    </script>


</x-app-landing-layout>
