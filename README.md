# 🛍️ LuminaStore - Landing Page Toko Online

Halaman landing page website toko online modern, estetik, dan responsif yang dibangun menggunakan **HTML5** & **CSS3**.

---

## 🌟 Fitur Utama

1. **Header & Navigation Bar**:
   - Logo toko online yang modern.
   - Menu navigasi cepat dengan link anchor halus (*smooth scrolling*).
   - Tombol pencarian, keranjang belanja dengan indikator item, dan tombol CTA.
   - Menu responsif untuk tampilan mobile (menggunakan teknik CSS checkbox toggle).

2. **Hero Section**:
   - Headline yang menarik dan persuasif.
   - Tombol *Call to Action* (CTA) belanja dan promo.
   - Statistik toko (jumlah pelanggan, total produk, toko rating).
   - Visual foto model dengan efek *floating cards* (voucher diskon dan ulasan pembeli).

3. **Keunggulan Layanan (*Value Propositions*)**:
   - 4 kartu keunggulan: Gratis Ongkir, Garansi 100% Original, Pembayaran Aman & COD, Layanan CS 24/7.

4. **Produk Unggulan / Terlaris (*Featured Products*)**:
   - Grid kartu produk dengan badge diskon/hot.
   - Hover zoom effect pada foto produk.
   - Tombol aksi wishlist, preview cepat, dan tombol tambah ke keranjang (*Add to Cart*).
   - Format harga coret diskon dan rating bintang.

5. **Banner Promo Spesial**:
   - Desain gradient yang mencolok untuk penawaran waktu terbatas.
   - Kotak hitung mundur (*Countdown timer*).

6. **Testimoni Pembeli**:
   - Ulasan dari pelanggan nyata beserta rating bintang dan foto avatar.

7. **Formulir Newsletter**:
   - Kolom langganan email untuk mendapatkan diskon pembelian pertama.

8. **Footer Lengkap**:
   - Informasi brand, tautan kategori, pusat bantuan, alamat & kontak, serta ikon metode pembayaran (Visa, Mastercard, QRIS, COD).

---

## 📁 Struktur File

```text
18.Belajar Anti Gravity/
│
├── index.html       # Struktur konten semantic HTML5
├── style.css        # Seluruh style, variabel warna, grid, animasi & media queries
└── README.md        # Panduan penggunaan dan kustomisasi
```

---

## 🚀 Cara Menjalankan

1. Buka folder proyek ini di File Explorer:
   ```text
   d:\02.File Belajar Codingan\18.Belajar Anti Gravity
   ```
2. Klik ganda (**double-click**) pada file `index.html`. File akan langsung terbuka di browser favorit Anda (Google Chrome, Microsoft Edge, Firefox, dll).
3. Atau jika menggunakan VS Code, Anda bisa klik kanan pada `index.html` lalu pilih **"Open with Live Server"**.

---

## 🎨 Tips Kustomisasi Cepat

- **Mengubah Warna Utama Toko**:
  Buka file `style.css` pada bagian `:root` paling atas:
  ```css
  --primary: #4f46e5;       /* Ganti dengan kode warna pilihanmu */
  --primary-hover: #4338ca;
  ```
- **Mengganti Nama Toko**:
  Buka `index.html`, cari teks `LuminaStore` dan ubah sesuai nama brand tokomu.
- **Mengganti Gambar Produk**:
  Cari tag `<img>` pada section `<section class="products" id="produk">` di `index.html`, lalu ganti atribut `src="..."` dengan link gambar produkmu.
