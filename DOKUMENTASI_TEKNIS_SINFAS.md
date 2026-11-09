# BUKU PANDUAN PENGEMBANG & DOKUMENTASI TEKNIS KODE PROGRAM
# SINFAS (SISTEM INFORMASI FASILITAS) - SMKN 11 BANDUNG

Dokumen ini disusun sebagai panduan teknis lengkap (*Developer Onboarding & Maintenance Guide*) agar setiap *developer*, tim pengembang baru, atau penerus proyek dapat memahami, merawat, dan mengembangkan sistem SINFAS tanpa kebingungan.

---

## 1. IKHTISAR SISTEM & TEKNOLOGI

* **Nama Aplikasi:** SINFAS (Sistem Informasi Fasilitas & Peminjaman Sarana Prasarana)
* **Institusi:** SMK Negeri 11 Bandung
* **Tujuan Utama:** Mengelola inventaris sarana prasarana sekolah, memfasilitasi peminjaman alat praktik oleh siswa secara digital, melacak kondisi fisik barang, dan mencegah kehilangan/keterlambatan pengembalian.
* **Stack Teknologi:**
  * **Backend Framework:** Laravel 11.x (PHP 8.2+)
  * **Database:** MySQL / MariaDB (InnoDB Engine)
  * **Frontend UI:** Blade Templating, Tailwind CSS, Alpine.js, Vanilla JS (AJAX Polling)
  * **Autentikasi:** Session-based Authentication bawaan Laravel dengan pemisahan *Role Multi-Level*.
  * **Media Storage:** Laravel Local Public Storage (`storage/app/public` disimbolkan ke `public/storage`).

---

## 2. PEMBAGIAN HAK AKSES (*ROLE ARCHITECTURE*)

Sistem memiliki 3 tingkat hak akses pengguna yang ditentukan di kolom `role` pada tabel `akun`:

| Role | Identifikasi | Tanggung Jawab Utama | Halaman Utama |
| :--- | :--- | :--- | :--- |
| **`siswa`** | Memiliki `nis` terdaftar di tabel `siswa` | Melihat katalog barang, mengajukan peminjaman, membatalkan permohonan yang belum disetujui, mengunggah bukti pengembalian fisik, memantau tenggat waktu. | `/user/status`, `/katalog` |
| **`admin`** | Staf Sarana & Prasarana | Mengelola inventaris barang & kategori, menyetujui/menolak pengajuan pinjam, memeriksa fisik alat saat kembali, mencetak laporan. | `/admin/dashboard`, `/admin/verifikasi` |
| **`sistem`** | Super Admin / IT Sekolah | Mengelola data seluruh akun pengguna (siswa & admin), konfigurasi sistem, audit log. | `/sistem/dashboard`, `/sistem/akun` |

---

## 3. ARSITEKTUR BASIS DATA & SKEMA INTI

```
+---------------+           +---------------+           +--------------------+
|     siswa     | 1       1 |     akun      |           |      kategori      |
+---------------+-----------+---------------+           +--------------------+
| *nis (PK)     |           | *id_akun (PK) |                      | 1
|  nama         |           |  username     |                      |
|  kelas        |           |  password     |                      | N
|  jurusan      |           |  role         |           +--------------------+
|  no_hp        |           |  nis (FK)     |           |       barang       |
+---------------+           +---------------+           +--------------------+
        | 1                                             | *kode_barang (PK)  |
        |                                               |  nama_barang       |
        | N                                             |  id_kategori (FK)  |
+---------------------------------------+               |  jumlah_total      |
|              peminjaman               |               |  jumlah_baik       |
+---------------------------------------+               |  jumlah_kurang_baik|
| *kode_pinjam (PK, PJM-YYYYMMDD-XXXX)  |               |  jumlah_rusak_berat|
|  nis (FK -> siswa.nis)                |               +--------------------+
|  kode_barang (FK -> barang.kode_barang)                      | 1
|  tanggal_pinjam                       |                      |
|  tanggal_kembali                      |                      |
|  status_pengajuan                     |                      | N
|  ('menunggu','disetujui','ditolak',   |                      |
|   'dibatalkan')                       |----------------------+
+---------------------------------------+
        | 1
        | 
        | 0..1
+---------------------------------------+
|             pengembalian              |
+---------------------------------------+
| *kode_kembali (PK, KMB-YYYYMMDD-XXXX) |
|  kode_pinjam (FK -> peminjaman)       |
|  tanggal_kembali                      |
|  kondisi_barang                       |
|  ('Baik','Kurang Baik','Rusak Berat') |
|  bukti_foto_video                     |
|  status ('menunggu', 'selesai')       |
+---------------------------------------+
```

