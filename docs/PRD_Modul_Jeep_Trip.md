
# PRD – Modul Produk Jeep Trip (Skema DB Khusus Jeep)

## 1. Latar Belakang & Tujuan

### 1.1 Latar Belakang
- Sistem **Villa Hotel Dieng** saat ini hanya memiliki produk utama villa/homestay.
- Website ingin menambah **produk jasa Jeep Trip (tour jeep Dieng)** sebagai lini bisnis baru:
  - Paket sunrise, paket zona favorit, paket kombinasi beberapa destinasi, dll.
- Kebutuhan khusus Jeep berbeda dari villa:
  - Durasi jam, jam keberangkatan, zona trip, kapasitas per jeep, quota per slot waktu, dll.
- Untuk menjaga fleksibilitas jangka panjang (multi slot per hari, multi meeting point), diputuskan **membuat skema database baru khusus Jeep**, tidak menumpang di tabel `produks` yang lama.

### 1.2 Tujuan
- Menyediakan **modul Jeep Trip** end-to-end:
  - Manajemen paket Jeep (admin).
  - Tampilan landing & detail produk Jeep (front).
  - Booking Jeep (tanggal + slot waktu).
  - Manajemen ketersediaan & quota per tanggal/slot.
- Menjaga **integrasi** dengan sistem existing:
  - User login & profil tetap reuse.
  - Gateway pembayaran tetap reuse (Midtrans / existing).
  - Laporan transaksi bisa dipisah per jenis produk (villa vs jeep).

### 1.3 Ruang Lingkup (Scope)

**Termasuk:**
- Skema database baru khusus Jeep.
- Halaman admin CRUD paket Jeep.
- Halaman landing listing Jeep.
- Halaman detail produk Jeep + form booking.
- Flow booking Jeep sampai pembayaran (integrasi dengan modul transaksi existing).
- Manajemen ketersediaan per tanggal dan per slot.

**Tidak termasuk (out of scope versi pertama):**
- Bundling otomatis Villa + Jeep dalam satu paket.
- Dynamic pricing rumit (musim liburan, dsb) di luar weekday/weekend.
- Sistem komisi agen/mitra jeep (bisa ditambahkan kemudian).

---

## 2. Definisi Peran Pengguna

1. **Pengunjung (Guest / Unregistered)**
   - Melihat listing paket Jeep.
   - Melihat detail paket, destinasi, fasilitas, foto.
   - Simulasi harga → diarahkan login/registrasi saat checkout.

2. **Customer (Registered User)**
   - Semua kemampuan guest.
   - Membuat booking Jeep.
   - Melihat riwayat / status booking Jeep.

3. **Admin**
   - Mengelola master data Jeep.
   - Mengatur ketersediaan & quota.
   - Mengelola harga, promo khusus Jeep (kalau ingin).
   - Monitoring transaksi Jeep.

---

## 3. User Stories (Jeep Trip)

### 3.1 Guest & Customer

1. **Browsing paket**
   - *Sebagai* pengunjung  
   - *Saya ingin* melihat daftar paket Jeep yang tersedia  
   - *Sehingga saya bisa* memilih paket yang cocok (zona, durasi, harga).

2. **Melihat detail paket Jeep**
   - *Sebagai* pengunjung  
   - *Saya ingin* melihat penjelasan detail paket (destinasi, durasi, jam berangkat, include/exclude, foto)  
   - *Sehingga saya* paham apa yang saya dapat.

3. **Cek ketersediaan & harga**
   - *Sebagai* pengunjung  
   - *Saya ingin* memilih tanggal & slot waktu (mis. Sunrise 03.00)  
   - *Sehingga saya* tahu apakah masih ada quota jeep dan total harga.

4. **Booking Jeep**
   - *Sebagai* user terdaftar  
   - *Saya ingin* memesan X unit jeep pada tanggal & slot tertentu  
   - *Sehingga saya* bisa konfirmasi trip dan melakukan pembayaran online.

5. **Melihat status booking**
   - *Sebagai* user  
   - *Saya ingin* melihat status booking Jeep (pending, paid, cancelled, done)  
   - *Sehingga saya* yakin jadwal saya sudah tercatat.

### 3.2 Admin

6. **CRUD paket Jeep**
   - *Sebagai* admin  
   - *Saya ingin* membuat, mengubah, menonaktifkan paket Jeep  
   - *Sehingga saya* dapat mengatur produk tanpa bantuan developer.

