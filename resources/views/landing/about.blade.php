<x-app-landing-layout>
    <!-- Hero Section -->
    <section class="relative bg-gradient-to-br from-blue-50 via-white to-green-50 py-16 sm:py-20 lg:py-24">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-6">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 mb-4">
                    Tentang Kami
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 max-w-2xl mx-auto">
                    Kenali lebih dalam tentang Villa Hotel Dieng dan komitmen kami untuk memberikan pengalaman menginap yang tak terlupakan
                </p>
            </div>
        </div>
    </section>

    <!-- About Content Section -->
    <section class="py-16 sm:py-20 lg:py-24 bg-white">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <div class="prose prose-lg prose-gray max-w-none">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 sm:p-8 lg:p-12">
                    {!! $settings['page_about'] ?? '<p class="text-gray-500 text-center py-12">Konten tentang kami sedang disiapkan...</p>' !!}
                </div>
            </div>
        </div>
    </section>

    <!-- Values Section (Optional - can be expanded if more content available) -->
    <section class="py-16 sm:py-20 lg:py-24 bg-gray-50">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 max-w-5xl">
            <div class="text-center mb-12">
                <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 mb-4">
                    Nilai-Nilai Kami
                </h2>
                <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                    Prinsip yang mendasari setiap layanan yang kami berikan
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Value 1 -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Kualitas Terbaik</h3>
                    <p class="text-gray-600">Kami berkomitmen untuk memberikan pengalaman menginap berkualitas tinggi dengan fasilitas modern dan pelayanan prima.</p>
                </div>

                <!-- Value 2 -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300">
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="rotate: -90deg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9v-9m0-9v9"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Keaslian Lokal</h3>
                    <p class="text-gray-600">Memperkenalkan keindahan dan budaya Dieng melalui pengalaman autentik yang tak terlupakan.</p>
                </div>

                <!-- Value 3 -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-300 md:col-span-2 lg:col-span-1">
                    <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mb-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 mb-2">Pelayanan Ramah</h3>
                    <p class="text-gray-600">Tim kami siap memberikan pelayanan yang hangat dan profesional untuk memastikan kenyamanan Anda.</p>
                </div>
            </div>
        </div>
    </section>
</x-app-landing-layout>