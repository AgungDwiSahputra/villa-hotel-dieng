<x-app-layout title="Dashboard" subTitle="Dashboard">
    <div class="col-xl-5">
        <div class="card overflow-hidden">
            <div class="bg-primary bg-soft">
                <div class="row">
                    <div class="col-7">
                        <div class="text-primary p-3">
                            <h5 class="text-primary">Welcome Back !</h5>
                            <p>Dashboard {{ $settings['company'] ?? null }}</p>
                        </div>
                    </div>
                    <div class="col-5 align-self-end">
                        <img src="{{ asset('assets/images/profile-img.png')}}" alt="" class="img-fluid">
                    </div>
                </div>
            </div>
            <div class="card-body pt-0">
                <div class="row">
                    <div class="col-sm-4">
                        <div class="avatar-md profile-user-wid mb-4">
                            <img src="{{ Auth::user()->image ? asset('storage/'.Auth::user()->image) : 'https://ui-avatars.com/api/?background=0D8ABC&color=FFF&name=' . str_replace(' ', '+', Auth::user()->name) }}" alt="" class="img-thumbnail rounded-circle" style="height: 70px; width:70px">
                        </div>
                        <h5 class="font-size-15 text-truncate">{{ auth()->user()->name }}</h5>
                        <p class="text-muted mb-0 text-truncate">{{ auth()->user()->roles()?->first()?->name }}</p>
                    </div>

                    <div class="col-sm-8">
                        <div class="pt-4">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="font-size-15"></h5>
                                    <p class="text-muted mb-0">Skills</p>
                                </div>
                                <div class="col-6">
                                    <h5 class="font-size-15"></h5>
                                    <p class="text-muted mb-0">Portfolio</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <a href="{{ route('profile.edit') }}"
                                    class="btn btn-primary waves-effect waves-light btn-sm">View
                                    Profile <i class="mdi mdi-arrow-right ms-1"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
