<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="id-ID" lang="id-ID">

@include('layouts.landing.head')

<body class="body header-fixed counter-scroll">
    @include('layouts.landing.preloader')

    <div id="wrapper">
        <div id="pagee" class="clearfix">
            @include('layouts.landing.header')

            <main id="main">
                {{ $slot }}
            </main>
            @include('layouts.landing.footer')
        </div>
    </div>

    <a id="scroll-top" class="button-go"></a>
    @include('layouts.landing.script')
</body>

</html>