# Script Testing Filter Pencarian Lanjutan

**Tujuan:** Memverifikasi bahwa semua filter pencarian lanjutan berfungsi dengan benar setelah perbaikan.

---

## 🧪 Testing via Browser (Manual)

### 1. Akses Halaman All Products
```
URL: http://localhost/all-produk
atau: http://your-domain.com/all-produk
```

### 2. Test Filter Rentang Harga

**Test Case 1: Harga Rp 0 - 500.000**
- Pilih filter "Rp 0 - 500.000"
- Klik "Terapkan Filter"
- **Expected:** Hanya menampilkan villa dengan `harga_weekday` antara 0 - 500.000
- **URL:** `?price_range=0-500000`

**Test Case 2: Harga Rp 500.000 - 1.000.000**
- Pilih filter "Rp 500.000 - 1.000.000"
- Klik "Terapkan Filter"
- **Expected:** Hanya menampilkan villa dengan `harga_weekday` antara 500.000 - 1.000.000
- **URL:** `?price_range=500000-1000000`

**Test Case 3: Harga Di atas Rp 2.000.000**
- Pilih filter "Di atas Rp 2.000.000"
- Klik "Terapkan Filter"
- **Expected:** Hanya menampilkan villa dengan `harga_weekday` > 2.000.000
- **URL:** `?price_range=2000000+`

---

### 3. Test Filter Kapasitas

**Test Case 1: Kapasitas 1-2 Orang**
- Pilih filter "1-2 Orang"
- Klik "Terapkan Filter"
- **Expected:** Menampilkan villa dengan `maks_orang` antara 1-2
- **URL:** `?capacity=1-2`
- **Verify:** Cek detail villa, kapasitas harus 1-2 orang

**Test Case 2: Kapasitas 5-8 Orang**
- Pilih filter "5-8 Orang"
- Klik "Terapkan Filter"
- **Expected:** Menampilkan villa dengan `maks_orang` antara 5-8
- **URL:** `?capacity=5-8`

**Test Case 3: Kapasitas 9+ Orang**
- Pilih filter "9+ Orang"
- Klik "Terapkan Filter"
- **Expected:** Menampilkan villa dengan `maks_orang` >= 9
- **URL:** `?capacity=9%2B`

---

### 4. Test Filter Jumlah Kamar

**Test Case 1: 1 Kamar**
- Pilih filter "1 Kamar"
- Klik "Terapkan Filter"
- **Expected:** Menampilkan villa dengan `kamar` = 1
- **URL:** `?rooms=1`

**Test Case 2: 2 Kamar**
- Pilih filter "2 Kamar"
- Klik "Terapkan Filter"
- **Expected:** Menampilkan villa dengan `kamar` = 2
- **URL:** `?rooms=2`

**Test Case 3: 4+ Kamar**
- Pilih filter "4+ Kamar"
- Klik "Terapkan Filter"
- **Expected:** Menampilkan villa dengan `kamar` >= 4
- **URL:** `?rooms=4%2B`

---

### 5. Test Filter Dekat Wisata

**Test Case 1: Candi Arjuna**
- Pilih filter "Candi Arjuna"
- Klik "Terapkan Filter"
- **Expected:** Menampilkan villa yang memiliki kata "candi" atau "arjuna" di kolom `lokasi` atau `label`
- **URL:** `?attractions=candi-arjuna`

**Test Case 2: Kawah Sikidang**
- Pilih filter "Kawah Sikidang"
- Klik "Terapkan Filter"
- **Expected:** Menampilkan villa yang memiliki kata "kawah" atau "sikidang" di kolom `lokasi` atau `label`
- **URL:** `?attractions=kawah-sikidang`

**Test Case 3: Telaga Warna**
- Pilih filter "Telaga Warna"
- Klik "Terapkan Filter"
- **Expected:** Menampilkan villa yang memiliki kata "telaga" atau "warna" di kolom `lokasi` atau `label`
- **URL:** `?attractions=telaga-warna`

---

### 6. Test Sorting

