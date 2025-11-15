# 🚀 Quick Reference - Availability Badge

**Feature:** Badge Ketersediaan Produk  
**Status:** ✅ Active  
**Updated:** 15 November 2025

---

## 🎯 Kapan Badge Muncul?

Badge **HANYA** muncul ketika user melakukan filter dengan **Tanggal Booking** dan **Jumlah Malam**.

```
✅ Muncul: User pilih tanggal + jumlah malam → Badge tampil
❌ Tidak: User tidak pilih tanggal → Badge tidak tampil
```

---

## 🎨 3 Status Badge

### 1. 🟢 TERSEDIA (Hijau)
```
Kondisi: Unit > 2 DAN percentage > 30%
Warna: bg-green-600
Icon: ✓ (Checkmark)
Text: "Tersedia X unit"
Animation: -
```

**Contoh:**
- Total 10 unit, booked 3 → **Tersedia 7 unit** 🟢
- Total 5 unit, booked 2 → **Tersedia 3 unit** 🟢

---

### 2. 🟠 HAMPIR PENUH (Orange)
```
Kondisi: Unit 1-2 ATAU percentage ≤ 30%
Warna: bg-orange-600
Icon: ⚠ (Warning)
Text: "Tersedia X unit"
Animation: -
```

**Contoh:**
- Total 5 unit, booked 4 → **Tersedia 1 unit** 🟠 (sisa 1)
- Total 3 unit, booked 1 → **Tersedia 2 unit** 🟠 (sisa 2)
- Total 10 unit, booked 8 → **Tersedia 2 unit** 🟠 (sisa 2)
- Total 10 unit, booked 7 → **Tersedia 3 unit** 🟠 (30%)

---

### 3. 🔴 HABIS (Merah)
```
Kondisi: Unit = 0
Warna: bg-red-600
Icon: ✕ (X mark)
Text: "Habis"
Animation: animate-pulse ⚡
```

**Contoh:**
- Total 5 unit, booked 5 → **Habis** 🔴 (pulse)

---

## 📊 Tabel Logic Lengkap

### Produk 10 Unit:
| Booked | Available | % | Badge | Warna |
|--------|-----------|---|-------|-------|
| 0 | 10 | 100% | Tersedia 10 unit | 🟢 Hijau |
| 3 | 7 | 70% | Tersedia 7 unit | 🟢 Hijau |
| 5 | 5 | 50% | Tersedia 5 unit | 🟢 Hijau |
| 7 | 3 | 30% | Tersedia 3 unit | 🟠 Orange |
| 8 | 2 | 20% | Tersedia 2 unit | 🟠 Orange |
| 9 | 1 | 10% | Tersedia 1 unit | 🟠 Orange |
| 10 | 0 | 0% | Habis | 🔴 Merah |

### Produk 5 Unit:
| Booked | Available | % | Badge | Warna |
|--------|-----------|---|-------|-------|
| 0 | 5 | 100% | Tersedia 5 unit | 🟢 Hijau |
| 2 | 3 | 60% | Tersedia 3 unit | 🟢 Hijau |
| 3 | 2 | 40% | Tersedia 2 unit | 🟠 Orange |
| 4 | 1 | 20% | Tersedia 1 unit | 🟠 Orange |
| 5 | 0 | 0% | Habis | 🔴 Merah |

### Produk 3 Unit:
| Booked | Available | % | Badge | Warna |
|--------|-----------|---|-------|-------|
| 0 | 3 | 100% | Tersedia 3 unit | 🟢 Hijau |
| 1 | 2 | 67% | Tersedia 2 unit | 🟠 Orange |
| 2 | 1 | 33% | Tersedia 1 unit | 🟠 Orange |
| 3 | 0 | 0% | Habis | 🔴 Merah |

---

## 🔍 Pertanyaan Penting: **Unit Sisa 1 Berubah Warna?**

### ✅ YA! Badge berubah jadi ORANGE 🟠

**Logic:**
```php
if ($available == 0) {
    $badgeClass = 'bg-red-600';     // 🔴 Habis
} elseif ($available <= 2) {
    $badgeClass = 'bg-orange-600';  // 🟠 Hampir Penuh (1-2 unit)
} elseif ($percentage <= 30) {
    $badgeClass = 'bg-orange-600';  // 🟠 Hampir Penuh (≤30%)
} else {
    $badgeClass = 'bg-green-600';   // 🟢 Tersedia
}
```