### Aturan Status Pengajuan Peminjaman (`status_pengajuan`):
1. **`menunggu`**: Permohonan baru diajukan siswa. Stok barang belum terpotong. Siswa **dapat membatalkan** pada tahap ini.
2. **`disetujui`**: Disetujui oleh admin sarana. Stok barang layak pakai (`jumlah_baik`) otomatis berkurang 1.
3. **`ditolak`**: Ditolak oleh admin disertai catatan alasan penolakan. Stok barang tidak berubah.
4. **`dibatalkan`**: Dibatalkan secara mandiri oleh siswa sebelum diproses admin. Stok barang tidak berubah.

---

## 4. ALUR LOGIKA BISNIS (*CORE LIFECYCLE FLOW*)

### A. Alur Peminjaman Barang
```
[Siswa] Pilih Barang di Katalog
   │
   ▼
[Siswa] Isi Form (Tgl Pinjam, Tgl Kembali, WhatsApp, Tujuan)
   │
   ├─► Validasi: Tanggal >= Hari Ini, Tgl Kembali >= Tgl Pinjam, Stok jumlah_baik >= 1
   │
   ▼
Peminjaman::create(status_pengajuan = 'menunggu')
   │
   ├──► [Siswa] Batal Mandiri? ──► cancel() ──► status = 'dibatalkan' (Selesai)
   │
   ├──► [Admin] Tolak? ──────────► reject() ──► status = 'ditolak' + Alasan (Selesai)
   │
   ▼
[Admin] Setujui? ──► approve() 
   │
   ├──► DB::transaction:
   │       1. status_pengajuan = 'disetujui'
   │       2. barang->decrement('jumlah_baik', 1)
   │
   ▼
Peminjaman Aktif (Siswa memegang alat)
```

### B. Alur Pengembalian Barang & Pemulihan Stok
```
[Siswa] Lapor Pengembalian via Form
   │
   ▼
Upload Bukti Fisik (Foto/Video maks 25MB) + Input Kondisi Saat Kembali
   │
   ▼
Pengembalian::create(status = 'menunggu')
   (Catatan: Stok fisik BELUM dipulihkan di tahap ini demi mencegah manipulasi data)
   │
   ▼
[Admin Sarana] Cek Fisik Barang di Ruang Sarana
   │
   ▼
[Admin Sarana] Konfirmasi Verifikasi (verifikasiPengembalian())
   │
   ├──► DB::transaction:
   │       1. pengembalian->update(status = 'selesai')
   │       2. Penyesuaian Stok Otomatis:
   │            - Kondisi 'Baik'        ──► barang->increment('jumlah_baik', 1)
   │            - Kondisi 'Kurang Baik' ──► barang->increment('jumlah_kurang_baik', 1)
   │            - Kondisi 'Rusak Berat' ──► barang->increment('jumlah_rusak_berat', 1)
   │
   ▼
Peminjaman Tuntas (Arsip Riwayat)
```

---

## 5. KATALOG FILE & FUNGSI KRUSIAL (CODE DIRECTORY)

