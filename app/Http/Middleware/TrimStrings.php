<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TrimStrings as Middleware;

/**
 * Middleware Pembersih Spasi Input (Trim Strings).
 *
 * Menghapus spasi di awal dan akhir nilai input request secara otomatis,
 * kecuali atribut sensitif kata sandi.
 *
 * @package App\Http\Middleware
 */
class TrimStrings extends Middleware
{
    /**
     * Nama atribut input yang tidak boleh dipotong spasinya (misalnya kata sandi).
     *
     * @var array<int, string>
     */
    protected $except = [
        'current_password',
        'password',
        'password_confirmation',
    ];
}