**Test Case 1: Sort by Harga Terendah**
- Pilih sort "Harga Terendah"
- Klik "Terapkan Filter"
- **Expected:** Villa diurutkan dari harga terendah ke tertinggi
- **URL:** `?sort=price-low`
- **Verify:** Villa pertama harus memiliki harga paling rendah

**Test Case 2: Sort by Harga Tertinggi**
- Pilih sort "Harga Tertinggi"
- Klik "Terapkan Filter"
- **Expected:** Villa diurutkan dari harga tertinggi ke terendah
- **URL:** `?sort=price-high`
- **Verify:** Villa pertama harus memiliki harga paling tinggi

**Test Case 3: Sort by Rating Tertinggi** ⭐ **(BARU)**
- Pilih sort "Rating Tertinggi"
- Klik "Terapkan Filter"
- **Expected:** Villa diurutkan dari rating tertinggi ke terendah
- **URL:** `?sort=rating`
- **Verify:** Villa pertama harus memiliki rating paling tinggi (5.0, 4.7, dst)

**Test Case 4: Sort by Nama A-Z**
- Pilih sort "Nama A-Z"
- Klik "Terapkan Filter"
- **Expected:** Villa diurutkan alfabetis A ke Z
- **URL:** `?sort=name`
- **Verify:** Villa diurutkan berdasarkan nama

---

### 7. Test Kombinasi Multiple Filter

**Test Case 1: Harga + Kapasitas**
- Pilih "Rp 500.000 - 1.000.000"
- Pilih "5-8 Orang"
- Klik "Terapkan Filter"
- **Expected:** Villa dengan harga 500K-1M DAN kapasitas 5-8 orang
- **URL:** `?price_range=500000-1000000&capacity=5-8`

**Test Case 2: Kamar + Wisata + Sort**
- Pilih "2 Kamar"
- Pilih "Candi Arjuna"
- Pilih sort "Harga Terendah"
- Klik "Terapkan Filter"
- **Expected:** Villa 2 kamar dekat Candi Arjuna, diurutkan harga terendah
- **URL:** `?rooms=2&attractions=candi-arjuna&sort=price-low`

**Test Case 3: All Filters**
- Pilih semua filter yang tersedia
- Klik "Terapkan Filter"
- **Expected:** Villa yang memenuhi SEMUA kriteria filter
- **URL:** `?price_range=...&capacity=...&rooms=...&attractions=...&sort=...`

---

### 8. Test Reset Filter

**Test Case 1: Reset Semua**
- Terapkan beberapa filter
- Klik "Reset Semua"
- **Expected:** Semua filter dihapus, kembali ke tampilan default
- **URL:** `/all-produk` (tanpa parameter)

**Test Case 2: Reset Kategori**
- Pilih kategori tertentu
- Klik "Reset Kategori"
- **Expected:** Filter kategori dihapus, filter lain tetap aktif
- **URL:** Parameter `category` dihapus dari URL

---

## 🗄️ Testing via Database Query

### Setup MySQL Connection
```bash
mysql -u root -p u693357708_vilahoteldieng
```

### Test Query 1: Verifikasi Kolom Rating Ada
```sql
DESCRIBE produks;
```
**Expected Output:** Harus ada kolom `rating` dengan tipe `decimal(3,2)`

### Test Query 2: Cek Data Rating
```sql
SELECT name, rating, kamar, maks_orang, harga_weekday 
FROM produks 
ORDER BY rating DESC;
```
**Expected Output:** Semua produk harus memiliki rating antara 0.00 - 5.00

### Test Query 3: Simulasi Filter Kapasitas (1-2 Orang)
```sql
SELECT name, maks_orang 
FROM produks 
WHERE maks_orang BETWEEN 1 AND 2;
```
**Expected Output:** Produk dengan kapasitas maksimum 1-2 orang

### Test Query 4: Simulasi Filter Kamar (2 Kamar)
```sql
SELECT name, kamar 
FROM produks 
WHERE kamar = 2;
```
**Expected Output:** Produk dengan 2 kamar tidur

