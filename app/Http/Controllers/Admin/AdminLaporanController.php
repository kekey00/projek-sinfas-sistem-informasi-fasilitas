<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminLaporanController extends Controller
{
    public function index()
    {
        return view('admin.laporan.index');
    }

    public function frekuensi(Request $request)
    {
        return view('admin.laporan.frekuensi', $this->reportData($request));
    }

    public function frekuensiPdf(Request $request)
    {
        return $this->downloadPdf($request, 'frekuensi', 'laporan-frekuensi-peminjaman');
    }

    public function kondisi(Request $request)
    {
        return view('admin.laporan.kondisi', $this->reportData($request));
    }

    public function kondisiPdf(Request $request)
    {
        return $this->downloadPdf($request, 'kondisi', 'laporan-kondisi-barang');
    }

    public function keterlambatan(Request $request)
    {
        return view('admin.laporan.keterlambatan', $this->reportData($request));
    }

    public function keterlambatanPdf(Request $request)
    {
        return $this->downloadPdf($request, 'keterlambatan', 'laporan-keterlambatan-pengembalian');
    }

    public function inventaris(Request $request)
    {
        return view('admin.laporan.inventaris', $this->reportData($request));
    }

    public function inventarisPdf(Request $request)
    {
        return $this->downloadPdf($request, 'inventaris', 'laporan-rekapitulasi-inventaris');
    }

    private function downloadPdf(Request $request, string $report, string $filename)
    {
        return Pdf::loadView('admin.laporan.pdf.' . $report, $this->reportData($request))
            ->setPaper('a4', 'landscape')
            ->download($filename . '.pdf');
    }

    private function reportData(Request $request): array
    {
        $validated = $request->validate([
            'tanggal_mulai' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'kategori' => 'nullable|exists:kategori,id_kategori',
        ]);

        $tanggalMulai = Carbon::parse($validated['tanggal_mulai'] ?? now()->startOfMonth()->toDateString());
        $tanggalAkhir = Carbon::parse($validated['tanggal_akhir'] ?? now()->toDateString());
        $peminjaman = Peminjaman::with(['barang.kategori', 'pengembalian', 'siswa'])
            ->whereIn('status_pengajuan', ['disetujui', 'dikembalikan'])
            ->whereBetween('tanggal_pinjam', [$tanggalMulai->toDateString(), $tanggalAkhir->toDateString()])
            ->when($validated['kategori'] ?? null, function ($query, $kategori) {
                $query->whereHas('barang', fn ($barang) => $barang->where('id_kategori', $kategori));
            })
            ->get();

        $frekuensiBarang = $peminjaman->groupBy('kode_barang')->map(function ($items) {
            $barang = $items->first()->barang;
            return [
                'nama_barang' => $barang->nama_barang ?? 'Barang tidak ditemukan',
                'kategori' => $barang->kategori->nama_kategori ?? '-',
                'frekuensi' => $items->count(),
            ];
        })->sortByDesc('frekuensi')->values();

        $riwayatKondisi = $peminjaman->filter(fn ($item) => $item->pengembalian)
            ->sortByDesc(fn ($item) => $item->pengembalian->tanggal_kembali)->values();
        $kondisiRingkasan = $riwayatKondisi->groupBy(fn ($item) => $item->pengembalian->kondisi_barang ?: 'Belum dicatat')->map->count();

        $keterlambatan = $peminjaman->filter(function ($item) {
            if (!$item->tanggal_kembali) return false;
            $tanggalAktual = $item->pengembalian?->tanggal_kembali ?? now();
            return $tanggalAktual->greaterThan($item->tanggal_kembali);
        })->sortByDesc(fn ($item) => $item->pengembalian?->tanggal_kembali ?? now())->values();

        $stokInventaris = Barang::with(['kategori', 'peminjamans.pengembalian'])
            ->when($validated['kategori'] ?? null, fn ($query, $kategori) => $query->where('id_kategori', $kategori))
            ->orderBy('nama_barang')->get()->map(function ($barang) {
                $dipinjam = $barang->peminjamans->filter(fn ($item) => $item->status_pengajuan === 'disetujui' && (!$item->pengembalian || $item->pengembalian->status !== 'selesai'))->count();
                return [
                    'nama_barang' => $barang->nama_barang,
                    'kategori' => $barang->kategori->nama_kategori ?? '-',
                    'baik' => $barang->jumlah_baik,
                    'kurang_baik' => $barang->jumlah_kurang_baik,
                    'rusak_berat' => $barang->jumlah_rusak_berat,
                    'dipinjam' => $dipinjam,
                    'total' => $barang->jumlah_baik + $barang->jumlah_kurang_baik + $barang->jumlah_rusak_berat,
                ];
            });

        return [
            'kategoriList' => Kategori::orderBy('nama_kategori')->get(),
            'frekuensiBarang' => $frekuensiBarang,
            'trenHarian' => $peminjaman->groupBy(fn ($item) => $item->tanggal_pinjam->format('Y-m-d'))->map->count(),
            'totalPeminjaman' => $peminjaman->count(),
            'totalBarangDipinjam' => $frekuensiBarang->count(),
            'tanggalMulai' => $tanggalMulai->toDateString(),
            'tanggalAkhir' => $tanggalAkhir->toDateString(),
            'kategoriTerpilih' => $validated['kategori'] ?? '',
            'riwayatKondisi' => $riwayatKondisi,
            'kondisiRingkasan' => $kondisiRingkasan,
            'keterlambatan' => $keterlambatan,
            'stokInventaris' => $stokInventaris,
        ];
    }
}
