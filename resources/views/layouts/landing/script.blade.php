<script src="{{ asset('landing/app/js/jquery.min.js')}}"></script>
<script src="{{ asset('landing/app/js/jquery.nice-select.min.js')}}"></script>
<script src="{{ asset('landing/app/js/bootstrap.min.js')}}"></script>
{{-- <script src="{{ asset('landing/app/js/swiper-bundle.min.js')}}"></script> --}}
<script src="{{ asset('landing/app/js/swiper.js')}}"></script>
<script src="{{ asset('landing/app/js/plugin.js')}}"></script>
<script src="{{ asset('landing/app/js/count-down.js')}}"></script>
<script src="{{ asset('landing/app/js/countto.js')}}"></script>
<script src="{{ asset('landing/app/js/jquery.fancybox.js')}}"></script>
<script src="{{ asset('landing/app/js/jquery.magnific-popup.min.js')}}"></script>
<script src="{{ asset('landing/app/js/price-ranger.js')}}"></script>
<script src="{{ asset('landing/app/js/textanimation.js')}}"></script>
<script src="{{ asset('landing/app/js/wow.min.js')}}"></script>
<script src="{{ asset('landing/app/js/shortcodes.js')}}"></script>
<script src="{{ asset('landing/app/js/main.js')}}"></script>
<script src="{{ asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<script>
    @if (session('success'))
        Swal.fire({ icon: 'success', title: 'Successfully',  text: "{{ session('success') }}", showConfirmButton: true});
    @endif
    @if ($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Error',
            html: `{!! implode('<br>', $errors->all()) !!}`,
            showConfirmButton: true
        });
    @endif

</script>
@stack('js')