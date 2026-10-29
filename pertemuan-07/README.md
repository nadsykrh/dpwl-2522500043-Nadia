# pertemuan-07
# README.md

# P7 — Implementasi Keranjang Transaksi pada Sistem Rental Kendaraan

## A. Deskripsi Proyek

Proyek ini merupakan pengembangan sistem informasi rental kendaraan berbasis web menggunakan PHP dan MySQL. Pengembangan dilakukan dengan melanjutkan proyek sebelumnya dan menerapkan pola arsitektur **Model-View-Controller (MVC)**.

## B. Persiapan Model dan Controller Transaksi

Pada bagian ini dilakukan persiapan komponen transaksi untuk menangani proses penambahan kendaraan ke keranjang.

### 1. Model Transaksi

File yang dibuat:

`application/models/Transaksi_model.php`

Model transaksi digunakan sebagai tempat pengelolaan data transaksi yang berhubungan dengan database.

Fitur yang dipersiapkan meliputi:
- Pengelolaan kunci transaksi menggunakan mekanisme MySQL `GET_LOCK`.
- Pelepasan kunci transaksi menggunakan `RELEASE_LOCK`.
- Pembuatan kode sewa dengan format `INV/YYYYMMDD/NN`.

### 2. Controller Transaksi

File yang dibuat:

`application/controllers/Transaksi_controller.php`

Controller transaksi disiapkan untuk menangani permintaan penambahan kendaraan ke keranjang.

Proses yang dipersiapkan meliputi:
- Memeriksa status login penyewa.
- Memastikan permintaan menggunakan metode POST.
- Mengambil nomor polisi kendaraan dan tujuan pengalihan halaman.
- Menyiapkan pesan untuk memberikan informasi kepada pengguna.

### 3. Routing

Pada file `routes.php`, ditambahkan route berikut:

```php
$route['transaksi/tambah'] = 'Transaksi_controller/tambah';
```

Route ini digunakan untuk mengarahkan permintaan penambahan kendaraan ke controller transaksi.

## C. Integrasi Tombol Tambah ke Keranjang

Pada bagian ini dilakukan penyesuaian tampilan katalog dan detail kendaraan agar pengguna dapat menambahkan kendaraan ke keranjang melalui form.

### 1. Halaman Detail Kendaraan

File:

`application/views/katalog/detail.php`

Perubahan yang dilakukan:
- Menyesuaikan tombol tambah ke keranjang berdasarkan status ketersediaan kendaraan.
- Menampilkan form penambahan kendaraan jika kendaraan tersedia.
- Menyesuaikan tampilan tombol berdasarkan status login penyewa.
- Mengirimkan nomor polisi kendaraan melalui input tersembunyi (`hidden input`).
- Menambahkan parameter `return_to` dengan nilai `detail`.

### 2. Halaman Katalog Kendaraan

File:

`application/views/katalog/index.php`

Perubahan yang dilakukan:
- Menyesuaikan tombol tambah ke keranjang pada setiap kartu kendaraan.
- Menampilkan tombol aktif jika kendaraan tersedia dan tombol nonaktif jika tidak tersedia.
- Mengirimkan nomor polisi kendaraan melalui input tersembunyi.
- Menambahkan parameter `return_to` dengan nilai `katalog`.
- Mengarahkan form ke route `transaksi/tambah` menggunakan metode POST.

## D. Integrasi Navigasi dan Jumlah Keranjang

### D.1. Penyesuaian Navbar

File:

`application/views/katalog/navbar.php`

Penyesuaian dilakukan untuk menampilkan informasi keranjang pada bagian navigasi.

Perubahan yang dilakukan:
- Menambahkan variabel untuk jumlah kendaraan dalam keranjang.
- Menambahkan penanganan flash message transaksi.
- Menampilkan pesan sukses atau gagal kepada pengguna.
- Mengarahkan ikon keranjang ke halaman `transaksi/keranjang`.
- Mengganti angka jumlah keranjang yang sebelumnya statis dengan nilai dinamis dari variabel `$jumlahKeranjang`.

### D.2. Integrasi Model dan Controller

#### D.2.1. Menambahkan Fungsi Penghitungan Keranjang

File:

`application/models/Transaksi_model.php`

Ditambahkan method:

`getJumlahMobilKeranjang(string $userPlg): int`

Method ini digunakan untuk menghitung jumlah kendaraan dalam keranjang berdasarkan pengguna yang sedang login.

