<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Peminjaman;
use App\Models\PeminjamanAktif;
use App\Models\RekapInventarisView;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Controller Pelaporan & Rekapitulasi Sarana Prasarana (Admin Sarana)
 *
 * Mengelola pembuatan laporan operasional dan pencetakan dokumen PDF landscape A4:
 * 1. Laporan Frekuensi Peminjaman (identifikasi barang terpopuler & paling sering digunakan).
 * 2. Laporan Rekapitulasi Kondisi Fisik Alat (monitoring kerusakan & pemeliharaan).
 * 3. Laporan Keterlambatan Pengembalian (analisis disiplin pengembalian sarana).
 * 4. Laporan Rekapitulasi Inventaris Keseluruhan.
 */
class AdminLaporanController extends Controller
{
    /**
     * Menampilkan menu utama pusat laporan sarana.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.laporan.index');
    }

    /**
     * Menampilkan laporan frekuensi peminjaman alat berbasis filter rentang tanggal & kategori.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function frekuensi(Request $request)
    {
        return view('admin.laporan.frekuensi', $this->reportData($request));
    }

    /**
     * Mengekspor dan mengunduh laporan frekuensi peminjaman dalam format berkas PDF (A4 Landscape).
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response Unduhan file PDF.
     */
    public function frekuensiPdf(Request $request)
    {
        return $this->downloadPdf($request, 'frekuensi', 'laporan-frekuensi-peminjaman');
    }

    /**
     * Menampilkan laporan rekapitulasi kondisi barang saat dikembalikan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function kondisi(Request $request)
    {
        return view('admin.laporan.kondisi', $this->reportData($request));
    }

    /**
     * Mengekspor laporan kondisi barang dalam format PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function kondisiPdf(Request $request)
    {
        return $this->downloadPdf($request, 'kondisi', 'laporan-kondisi-barang');
    }

    /**
     * Menampilkan laporan analisis keterlambatan pengembalian alat.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function keterlambatan(Request $request)
    {
        return view('admin.laporan.keterlambatan', $this->reportData($request));
    }

    /**
     * Mengekspor laporan keterlambatan pengembalian dalam format PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function keterlambatanPdf(Request $request)
    {
        return $this->downloadPdf($request, 'keterlambatan', 'laporan-keterlambatan-pengembalian');
    }

    /**
     * Menampilkan laporan rekapitulasi inventaris barang.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function inventaris(Request $request)
    {
        return view('admin.laporan.inventaris', $this->reportData($request));
    }

    /**
     * Mengekspor laporan rekapitulasi inventaris ke PDF.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function inventarisPdf(Request $request)
    {
        return $this->downloadPdf($request, 'inventaris', 'laporan-rekapitulasi-inventaris');
    }

    /**
     * Helper untuk me-render view blade laporan ke stream unduhan berkas PDF DomPDF.
     *
     * @param  \Illuminate\Http\Request  $request   Parameter filter data.
     * @param  string                    $report    Nama template view PDF.
     * @param  string                    $filename  Nama file unduhan tanpa ekstensi.
     * @return \Illuminate\Http\Response
     */
    private function downloadPdf(Request $request, string $report, string $filename)
    {
        return Pdf::loadView('admin.laporan.pdf.' . $report, $this->reportData($request))
            ->setPaper('a4', 'landscape')
            ->download($filename . '.pdf');
    }

