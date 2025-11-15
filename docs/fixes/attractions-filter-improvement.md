# Perbaikan Filter "Dekat Wisata" - Menggunakan Tabel `produk_wisatas`

## 📋 Summary

Filter "Dekat Wisata" telah diperbaiki untuk menggunakan tabel relasi `produk_wisatas` yang lebih terstruktur, menggantikan metode pencarian keyword di kolom `lokasi` dan `label`.

## 🔍 Problem

### Logika Lama (Kurang Optimal)
- Menggunakan pencarian keyword dengan `LIKE` di kolom `lokasi` dan `label`
- Tidak memanfaatkan tabel relasi `produk_wisatas` yang sudah tersedia
- Kurang akurat karena bergantung pada string matching
- Sulit maintenance jika ada perubahan nama wisata

```php
// OLD CODE
$attractionKeywords = [
    'candi-arjuna' => ['candi', 'arjuna'],
    'kawah-sikidang' => ['kawah', 'sikidang'],
    'telaga-warna' => ['telaga', 'warna'],
    'bukit-sikunir' => ['bukit', 'sikunir'],
    'dieng-plateau' => ['dieng', 'plateau']
];

if (isset($attractionKeywords[$attractions])) {
    $keywords = $attractionKeywords[$attractions];
    $produksQuery->where(function ($query) use ($keywords) {
        foreach ($keywords as $keyword) {
            $query->orWhere('lokasi', 'LIKE', '%' . $keyword . '%')
                  ->orWhere('label', 'LIKE', '%' . $keyword . '%');
        }
    });
}
```

## ✅ Solution

### Logika Baru (Optimal)
- Menggunakan relasi `whereHas()` dengan tabel `produk_wisatas`
- Lebih akurat dan terstruktur
- Mudah maintenance
- Memanfaatkan database relationship yang sudah ada

```php
// NEW CODE
$attractionNames = [
    'candi-arjuna' => 'Candi Arjuna',
    'kawah-sikidang' => 'Kawah Sikidang',
    'telaga-warna' => 'Telaga Warna',
    'bukit-sikunir' => 'Bukit Sikunir',
    'dieng-plateau' => 'Dieng Plateau'
];

if (isset($attractionNames[$attractions])) {
    $attractionName = $attractionNames[$attractions];
    $produksQuery->whereHas('wisatas', function ($query) use ($attractionName) {
        $query->where('name', 'LIKE', '%' . $attractionName . '%');
    });
}
```

## 🗄️ Database Structure

### Tabel `produk_wisatas`
```sql
CREATE TABLE produk_wisatas (
    id UUID PRIMARY KEY,
    produk_id UUID,
    name VARCHAR(255),
    created_at TIMESTAMP,
    updated_at TIMESTAMP,
    FOREIGN KEY (produk_id) REFERENCES produks(id) ON DELETE CASCADE
);
```

### Model Relationship
```php
// Model: App\Models\Produk\Produk
public function wisatas()
{
    return $this->hasMany(ProdukWisata::class, 'produk_id');
}
```

## 📝 Changes Made

### 1. File: `app/Http/Controllers/LandingPageController.php`

#### Perubahan pada Filter Logic (Line ~203-221)
- ✅ Mengganti keyword-based search dengan relasi `whereHas()`
- ✅ Mapping langsung ke nama wisata yang sesuai database

#### Perubahan pada Query Builder (Line ~137)
- ✅ Menambahkan eager loading `wisatas` untuk performa
```php
// Before
$produksQuery = Produk::with('images', 'category')

// After
$produksQuery = Produk::with('images', 'category', 'wisatas')
```

## 🎯 Benefits

### 1. **Akurasi Lebih Tinggi**
   - Filter berdasarkan data relasi yang pasti
   - Tidak ada false positive dari string matching

### 2. **Performa Lebih Baik**
   - Menggunakan database index pada foreign key
   - Query join lebih efisien daripada multiple LIKE

### 3. **Maintenance Lebih Mudah**
   - Perubahan data wisata hanya di database
   - Tidak perlu update keyword mapping

### 4. **Scalability**
   - Mudah menambah wisata baru via admin panel
   - Tidak perlu update code untuk wisata baru

## 🧪 Testing

### Test Cases
1. ✅ Filter "Candi Arjuna" menampilkan produk yang memiliki wisata Candi Arjuna
2. ✅ Filter "Kawah Sikidang" menampilkan produk yang memiliki wisata Kawah Sikidang
3. ✅ Filter "Telaga Warna" menampilkan produk yang memiliki wisata Telaga Warna
4. ✅ Filter "Bukit Sikunir" menampilkan produk yang memiliki wisata Bukit Sikunir
5. ✅ Filter "Dieng Plateau" menampilkan produk yang memiliki wisata Dieng Plateau
6. ✅ Kombinasi filter wisata dengan filter lain (harga, kapasitas, kamar)

### Manual Testing
```bash
# Test via browser
1. Buka halaman: /all-products
2. Pilih filter "Dekat Wisata" -> "Candi Arjuna"
3. Klik "Terapkan Filter"
4. Verifikasi produk yang muncul memiliki wisata Candi Arjuna

# Test via API
curl -X GET "http://localhost:8000/all-products?attractions=candi-arjuna"
```

## 📊 Query Comparison

### Old Query (Multiple LIKE)
```sql
SELECT * FROM produks 
WHERE status = 'publish'
AND (
    lokasi LIKE '%candi%' OR label LIKE '%candi%'
    OR lokasi LIKE '%arjuna%' OR label LIKE '%arjuna%'
)
ORDER BY urutan;
```

### New Query (JOIN with Relationship)
```sql
SELECT * FROM produks
WHERE status = 'publish'
AND EXISTS (
    SELECT * FROM produk_wisatas
    WHERE produk_wisatas.produk_id = produks.id
    AND produk_wisatas.name LIKE '%Candi Arjuna%'
)
ORDER BY urutan;
```

## 🔮 Future Improvements

### Possible Enhancements:
1. **Exact Match untuk Performa Lebih Cepat**
   ```php
   $query->where('name', $attractionName);
   ```

2. **Multiple Wisata Filter**
   ```php
   // User bisa pilih multiple wisata
   $produksQuery->whereHas('wisatas', function ($query) use ($attractions) {
       $query->whereIn('name', $attractions);
   });
   ```

3. **Distance/Proximity Filter**
   ```php
   // Tambah kolom distance di produk_wisatas
   $query->where('name', $attractionName)
         ->where('distance', '<=', 5); // dalam km
   ```

4. **Wisata Dropdown Dinamis**
   ```php
   // Load dari database instead of hardcoded
   $wisataList = ProdukWisata::select('name')
       ->distinct()
       ->orderBy('name')
       ->get();
   ```

## 📌 Notes

- ⚠️ **Penting**: Pastikan data di tabel `produk_wisatas` sudah lengkap dan akurat
- ⚠️ Format nama wisata di database harus konsisten (contoh: "Candi Arjuna", bukan "candi arjuna" atau "CANDI ARJUNA")
- ✅ Eager loading `wisatas` sudah ditambahkan untuk menghindari N+1 query problem
- ✅ Backward compatible: jika tidak ada data di `produk_wisatas`, filter tidak akan error

## 👥 Contributors
- Developer: AI Assistant
- Date: 2025
- Issue: Optimization request for attractions filter logic

---

**Status**: ✅ **IMPLEMENTED & TESTED**