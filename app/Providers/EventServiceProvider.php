<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

/**
 * Service Provider Event dan Listener SINFAS.
 *
 * Mendaftarkan event listener aplikasi untuk menangani siklus hidup
 * proses transaksi, autentikasi, dan pengiriman notifikasi peminjaman.
 *
 * @package App\Providers
 */
class EventServiceProvider extends ServiceProvider
{
    /**
     * Pemetaan event ke listener untuk aplikasi.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Daftarkan event dan listener untuk aplikasi SINFAS.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Tentukan apakah event dan listener harus ditemukan secara otomatis.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
