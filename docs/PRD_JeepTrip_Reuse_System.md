# PRD Penambahan Produk Jeep Trip (Reuse Sistem Eksisting)

## 1. Latar Belakang & Tujuan

**Latar belakang:**
- Sistem Villa Hotel Dieng saat ini sudah mendukung:
  - Manajemen produk (villa/property) via tabel `produks` + relasi (kategori, fasilitas, gambar, dst.).
  - Booking, ketersediaan (`availabilities`), promosi (`promos`, `promo_products`, `promo_categories`), dan pembayaran (Midtrans).
- Bisnis ingin menambahkan produk **Jeep Trip (tour jeep Dieng)** ke dalam sistem yang sama tanpa membuat modul/database baru.

**Tujuan:**

1. Menambah jenis produk **Jeep Trip** ke sistem eksisting dengan:
   - Reuse tabel `produks` dan relasinya (`produk_fasilitas`, `produk_wisata`, `produk_images`, `availabilities`, `transaksis`, dll.).
   - Tanpa membuat tabel khusus `jeep_trips`, `jeep_trip_bookings`, dsb.
2. Menyediakan halaman landing & detail produk Jeep Trip mirip konsep diengcool.com (listing paket, detail rute, fasilitas, harga, rating).
3. Memungkinkan user:
   - Memilih paket jeep,
   - Memilih tanggal trip,
   - Melakukan pemesanan & pembayaran online,
   - Menggunakan promo jika ada.
4. Meminimalkan perubahan core sistem booking & payment.

---

## 2. Scope & Out of Scope

### 2.1. In Scope

1. **Backend**
   - Penambahan kolom & enum baru di tabel `produks` (untuk membedakan villa vs jeep).
   - Penambahan kategori produk “Jeep Trip”.
   - Penyesuaian logic availability & booking agar support produk **1 hari (day trip)**.
   - Penyesuaian kalkulasi harga (jeep = per unit, per hari, bukan per malam).
   - Reuse transaksi & payment flow yang ada.

2. **Frontend (Landing + Dashboard Admin)**
   - Halaman publik:
     - `/jeeptrip` → listing semua produk Jeep Trip.
     - `/jeeptrip/{slug}` → halaman detail satu paket Jeep Trip.
   - Update form admin Produk:
     - Bisa buat/update produk dengan **jenis Jeep Trip**.
     - Input field khusus: durasi, jam berangkat, zona, rute destinasi, fasilitas paket, dll.
   - UI booking Jeep Trip:
     - Form pilih tanggal + jumlah jeep (unit).
     - Menampilkan ringkasan paket: destinasi, fasilitas, jadwal, harga.

3. **Integrasi Promo & Availability**
   - Jeep Trip bisa ikut promo kategori/produk.
   - Availability jeep per tanggal tetap pakai `availabilities`.

### 2.2. Out of Scope

- Manajemen slot jam multiple dalam 1 hari (mis: jam 03:00 & 09:00 untuk produk sama) – versi awal diasumsikan **1 slot keberangkatan per produk per hari**.
- Paket bundling otomatis (Villa + Jeep) – masih single product booking, bundle hanya bisa lewat manual setting produk paket.
- Sistem komisi driver/mitra jeep detail (bagi hasil, laporan khusus).

---

## 3. Definisi Pengguna & Use Case Utama

### 3.1. Role

1. **Admin / Owner**
   - Mengelola produk Jeep Trip (CRUD).
   - Mengatur harga, promo, quota per tanggal.
   - Melihat dan mengelola booking Jeep Trip (konfirmasi, refund manual, dsb).

2. **Customer (User publik)**
   - Melihat daftar paket Jeep Trip.
   - Melihat detail paket (destinasi, fasilitas, jadwal).
   - Memilih tanggal & jumlah jeep.
   - Melakukan booking & pembayaran.

---

## 4. User Story

### 4.1. Admin

1. **Sebagai admin**, saya ingin menambahkan produk baru dengan jenis “Jeep Trip”, sehingga bisa menjual paket tour jeep tanpa sistem baru.
2. **Sebagai admin**, saya ingin mengisi data khusus Jeep Trip (durasi jam, jam berangkat, zona, destinasi, fasilitas paket), sehingga informasi paket lengkap di halaman publik.
3. **Sebagai admin**, saya ingin mengatur harga Jeep Trip per unit jeep dan membedakan weekday/weekend bila perlu.
4. **Sebagai admin**, saya ingin melihat daftar booking Jeep Trip di modul transaksi yang sama dengan villa, sehingga laporan tetap terpusat.
5. **Sebagai admin**, saya ingin mengatur ketersediaan Jeep (quota jeep) per tanggal menggunakan modul availability yang ada.

### 4.2. Customer

