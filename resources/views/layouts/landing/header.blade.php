<!-- Modern Header Navigation -->
<header class="fixed top-0 left-0 right-0 z-50 bg-gradient-to-r from-primary-900/90 via-primary-800/90 to-primary-900/90 backdrop-blur-md shadow-sm transition-all duration-300" id="main-header">
    <div class="container mx-auto px-3 sm:px-4 lg:px-8 max-w-5xl">
        <div class="flex items-center justify-between h-14 sm:h-16 lg:h-20">
            <!-- Logo Section -->
            <div class="flex-shrink-0">
                <a href="{{ route('index') }}" class="flex items-center space-x-2 sm:space-x-3 group" aria-label="Beranda">
                    <div class="relative overflow-hidden rounded-lg">
                        <img src="{{ asset('storage/'.($settings['logo'] ?? 'images/logo-default.png'))}}"
                             alt="{{ $settings['name'] ?? 'Villa Hotel Dieng' }}"
                             class="h-8 w-auto sm:h-10 lg:h-12 object-contain transition-transform duration-300 group-hover:scale-105">
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center space-x-6 xl:space-x-8" role="navigation" aria-label="Main navigation">
                <a href="{{ route('index') }}"
                    class="relative px-2 xl:px-3 py-2 text-sm font-medium text-white transition-colors duration-200 hover:text-primary-200 group {{ Route::is('index') ? 'text-primary-200' : '' }}">
                    Beranda
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary-600 transform scale-x-0 transition-transform duration-200 group-hover:scale-x-100 {{ Route::is('index') ? 'scale-x-100' : '' }}"></span>
                </a>
                <a href="{{ route('tentang-kami') }}"
                    class="relative px-2 xl:px-3 py-2 text-sm font-medium text-white transition-colors duration-200 hover:text-primary-200 group {{ Route::is('tentang-kami') ? 'text-primary-200' : '' }}">
                    Tentang Kami
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary-600 transform scale-x-0 transition-transform duration-200 group-hover:scale-x-100 {{ Route::is('tentang-kami') ? 'scale-x-100' : '' }}"></span>
                </a>
                <a href="{{ route('sk') }}"
                    class="relative px-2 xl:px-3 py-2 text-sm font-medium text-white transition-colors duration-200 hover:text-primary-200 group {{ Route::is('sk') ? 'text-primary-200' : '' }}">
                    Syarat & Ketentuan
                    <span class="absolute bottom-0 left-0 w-full h-0.5 bg-primary-600 transform scale-x-0 transition-transform duration-200 group-hover:scale-x-100 {{ Route::is('sk') ? 'scale-x-100' : '' }}"></span>
                </a>
            </nav>

            <!-- Search Box & Actions -->
            <div class="flex items-center space-x-2 sm:space-x-4">
                <!-- Desktop Search -->
                <div class="hidden lg:block">
                    <form method="GET" action="{{ route('produk.all') }}" class="relative">
                        <div class="relative">
                            <input type="text"
                                   name="search"
                                   placeholder="Cari villa impian..."
                                   value="{{ request('search') ?? '' }}"
                                   class="w-48 xl:w-64 pl-3 xl:pl-4 pr-8 xl:pr-10 py-2 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-full focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500 transition-all duration-200">
                            <button type="submit"
                                    class="absolute inset-y-0 right-0 flex items-center justify-center w-8 xl:w-10 h-full text-gray-400 hover:text-primary-600 transition-colors duration-200">
                                <svg class="w-4 h-4 xl:w-5 xl:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Mobile Menu Button -->
                <button type="button"
                         class="lg:hidden p-2 text-white hover:text-primary-200 hover:bg-white/10 rounded-lg transition-colors duration-200"
                         id="mobile-menu-button"
                         aria-expanded="false"
                         aria-controls="mobile-menu">
                    <span class="sr-only">Buka menu</span>
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="lg:hidden hidden" id="mobile-menu">
        <div class="px-3 sm:px-4 pt-2 pb-3 space-y-1 bg-primary-900/95 backdrop-blur-md border-t border-white/10">
            <!-- Mobile Search -->
            <div class="pt-3 pb-2">
                <form method="GET" action="{{ route('produk.all') }}" class="relative">
                    <div class="relative">
                        <input type="text"
                               name="search"
                               placeholder="Cari villa impian..."
                               value="{{ request('search') ?? '' }}"
                               class="w-full pl-3 sm:pl-4 pr-8 sm:pr-10 py-2.5 sm:py-3 text-sm text-gray-900 bg-gray-50 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-primary-500">
                        <button type="submit"
                                class="absolute inset-y-0 right-0 flex items-center justify-center w-8 sm:w-10 h-full text-gray-400 hover:text-primary-600">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Mobile Navigation Links -->
            <a href="{{ route('index') }}"
                class="block px-3 py-2.5 text-sm sm:text-base font-medium text-white hover:text-primary-200 hover:bg-white/10 rounded-md transition-colors duration-200 {{ Route::is('index') ? 'text-primary-200 bg-white/10' : '' }}">
                Beranda
            </a>
            <a href="{{ route('tentang-kami') }}"
                class="block px-3 py-2.5 text-sm sm:text-base font-medium text-white hover:text-primary-200 hover:bg-white/10 rounded-md transition-colors duration-200 {{ Route::is('tentang-kami') ? 'text-primary-200 bg-white/10' : '' }}">
                Tentang Kami
            </a>
            <a href="{{ route('sk') }}"
                class="block px-3 py-2.5 text-sm sm:text-base font-medium text-white hover:text-primary-200 hover:bg-white/10 rounded-md transition-colors duration-200 {{ Route::is('sk') ? 'text-primary-200 bg-white/10' : '' }}">
                Syarat & Ketentuan
            </a>

            <!-- Mobile CTA Button -->
            <div class="pt-4 pb-2">
                <a href="{{ route('index') }}#booking"
                   class="w-full flex items-center justify-center px-4 sm:px-6 py-2.5 sm:py-3 text-sm sm:text-base font-medium text-white bg-gradient-to-r from-primary-600 to-primary-700 rounded-lg hover:from-primary-700 hover:to-primary-800 transition-all duration-200">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    Pesan Sekarang
                </a>
            </div>
        </div>
    </div>
