<!DOCTYPE html>
<html lang="id-ID" dir="ltr" class="scroll-smooth">
@include('layouts.landing.head')

<body class="antialiased bg-gray-50 text-gray-900 transition-colors duration-300">
    <!-- Skip to Content Link for Accessibility -->
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 bg-blue-600 text-white px-4 py-2 rounded-md z-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
        Langsung ke konten utama
    </a>

    <!-- Preloader -->
    @include('layouts.landing.preloader')

    <!-- Main Layout Wrapper -->
    <div id="app" class="min-h-screen flex flex-col">
        <!-- Header Navigation -->
        @include('layouts.landing.header')

        <!-- Main Content Area -->
        <main id="main-content" class="flex-grow" role="main">
            {{ $slot }}
        </main>

        <!-- Footer -->
        @include('layouts.landing.footer')
    </div>

    <!-- Scroll to Top Button -->
    <button
        id="scroll-top"
        class="fixed bottom-4 sm:bottom-6 lg:bottom-8 right-4 sm:right-6 lg:right-8 bg-blue-600 hover:bg-blue-700 text-white p-3 sm:p-4 rounded-full shadow-lg transform translate-y-20 opacity-0 transition-all duration-300 ease-in-out z-40 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        aria-label="Kembali ke atas"
        title="Kembali ke atas halaman">
        <svg class="w-4 h-4 sm:w-5 sm:h-5 lg:w-6 lg:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
        </svg>
    </button>

    <!-- Scripts -->
    @include('layouts.landing.script')

    <!-- Custom Initialization Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Scroll to top functionality
            const scrollTopBtn = document.getElementById('scroll-top');
            
            window.addEventListener('scroll', function() {
                if (window.pageYOffset > 300) {
                    scrollTopBtn.classList.remove('translate-y-20', 'opacity-0');
                    scrollTopBtn.classList.add('translate-y-0', 'opacity-100');
                } else {
                    scrollTopBtn.classList.add('translate-y-20', 'opacity-0');
                    scrollTopBtn.classList.remove('translate-y-0', 'opacity-100');
                }
            });

            scrollTopBtn.addEventListener('click', function() {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            });

            // Enhanced keyboard navigation
            document.addEventListener('keydown', function(e) {
                // Alt + Shift + T to go to top
                if (e.altKey && e.shiftKey && e.key === 'T') {
                    e.preventDefault();
                    window.scrollTo({
                        top: 0,
                        behavior: 'smooth'
                    });
                }
                
                // Alt + Shift + M to go to main content
                if (e.altKey && e.shiftKey && e.key === 'M') {
                    e.preventDefault();
                    document.getElementById('main-content').scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });

            // Performance optimization: Lazy load images
            if ('IntersectionObserver' in window) {
                const imageObserver = new IntersectionObserver((entries, observer) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            const img = entry.target;
                            if (img.dataset.src) {
                                img.src = img.dataset.src;
                                img.classList.remove('lazy-load');
                                img.classList.add('loaded');
                                observer.unobserve(img);
                            }
                        }
                    });
                });

                document.querySelectorAll('img[data-src]').forEach(img => {
                    imageObserver.observe(img);
                });
            }
        });
    </script>
</body>
</html>