### Test Query 5: Simulasi Filter Harga + Sort Rating
```sql
SELECT name, harga_weekday, rating 
FROM produks 
WHERE harga_weekday BETWEEN 500000 AND 1000000 
ORDER BY rating DESC;
```
**Expected Output:** Produk dengan harga 500K-1M, diurutkan rating tertinggi

### Test Query 6: Simulasi Filter Wisata (Candi Arjuna)
```sql
SELECT name, lokasi, label 
FROM produks 
WHERE lokasi LIKE '%candi%' 
   OR lokasi LIKE '%arjuna%' 
   OR label LIKE '%candi%' 
   OR label LIKE '%arjuna%';
```
**Expected Output:** Produk yang lokasinya dekat Candi Arjuna

### Test Query 7: Kombinasi Filter (Kamar + Kapasitas + Harga)
```sql
SELECT name, kamar, maks_orang, harga_weekday, rating 
FROM produks 
WHERE kamar = 2 
  AND maks_orang BETWEEN 5 AND 8 
  AND harga_weekday BETWEEN 500000 AND 1000000 
ORDER BY rating DESC;
```
**Expected Output:** Villa 2 kamar, kapasitas 5-8, harga 500K-1M, urut rating

---

## 🔧 Testing via Laravel Tinker

### Buka Laravel Tinker
```bash
php artisan tinker
```

### Test 1: Cek Kolom Rating di Model
```php
$produk = App\Models\Produk\Produk::first();
echo $produk->rating; // Harus menampilkan angka desimal 0.00 - 5.00
```

### Test 2: Filter Kapasitas
```php
use App\Models\Produk\Produk;

// Filter kapasitas 5-8 orang
$result = Produk::whereBetween('maks_orang', [5, 8])->get(['name', 'maks_orang']);
print_r($result->toArray());
```

### Test 3: Filter Jumlah Kamar
```php
use App\Models\Produk\Produk;

// Filter 2 kamar
$result = Produk::where('kamar', 2)->get(['name', 'kamar']);
print_r($result->toArray());
```

### Test 4: Sort by Rating
```php
use App\Models\Produk\Produk;

// Sort by rating DESC
$result = Produk::orderBy('rating', 'desc')->get(['name', 'rating']);
print_r($result->toArray());
```

### Test 5: Kombinasi Filter
```php
use App\Models\Produk\Produk;

// Kapasitas 5-8 + Kamar 2 + Sort Rating
$result = Produk::whereBetween('maks_orang', [5, 8])
    ->where('kamar', 2)
    ->orderBy('rating', 'desc')
    ->get(['name', 'kamar', 'maks_orang', 'rating']);
print_r($result->toArray());
```

### Test 6: Update Rating Manual
```php
use App\Models\Produk\Produk;

// Update rating produk tertentu
$produk = Produk::where('name', 'Asoka villa')->first();
$produk->rating = 4.8;
$produk->save();
echo "Rating updated to: " . $produk->rating;
```

---

## 📱 Testing via API (Optional)

### Test 1: GET All Products dengan Filter
```bash
# Filter Kapasitas
curl "http://localhost/all-produk?capacity=5-8"

# Filter Kamar
curl "http://localhost/all-produk?rooms=2"

# Filter Harga
curl "http://localhost/all-produk?price_range=500000-1000000"

# Sort by Rating
curl "http://localhost/all-produk?sort=rating"

# Kombinasi
curl "http://localhost/all-produk?capacity=5-8&rooms=2&sort=rating"
```

---

## ✅ Checklist Testing

