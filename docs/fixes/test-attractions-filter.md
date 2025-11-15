# Test Script: Filter "Dekat Wisata" - Menggunakan Relasi `produk_wisatas`

## 📋 Checklist Testing

### Prerequisites
- [x] Tabel `produk_wisatas` sudah ada di database
- [x] Data wisata sudah terisi untuk setiap produk
- [x] Model `ProdukWisata` sudah memiliki relasi dengan `Produk`
- [x] Controller sudah diupdate menggunakan `whereHas()`

---

## 🧪 Test Cases

### 1. Test Filter Candi Arjuna
**URL**: `/all-products?attractions=candi-arjuna`

**Expected**:
- Produk yang muncul hanya yang memiliki relasi dengan wisata "Candi Arjuna"
- Produk tanpa wisata Candi Arjuna tidak muncul

**SQL untuk Verifikasi**:
```sql
SELECT p.id, p.name, pw.name as wisata_name
FROM produks p
INNER JOIN produk_wisatas pw ON pw.produk_id = p.id
WHERE p.status = 'publish'
AND pw.name LIKE '%Candi Arjuna%';
```

---

### 2. Test Filter Kawah Sikidang
**URL**: `/all-products?attractions=kawah-sikidang`

**Expected**:
- Produk yang muncul hanya yang memiliki relasi dengan wisata "Kawah Sikidang"

**SQL untuk Verifikasi**:
```sql
SELECT p.id, p.name, pw.name as wisata_name
FROM produks p
INNER JOIN produk_wisatas pw ON pw.produk_id = p.id
WHERE p.status = 'publish'
AND pw.name LIKE '%Kawah Sikidang%';
```

---

### 3. Test Filter Telaga Warna
**URL**: `/all-products?attractions=telaga-warna`

**Expected**:
- Produk yang muncul hanya yang memiliki relasi dengan wisata "Telaga Warna"

**SQL untuk Verifikasi**:
```sql
SELECT p.id, p.name, pw.name as wisata_name
FROM produks p
INNER JOIN produk_wisatas pw ON pw.produk_id = p.id
WHERE p.status = 'publish'
AND pw.name LIKE '%Telaga Warna%';
```

---

### 4. Test Filter Bukit Sikunir
**URL**: `/all-products?attractions=bukit-sikunir`

**Expected**:
- Produk yang muncul hanya yang memiliki relasi dengan wisata "Bukit Sikunir"

**SQL untuk Verifikasi**:
```sql
SELECT p.id, p.name, pw.name as wisata_name
FROM produks p
INNER JOIN produk_wisatas pw ON pw.produk_id = p.id
WHERE p.status = 'publish'
AND pw.name LIKE '%Bukit Sikunir%';
```

---

### 5. Test Filter Dieng Plateau
**URL**: `/all-products?attractions=dieng-plateau`

**Expected**:
- Produk yang muncul hanya yang memiliki relasi dengan wisata "Dieng Plateau"

**SQL untuk Verifikasi**:
```sql
SELECT p.id, p.name, pw.name as wisata_name
FROM produks p
INNER JOIN produk_wisatas pw ON pw.produk_id = p.id
WHERE p.status = 'publish'
AND pw.name LIKE '%Dieng Plateau%';
```

---

### 6. Test Filter Tanpa Wisata (Semua Lokasi)
**URL**: `/all-products?attractions=`

**Expected**:
- Menampilkan semua produk (tidak ada filter)
- Termasuk produk yang tidak punya wisata

---

### 7. Test Kombinasi Filter: Wisata + Harga
**URL**: `/all-products?attractions=candi-arjuna&price_range=500000-1000000`

**Expected**:
- Produk dengan wisata Candi Arjuna
- DAN harga weekday antara 500.000 - 1.000.000

**SQL untuk Verifikasi**:
```sql
SELECT p.id, p.name, p.harga_weekday, pw.name as wisata_name
FROM produks p
INNER JOIN produk_wisatas pw ON pw.produk_id = p.id
WHERE p.status = 'publish'
AND pw.name LIKE '%Candi Arjuna%'
AND p.harga_weekday BETWEEN 500000 AND 1000000;
```

---

### 8. Test Kombinasi Filter: Wisata + Kapasitas
**URL**: `/all-products?attractions=telaga-warna&capacity=5-8`

**Expected**:
- Produk dengan wisata Telaga Warna
- DAN kapasitas 5-8 orang

**SQL untuk Verifikasi**:
```sql
SELECT p.id, p.name, p.maks_orang, pw.name as wisata_name
FROM produks p
INNER JOIN produk_wisatas pw ON pw.produk_id = p.id
WHERE p.status = 'publish'
AND pw.name LIKE '%Telaga Warna%'
AND p.maks_orang BETWEEN 5 AND 8;
```

---

### 9. Test Kombinasi Filter: Wisata + Jumlah Kamar
**URL**: `/all-products?attractions=kawah-sikidang&rooms=3`

**Expected**:
- Produk dengan wisata Kawah Sikidang
- DAN memiliki 3 kamar

