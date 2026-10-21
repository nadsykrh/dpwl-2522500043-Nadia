# pertemuan-05

# DPWL P5 — Manajemen Kendaraan

## Bagian A — Menambahkan Menu Manajemen Kendaraan

**Perubahan:**
- Menambahkan menu Manajemen Kendaraan pada `application/views/templates/sidebar.php`.
- Menambahkan route `admin/mobil` pada `application/config/routes.php`.

**Hasil pengujian:**
- URL: `http://localhost/dpwl-2522500043/index.php/admin/mobil`
- Hasil aktual: menampilkan pesan `Controller tidak ditemukan.`
- Sesuai modul, pesan tersebut diharapkan karena `Mobil_controller.php` belum dibuat pada tahap A.

## Bagian B — Menambahkan Route Manajemen Kendaraan

**Perubahan:**
Menambahkan tiga route pada `application/config/routes.php`:
- `admin/mobil/tambah` → `Mobil_controller/tambah`
- `admin/mobil/ubah/(:any)` → `Mobil_controller/ubah/$1`
- `admin/mobil/hapus/(:any)` → `Mobil_controller/hapus/$1`

**Berkas yang terdampak:**
- `application/config/routes.php`

**Hasil pemeriksaan:**
Konfigurasi tiga route telah ditambahkan. Pengujian fungsi route akan dilanjutkan setelah `Mobil_controller.php` dibuat pada tahap C.

### Bagian C — READ Data Kendaraan

**Hasil pengujian:**
- Halaman Manajemen Kendaraan berhasil dibuka setelah admin login.
- Data kendaraan berhasil ditampilkan dalam tabel.
- Jumlah data yang terdeteksi: 42 kendaraan.
- Informasi kendaraan dan navigasi tabel tampil pada halaman.

### Bagian D — CREATE Data Kendaraan

**Perubahan:**
- Menambahkan method `create()` pada `application/models/Mobil_model.php` untuk menyimpan data kendaraan ke database menggunakan prepared statement.
- Menambahkan validasi input pada `application/controllers/Mobil_controller.php`.
- Menambahkan proses unggah foto depan, foto belakang, dan foto interior.
- Menambahkan penanganan unggahan foto dengan format JPEG, PNG, dan WEBP serta ukuran maksimal 5 MB per foto.
- Menambahkan proses pembersihan berkas foto yang sudah diunggah apabila penyimpanan data gagal.
- Memperbarui `application/views/admin/mobil_view.php` dengan formulir tambah kendaraan dan input unggah foto.

**Hasil pemeriksaan:**
- Pemeriksaan sintaks `Mobil_controller.php`: tidak ditemukan kesalahan sintaks.
- Pemeriksaan sintaks `mobil_view.php`: tidak ditemukan kesalahan sintaks.

**Hasil pengujian:**
- Data kendaraan berhasil ditambahkan melalui formulir.
- Data kendaraan berhasil tersimpan ke database.
- Unggahan foto berhasil dilakukan dan berkas tersimpan di folder `uploads/mobil/`.
- Pesan keberhasilan tampil setelah data berhasil ditambahkan.

### Bagian E — UPDATE Data Kendaraan

**Perubahan:**
- Menambahkan method `findByNoPlat()` pada `application/models/Mobil_model.php` untuk mengambil data kendaraan berdasarkan nomor plat.
- Menambahkan method `update()` pada `application/models/Mobil_model.php` untuk memperbarui data kendaraan di database menggunakan prepared statement.
- Menambahkan method `ubah()` pada `application/controllers/Mobil_controller.php` untuk menampilkan formulir ubah dan memproses perubahan data kendaraan.
- Menggunakan kembali validasi input pada `application/controllers/Mobil_controller.php` sebelum perubahan disimpan.
- Menambahkan proses penggantian foto depan, foto belakang, dan foto interior kendaraan.
- Mempertahankan foto lama apabila pengguna tidak mengunggah foto pengganti.
- Menambahkan penanganan kegagalan unggah foto dan pembersihan berkas foto baru apabila pembaruan data gagal.
- Memperbarui `application/views/admin/mobil_view.php` dengan formulir ubah kendaraan yang menampilkan data sebelumnya.

**Hasil pemeriksaan:**
- Pemeriksaan sintaks `Mobil_model.php`: tidak ditemukan kesalahan sintaks.
- Pemeriksaan sintaks `Mobil_controller.php`: tidak ditemukan kesalahan sintaks.
- Pemeriksaan sintaks `mobil_view.php`: tidak ditemukan kesalahan sintaks.

**Hasil pengujian:**
- Formulir ubah kendaraan berhasil ditampilkan dengan data kendaraan yang dipilih.
- Perubahan data kendaraan berhasil disimpan ke database.
- Penggantian foto kendaraan berhasil dilakukan.
- Foto lama tetap digunakan apabila foto tidak diganti.
- Pengujian fitur UPDATE berhasil dilakukan sesuai skenario yang diuji.

## F. DELETE Data Kendaraan

### Tujuan
Menambahkan fitur untuk menghapus data kendaraan pada halaman Manajemen Kendaraan.

### Implementasi
Fitur DELETE data kendaraan meliputi:
1. Menambahkan method `delete()` pada `Mobil_model.php` untuk menghapus data kendaraan berdasarkan nomor plat.
2. Menambahkan method `hapus()` pada `Mobil_controller.php` untuk menangani permintaan penghapusan kendaraan.
3. Memastikan hanya admin yang sudah login dapat melakukan penghapusan.
4. Menggunakan metode HTTP POST untuk proses penghapusan.
5. Menghapus foto kendaraan terkait setelah data kendaraan berhasil dihapus dari database.
6. Menampilkan pesan keberhasilan atau kegagalan proses penghapusan.

### Pengujian
- Menambahkan data kendaraan untuk pengujian.
- Menghapus data kendaraan melalui tombol **Hapus**.
- Memastikan data kendaraan terhapus dari tabel.
- Memastikan pesan keberhasilan ditampilkan setelah penghapusan berhasil.

**Status:** Berhasil diuji pada proyek latihan.