1. **Sebagai customer**, saya ingin melihat halaman khusus “Jeep Trip” berisi daftar paket, sehingga saya bisa membandingkan paket dengan mudah.
2. **Sebagai customer**, saya ingin melihat detail paket Jeep Trip (destinasi, fasilitas, durasi, jam berangkat, foto), sehingga saya yakin sebelum memesan.
3. **Sebagai customer**, saya ingin memilih tanggal trip dan jumlah jeep, melihat harga total, kemudian membayar online.
4. **Sebagai customer**, saya ingin melihat informasi apakah tanggal tersebut masih tersedia atau sudah penuh.

---

## 5. Solusi Teknis (High Level)

### 5.1. Perubahan Data & Model

**Tanpa membuat tabel baru**. Reuse:

- `produks`
- `produk_categories`
- `produk_fasilitas`
- `produk_wisata`
- `produk_images`
- `availabilities`
- `transaksis`
- `transaksi_details`
- `promos`, `promo_products`, `promo_categories`

#### 5.1.1. Tabel `produk_categories`

- Tambah 1 record kategori:
  - `name`: “Jeep Trip”
  - `slug`: `jeeptrip`
  - `urutan`: disesuaikan

#### 5.1.2. Tabel `produks`

Tambahan kolom (via migration):

```php
Schema::table('produks', function (Blueprint $table) {
    $table->string('jenis_produk')
        ->default('villa')
        ->comment('villa, jeep_trip, dll.');

    $table->integer('durasi_jam')
        ->nullable()
        ->comment('Durasi paket dalam jam, khusus jeep_trip');

    $table->time('jam_berangkat')
        ->nullable()
        ->comment('Jam start keberangkatan jeep_trip');

    $table->string('zona')
        ->nullable()
        ->comment('Zona trip: zona_1, zona_2, sunrise, favorit, dsb.');
});
```

Update Model `Produk`:

```php
class Produk extends Model
{
    protected $fillable = [
        'category_id',
        'owner',
        'name',
        'slug',
        'unit',
        'orang',
        'maks_orang',
        'lokasi',
        'fasilitas',
        'kamar',
        // field lain...
        'jenis_produk',
        'durasi_jam',
        'jam_berangkat',
        'zona',
    ];
}
```

**Aturan bisnis:**

- `jenis_produk = 'villa'` (default) untuk produk lama.
- `jenis_produk = 'jeep_trip'` untuk produk Jeep:
  - `orang` = kapasitas ideal per jeep (mis: 4).
  - `maks_orang` = kapasitas maksimal per jeep (mis: 5).
  - `unit` = jumlah unit jeep yang dapat dijual per tanggal.

#### 5.1.3. Tabel Relasi Produk

- `produk_fasilitas`: untuk “Termasuk paket” (driver, BBM, parkir, dokumentasi).
- `produk_wisata`: untuk daftar destinasi rute Jeep.
- `produk_images`: foto jeep & spot.
- `produk_syarat` (jika ada): catatan penting (meeting point, ketentuan usia, dsb.).

Tidak ada perubahan struktur; hanya pemanfaatan berbeda di UI.

#### 5.1.4. Tabel `availabilities`

- Tetap dipakai untuk ketersediaan jeep per tanggal.
- Quota = `unit` (jumlah jeep).
- Hitung terpakai via `transaksi_details` untuk tanggal itu.

Asumsi awal: **1 slot keberangkatan per hari per produk Jeep**.

---

## 6. Perubahan Logika Bisnis

### 6.1. Booking Flow Jeep Trip

**Perbedaan utama vs villa:**

- Villa: ada `start_date`, `end_date`, dan `night`.
- Jeep: day trip → `start_date = end_date`, `night` bisa 0 atau 1 (tergantung aturan global).

**Rule baru:**

- Jika `produk.jenis_produk == 'jeep_trip'`:
  - Form booking hanya meminta **tanggal trip** (`trip_date`).
  - Backend set:
    - `start_date = trip_date`
    - `end_date = trip_date`
    - `night = 0` (atau 1, pilih satu dan konsisten).
  - Jumlah jeep yang dipesan (`qty_jeep`) masuk ke `transaksi_details.qty` atau field setara jumlah unit.

### 6.2. Kalkulasi Harga

- Villa: umumnya `harga_per_malam * malam` ± promo.
- Jeep: `harga_per_unit_jeep * jumlah_jeep`.

Aturan:

- Jika `jenis_produk == 'jeep_trip'`:
  - Abaikan kalkulasi malam.
  - Hitung:
    - `base_price = harga_weekday/weekend` berdasarkan `trip_date`.
    - `total_price = base_price * qty_jeep`.
  - Promo tetap bisa diterapkan (pakai engine promo sekarang, berdasarkan kategori atau produk).

### 6.3. Availability Check

- Fungsi pengecekan ketersediaan produk period range sudah ada.
- Untuk `jeep_trip`:
  - Range selalu 1 hari (trip_date sampai trip_date).
  - Kapasitas = `unit`.
  - Terpakai = sum booking jeep pada tanggal itu.
  - Available jika `unit - terpakai >= qty_jeep`.

Kalau saat ini fungsi `getAvailableUnitsForRange()` sudah ada di `Produk`, cukup pastikan branch untuk jeeps memperlakukan durasi 1 hari dan `night` tidak mengganggu.

