<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminVerifikasiController extends Controller
{
    /**
     * Halaman Verifikasi Pengajuan & Pengembalian (dengan Tabs).
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'requests'); // 'requests' or 'returns' or 'history'

        // 1. Pending Requests (Menunggu Verifikasi)
        $pendingRequests = Peminjaman::with(['barang.kategori', 'siswa'])
            ->where('status_pengajuan', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'req_page')
            ->withQueryString();

        // 2. Active Loans waiting for return (Sedang Dipinjam & Belum Dikembalikan)
        $activeLoans = Peminjaman::with(['barang.kategori', 'siswa'])
            ->where('status_pengajuan', 'disetujui')
            ->whereDoesntHave('pengembalian')
            ->orderBy('tanggal_kembali', 'asc')
            ->paginate(10, ['*'], 'ret_page')
            ->withQueryString();

        // 3. Riwayat Selesai (Dikembalikan atau Ditolak)
        $historyLoans = Peminjaman::with(['barang.kategori', 'siswa', 'pengembalian'])
            ->where(function ($q) {
                $q->whereHas('pengembalian')
                  ->orWhere('status_pengajuan', 'ditolak');
            })
            ->latest('updated_at')
            ->paginate(10, ['*'], 'hist_page')
            ->withQueryString();

        return view('admin.verifikasi.index', compact(
            'tab',
            'pendingRequests',
            'activeLoans',
            'historyLoans'
        ));
    }

    /**
     * Setujui pengajuan peminjaman.
     */
    public function approve(string $kode_pinjam)
    {
        $peminjaman = Peminjaman::with('barang')->findOrFail($kode_pinjam);

        if ($peminjaman->status_pengajuan !== 'menunggu') {
            return back()->with('error', 'Status pengajuan peminjaman ini sudah diproses sebelumnya.');
        }

        $barang = $peminjaman->barang;
        if (!$barang || $barang->jumlah_baik < 1) {
            return back()->with('error', 'Gagal menyetujui: Stok barang kondisi baik sedang habis atau tidak mencukupi.');
        }

        DB::transaction(function () use ($peminjaman, $barang) {
            // Update status peminjaman
            $peminjaman->update([
                'status_pengajuan' => 'disetujui',
            ]);

            // Kurangi stok barang kondisi baik
            $barang->decrement('jumlah_baik', 1);
        });

        return back()->with('success', 'Pengajuan peminjaman #' . $peminjaman->kode_pinjam . ' berhasil DISETUJUI!');
    }

    /**
     * Tolak pengajuan peminjaman.
     */
    public function reject(Request $request, string $kode_pinjam)
    {
        $peminjaman = Peminjaman::findOrFail($kode_pinjam);

        if ($peminjaman->status_pengajuan !== 'menunggu') {
            return back()->with('error', 'Status pengajuan peminjaman ini sudah diproses sebelumnya.');
        }

        $alasan = $request->input('alasan') ?: $request->input('alasan_penolakan', 'Ditolak oleh admin sarana');

        $peminjaman->update([
            'status_pengajuan'      => 'ditolak',
            'keterangan_penggunaan' => $peminjaman->keterangan_penggunaan . ($alasan ? ' [Catatan: ' . $alasan . ']' : ''),
        ]);

        return back()->with('success', 'Pengajuan peminjaman #' . $peminjaman->kode_pinjam . ' telah DITOLAK.');
    }

    /**
     * Verifikasi penerimaan pengembalian alat dan pencatatan kondisi barang.
     */
    public function verifikasiPengembalian(Request $request, string $kode_pinjam)
    {
        $request->validate([
            'kondisi_barang'  => 'required|in:Baik,Kurang Baik,Rusak Berat',
            'tanggal_kembali' => 'required|date',
            'catatan'         => 'nullable|string',
        ], [
            'kondisi_barang.required'  => 'Pilih kondisi fisik alat saat dikembalikan.',
            'tanggal_kembali.required' => 'Tanggal pengembalian wajib diisi.',
        ]);

        $peminjaman = Peminjaman::with('barang')->findOrFail($kode_pinjam);

        // Pastikan belum pernah dikembalikan
        if ($peminjaman->pengembalian()->exists()) {
            return back()->with('error', 'Peminjaman ini sudah tercatat telah dikembalikan sebelumnya.');
        }

        DB::transaction(function () use ($request, $peminjaman) {
            // 1. Buat catatan pengembalian
            Pengembalian::create([
                'kode_kembali'    => Pengembalian::generateKode(),
                'kode_pinjam'     => $peminjaman->kode_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'kondisi_barang'  => $request->kondisi_barang,
                'bukti_foto_video'=> $request->catatan,
            ]);

            // 2. Pulihkan / sesuaikan stok alat sesuai kondisi saat kembali
            $barang = $peminjaman->barang;
            if ($barang) {
                if ($request->kondisi_barang === 'Baik') {
                    $barang->increment('jumlah_baik', 1);
                } elseif ($request->kondisi_barang === 'Kurang Baik') {
                    $barang->increment('jumlah_kurang_baik', 1);
                } elseif ($request->kondisi_barang === 'Rusak Berat') {
                    $barang->increment('jumlah_rusak_berat', 1);
                }
            }
        });

        return back()->with('success', 'Pengembalian alat untuk peminjaman #' . $peminjaman->kode_pinjam . ' berhasil diverifikasi & stok diperbarui!');
    }
}
