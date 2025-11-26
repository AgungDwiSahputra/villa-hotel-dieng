# Dokumentasi Struktur Database

**Proyek**: Sistem Manajemen Villa Hotel Dieng
**Mesin Database**: MySQL 8.0+ / MariaDB
**ORM**: Laravel Eloquent
**Terakhir Diperbarui**: November 2025

---

## 📋 Ringkasan

Dokumentasi ini menyediakan dokumentasi komprehensif untuk struktur database Villa Hotel Dieng. Database ini dirancang untuk mendukung sistem manajemen villa/hotel lengkap dengan kemampuan pemesanan, pembayaran, promosi, manajemen pengguna, serta Jeep Trip.

---

## 🗂️ Ringkasan Database

```
Total Tabel:        38 tabel
Tabel Bisnis Inti:  28 tabel (termasuk 9 tabel Jeep Trip)
Tabel Sistem Laravel: 10 tabel
Total Relasi:       50+ relasi
Soft Deletes:       3 tabel (users, produks, promos)
UUID Tables:        9 tabel Jeep Trip (menggunakan UUID sebagai primary key)
```

---

## 📊 Diagram Relasi Entitas (ERD)

**Lokasi**: Direktori root proyek
**Format**: Diagram visual menampilkan semua tabel, field, dan relasi
**Kebijakan Pembaruan**: Pembaruan manual diperlukan saat struktur database berubah

### Kapan Memperbarui ERD:
- ✅ Tabel baru ditambahkan
- ✅ Tabel yang ada dimodifikasi (field ditambah/dihapus)
- ✅ Relasi berubah
- ✅ Indeks atau constraint dimodifikasi
- ✅ Tipe data berubah

---

## 🔐 Tabel Otentikasi & Otorisasi

### 1. users
**Tujuan**: Menyimpan informasi akun pengguna dan kredensial otentikasi

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| name | varchar | Nama lengkap pengguna |
| email | varchar | Alamat email (unik) |
| email_verified_at | timestamp | Timestamp verifikasi email |
| password | varchar | Kata sandi yang di-hash |
| no_hp | varchar | Nomor telepon |
| role | varchar | Identifier peran pengguna |
| remember_token | varchar | Token remember me |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan terakhir |
| deleted_at | timestamp | Timestamp soft delete |

**Relasi**:
- Memiliki banyak: transaksis, availabilities, logs
- Dimiliki oleh banyak: roles (via model_has_roles)

**Indeks**:
- PRIMARY KEY (id)
- UNIQUE (email)

---

### 2. roles
**Tujuan**: Mendefinisikan peran pengguna (Super Admin, Admin, Customer)

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| name | varchar | Nama peran |
| guard_name | varchar | Nama guard (web/api) |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh banyak: permissions (via role_has_permissions)
- Dimiliki oleh banyak: users (via model_has_roles)

---

### 3. permissions
**Tujuan**: Menyimpan definisi izin granular

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| name | varchar | Nama izin |
| guard_name | varchar | Nama guard (web/api) |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh banyak: roles (via role_has_permissions)

---

### 4. model_has_permissions
**Tujuan**: Penugasan izin pengguna langsung (polimorfik)

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| permission_id | bigint | Foreign key ke permissions |
| model_type | varchar | Nama class model |
| model_id | bigint | ID model |

**Kunci Komposit**: (permission_id, model_id, model_type)

---

### 5. model_has_roles
**Tujuan**: Penugasan peran pengguna (polimorfik)

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| role_id | bigint | Foreign key ke roles |
| model_type | varchar | Nama class model |
| model_id | bigint | ID model |

**Kunci Komposit**: (role_id, model_id, model_type)

---

### 6. role_has_permissions
**Tujuan**: Memetakan izin ke peran

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| permission_id | bigint | Foreign key ke permissions |
| role_id | bigint | Foreign key ke roles |

**Kunci Komposit**: (permission_id, role_id)

---

## 🏠 Tabel Manajemen Produk (Villa/Property)

