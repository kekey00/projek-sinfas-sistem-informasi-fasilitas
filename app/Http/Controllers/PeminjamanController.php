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

/**
 * Controller Peminjaman (Siswa / Pengguna)
 *
 * Mengelola seluruh siklus hidup interaksi peminjaman fasilitas oleh siswa,
 * meliputi: pengajuan baru, monitoring status, pembatalan permohonan,
 * pelaporan pengembalian barang fisik, dan kalkulasi notifikasi pengingat tenggat.
 */
class PeminjamanController extends Controller
{
    /**
     * Menampilkan daftar seluruh riwayat dan status pengajuan peminjaman milik siswa yang sedang login.
     *
     * @return \Illuminate\View\View Tampilan halaman riwayat status peminjaman user.
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
     * Menampilkan detail lengkap informasi satu transaksi peminjaman.
     *
     * Prasyarat: Pengguna harus berstatus siswa dan hanya dapat melihat transaksi miliknya sendiri.
     *
     * @param  string  $kode_pinjam  Kode unik transaksi peminjaman (contoh: PJM-20261109-0001).
     * @return \Illuminate\View\View Tampilan detail peminjaman.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException Jika pengguna bukan siswa (HTTP 403).
     * @throws \Illuminate\Database\Eloquent\ModelNotFoundException  Jika kode transaksi tidak ditemukan (HTTP 404).
     */
    public function showStatus(string $kode_pinjam)
    {
        $user = Auth::user();
        abort_unless($user->role === 'siswa' && $user->nis, 403);

        $peminjaman = Peminjaman::with(['barang.kategori', 'pengembalian'])
            ->where('nis', $user->nis)
            ->findOrFail($kode_pinjam);

        return view('user.status_detail', compact('peminjaman'));
    }

    /**
     * Menampilkan pusat notifikasi siswa dengan dukungan pagination dan filter tab.
     *
     * @param  \Illuminate\Http\Request  $request  HTTP request dengan opsi query filter (all, attention, pending, active).
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse Tampilan daftar notifikasi berpaginasi.
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
     * Memproses dan menyimpan permohonan peminjaman sarana baru dari form siswa.
     *
     * Aturan Bisnis & Validasi:
     * - Barang harus ada di database dan stok kondisi baik (`jumlah_baik`) minimal 1 unit.
     * - Tanggal pinjam minimal hari ini (tidak boleh tanggal lampau).
     * - Tanggal rencana kembali tidak boleh mendahului tanggal pinjam.
     * - Menyimpan nomor WhatsApp aktif ke profil akun & data siswa.
     * - Menghasilkan kode peminjaman otomatis melalui Peminjaman::generateKode().
     * - Status awal transaksi diset menjadi 'menunggu' untuk diverifikasi admin sarana.
     *
     * @param  \Illuminate\Http\Request  $request  Data form permohonan peminjaman.
     * @return \Illuminate\Http\RedirectResponse  Redirect ke halaman status riwayat pinjam siswa.
     *
     * @throws \Illuminate\Validation\ValidationException Jika input data tidak memenuhi kriteria validasi.
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

        // Cek ketersediaan stok fisik barang siap pakai
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
     * Membatalkan permohonan peminjaman yang diajukan oleh siswa.
     *
     * Aturan Bisnis & Konkurensi:
     * - Hanya siswa pemilik pengajuan yang berhak membatalkan permohonannya.
     * - Pengajuan hanya bisa dibatalkan jika statusnya masih 'menunggu' verifikasi admin.
     * - Menggunakan database transaction dan row-level locking (lockForUpdate) untuk menghindari
     *   race condition jika admin menyetujui/menolak pada saat yang bersamaan.
     *
     * @param  string  $kode_pinjam  Kode unik transaksi peminjaman (contoh: PJM-20261109-0001).
     * @return \Illuminate\Http\RedirectResponse  Redirect kembali ke status peminjaman dengan flash message.
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException Jika pengguna bukan siswa (HTTP 403).
     */
    public function cancel(string $kode_pinjam)
    {
        $user = Auth::user();
        abort_unless($user->role === 'siswa' && $user->nis, 403);

        $peminjaman = DB::transaction(function () use ($user, $kode_pinjam) {
            $peminjaman = Peminjaman::where('nis', $user->nis)
                ->lockForUpdate()
                ->findOrFail($kode_pinjam);

            if ($peminjaman->status_pengajuan !== 'menunggu') {
                return null;
            }

            $peminjaman->update(['status_pengajuan' => 'dibatalkan']);

            return $peminjaman;
        });

        if (!$peminjaman) {
            return redirect()->route('user.status')
                ->with('error', 'Peminjaman hanya dapat dibatalkan saat masih menunggu verifikasi.');
        }

        return redirect()->route('user.status')
            ->with('success', 'Pengajuan peminjaman berhasil dibatalkan.');
    }

