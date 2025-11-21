<x-app-landing-layout>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-50 via-white to-green-50 py-16 sm:py-20 lg:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Syarat & Ketentuan
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto">
                    Ketentuan dan peraturan yang berlaku untuk penggunaan layanan Villa Hotel Dieng
                </p>
            </div>
        </div>
    </section>

    <!-- Terms Content Section -->
    <section class="py-16 sm:py-20 lg:py-24 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <div class="prose prose-lg prose-gray max-w-none">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 lg:p-12">
                    {!! $settings['page_terms'] ?? '<p class="text-gray-500 text-center py-12">Konten syarat dan ketentuan sedang disiapkan...</p>' !!}
                </div>
            </div>
        </div>
    </section>

    <!-- Key Terms Highlights -->
    <section class="py-16 sm:py-20 lg:py-24 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Poin-Poin Penting
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Ringkasan ketentuan utama untuk memudahkan pemahaman Anda
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Booking -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Pemesanan</h3>
                    <p class="text-gray-600">Reservasi dianggap sah setelah pembayaran dilakukan. Konfirmasi akan dikirim via email dan WhatsApp.</p>
                </div>

                <!-- Payment -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Pembayaran</h3>
                    <p class="text-gray-600">Pembayaran dilakukan melalui transfer bank atau gateway pembayaran. Invoice akan dikirim setelah pembayaran berhasil.</p>
                </div>

                <!-- Cancellation -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300 md:col-span-2 lg:col-span-1">
                    <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Pembatalan</h3>
                    <p class="text-gray-600">Pembatalan dapat dilakukan dengan syarat dan ketentuan tertentu. Silakan hubungi kami untuk informasi lebih lanjut.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="py-16 sm:py-20 lg:py-24 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <div class="bg-gradient-to-r from-blue-50 to-green-50 rounded-2xl p-8 sm:p-12 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white rounded-full mb-6 shadow-sm">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-4">
                    Ada Pertanyaan?
                </h3>
                <p class="text-lg text-gray-600 mb-8 max-w-2xl mx-auto">
                    Jika Anda memiliki pertanyaan mengenai syarat dan ketentuan ini, jangan ragu untuk menghubungi tim kami.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="https://wa.me/6281234567890" class="inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.885 3.488"/>
                        </svg>
                        Hubungi WhatsApp
                    </a>
                    <a href="mailto:info@villahoteldieng.com" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        Kirim Email
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-landing-layout>