### 7. produks
**Tujuan**: Informasi produk/villa utama

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| category_id | bigint | Foreign key ke categories |
| owner | varchar | Nama pemilik properti |
| name | varchar | Nama villa/produk |
| slug | varchar | Slug URL-friendly |
| unit | int | Jumlah unit tersedia |
| orang | int | Kapasitas tamu |
| maks_orang | int | Kapasitas maksimal tamu |
| lokasi | varchar | Lokasi/alamat |
| fasilitas | text | Deskripsi fasilitas |
| kamar | int | Jumlah kamar |
| rating | decimal | Rating produk |
| status | varchar | Status (publish/draft) |
| has_active_promo | boolean | Flag promo aktif |
| promo_price_weekday | decimal | Harga promo hari kerja |
| promo_price_weekend | decimal | Harga promo akhir pekan |
| promo_discount_type | varchar | Tipe diskon promo |
| promo_discount_percentage | decimal | Persentase diskon promo |
| promo_calculated_at | timestamp | Waktu kalkulasi promo |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |
| deleted_at | timestamp | Timestamp soft delete |

**Relasi**:
- Dimiliki oleh: produk_categories
- Memiliki banyak: produk_images, produk_fasilitas, produk_syarat, produk_wisata
- Memiliki banyak: availabilities, transaksi_details, promo_products

**Indeks**:
- PRIMARY KEY (id)
- INDEX (category_id)
- UNIQUE (slug)

---

### 8. produk_categories
**Tujuan**: Mengkategorikan produk (Villa, Kamar Hotel, dll.)

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| name | varchar | Nama kategori |
| slug | varchar | Slug URL-friendly |
| urutan | int | Urutan tampilan |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Memiliki banyak: produks

---

### 9. produk_fasilitas
**Tujuan**: Menyimpan fasilitas villa (WiFi, AC, Dapur, dll.)

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| produk_id | bigint | Foreign key ke produks |
| name | varchar | Nama fasilitas |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: produks

---

### 10. produk_images
**Tujuan**: Galeri gambar produk

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| produk_id | bigint | Foreign key ke produks |
| name | varchar | Nama/judul gambar |
| image | varchar | Path file gambar |
| urutan | int | Urutan tampilan |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: produks

---

### 11. produk_syarat
**Tujuan**: Syarat dan ketentuan untuk penyewaan properti

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| produk_id | bigint | Foreign key ke produks |
| name | varchar | Deskripsi syarat/ketentuan |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: produks

---

### 12. produk_wisata
**Tujuan**: Atraksi wisata terdekat

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| produk_id | bigint | Foreign key ke produks |
| name | varchar | Nama atraksi |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: produks

---

### 13. availabilities
**Tujuan**: Kalender ketersediaan produk

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| produk_id | bigint | Foreign key ke produks |
| date | date | Tanggal ketersediaan |
| is_available | boolean | Status ketersediaan |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: produks

**Indeks**:
- PRIMARY KEY (id)
- INDEX (produk_id, date)

---

## 🎁 Tabel Manajemen Promosi

### 14. promos
**Tujuan**: Manajemen promosi dan diskon

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| name | varchar | Nama promo |
| description | text | Deskripsi promo |
| discount_type | varchar | Tipe (persentase/fixed) |
| discount_value | decimal | Jumlah diskon/persentase |
| start_date | date | Tanggal mulai promo |
| end_date | date | Tanggal akhir promo |
| is_active | boolean | Status aktif |
| usage_limit | int | Batas maksimal penggunaan |
| usage_count | int | Jumlah penggunaan saat ini |
| target_type | varchar | Target (semua/kategori/produk) |
| promo_code | varchar | Kode promo |
| metadata | json | Metadata tambahan |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |
| deleted_at | timestamp | Timestamp soft delete |

**Relasi**:
- Memiliki banyak: promo_categories, promo_products

**Indeks**:
- PRIMARY KEY (id)
- UNIQUE (promo_code)

---

### 15. promo_categories
**Tujuan**: Penugasan promo berbasis kategori

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| promo_id | bigint | Foreign key ke promos |
| category_id | bigint | Foreign key ke categories |
| discount_type | varchar | Override tipe diskon |
| discount_value | decimal | Override nilai diskon |
| embed | boolean | Flag embed |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: promos, produk_categories

---

### 16. promo_products
**Tujuan**: Penugasan promo spesifik produk

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| promo_id | bigint | Foreign key ke promos |
| produk_id | bigint | Foreign key ke produks |
| discount_type | varchar | Override tipe diskon |
| discount_value | decimal | Override nilai diskon |
| embed | boolean | Flag embed |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: promos, produks

