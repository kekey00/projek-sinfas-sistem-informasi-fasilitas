<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance as Middleware;

/**
 * Middleware Mode Pemeliharaan (Maintenance Mode).
 *
 * Mencegah akses pengguna saat sistem SINFAS sedang dalam proses maintenance.
 *
 * @package App\Http\Middleware
 */
class PreventRequestsDuringMaintenance extends Middleware
{
    /**
     * Alamat URI yang tetap dapat diakses meskipun mode maintenance sedang aktif.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
