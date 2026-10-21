<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Siswa;
use App\Models\Akun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PeminjamanController extends Controller
{
    /**
     * Halaman Status Pengajuan User (Daftar semua pinjaman user)
     */
    public function status()
    {
        $user = Auth::user();
        $peminjamans = Peminjaman::with(['barang.kategori', 'pengembalian'])
            ->where('nis', $user->nis)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.status', compact('peminjamans'));
    }

    /**
     * Halaman khusus Semua Notifikasi User dengan Pagination
     */
    public function notifikasi(Request $request)
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'siswa') {
            return redirect()->route('login');
        }

        $allNotifs = self::getUserNotifications($user);
        $totalAll = $allNotifs->count();

        // Filter tab
        $tab = $request->get('filter', 'all');
        if ($tab !== 'all') {
            $allNotifs = $allNotifs->filter(function ($n) use ($tab) {
                if ($tab === 'attention') {
                    return in_array($n['type'], ['overdue', 'warning']);
                }
                return $n['type'] === $tab;
            });
        }

        // Pagination Collection (6 notifikasi per halaman)
        $currentPage = \Illuminate\Pagination\Paginator::resolveCurrentPage() ?: 1;
        $perPage = 6;
        $currentPageItems = $allNotifs->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginatedNotifications = new \Illuminate\Pagination\LengthAwarePaginator(
            $currentPageItems,
            $allNotifs->count(),
            $perPage,
            $currentPage,
            [
                'path' => \Illuminate\Pagination\Paginator::resolveCurrentPath(),
                'query' => $request->query(),
            ]
        );

        $rawAll = self::getUserNotifications($user);
        $counts = [
            'all'       => $totalAll,
            'attention' => $rawAll->filter(fn($n) => in_array($n['type'], ['overdue', 'warning']))->count(),
            'pending'   => $rawAll->filter(fn($n) => $n['type'] === 'pending')->count(),
            'active'    => $rawAll->filter(fn($n) => $n['type'] === 'active')->count(),
        ];

        return view('user.notifikasi', [
            'notifications' => $paginatedNotifications,
            'currentFilter' => $tab,
            'counts'        => $counts,
        ]);
    }

    /**
     * Simpan pengajuan peminjaman dari form user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode_barang'           => 'required|string|exists:barang,kode_barang',
            'nomor_telepon'         => 'required|string|max:20',
            'tanggal_pinjam'        => 'required|date|after_or_equal:today',
            'tanggal_kembali'       => 'required|date|after_or_equal:tanggal_pinjam',
            'keterangan_penggunaan' => 'required|string|max:1000',
        ], [
            'nomor_telepon.required'         => 'Nomor telepon / WhatsApp peminjam wajib diisi.',
            'nomor_telepon.max'              => 'Nomor telepon maksimal 20 karakter.',
            'tanggal_pinjam.required'        => 'Tanggal pinjam wajib diisi.',
            'tanggal_pinjam.after_or_equal'  => 'Tanggal pinjam tidak boleh sebelum hari ini.',
            'tanggal_kembali.required'       => 'Rencana tanggal kembali wajib diisi.',
            'tanggal_kembali.after_or_equal' => 'Tanggal kembali tidak boleh sebelum tanggal pinjam.',
            'keterangan_penggunaan.required' => 'Tujuan / alasan peminjaman wajib diisi.',
        ]);

        $barang = Barang::findOrFail($request->kode_barang);

        // Cek stok barang tersedia
        if ($barang->jumlah_baik < 1) {
            return back()->withErrors(['stok' => 'Maaf, barang ini sedang tidak tersedia untuk dipinjam.'])->withInput();
        }

        $kodePinjam = Peminjaman::generateKode();

        Peminjaman::create([
            'kode_pinjam'           => $kodePinjam,
            'nis'                   => Auth::user()->nis,
            'nomor_telepon'         => $request->nomor_telepon,
            'kode_barang'           => $request->kode_barang,
            'tanggal_pinjam'        => $request->tanggal_pinjam,
            'tanggal_kembali'       => $request->tanggal_kembali,
            'keterangan_penggunaan' => $request->keterangan_penggunaan,
            'status_pengajuan'      => 'menunggu',
        ]);

        // Perbarui nomor kontak di akun & data siswa agar profil selalu terupdate
        $user = Auth::user();
        if ($user) {
            Akun::where('id_akun', $user->id_akun)->update(['nomor_kontak' => $request->nomor_telepon]);
            if ($user->nis) {
                Siswa::where('nis', $user->nis)->update(['no_hp' => $request->nomor_telepon]);
            }
        }

        return redirect()->route('user.status')
            ->with('loan_submitted', true)
            ->with('loan_item_name', $barang->nama_barang)
            ->with('success', 'Pengajuan peminjaman "' . $barang->nama_barang . '" berhasil dikirim!');
    }

    /**
     * Tampilkan form pengembalian barang.
     */
    public function createPengembalian(string $kode_pinjam)
    {
        $peminjaman = Peminjaman::with(['barang.kategori', 'pengembalian'])
            ->where('nis', Auth::user()->nis)
            ->findOrFail($kode_pinjam);

        if ($peminjaman->status_pengajuan !== 'disetujui') {
            return redirect()->route('user.status')->with('error', 'Barang ini belum disetujui untuk dipinjam.');
        }

        if ($peminjaman->pengembalian()->exists()) {
            return redirect()->route('user.status')->with('error', 'Barang ini sudah pernah dilaporkan dikembalikan.');
        }

        return view('user.pengembalian', compact('peminjaman'));
    }

    /**
     * Proses pengajuan pengembalian barang dari user.
     */
    public function storePengembalian(Request $request, string $kode_pinjam)
    {
        $request->validate([
            'tanggal_kembali' => 'required|date',
            'kondisi_barang'  => 'required|in:Baik,Kurang Baik,Rusak Berat',
            'bukti_foto'      => 'required|file|mimes:jpeg,png,jpg,webp,mp4,mov,avi,webm,mkv|max:25600',
            'catatan'         => 'nullable|string|max:500',
        ], [
            'tanggal_kembali.required' => 'Tanggal pengembalian wajib diisi.',
            'kondisi_barang.required'  => 'Pilih kondisi barang saat dikembalikan.',
            'bukti_foto.required'      => 'Pengajuan pengembalian barang wajib menyertakan bukti foto atau video fisik.',
            'bukti_foto.file'          => 'Bukti harus berupa file foto atau video yang valid.',
            'bukti_foto.mimes'         => 'Format file bukti harus berupa foto (JPG, JPEG, PNG, WebP) atau video (MP4, MOV, WebM, AVI).',
            'bukti_foto.max'           => 'Ukuran file foto atau video maksimal 25 MB.',
        ]);

        $peminjaman = Peminjaman::with('barang')
            ->where('nis', Auth::user()->nis)
            ->findOrFail($kode_pinjam);

        if ($peminjaman->pengembalian()->exists()) {
            return redirect()->route('user.status')->with('error', 'Barang ini sudah dikembalikan sebelumnya.');
        }

        DB::transaction(function () use ($request, $peminjaman) {
            $mediaPath = $request->file('bukti_foto')->store('pengembalian', 'public');

            // Simpan pengembalian dengan status menunggu verifikasi admin
            Pengembalian::create([
                'kode_kembali'     => Pengembalian::generateKode(),
                'kode_pinjam'      => $peminjaman->kode_pinjam,
                'tanggal_kembali'  => $request->tanggal_kembali,
                'kondisi_barang'   => $request->kondisi_barang,
                'bukti_foto_video' => $mediaPath,
                'status'           => 'menunggu',
            ]);

            // Catatan: Stok barang belum dipulihkan disini, akan dipulihkan saat Admin Sarana memverifikasi pengembalian.
        });

        return redirect()->route('user.status')->with('success', 'Laporan pengembalian barang "' . ($peminjaman->barang->nama_barang ?? 'Barang') . '" berhasil diajukan dengan bukti foto/video! Menunggu verifikasi fisik dari Admin.');
    }

    /**
     * Dapatkan daftar notifikasi aktif untuk user siswa
     */
    public static function getUserNotifications($user)
    {
        $notifications = collect();
        if (!$user || $user->role !== 'siswa') {
            return $notifications;
        }

        $now = \Carbon\Carbon::now();

        // 1. Peminjaman yang masih menunggu verifikasi admin
        $pending = Peminjaman::with('barang')
            ->where('nis', $user->nis)
            ->where('status_pengajuan', 'menunggu')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($pending as $pjm) {
            $notifications->push([
                'type'    => 'pending',
                'icon'    => '⏳',
                'title'   => 'Menunggu Persetujuan',
                'message' => 'Pengajuan pinjam "' . ($pjm->barang->nama_barang ?? 'Fasilitas') . '" sedang menunggu verifikasi admin.',
                'kode'    => $pjm->kode_pinjam,
                'date'    => $pjm->created_at ? $pjm->created_at->format('d M Y H:i') : '-',
            ]);
        }

        // 2. Pengembalian yang sedang menunggu verifikasi admin
        $pendingReturns = Peminjaman::with(['barang', 'pengembalian'])
            ->where('nis', $user->nis)
            ->whereHas('pengembalian', function ($q) {
                $q->where('status', 'menunggu');
            })
            ->latest('updated_at')
            ->get();

        foreach ($pendingReturns as $pjm) {
            $notifications->push([
                'type'    => 'pending',
                'icon'    => '📦',
                'title'   => 'Pengembalian Diverifikasi',
                'message' => 'Laporan pengembalian "' . ($pjm->barang->nama_barang ?? 'Fasilitas') . '" sedang dicek oleh admin.',
                'kode'    => $pjm->kode_pinjam,
                'date'    => $pjm->pengembalian->created_at ? $pjm->pengembalian->created_at->format('d M Y H:i') : '-',
            ]);
        }

        // 3. Barang disetujui tapi belum dikembalikan (aktif dipinjam)
        $active = Peminjaman::with(['barang', 'pengembalian'])
            ->where('nis', $user->nis)
            ->where('status_pengajuan', 'disetujui')
            ->whereDoesntHave('pengembalian')
            ->orderBy('tanggal_kembali', 'asc')
            ->get();

        foreach ($active as $pjm) {
            $deadline = $pjm->tanggal_kembali;
            $isOverdue = $deadline && $deadline->lt($now->startOfDay());
            $isNearDeadline = $deadline && !$isOverdue && $deadline->lte($now->copy()->addDays(1)->endOfDay());

            if ($isOverdue) {
                $notifications->push([
                    'type'    => 'overdue',
                    'icon'    => '🚨',
                    'title'   => 'Terlambat Dikembalikan!',
                    'message' => '"' . ($pjm->barang->nama_barang ?? 'Fasilitas') . '" sudah melewati tenggat kembali (' . $deadline->format('d M Y') . '). Segera kembalikan!',
                    'kode'    => $pjm->kode_pinjam,
                    'date'    => $deadline->format('d M Y'),
                ]);
            } elseif ($isNearDeadline) {
                $notifications->push([
                    'type'    => 'warning',
                    'icon'    => '⚠️',
                    'title'   => 'Mendekati Tenggat',
                    'message' => '"' . ($pjm->barang->nama_barang ?? 'Fasilitas') . '" harus dikembalikan paling lambat ' . $deadline->format('d M Y') . '.',
                    'kode'    => $pjm->kode_pinjam,
                    'date'    => $deadline->format('d M Y'),
                ]);
            } else {
                $notifications->push([
                    'type'    => 'active',
                    'icon'    => '📦',
                    'title'   => 'Belum Dikembalikan',
                    'message' => '"' . ($pjm->barang->nama_barang ?? 'Fasilitas') . '" masih dalam masa pinjam. Kembali: ' . ($deadline ? $deadline->format('d M Y') : '-') . '.',
                    'kode'    => $pjm->kode_pinjam,
                    'date'    => $pjm->tanggal_pinjam ? $pjm->tanggal_pinjam->format('d M Y') : '-',
                ]);
            }
        }

        // Urutkan prioritas: overdue -> warning -> pending -> active
        $priority = ['overdue' => 0, 'warning' => 1, 'pending' => 2, 'active' => 3];
        return $notifications->sortBy(function ($n) use ($priority) {
            return $priority[$n['type']] ?? 99;
        })->values();
    }

    /**
     * Endpoint live-check AJAX untuk auto-refresh notifikasi dan deteksi status peminjaman siswa
     */
    public function liveCheck()
    {
        $user = Auth::user();
        if (!$user || $user->role !== 'siswa') {
            return response()->json(['success' => false], 403);
        }

        $notifications = self::getUserNotifications($user);

        // Ambil data pinjaman terbaru untuk mendeteksi perubahan status (disetujui/ditolak/selesai)
        $recentLoans = Peminjaman::with(['barang', 'pengembalian'])
            ->where('nis', $user->nis)
            ->orderBy('updated_at', 'desc')
            ->limit(20)
            ->get()
            ->map(function ($p) {
                return [
                    'kode_pinjam'         => $p->kode_pinjam,
                    'nama_barang'         => $p->barang->nama_barang ?? 'Fasilitas',
                    'status_pengajuan'    => $p->status_pengajuan,
                    'has_pengembalian'    => $p->pengembalian ? true : false,
                    'status_pengembalian' => $p->pengembalian ? $p->pengembalian->status : null,
                    'updated_at'          => $p->updated_at ? $p->updated_at->timestamp : 0,
                ];
            });

        return response()->json([
            'success'       => true,
            'count'         => $notifications->count(),
            'notifications' => $notifications,
            'recent_loans'  => $recentLoans,
        ]);
    }
}
