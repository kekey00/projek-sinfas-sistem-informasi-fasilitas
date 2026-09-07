<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureAdminSistem
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin_sistem') {
            if (Auth::check() && Auth::user()->role === 'admin_sarana') {
                return redirect()->route('admin.dashboard');
            }
            return redirect()->route('login')->with('error', 'Akses ditolak. Halaman ini hanya untuk Admin Sistem.');
        }

        return $next($request);
    }
}