---

## 💳 Tabel Transaksi & Pemesanan

### 17. transaksis
**Tujuan**: Catatan pemesanan dan reservasi

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| user_id | bigint | Foreign key ke users (nullable) |
| produk_id | bigint | Foreign key ke produks |
| start_date | date | Tanggal mulai pemesanan |
| end_date | date | Tanggal akhir pemesanan |
| night | int | Jumlah malam |
| total | decimal | Jumlah total |
| email | varchar | Email pelanggan |
| no_wa | varchar | Nomor WhatsApp |
| metadata | json | Metadata tambahan |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: users, produks
- Memiliki banyak: transaksi_details

**Indeks**:
- PRIMARY KEY (id)
- INDEX (user_id)
- INDEX (produk_id)
- INDEX (start_date, end_date)

---

### 18. transaksi_details
**Tujuan**: Item baris transaksi dan breakdown harian

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| transaksi_id | bigint | Foreign key ke transaksis |
| produk_id | bigint | Foreign key ke produks |
| date | date | Tanggal pemesanan |
| unit | int | Jumlah unit |
| status | varchar | Status ('PENDING','APPROVED','REJECTED') |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: transaksis, produks

**Indeks**:
- PRIMARY KEY (id)
- INDEX (transaksi_id)
- INDEX (produk_id, date)

---

## 💰 Tabel Pembayaran & Finansial

### 19. rekenings
**Tujuan**: Informasi rekening bank untuk pembayaran

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| name | varchar | Nama rekening bank |
| image | varchar | Path logo/gambar bank |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

---


## 🚙 Tabel Manajemen Jeep Trip

### 30. jeep_trips
**Tujuan**: Informasi paket Jeep Trip utama - Master data untuk semua paket perjalanan jeep

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | char(36) | Kunci primer UUID |
| kode | varchar(50) | Kode paket internal (unik, nullable) |
| slug | varchar(150) | Slug URL-friendly (unik) |
| nama_paket | varchar(150) | Nama paket Jeep Trip |
| deskripsi_singkat | text | Deskripsi singkat untuk listing (nullable) |
| deskripsi_lengkap | longtext | Deskripsi detail dengan HTML (nullable) |
| zona | varchar(50) | Zona operasi (sunrise, favorit, dll.) |
| durasi_jam | int unsigned | Durasi trip dalam jam (nullable) |
| jam_berangkat_default | time | Jam berangkat default (nullable) |
| kapasitas_ideal_per_jeep | int unsigned | Kapasitas ideal per jeep (default 4) |
| kapasitas_max_per_jeep | int unsigned | Kapasitas maksimal per jeep (default 4) |
| harga_weekday | decimal(15,2) | Harga hari kerja (Senin-Jumat) |
| harga_weekend | decimal(15,2) | Harga akhir pekan (Sabtu-Minggu) |
| rating | decimal(3,2) | Rating rata-rata paket (nullable) |
| is_active | tinyint(1) | Status aktif/nonaktif (default 1) |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Memiliki banyak: jeep_trip_destinations, jeep_trip_includes, jeep_trip_excludes, jeep_trip_slots, jeep_trip_images, jeep_trip_booking_items
- Berelasi dengan: jeep_trip_slots (one-to-many), jeep_trip_booking_items (one-to-many)

**Indeks**:
- PRIMARY KEY (id)
- UNIQUE KEY (kode)
- UNIQUE KEY (slug)
- INDEX (is_active) - untuk filtering paket aktif
- INDEX (zona) - untuk filtering berdasarkan zona
- INDEX (harga_weekday, harga_weekend) - untuk sorting harga

**Business Logic**:
- UUID sebagai primary key untuk keamanan dan distributed systems
- Soft delete tidak diterapkan (paket di-nonaktifkan via is_active)
- Harga dinamis berdasarkan weekday/weekend
- Rating dihitung dari feedback customer (future feature)

---

### 31. jeep_trip_destinations
**Tujuan**: Destinasi kunjungan dalam paket Jeep Trip

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | uuid | Kunci primer |
| jeep_trip_id | uuid | Foreign key ke jeep_trips |
| nama_destinasi | varchar(150) | Nama destinasi |
| urutan | int unsigned | Urutan tampilan (default 1) |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: jeep_trips

---