7. **Mengelola destinasi trip**
   - *Sebagai* admin  
   - *Saya ingin* menyusun daftar destinasi per paket  
   - *Sehingga* itinerary jelas untuk customer dan driver jeep.

8. **Mengelola slot waktu & quota**
   - *Sebagai* admin  
   - *Saya ingin* mengatur slot waktu (Sunrise, Siang, dll.) dan quota unit per slot/tanggal  
   - *Sehingga* tidak overbooking.

9. **Monitoring booking Jeep**
   - *Sebagai* admin  
   - *Saya ingin* melihat list booking Jeep (filter tanggal, status)  
   - *Sehingga* operasional bisa di-manage (driver, unit jeep, dsb).

---

## 4. Requirement Fungsional

### 4.1 Frontend – Landing & Detail Jeep

1. **Halaman: `/jeeptrip`**
   - Menampilkan list paket Jeep:
     - Card: nama paket, harga mulai, durasi, zona, rating, thumbnail.
   - Filter dasar:
     - Zona (dropdown).
     - Durasi (range/filter).
   - Sorting:
     - Harga terendah/tertinggi.
     - Durasi tersingkat.
     - Rating tertinggi.

2. **Halaman: `/jeeptrip/{slug}`**
   - Section utama:
     - Nama paket, zona, rating, durasi (jam), kapasitas per jeep.
     - Harga mulai (weekday / weekend).
     - Tombol **“Pilih Tanggal & Slot”**.
   - Section tanggal & slot:
     - Input tanggal (date picker).
     - Dropdown slot waktu, mis:
       - “Sunrise 03.00–07.00”
       - “Siang 09.00–13.00”
     - Setelah pilih tanggal + slot:
       - Fetch ketersediaan quota jeep.
       - User isi `jumlah_jeep` (max sesuai quota).
       - Tampilkan hitung total: `harga_per_jeep * jumlah_jeep`.
       - Tampilkan status ketersediaan (tersedia / hampir penuh / penuh).
   - Section destinasi:
     - List destinasi dengan urutan.
   - Section include / exclude:
     - Termasuk paket (BBM, driver, parkir, dll.)
     - Tidak termasuk (tiket masuk, makan, dll.).
   - Section galeri:
     - Slider foto jeep & suasana trip.

3. **Flow booking:**
   - Jika user belum login:
     - Setelah klik **“Lanjutkan Booking”**, redirect ke login/register.
     - Setelah login, kembali ke halaman booking dengan parameter yang sama.
   - Jika login:
     - Tampilkan ringkasan:
       - Paket, tanggal, slot, jumlah_jeep, total harga.
     - Tombol **“Bayar Sekarang”** → redirect ke flow pembayaran (Midtrans / existing).

### 4.2 Backend – Admin Jeep

1. **Menu baru di admin:**
   - `Jeep Trip` → sub-menu:
     - `Paket Jeep`
     - `Slot & Ketersediaan`
     - `Booking Jeep`

2. **Form Paket Jeep (CRUD):**
   - Field:
     - Nama paket
     - Slug (auto dari nama, bisa diedit)
     - Deskripsi singkat
     - Deskripsi lengkap (HTML/Text)
     - Zona (enum/text)
     - Durasi (jam, integer)
     - Jam berangkat default (time)
     - Kapasitas ideal per jeep (int)
     - Kapasitas maksimal per jeep (int)
     - Harga weekday (decimal)
     - Harga weekend (decimal)
     - Status (aktif/nonaktif)
   - Relasi:
     - Destinasi (repeatable list)
     - Include (repeatable list)
     - Exclude (repeatable list)
     - Galeri foto (upload multiple).

3. **Manajemen slot & ketersediaan:**
   - Admin dapat membuat **slot waktu** per paket:
     - Contoh: “Sunrise”, jam_mulai 03.00, jam_selesai 07.00.
   - Per tanggal & slot:
     - Set `quota_jeep` (max unit).
     - Lihat `quota_terpakai`.
     - Bisa tutup slot (closed).

4. **Manajemen booking Jeep:**
   - Tabel list booking:
     - Filter: tanggal trip, paket, slot, status pembayaran.
   - Detail booking:
     - Data customer (nama, WA, email).
     - Paket, tanggal, slot, jumlah_jeep, total.
     - Status pembayaran & log callback payment gateway (re-use existing).

---

## 5. Desain Database – Skema Khusus Jeep

### 5.1 Diagram Konseptual (teks)

- `jeep_trips` (master paket Jeep)
  - 1 → n `jeep_trip_destinations`
  - 1 → n `jeep_trip_includes`
  - 1 → n `jeep_trip_excludes`
  - 1 → n `jeep_trip_images`
  - 1 → n `jeep_trip_slots`
