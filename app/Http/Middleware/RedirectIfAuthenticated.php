<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware Pengalihan Pengguna yang Sudah Login.
 *
 * Mencegah pengguna yang sudah login untuk membuka kembali halaman login/registrasi publik,
 * dan langsung mengarahkannya ke dashboard.
 *
 * @package App\Http\Middleware
 */
class RedirectIfAuthenticated
{
    /**
     * Tangani request yang masuk dan periksa status login pengguna.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$guards
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::HOME);
            }
        }

        return $next($request);
    }
}
