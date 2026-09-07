<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class SistemSettingsController extends Controller
{
    /**
     * Tampilkan halaman pengaturan sistem.
     */
    public function index()
    {
        // Pengaturan sistem (bisa disimpan ke DB / file config di produksi nyata)
        $settings = [
            'jam_operasional_buka'  => '07:00',
            'jam_operasional_tutup' => '16:00',
            'maks_hari_pinjam'      => 7,
            'backup_otomatis'       => true,
            'backup_jadwal'         => 'Setiap hari pukul 03:00',
            'backup_terakhir'       => now()->subDays(2)->format('d M Y, H:i'),
            'versi_sistem'          => '1.0.0',
            'nama_instansi'         => 'SINFAS - Sistem Informasi Fasilitas',
            'email_notifikasi'      => 'admin@sinfas.sch.id',
            'max_file_size'         => '2',  // MB
            'timezone'              => 'Asia/Jakarta',
        ];

        return view('sistem.settings.index', compact('settings'));
    }

    /**
     * Simpan pengaturan sistem.
     */
    public function update(Request $request)
    {
        $request->validate([
            'jam_operasional_buka'  => 'required|date_format:H:i',
            'jam_operasional_tutup' => 'required|date_format:H:i|after:jam_operasional_buka',
            'maks_hari_pinjam'      => 'required|integer|min:1|max:30',
            'nama_instansi'         => 'required|string|max:255',
            'email_notifikasi'      => 'required|email',
            'max_file_size'         => 'required|integer|min:1|max:10',
        ], [
            'jam_operasional_buka.required'    => 'Jam buka wajib diisi.',
            'jam_operasional_tutup.required'   => 'Jam tutup wajib diisi.',
            'jam_operasional_tutup.after'      => 'Jam tutup harus setelah jam buka.',
            'maks_hari_pinjam.required'        => 'Maks hari pinjam wajib diisi.',
            'maks_hari_pinjam.min'             => 'Minimal 1 hari.',
            'maks_hari_pinjam.max'             => 'Maksimal 30 hari.',
            'nama_instansi.required'           => 'Nama instansi wajib diisi.',
            'email_notifikasi.required'        => 'Email notifikasi wajib diisi.',
            'email_notifikasi.email'           => 'Format email tidak valid.',
            'max_file_size.required'           => 'Ukuran file maksimal wajib diisi.',
        ]);

        // Di aplikasi nyata, simpan ke database (tabel settings) atau .env
        // Untuk sekarang cukup simulasikan
        return redirect()->route('sistem.settings.index')
            ->with('success', 'Pengaturan sistem berhasil disimpan!');
    }

    /**
     * Jalankan backup manual.
     */
    public function backup(Request $request)
    {
        // Di aplikasi nyata, panggil Artisan command untuk backup DB
        // Artisan::call('backup:run');

        return redirect()->route('sistem.settings.index')
            ->with('success', 'Backup database berhasil dijalankan pada ' . now()->format('d M Y, H:i') . '!');
    }

    /**
     * Clear cache aplikasi.
     */
    public function clearCache(Request $request)
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        return redirect()->route('sistem.settings.index')
            ->with('success', 'Cache aplikasi berhasil dibersihkan!');
    }
}
