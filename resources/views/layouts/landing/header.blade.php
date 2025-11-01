<header class="main-header flex">
    <div id="header">
        <div class="header-lower">
            <div class="tf-container full">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="inner-container flex justify-space align-center">
                            <!-- Logo Box -->
                            <div class="mobile-nav-toggler mobie-mt mobile-button">
                                <i class="icon-Vector3"></i>
                            </div>
                            <div class="logo-box">
                                <div class="logo">
                                    <a href="{{ route('index') }}">
                                        <img src="{{ asset('storage/'.($settings['logo'] ?? null))}}" alt="{{ $settings['name'] ?? null }}">
                                    </a>
                                </div>
                            </div>
                            <div class="nav-outer flex align-center">
                                <nav class="main-menu show navbar-expand-md">
                                    <div class="navbar-collapse collapse clearfix"
                                        id="navbarSupportedContent">
                                        <ul class="navigation clearfix">
                                            <li class="{{ Route::is('index') ? 'current' : '' }}"><a href="{{ route('index') }}">Beranda</a></li>
                                            <li class="{{ Route::is('tentang-kami') ? 'current' : '' }}"><a href="{{ route('tentang-kami') }}">Tentang Kami</a></li>
                                            <li class="{{ Route::is('sk') ? 'current' : '' }}"><a href="{{ route('sk') }}">Syarat & Ketentuan</a></li>
                                        </ul>
                                    </div>
                                </nav>
                                <!-- Search Box -->
                                <div class="header-search-box">
                                    <form method="GET" action="{{ route('index') }}" class="search-form">
                                        <div class="search-input-group">
                                            <input type="text" name="search" placeholder="Cari Penginapan..." value="{{ request('search') ?? '' }}" class="search-input">
                                            <button type="submit" class="search-btn">
                                                <i class="fa fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                                <!-- Mobile Search Toggle -->
                                <button class="mobile-search-toggle" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile Menu  -->
    <div class="close-btn"><span class="icon flaticon-cancel-1"></span></div>
    <div class="mobile-menu">
        <div class="menu-backdrop"></div>
        <nav class="menu-box">
            <div class="nav-logo"><a href="{{ route('index') }}">
                    <img src="{{ asset('storage/'.($settings['logo'] ?? null))}}" alt="{{ $settings['name'] ?? null }}"></a></div>
            <div class="bottom-canvas">
                <!-- Mobile Search -->
                <div class="mobile-search-box">
                    <form method="GET" action="{{ route('index') }}" class="mobile-search-form">
                        <div class="mobile-search-input-group">
                            <input type="text" name="search" placeholder="Cari villa atau penginapan..." value="{{ request('search') ?? '' }}" class="mobile-search-input">
                            <button type="submit" class="mobile-search-btn">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
                <div class="menu-outer">
                </div>
            </div>
        </nav>
    </div>
</header>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const mobileSearchToggle = document.querySelector('.mobile-search-toggle');
    const mobileMenu = document.querySelector('.mobile-menu');
    const closeBtn = document.querySelector('.close-btn');
    
    if (mobileSearchToggle && mobileMenu) {
        mobileSearchToggle.addEventListener('click', function(e) {
            e.preventDefault();
            mobileMenu.classList.add('active');
        });
    }
    
    if (closeBtn && mobileMenu) {
        closeBtn.addEventListener('click', function() {
            mobileMenu.classList.remove('active');
        });
    }
    
    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        if (mobileMenu && !mobileMenu.contains(e.target) && !e.target.closest('.mobile-search-toggle')) {
            mobileMenu.classList.remove('active');
        }
    });
});
</script>