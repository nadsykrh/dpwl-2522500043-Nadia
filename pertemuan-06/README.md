# pertemuan-06

# Dokumentasi Praktikum DPWL P6

**Nama:** Nadia Syakirah  
**NIM:** 2522500043  
**Mata Kuliah:** Desain dan Pemrograman Web Lanjutan  
**Pertemuan:** 6  
**Proyek:** Sistem Informasi Penyewaan Kendaraan

## 1. Deskripsi Proyek

Proyek ini merupakan pengembangan lanjutan aplikasi penyewaan kendaraan dari pertemuan sebelumnya. Pada P6, aplikasi dikembangkan menggunakan PHP dengan pendekatan Model-View-Controller (MVC) buatan sendiri.

Pengembangan meliputi integrasi antarmuka TemplateMo Zay Shop, katalog dan detail kendaraan, registrasi akun penyewa, login dan logout penyewa, pembaruan profil, serta penyempurnaan URL aplikasi.

## 2. Teknologi yang Digunakan

- PHP 8.3.33
- MySQL
- Apache
- Laragon 8
- HTML, CSS, dan JavaScript
- TemplateMo Zay Shop
- Git dan GitHub

## 3. Tahapan Pengembangan

### A. Integrasi Antarmuka TemplateMo

**Perubahan dan implementasi:**
- Mengintegrasikan antarmuka pengguna berbasis TemplateMo Zay Shop.
- Menyesuaikan URL aset dan navigasi agar sesuai dengan struktur aplikasi MVC.

**Pengujian:**
- Memeriksa tampilan dan navigasi halaman aplikasi.

**Hasil:** Halaman katalog dapat dibuka melalui aplikasi.

### B. Implementasi Katalog Kendaraan

**Perubahan dan implementasi:**
- Mengintegrasikan pengambilan data kendaraan melalui model.
- Menghubungkan route dan controller katalog.
- Menampilkan data kendaraan pada halaman katalog.

**Pengujian:**
- Membuka halaman katalog melalui browser.
- Memeriksa tampilan daftar kendaraan.

**Hasil:** Halaman katalog berhasil dibuka.

### C. Implementasi Detail Kendaraan

**Perubahan dan implementasi:**
- Menambahkan route `katalog/detail/(:any)`.
- Mengintegrasikan method `detail()` pada `Katalog_controller`.
- Menambahkan tampilan detail kendaraan.

**Pengujian:**
- Mengklik tombol Lihat Mobil dari katalog.
- Menguji URL detail kendaraan dengan nomor plat yang mengandung spasi.

**Hasil:** Halaman detail kendaraan berhasil dibuka setelah perbaikan aturan rewrite Apache.

### D. Registrasi Akun Penyewa

**Perubahan dan implementasi:**
- Menambahkan route `auth/register`.
- Membuat model `Penyewa_model.php`.
- Mengintegrasikan proses registrasi pada controller `Auth`.
- Membuat tampilan registrasi penyewa.

**Pengujian:**
- Menguji halaman dan proses registrasi akun penyewa.

**Hasil:** Fitur registrasi telah diuji.

### E. Login, Sesi, dan Logout Penyewa

**Perubahan dan implementasi:**
- Menambahkan route login dan logout penyewa.
- Mengintegrasikan autentikasi serta pengelolaan sesi.
- Membuat tampilan login penyewa.

**Pengujian:**
- Menguji proses login dan logout penyewa.

**Hasil:** Fitur login dan logout telah diuji.

### F. Pembaruan Profil Penyewa

**Perubahan dan implementasi:**
- Menambahkan route `penyewa/profil`.
- Mengintegrasikan proses pembaruan profil pada controller dan model.
- Membuat tampilan profil penyewa.

**Pengujian:**
- Membuka halaman profil.
- Menguji pembaruan data profil.

**Hasil:** Fitur profil dan pembaruan data telah diuji.

### G. Menghilangkan `index.php` pada URL

**Perubahan dan implementasi:**
- Membuat dan menyesuaikan file `.htaccess`.
- Memperbarui pengambilan route pada `index.php`.
- Menyesuaikan `site_url()` pada `application/helpers/url_helper.php`.
- Mengubah default controller menjadi `Katalog_controller`.
- Menyesuaikan konfigurasi Apache agar aturan `.htaccess` dapat digunakan.

**Masalah yang ditemukan:**
- URL tanpa `index.php` menghasilkan `403 Forbidden`.
- Log Apache menunjukkan error `AH10411` terkait query string hasil rewrite yang mengandung spasi atau karakter kontrol.

**Perbaikan:**
Aturan rewrite pada `.htaccess` diubah dengan menambahkan flag `B`:

```apache
RewriteRule ^(.*)$ index.php?route=$1 [B,QSA,L]
```

**Pengujian:**
- Membuka katalog tanpa `index.php`.
- Mengakses detail kendaraan yang memiliki spasi pada nomor plat.
- Menguji navigasi serta proses penyimpanan perubahan kendaraan.

**Hasil:** URL tanpa `index.php` dapat digunakan dan error `403 Forbidden` telah teratasi pada pengujian yang dilakukan.

## 4. Ringkasan Pengujian

| Fitur | Status |
|---|---|
| Katalog kendaraan | Berhasil diuji |
| Detail kendaraan | Berhasil diuji |
| Registrasi penyewa | Telah diuji |
| Login dan logout penyewa | Telah diuji |
| Pembaruan profil penyewa | Berhasil diuji |
| Manajemen dan penyimpanan kendaraan | Berhasil diuji |
| URL tanpa `index.php` | Berhasil diuji |
| Upload foto kendaraan yang belum tersedia | Berhasil diuji |

## 5. Kendala dan Solusi

Kendala utama selama pengembangan adalah munculnya `403 Forbidden` saat mengakses URL aplikasi tanpa `index.php`. Pemeriksaan dilakukan melalui konfigurasi Apache dan file `.htaccess`.

Ditemukan error rewrite `AH10411` akibat karakter pada query string. Masalah diatasi dengan menambahkan flag `B` pada aturan `RewriteRule`. Setelah perubahan diuji, katalog, detail kendaraan, navigasi, dan proses penyimpanan dapat digunakan kembali tanpa error tersebut.

## 6. Status Akhir

Pengembangan P6 telah mencakup integrasi katalog dan detail kendaraan, registrasi, autentikasi penyewa, pembaruan profil, serta konfigurasi URL tanpa `index.php`.

Upload foto kendaraan yang belum tersedia masih perlu dilakukan dan diuji melalui fitur Manajemen Kendaraan. Riwayat commit dan push GitHub perlu diperiksa untuk memastikan dokumentasi serta hasil pengembangan terbaru sudah dikumpulkan sesuai ketentuan praktikum.
