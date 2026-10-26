<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\View\View;

class AdminNotificationController extends Controller
{
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
