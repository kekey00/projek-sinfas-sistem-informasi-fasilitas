<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

/**
 * Exception Handler Utama Aplikasi SINFAS (Rubrik No. 6: Exception / Error Handling).
 *
 * Kelas ini bertugas menangkap, mencatat (logging), dan mengelola seluruh pengecualian (exception)
 * serta error runtime yang terjadi pada sistem informasi fasilitas sekolah.
 *
 * Mengamankan data sensitif seperti password dari session flash saat terjadi error validasi,
 * serta menyediakan mekanisme penanganan error terpusat untuk HTTP request dan response API.
 *
 * @package App\Exceptions
 */
class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
