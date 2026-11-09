<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Peminjaman;
use Carbon\Carbon;

/**
 * Service Provider Utama Aplikasi SINFAS
 *
 * Mengelola inisialisasi layanan global aplikasi saat proses booting:
 * 1. Mekanisme auto-patch skema enum basis data di server hosting (menjamin nilai 'dibatalkan' selalu terdaftar).
 * 2. View Composer global yang menyuntikkan koleksi notifikasi siswa aktif ke seluruh halaman bertema 'layouts.user'.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Mendaftarkan binding layanan aplikasi ke service container.
     */
    public function register(): void
    {
        //
    }

    /**
     * Mem-bootstrap dan menginisialisasi layanan aplikasi saat request pertama kali dijalankan.
     */
    public function boot(): void
    {
        // Mekanisme Auto-Fix Skema Enum Database:
        // Berfungsi memodifikasi kolom enum 'status_pengajuan' pada tabel 'peminjaman'
        // agar memiliki opsi 'dibatalkan'. Eksekusi ini di-cache selamanya (Cache::forever)
        // sehingga hanya dijalankan sekali saja dan tidak membebani performa server.
        if (!Cache::has('enum_dibatalkan_added')) {
            try {
                DB::statement("ALTER TABLE `peminjaman` MODIFY COLUMN `status_pengajuan` ENUM('menunggu', 'disetujui', 'ditolak', 'dibatalkan') NOT NULL DEFAULT 'menunggu'");
                Cache::forever('enum_dibatalkan_added', true);
            } catch (\Exception $e) {
                // Tabel belum dimigrasi atau database engine tidak mendukung ALTER TABLE
                Cache::forever('enum_dibatalkan_added', true);
            }
        }

        // Global View Composer:
        // Menyediakan variabel $userNotifications secara otomatis ke layout pengguna (layouts.user)
        // sehingga badge notifikasi selalu sinkron tanpa perlu query manual di setiap method controller.
        View::composer('layouts.user', function ($view) {
            $notifications = collect();
            if (Auth::check()) {
                $notifications = \App\Http\Controllers\PeminjamanController::getUserNotifications(Auth::user());
            }
            $view->with('userNotifications', $notifications);
        });
    }
}
