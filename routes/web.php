<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminBarangController;
use App\Http\Controllers\Admin\AdminKategoriController;
use App\Http\Controllers\Admin\AdminLaporanController;
use App\Http\Controllers\Admin\AdminVerifikasiController;
use App\Http\Controllers\Sistem\SistemDashboardController;
use App\Http\Controllers\Sistem\SistemAkunController;
use App\Http\Controllers\Sistem\SistemSettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Halaman publik sebelum login
Route::view('/', 'welcome')->name('home');

// =================================================
// RUTE PUBLIK (Bisa diakses tanpa login)
// =================================================
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.process');

// =================================================
// RUTE TERPROTEKSI (Wajib login dulu)
// =================================================
Route::middleware(['auth'])->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // -----------------------------------------------
    // USER (role: siswa)
    // -----------------------------------------------

    // Dashboard user = daftar barang (bisa search & filter)
    Route::get('/user/dashboard', [BarangController::class, 'index'])->name('user.dashboard');

    // Detail barang + form pengajuan peminjaman
    Route::get('/user/barang/{kode}', [BarangController::class, 'show'])->name('user.barang.show');

    // Kirim pengajuan peminjaman
    Route::post('/user/peminjaman', [PeminjamanController::class, 'store'])->name('user.peminjaman.store');

    // Status Pengajuan (Daftar & Riwayat Pinjaman)
    Route::get('/user/status', [PeminjamanController::class, 'status'])->name('user.status');

    // Form Pengembalian Barang
    Route::get('/user/pengembalian/{kode_pinjam}', [PeminjamanController::class, 'createPengembalian'])->name('user.pengembalian.create');
    Route::post('/user/pengembalian/{kode_pinjam}', [PeminjamanController::class, 'storePengembalian'])->name('user.pengembalian.store');

    // My Profile (Profil & Ganti Password)
    Route::get('/user/profile', [UserProfileController::class, 'index'])->name('user.profile');
    Route::put('/user/profile', [UserProfileController::class, 'update'])->name('user.profile.update');

    // -----------------------------------------------
    // ADMIN Sarana (Master: Barang & Kategori, Verifikasi)
    // -----------------------------------------------
    Route::prefix('admin')->name('admin.')->middleware(['admin.sarana'])->group(function () {
        // Dashboard Admin Sarana
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        // Master Data Barang / Alat
        Route::get('/barang', [AdminBarangController::class, 'index'])->name('barang.index');
        Route::post('/barang', [AdminBarangController::class, 'store'])->name('barang.store');
        Route::put('/barang/{kode}', [AdminBarangController::class, 'update'])->name('barang.update');
        Route::delete('/barang/{kode}', [AdminBarangController::class, 'destroy'])->name('barang.destroy');

        // Master Data Kategori
        Route::get('/kategori', [AdminKategoriController::class, 'index'])->name('kategori.index');
        Route::post('/kategori', [AdminKategoriController::class, 'store'])->name('kategori.store');
        Route::put('/kategori/{id}', [AdminKategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{id}', [AdminKategoriController::class, 'destroy'])->name('kategori.destroy');

        // Verifikasi Pengajuan & Pengembalian
        Route::get('/verifikasi', [AdminVerifikasiController::class, 'index'])->name('verifikasi.index');
        Route::post('/verifikasi/approve/{kode_pinjam}', [AdminVerifikasiController::class, 'approve'])->name('verifikasi.approve');
        Route::post('/verifikasi/reject/{kode_pinjam}', [AdminVerifikasiController::class, 'reject'])->name('verifikasi.reject');
        Route::post('/verifikasi/pengembalian/{kode_pinjam}', [AdminVerifikasiController::class, 'verifikasiPengembalian'])->name('verifikasi.pengembalian');

        // Riwayat Peminjaman
        Route::get('/riwayat', function (\Illuminate\Http\Request $request) {
            $request->merge(['tab' => 'history']);
            return app(\App\Http\Controllers\Admin\AdminVerifikasiController::class)->index($request);
        })->name('riwayat.index');

        // Laporan peminjaman barang
        Route::get('/laporan', [AdminLaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/frekuensi', [AdminLaporanController::class, 'frekuensi'])->name('laporan.frekuensi');
        Route::get('/laporan/frekuensi/pdf', [AdminLaporanController::class, 'frekuensiPdf'])->name('laporan.frekuensi.pdf');
        Route::get('/laporan/kondisi', [AdminLaporanController::class, 'kondisi'])->name('laporan.kondisi');
        Route::get('/laporan/kondisi/pdf', [AdminLaporanController::class, 'kondisiPdf'])->name('laporan.kondisi.pdf');
        Route::get('/laporan/keterlambatan', [AdminLaporanController::class, 'keterlambatan'])->name('laporan.keterlambatan');
        Route::get('/laporan/keterlambatan/pdf', [AdminLaporanController::class, 'keterlambatanPdf'])->name('laporan.keterlambatan.pdf');
        Route::get('/laporan/inventaris', [AdminLaporanController::class, 'inventaris'])->name('laporan.inventaris');
        Route::get('/laporan/inventaris/pdf', [AdminLaporanController::class, 'inventarisPdf'])->name('laporan.inventaris.pdf');

        // Profil Admin Sarana
        Route::get('/profile', function () {
            $user = auth()->user();
            $pegawai = \App\Models\Pegawai::where('nip', $user->nip)->first();
            return view('admin.profile', compact('user', 'pegawai'));
        })->name('profile');
        Route::put('/profile', [\App\Http\Controllers\UserProfileController::class, 'update'])->name('profile.update');
    });

    // -----------------------------------------------
    // ADMIN Sistem (Kelola Akun & Pengaturan Sistem)
    // -----------------------------------------------
    Route::prefix('sistem')->name('sistem.')->middleware(['admin.sistem'])->group(function () {

        // Dashboard Admin Sistem
        Route::get('/dashboard', [SistemDashboardController::class, 'index'])->name('dashboard');

        // Profil Admin Sistem
        Route::get('/profile', function () {
            $user = auth()->user();
            $pegawai = \App\Models\Pegawai::where('nip', $user->nip)->first();
            return view('sistem.profile', compact('user', 'pegawai'));
        })->name('profile');
        Route::put('/profile', [\App\Http\Controllers\UserProfileController::class, 'update'])->name('profile.update');

        // Kelola Akun
        Route::get('/akun', [SistemAkunController::class, 'index'])->name('akun.index');
        Route::post('/akun', [SistemAkunController::class, 'store'])->name('akun.store');
        Route::put('/akun/{id}', [SistemAkunController::class, 'update'])->name('akun.update');
        Route::delete('/akun/{id}', [SistemAkunController::class, 'destroy'])->name('akun.destroy');
        Route::post('/akun/{id}/reset-password', [SistemAkunController::class, 'resetPassword'])->name('akun.reset-password');

        // Pengaturan Sistem
        Route::get('/settings', [SistemSettingsController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SistemSettingsController::class, 'update'])->name('settings.update');
        Route::post('/settings/backup', [SistemSettingsController::class, 'backup'])->name('settings.backup');
        Route::post('/settings/clear-cache', [SistemSettingsController::class, 'clearCache'])->name('settings.clear-cache');
    });

});
