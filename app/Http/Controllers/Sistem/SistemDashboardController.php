<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use App\Models\Akun;

class SistemDashboardController extends Controller
{
    public function index()
    {
        // Statistik Akun langsung dari database
        $totalAkun = Akun::count();
        $totalSiswa = Akun::where('role', 'siswa')->count();
        $totalAdminSarana = Akun::where('role', 'admin_sarana')->count();
        $totalAdminSistem = Akun::where('role', 'admin_sistem')->count();

        // Akun baru bulan ini sesuai data mockup
        $akunBulanIni = 8;
        $periodeBulan = 'Ditambahkan Agustus 2026';

        // Backup terakhir sesuai mockup
        $backupRelative = '2 hari lalu';
        $backupTerakhir = '25 Agu 2026, 03:00';

        return view('sistem.dashboard', compact(
            'totalAkun',
            'akunBulanIni',
            'periodeBulan',
            'totalSiswa',
            'totalAdminSarana',
            'totalAdminSistem',
            'backupRelative',
            'backupTerakhir'
        ));
    }
}
