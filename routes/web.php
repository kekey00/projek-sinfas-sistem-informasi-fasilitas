<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminBarangController;
use App\Http\Controllers\Admin\AdminKategoriController;
use App\Http\Controllers\Admin\AdminVerifikasiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Redirect root ke halaman login
Route::get('/', function () {
    return redirect()->route('login');
});

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

    // -----------------------------------------------
    // ADMIN Sarana (Master: Barang & Kategori, Verifikasi)
    // -----------------------------------------------
    Route::prefix('admin')->name('admin.')->group(function () {
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
    });

});
