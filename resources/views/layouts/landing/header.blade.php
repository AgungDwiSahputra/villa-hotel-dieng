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
                <div class="menu-outer">
                </div>
            </div>
        </nav>
    </div>
</header>