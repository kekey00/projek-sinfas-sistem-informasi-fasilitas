<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Controller Admin Verifikasi Sarana & Prasarana
 *
 * Mengelola antrean verifikasi persetujuan permohonan pinjam alat,
 * penolakan pengajuan, verifikasi fisik barang yang dikembalikan,
 * serta penyesuaian otomatis stok fisik barang (Baik, Kurang Baik, Rusak Berat).
 */
class AdminVerifikasiController extends Controller
{
    /**
     * Menampilkan dashboard verifikasi peminjaman dan pengembalian sarana (berbasis multi-tab & pagination).
     *
     * Tab yang tersedia:
     * 1. 'requests': Permohonan baru yang membutuhkan persetujuan/penolakan (status: 'menunggu').
     * 2. 'returns' : Pengembalian alat yang menunggu konfirmasi fisik dari petugas.
     * 3. 'history' : Seluruh arsip peminjaman yang telah selesai, ditolak, atau dibatalkan.
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request dengan opsi parameter query 'tab'.
     * @return \Illuminate\View\View Tampilan dashboard verifikasi admin.
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

        // Peminjaman tetap berstatus aktif sampai admin memverifikasi fisik pengembalian barang.
        $borrowedLoansQuery = Peminjaman::with(['barang.kategori', 'siswa', 'pengembalian'])
            ->where('status_pengajuan', 'disetujui')
            ->where(function ($q) {
                $q->whereDoesntHave('pengembalian')
                  ->orWhereHas('pengembalian', function ($p) {
                      $p->where('status', 'menunggu');
                  });
            });

        $borrowedLoans = (clone $borrowedLoansQuery)
            ->orderBy('tanggal_kembali', 'asc')
            ->paginate(10, ['*'], 'loan_page')
            ->withQueryString();

        // Peminjaman aktif yang menunggu verifikasi pengembalian diurutkan terlebih dahulu.
        $activeLoans = (clone $borrowedLoansQuery)
            ->orderByRaw("CASE WHEN EXISTS (SELECT 1 FROM pengembalian WHERE pengembalian.kode_pinjam = peminjaman.kode_pinjam AND pengembalian.status = 'menunggu') THEN 0 ELSE 1 END")
            ->orderBy('tanggal_kembali', 'asc')
            ->paginate(10, ['*'], 'ret_page')
            ->withQueryString();

        // 3. Riwayat Selesai (Dikembalikan Selesai atau Ditolak)
        $historyLoans = Peminjaman::with(['barang.kategori', 'siswa', 'pengembalian'])
            ->where(function ($q) {
                $q->whereHas('pengembalian', function ($p) {
                    $p->where('status', 'selesai');
                })
                ->orWhereIn('status_pengajuan', ['ditolak', 'dibatalkan']);
            })
            ->latest('updated_at')
            ->paginate(10, ['*'], 'hist_page')
            ->withQueryString();

        return view('admin.verifikasi.index', compact(
            'tab',
            'pendingRequests',
            'borrowedLoans',
            'activeLoans',
            'historyLoans'
        ));
    }

    /**
     * Menyetujui permohonan peminjaman sarana dan memotong stok fisik barang.
     *
     * Aturan Bisnis & Transaksi:
     * - Status permohonan harus masih 'menunggu'.
     * - Stok fisik barang kondisi baik (`jumlah_baik`) minimal tersedia 1 unit.
     * - Dibungkus dalam DB Transaction: status diubah ke 'disetujui' dan stok dipotong secara atomik (-1).
     *
     * @param  string  $kode_pinjam  Kode unik transaksi peminjaman (contoh: PJM-20261109-0001).
     * @return \Illuminate\Http\RedirectResponse  Redirect kembali dengan flash notification hasil persetujuan.
     *
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException Jika kode peminjaman tidak ditemukan (HTTP 404).
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
            $stokAwal = DB::table('barang')->where('kode_barang', $barang->kode_barang)->value('jumlah_baik');

            // Update status peminjaman (memicu TRIGGER trg_peminjaman_after_update di MySQL jika terpasang)
            $peminjaman->update([
                'status_pengajuan' => 'disetujui',
            ]);

            // Cek apakah trigger basis data sudah otomatis memotong stok
            $stokTerkini = DB::table('barang')->where('kode_barang', $barang->kode_barang)->value('jumlah_baik');

            // Fallback: Jika trigger database belum aktif di lingkungan lokal user, kurangi stok via Eloquent
            if ($stokTerkini == $stokAwal) {
                $barang->decrement('jumlah_baik', 1);
            }
        });

        return back()
            ->with('success', 'Pengajuan peminjaman #' . $peminjaman->kode_pinjam . ' berhasil disetujui!')
            ->with('toast_title', 'Persetujuan pengajuan berhasil');
    }

    /**
     * Menolak permohonan peminjaman sarana oleh admin dengan menyertakan alasan.
     *
     * Aturan Bisnis:
     * - Pengajuan hanya bisa ditolak bila statusnya masih 'menunggu'.
     * - Catatan penolakan ditambahkan ke kolom `keterangan_penggunaan` agar terbaca oleh siswa.
     *
     * @param  \Illuminate\Http\Request  $request      HTTP request membawa data alasan penolakan.
     * @param  string                    $kode_pinjam  Kode unik transaksi peminjaman.
     * @return \Illuminate\Http\RedirectResponse       Redirect kembali ke panel admin.
     */
    public function reject(Request $request, string $kode_pinjam)
    {
        $peminjaman = Peminjaman::findOrFail($kode_pinjam);

        if ($peminjaman->status_pengajuan !== 'menunggu') {
            return back()
                ->with('error', 'Status pengajuan peminjaman ini sudah diproses sebelumnya.')
                ->with('toast_title', 'Penolakan pengajuan gagal');
        }

        $alasan = $request->input('alasan') ?: $request->input('alasan_penolakan', 'Ditolak oleh admin sarana');

        $peminjaman->update([
            'status_pengajuan'      => 'ditolak',
            'keterangan_penggunaan' => $peminjaman->keterangan_penggunaan . ($alasan ? ' [Catatan: ' . $alasan . ']' : ''),
        ]);

        return back()
            ->with('success', 'Pengajuan peminjaman #' . $peminjaman->kode_pinjam . ' telah ditolak.')
            ->with('toast_title', 'Penolakan pengajuan berhasil');
    }

