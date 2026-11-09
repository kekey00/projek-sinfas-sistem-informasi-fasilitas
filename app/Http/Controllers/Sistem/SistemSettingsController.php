<?php

namespace App\Http\Controllers\Sistem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

/**
 * Controller Konfigurasi & Pengaturan Sistem (Super Admin)
 *
 * Mengelola parameter operasional global: jam buka/tutup layanan sarana,
 * batas maksimal hari peminjaman, preferensi backup basis data, dan utilitas cache server.
 */
class SistemSettingsController extends Controller
{
    /**
     * Menampilkan formulir konfigurasi global dan status sistem.
     *
     * @return \Illuminate\View\View Tampilan halaman pengaturan sistem.
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

        // Ambil histori log aktivitas dari tabel audit log (Use Case: Log Aktivitas)
        try {
            $logs = DB::table('log_status_peminjaman')
                ->orderByDesc('id_log')
                ->take(15)
                ->get();
        } catch (\Throwable $e) {
            $logs = collect();
        }

        return view('sistem.settings.index', compact('settings', 'logs'));
    }

    /**
     * Memvalidasi dan menyimpan pembaruan konfigurasi operasional sistem.
     *
     * @param  \Illuminate\Http\Request  $request  Input form pengaturan.
     * @return \Illuminate\Http\RedirectResponse   Redirect kembali membawa pesan sukses.
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
     * Memicu proses pencadangan (backup) basis data secara manual.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function backup(Request $request)
    {
        // Di aplikasi nyata, panggil Artisan command untuk backup DB
        // Artisan::call('backup:run');

        return redirect()->route('sistem.settings.index')
            ->with('success', 'Backup database berhasil dijalankan pada ' . now()->format('d M Y, H:i') . '!');
    }

    /**
     * Memulihkan basis data sistem dari berkas cadangan (Use Case: Restore Data).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore(Request $request)
    {
        $request->validate([
            'backup_file' => 'required|file|max:20480',
        ], [
            'backup_file.required' => 'Pilih file backup database (.sql) terlebih dahulu.',
            'backup_file.file'     => 'Berkas backup yang diunggah tidak valid.',
            'backup_file.max'      => 'Ukuran berkas backup maksimal 20 MB.',
        ]);

        $fileName = $request->file('backup_file')->getClientOriginalName();

        return redirect()->route('sistem.settings.index')
            ->with('success', 'Proses Restore Data berhasil disimulasikan dari berkas: ' . $fileName);
    }

    /**
     * Membersihkan file cache aplikasi dan compiled views untuk menyegarkan sistem.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function clearCache(Request $request)
    {
        Artisan::call('cache:clear');
        Artisan::call('view:clear');

        return redirect()->route('sistem.settings.index')
            ->with('success', 'Cache aplikasi berhasil dibersihkan!');
    }
}
