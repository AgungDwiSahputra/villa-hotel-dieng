# Villa Hotel Dieng Management System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.0-FF2D20?style=for-the-badge&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/PHP-8.3-777BB4?style=for-the-badge&logo=php" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql" alt="MySQL">
  <img src="https://img.shields.io/badge/Tailwind%20CSS-3.1-38B2AC?style=for-the-badge&logo=tailwind-css" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/Vite-5.0-646CFF?style=for-the-badge&logo=vite" alt="Vite">
</p>

Sistem manajemen villa dan hotel modern yang dibangun dengan Laravel 12 untuk mengelola properti, pemesanan, dan operasional bisnis perhotelan secara komprehensif.

## 🏨 Fitur Utama

### Manajemen Properti
- **Produk Management**: Kelola villa/kamar dengan informasi lengkap
- **Kategori Produk**: Organisasi properti berdasarkan kategori
- **Galeri Foto**: Upload dan kelola foto properti
- **Fasilitas**: Daftar fasilitas yang tersedia di setiap properti
- **Wisata Terdekat**: Informasi objek wisata di sekitar properti
- **Syarat & Ketentuan**: Aturan sewa dan kebijakan properti

### Sistem Pemesanan
- **Booking Online**: Sistem reservasi real-time
- **Availability Calendar**: Kalender ketersediaan properti
- **Transaksi Management**: Kelola pemesanan dan pembayaran
- **Payment Gateway**: Integrasi dengan Midtrans
- **Rekening Management**: Kelola rekening pembayaran

### Manajemen Pengguna
- **Role-Based Access Control**: Sistem permission dengan Spatie Laravel Permission
- **User Activity Logging**: Track aktivitas pengguna
- **Authentication**: Laravel Sanctum untuk API authentication

### Fitur Tambahan
- **Export/Import**: Excel export untuk data laporan
- **Data Tables**: Tabel interaktif dengan Yajra DataTables
- **Regional Data**: Data wilayah Indonesia lengkap
- **Real-time Logging**: Monitor sistem dengan Laravel Pail

## 🛠️ Teknologi Stack

### Backend
- **Framework**: Laravel 12.0
- **PHP Version**: 8.3
- **Database**: MySQL
- **Authentication**: Laravel Sanctum
- **Permission**: Spatie Laravel Permission 6.9
- **Queue System**: Laravel Queue
- **Logging**: Laravel Pail

### Frontend
- **Build Tool**: Vite 5.0
- **CSS Framework**: Tailwind CSS 3.1
- **JavaScript**: Alpine.js 3.4.2
- **HTTP Client**: Axios 1.7.4
- **UI Kit**: Laravel Breeze 2.2

### Payment & Integration
- **Payment Gateway**: Midtrans PHP 2.6
- **Excel Processing**: Maatwebsite Excel 3.1
- **Data Tables**: Yajra Laravel DataTables 12.0
- **Regional Data**: Azishapidin Indonesia Region 3.0

### Development Tools
- **Debugging**: Laravel Debugbar 3.16
- **Code Quality**: Laravel Pint 1.13
- **Testing**: PHPUnit 11.0.1
- **Package Management**: Composer & NPM

## 📋 Persyaratan Sistem

### Server Requirements
- PHP >= 8.3
- MySQL >= 8.0 atau MariaDB
- Composer
- Node.js & NPM
- Web Server (Apache/Nginx)

### PHP Extensions
- BCMath
- Ctype
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PDO
- Tokenizer
- XML
- GD Library
- cURL

## 🚀 Instalasi

### 1. Clone Repository
```bash
git clone <repository-url>
cd villa-hotel-dieng
```

### 2. Install Dependencies
```bash
# Install PHP dependencies
composer install

# Install Node.js dependencies
npm install
```

### 3. Environment Setup
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Database Configuration
Edit file `.env` dan sesuaikan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database_name
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Run Migration
```bash
php artisan migrate
```

### 6. Link Storage
```bash
php artisan storage:link
```

### 6.1. Create Required Directories
```bash
# Buat folder yang diperlukan untuk seeder
mkdir -p storage/app/public/images/setting
```

### 7. Compile Assets
```bash
# Development
npm run dev

# Production
npm run build
```

### 8. Run Database Seeders
```bash
# Jalankan semua seeder
php artisan db:seed

# Atau jalankan seeder spesifik
php artisan db:seed --class=SettingSeeder
php artisan db:seed --class=RolePermissionSeeder
```

### 9. Start Development Server
```bash
# Start Laravel server
php artisan serve

# Start queue worker (optional)
php artisan queue:work

# Start monitoring logs (optional)
php artisan pail
```

