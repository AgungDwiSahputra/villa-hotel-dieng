<head>
    <meta charset="utf-8">
    <title>{{ $settings['name'] ?? null }}</title>
    <meta name="author" content="thedaywebsite.com">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
    <meta name="theme-color" content="#0d6efd">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="stylesheet" href="{{ asset('landing/app/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('landing/app/css/magnific-popup.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('landing/app/css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('landing/app/css/textanimation.css') }}">
    <link href="{{ asset('assets/libs/sweetalert2/sweetalert2.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
    <link rel="shortcut icon" href="{{ asset('storage/' . ($settings['icon'] ?? null)) }}">
    <link rel="apple-touch-icon-precomposed" href="{{ asset('storage/' . ($settings['icon'] ?? null)) }}">
    @stack('css')
</head>
