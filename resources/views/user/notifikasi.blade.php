@extends('layouts.user')

@section('title', 'Semua Notifikasi - SINFAS')

@section('styles')
<style>
    .notif-hero-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .title-vibe-bold {
        font-size: 28px;
        font-weight: 900;
        letter-spacing: -0.6px;
        color: var(--text-main);
    }

    /* BACK LINK PILL */
    .back-pill-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        padding: 8px 16px;
        border-radius: var(--radius-pill);
        font-size: 13px;
        font-weight: 700;
        color: var(--text-secondary);
        text-decoration: none;
        margin-bottom: 20px;
        transition: all 0.2s ease;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }
    .back-pill-link:hover {
        border-color: #5B8DEF;
        color: #3B5998;
        transform: translateX(-3px);
    }

    /* FILTER TABS PILLS */
    .filter-tabs-row {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .filter-tab-pill {
        padding: 8px 18px;
        border-radius: var(--radius-pill);
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none;
        white-space: nowrap;
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        color: #334155;
        transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        user-select: none;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
        font-family: inherit;
        line-height: 1.4;
    }

    .filter-tab-pill:hover {
        border-color: #5B8DEF;
        color: #3B5998;
        transform: translateY(-1px);
    }

    .filter-tab-pill.active {
        background: #3B5998 !important;
        border-color: #3B5998 !important;
        color: #FFFFFF !important;
        box-shadow: 0 4px 14px rgba(59, 89, 152, 0.28) !important;
        font-weight: 700;
    }

    .filter-tab-pill .filter-tab-count {
        font-size: 12.5px;
        font-weight: 600;
        opacity: 0.75;
        margin-left: 2px;
    }

    .filter-tab-pill.active .filter-tab-count {
        opacity: 0.9;
        color: #FFFFFF;
    }

    /* NOTIFICATION CARDS */
    .notif-cards-list {
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .notif-card-item {
        background: #FFFFFF;
        border-radius: 18px;
        padding: 18px 22px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        box-shadow: var(--shadow-card);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }
    .notif-card-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.08);
    }

    /* PAGINATION STYLING */
    .user-pagination-wrapper {
        margin-top: 36px;
        padding-top: 24px;
        border-top: 1px solid var(--border-subtle);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }
    .user-pagination-info {
        font-size: 13.5px;
        color: var(--text-muted);
        font-weight: 500;
    }
    .user-pagination-info strong {
        color: var(--text-main);
        font-weight: 700;
    }
    .user-pagination-pills {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #FFFFFF;
        padding: 5px 8px;
        border-radius: var(--radius-pill);
        border: 1.5px solid #E2E8F0;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }
    .user-page-btn {
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border-radius: var(--radius-pill);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        text-decoration: none;
        transition: all 0.18s ease;
        gap: 4px;
        border: 1px solid transparent;
        font-family: inherit;
    }
    .user-page-btn:hover:not(.disabled):not(.active) {
        background: #F1F5F9;
        color: #1E293B;
        border-color: #CBD5E1;
        transform: translateY(-1px);
    }
    .user-page-btn.active {
        background: linear-gradient(135deg, #3B5998 0%, #2C4A7C 100%);
        color: #FFFFFF !important;
        box-shadow: 0 3px 10px rgba(44, 74, 124, 0.28);
    }
    .user-page-btn.disabled {
        opacity: 0.35;
        cursor: not-allowed;
        color: #94A3B8;
    }
    .user-page-ellipsis {
        padding: 0 4px;
        color: #94A3B8;
        font-size: 13px;
    }
</style>
@endsection

@section('content')

    <!-- BACK NAV PILL -->
    <a href="{{ route('user.dashboard') }}" class="back-pill-link" id="btn-back-home">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
        <span>Kembali ke Beranda</span>
    </a>

    <!-- HEADING -->
    <div class="notif-hero-heading">
        <div>
            <h1 class="title-vibe-bold">Pusat Notifikasi & Pemberitahuan 🔔</h1>
            <p style="font-size: 14.5px; color: var(--text-secondary); margin-top: 4px;">
                Semua pembaruan terkait status peminjaman, batas pengembalian, dan verifikasi admin.
            </p>
        </div>
        <div style="display: flex; gap: 10px;">
            <a href="{{ route('user.status') }}" class="btn-genz-secondary" style="font-size: 13px; padding: 9px 18px;">
                Lihat Status Pinjaman
            </a>
            <a href="{{ route('user.dashboard') }}" class="btn-genz-primary" style="font-size: 13px; padding: 9px 18px;">
                Pinjam Alat Baru
            </a>
        </div>
    </div>

    <!-- FILTER TABS ROW -->
    <div class="filter-tabs-row">
        <a href="{{ route('user.notifikasi', ['filter' => 'all']) }}" class="filter-tab-pill {{ $currentFilter === 'all' ? 'active' : '' }}">
            <span>✨ Semua</span>
            <span class="filter-tab-count">({{ $counts['all'] }})</span>
        </a>
        <a href="{{ route('user.notifikasi', ['filter' => 'attention']) }}" class="filter-tab-pill {{ $currentFilter === 'attention' ? 'active' : '' }}">
            <span>🚨 Perlu Perhatian</span>
            <span class="filter-tab-count">({{ $counts['attention'] }})</span>
        </a>
        <a href="{{ route('user.notifikasi', ['filter' => 'pending']) }}" class="filter-tab-pill {{ $currentFilter === 'pending' ? 'active' : '' }}">
            <span>⏳ Menunggu Verifikasi</span>
            <span class="filter-tab-count">({{ $counts['pending'] }})</span>
        </a>
        <a href="{{ route('user.notifikasi', ['filter' => 'active']) }}" class="filter-tab-pill {{ $currentFilter === 'active' ? 'active' : '' }}">
            <span>📦 Aktif Dipinjam</span>
            <span class="filter-tab-count">({{ $counts['active'] }})</span>
        </a>
    </div>

    <!-- NOTIFICATION LIST -->
    <div class="notif-cards-list">
        @forelse($notifications as $notif)
            @php
                $borderColor = match($notif['type']) {
                    'overdue' => '#FCA5A5',
                    'warning' => '#FCD34D',
                    'pending' => '#93C5FD',
                    'active'  => '#A7F3D0',
                    default   => '#E2E8F0',
                };
                $bgColor = match($notif['type']) {
                    'overdue' => '#FEF2F2',
                    'warning' => '#FFFBEB',
                    'pending' => '#EFF6FF',
                    'active'  => '#F0FDF4',
                    default   => '#FFFFFF',
                };
                $titleColor = match($notif['type']) {
                    'overdue' => '#DC2626',
                    'warning' => '#D97706',
                    'pending' => '#2563EB',
                    'active'  => '#059669',
                    default   => '#1E293B',
                };
            @endphp
            <div class="notif-card-item" style="background: {{ $bgColor }}; border: 1.5px solid {{ $borderColor }};">
                <div style="font-size: 28px; flex-shrink: 0; line-height: 1;">{{ $notif['icon'] }}</div>
                <div style="flex: 1; min-width: 0;">
                    <div style="display: flex; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 6px; flex-wrap: wrap;">
                        <span style="font-size: 15px; font-weight: 800; color: {{ $titleColor }};">{{ $notif['title'] }}</span>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="font-size: 12px; color: #64748B; background: rgba(255,255,255,0.8); border: 1px solid rgba(0,0,0,0.06); padding: 2px 8px; border-radius: 6px; font-weight: 600;">{{ $notif['date'] ?? '-' }}</span>
                            <span style="font-size: 11px; color: #94A3B8; font-weight: 600;">#{{ $notif['kode'] }}</span>
                        </div>
                    </div>
                    <p style="font-size: 13.5px; color: #475569; line-height: 1.6; margin: 0;">{{ $notif['message'] }}</p>

                    <div style="margin-top: 12px; display: flex; align-items: center; gap: 12px;">
                        <a href="{{ route('user.status') }}" style="font-size: 12.5px; font-weight: 700; color: {{ $titleColor }}; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                            <span>Lihat Detail Pinjaman</span>
                            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div style="background:#FFFFFF; border: 2px dashed #CBD5E1; border-radius: 24px; padding: 60px 20px; text-align: center; color: var(--text-muted);">
                <div style="font-size: 48px; margin-bottom: 12px;">🎉</div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--text-main); margin-bottom: 6px;">Tidak Ada Notifikasi</h3>
                <p style="font-size: 14px; margin-bottom: 18px;">Semua urusan peminjaman fasilitas sekolahmu saat ini sedang berjalan beres!</p>
                <a href="{{ route('user.dashboard') }}" class="btn-genz-primary">
                    Kembali ke Beranda
                </a>
            </div>
        @endforelse
    </div>

    <!-- PAGINATION SINFAS NOTIFIKASI -->
    @if($notifications->hasPages())
        <div class="user-pagination-wrapper">
            <div class="user-pagination-info">
                Menampilkan <strong>{{ $notifications->firstItem() ?? 0 }}</strong> &ndash; <strong>{{ $notifications->lastItem() ?? 0 }}</strong> dari <strong>{{ $notifications->total() }}</strong> notifikasi
            </div>
            <div class="user-pagination-pills">
                {{-- Tombol Sebelumnya --}}
                @if($notifications->onFirstPage())
                    <span class="user-page-btn disabled" aria-disabled="true">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Prev</span>
                    </span>
                @else
                    <a href="{{ $notifications->previousPageUrl() }}" class="user-page-btn" rel="prev">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Prev</span>
                    </a>
                @endif

                {{-- Nomor Halaman --}}
                @for($p = 1; $p <= $notifications->lastPage(); $p++)
                    @if($p == 1 || $p == $notifications->lastPage() || ($p >= $notifications->currentPage() - 1 && $p <= $notifications->currentPage() + 1))
                        @if($p == $notifications->currentPage())
                            <span class="user-page-btn active" aria-current="page">{{ $p }}</span>
                        @else
                            <a href="{{ $notifications->url($p) }}" class="user-page-btn">{{ $p }}</a>
                        @endif
                    @elseif($p == 2 || $p == $notifications->lastPage() - 1)
                        <span class="user-page-ellipsis">&hellip;</span>
                    @endif
                @endfor

                {{-- Tombol Selanjutnya --}}
                @if($notifications->hasMorePages())
                    <a href="{{ $notifications->nextPageUrl() }}" class="user-page-btn" rel="next">
                        <span>Next</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </a>
                @else
                    <span class="user-page-btn disabled" aria-disabled="true">
                        <span>Next</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </span>
                @endif
            </div>
        </div>
    @endif

@endsection
