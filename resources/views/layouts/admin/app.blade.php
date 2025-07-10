<!doctype html>
<html lang="en">
    @include('layouts.admin.head')
    <body data-sidebar="colored" data-layout-mode="color">
        <div id="layout-wrapper">
            @include('layouts.admin.header')
            @include('layouts.admin.menu')
            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                                    <h4 class="mb-sm-0 font-size-18">{{ $title }}</h4>
                        
                                    <div class="page-title-right">
                                        <ol class="breadcrumb m-0">
                                            <li class="breadcrumb-item">{{ $title }}</li>
                                            <li class="breadcrumb-item">{{ $subTitle }}</li>
                                        </ol>
                                    </div>
                        
                                </div>
                            </div>

                            {{ $slot }}
                        </div>
                    </div>
                </div>

                @include('layouts.admin.footer')
            </div>
        </div>
        {{ $modal }}
        @include('layouts.admin.menu2')
        @include('layouts.admin.script')
    </body>
</html>