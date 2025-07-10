<footer class="bg-light text-center text-muted py-4">
    <div class="container">
        <nav class="mb-3">
            <a href="{{ route('index') }}" class="text-decoration-none text-muted mx-2">Beranda</a>
            <a href="{{ route('tentang-kami') }}" class="text-decoration-none text-muted mx-2">Tentang Kami</a>
            <a href="{{ route('sk') }}" class="text-decoration-none text-muted mx-2">S & K</a>
            <a href="{{ $settings['sosmed_whatsapp'] ?? '#' }}" class="text-decoration-none text-muted mx-2">Pusat Bantuan</a>
        </nav>
        <p class="mb-0 fw-bold">{{ request()->getHost() }}</p>
        <p class="mb-0">{{ $settings['contact_address' ]}}</p>
        <p class="mb-0">&copy; {{ date('Y') }} {{ $settings['company'] ?? null }}</p>
    </div>
</footer>