Penghitungan dilakukan dengan mengambil data dari tabel `t_pilih` dan menghubungkannya dengan tabel `t_sewa`. Data yang dihitung dibatasi pada transaksi milik penyewa terkait dengan status sewa `keranjang`.

#### D.2.2. Integrasi pada Katalog Controller

File:

`application/controllers/Katalog_controller.php`

Penyesuaian yang dilakukan:
- Menambahkan pemanggilan file `Transaksi_model.php`.
- Menambahkan properti untuk objek model transaksi pada controller katalog.
- Menginisialisasi objek `Transaksi_model` pada constructor.
- Mengirimkan variabel `jumlahKeranjang` ke halaman katalog.
- Menyiapkan pengiriman jumlah keranjang pada halaman detail kendaraan.

Jumlah keranjang dihitung berdasarkan pengguna yang sedang login. Jika pengguna belum login, jumlah keranjang ditetapkan menjadi `0`.

### D.2.3. Memperbarui Penyewa Controller

File:

`application/controllers/Penyewa_controller.php`

Pada tahap ini, dilakukan penyesuaian pada controller penyewa agar jumlah kendaraan dalam keranjang tetap dikirim ke halaman profil penyewa. Dengan demikian, navbar dapat menampilkan jumlah keranjang ketika pengguna membuka halaman katalog, detail kendaraan, maupun profil penyewa.

**Perubahan yang dilakukan:**

1. Menambahkan pemanggilan `Transaksi_model.php` menggunakan `require_once`.
2. Menambahkan properti `$transaksiModel` di dalam class `Penyewa_controller`.
3. Menginisialisasi objek `Transaksi_model` pada method `__construct()`.
4. Menambahkan perhitungan jumlah kendaraan dalam keranjang menggunakan method `getJumlahMobilKeranjang($userPlg)` pada method `profil()`.
5. Mengirimkan variabel `jumlahKeranjang` ke view `penyewa/profil`.
6. Menambahkan data jumlah keranjang pada tampilan profil ketika validasi formulir gagal.
7. Memperbarui method `renderProfilError()` agar tetap mengirimkan jumlah keranjang ketika terjadi kesalahan pada proses pembaruan profil.

**Tujuan:**

Memastikan jumlah kendaraan dalam keranjang tetap ditampilkan pada navbar halaman profil penyewa, termasuk ketika formulir profil menampilkan pesan kesalahan validasi atau proses pembaruan profil mengalami kegagalan.

**Pengujian:**

- Membuka halaman profil penyewa dan memeriksa jumlah pada ikon keranjang.
- Mengubah data profil dengan data valid dan memastikan jumlah keranjang tetap ditampilkan.
- Menguji formulir dengan data yang tidak valid dan memastikan pesan kesalahan serta jumlah keranjang tetap ditampilkan.
- Memeriksa kembali halaman katalog dan detail kendaraan untuk memastikan perubahan tidak mengganggu halaman lainnya.

Hasil pengujian aktual dicatat setelah seluruh skenario pengujian dijalankan.

## E. Mengintegrasikan Proses Penambahan Kendaraan ke Keranjang

### E.1. Menambahkan Method `tambahKeKeranjang()`

**File yang diperbarui:**
- `application/models/Transaksi_model.php`

**Deskripsi:**

Pada tahap ini, Model transaksi dikembangkan untuk mengintegrasikan proses penambahan kendaraan ke dalam keranjang penyewaan. Sistem menggunakan tabel `t_sewa` sebagai penyimpan informasi utama transaksi dan tabel `t_pilih` untuk menyimpan kendaraan yang dipilih.

**Implementasi:**
- Menambahkan helper `namaKunciKeranjang()` untuk mengidentifikasi kunci keranjang berdasarkan penyewa.
- Menambahkan helper `kunciKendaraan()` untuk mengambil dan mengunci data kendaraan dari basis data.
- Menambahkan helper `hitungHariSewa()` untuk memvalidasi tanggal dan menghitung durasi penyewaan.
- Menambahkan helper `normalisasiWaktu()` untuk memvalidasi serta menormalisasi waktu pengambilan kendaraan.
- Menambahkan method `tambahKeKeranjang()` untuk memeriksa ketersediaan kendaraan, mencari keranjang aktif, membuat transaksi baru jika belum tersedia, dan menyimpan kendaraan yang dipilih.
- Menggunakan prepared statement MySQLi untuk menjalankan query basis data.
- Menggunakan transaksi basis data, mekanisme penguncian, serta penanganan error untuk menjaga konsistensi data dan mencegah penambahan kendaraan yang sama ke keranjang yang sama.

