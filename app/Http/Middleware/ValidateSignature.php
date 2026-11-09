<?php

namespace App\Http\Middleware;

use Illuminate\Routing\Middleware\ValidateSignature as Middleware;

/**
 * Middleware Validasi Tanda Tangan URL (Signed URL).
 *
 * Memverifikasi integritas link bertanda tangan (signed URL) agar tidak dimanipulasi pihak luar.
 *
 * @package App\Http\Middleware
 */
class ValidateSignature extends Middleware
{
    /**
     * Parameter query string yang diabaikan saat validasi signature.
     *
     * @var array<int, string>
     */
    protected $except = [
        // 'fbclid',
        // 'utm_campaign',
        // 'utm_content',
        // 'utm_medium',
        // 'utm_source',
        // 'utm_term',
    ];
}
