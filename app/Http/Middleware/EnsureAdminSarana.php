<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminSarana
{
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
