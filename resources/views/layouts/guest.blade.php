<!doctype html>
<html lang="en">
    @include('layouts.admin.head')
    <body>
        <div class="account-pages my-5 pt-sm-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card overflow-hidden">
                            <div class="bg-primary bg-soft">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="text-primary p-4">
                                            <h5 class="text-primary">Welcome Back !</h5>
                                            <p>Sign in to continue to {{ $settings['name'] ?? null }}.</p>
                                        </div>
                                    </div>
                                    <div class="col-5 align-self-end">
                                        <img src="{{ asset('assets/images/profile-img.png')}}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body pt-0"> 
                                <div class="auth-logo">
                                    <a href="{{ route('index') }}" class="auth-logo-dark">
                                        <div class="avatar-md profile-user-wid mb-4">
                                            <span class="avatar-title rounded-circle bg-light">
                                                <img src="{{ asset('storage/'.($settings['icon'] ?? null))}}" alt="" class="rounded-circle" height="50">
                                            </span>
                                        </div>
                                    </a>
                                </div>
                                <div>
                                   {{ $slot }}
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                             <div>
                                @if(request()->routeIs('register') || request()->routeIs('password.request'))
                                    <p>Already have an account? <a href="{{ route('login') }}" class="fw-medium text-primary"> Login now </a> </p>
                                @endif
                                {{ $forgot ?? null }}
                                <p>{{ date('Y') }} © {{ $settings['company'] ?? null }} <span> - {{ $settings['strapline'] ?? null }}</span></p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
       @include('layouts.admin.script')
    </body>
</html>