**Pengujian:**

1. Memeriksa sintaks PHP pada `application/models/Transaksi_model.php` menggunakan perintah `php -l`. Hasil: tidak ditemukan kesalahan sintaks.
2. Menguji penambahan kendaraan ke keranjang melalui aplikasi. Hasil: kendaraan berhasil ditambahkan ke keranjang.
3. Mencoba menambahkan kendaraan yang sama untuk kedua kalinya. Hasil: sistem menampilkan pesan bahwa kendaraan sudah ada di keranjang ini dan mencegah penambahan duplikat.

**Status:** Implementasi dan pengujian fungsional bagian E.1 berhasil. Fitur penambahan kendaraan ke keranjang berjalan sesuai hasil pengujian.

## F.1. Membuat Halaman Isi Keranjang

**File yang dibuat:**
- `application/views/transaksi/keranjang.php`

### Deskripsi

Pada tahap ini, dibuat halaman isi keranjang penyewaan kendaraan untuk menampilkan informasi transaksi dan kendaraan yang dipilih oleh penyewa.

### Implementasi

- Memanggil header dan navbar aplikasi.
- Menampilkan kode transaksi dan status penyewaan.
- Menampilkan formulir tanggal mulai, tanggal selesai, dan waktu pengambilan kendaraan.
- Menampilkan pesan notifikasi berdasarkan hasil proses.
- Menampilkan daftar kendaraan dalam keranjang, meliputi foto, nama kendaraan, nomor polisi, harga sewa per hari, durasi sewa, dan subtotal.
- Menampilkan total biaya sewa.
- Menyediakan formulir untuk menghapus kendaraan dari keranjang.
- Menyediakan tombol untuk melanjutkan ke halaman checkout atau konfirmasi transaksi.
- Menggunakan fungsi `htmlspecialchars()` untuk mengamankan data sebelum ditampilkan pada HTML.
- Menambahkan JavaScript untuk membantu membatasi waktu pengambilan minimal dua jam dari waktu sekarang serta memvalidasi periode sewa.

### Pengujian

- Melakukan pemeriksaan sintaks PHP pada `application/views/transaksi/keranjang.php` menggunakan PHP Laragon.
- Hasil pemeriksaan: `No syntax errors detected in application/views/transaksi/keranjang.php`.

### Status

Pembuatan halaman keranjang selesai dan pemeriksaan sintaks berhasil. Pengujian tampilan serta fungsi formulir pada browser dicatat setelah halaman diintegrasikan dengan Controller dan route transaksi.

## F.2. Menambahkan Method Keranjang dan Lainnya pada Controller Transaksi

### Perubahan yang Dilakukan
- Menambahkan method `keranjang()` pada `Transaksi_controller` untuk menampilkan keranjang milik penyewa yang sedang login.
- Menambahkan method `perbaruiPeriode()` untuk memperbarui tanggal mulai, tanggal selesai, dan waktu pengambilan kendaraan.
- Menambahkan method `hapus()` untuk menghapus kendaraan dari keranjang.
- Menambahkan method `checkout()` untuk menampilkan konfirmasi dan memproses pengajuan transaksi.
- Menambahkan method `redirectDenganPesan()` untuk mengatur pengalihan halaman beserta notifikasi.
- Menambahkan method pada `Transaksi_model`, yaitu `validasiWaktuMulai()`, `perbaruiPeriodeKeranjang()`, `getKeranjang()`, `hapusDariKeranjang()`, `checkout()`, dan `getKodeKeranjangAktif()`.
- Mendaftarkan route transaksi, keranjang, pembaruan periode, penghapusan kendaraan, dan checkout pada `application/config/routes.php`.

### Pengujian
| No. | Skenario Pengujian | Hasil Aktual |
|---|---|---|
| 1 | Menampilkan keranjang milik penyewa yang memiliki keranjang aktif | Berhasil |
| 2 | Mengarahkan penyewa yang belum memiliki keranjang aktif kembali ke katalog dengan pesan keranjang kosong | Berhasil |
| 3 | Menampilkan jumlah kendaraan pada navbar sesuai keranjang penyewa yang login | Berhasil |
| 4 | Memperbarui periode dan waktu pengambilan kendaraan | Berhasil |
| 5 | Menghapus kendaraan dari keranjang | Berhasil |
| 6 | Menampilkan halaman konfirmasi checkout | Berhasil |
| 7 | Memproses checkout dan mengajukan transaksi | Berhasil |
| 8 | Memeriksa sintaks PHP pada `Transaksi_model.php` | Berhasil, tidak ditemukan kesalahan sintaks |