### 32. jeep_trip_includes
**Tujuan**: Fasilitas yang termasuk dalam paket

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | uuid | Kunci primer |
| jeep_trip_id | uuid | Foreign key ke jeep_trips |
| nama_item | varchar(150) | Nama item fasilitas |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: jeep_trips

---

### 33. jeep_trip_excludes
**Tujuan**: Fasilitas yang tidak termasuk dalam paket

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | uuid | Kunci primer |
| jeep_trip_id | uuid | Foreign key ke jeep_trips |
| nama_item | varchar(150) | Nama item fasilitas |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: jeep_trips

---

### 34. jeep_trip_slots
**Tujuan**: Slot waktu untuk Jeep Trip

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | uuid | Kunci primer |
| jeep_trip_id | uuid | Foreign key ke jeep_trips |
| nama_slot | varchar(100) | Nama slot (e.g. Pagi, Siang) |
| jam_mulai | time | Jam mulai slot |
| jam_selesai | time | Jam selesai slot |
| is_active | boolean | Status aktif (default true) |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: jeep_trips
- Memiliki banyak: jeep_trip_availabilities, jeep_trip_booking_items

**Indeks**:
- FOREIGN KEY (jeep_trip_id) cascade

---

### 35. jeep_trip_images
**Tujuan**: Galeri gambar Jeep Trip

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | uuid | Kunci primer |
| jeep_trip_id | uuid | Foreign key ke jeep_trips |
| image_path | varchar(255) | Path gambar |
| judul | varchar(150) | Judul gambar (nullable) |
| urutan | int unsigned | Urutan tampilan (default 1) |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: jeep_trips

---

### 36. jeep_trip_bookings
**Tujuan**: Header pemesanan Jeep Trip - Mengelola status dan total booking

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | char(36) | Kunci primer UUID |
| user_id | bigint unsigned | Foreign key ke users (nullable untuk guest booking) |
| kode_booking | varchar(50) | Kode booking unik (format: JT-{uniqid}) |
| total_harga | decimal(15,2) | Total harga semua item |
| status | enum('draft','pending','paid','cancelled','expired','done') | Status booking |
| payment_ref | varchar(100) | Referensi pembayaran Midtrans (nullable) |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: users (nullable)
- Memiliki banyak: jeep_trip_booking_items
- Berelasi dengan: transaksis (future integration)

**Indeks**:
- PRIMARY KEY (id)
- UNIQUE KEY (kode_booking)
- INDEX (user_id) - untuk filtering booking per user
- INDEX (status) - untuk filtering status booking
- INDEX (created_at) - untuk sorting booking terbaru
- FOREIGN KEY (user_id) REFERENCES users(id)

**Business Logic**:
- Kode booking generated otomatis dengan prefix 'JT-'
- Status flow: draft → pending → paid/cancelled/expired → done
- Guest booking diizinkan (user_id nullable)
- Payment reference untuk integrasi Midtrans
- Soft delete tidak diterapkan untuk audit trail

---

### 37. jeep_trip_booking_items
**Tujuan**: Detail item dalam pemesanan Jeep Trip

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | uuid | Kunci primer |
| jeep_trip_booking_id | uuid | Foreign key ke jeep_trip_bookings |
| jeep_trip_id | uuid | Foreign key ke jeep_trips |
| jeep_trip_slot_id | uuid | Foreign key ke jeep_trip_slots |
| tanggal_trip | date | Tanggal trip |
| jumlah_jeep | int unsigned | Jumlah jeep |
| harga_satuan | decimal(15,2) | Harga per jeep |
| subtotal | decimal(15,2) | Subtotal |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: jeep_trip_bookings, jeep_trips, jeep_trip_slots

---

### 38. jeep_trip_availabilities
**Tujuan**: Sistem ketersediaan dan quota Jeep Trip - Core business logic untuk availability management

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | char(36) | Kunci primer UUID |
| jeep_trip_slot_id | char(36) | Foreign key ke jeep_trip_slots |
| tanggal | date | Tanggal ketersediaan |
| quota_jeep | int unsigned | Total kuota jeep untuk slot/tanggal ini |
| quota_terpakai | int unsigned | Jumlah jeep yang sudah dipesan (default 0) |
| is_closed | tinyint(1) | Flag untuk menutup slot (default 0) |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Relasi**:
- Dimiliki oleh: jeep_trip_slots
- Berelasi dengan: jeep_trip_booking_items (via jeep_trip_slot_id)

