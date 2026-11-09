<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Middleware Otorisasi Admin Sarana.
 *
 * Middleware ini memastikan hanya pengguna dengan role 'admin_sarana'
 * yang dapat mengakses halaman pengelolaan fasilitas dalam sistem SINFAS.
 * Jika pengguna memiliki role 'admin_sistem', akan diarahkan ke dashboard sistem.
 * Jika pengguna tidak terautentikasi atau memiliki role lain, akan diarahkan ke halaman login.
 *
 * @package App\Http\Middleware
 */
class EnsureAdminSarana
{
    /**
     * Menangani request yang masuk dan memverifikasi otorisasi Admin Sarana.
     *
     * Memeriksa apakah pengguna sudah login dan memiliki role 'admin_sarana'.
     * Melakukan redirect sesuai kondisi jika otorisasi gagal.
     *
     * @param  \Illuminate\Http\Request  $request  Instance HTTP request yang masuk.
     * @param  \Closure  $next  Callback untuk meneruskan request ke middleware/handler berikutnya.
     * @return mixed  Response dari middleware berikutnya atau redirect response jika otorisasi gagal.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin_sarana') {
            if (Auth::check() && Auth::user()->role === 'admin_sistem') {
                return redirect()->route('sistem.dashboard');
            }
            return redirect()->route('login')->with('error', 'Akses ditolak. Halaman ini hanya untuk Admin Sarana.');
        }

        return $next($request);
    }
}