### Filter Individual
- [ ] ✅ Filter Rentang Harga: 0-500K
- [ ] ✅ Filter Rentang Harga: 500K-1M
- [ ] ✅ Filter Rentang Harga: 1M-2M
- [ ] ✅ Filter Rentang Harga: 2M+
- [ ] ✅ Filter Kapasitas: 1-2 Orang
- [ ] ✅ Filter Kapasitas: 3-4 Orang
- [ ] ✅ Filter Kapasitas: 5-8 Orang
- [ ] ✅ Filter Kapasitas: 9+ Orang
- [ ] ✅ Filter Kamar: 1 Kamar
- [ ] ✅ Filter Kamar: 2 Kamar
- [ ] ✅ Filter Kamar: 3 Kamar
- [ ] ✅ Filter Kamar: 4+ Kamar
- [ ] ✅ Filter Wisata: Candi Arjuna
- [ ] ✅ Filter Wisata: Kawah Sikidang
- [ ] ✅ Filter Wisata: Telaga Warna
- [ ] ✅ Filter Wisata: Bukit Sikunir
- [ ] ✅ Filter Wisata: Dieng Plateau

### Sorting
- [ ] ✅ Sort: Relevansi (default)
- [ ] ✅ Sort: Harga Terendah
- [ ] ✅ Sort: Harga Tertinggi
- [ ] ✅ Sort: Rating Tertinggi ⭐ (BARU)
- [ ] ✅ Sort: Nama A-Z

### Kombinasi Filter
- [ ] ✅ Harga + Kapasitas
- [ ] ✅ Kapasitas + Kamar
- [ ] ✅ Kamar + Wisata
- [ ] ✅ Harga + Sort
- [ ] ✅ Semua Filter + Sort

### Reset & Clear
- [ ] ✅ Reset Semua Filter
- [ ] ✅ Reset Kategori
- [ ] ✅ Reset Promo

### Responsiveness
- [ ] ✅ Mobile View (Filter Toggle)
- [ ] ✅ Tablet View
- [ ] ✅ Desktop View

### Performance
- [ ] ✅ Load Time < 2 detik
- [ ] ✅ Pagination bekerja dengan filter aktif
- [ ] ✅ URL tetap readable dengan multiple filter

---

## 🐛 Known Issues & Solutions

### Issue 1: Filter tidak mengembalikan hasil
**Solusi:** Pastikan produk memiliki data yang sesuai dengan filter
```sql
-- Cek data produk
SELECT name, kamar, maks_orang, rating, harga_weekday FROM produks;
```

### Issue 2: Sort by Rating tidak berubah
**Solusi:** Pastikan semua produk memiliki rating yang berbeda
```bash
php artisan db:seed --class=UpdateProdukRatingSeeder
```

### Issue 3: Filter wisata tidak mengembalikan hasil
**Solusi:** Pastikan kolom `lokasi` atau `label` memiliki keyword wisata
```sql
UPDATE produks SET lokasi = 'Dekat Candi Arjuna' WHERE id = 'xxx';
```

---

## 📊 Expected Results Summary

| Filter/Feature | Status | Kolom Database | Query Method |
|----------------|--------|----------------|--------------|
| Filter Harga | ✅ | `harga_weekday` | `whereBetween()` / `where()` |
| Filter Kapasitas | ✅ | `maks_orang` | `whereBetween()` / `where()` |
| Filter Kamar | ✅ | `kamar` | `where()` |
| Filter Wisata | ✅ | `lokasi`, `label` | `LIKE %keyword%` |
| Sort: Price | ✅ | `harga_weekday` | `orderBy()` |
| Sort: Rating | ✅ | `rating` | `orderBy('rating', 'desc')` |
| Sort: Name | ✅ | `name` | `orderBy('name', 'asc')` |

---

## 🎉 Success Criteria

Filter pencarian lanjutan dianggap **BERHASIL** jika:

1. ✅ Semua filter individual berfungsi dengan benar
2. ✅ Kombinasi multiple filter bekerja tanpa error
3. ✅ Sort by rating mengurutkan dengan benar
4. ✅ Reset filter menghapus semua parameter
5. ✅ URL parameter ter-generate dengan benar
6. ✅ Pagination tetap bekerja dengan filter aktif
7. ✅ Responsive di semua device (mobile/tablet/desktop)
8. ✅ Load time < 2 detik untuk filter query

---

**Testing Date:** _____________  
**Tested By:** _____________  
**Status:** [ ] PASS / [ ] FAIL  
**Notes:** _____________________________________________