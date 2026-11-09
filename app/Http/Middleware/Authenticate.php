<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

/**
 * Middleware Autentikasi Pengguna SINFAS.
 *
 * Memeriksa apakah pengguna sudah login sebelum mengakses halaman yang dilindungi.
 * Mengarahkan ke rute login jika belum terautentikasi.
 *
 * @package App\Http\Middleware
 */
class Authenticate extends Middleware
{
    /**
     * Tentukan alamat URL tujuan redirect ketika pengguna belum login.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
