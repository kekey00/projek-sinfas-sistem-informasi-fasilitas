<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

/**
 * Middleware Kepercayaan Proxy (Trust Proxies).
 *
 * Mengonfigurasi penanganan proxy seperti reverse proxy (Nginx, Cloudflare) untuk mendeteksi IP klien secara akurat.
 *
 * @package App\Http\Middleware
 */
class TrustProxies extends Middleware
{
    /**
     * Alamat proxy yang dipercaya untuk aplikasi ini.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies;

    /**
     * Header HTTP yang digunakan untuk mendeteksi proxy.
     *
     * @var int
     */
    protected $headers =
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB;
}
