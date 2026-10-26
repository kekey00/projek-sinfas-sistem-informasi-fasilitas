@extends('layouts.admin')

@section('title', 'Pusat Notifikasi - SINFAS')
@section('page_title', 'Pusat Notifikasi')

@section('styles')
<style>
    .notification-intro {
        color: #64748B;
        font-size: 13.5px;
        margin-top: -12px;
    }

    .notification-section {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
    }

    .notification-section-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 18px 22px;
        border-bottom: 1px solid #F1F5F9;
    }

    .notification-section-title {
        color: #0F172A;
        font-family: 'Outfit', sans-serif;
        font-size: 16px;
        font-weight: 700;
    }

    .notification-count {
        border-radius: 999px;
        background: #EEF2FF;
        color: #3B5998;
        font-size: 12px;
        font-weight: 700;
        padding: 4px 10px;
    }

    .notification-list {
        display: flex;
        flex-direction: column;
    }

    .notification-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 16px 22px;
        color: inherit;
        text-decoration: none;
        transition: background 0.15s ease;
    }

    .notification-item + .notification-item {
        border-top: 1px solid #F1F5F9;
    }

    .notification-item:hover {
        background: #F8FAFC;
    }

    .notification-icon {
        width: 42px;
        height: 42px;
        display: grid;
        place-items: center;
        flex: 0 0 42px;
        border-radius: 13px;
        background: #EEF2FF;
        color: #3B5998;
    }

    .notification-icon.return {
        background: #ECFDF5;
        color: #059669;
    }

    .notification-copy {
        flex: 1;
        min-width: 0;
    }

    .notification-copy strong {
        display: block;
        color: #1E293B;
        font-size: 13.5px;
        font-weight: 700;
    }

    .notification-copy span,
    .notification-copy time {
        display: block;
        color: #64748B;
        font-size: 12px;
        margin-top: 3px;
    }

    .notification-arrow {
        color: #94A3B8;
        flex: 0 0 auto;
    }

    .notification-empty {
        padding: 28px 22px;
        color: #64748B;
        font-size: 13px;
        text-align: center;
    }

    .notification-pagination {
        display: flex;
        justify-content: center;
        gap: 8px;
        padding: 12px;
        border-top: 1px solid #F1F5F9;
    }

    .notification-pagination a,
    .notification-pagination span {
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        color: #475569;
        font-size: 12px;
        padding: 6px 10px;
        text-decoration: none;
    }

    .notification-pagination a:hover {
        background: #EEF2FF;
        color: #3B5998;
    }

    @media (max-width: 600px) {
        .notification-section-header,
        .notification-item {
            padding-left: 16px;
            padding-right: 16px;
        }
    }
</style>
@endsection

@section('content')
<p class="notification-intro">Pengajuan pinjaman dan pengembalian yang menunggu tindakan Admin Sarana.</p>

<section class="notification-section" aria-labelledby="loan-notifications-title">
    <div class="notification-section-header">
        <h2 class="notification-section-title" id="loan-notifications-title">Pengajuan Peminjaman</h2>
        <span class="notification-count">{{ $pendingLoans->total() }}</span>
    </div>

    @if($pendingLoans->isEmpty())
        <p class="notification-empty">Tidak ada pengajuan peminjaman yang menunggu verifikasi.</p>
    @else
        <div class="notification-list">
            @foreach($pendingLoans as $loan)
                <a class="notification-item" href="{{ route('admin.verifikasi.index', ['tab' => 'requests']) }}">
                    <span class="notification-icon" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M8 6h13M8 12h13M8 18h13"></path><path d="M3 6h.01M3 12h.01M3 18h.01"></path>
                        </svg>
                    </span>
                    <span class="notification-copy">
                        <strong>Pengajuan pinjaman baru dari {{ $loan->siswa->nama ?? 'Siswa' }}</strong>
                        <span>{{ $loan->barang->nama_barang ?? 'Barang' }} · Kode {{ $loan->kode_pinjam }}</span>
                        <time datetime="{{ $loan->created_at?->toIso8601String() }}">{{ $loan->created_at?->format('d M Y, H:i') ?? 'Waktu tidak tersedia' }}</time>
                    </span>
                    <svg class="notification-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            @endforeach
        </div>
        @if($pendingLoans->hasPages())
            <div class="notification-pagination">{{ $pendingLoans->links('pagination::simple-default') }}</div>
        @endif
    @endif
</section>

<section class="notification-section" aria-labelledby="return-notifications-title">
    <div class="notification-section-header">
        <h2 class="notification-section-title" id="return-notifications-title">Pengajuan Pengembalian</h2>
        <span class="notification-count">{{ $pendingReturns->total() }}</span>
    </div>

    @if($pendingReturns->isEmpty())
        <p class="notification-empty">Tidak ada pengembalian yang menunggu verifikasi.</p>
    @else
        <div class="notification-list">
            @foreach($pendingReturns as $return)
                <a class="notification-item" href="{{ route('admin.verifikasi.index', ['tab' => 'returns']) }}">
                    <span class="notification-icon return" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12a9 9 0 1 0 3-6.7L3 8"></path><path d="M3 3v5h5"></path><path d="M12 7v5l3 2"></path>
                        </svg>
                    </span>
                    <span class="notification-copy">
                        <strong>Laporan pengembalian dari {{ $return->peminjaman->siswa->nama ?? 'Siswa' }}</strong>
                        <span>{{ $return->peminjaman->barang->nama_barang ?? 'Barang' }} · Kode {{ $return->kode_pinjam }}</span>
                        <time datetime="{{ $return->created_at?->toIso8601String() }}">{{ $return->created_at?->format('d M Y, H:i') ?? 'Waktu tidak tersedia' }}</time>
                    </span>
                    <svg class="notification-arrow" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M5 12h14M12 5l7 7-7 7"></path>
                    </svg>
                </a>
            @endforeach
        </div>
        @if($pendingReturns->hasPages())
            <div class="notification-pagination">{{ $pendingReturns->links('pagination::simple-default') }}</div>
        @endif
    @endif
</section>
@endsection
