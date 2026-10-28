<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StudentLoanHistoryController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $akun = $request->user();
        abort_unless($akun->role === 'siswa' && $akun->nis, 403, 'Riwayat ini hanya tersedia untuk siswa.');

        $peminjamans = Peminjaman::query()
            ->with(['barang:kode_barang,nama_barang', 'pengembalian'])
            ->where('nis', $akun->nis)
            ->latest('created_at')
            ->get();

        return response()->json([
            'data' => [
                'summary' => [
                    'total_pengajuan' => $peminjamans->count(),
                    'total_dipinjam' => $peminjamans->filter(fn (Peminjaman $peminjaman) => $this->resolveLoanStatus($peminjaman) === 'disetujui')->count(),
                    'menunggu_verifikasi' => $peminjamans->filter(fn (Peminjaman $peminjaman) => in_array($this->resolveLoanStatus($peminjaman), ['menunggu', 'menunggu_pengembalian'], true))->count(),
                    'ditolak' => $peminjamans->filter(fn (Peminjaman $peminjaman) => $this->resolveLoanStatus($peminjaman) === 'ditolak')->count(),
                ],
                'items' => $peminjamans->map(function (Peminjaman $peminjaman) {
                    return [
                        'kode_pinjam' => $peminjaman->kode_pinjam,
                        'nama_barang' => $peminjaman->barang?->nama_barang ?? 'Barang',
                        'status' => $this->resolveLoanStatus($peminjaman),
                        'tanggal_pengajuan' => $peminjaman->created_at?->toIso8601String(),
                        'tanggal_pinjam' => $peminjaman->tanggal_pinjam?->format('Y-m-d'),
                        'jam_pinjam' => $peminjaman->jam_pinjam,
                        'tanggal_kembali' => $peminjaman->tanggal_kembali?->format('Y-m-d'),
                        'jam_kembali' => $peminjaman->jam_kembali,
                        'tanggal_pengembalian' => $peminjaman->pengembalian?->tanggal_kembali?->format('Y-m-d'),
                        'waktu_laporan_pengembalian' => $peminjaman->pengembalian?->created_at?->toIso8601String(),
                    ];
                })->values(),
            ],
        ]);
    }

    private function resolveLoanStatus(Peminjaman $peminjaman): string
    {
        $statusPengembalian = $peminjaman->pengembalian?->status;

        if ($statusPengembalian === 'selesai') {
            return 'selesai';
        }

        if ($statusPengembalian === 'menunggu') {
            return 'menunggu_pengembalian';
        }

        return $peminjaman->status_pengajuan ?? 'menunggu';
    }
}