**Jadi:**
- Sisa **1 unit** → SELALU 🟠 Orange (Hampir Penuh)
- Sisa **2 unit** → SELALU 🟠 Orange (Hampir Penuh)
- Sisa **3+ unit** DAN **>30%** → 🟢 Hijau (Tersedia)

---

## 🎯 Use Case Real

### Scenario 1: Villa Populer (10 unit)
```
Senin pagi:   10 unit tersedia → 🟢 "Tersedia 10 unit"
Senin siang:   7 unit tersedia → 🟢 "Tersedia 7 unit"
Senin sore:    3 unit tersedia → 🟠 "Tersedia 3 unit" (30%)
Senin malam:   1 unit tersedia → 🟠 "Tersedia 1 unit" (URGENCY!)
Selasa pagi:   0 unit tersedia → 🔴 "Habis" (pulse effect)
```

### Scenario 2: Villa Eksklusif (2 unit)
```
Booking pertama: 2 unit → 🟢 "Tersedia 2 unit"
Booking kedua:   1 unit → 🟠 "Tersedia 1 unit" (Hampir penuh!)
Booking ketiga:  0 unit → 🔴 "Habis"
```

---

## 💡 Tips Penggunaan

### Untuk User:
- 🟢 **Hijau**: Tenang, masih banyak pilihan
- 🟠 **Orange**: Cepat booking sebelum habis!
- 🔴 **Merah**: Cari villa lain atau ubah tanggal

### Untuk Admin:
- Monitor villa dengan badge 🟠 orange → Popular dates
- Villa dengan badge 🔴 merah → Full booked (success!)
- Badge 🟢 hijau terus → Perlu promosi?

---

## 📍 Lokasi Badge

```
┌──────────────────────────┐
│ [PROMO 20%] (Top-Left)   │ ← Promo badge
│                          │
│    [Villa Image]         │
│                          │
│ [Tersedia 2 unit]        │ ← Availability badge
└──────────────────────────┘   (Bottom-Left)
```

Badge tidak overlap karena posisi berbeda:
- **Promo Badge**: `top-2 left-2`
- **Availability Badge**: `bottom-2 left-2`

---

## 🧪 Testing Cepat

### Via Browser:
```
1. Buka: /all-produk
2. Pilih tanggal: Besok
3. Pilih malam: 2 malam
4. Klik: "Cari & Terapkan Filter"
5. Cek: Badge muncul di setiap villa card
```

### Via Tinker:
```php
php artisan tinker

use App\Models\Produk\Produk;
use App\Models\Transaksi\TransaksiDetail;

// Simulasi booking untuk test
$produk = Produk::first();
$booked = TransaksiDetail::where('produk_id', $produk->id)
    ->where('date', today())
    ->sum('unit');

$available = $produk->unit - $booked;
echo "Available: $available / {$produk->unit}";

// Output: Available: 3 / 5
// Expected Badge: Tersedia 3 unit (Hijau/Orange tergantung %)
```

---

## 🔧 Troubleshooting

### Badge tidak muncul?
✅ **Cek:** Apakah tanggal & malam sudah dipilih?
✅ **Cek:** `$bookingDate` dan `$nightsCount` ada value?

### Warna badge salah?
✅ **Cek:** Logic di `all-products.blade.php` line 266-286
✅ **Cek:** Data `$availability[$produk->id]` benar?

### Text badge salah?
✅ **Cek:** Query `TransaksiDetail::sum('unit')` di controller
✅ **Cek:** `$produk->unit` match dengan database?

---

## 📚 Dokumentasi Lengkap

- **Detail:** `docs/fixes/availability-badge-feature.md`
- **Testing:** `docs/fixes/test-filter-script.md`
- **Summary:** `docs/fixes/SUMMARY.md`

---

## ✅ Checklist

- [x] Badge muncul saat filter tanggal aktif
- [x] Badge tidak muncul tanpa filter tanggal
- [x] Warna badge akurat (hijau/orange/merah)
- [x] Sisa 1-2 unit SELALU orange
- [x] Habis (0 unit) SELALU merah + pulse
- [x] Text menampilkan jumlah unit yang benar
- [x] Icon sesuai dengan status
- [x] Responsive di mobile/tablet/desktop
- [x] Tidak overlap dengan badge lain

---

**🎉 Semua badge ketersediaan bekerja dengan sempurna!**

Sisa 1 unit? → 🟠 **ORANGE (Hampir Penuh)**  
Habis? → 🔴 **MERAH (Pulse Animation)**

---

**Version:** 1.0.0  
**Last Updated:** 15 November 2025