### 1. `app/Http/Controllers/PeminjamanController.php`
* **`status()`**: Menampilkan riwayat transaksi pinjam siswa yang login.
* **`store(Request $request)`**: Memvalidasi input pengajuan, memverifikasi ketersediaan stok fisik barang, men-generate kode transaksi unik, dan menyimpan data.
* **`cancel(string $kode_pinjam)`**: Membatalkan peminjaman dengan penguncian baris (`lockForUpdate`) untuk menghindari tabrakan konkurensi dengan admin.
* **`createPengembalian(string $kode_pinjam)`**: Menampilkan formulir lapor kembali jika barang sudah berstatus `'disetujui'`.
* **`storePengembalian(Request $request, string $kode_pinjam)`**: Menyimpan berkas bukti foto/video ke direktori `storage/app/public/pengembalian` dan membuat record pengembalian berstatus `'menunggu'`.
* **`getUserNotifications($user)`**: Mesin kalkulasi notifikasi cerdas:
  * Prioritas 0 (`overdue`): Tenggat waktu telah terlewati.
  * Prioritas 1 (`warning`): Sisa waktu kurang dari 24 jam.
  * Prioritas 2 (`pending`): Pengajuan menunggu persetujuan.
  * Prioritas 3 (`active`): Barang dalam masa peminjaman normal.
* **`liveCheck()`**: Endpoint JSON polling untuk memperbarui badge notifikasi siswa secara asinkron tanpa refresh browser.

### 2. `app/Http/Controllers/Admin/AdminVerifikasiController.php`
* **`index(Request $request)`**: Dashboard verifikasi 3 tab: Permohonan Baru (`requests`), Barang Sedang Dipinjam & Tunggu Cek (`returns`), dan Riwayat Tuntas (`history`).
* **`approve(string $kode_pinjam)`**: Memvalidasi ketersediaan stok fisik, mengubah status jadi `'disetujui'`, dan memotong stok `jumlah_baik` secara atomik di dalam `DB::transaction`.
* **`reject(Request $request, string $kode_pinjam)`**: Mengubah status jadi `'ditolak'` dan menyematkan catatan penolakan ke riwayat.
* **`verifikasiPengembalian(Request $request, string $kode_pinjam)`**: Finalisasi pengembalian barang dan penambahan kembali stok inventaris sekolah sesuai kondisi fisik aktual.
* **`liveCheck()`**: Endpoint JSON polling untuk admin agar mendapatkan notifikasi audio/toast jika ada pengajuan baru yang masuk secara *real-time*.

### 3. `app/Models/Peminjaman.php` & `app/Models/Pengembalian.php`
* Menggunakan *String Primary Key* non-incrementing (`public $incrementing = false`).
* **`generateKode()`**: Generator ID berurutan berbasis tanggal harian:
  * `PJM-YYYYMMDD-XXXX` pada Peminjaman.
  * `KMB-YYYYMMDD-XXXX` pada Pengembalian.

### 4. `app/Providers/AppServiceProvider.php`
* **Auto-fix Enum Schema Database:** Terdapat mekanisme auto-patch menggunakan cache `enum_dibatalkan_added` yang mengeksekusi raw query `ALTER TABLE peminjaman MODIFY COLUMN status_pengajuan ENUM(...)` agar saat dideploy di hosting tanpa SSH (misal: cPanel/DirectAdmin), skema database langsung termutakhirkan otomatis.
* **Global View Composer:** Menyuntikkan counter notifikasi aktif ke komponen layout user secara otomatis.

---

## 6. GOTCHAS & ATURAN PENTING BAGI PENGEMBANG BARU

1. **Konkurensi & Transaksi:**
   * Setiap kali mengubah status peminjaman yang mempengaruhi stok barang, **WAJIB** membungkus kode dalam `DB::transaction(function() { ... })`.
   * Hindari melakukan pemotongan stok di luar controller verifikasi.
2. **Penyimpanan Berkas (Upload Bukti):**
   * File diupload ke disk `'public'` (folder `storage/app/public/pengembalian`).
   * Di server lokal atau VPS, wajib menjalankan `php artisan storage:link` agar file dapat diakses publik melalui URL `/storage/...`.
3. **Format Tanggal:**
   * Kolom tanggal di-cast sebagai `date` pada Model Eloquent. Gunakan Carbon helper (`$pjm->tanggal_kembali->format('d M Y')`) untuk manipulasi tanggal.

---

## 7. CARA MENJALANKAN PROYEK DI KOMPUTER LOKAL (LOCAL SETUP)

Bagi pengembang baru yang meng-clone repository ini dari GitHub:

