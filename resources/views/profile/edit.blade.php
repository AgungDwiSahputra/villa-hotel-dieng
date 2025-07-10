<x-app-layout title="Profile" subTitle="Profile">
    <x-card-component col="12" title="Profile">
        <div class="row">
            <div class="col-lg-4 col-md-12 col-sm-12">
                <img src="{{ Auth::user()->image ? asset('storage/'.Auth::user()->image) : 'https://ui-avatars.com/api/?background=0D8ABC&color=FFF&name=' . str_replace(' ', '+', Auth::user()->name) }}" style="width: 100%" class="img-fluid" alt="Responsive image">                
            </div>
            <div class="col-lg-8 col-md-12 col-sm-12">
                <ul class="nav nav-tabs nav-tabs-custom nav-justified" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" data-bs-toggle="tab" href="#profile" role="tab" aria-selected="true">
                            <span class="d-block d-sm-none"><i class="fas fa-user"></i></span>
                            <span class="d-none d-sm-block">Profile</span> 
                        </a>
                    </li>

                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#password" role="tab" aria-selected="false" tabindex="-1">
                            <span class="d-block d-sm-none"><i class="fas fa-key"></i></span>
                            <span class="d-none d-sm-block">Edit Password</span>   
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" data-bs-toggle="tab" href="#delete" role="tab" aria-selected="false" tabindex="-1">
                            <span class="d-block d-sm-none"><i class="fas fa-key"></i></span>
                            <span class="d-none d-sm-block">Delete Account</span>   
                        </a>
                    </li>
                </ul>
    
                <!-- Tab panes -->
                <div class="tab-content p-3 text-muted">
                    <div class="tab-pane active show" id="profile" role="tabpanel">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                    <div class="tab-pane" id="password" role="tabpanel">
                        @include('profile.partials.update-password-form')
                    </div>
                    <div class="tab-pane" id="delete" role="tabpanel">
                        <div class="max-w-xl">
                            @include('profile.partials.delete-user-form')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </x-card-component>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div> --}}
</x-app-layout>
