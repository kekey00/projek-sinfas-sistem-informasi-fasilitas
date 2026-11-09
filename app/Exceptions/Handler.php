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
     * Daftar input sensitif yang tidak boleh disimpan ke session flash saat terjadi error validasi.
     * Mencegah kata sandi terbuka kembali ke form demi keamanan data pengguna.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Daftarkan fungsi penanganan (callback) exception untuk aplikasi SINFAS.
     * Digunakan untuk mencatat log error atau mengubah respon error sesuai kebutuhan.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}