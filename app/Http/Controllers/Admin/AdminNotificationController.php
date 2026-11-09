<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\View\View;

/**
 * Controller Pusat Notifikasi Admin Sarana
 *
 * Mengelola daftar notifikasi tugas mendesak bagi staf sarana:
 * - Tab 1: Daftar permohonan peminjaman yang menunggu persetujuan (pending loans).
 * - Tab 2: Daftar barang yang telah dilaporkan kembali oleh siswa dan menunggu pengecekan fisik (pending returns).
 */
class AdminNotificationController extends Controller
{
    /**
     * Menampilkan pusat pemberitahuan antrean verifikasi peminjaman dan pengembalian.
     *
     * @return \Illuminate\View\View Tampilan daftar notifikasi tugas verifikasi admin.
     */
    public function index(): View
    {
        $pendingLoans = Peminjaman::with(['barang', 'siswa'])
            ->where('status_pengajuan', 'menunggu')
            ->latest()
            ->paginate(10, ['*'], 'loan_page')
            ->withQueryString();

        $pendingReturns = Pengembalian::with(['peminjaman.barang', 'peminjaman.siswa'])
            ->where('status', 'menunggu')
            ->latest()
            ->paginate(10, ['*'], 'return_page')
            ->withQueryString();

        return view('admin.notifications.index', compact('pendingLoans', 'pendingReturns'));
    }
}