    /**
     * Menampilkan formulir pelaporan pengembalian barang bagi siswa.
     *
     * Prasyarat:
     * - Status peminjaman harus 'disetujui'.
     * - Belum pernah mengajukan pengembalian sebelumnya untuk kode pinjam tersebut.
     *
     * @param  string  $kode_pinjam  Kode transaksi peminjaman (contoh: PJM-20261109-0001).
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse Form view pengembalian atau redirect jika syarat tidak terpenuhi.
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
     * Memproses pelaporan pengembalian sarana oleh siswa beserta upload bukti fisik foto/video.
     *
     * Aturan Bisnis & Efek Samping:
     * - Wajib melampirkan berkas bukti fisik (JPG, PNG, WebP atau Video MP4/MOV) maksimal 25 MB.
     * - Status pengembalian awal diset 'menunggu' untuk menunggu verifikasi fisik oleh admin sarana.
     * - Catatan: Stok barang fisik belum dipulihkan di tahap ini, melainkan saat admin memverifikasi fisik barang.
     *
     * @param  \Illuminate\Http\Request  $request  Data form pengembalian (tanggal_kembali, kondisi_barang, bukti_foto, catatan).
     * @param  string  $kode_pinjam  Kode transaksi peminjaman.
     * @return \Illuminate\Http\RedirectResponse  Redirect ke halaman status dengan pesan konfirmasi.
     *
     * @throws \Illuminate\Validation\ValidationException Jika berkas bukti fisik atau input tidak valid.
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
     * Mengalkulasi dan menyusun daftar notifikasi cerdas bagi siswa berdasarkan status & tenggat waktu.
     *
     * Kategori & Urutan Skala Prioritas:
     * 1. 'overdue' (Tingkat 0) : Melewati tanggal rencana pengembalian (peringatan darurat).
     * 2. 'warning' (Tingkat 1) : Mendekati batas waktu (sisa <= 24 jam).
     * 3. 'pending' (Tingkat 2) : Pengajuan peminjaman/pengembalian sedang diverifikasi staf.
     * 4. 'active'  (Tingkat 3) : Barang dalam masa pinjam aktif normal.
     *
     * @param  \App\Models\Akun|\Illuminate\Contracts\Auth\Authenticatable|null  $user  Objek user siswa terautentikasi.
     * @return \Illuminate\Support\Collection  Koleksi array notifikasi yang telah diurutkan prioritasnya.
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
     * Endpoint API AJAX live-check untuk pembaruan waktu nyata (real-time polling) pada UI siswa.
     *
     * Berfungsi memantau perubahan status persetujuan peminjaman dan memperbarui
     * badge notifikasi secara asinkron tanpa reload seluruh halaman.
     *
     * @return \Illuminate\Http\JsonResponse Respon JSON berisi status, counter notifikasi, dan daftar pinjaman mutakhir.
     */
    public function liveCheck(): \Illuminate\Http\JsonResponse
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