**SQL untuk Verifikasi**:
```sql
SELECT p.id, p.name, p.kamar, pw.name as wisata_name
FROM produks p
INNER JOIN produk_wisatas pw ON pw.produk_id = p.id
WHERE p.status = 'publish'
AND pw.name LIKE '%Kawah Sikidang%'
AND p.kamar = 3;
```

---

### 10. Test Kombinasi Filter: Wisata + Sort
**URL**: `/all-products?attractions=bukit-sikunir&sort=price-low`

**Expected**:
- Produk dengan wisata Bukit Sikunir
- Diurutkan berdasarkan harga terendah

---

## 🔍 Query Debugging

### Cek Data Wisata untuk Produk Tertentu
```sql
SELECT 
    p.id,
    p.name as produk_name,
    pw.name as wisata_name
FROM produks p
LEFT JOIN produk_wisatas pw ON pw.produk_id = p.id
WHERE p.status = 'publish'
ORDER BY p.name, pw.name;
```

### Cek Produk yang Tidak Punya Wisata
```sql
SELECT p.id, p.name
FROM produks p
LEFT JOIN produk_wisatas pw ON pw.produk_id = p.id
WHERE p.status = 'publish'
AND pw.id IS NULL;
```

### Cek Jumlah Wisata per Produk
```sql
SELECT 
    p.id,
    p.name,
    COUNT(pw.id) as total_wisata
FROM produks p
LEFT JOIN produk_wisatas pw ON pw.produk_id = p.id
WHERE p.status = 'publish'
GROUP BY p.id, p.name
ORDER BY total_wisata DESC;
```

### Cek Nama Wisata yang Tersedia
```sql
SELECT DISTINCT name
FROM produk_wisatas
ORDER BY name;
```

---

## 🐛 Troubleshooting

### Problem: Filter tidak menampilkan hasil apapun

**Kemungkinan Penyebab**:
1. Nama wisata di database tidak match dengan mapping di controller
2. Data produk_wisatas kosong
3. Typo pada nama wisata

**Solusi**:
```sql
-- Cek nama wisata yang sebenarnya ada di database
SELECT DISTINCT name FROM produk_wisatas;

-- Cek apakah ada data untuk wisata tertentu
SELECT * FROM produk_wisatas WHERE name LIKE '%Candi%';
```

---

### Problem: Filter menampilkan produk yang salah

**Kemungkinan Penyebab**:
1. Relasi di model tidak benar
2. Foreign key tidak match

**Solusi**:
```sql
-- Cek relasi produk dan wisata
SELECT 
    p.id as produk_id,
    p.name as produk_name,
    pw.id as wisata_id,
    pw.produk_id as wisata_produk_id,
    pw.name as wisata_name
FROM produks p
LEFT JOIN produk_wisatas pw ON pw.produk_id = p.id
WHERE p.id = 'uuid-produk-bermasalah';
```

---

### Problem: Query lambat

**Kemungkinan Penyebab**:
1. Tidak ada index pada foreign key
2. N+1 query problem

**Solusi**:
```sql
-- Tambahkan index jika belum ada
CREATE INDEX idx_produk_wisatas_produk_id ON produk_wisatas(produk_id);
CREATE INDEX idx_produk_wisatas_name ON produk_wisatas(name);
```

```php
// Pastikan eager loading sudah ditambahkan
$produksQuery = Produk::with('images', 'category', 'wisatas');
```

---

## 📊 Performance Testing

### Test Query Performance
```sql
-- Test dengan EXPLAIN untuk melihat query execution plan
EXPLAIN SELECT p.*
FROM produks p
WHERE p.status = 'publish'
AND EXISTS (
    SELECT 1 FROM produk_wisatas pw
    WHERE pw.produk_id = p.id
    AND pw.name LIKE '%Candi Arjuna%'
);
```

### Expected Query Time
- **Small Dataset** (< 100 produk): < 50ms
- **Medium Dataset** (100-1000 produk): < 200ms
- **Large Dataset** (> 1000 produk): < 500ms

---

## ✅ Test Results Template

| Test Case | Status | Notes | Tested By | Date |
|-----------|--------|-------|-----------|------|
| Filter Candi Arjuna | ⏳ Pending | | | |
| Filter Kawah Sikidang | ⏳ Pending | | | |
| Filter Telaga Warna | ⏳ Pending | | | |
| Filter Bukit Sikunir | ⏳ Pending | | | |
| Filter Dieng Plateau | ⏳ Pending | | | |
| Semua Lokasi | ⏳ Pending | | | |
| Wisata + Harga | ⏳ Pending | | | |
| Wisata + Kapasitas | ⏳ Pending | | | |
| Wisata + Kamar | ⏳ Pending | | | |
| Wisata + Sort | ⏳ Pending | | | |

**Status Legend**:
- ⏳ Pending
- ✅ Pass
- ❌ Fail
- ⚠️ Warning

---

## 🔄 Rollback Plan

Jika terjadi masalah dan perlu rollback ke logika lama:

```php
// Rollback ke keyword-based search
if ($attractions) {
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
}
```

---

**Created**: 2025  
**Last Updated**: 2025  
**Status**: Ready for Testing