<head>
    <!-- Meta Tags Dasar -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5.0, user-scalable=yes">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>{{ $settings['name'] ?? 'Villa Hotel Dieng' }} - Penginapan Villa & Hotel Mewah di Dieng</title>
    <meta name="description" content="{{ $settings['meta_description'] ?? 'Temukan villa dan hotel mewah di Dieng dengan pemandangan alam yang memukau. Nikmati pengalaman menginap premium dengan fasilitas lengkap dan harga terbaik. Pesan sekarang!' }}">
    <meta name="keywords" content="villa dieng, hotel dieng, penginapan dieng, wisata dieng, villa mewah dieng, hotel murah dieng, wonosobo, negeri di atas awan">
    <meta name="author" content="{{ $settings['name'] ?? 'Villa Hotel Dieng' }}">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <link rel="canonical" href="{{ url()->current() }}" />
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:locale" content="id_ID">
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $settings['name'] ?? 'Villa Hotel Dieng' }} - Penginapan Villa & Hotel Mewah di Dieng">
    <meta property="og:description" content="{{ $settings['meta_description'] ?? 'Temukan villa dan hotel mewah di Dieng dengan pemandangan alam yang memukau. Nikmati pengalaman menginap premium dengan fasilitas lengkap dan harga terbaik.' }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:site_name" content="{{ $settings['name'] ?? 'Villa Hotel Dieng' }}">
    <meta property="og:image" content="{{ asset('storage/' . ($settings['og_image'] ?? $settings['logo'] ?? 'images/og-default.jpg')) }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:type" content="image/jpeg">
    
    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $settings['name'] ?? 'Villa Hotel Dieng' }} - Penginapan Villa & Hotel Mewah di Dieng">
    <meta name="twitter:description" content="{{ $settings['meta_description'] ?? 'Temukan villa dan hotel mewah di Dieng dengan pemandangan alam yang memukau.' }}">
    <meta name="twitter:image" content="{{ asset('storage/' . ($settings['og_image'] ?? $settings['logo'] ?? 'images/og-default.jpg')) }}">
    <meta name="twitter:site" content="@{{ $settings['twitter_handle'] ?? 'villahoteldieng' }}">
    
    <!-- Additional Meta Tags -->
    <meta name="theme-color" content="#1e40af">
    <meta name="msapplication-TileColor" content="#1e40af">
    <meta name="msapplication-config" content="{{ asset('browserconfig.xml') }}">
    <meta name="google-site-verification" content="{{ $settings['google_verification'] ?? 'NvAwI-RHScYQA82tWGK1kWvtosyebFBpCArrNk7NmmM' }}" />
    
    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    
    <!-- Favicon dan Icons -->
    <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . ($settings['icon'] ?? 'favicon.ico')) }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('storage/' . ($settings['icon'] ?? 'favicon-32x32.png')) }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('storage/' . ($settings['icon'] ?? 'favicon-16x16.png')) }}">
    <link rel="shortcut icon" href="{{ asset('storage/' . ($settings['icon'] ?? null)) }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('storage/' . ($settings['icon'] ?? null)) }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('storage/' . ($settings['icon'] ?? 'apple-touch-icon.png')) }}">
    <link rel="mask-icon" href="{{ asset('storage/' . ($settings['icon'] ?? 'safari-pinned-tab.svg')) }}" color="#1e40af">
    
    <!-- Preconnect ke Domain Eksternal untuk Performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preconnect" href="https://cdnjs.cloudflare.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net">
    
    <!-- Font Modern: Inter & Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Vite Assets untuk Landing Page -->
    @vite(['resources/css/landing.css'])
    
    <!-- CSS Libraries -->
    <link rel="stylesheet" type="text/css" href="{{ asset('landing/app/css/magnific-popup.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('landing/app/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('landing/app/css/textanimation.css') }}">
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{ asset('assets/custom.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    
    <!-- Additional Custom CSS (jika diperlukan) -->
    <style>
        /* Additional custom styles yang tidak tercover oleh Tailwind */
        .modern-card {
            @apply bg-white rounded-2xl shadow-md;
        }
        
        .modern-btn {
            @apply px-6 py-3 rounded-lg font-medium transition-colors duration-200;
        }
        
        .modern-image {
            @apply transition-transform duration-300;
        }
        
        .modern-image:hover {
            @apply scale-105;
        }
        
        /* Mobile Optimization Styles */
        @media (max-width: 640px) {
            /* Hero Section Mobile Optimizations */
            .hero-section {
                min-height: 100vh;
                padding-top: 3.5rem; /* Account for mobile header */
            }
            
            .hero-content {
                text-align: center;
                padding: 0 1rem;
            }
            
            .hero-heading {
                font-size: 2.5rem;
                line-height: 1.1;
                margin-bottom: 1rem;
            }
            
            .hero-subheading {
                font-size: 3rem;
                line-height: 1.1;
            }
            
            .hero-description {
                font-size: 1rem;
                line-height: 1.6;
                margin-bottom: 1.5rem;
            }
            
            .hero-buttons {
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .hero-button {
                width: 100%;
                justify-content: center;
                padding: 0.875rem 1.5rem;
                font-size: 0.875rem;
            }
            
            .trust-indicators {
                grid-template-columns: repeat(3, 1fr);
                gap: 0.75rem;
                padding: 0.75rem;
            }
            
            .trust-card {
                padding: 0.75rem;
                border-radius: 0.5rem;
            }
            
            .trust-number {
                font-size: 1.5rem;
            }
            
            .trust-label {
                font-size: 0.75rem;
            }
            
            /* Villa Cards Mobile Optimizations */
            .villa-card {
                border-radius: 0.75rem;
                margin-bottom: 1rem;
            }
            
            .villa-image {
                height: 12rem;
                border-radius: 0.75rem 0.75rem 0 0;
            }
            
            .villa-content {
                padding: 1rem;
            }
            
            .villa-title {
                font-size: 1rem;
                margin-bottom: 0.5rem;
            }
            
            .villa-location {
                font-size: 0.75rem;
                margin-bottom: 0.5rem;
            }
            
            .villa-rating {
                margin-bottom: 0.5rem;
            }
            
            .villa-facilities {
                font-size: 0.75rem;
                margin-bottom: 0.75rem;
            }
            
            .villa-price {
                font-size: 1rem;
            }
            
            .villa-button {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
            
            /* Filter Section Mobile Optimizations */
            .filter-section {
                padding: 1rem;
                border-radius: 0.75rem;
                margin-bottom: 1.5rem;
            }
            
            .filter-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
            
            .filter-select {
                padding: 0.75rem;
                font-size: 0.875rem;
            }
            
            .filter-buttons {
                flex-direction: column;
                gap: 0.5rem;
            }
            
            .filter-button {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
            
            /* Category Tabs Mobile Optimizations */
            .category-tabs {
                gap: 0.5rem;
                padding: 0 0.5rem;
            }
            
            .category-tab {
                padding: 0.5rem 1rem;
                font-size: 0.875rem;
                border-radius: 9999px;
            }
            
            /* Pagination Mobile Optimizations */
            .pagination {
                gap: 0.25rem;
            }
            
            .pagination-button {
                width: 2.5rem;
                height: 2.5rem;
                font-size: 0.875rem;
            }
            
            /* Header Mobile Optimizations */
            .mobile-header {
                padding: 0 1rem;
                height: 3.5rem;
            }
            
            .mobile-logo {
                height: 2rem;
            }
            
            .mobile-menu {
                padding: 1rem;
            }
            
            .mobile-search {
                margin-bottom: 1rem;
            }
            
            .mobile-search-input {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
            
            .mobile-nav-link {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
                border-radius: 0.5rem;
            }
            
            .mobile-cta {
                padding: 0.75rem 1rem;
                font-size: 0.875rem;
            }
            
            /* Footer Mobile Optimizations */
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }
            
            .footer-section {
                text-align: center;
            }
            
            .footer-logo {
                height: 2rem;
                margin: 0 auto 1rem;
            }
            
            .footer-description {
                font-size: 0.875rem;
                text-align: center;
                margin-bottom: 1rem;
            }
            
            .footer-social {
                justify-content: center;
                gap: 0.75rem;
            }
            
            .social-link {
                width: 2.5rem;
                height: 2.5rem;
            }
            
            .footer-heading {
                font-size: 1rem;
                text-align: center;
                margin-bottom: 0.75rem;
            }
            
            .footer-links {
                text-align: center;
            }
            
            .footer-link-item {
                font-size: 0.875rem;
                padding: 0.5rem 0;
            }
            
            .footer-contact {
                text-align: center;
            }
            
            .contact-item {
                font-size: 0.875rem;
                justify-content: center;
            }
            
            .payment-methods {
                justify-content: center;
                gap: 0.5rem;
            }
            
            .payment-method {
                width: 2.5rem;
                height: 1.5rem;
                font-size: 0.625rem;
            }
            
            .footer-bottom {
                text-align: center;
                padding: 1rem 0;
            }
            
            .footer-copyright {
                font-size: 0.75rem;
            }
            
            .footer-powered {
                font-size: 0.75rem;
            }
            
            /* Scroll to Top Button Mobile */
            .scroll-top {
                width: 3rem;
                height: 3rem;
                bottom: 1rem;
                right: 1rem;
            }
            
            .scroll-top svg {
                width: 1rem;
                height: 1rem;
            }
        }
        
        /* Tablet Optimizations */
        @media (min-width: 641px) and (max-width: 1024px) {
            .hero-section {
                min-height: 80vh;
                padding-top: 4rem;
            }
            
            .hero-heading {
                font-size: 3.5rem;
            }
            
            .hero-subheading {
                font-size: 4rem;
            }
            
            .hero-description {
                font-size: 1.125rem;
            }
            
            .trust-indicators {
                gap: 1rem;
                padding: 1rem;
            }
            
            .villa-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1rem;
            }
            
            .filter-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            
            .footer-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 2rem;
            }
        }
        
        /* Touch-friendly improvements */
        @media (pointer: coarse) {
            .hero-button,
            .villa-button,
            .filter-button,
            .category-tab,
            .pagination-button,
            .mobile-nav-link,
            .mobile-cta,
            .footer-link-item,
            .social-link {
                min-height: 44px;
                min-width: 44px;
            }
            
            .filter-select,
            .mobile-search-input {
                min-height: 44px;
            }
        }
        
        /* Reduce motion for accessibility */
        @media (prefers-reduced-motion: reduce) {
            .hero-section *,
            .villa-card *,
            .filter-section *,
            .header *,
            .footer * {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
        
        /* Enhanced Flickity Carousel Styles */
        .popular-villas-carousel {
            margin-bottom: 2rem;
        }
        
        .popular-villas-carousel .flickity-viewport {
            overflow: hidden;
            position: relative;
            height: 600px !important;
        }
        
        .popular-villas-carousel .flickity-slider {
            display: flex;
            align-items: stretch;
            height: 100%;
        }
        
        .popular-villas-carousel .carousel-cell {
            width: 100%;
            height: 100%;
            padding-right: 0.5rem;
            box-sizing: border-box;
        }
        
        /* Desktop: 4 cards */
        @media (min-width: 1024px) {
            .popular-villas-carousel .carousel-cell {
                width: 25%;
            }
            
            .popular-villas-carousel .flickity-viewport {
                height: 580px !important;
            }
        }
        
        /* Tablet: 3 cards */
        @media (min-width: 768px) and (max-width: 1023px) {
            .popular-villas-carousel .carousel-cell {
                width: 33.333%;
            }
            
            .popular-villas-carousel .flickity-viewport {
                height: 550px !important;
            }
        }
        
        /* Mobile: 2 cards */
        @media (max-width: 767px) {
            .popular-villas-carousel .carousel-cell {
                width: 50%;
            }
            
            .popular-villas-carousel .flickity-viewport {
                height: 520px !important;
            }
        }
        
        /* Small Mobile: 1 card */
        @media (max-width: 480px) {
            .popular-villas-carousel .carousel-cell {
                width: 100%;
            }
            
            .popular-villas-carousel .flickity-viewport {
                height: 500px !important;
            }
        }
        
        /* Enhanced Navigation Dots */
        .popular-villas-carousel .flickity-page-dots {
            bottom: -40px;
            text-align: center;
            line-height: 1;
        }
        
        .popular-villas-carousel .dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin: 0 6px;
            background: #d1d5db;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0.7;
        }
        
        .popular-villas-carousel .dot.is-selected {
            background: #1e40af;
            opacity: 1;
            transform: scale(1.2);
        }
        
        /* Enhanced Navigation Arrows */
        .popular-villas-carousel .flickity-prev-next-button {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid #e5e7eb;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }
        
        .popular-villas-carousel .flickity-prev-next-button:hover {
            background: #1e40af;
            border-color: #1e40af;
            transform: translateY(-50%) scale(1.1);
        }
        
        .popular-villas-carousel .flickity-prev-next-button:hover .arrow {
            fill: white;
        }
        
        .popular-villas-carousel .flickity-prev-next-button.previous {
            left: -20px;
        }
        
        .popular-villas-carousel .flickity-prev-next-button.next {
            right: -20px;
        }
        
        .popular-villas-carousel .flickity-prev-next-button .arrow {
            fill: #374151;
            transition: fill 0.3s ease;
        }
        
        .popular-villas-carousel .flickity-prev-next-button:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }
        
        .popular-villas-carousel .flickity-prev-next-button:disabled:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: #e5e7eb;
            transform: translateY(-50%);
        }
        
        .popular-villas-carousel .flickity-prev-next-button:disabled:hover .arrow {
            fill: #374151;
        }
        
        /* Hide arrows on mobile for better UX */
        @media (max-width: 767px) {
            .popular-villas-carousel .flickity-prev-next-button {
                display: none;
            }
        }
        
        /* Smooth transitions for carousel items */
        .popular-villas-carousel .carousel-cell .villa-card {
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .popular-villas-carousel .carousel-cell .villa-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }
        
        /* Ensure proper spacing and alignment */
        .popular-villas-carousel .flickity-slider > * {
            flex-shrink: 0;
        }
        
        /* Loading state for carousel */
        .popular-villas-carousel.loading {
            opacity: 0.6;
            pointer-events: none;
        }
        
        .popular-villas-carousel.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 32px;
            height: 32px;
            margin: -16px 0 0 -16px;
            border: 3px solid #f3f4f6;
            border-top: 3px solid #1e40af;
            border-radius: 50%;
            animation: flickity-spin 1s linear infinite;
        }
        
        @keyframes flickity-spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Enhanced Testimonials Carousel with Flickity */
        .testimonials-carousel .testimonial-slider {
            margin-bottom: 2rem;
        }
        
        .testimonials-carousel .flickity-viewport {
            overflow: hidden;
            position: relative;
            min-height: 300px;
        }
        
        .testimonials-carousel .flickity-slider {
            display: flex;
            align-items: stretch;
        }
        
        .testimonials-carousel .testimonial-slide {
            width: 100%;
            padding-right: 1rem;
            box-sizing: border-box;
        }
        
        /* Enhanced Testimonials Navigation Dots */
        .testimonials-carousel .flickity-page-dots {
            bottom: -30px;
            text-align: center;
            line-height: 1;
        }
        
        .testimonials-carousel .dot {
            display: inline-block;
            width: 10px;
            height: 10px;
            margin: 0 4px;
            background: rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        
        .testimonials-carousel .dot.is-selected {
            background: #fbbf24;
            opacity: 1;
            transform: scale(1.3);
            width: 24px;
            border-radius: 6px;
        }
        
        /* Enhanced Testimonials Navigation Arrows */
        .testimonials-carousel .flickity-prev-next-button {
            width: 44px;
            height: 44px;
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
        }
        
        .testimonials-carousel .flickity-prev-next-button:hover {
            background: rgba(251, 191, 36, 0.8);
            border-color: #fbbf24;
            transform: translateY(-50%) scale(1.1);
        }
        
        .testimonials-carousel .flickity-prev-next-button:hover .arrow {
            fill: white;
        }
        
        .testimonials-carousel .flickity-prev-next-button.previous {
            left: -20px;
        }
        
        .testimonials-carousel .flickity-prev-next-button.next {
            right: -20px;
        }
        
        .testimonials-carousel .flickity-prev-next-button .arrow {
            fill: rgba(255, 255, 255, 0.7);
            transition: fill 0.3s ease;
        }
        
        .testimonials-carousel .flickity-prev-next-button:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }
        
        .testimonials-carousel .flickity-prev-next-button:disabled:hover {
            background: rgba(255, 255, 255, 0.1);
            border-color: rgba(255, 255, 255, 0.2);
            transform: translateY(-50%);
        }
        
        .testimonials-carousel .flickity-prev-next-button:disabled:hover .arrow {
            fill: rgba(255, 255, 255, 0.7);
        }
        
        /* Hide custom navigation buttons when Flickity is active */
        .testimonials-carousel.flickity-enabled #testimonial-prev,
        .testimonials-carousel.flickity-enabled #testimonial-next {
            display: none;
        }
        
        /* Hide custom indicators when Flickity is active */
        .testimonials-carousel.flickity-enabled #testimonialIndicators {
            display: none;
        }
        
        /* Smooth transitions for testimonial items */
        .testimonials-carousel .testimonial-slide .testimonial-card {
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .testimonials-carousel .testimonial-slide .testimonial-card:hover {
            transform: translateY(-2px);
        }
        
        /* Ensure proper spacing and alignment */
        .testimonials-carousel .flickity-slider > * {
            flex-shrink: 0;
        }
        
        /* Enhanced Villa Card Animations */
        .villa-card {
            transform-origin: center;
            will-change: transform, box-shadow;
        }
        
        .villa-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        }
        
        .villa-card .lazy-load {
            transition: opacity 0.3s ease, transform 0.5s ease;
        }
        
        .villa-card .lazy-load.loaded {
            opacity: 1;
        }
        
        .villa-card .group:hover .lazy-load {
            transform: scale(1.1);
        }
        
        /* Enhanced Badge Animations */
        .villa-card .absolute.top-3 span {
            animation: slideInLeft 0.5s ease-out;
            transform-origin: left center;
        }
        
        .villa-card:hover .absolute.top-3 span {
            transform: scale(1.05);
        }
        
        /* Heart Button Animation */
        .villa-card button[onclick*="toggleFavorite"] {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        
        .villa-card button[onclick*="toggleFavorite"]:hover {
            transform: scale(1.1) rotate(5deg);
        }
        
        .villa-card button[onclick*="toggleFavorite"].active {
            animation: heartBeat 0.6s ease-in-out;
        }
        
        /* Price Animation */
        .villa-card .text-xl {
            transition: all 0.3s ease;
        }
        
        .villa-card:hover .text-xl {
            transform: translateY(-2px);
            color: #1e40af;
        }
        
        /* CTA Button Enhancement */
        .villa-card a[href*="produk"] {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }
        
        .villa-card a[href*="produk"]::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }
        
        .villa-card a[href*="produk"]:hover::before {
            left: 100%;
        }
        
        /* Loading Skeleton for Villa Cards */
        .villa-card-skeleton {
            background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
        }
        
        @keyframes loading {
            0% { background-position: 200% 0; }
            100% { background-position: -200% 0; }
        }
        
        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-20px);
            }
            to {
                opacity: 1;
                transform: translateX(0);
            }
        }
        
        @keyframes heartBeat {
            0%, 100% { transform: scale(1); }
            25% { transform: scale(1.3); }
            50% { transform: scale(1); }
            75% { transform: scale(1.3); }
        }

        /* Enhanced Best Villas Carousel Styles - Copy dari Popular Villas */
        .best-villas-carousel {
            margin-bottom: 2rem;
        }

        .best-villas-carousel .flickity-viewport {
            overflow: hidden;
            position: relative;
            height: 600px !important;
        }

        .best-villas-carousel .flickity-slider {
            display: flex;
            align-items: stretch;
            height: 100%;
        }

        .best-villas-carousel .carousel-cell {
            width: 100%;
            height: 100%;
            padding-right: 0.5rem;
            box-sizing: border-box;
        }

        /* Desktop: 4 cards */
        @media (min-width: 1024px) {
            .best-villas-carousel .carousel-cell {
                width: 25%;
            }

            .best-villas-carousel .flickity-viewport {
                height: 580px !important;
            }
        }

        /* Tablet: 3 cards */
        @media (min-width: 768px) and (max-width: 1023px) {
            .best-villas-carousel .carousel-cell {
                width: 33.333%;
            }

            .best-villas-carousel .flickity-viewport {
                height: 550px !important;
            }
        }

        /* Mobile: 2 cards */
        @media (max-width: 767px) {
            .best-villas-carousel .carousel-cell {
                width: 50%;
            }

            .best-villas-carousel .flickity-viewport {
                height: 520px !important;
            }
        }

        /* Small Mobile: 1 card */
        @media (max-width: 480px) {
            .best-villas-carousel .carousel-cell {
                width: 100%;
            }

            .best-villas-carousel .flickity-viewport {
                height: 500px !important;
            }
        }

        /* Enhanced Navigation Dots */
        .best-villas-carousel .flickity-page-dots {
            bottom: -40px;
            text-align: center;
            line-height: 1;
        }

        .best-villas-carousel .dot {
            display: inline-block;
            width: 12px;
            height: 12px;
            margin: 0 6px;
            background: #d1d5db;
            border-radius: 50%;
            cursor: pointer;
            transition: all 0.3s ease;
            opacity: 0.7;
        }

        .best-villas-carousel .dot.is-selected {
            background: #1e40af;
            opacity: 1;
            transform: scale(1.2);
        }

        /* Enhanced Navigation Arrows */
        .best-villas-carousel .flickity-prev-next-button {
            width: 48px;
            height: 48px;
            background: rgba(255, 255, 255, 0.95);
            border: 2px solid #e5e7eb;
            border-radius: 50%;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .best-villas-carousel .flickity-prev-next-button:hover {
            background: #1e40af;
            border-color: #1e40af;
            transform: translateY(-50%) scale(1.1);
        }

        .best-villas-carousel .flickity-prev-next-button:hover .arrow {
            fill: white;
        }

        .best-villas-carousel .flickity-prev-next-button.previous {
            left: -20px;
        }

        .best-villas-carousel .flickity-prev-next-button.next {
            right: -20px;
        }

        .best-villas-carousel .flickity-prev-next-button .arrow {
            fill: #374151;
            transition: fill 0.3s ease;
        }

        .best-villas-carousel .flickity-prev-next-button:disabled {
            opacity: 0.3;
            cursor: not-allowed;
        }

        .best-villas-carousel .flickity-prev-next-button:disabled:hover {
            background: rgba(255, 255, 255, 0.95);
            border-color: #e5e7eb;
            transform: translateY(-50%);
        }

        .best-villas-carousel .flickity-prev-next-button:disabled:hover .arrow {
            fill: #374151;
        }

        /* Hide arrows on mobile for better UX */
        @media (max-width: 767px) {
            .best-villas-carousel .flickity-prev-next-button {
                display: none;
            }
        }

        /* Smooth transitions for carousel items */
        .best-villas-carousel .carousel-cell .villa-card {
            height: 100%;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .best-villas-carousel .carousel-cell .villa-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* Ensure proper spacing and alignment */
        .best-villas-carousel .flickity-slider > * {
            flex-shrink: 0;
        }

        /* Loading state for carousel */
        .best-villas-carousel.loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .best-villas-carousel.loading::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 32px;
            height: 32px;
            margin: -16px 0 0 -16px;
            border: 3px solid #f3f4f6;
            border-top: 3px solid #1e40af;
            border-radius: 50%;
            animation: flickity-spin 1s linear infinite;
        }
        
        /* Responsive Enhancements */
        @media (max-width: 640px) {
            .villa-card:hover {
                transform: translateY(-4px) scale(1.01);
            }
        }
        
        /* Focus States for Accessibility */
        .villa-card:focus-within {
            outline: 2px solid #1e40af;
            outline-offset: 2px;
        }
        
        /* Enhanced Image Hover Effect */
        .villa-card .relative.overflow-hidden img {
            filter: brightness(1);
            transition: filter 0.3s ease, transform 0.5s ease;
        }
        
        .villa-card:hover .relative.overflow-hidden img {
            filter: brightness(1.1);
        }
    </style>
    
    <!-- Additional CSS Stack -->
    @stack('css')
</head>