---

## 7. Perubahan Frontend & UX

### 7.1. Halaman Publik

1. **Route & Controller**
   - `GET /jeeptrip`
     - Controller: `JeepTripController@index`
     - Query:
       - Produk dengan:
         - `jenis_produk = 'jeep_trip'` **atau**
         - `category.slug = 'jeeptrip'`.
     - Tampilan: grid kartu paket Jeep (foto utama, nama paket, zona, harga mulai, rating).

   - `GET /jeeptrip/{slug}`
     - Controller: `JeepTripController@show`
     - Ambil:
       - `produk` + relasi: `produk_fasilitas`, `produk_wisata`, `produk_images`.
     - Tampilkan:
       - Hero section (judul, zona, rating, durasi, jam berangkat, harga).
       - Rute destinasi (list).
       - Termasuk paket (fasilitas).
       - Catatan (syarat/keterangan).
       - Galeri foto (slider).
       - Widget form booking (tanggal + jumlah jeep + tombol lanjut ke checkout).

2. **Form Booking Jeep (di detail page)**
   - Field:
     - `tanggal_trip` (date picker).
     - `jumlah_jeep` (numeric, min 1, max sesuai availability).
   - Validasi:
     - Tanggal >= hari ini.
     - Jeep tersedia cukup.
   - Setelah submit:
     - Redirect ke halaman ringkasan/checkout (reuse flow villa) dengan label yang disesuaikan (Trip Date, Jumlah Jeep).

### 7.2. Halaman Admin – Produk

- Di form buat/edit produk:
  - Dropdown `Jenis Produk`: `villa`, `jeep_trip` (required).
  - Jika `jeep_trip` terpilih:
    - Tampilkan field tambahan:
      - `Durasi (jam)` → `durasi_jam`
      - `Jam Berangkat` → `jam_berangkat`
      - `Zona` (text atau select)
      - Section “Destinasi / Rute” → CRUD kecil ke `produk_wisata`.
      - Section “Termasuk dalam Paket” → CRUD kecil ke `produk_fasilitas`.
    - Sembunyikan field yang hanya relevan untuk villa jika perlu (misal beberapa field kamar).

- Di listing produk, bisa tambahkan badge `Jeep Trip` di kolom jenis.

### 7.3. Halaman Admin – Booking/Transaksi

- Di tabel transaksi:
  - Tambahkan kolom/label jenis produk:
    - Villa / Jeep Trip.
  - Untuk Jeep:
    - Tampilkan “Tanggal Trip” (bisa ambil dari `start_date`).
    - Tampilkan “Jumlah Jeep” (qty).

---

## 8. Validasi, Error Handling & Edge Case

1. **Tanggal lampau**  
   - Jangan izinkan `tanggal_trip` < `today`.

2. **Double booking / race condition**  
   - Pastikan pengecekan quota & pengurangan quota dilakukan di transaksi yang atomic (di dalam DB transaction).

3. **Produk di-nonaktifkan**  
   - Jika `produk.status = draft` atau `jenis_produk` berubah dari `jeep_trip` ke lain setelah ada booking, booking lama tetap valid tapi produk tidak tampil di listing publik.

4. **Promo tidak kompatibel**  
   - Jika promo filter per kategori, pastikan kategori Jeep Trip sudah diperhitungkan (bisa dibuat promo khusus jeep).

---

## 9. Non-Functional Requirement

- **Kinerja:**  
  - Query listing Jeep Trip harus menggunakan eager loading minimal (produk + images utama) untuk menghindari N+1.
- **Keamanan:**  
  - Booking & pembayaran reuse mekanisme autentikasi & Midtrans yang sama.
- **Maintainability:**  
  - Code terkait Jeep sebisa mungkin ditulis sebagai kondisi berdasarkan `jenis_produk` tanpa mengotori terlalu banyak bagian lama.
  - Pertimbangkan service/class khusus `JeepTripPricingService` jika logika harga mulai kompleks.

---

## 10. Tracking & KPI

Beberapa KPI yang bisa diambil dari modul yang sama:

- Jumlah booking Jeep Trip per bulan.
- Revenue Jeep Trip per bulan.
- Conversion rate (view detail Jeep Trip → create transaksi).
- Persentase promo yang dipakai di transaksi Jeep Trip.

Query bisa dibedakan dengan filter `jenis_produk = 'jeep_trip'` atau kategori `jeeptrip`.

---

## 11. Risiko & Mitigasi

1. **Logika booking villa & jeep tercampur membingungkan**  
   - Mitigasi: isolasi branch kondisi `jenis_produk` di service / helper, bukan di view secara besar-besaran.

2. **Kebutuhan slot jam ganda di masa depan**  
   - Mitigasi: desain kode availability yang mudah di-extend (misalnya sudah siap untuk penambahan `slot` di level kode meski belum ada tabelnya).

3. **Perubahan besar di pricing**  
   - Jika nanti ada pricing per orang/per jeep campuran, kemungkinan butuh abstraksi pricing service.
