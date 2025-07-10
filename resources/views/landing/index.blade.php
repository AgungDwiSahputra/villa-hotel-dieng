<x-app-landing-layout>
    <section class="tour-package pd-main pt-4">
        <div class="tf-container w-1456">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tab-tour-list">
                        <ul class="nav justify-content-center tab-list mb-37" id="myTab" role="tablist">
                            @foreach ($categories as $category)
                                <li class="nav-item">
                                    <a class="nav-link text-center {{ $activeCategory === $category->slug ? 'active' : '' }}" href="{{ route('index', ['category' => $category->slug]) }}"  style="border-radius: 0.5rem;">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active">
                                <div class="row">
                                    @forelse ($produks as $produk)
                                        <div class="col-sm-6 col-lg-3">
                                            <div class="tour-listing wow fadeInUp animated" data-wow-delay="0.1s">
                                                <a href="{{ route('produk',$produk->slug) }}" class="tour-listing-image">
                                                    <div class="badge-top flex-two">
                                                        <span class="feature">{{ $produk->category->name }}</span>
                                                        <div class="badge-media flex-five">
                                                            <span class="media">
                                                                <i class="icon-Group-1000002909"></i>
                                                                {{ $produk->images->count() }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <img src="{{ asset('storage/'.$produk->images?->first()?->image ?? '') }}" alt="Image Listing">
                                                </a>
                                                <div class="tour-listing-content">
                                                    <span class="map"><i class="icon-Vector4"></i>{{ $produk->lokasi }}</span>
                                                    <h3 class="title-tour-list">
                                                        <a href="{{ route('produk',$produk->slug) }}">{{ $produk->name }}</a>
                                                    </h3>
                                                    <div class="review">
                                                        <i class="icon-Star"></i><i class="icon-Star"></i>
                                                        <i class="icon-Star"></i><i class="icon-Star"></i>
                                                        <i class="icon-Star"></i>
                                                    </div>
                                                    <div class="icon-box flex-three" style="justify-content: flex-end;">
                                                        <div class="icons flex-three" style="display: flex; align-items: center; gap: 15px;">
                                                            <!-- Icon Orang -->
                                                            <div style="display: flex; align-items: center; gap: 5px;">
                                                                <svg width="21" height="16" viewBox="0 0 21 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M4.34766 4.79761C4.34766 2.94013 5.85346 1.43433 7.71094 1.43433C9.56841 1.43433 11.0742 2.94013 11.0742 4.79761C11.0742 6.65508 9.56841 8.16089 7.71094 8.16089C5.85346 8.16089 4.34766 6.65508 4.34766 4.79761Z" stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M9.5977 15.1797H2.46098C1.34827 15.1797 0.558268 14.0954 0.898984 13.0362C1.80408 10.222 4.57804 8.18566 7.69301 8.18566C9.17897 8.18566 10.5566 8.64906 11.6895 9.43922" stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M17.1035 15.1797V9.02734" stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                                    <path d="M20.1797 12.1035H14.0273" stroke="currentColor" stroke-width="1.7" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round" />
                                                                </svg>
                                                                <span>{{ $produk->orang }} - {{ $produk->maks_orang }} Orang</span>
                                                            </div>

                                                            <!-- Icon Kamar -->
                                                            <div style="display: flex; align-items: center; gap: 5px;">
                                                                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                    <path d="M4 3H20V21H4V3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                                    <circle cx="16" cy="12" r="1" fill="currentColor"/>
                                                                </svg>
                                                                <span>{{ $produk->kamar }} Kamar</span>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="flex-two">
                                                        <div class="price-box flex-three">
                                                            <p class="d-flex justify-content-between w-100 mb-1">
                                                                <span>Weekday</span>
                                                                <span class="price-sale">Rp. {{ number_format($produk->harga_weekday, 0, ',', '.') }}</span>
                                                            </p>
                                                            <p class="d-flex justify-content-between w-100 mb-0">
                                                                <span>Weekend</span>
                                                                <span class="price-sale">Rp. {{ number_format($produk->harga_weekend, 0, ',', '.') }}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <p class="text-center">Produk tidak ditemukan.</p>
                                    @endforelse
                                </div>

                                @if ($produks->lastPage() > 1)
                                    <ul class="tf-pagination flex-five mt-20">
                                        <li>
                                            <a class="pages-link {{ $produks->onFirstPage() ? 'disabled' : '' }}"
                                            href="{{ $produks->previousPageUrl() ?? '#' }}">
                                                <i class="icon-29"></i>
                                            </a>
                                        </li>

                                        @for ($i = 1; $i <= $produks->lastPage(); $i++)
                                            <li class="pages-item {{ $produks->currentPage() == $i ? 'active' : '' }}">
                                                <a class="pages-link" href="{{ $produks->url($i) }}">{{ $i }}</a>
                                            </li>
                                        @endfor

                                        <li>
                                            <a class="pages-link {{ !$produks->hasMorePages() ? 'disabled' : '' }}"
                                            href="{{ $produks->nextPageUrl() ?? '#' }}">
                                                <i class="icon--1"></i>
                                            </a>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="installBtn" style="display: none;">
        <button class="btn btn-primary position-fixed m-3 rounded-circle shadow d-flex align-items-center justify-content-center" style="width: 50px; height: 50px; bottom: 30px;">
            <i class="fa fa-download  text-white" title="Install App"></i>
        </button>
    </div>

@push('js')
    <script>
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (event) => {
            event.preventDefault();
            deferredPrompt = event;
            const installBtn = document.getElementById('installBtn');
            
            if (installBtn) {
                installBtn.style.display = 'block';
                installBtn.addEventListener('click', () => {
                    if (deferredPrompt) {
                        deferredPrompt.prompt();
                        deferredPrompt.userChoice.then(choiceResult => {
                            console.log(choiceResult.outcome === 'accepted' ? 
                                'User accepted the install prompt' : 
                                'User dismissed the install prompt');
                            deferredPrompt = null;
                            installBtn.style.display = 'none';
                        });
                    }
                });
            }
        });
    </script>
@endpush
</x-app-landing-layout>