- `jeep_trip_slots`
  - 1 → n `jeep_trip_availabilities`
- `jeep_trip_bookings`
  - 1 → n `jeep_trip_booking_items` (opsional, kalau 1 booking bisa multi slot/paket)
  - Terhubung ke tabel transaksi global jika diperlukan (`transaksis` existing).

### 5.2 Detail Tabel

#### 1) Tabel `jeep_trips`
Master paket Jeep.

```sql
CREATE TABLE jeep_trips (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(50) UNIQUE,            -- optional kode internal, mis: JEEP-SUNRISE-01
    slug VARCHAR(150) UNIQUE,
    nama_paket VARCHAR(150),
    deskripsi_singkat TEXT NULL,
    deskripsi_lengkap LONGTEXT NULL,
    zona VARCHAR(50) NULL,              -- zona_1, zona_2, sunrise, favorit, dll.
    durasi_jam INT UNSIGNED NULL,
    jam_berangkat_default TIME NULL,
    kapasitas_ideal_per_jeep INT UNSIGNED DEFAULT 4,
    kapasitas_max_per_jeep INT UNSIGNED DEFAULT 4,
    harga_weekday DECIMAL(15,2) NOT NULL,
    harga_weekend DECIMAL(15,2) NOT NULL,
    rating DECIMAL(3,2) NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
);
```

#### 2) Tabel `jeep_trip_destinations`

```sql
CREATE TABLE jeep_trip_destinations (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jeep_trip_id BIGINT UNSIGNED NOT NULL,
    nama_destinasi VARCHAR(150),
    urutan INT UNSIGNED DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (jeep_trip_id) REFERENCES jeep_trips(id) ON DELETE CASCADE
);
```

#### 3) Tabel `jeep_trip_includes` & `jeep_trip_excludes`

```sql
CREATE TABLE jeep_trip_includes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jeep_trip_id BIGINT UNSIGNED NOT NULL,
    nama_item VARCHAR(150),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (jeep_trip_id) REFERENCES jeep_trips(id) ON DELETE CASCADE
);

CREATE TABLE jeep_trip_excludes (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jeep_trip_id BIGINT UNSIGNED NOT NULL,
    nama_item VARCHAR(150),
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (jeep_trip_id) REFERENCES jeep_trips(id) ON DELETE CASCADE
);
```

#### 4) Tabel `jeep_trip_images`

```sql
CREATE TABLE jeep_trip_images (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jeep_trip_id BIGINT UNSIGNED NOT NULL,
    image_path VARCHAR(255),
    judul VARCHAR(150) NULL,
    urutan INT UNSIGNED DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (jeep_trip_id) REFERENCES jeep_trips(id) ON DELETE CASCADE
);
```

#### 5) Tabel `jeep_trip_slots`
Slot waktu per paket Jeep.

```sql
CREATE TABLE jeep_trip_slots (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jeep_trip_id BIGINT UNSIGNED NOT NULL,
    nama_slot VARCHAR(100),          -- "Sunrise", "Siang", "Full Day"
    jam_mulai TIME NOT NULL,
    jam_selesai TIME NOT NULL,
    is_active TINYINT(1) DEFAULT 1,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (jeep_trip_id) REFERENCES jeep_trips(id) ON DELETE CASCADE
);
```

#### 6) Tabel `jeep_trip_availabilities`
Quota per tanggal & slot.

```sql
CREATE TABLE jeep_trip_availabilities (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jeep_trip_slot_id BIGINT UNSIGNED NOT NULL,
    tanggal DATE NOT NULL,
    quota_jeep INT UNSIGNED NOT NULL,
    quota_terpakai INT UNSIGNED DEFAULT 0,
    is_closed TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    UNIQUE KEY uniq_slot_tanggal (jeep_trip_slot_id, tanggal),
    FOREIGN KEY (jeep_trip_slot_id) REFERENCES jeep_trip_slots(id) ON DELETE CASCADE
);
```

#### 7) Tabel `jeep_trip_bookings`
Header booking Jeep (bisa di-link ke transaksi global).

```sql
CREATE TABLE jeep_trip_bookings (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    kode_booking VARCHAR(50) UNIQUE,
    total_harga DECIMAL(15,2) NOT NULL,
    status ENUM('pending','paid','cancelled','expired','done') DEFAULT 'pending',
    payment_ref VARCHAR(100) NULL,   -- id transaksi di payment gateway / transaksi global
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL
    -- FOREIGN KEY (user_id) REFERENCES users(id)
);
```