</header>

<!-- Spacer untuk fixed header -->
<div class="h-14 sm:h-16 lg:h-20"></div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const header = document.getElementById('main-header');
    let lastScrollY = window.scrollY;

    // Mobile menu toggle
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            const isExpanded = mobileMenuButton.getAttribute('aria-expanded') === 'true';
            mobileMenuButton.setAttribute('aria-expanded', !isExpanded);

            if (isExpanded) {
                mobileMenu.classList.add('hidden');
                // Change icon to hamburger
                mobileMenuButton.innerHTML = `
                    <span class="sr-only">Buka menu</span>
                    <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                `;
            } else {
                mobileMenu.classList.remove('hidden');
                // Change icon to close
                mobileMenuButton.innerHTML = `
                    <span class="sr-only">Tutup menu</span>
                    <svg class="w-6 h-6 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                `;
            }
        });
    }

    // Header scroll behavior
    window.addEventListener('scroll', function() {
        const currentScrollY = window.scrollY;

        if (currentScrollY > 100) {
            header.classList.add('shadow-lg');
        } else {
            header.classList.remove('shadow-lg');
        }

        // Hide/show header on scroll
        if (currentScrollY > lastScrollY && currentScrollY > 300) {
            // Scrolling down
            header.classList.add('-translate-y-full');
        } else {
            // Scrolling up
            header.classList.remove('-translate-y-full');
        }

        lastScrollY = currentScrollY;
    });

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        if (mobileMenu && !mobileMenu.contains(e.target) && !mobileMenuButton.contains(e.target)) {
            mobileMenu.classList.add('hidden');
            mobileMenuButton.setAttribute('aria-expanded', 'false');
            // Reset icon to hamburger
            mobileMenuButton.innerHTML = `
                <span class="sr-only">Buka menu</span>
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            `;
        }
    });

    // Keyboard navigation
    document.addEventListener('keydown', function(e) {
        // Escape key to close mobile menu
        if (e.key === 'Escape' && !mobileMenu.classList.contains('hidden')) {
            mobileMenu.classList.add('hidden');
            mobileMenuButton.setAttribute('aria-expanded', 'false');
            mobileMenuButton.focus();
        }
    });
});
</script>