**Indeks**:
- PRIMARY KEY (id)
- UNIQUE KEY (jeep_trip_slot_id, tanggal) - mencegah duplikasi slot per tanggal
- INDEX (tanggal) - untuk filtering availability per tanggal
- INDEX (is_closed) - untuk filtering slot aktif
- INDEX (quota_jeep, quota_terpakai) - untuk kalkulasi ketersediaan cepat
- FOREIGN KEY (jeep_trip_slot_id) REFERENCES jeep_trip_slots(id) ON DELETE CASCADE

**Business Logic**:
- **Atomic Operations**: Menggunakan `increment('quota_terpakai')` untuk mencegah race condition
- **Availability Formula**: `quota_tersedia = quota_jeep - quota_terpakai`
- **Status Logic**: Slot dianggap tidak tersedia jika `is_closed = true` OR `quota_terpakai >= quota_jeep`
- **Constraint Check**: Booking hanya diizinkan jika `quota_jeep - quota_terpakai >= jumlah_jeep_dipesan`
- **Recovery Mechanism**: Quota dikembalikan otomatis jika pembayaran gagal/dibatalkan
- **Admin Control**: Admin dapat menutup slot kapan saja via `is_closed` flag

---
## ⚙️ Tabel Konfigurasi Sistem

### 20. settings
**Tujuan**: Pengaturan aplikasi dan konfigurasi situs

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| key | varchar | Kunci pengaturan (unik) |
| value | text | Nilai pengaturan |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Indeks**:
- PRIMARY KEY (id)
- UNIQUE (key)

---

### 21. logs
**Tujuan**: Logging aktivitas dan audit trail

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| log_date | timestamp | Timestamp log |
| table_name | varchar | Nama tabel yang terpengaruh |
| log_type | varchar | Tipe log (create/update/delete) |
| data | text | Data log (JSON) |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Indeks**:
- PRIMARY KEY (id)
- INDEX (log_date)
- INDEX (table_name)

---

## 🔧 Tabel Sistem Laravel

### 22. cache
**Tujuan**: Penyimpanan cache Laravel

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| key | varchar | Kunci cache (primer) |
| value | mediumtext | Nilai yang di-cache |
| expiration | int | Timestamp kedaluwarsa |

---

### 23. cache_locks
**Tujuan**: Mekanisme penguncian cache

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| key | varchar | Kunci penguncian (primer) |
| owner | varchar | Pemilik penguncian |
| expiration | int | Kedaluwarsa penguncian |

---

### 24. migrations
**Tujuan**: Pelacakan migrasi database

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | int | Kunci primer |
| migration | varchar | Nama file migrasi |
| batch | int | Batch migrasi |

---

### 25. password_reset_tokens
**Tujuan**: Penyimpanan token reset kata sandi

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| email | varchar | Email pengguna (primer) |
| token | varchar | Token reset |
| created_at | timestamp | Timestamp pembuatan |

---

### 26. sessions
**Tujuan**: Data sesi pengguna

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | varchar | ID sesi (primer) |
| user_id | bigint | ID pengguna (nullable) |
| ip_address | varchar | Alamat IP klien |
| user_agent | text | User agent klien |
| payload | longtext | Payload sesi |
| last_activity | int | Timestamp aktivitas terakhir |

**Indeks**:
- PRIMARY KEY (id)
- INDEX (user_id)
- INDEX (last_activity)

---

### 27. personal_access_tokens
**Tujuan**: Token API Laravel Sanctum

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| tokenable_type | varchar | Tipe model tokenable |
| tokenable_id | bigint | ID model tokenable |
| name | varchar | Nama token |
| token | varchar | Hash token (unik) |
| abilities | text | Kemampuan token (JSON) |
| last_used_at | timestamp | Timestamp penggunaan terakhir |
| expires_at | timestamp | Timestamp kedaluwarsa |
| created_at | timestamp | Timestamp pembuatan |
| updated_at | timestamp | Timestamp pembaruan |

**Indeks**:
- PRIMARY KEY (id)
- INDEX (tokenable_type, tokenable_id)
- UNIQUE (token)

---

