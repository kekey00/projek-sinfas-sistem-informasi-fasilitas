<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustHosts as Middleware;

/**
 * Middleware Kepercayaan Host (Trust Hosts).
 *
 * Mengamankan header Host dari manipulasi DNS rebinding atau host injection.
 *
 * @package App\Http\Middleware
 */
class TrustHosts extends Middleware
{
    /**
     * Dapatkan pola host domain yang dipercaya oleh aplikasi.
     *
     * @return array<int, string|null>
     */
    public function hosts(): array
    {
        return [
            $this->allSubdomainsOfApplicationUrl(),
        ];
    }
}
