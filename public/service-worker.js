self.addEventListener('install', function(event) {
    console.log('Service worker installed');
});

self.addEventListener('fetch', function(event) {
    // Bisa ditambahkan cache logic di sini
});