#### 8) Tabel `jeep_trip_booking_items`
Detail booking (per paket, slot, tanggal).

```sql
CREATE TABLE jeep_trip_booking_items (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    jeep_trip_booking_id BIGINT UNSIGNED NOT NULL,
    jeep_trip_id BIGINT UNSIGNED NOT NULL,
    jeep_trip_slot_id BIGINT UNSIGNED NOT NULL,
    tanggal_trip DATE NOT NULL,
    jumlah_jeep INT UNSIGNED NOT NULL,
    harga_satuan DECIMAL(15,2) NOT NULL,
    subtotal DECIMAL(15,2) NOT NULL,
    created_at TIMESTAMP NULL,
    updated_at TIMESTAMP NULL,
    FOREIGN KEY (jeep_trip_booking_id) REFERENCES jeep_trip_bookings(id) ON DELETE CASCADE,
    FOREIGN KEY (jeep_trip_id) REFERENCES jeep_trips(id),
    FOREIGN KEY (jeep_trip_slot_id) REFERENCES jeep_trip_slots(id)
);
```

> Catatan: tabel `jeep_trip_booking_items` memungkinkan 1 booking punya beberapa paket/slot, walaupun versi awal mungkin hanya pakai 1 baris.

---

## 6. Integrasi dengan Sistem Existing

1. **User & Auth**
   - Reuse tabel `users` dan mekanisme login yang sudah ada.
   - `jeep_trip_bookings.user_id` refer ke `users.id`.

2. **Pembayaran**
   - Opsi A: mapping 1:1 ke `transaksis` yang sudah ada → `jeep_trip_bookings.payment_ref = transaksis.kode`.
   - Opsi B: simpan `midtrans_order_id` langsung di `jeep_trip_bookings.payment_ref`.

3. **Laporan**
   - Tambah filter di laporan transaksi:
     - Tipe produk: villa / jeep.
   - Atau buat laporan terpisah khusus Jeep berdasarkan `jeep_trip_bookings`.

---

## 7. Non-Fungsional

- **Performance**:
  - Query ketersediaan tanggal & slot harus tetap cepat (<300ms) untuk normal traffic.
- **Reliability**:
  - Pengurangan quota harus atomic pada saat booking (gunakan transaksi DB).
- **Security**:
  - Endpoint admin di-protect middleware `auth:admin`.
  - Validasi server-side `jumlah_jeep <= quota` tersisa.
- **Scalability (future)**:
  - Desain slot & availability sudah siap untuk multi slot & multi tanggal.

---

## 8. Risiko & Mitigasi

1. **Overbooking karena race condition**
   - *Risiko*: 2 user booking di detik yang sama pada slot dengan quota mepet.
   - *Mitigasi*: 
     - Gunakan DB transaction + `SELECT ... FOR UPDATE` / locking pada row `jeep_trip_availabilities`.
     - Validasi ulang quota sebelum insert booking.

2. **Complexity vs modul existing**
   - *Risiko*: Ada duplikasi fungsi booking (villa vs jeep).
   - *Mitigasi*: 
     - Abstraksikan bagian common (payment, notifikasi) jadi service reusable.
     - Pisahkan route dan controller supaya kode tetap bersih.

3. **Perubahan kebutuhan (bundling, dynamic pricing)**
   - *Risiko*: Dalam 3–6 bulan, owner ingin bundling Villa + Jeep.
   - *Mitigasi*: 
     - Skema `jeep_trip_bookings` dibuat cukup fleksibel.
     - Pertimbangkan ke depan membuat `order` global yang bisa punya beberapa tipe item (villa, jeep, dll.).

---

## 9. Kriteria Selesai (Definition of Done)

1. **Admin:**
   - Bisa membuat paket Jeep lengkap dengan destinasi, include/exclude, foto.
   - Bisa membuat slot & mengatur quota per tanggal.
2. **Frontend:**
   - `/jeeptrip` listing paket Jeep.
   - `/jeeptrip/{slug}` detail + pilih tanggal & slot + hitung harga.
3. **Booking:**
   - User bisa booking Jeep, quota berkurang sesuai `jumlah_jeep`.
   - Status booking berubah otomatis setelah pembayaran sukses (via callback).
4. **QA:**
   - Test kasus:
     - Booking normal.
     - Quota habis.
     - Pembayaran gagal.
     - Concurrency test minimal (2 user booking quota terakhir).
