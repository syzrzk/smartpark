# 📋 Panduan Logo SmartPark & UPB

## 📂 Lokasi File Logo

Semua logo disimpan di: `public/assets/images/`

### File Logo yang Ada:
- **upb-logo.svg** - Logo Universitas Pendidikan Bahasa (UPB)
- Logo SmartPark menggunakan inline SVG di dalam halaman login

---

## 🎨 Logo SmartPark

### Spesifikasi:
- **Format**: Inline SVG (embedded dalam HTML)
- **Ukuran**: 72×72 px (dapat disesuaikan)
- **Warna**: Gradient biru (#2563eb → #3b82f6)
- **Gaya**: Modern dengan efek shimmer/kilauan
- **Font**: Inter (Sans-serif)

### Karakteristik Logo:
- 🅿️ Simbol P (Parking) dengan desain profesional
- ✨ Efek gradien biru yang mencerminkan tema modern
- 💫 Animasi shimmer yang halus dan elegan

### Lokasi di Kode:
Halaman: `resources/views/auth/login.blade.php` (baris ±585)

---

## 🏫 Logo UPB (Universitas Pendidikan Bahasa)

### Spesifikasi:
- **Format**: SVG (file terpisah)
- **Lokasi**: `public/assets/images/upb-logo.svg`
- **Ukuran**: 200×200 px (dapat diskalakan)
- **Warna**: Biru (#3b82f6) dengan gradien
- **Elemen**: 
  - Lingkaran background (#1f2937)
  - Ikon gedung/kampus
  - Simbol buku/pendidikan
  - Text "UPB"

### Cara Mengganti Logo UPB:

#### Opsi 1: Mengunggah Logo PNG/JPG
1. Siapkan logo UPB Anda (format PNG atau JPG)
2. Letakkan di: `public/assets/images/upb-logo.png`
3. Ukuran yang disarankan: 200×200 px atau lebih
4. Ubah nama file di `login.blade.php` menjadi:
   ```blade
   <img src="{{ asset('assets/images/upb-logo.png') }}" alt="UPB Logo">
   ```

#### Opsi 2: Mengedit Logo SVG
1. Edit file: `public/assets/images/upb-logo.svg`
2. Ubah warna, elemen, dan text sesuai kebutuhan
3. Gunakan tools SVG editor seperti:
   - Figma (figma.com)
   - Inkscape (free)
   - Adobe Illustrator
   - Online: svgedit.netlify.app

---

## 🎯 Mengubah Tampilan Logo

### Ubah Ukuran Logo:
Di `resources/views/auth/login.blade.php`, cari:
```html
<div class="upb-logo">
    <img src="{{ asset('assets/images/upb-logo.svg') }}" ...>
</div>
```

Tambahkan CSS custom:
```html
<div class="upb-logo" style="transform: scale(1.2);">
    ...
</div>
```

### Ubah Warna SmartPark Logo:
Edit `login.blade.php` di bagian `.brand-icon`:
```css
.brand-icon {
    background: linear-gradient(135deg, #YOUR_COLOR1, #YOUR_COLOR2);
    /* Contoh: #ff6b6b, #ff4757 untuk merah */
}
```

### Ubah Nama Universitas:
Di `login.blade.php`, cari:
```html
<div class="upb-text">Universitas Pendidikan Bahasa</div>
```
Ubah text sesuai nama universitas Anda.

---

## 📱 Responsive Design

Logo sudah responsive dan akan terlihat baik di:
- ✅ Desktop (1920×1080)
- ✅ Tablet (768×1024)
- ✅ Mobile (375×667)

---

## 🔧 Custom Logo Setup (Jika Diperlukan)

### Buat Logo PNG Baru:
1. Buka Figma atau tool desain lainnya
2. Ukuran canvas: 200×200 px
3. Buat logo Anda
4. Export sebagai PNG dengan transparansi
5. Letakkan di: `public/assets/images/`
6. Update reference di `login.blade.php`

### Format SVG (Recommended):
```svg
<svg width="200" height="200" viewBox="0 0 200 200">
    <!-- Konten logo Anda -->
</svg>
```

---

## ✨ Tips Desain Logo

1. **Gunakan warna konsisten** dengan tema aplikasi (biru #3b82f6)
2. **Buat logo sederhana** agar mudah dikenali
3. **Hindari detail terlalu banyak** untuk keterbacaan di ukuran kecil
4. **Gunakan transparansi** untuk background yang fleksibel
5. **Test di berbagai ukuran** untuk memastikan kualitas

---

## 📞 Bantuan & Troubleshooting

### Logo tidak muncul?
- Pastikan file tersimpan di path yang benar: `public/assets/images/`
- Clear browser cache (Ctrl+Shift+Delete)
- Run: `php artisan storage:link` (jika menggunakan symlink)

### Logo terlalu besar/kecil?
- Edit CSS di `.upb-logo img { height: 60px; }`
- Ubah nilai height sesuai kebutuhan

### Ingin menambah logo lain?
- Buat struktur yang sama seperti `.upb-logo`
- Gunakan grid atau flexbox untuk layout
- Contoh: `grid grid-cols-1 md:grid-cols-3` untuk 3 logo bersebelahan

---

**Selamat mendesain! 🎨**
