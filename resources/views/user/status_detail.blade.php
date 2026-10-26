@extends('layouts.user')

@section('title', 'Detail Pengajuan ' . $peminjaman->kode_pinjam . ' - SINFAS')

@section('styles')
<style>
    .loan-detail-page {
        width: min(100%, 920px);
        margin: 0 auto;
    }

    .loan-detail-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #3B5998;
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        margin-bottom: 18px;
    }

    .loan-detail-back:hover { color: #2C4A7C; }

    .loan-detail-card {
        overflow: hidden;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 22px;
        box-shadow: var(--shadow-card);
    }

    .loan-detail-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 18px;
        padding: 24px 28px;
        border-bottom: 1px solid #F1F5F9;
    }

    .loan-detail-title {
        color: var(--text-main);
        font-family: 'Outfit', sans-serif;
        font-size: 23px;
        font-weight: 800;
    }

    .loan-detail-code {
        color: var(--text-secondary);
        font-size: 12.5px;
        margin-top: 5px;
    }

    .loan-detail-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 800;
        padding: 7px 12px;
        white-space: nowrap;
    }

    .loan-detail-status.pending,
    .loan-detail-status.returning { background: #FFFBEB; color: #B45309; }
    .loan-detail-status.approved { background: #ECFDF5; color: #047857; }
    .loan-detail-status.rejected { background: #FFF1F2; color: #BE123C; }
    .loan-detail-status.returned { background: #F0FDF4; color: #15803D; }

    .loan-detail-section { padding: 24px 28px; }
    .loan-detail-section + .loan-detail-section { border-top: 1px solid #F1F5F9; }

    .loan-detail-section h2 {
        color: var(--text-main);
        font-family: 'Outfit', sans-serif;
        font-size: 15px;
        font-weight: 800;
        margin-bottom: 16px;
    }

    .loan-detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px 24px;
    }

    .loan-detail-label {
        color: #94A3B8;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .06em;
        text-transform: uppercase;
    }

    .loan-detail-value {
        color: #334155;
        font-size: 13.5px;
        font-weight: 600;
        margin-top: 5px;
        overflow-wrap: anywhere;
    }

    .loan-detail-note {
        color: #475569;
        font-size: 13.5px;
        line-height: 1.7;
        white-space: pre-wrap;
    }

    .loan-detail-evidence {
        display: block;
        max-width: min(100%, 560px);
        max-height: 420px;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        background: #F8FAFC;
        object-fit: contain;
    }

    @media (max-width: 600px) {
        .loan-detail-header { padding: 20px; flex-direction: column; }
        .loan-detail-section { padding: 20px; }
        .loan-detail-grid { grid-template-columns: 1fr; }
        .loan-detail-title { font-size: 20px; }
    }
</style>
@endsection

@section('content')
@php
    $pengembalian = $peminjaman->pengembalian;
    if ($pengembalian?->status === 'selesai') {
        $statusLabel = 'Selesai dikembalikan';
        $statusClass = 'returned';
    } elseif ($pengembalian?->status === 'menunggu') {
        $statusLabel = 'Menunggu verifikasi pengembalian';
        $statusClass = 'returning';
    } elseif ($peminjaman->status_pengajuan === 'menunggu') {
        $statusLabel = 'Menunggu persetujuan';
        $statusClass = 'pending';
    } elseif ($peminjaman->status_pengajuan === 'ditolak') {
        $statusLabel = 'Ditolak';
        $statusClass = 'rejected';
    } else {
        $statusLabel = 'Disetujui · Sedang dipinjam';
        $statusClass = 'approved';
    }
@endphp

<main class="loan-detail-page">
    <a class="loan-detail-back" href="{{ route('user.status') }}">
        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
            <path d="M19 12H5M12 19l-7-7 7-7"></path>
        </svg>
        Kembali ke Status Peminjaman
    </a>

    <article class="loan-detail-card">
        <header class="loan-detail-header">
            <div>
                <h1 class="loan-detail-title">{{ $peminjaman->barang->nama_barang ?? 'Fasilitas' }}</h1>
                <p class="loan-detail-code">Kode pengajuan: {{ $peminjaman->kode_pinjam }}</p>
            </div>
            <span class="loan-detail-status {{ $statusClass }}">{{ $statusLabel }}</span>
        </header>

        <section class="loan-detail-section">
            <h2>Informasi Pengajuan</h2>
            <div class="loan-detail-grid">
                <div>
                    <div class="loan-detail-label">Nama Barang</div>
                    <div class="loan-detail-value">{{ $peminjaman->barang->nama_barang ?? $peminjaman->kode_barang }}</div>
                </div>
                <div>
                    <div class="loan-detail-label">Kode Barang</div>
                    <div class="loan-detail-value">{{ $peminjaman->kode_barang }}</div>
                </div>
                <div>
                    <div class="loan-detail-label">Kategori</div>
                    <div class="loan-detail-value">{{ $peminjaman->barang->kategori->nama_kategori ?? '-' }}</div>
                </div>
                <div>
                    <div class="loan-detail-label">Tanggal Pengajuan</div>
                    <div class="loan-detail-value">{{ $peminjaman->created_at?->format('d M Y, H:i') ?? '-' }}</div>
                </div>
                <div>
                    <div class="loan-detail-label">Tanggal Pinjam</div>
                    <div class="loan-detail-value">{{ $peminjaman->tanggal_pinjam?->format('d M Y') ?? '-' }}{{ $peminjaman->jam_pinjam ? ' · ' . $peminjaman->jam_pinjam : '' }}</div>
                </div>
                <div>
                    <div class="loan-detail-label">Rencana Pengembalian</div>
                    <div class="loan-detail-value">{{ $peminjaman->tanggal_kembali?->format('d M Y') ?? '-' }}{{ $peminjaman->jam_kembali ? ' · ' . $peminjaman->jam_kembali : '' }}</div>
                </div>
                <div>
                    <div class="loan-detail-label">Nomor Telepon</div>
                    <div class="loan-detail-value">{{ $peminjaman->nomor_telepon ?? '-' }}</div>
                </div>
                <div>
                    <div class="loan-detail-label">Status Pengajuan</div>
                    <div class="loan-detail-value">{{ $statusLabel }}</div>
                </div>
            </div>
        </section>

        <section class="loan-detail-section">
            <h2>Keperluan Peminjaman</h2>
            <p class="loan-detail-note">{{ $peminjaman->keterangan_penggunaan ?: '-' }}</p>
        </section>

        @if($pengembalian)
            <section class="loan-detail-section">
                <h2>Informasi Pengembalian</h2>
                <div class="loan-detail-grid">
                    <div>
                        <div class="loan-detail-label">Tanggal Dilaporkan Kembali</div>
                        <div class="loan-detail-value">{{ $pengembalian->tanggal_kembali?->format('d M Y') ?? '-' }}</div>
                    </div>
                    <div>
                        <div class="loan-detail-label">Kondisi Barang</div>
                        <div class="loan-detail-value">{{ $pengembalian->kondisi_barang ?: 'Belum dicatat' }}</div>
                    </div>
                    <div>
                        <div class="loan-detail-label">Status Verifikasi</div>
                        <div class="loan-detail-value">{{ $pengembalian->status === 'selesai' ? 'Selesai' : 'Menunggu verifikasi admin' }}</div>
                    </div>
                    <div>
                        <div class="loan-detail-label">Waktu Laporan</div>
                        <div class="loan-detail-value">{{ $pengembalian->created_at?->format('d M Y, H:i') ?? '-' }}</div>
                    </div>
                </div>
            </section>

            @if($pengembalian->bukti_foto_video)
                <section class="loan-detail-section">
                    <h2>Bukti Pengembalian</h2>
                    @if(\Illuminate\Support\Str::startsWith($pengembalian->bukti_foto_video, 'pengembalian/'))
                        @php
                            $evidenceUrl = asset('storage/' . $pengembalian->bukti_foto_video);
                            $extension = strtolower(pathinfo($pengembalian->bukti_foto_video, PATHINFO_EXTENSION));
                            $isVideo = in_array($extension, ['mp4', 'mov', 'avi', 'webm', 'mkv'], true);
                        @endphp
                        @if($isVideo)
                            <video class="loan-detail-evidence" controls preload="metadata" src="{{ $evidenceUrl }}">
                                Browser tidak mendukung pemutar video.
                            </video>
                        @else
                            <a href="{{ $evidenceUrl }}" target="_blank" rel="noopener noreferrer">
                                <img class="loan-detail-evidence" src="{{ $evidenceUrl }}" alt="Bukti foto pengembalian barang">
                            </a>
                        @endif
                    @else
                        <p class="loan-detail-note">{{ $pengembalian->bukti_foto_video }}</p>
                    @endif
                </section>
            @endif
        @endif
    </article>
</main>
@endsection
