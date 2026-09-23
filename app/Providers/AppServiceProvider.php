<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Peminjaman;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share notification data with user layout
        View::composer('layouts.user', function ($view) {
            $notifications = collect();

            if (Auth::check()) {
                $user = Auth::user();
                $now = Carbon::now();

                // 1. Peminjaman menunggu verifikasi admin
                $pending = Peminjaman::with('barang')
                    ->where('nis', $user->nis)
                    ->where('status_pengajuan', 'menunggu')
                    ->orderBy('created_at', 'desc')
                    ->get();

                foreach ($pending as $pjm) {
                    $notifications->push([
                        'type'    => 'pending',
                        'icon'    => '⏳',
                        'title'   => 'Menunggu Verifikasi',
                        'message' => 'Pengajuan pinjam "' . ($pjm->barang->nama_barang ?? 'Fasilitas') . '" sedang menunggu persetujuan admin.',
                        'kode'    => $pjm->kode_pinjam,
                        'date'    => $pjm->created_at,
                    ]);
                }

                // 2. Barang disetujui tapi belum dikembalikan (aktif dipinjam)
                $active = Peminjaman::with('barang')
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
                            'date'    => $deadline,
                        ]);
                    } elseif ($isNearDeadline) {
                        $notifications->push([
                            'type'    => 'warning',
                            'icon'    => '⚠️',
                            'title'   => 'Mendekati Tenggat',
                            'message' => '"' . ($pjm->barang->nama_barang ?? 'Fasilitas') . '" harus dikembalikan paling lambat ' . $deadline->format('d M Y') . '.',
                            'kode'    => $pjm->kode_pinjam,
                            'date'    => $deadline,
                        ]);
                    } else {
                        $notifications->push([
                            'type'    => 'active',
                            'icon'    => '📦',
                            'title'   => 'Belum Dikembalikan',
                            'message' => '"' . ($pjm->barang->nama_barang ?? 'Fasilitas') . '" masih dalam masa pinjam. Kembali: ' . ($deadline ? $deadline->format('d M Y') : '-') . '.',
                            'kode'    => $pjm->kode_pinjam,
                            'date'    => $pjm->tanggal_pinjam,
                        ]);
                    }
                }

                // Sort: overdue first, then warning, then pending, then active
                $priority = ['overdue' => 0, 'warning' => 1, 'pending' => 2, 'active' => 3];
                $notifications = $notifications->sortBy(function ($n) use ($priority) {
                    return $priority[$n['type']] ?? 99;
                })->values();
            }

            $view->with('userNotifications', $notifications);
        });
    }
}
