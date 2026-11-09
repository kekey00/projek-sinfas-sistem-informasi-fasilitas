<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * Base Controller SINFAS (Rubrik No. 1: Runtunan Class & Object).
 *
 * Kelas induk untuk seluruh controller aplikasi SINFAS.
 * Menyediakan fungsionalitas dasar seperti validasi request dan otorisasi akses
 * yang diwarisi (inheritance) oleh semua controller turunan di namespace App\Http\Controllers.
 *
 * @package App\Http\Controllers
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