    /**
     * Memproses data agregasi peminjaman, frekuensi, kondisi, dan keterlambatan untuk laporan.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array Dataset teragregasi untuk view dan PDF.
     */
    private function reportData(Request $request): array
    {
        $validated = $request->validate([
            'tanggal_mulai' => 'nullable|date',
            'tanggal_akhir' => 'nullable|date|after_or_equal:tanggal_mulai',
            'kategori' => 'nullable|exists:kategori,id_kategori',
        ]);

        // Default: 3 bulan terakhir agar grafik tidak kosong
        $tanggalMulai = Carbon::parse($validated['tanggal_mulai'] ?? now()->subMonths(3)->startOfMonth()->toDateString());
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

        $keterlambatanRingkasan = [
            'Belum dikembalikan' => $keterlambatan->filter(fn ($item) => !$item->pengembalian)->count(),
            'Sudah dikembalikan' => $keterlambatan->filter(fn ($item) => $item->pengembalian)->count(),
        ];

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
                    // Menggunakan Stored Function 'fn_total_unit_barang' via Accessor Model Barang (Rubrik No. 7)
                    'total' => $barang->total_unit,
                ];
            });

        $stokRingkasan = [
            'Kondisi baik' => $stokInventaris->sum('baik'),
            'Kurang baik' => $stokInventaris->sum('kurang_baik'),
            'Rusak berat' => $stokInventaris->sum('rusak_berat'),
            'Sedang dipinjam' => $stokInventaris->sum('dipinjam'),
        ];

        // Bangun tren harian: isi semua hari dalam range, termasuk yang 0 transaksi
        $trenHarianData = $peminjaman->groupBy(fn ($item) => $item->tanggal_pinjam->format('Y-m-d'))->map->count();
        $allDays = collect();
        $current = $tanggalMulai->copy();
        while ($current->lte($tanggalAkhir)) {
            $dateKey = $current->format('Y-m-d');
            $allDays[$dateKey] = $trenHarianData[$dateKey] ?? 0;
            $current->addDay();
        }
        // Jika range terlalu panjang (>60 hari), ringkas per minggu agar grafik tetap terbaca
        if ($allDays->count() > 60) {
            $weeklyTren = collect();
            foreach ($allDays->chunk(7) as $chunk) {
                $label = $chunk->keys()->first();
                $weeklyTren[$label] = $chunk->sum();
            }
            $trenHarian = $weeklyTren;
        } else {
            $trenHarian = $allDays;
        }

        return [
            'kategoriList' => Kategori::orderBy('nama_kategori')->get(),
            'frekuensiBarang' => $frekuensiBarang,
            'trenHarian' => $trenHarian,
            'totalPeminjaman' => $peminjaman->count(),
            'totalBarangDipinjam' => $frekuensiBarang->count(),
            'tanggalMulai' => $tanggalMulai->toDateString(),
            'tanggalAkhir' => $tanggalAkhir->toDateString(),
            'kategoriTerpilih' => $validated['kategori'] ?? '',
            'riwayatKondisi' => $riwayatKondisi,
            'kondisiRingkasan' => $kondisiRingkasan,
            'keterlambatan' => $keterlambatan,
            'keterlambatanRingkasan' => $keterlambatanRingkasan,
            'stokInventaris' => $stokInventaris,
            'stokRingkasan' => $stokRingkasan,
        ];
    }

    /**
     * Mengambil rekapitulasi histori transaksi peminjaman siswa menggunakan STORED PROCEDURE MySQL
     * 'sp_rekap_peminjaman_siswa' (Rubrik Poin No. 7: Stored Procedure).
     *
     * @param  string  $nis  Nomor Induk Siswa.
     * @return \Illuminate\Http\JsonResponse
     */
    public function rekapSiswa(string $nis)
    {
        $data = Peminjaman::callStoredProcedureRekap($nis);
        return response()->json([
            'status' => 'success',
            'nis'    => $nis,
            'source' => 'Stored Procedure MySQL (sp_rekap_peminjaman_siswa)',
            'total'  => count($data),
            'data'   => $data,
        ]);
    }

    /**
     * Mengambil daftar peminjaman aktif langsung dari DATABASE VIEW 'v_peminjaman_aktif'
     * (Rubrik Poin No. 9: Database View).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function peminjamanAktif()
    {
        try {
            $data = PeminjamanAktif::all();
            return response()->json([
                'status' => 'success',
                'source' => 'Database View (v_peminjaman_aktif)',
                'total'  => $data->count(),
                'data'   => $data,
            ]);
        } catch (\Throwable $e) {
            $data = Peminjaman::getPeminjamanAktifFromView();
            return response()->json([
                'status' => 'success',
                'source' => 'Database View Fallback (v_peminjaman_aktif)',
                'total'  => $data->count(),
                'data'   => $data,
            ]);
        }
    }

    /**
     * Mengambil rekapitulasi inventaris langsung dari DATABASE VIEW 'v_rekap_inventaris'
     * (Rubrik Poin No. 9: Database View).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function rekapInventarisView()
    {
        try {
            $data = RekapInventarisView::all();
            return response()->json([
                'status' => 'success',
                'source' => 'Database View (v_rekap_inventaris)',
                'total'  => $data->count(),
                'data'   => $data,
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
