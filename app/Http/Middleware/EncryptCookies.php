<?php

namespace App\Http\Middleware;

use Illuminate\Cookie\Middleware\EncryptCookies as Middleware;

/**
 * Middleware Enkripsi Cookie SINFAS.
 *
 * Mengamankan cookie aplikasi dengan enkripsi bawaan Laravel.
 *
 * @package App\Http\Middleware
 */
class EncryptCookies extends Middleware
{
    /**
     * Nama-nama cookie yang dikecualikan dari proses enkripsi.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