### 28. job_batches
**Tujuan**: Pelacakan batch job

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | varchar | ID batch (primer) |
| name | varchar | Nama batch |
| total_jobs | int | Total job dalam batch |
| pending_jobs | int | Jumlah job pending |
| failed_jobs | int | Jumlah job gagal |
| failed_job_ids | longtext | ID job gagal |
| options | mediumtext | Opsi batch |
| cancelled_at | int | Timestamp pembatalan |
| created_at | int | Timestamp pembuatan |
| finished_at | int | Timestamp selesai |

---

### 29. failed_jobs
**Tujuan**: Catatan job queue yang gagal

| Field | Tipe | Deskripsi |
|-------|------|-------------|
| id | bigint | Kunci primer |
| uuid | varchar | UUID job (unik) |
| connection | text | Koneksi queue |
| queue | text | Nama queue |
| payload | longtext | Payload job |
| exception | longtext | Detail exception |
| failed_at | timestamp | Timestamp kegagalan |

**Indeks**:
- PRIMARY KEY (id)
- UNIQUE (uuid)

---

## 🔗 Ringkasan Relasi Kunci

### Relasi One-to-Many
```
users → transaksis
users → availabilities
users → logs
produks → produk_images
produks → produk_fasilitas
produks → produk_syarat
produks → produk_wisata
produks → availabilities
produks → transaksi_details
produks → promo_products
produk_categories → produks
promos → promo_categories
promos → promo_products
transaksis → transaksi_details

// Jeep Trip Relations
jeep_trips → jeep_trip_destinations (ordered by urutan)
jeep_trips → jeep_trip_includes
jeep_trips → jeep_trip_excludes
jeep_trips → jeep_trip_slots
jeep_trips → jeep_trip_images (ordered by urutan)
jeep_trips → jeep_trip_booking_items
jeep_trip_slots → jeep_trip_availabilities
jeep_trip_slots → jeep_trip_booking_items
jeep_trip_bookings → jeep_trip_booking_items
users → jeep_trip_bookings (nullable for guest bookings)
```

### Relasi Many-to-Many
```
users ↔ roles (via model_has_roles)
roles ↔ permissions (via role_has_permissions)
promos ↔ produk_categories (via promo_categories)
promos ↔ produks (via promo_products)
```

### Relasi Polimorfik
```
permissions → * (via model_has_permissions)
roles → * (via model_has_roles)
personal_access_tokens → * (tokenable)
```

---

## 🗑️ Soft Deletes

Tabel dengan kemampuan soft delete (kolom deleted_at):
1. **users** - Mempertahankan data pengguna untuk tujuan audit
2. **produks** - Mempertahankan riwayat produk
3. **promos** - Menyimpan catatan promo untuk pelaporan

**Manfaat**: Data dapat dipulihkan jika dihapus secara tidak sengaja

---

## 📅 Timestamp

Semua tabel menyertakan kolom `created_at` dan `updated_at` untuk:
- Pelacakan audit
- Kontrol versi
- Sinkronisasi data
- Pelaporan dan analitik

---

## 🔍 Indeks Penting

### Indeks Kritis Performa:
- `users.email` (UNIQUE) - Pencarian login cepat
- `produks.slug` (UNIQUE) - Pencarian produk cepat
- `availabilities (produk_id, date)` - Pemeriksaan ketersediaan cepat
- `transaksi_details (produk_id, date)` - Pencarian pemesanan cepat
- `promos.promo_code` (UNIQUE) - Validasi promo cepat
- `sessions (user_id, last_activity)` - Manajemen sesi

### Indeks Jeep Trip (Critical untuk Availability):
- `jeep_trips.slug` (UNIQUE) - Pencarian paket Jeep Trip cepat
- `jeep_trips.is_active` - Filtering paket aktif
- `jeep_trips.zona` - Filtering berdasarkan zona operasi
- `jeep_trips (harga_weekday, harga_weekend)` - Sorting harga
- `jeep_trip_slots.jeep_trip_id` - Relasi slot ke paket
- `jeep_trip_availabilities (jeep_trip_slot_id, tanggal)` (UNIQUE) - Pemeriksaan ketersediaan slot cepat
- `jeep_trip_availabilities.tanggal` - Filtering availability per tanggal
- `jeep_trip_availabilities.is_closed` - Filtering slot aktif
- `jeep_trip_availabilities (quota_jeep, quota_terpakai)` - Kalkulasi ketersediaan cepat
- `jeep_trip_bookings.kode_booking` (UNIQUE) - Validasi booking cepat
- `jeep_trip_bookings (user_id, status)` - Filtering booking per user
- `jeep_trip_bookings.created_at` - Sorting booking terbaru
- `jeep_trip_booking_items (jeep_trip_slot_id, tanggal_trip)` - Pencarian booking per slot/tanggal