## ⚙️ Konfigurasi

### Midtrans Payment Gateway
Edit file `.env` untuk konfigurasi Midtrans:
```env
MIDTRANS_MERCHAT_ID=your_merchant_id
MIDTRANS_SERVER_KEY=your_server_key
MIDTRANS_CLIENT_KEY=your_client_key
MIDTRANS_IS_PRODUCTION=false
MIDTRANS_IS_SANITIZED=true
MIDTRANS_IS_3DS=true
```

### Email Configuration
```env
MAIL_MAILER=smtp
MAIL_HOST=your_smtp_host
MAIL_PORT=587
MAIL_USERNAME=your_email
MAIL_PASSWORD=your_password
MAIL_ENCRYPTION=tls
```

## 📁 Struktur Database

### Tabel Utama
- **users**: Data pengguna
- **settings**: Konfigurasi sistem
- **produks**: Data properti (villa/kamar)
- **produk_categories**: Kategori properti
- **produk_fasilitas**: Fasilitas properti
- **produk_images**: Galeri foto properti
- **produk_wisatas**: Wisata terdekat
- **produk_syarats**: Syarat & ketentuan
- **rekenings**: Data rekening pembayaran
- **transaksis**: Data transaksi pemesanan
- **transaksi_details**: Detail transaksi
- **availabilities**: Ketersediaan properti
- **activity_logs**: Log aktivitas pengguna

## 🎯 Penggunaan

### Manajemen Properti
1. Login ke dashboard admin
2. Navigasi ke menu "Produk"
3. Tambah properti baru dengan informasi lengkap
4. Upload foto dan tambahkan fasilitas
5. Set harga dan aturan sewa

### Manajemen Pemesanan
1. Customer dapat melihat properti yang tersedia
2. Pilih tanggal check-in dan check-out
3. Lakukan pemesanan dan pembayaran
4. Admin dapat melihat semua transaksi di dashboard

### Laporan dan Analitik
1. Akses menu "Laporan" untuk melihat data penjualan
2. Export data ke Excel untuk analisis lebih lanjut
3. Monitor aktivitas pengguna melalui activity logs

## 🔧 Development

### Running Tests
```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter TestExample
```

### Code Formatting
```bash
# Format code using Laravel Pint
./vendor/bin/pint
```

### Debugging
```bash
# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

## 📝 API Documentation

### Authentication
- Login: `POST /api/login`
- Logout: `POST /api/logout`
- Register: `POST /api/register`

### Products
- List Products: `GET /api/products`
- Show Product: `GET /api/products/{id}`
- Create Product: `POST /api/products`
- Update Product: `PUT /api/products/{id}`
- Delete Product: `DELETE /api/products/{id}`

### Transactions
- List Transactions: `GET /api/transactions`
- Create Transaction: `POST /api/transactions`
- Show Transaction: `GET /api/transactions/{id}`

## 🤝 Kontribusi

1. Fork repository
2. Buat branch baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buka Pull Request

## 📄 Lisensi

Proyek ini dilisensikan under MIT License - lihat file [LICENSE](LICENSE) untuk detailnya.

## 🆘 Troubleshooting

### Common Issues

#### Error "Table 'settings' doesn't exist" saat migration
Solusi: Comment sementara `SettingServiceProvider` di `bootstrap/providers.php` sebelum menjalankan migration.

#### Error "vendor/autoload.php not found"
Solusi: Jalankan `composer install` untuk menginstall dependensi PHP.

#### Error "Failed to open stream: No such file or directory" saat SettingSeeder
Solusi: Pastikan file template ada dan storage link sudah dibuat:
```bash
# Pastikan folder template ada di public/template/
ls public/template/

# Buat storage link jika belum ada
php artisan storage:link

# Buat folder yang diperlukan
mkdir -p storage/app/public/images/setting
```

#### Assets tidak loading
Solusi: Jalankan `npm run build` dan pastikan `php artisan storage:link` sudah dijalankan.

#### Permission denied error
Solusi: Set proper permissions untuk storage dan cache directories:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

## 📞 Support

Jika Anda mengalami masalah atau memiliki pertanyaan, silakan:
1. Cek dokumentasi ini
2. Lihat issues di GitHub
3. Hubungi tim development

## 🔄 Changelog

### Version 1.0.0
- Initial release
- Basic villa management system
- Booking system with Midtrans integration
- User management with role-based permissions
- Real-time availability calendar

---

**Dibuat dengan ❤️ menggunakan Laravel 12**
