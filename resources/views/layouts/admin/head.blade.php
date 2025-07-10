<head>
    <meta charset="utf-8" />
    <title>{{ $settings['name'] ?? null }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('storage/'.($settings['icon'] ?? null))}}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/admin-resources/rwd-table/rwd-table.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Responsive datatable examples -->
    {{-- <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/@chenfengyuan/datepicker/datepicker.min.css')}}" rel="stylesheet"  type="text/css"> --}}
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />

    <link href="{{ asset('assets/libs/leaflet/leaflet.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/toastr/build/toastr.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/custom.css')}}" rel="stylesheet" type="text/css" />

    <style>
        table.dataTable thead th {
            background-color: {{ $settings['theme'] ?? null }};
            color: white;
            position: relative;
            z-index: 1;
        }
        .bg-apps {
            background-color: #009B4C !important; /* Warna hijau Bootstrap */
        }

        .btn-apps {
        color: #fff; /* Teks berwarna putih */
        background-color: #009B4C; /* Warna latar belakang hijau */
        border-color: #009B4C; /* Warna border hijau */
        }

        .btn-apps:hover {
        color: #fff; /* Teks tetap putih saat hover */
        background-color: #1a6d2c; /* Warna latar belakang hijau yang lebih gelap saat hover */
        border-color: #1a6d2c; /* Warna border hijau yang lebih gelap saat hover */
        }

        .btn-apps:focus, .btn-apps.focus {
        box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.5); /* Efek fokus dengan bayangan hijau */
        }

        .btn-apps.disabled, .btn-apps:disabled {
        background-color: #c3e6cb; /* Warna latar belakang hijau muda untuk tombol yang dinonaktifkan */
        border-color: #c3e6cb; /* Warna border hijau muda untuk tombol yang dinonaktifkan */
        }

        .text-apps{
            color: #009B4C;
        }

        .min-width-160 {
            min-width: 160px !important;
        }
        .min-width-150 {
            min-width: 150px !important;
        }


    </style>
    
    @stack('css')
</head>