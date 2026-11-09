<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

/**
 * Service Provider Broadcast Event SINFAS.
 *
 * Mendaftarkan channel broadcasting untuk pengiriman notifikasi real-time peminjaman.
 *
 * @package App\Providers
 */
class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Inisialisasi rute dan kanal broadcast aplikasi.
     */
    public function boot(): void
    {
        Broadcast::routes();

        require base_path('routes/channels.php');
    }
}