    /**
     * Memverifikasi kondisi fisik penerimaan alat kembali dan memulihkan stok inventaris sekolah.
     *
     * Aturan Bisnis & Penyesuaian Stok:
     * - Memverifikasi kondisi aktual barang saat diserahkan ke ruang sarana (Baik / Kurang Baik / Rusak Berat).
     * - Jika kondisi 'Baik', kolom `jumlah_baik` bertambah 1.
     * - Jika 'Kurang Baik', kolom `jumlah_kurang_baik` bertambah 1 (perlu pemeliharaan ringan).
     * - Jika 'Rusak Berat', kolom `jumlah_rusak_berat` bertambah 1 (perlu perbaikan/penghapusan aset).
     * - Menandai status pengembalian menjadi 'selesai'.
     *
     * @param  \Illuminate\Http\Request  $request      Data form verifikasi fisik pengembalian.
     * @param  string                    $kode_pinjam  Kode transaksi peminjaman.
     * @return \Illuminate\Http\RedirectResponse       Redirect kembali membawa pesan sukses & pemulihan stok.
     */
    public function verifikasiPengembalian(Request $request, string $kode_pinjam)
    {
        $request->validate([
            'kondisi_barang'  => 'required|in:Baik,Kurang Baik,Rusak Berat',
            'tanggal_kembali' => 'required|date',
            'catatan'         => 'nullable|string|max:500',
            'bukti_foto'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'kondisi_barang.required'  => 'Pilih kondisi fisik alat saat dikembalikan.',
            'tanggal_kembali.required' => 'Tanggal pengembalian wajib diisi.',
            'bukti_foto.image'         => 'File bukti harus berupa gambar (JPG, PNG, WebP).',
            'bukti_foto.max'           => 'Ukuran foto maksimal 5 MB.',
        ]);

        $peminjaman = Peminjaman::with(['barang', 'pengembalian'])->findOrFail($kode_pinjam);

        $existingPengembalian = $peminjaman->pengembalian;
        if ($existingPengembalian && $existingPengembalian->status === 'selesai') {
            return back()
                ->with('error', 'Peminjaman ini sudah tercatat telah selesai dikembalikan sebelumnya.')
                ->with('toast_title', 'Konfirmasi pengembalian barang gagal');
        }

        DB::transaction(function () use ($request, $peminjaman, $existingPengembalian) {
            $fotoPath = null;
            if ($request->hasFile('bukti_foto')) {
                $fotoPath = $request->file('bukti_foto')->store('pengembalian', 'public');
            }

            // Ambil snapshot stok sebelum status pengembalian diselesaikan
            $stokAwal = DB::table('barang')->where('kode_barang', $peminjaman->kode_barang)->first();

            if ($existingPengembalian) {
                // Update catatan pengembalian dari siswa menjadi 'selesai'
                $dataToUpdate = [
                    'tanggal_kembali' => $request->tanggal_kembali,
                    'kondisi_barang'  => $request->kondisi_barang,
                    'status'          => 'selesai',
                ];
                if ($fotoPath) {
                    $dataToUpdate['bukti_foto_video'] = $fotoPath;
                }
                $existingPengembalian->update($dataToUpdate);
            } else {
                // Catat pengembalian manual langsung selesai
                Pengembalian::create([
                    'kode_kembali'     => Pengembalian::generateKode(),
                    'kode_pinjam'      => $peminjaman->kode_pinjam,
                    'tanggal_kembali'  => $request->tanggal_kembali,
                    'kondisi_barang'   => $request->kondisi_barang,
                    'bukti_foto_video' => $fotoPath ?? $request->catatan,
                    'status'           => 'selesai',
                ]);
            }

            // Cek snapshot stok setelah update/insert (apakah TRIGGER MySQL sudah memulihkan stok)
            $stokTerkini = DB::table('barang')->where('kode_barang', $peminjaman->kode_barang)->first();
            $barang = $peminjaman->barang;

            // Fallback: Jika trigger basis data belum aktif di lingkungan lokal user, pulihkan via Eloquent
            if ($barang && $stokAwal && $stokTerkini
                && $stokAwal->jumlah_baik == $stokTerkini->jumlah_baik
                && $stokAwal->jumlah_kurang_baik == $stokTerkini->jumlah_kurang_baik
                && $stokAwal->jumlah_rusak_berat == $stokTerkini->jumlah_rusak_berat) {
                if ($request->kondisi_barang === 'Baik') {
                    $barang->increment('jumlah_baik', 1);
                } elseif ($request->kondisi_barang === 'Kurang Baik') {
                    $barang->increment('jumlah_kurang_baik', 1);
                } elseif ($request->kondisi_barang === 'Rusak Berat') {
                    $barang->increment('jumlah_rusak_berat', 1);
                }
            }
        });

        return back()
            ->with('success', 'Pengembalian alat untuk peminjaman #' . $peminjaman->kode_pinjam . ' berhasil diverifikasi & stok fisik diperbarui!')
            ->with('toast_title', 'Konfirmasi pengembalian barang berhasil');
    }