### Kesimpulan
Implementasi F.2 telah selesai dan seluruh skenario pengujian yang dilakukan berhasil. Fitur keranjang, pembaruan periode sewa, penghapusan kendaraan, serta alur checkout telah diuji dan berjalan sesuai harapan.

# F.3 Implementasi Halaman Konfirmasi Transaksi

## F.3.1 Implementasi View Konfirmasi

Pada tahap ini dibuat file `application/views/transaksi/konfirmasi.php` untuk menampilkan halaman konfirmasi transaksi sebelum transaksi diajukan kepada admin.

Fitur yang diimplementasikan:
- Menampilkan kode transaksi.
- Menampilkan periode penyewaan dan waktu pengambilan.
- Menampilkan daftar kendaraan yang disewa.
- Menampilkan harga sewa, durasi, subtotal, dan total biaya.
- Menghitung uang muka (DP) sebesar 30% dari total biaya.
- Menampilkan sisa pembayaran.
- Menyediakan tombol **Kembali ke Keranjang** dan **Konfirmasi dan Ajukan Transaksi**.

**Hasil pengujian: Berhasil.** Halaman konfirmasi transaksi dapat ditampilkan dengan baik melalui URL checkout.

## F.3.2 Pengujian Halaman Konfirmasi Transaksi

Pengujian dilakukan untuk memastikan halaman konfirmasi menampilkan informasi transaksi dengan benar dan menyediakan navigasi yang sesuai.

| No. | Skenario Pengujian | Hasil |
|---|---|---|
| 1 | Membuka halaman konfirmasi melalui menu checkout. | Berhasil |
| 2 | Menampilkan kode transaksi dan periode penyewaan. | Berhasil |
| 3 | Menampilkan waktu pengambilan kendaraan. | Berhasil |
| 4 | Menampilkan daftar kendaraan beserta harga dan durasi sewa. | Berhasil |
| 5 | Menampilkan total biaya penyewaan. | Berhasil |
| 6 | Menampilkan perhitungan DP sebesar 30% dan sisa pembayaran. | Berhasil |
| 7 | Menggunakan tombol Kembali ke Keranjang. | Berhasil |
| 8 | Memastikan halaman konfirmasi hanya dapat diakses untuk transaksi milik penyewa yang sesuai dan berstatus keranjang. | Berhasil |

**Kesimpulan:** Implementasi dan pengujian halaman konfirmasi transaksi pada tahap F.3 hingga F.3.2 berhasil dilakukan. Halaman dapat menampilkan informasi transaksi, rincian biaya, DP, dan sisa pembayaran serta menyediakan navigasi untuk kembali ke keranjang.

## F.3.3 Pengujian Proses Checkout

Pengujian ini dilakukan untuk memastikan proses pengajuan transaksi berjalan dengan baik dan data transaksi tersimpan sesuai ketentuan.

| No. | Skenario Pengujian | Hasil |
|---|---|---|
| 1 | Membuka halaman konfirmasi transaksi. | Berhasil |
| 2 | Menekan tombol Konfirmasi dan Ajukan Transaksi. | Berhasil |
| 3 | Menampilkan pesan bahwa transaksi berhasil diajukan dan menunggu persetujuan admin. | Berhasil |
| 4 | Memastikan status transaksi pada tabel `t_sewa` berubah dari `keranjang` menjadi `diajukan`. | Berhasil |
| 5 | Memastikan data pembayaran DP tersimpan pada tabel `t_bayar`. | Berhasil |
| 6 | Memastikan jenis pembayaran tercatat sebagai `dp` dengan metode `transfer`. | Berhasil |
| 7 | Memastikan nominal DP sebesar 30% dari total biaya penyewaan. | Berhasil |
| 8 | Memastikan status pembayaran tercatat sebagai `pending`. | Berhasil |
| 9 | Memastikan transaksi yang sudah diajukan tidak dapat diajukan kembali melalui keranjang aktif. | Berhasil |

**Kesimpulan:** Proses checkout berhasil dijalankan. Transaksi diajukan kepada admin, status penyewaan diperbarui menjadi `diajukan`, dan data pembayaran DP dicatat dengan status `pending`. Pembayaran belum dianggap lunas karena masih menunggu proses verifikasi lebih lanjut.
