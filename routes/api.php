<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StudentMobileAuthController;
use App\Http\Controllers\Api\StudentLoanHistoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/**
 * ===========================================================================
 * Grup Route API Mobile SINFAS
 * ===========================================================================
 *
 * Route-route di bawah ini menangani akses API untuk aplikasi mobile mahasiswa.
 * Semua endpoint di grup ini memiliki prefix '/api/mobile'.
 */
Route::prefix('mobile')->group(function () {

    // Endpoint login mahasiswa via aplikasi mobile.
    // Dibatasi maksimal 6 percobaan per menit (throttle:6,1) untuk mencegah brute-force.
    Route::post('/login', [StudentMobileAuthController::class, 'login'])->middleware('throttle:6,1');

    // Grup endpoint yang membutuhkan autentikasi token Sanctum.
    // Mahasiswa harus sudah login untuk mengakses endpoint di bawah ini.
    Route::middleware('auth:sanctum')->group(function () {

        // Endpoint logout mahasiswa — menghapus token Sanctum yang aktif.
        Route::post('/logout', [StudentMobileAuthController::class, 'logout']);

        // Endpoint riwayat peminjaman fasilitas milik mahasiswa yang sedang login.
        Route::get('/riwayat', [StudentLoanHistoryController::class, 'index']);
    });
});

/**
 * Endpoint untuk mendapatkan data pengguna yang sedang terautentikasi.
 * Digunakan oleh SPA/mobile untuk memverifikasi sesi dan mengambil profil pengguna.
 * Dilindungi oleh middleware auth:sanctum.
 */
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