    /**
     * Endpoint API polling AJAX untuk auto-refresh dashboard verifikasi admin secara berkala (real-time).
     *
     * Menghitung jumlah permohonan baru dan pengembalian yang belum diproses,
     * serta mengembalikan data terkini untuk memicu notifikasi toast/audio pada panel admin.
     *
     * @return \Illuminate\Http\JsonResponse Respon JSON berisi penghitung dan rincian transaksi baru.
     */
    public function liveCheck(): \Illuminate\Http\JsonResponse
    {
        $pendingLoansCount = Peminjaman::where('status_pengajuan', 'menunggu')->count();
        $pendingReturnsCount = Pengembalian::where('status', 'menunggu')->count();
        $totalPending = $pendingLoansCount + $pendingReturnsCount;

        $latestPending = Peminjaman::with(['barang', 'siswa'])
            ->where('status_pengajuan', 'menunggu')
            ->latest('created_at')
            ->first();

        $latestReturn = Pengembalian::with(['peminjaman.barang', 'peminjaman.siswa'])
            ->where('status', 'menunggu')
            ->latest('created_at')
            ->first();

        return response()->json([
            'success'         => true,
            'pending_loans'   => $pendingLoansCount,
            'pending_returns' => $pendingReturnsCount,
            'total_pending'   => $totalPending,
            'latest_pending'  => $latestPending ? [
                'kode_pinjam' => $latestPending->kode_pinjam,
                'nama_siswa'  => $latestPending->siswa->nama ?? 'Siswa',
                'nama_barang' => $latestPending->barang->nama_barang ?? 'Barang',
                'created_at'  => $latestPending->created_at ? $latestPending->created_at->diffForHumans() : '',
                'timestamp'   => $latestPending->created_at ? $latestPending->created_at->timestamp : 0,
            ] : null,
            'latest_return'   => $latestReturn ? [
                'kode_kembali'=> $latestReturn->kode_kembali,
                'kode_pinjam' => $latestReturn->kode_pinjam,
                'nama_siswa'  => $latestReturn->peminjaman->siswa->nama ?? 'Siswa',
                'nama_barang' => $latestReturn->peminjaman->barang->nama_barang ?? 'Barang',
                'created_at'  => $latestReturn->created_at ? $latestReturn->created_at->diffForHumans() : '',
                'timestamp'   => $latestReturn->created_at ? $latestReturn->created_at->timestamp : 0,
            ] : null,
        ]);
    }
}