```bash
# 1. Clone repository
git clone https://github.com/kekey00/projek-sinfas-sistem-informasi-fasilitas.git
cd projek-sinfas-sistem-informasi-fasilitas

# 2. Salin environment configuration
copy .env.example .env

# 3. Install dependency PHP & Composer
composer install

# 4. Generate Application Key
php artisan key:generate

# 5. Konfigurasi Database di file .env:
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=sinfas_db
# DB_USERNAME=root
# DB_PASSWORD=

# 6. Jalankan Migrasi & Seeder
php artisan migrate --seed

# 7. Hubungkan Storage Link
php artisan storage:link

# 8. Jalankan Local Server
php artisan serve
```

Aplikasi dapat diakses melalui browser di `http://127.0.0.1:8000`.

---

## 8. ARSITEKTUR BASIS DATA LANJUTAN (STORED PROCEDURE, FUNCTION, TRIGGER & VIEW)

Untuk memenuhi rubrik rekayasa perangkat lunak dan basis data tingkat lanjut, SINFAS mengimplementasikan otomasi langsung di level DBMS MySQL:

### 1. Stored Procedure & Stored Function (Rubrik Poin No. 7)
* **`sp_rekap_peminjaman_siswa(IN p_nis VARCHAR(20))`** *(Stored Procedure)*:
  * **Tujuan:** Menarik rekap riwayat peminjaman siswa per NIS langsung via database engine.
  * **Pemanggilan di Kode:** Model `Peminjaman::callStoredProcedureRekap($nis)` dan Controller `AdminLaporanController::rekapSiswa($nis)`.
  * **Rute URL:** `GET /admin/laporan/rekap-siswa/{nis}`
* **`fn_total_unit_barang(p_kode_barang VARCHAR(30)) RETURNS INT`** *(Stored Function)*:
  * **Tujuan:** Menghitung total fisik alat (`jumlah_baik + jumlah_kurang_baik + jumlah_rusak_berat`).
  * **Pemanggilan di Kode:** Accessor Eloquent Model `$barang->total_unit`.
* **`fn_status_ketersediaan_barang(p_kode_barang VARCHAR(30)) RETURNS VARCHAR(30)`** *(Stored Function)*:
  * **Tujuan:** Mengembalikan status ketersediaan sarana (`Tersedia` / `Habis Dipinjam`).
  * **Pemanggilan di Kode:** Accessor Eloquent Model `$barang->status_ketersediaan`.

### 2. Database Trigger (Rubrik Poin No. 8)
* **`trg_peminjaman_after_update`** *(AFTER UPDATE ON `peminjaman`)*:
  * Otomatis memotong stok fisik `jumlah_baik` sebesar 1 unit saat pengajuan diubah statusnya menjadi `'disetujui'`.
  * Otomatis memulihkan stok (+1) jika transaksi yang disetujui dibatalkan/ditolak.
  * Mencatat riwayat audit perubahan status ke tabel `log_status_peminjaman`.
* **`trg_pengembalian_after_update` & `trg_pengembalian_after_insert`** *(ON `pengembalian`)*:
  * Otomatis menambah kembali stok ke kondisi fisik yang sesuai saat admin menyelesaikan pengembalian (`status = 'selesai'`).
* **`trg_cegah_stok_negatif`** *(BEFORE UPDATE ON `barang`)*:
  * Membatalkan transaksi (*rollback*) dan melempar pesan error `SQLSTATE 45000` jika ada modifikasi yang membuat stok minus (`jumlah_baik < 0`).

### 3. Database View (Rubrik Poin No. 9)
* **`v_peminjaman_aktif`**:
  * View gabungan relasi `peminjaman`, `siswa`, `barang`, dan `kategori` khusus untuk transaksi yang sedang berjalan (`status_pengajuan = 'disetujui'`).
  * Dipetakan ke Model Eloquent `App\Models\PeminjamanAktif` dan rute `GET /admin/laporan/peminjaman-aktif`.
* **`v_rekap_inventaris`**:
  * View rekapitulasi inventaris alat per kategori lengkap dengan akumulasi unit dan status ketersediaan.
  * Dipetakan ke Model Eloquent `App\Models\RekapInventarisView` dan rute `GET /admin/laporan/view-inventaris`.

---

*Dokumentasi ini diperbarui secara berkala sesuai dengan evolusi kode program aplikasi SINFAS.*