---

## 🛠️ Pemeliharaan Database

### Tugas Reguler:
1. **Backup**: Backup otomatis harian
2. **Optimasi**: Optimasi tabel mingguan
3. **Analisis Indeks**: Tinjauan performa indeks bulanan
4. **Pembersihan Data**: Pembersihan reguler sesi lama, cache, log
5. **Manajemen Migrasi**: Perubahan skema berversi

### Perintah Migrasi:
```bash
# Jalankan semua migrasi
php artisan migrate

# Rollback migrasi terakhir
php artisan migrate:rollback

# Reset dan jalankan ulang semua migrasi
php artisan migrate:fresh

# Jalankan dengan seeder
php artisan migrate:fresh --seed
```

---

## 📊 Statistik Database

```
Ukuran Baris Rata-rata: ~2KB per produk/villa, ~1.5KB per jeep trip record
Kebutuhan Penyimpanan: ~50MB per 1000 produk + ~20MB per 100 jeep trip bookings
Pertumbuhan Diharapkan: ~150MB per tahun (dengan Jeep Trip)
Indeks Direkomendasikan: 25+ indeks covering (termasuk Jeep Trip)
Performa Query: <100ms untuk 95% query, <50ms untuk availability checks
Concurrent Users: Optimized untuk 100+ simultaneous bookings
Race Condition Protection: Atomic operations pada availability updates
```

---

## 🔐 Pertimbangan Keamanan

1. **Hashing Kata Sandi**: bcrypt dengan faktor biaya 10
2. **SQL Injection**: Dilindungi via ORM Eloquent
3. **Mass Assignment**: Dilindungi via $fillable/$guarded
4. **Data Sensitif**: Token API di-hash, kata sandi dienkripsi
5. **Kontrol Akses**: Keamanan tingkat baris via policies

---

## 📝 Catatan untuk Developer

### Saat Menambahkan Tabel Baru:
1. Buat file migrasi dengan konvensi penamaan Laravel
2. Definisikan model Eloquent dengan proper relationships
3. Tambahkan relasi dan foreign key constraints
4. Perbarui dokumentasi ini dengan detail field dan business logic
5. **Perbarui diagram ERD secara manual**
6. Tambahkan seeder untuk data awal
7. Buat unit/feature tests untuk logic kompleks
8. Uji migrasi di environment staging

### Development Jeep Trip:
1. **UUID Primary Keys**: Gunakan `char(36)` untuk UUID fields
2. **Atomic Availability**: Selalu gunakan `increment()` untuk quota updates
3. **Session Management**: Implement expiry untuk draft bookings (30 menit)
4. **Race Condition**: Test concurrent booking scenarios
5. **Midtrans Integration**: Validate signatures dan handle callbacks properly
6. **Admin Interface**: Buat UI untuk availability management (missing feature)

### Praktik Terbaik:
- Gunakan nama kolom deskriptif dan konsisten
- Tambahkan constraint foreign key dengan cascade rules
- Sertakan indeks untuk kolom pencarian frekuent
- Gunakan tipe data yang sesuai (decimal untuk harga, tinyint untuk boolean)
- Tambahkan komentar untuk field dengan business logic kompleks
- Pertahankan integritas referensial dengan proper constraints
- Implement soft deletes untuk data sensitif
- Gunakan UUID untuk distributed systems compatibility

---

## 📞 Dukungan

Untuk pertanyaan terkait database:
1. Periksa file migrasi di `database/migrations/`
2. Tinjau definisi model di `app/Models/`
3. Konsultasikan diagram ERD untuk referensi visual
4. Periksa dokumentasi ini

---

**Versi Dokumen**: 1.2
**Terakhir Diperbarui**: November 2025
**Status**: ✅ Lengkap & Terkini (termasuk Jeep Trip)
**Status ERD**: ⚠️ Pembaruan manual diperlukan saat perubahan skema
**Jeep Trip Integration**: ✅ Fully documented dengan business logic