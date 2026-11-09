<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

/**
 * Middleware Verifikasi Token CSRF (Cross-Site Request Forgery).
 *
 * Mengamankan seluruh form request POST/PUT/DELETE dari serangan pemalsuan request lintas situs.
 *
 * @package App\Http\Middleware
 */
class VerifyCsrfToken extends Middleware
{
    /**
     * Alamat URI yang dikecualikan dari verifikasi token CSRF.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];
}
