<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

/**
 * Service Provider Autentikasi dan Kebijakan Otorisasi SINFAS.
 *
 * Mendaftarkan service autentikasi dan policy otorisasi hak akses peran
 * (siswa, admin_sarana, admin_sistem) pada aplikasi fasilitas sekolah.
 *
 * @package App\Providers
 */
class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
