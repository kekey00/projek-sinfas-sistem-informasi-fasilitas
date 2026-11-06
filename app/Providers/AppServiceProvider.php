<?php

namespace App\Providers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Peminjaman;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Auto-fix: pastikan enum status_pengajuan punya nilai 'dibatalkan'
        if (!Cache::has('enum_dibatalkan_added')) {
            try {
                DB::statement("ALTER TABLE `peminjaman` MODIFY COLUMN `status_pengajuan` ENUM('menunggu', 'disetujui', 'ditolak', 'dibatalkan') NOT NULL DEFAULT 'menunggu'");
                Cache::forever('enum_dibatalkan_added', true);
            } catch (\Exception $e) {
                // Sudah dimodifikasi atau tabel belum ada
                Cache::forever('enum_dibatalkan_added', true);
            }
        }

        // Share notification data with user layout
        View::composer('layouts.user', function ($view) {
            $notifications = collect();
            if (Auth::check()) {
                $notifications = \App\Http\Controllers\PeminjamanController::getUserNotifications(Auth::user());
            }
            $view->with('userNotifications', $notifications);
        });
    }
}
