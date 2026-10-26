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
        color: #2C4A7C;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        margin-bottom: 18px;
        transition: color .18s ease, transform .18s ease;
    }

    .loan-detail-back:hover { color: #5B8DEF; transform: translateX(-2px); }

    .loan-detail-card {
        overflow: hidden;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 18px;
        box-shadow: 0 16px 38px rgba(21, 34, 56, .09), 0 3px 10px rgba(21, 34, 56, .04);
    }

    .loan-detail-header {
        position: relative;
        isolation: isolate;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        padding: 30px 32px;
        overflow: hidden;
        background: linear-gradient(118deg, #172B49 0%, #2C4A7C 64%, #3B5998 100%);
    }

    .loan-detail-header::after {
        position: absolute;
        z-index: -1;
        content: '';
        width: 290px;
        height: 290px;
        top: -190px;
        right: -70px;
        border: 1px solid rgba(255, 255, 255, .13);
        border-radius: 50%;
        box-shadow: 0 0 0 34px rgba(255, 255, 255, .035), 0 0 0 68px rgba(255, 255, 255, .025);
    }

    .loan-detail-heading {
        display: flex;
        align-items: center;
        gap: 18px;
        min-width: 0;
    }

    .loan-detail-item-image {
        display: grid;
        place-items: center;
        width: 72px;
        height: 72px;
        flex: 0 0 72px;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, .24);
        border-radius: 15px;
        background: rgba(255, 255, 255, .12);
        color: #C7D9F5;
    }

    .loan-detail-item-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .loan-detail-eyebrow {
        margin-bottom: 5px;
        color: #B9D5F3;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .14em;
        text-transform: uppercase;
    }

    .loan-detail-title {
        color: #FFFFFF;
        font-family: 'Outfit', sans-serif;
        font-size: 24px;
        font-weight: 700;
        line-height: 1.25;
    }

    .loan-detail-code {
        color: rgba(255, 255, 255, .76);
        font-size: 12.5px;
        margin-top: 7px;
    }

    .loan-detail-status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        border: 1px solid transparent;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        line-height: 1.4;
        padding: 8px 11px;
        white-space: nowrap;
    }

    .loan-detail-status::before {
        width: 7px;
        height: 7px;
        flex: 0 0 7px;
        border-radius: 50%;
        background: currentColor;
        content: '';
    }

    .loan-detail-status.pending,
    .loan-detail-status.returning { background: #FFF7E6; border-color: #F5D999; color: #8A5B00; }
    .loan-detail-status.approved { background: #EAF6F1; border-color: #B9E1D0; color: #176B4D; }
    .loan-detail-status.rejected { background: #FCEDEE; border-color: #F1C8CC; color: #9B3038; }
    .loan-detail-status.returned { background: #EAF6F1; border-color: #B9E1D0; color: #176B4D; }

    .loan-detail-section {
        padding: 25px 30px;
    }

    .loan-detail-section + .loan-detail-section {
        border-top: 1px solid #E9EEF5;
    }

    .loan-detail-section-header {
        display: flex;
        align-items: center;
        gap: 11px;
        margin-bottom: 17px;
    }

    .loan-detail-section-icon {
        display: grid;
        place-items: center;
        width: 34px;
        height: 34px;
        flex: 0 0 34px;
        border: 1px solid #DBE6F4;
        border-radius: 9px;
        background: #EFF4FA;
        color: #345783;
    }

    .loan-detail-section-header h2 {
        color: #1F344F;
        font-family: 'Outfit', sans-serif;
        font-size: 14px;
        font-weight: 700;
        letter-spacing: .01em;
    }

    .loan-detail-section-header p {
        margin-top: 2px;
        color: #8190A3;
        font-size: 11.5px;
    }

    .loan-detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 10px 14px;
    }

    .loan-detail-field {
        min-height: 68px;
        padding: 12px 14px;
        border: 1px solid #E7EDF4;
        border-radius: 10px;
        background: linear-gradient(145deg, #FFFFFF 0%, #F8FAFD 100%);
    }

    .loan-detail-label {
        color: #74849A;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .075em;
        text-transform: uppercase;
    }

    .loan-detail-value {
        color: #263B56;
        font-size: 13px;
        font-weight: 600;
        margin-top: 6px;
        overflow-wrap: anywhere;
    }

    .loan-detail-note-box {
        padding: 15px 17px;
        border-left: 3px solid #6B8DD6;
        border-radius: 0 9px 9px 0;
        background: #F3F6FB;
    }

    .loan-detail-note {
        color: #475569;
        font-size: 13.5px;
        line-height: 1.7;
        white-space: pre-wrap;
    }

    .loan-detail-evidence-wrap {
        display: inline-flex;
        padding: 6px;
        border: 1px solid #E3EAF2;
        border-radius: 13px;
        background: #F7F9FC;
    }

    .loan-detail-evidence {
        display: block;
        max-width: min(100%, 560px);
        max-height: 420px;
        border-radius: 9px;
        background: #FFFFFF;
        object-fit: contain;
    }

    .loan-detail-return-status {
        display: flex;
        align-items: flex-start;
        gap: 11px;
        margin-top: 16px;
        padding: 13px 15px;
        border: 1px solid #D9E5F3;
        border-radius: 10px;
        background: #F3F7FC;
        color: #3B5575;
        font-size: 12px;
        line-height: 1.55;
    }

    .loan-detail-return-status strong { color: #263B56; }

    @media (max-width: 600px) {
        .loan-detail-header { align-items: flex-start; padding: 22px 18px; flex-direction: column; gap: 16px; }
        .loan-detail-heading { gap: 13px; }
        .loan-detail-item-image { width: 58px; height: 58px; flex-basis: 58px; }
        .loan-detail-title { font-size: 20px; }
        .loan-detail-section { padding: 20px 18px; }
        .loan-detail-grid { grid-template-columns: 1fr; gap: 9px; }
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
            <div class="loan-detail-heading">
                <div class="loan-detail-item-image">
                    @if($peminjaman->barang?->foto)
                        <img src="{{ asset('storage/' . $peminjaman->barang->foto) }}" alt="{{ $peminjaman->barang->nama_barang }}">
                    @else
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <path d="m3.3 7 8.7 5 8.7-5M12 22V12"></path>
                        </svg>
                    @endif
                </div>
                <div>
                    <div class="loan-detail-eyebrow">Informasi Peminjaman</div>
                    <h1 class="loan-detail-title">{{ $peminjaman->barang->nama_barang ?? 'Fasilitas' }}</h1>
                    <p class="loan-detail-code">Nomor pengajuan: {{ $peminjaman->kode_pinjam }}</p>
                </div>
            </div>
            <span class="loan-detail-status {{ $statusClass }}">{{ $statusLabel }}</span>
        </header>

        <section class="loan-detail-section">
            <div class="loan-detail-section-header">
                <span class="loan-detail-section-icon" aria-hidden="true">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M8 6h13M8 12h13M8 18h13"></path><path d="M3 6h.01M3 12h.01M3 18h.01"></path>
                    </svg>
                </span>
                <div>
                    <h2>Rincian Pengajuan</h2>
                    <p>Data barang dan jadwal peminjaman</p>
                </div>
            </div>
            <div class="loan-detail-grid">
                <div class="loan-detail-field">
                    <div class="loan-detail-label">Nama Barang</div>
                    <div class="loan-detail-value">{{ $peminjaman->barang->nama_barang ?? $peminjaman->kode_barang }}</div>
                </div>
                <div class="loan-detail-field">
                    <div class="loan-detail-label">Kode Barang</div>
                    <div class="loan-detail-value">{{ $peminjaman->kode_barang }}</div>
                </div>
                <div class="loan-detail-field">
                    <div class="loan-detail-label">Kategori</div>
                    <div class="loan-detail-value">{{ $peminjaman->barang->kategori->nama_kategori ?? '-' }}</div>
                </div>
                <div class="loan-detail-field">
                    <div class="loan-detail-label">Tanggal Pengajuan</div>
                    <div class="loan-detail-value">{{ $peminjaman->created_at?->format('d M Y, H:i') ?? '-' }}</div>
                </div>
                <div class="loan-detail-field">
                    <div class="loan-detail-label">Tanggal Pinjam</div>
                    <div class="loan-detail-value">{{ $peminjaman->tanggal_pinjam?->format('d M Y') ?? '-' }}{{ $peminjaman->jam_pinjam ? ' · ' . $peminjaman->jam_pinjam : '' }}</div>
                </div>
                <div class="loan-detail-field">
                    <div class="loan-detail-label">Rencana Pengembalian</div>
                    <div class="loan-detail-value">{{ $peminjaman->tanggal_kembali?->format('d M Y') ?? '-' }}{{ $peminjaman->jam_kembali ? ' · ' . $peminjaman->jam_kembali : '' }}</div>
                </div>
                <div class="loan-detail-field">
                    <div class="loan-detail-label">Nomor Telepon</div>
                    <div class="loan-detail-value">{{ $peminjaman->nomor_telepon ?? '-' }}</div>
                </div>
                <div class="loan-detail-field">
                    <div class="loan-detail-label">Status Pengajuan</div>
                    <div class="loan-detail-value">{{ $statusLabel }}</div>
                </div>
            </div>
        </section>

        <section class="loan-detail-section">
            <div class="loan-detail-section-header">
                <span class="loan-detail-section-icon" aria-hidden="true">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><path d="M14 2v6h6M8 13h8M8 17h8"></path>
                    </svg>
                </span>
                <div>
                    <h2>Keperluan Peminjaman</h2>
                    <p>Tujuan penggunaan barang</p>
                </div>
            </div>
            <div class="loan-detail-note-box">
                <p class="loan-detail-note">{{ $peminjaman->keterangan_penggunaan ?: 'Tidak ada catatan keperluan.' }}</p>
            </div>
        </section>

        @if($pengembalian)
            <section class="loan-detail-section">
                <div class="loan-detail-section-header">
                    <span class="loan-detail-section-icon" aria-hidden="true">
                        <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 12a9 9 0 1 0 3-6.7L3 8"></path><path d="M3 3v5h5"></path><path d="M12 7v5l3 2"></path>
                        </svg>
                    </span>
                    <div>
                        <h2>Informasi Pengembalian</h2>
                        <p>Pelaporan dan pemeriksaan barang</p>
                    </div>
                </div>
                <div class="loan-detail-grid">
                    <div class="loan-detail-field">
                        <div class="loan-detail-label">Tanggal Dilaporkan Kembali</div>
                        <div class="loan-detail-value">{{ $pengembalian->tanggal_kembali?->format('d M Y') ?? '-' }}</div>
                    </div>
                    <div class="loan-detail-field">
                        <div class="loan-detail-label">Kondisi Barang</div>
                        <div class="loan-detail-value">{{ $pengembalian->kondisi_barang ?: 'Belum dicatat' }}</div>
                    </div>
                    <div class="loan-detail-field">
                        <div class="loan-detail-label">Status Verifikasi</div>
                        <div class="loan-detail-value">{{ $pengembalian->status === 'selesai' ? 'Selesai' : 'Menunggu verifikasi admin' }}</div>
                    </div>
                    <div class="loan-detail-field">
                        <div class="loan-detail-label">Waktu Laporan</div>
                        <div class="loan-detail-value">{{ $pengembalian->created_at?->format('d M Y, H:i') ?? '-' }}</div>
                    </div>
                </div>
                @if($pengembalian->status === 'menunggu')
                    <div class="loan-detail-return-status" role="status">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"></circle><path d="M12 7v5l3 2"></path>
                        </svg>
                        <span><strong>Laporan diterima.</strong> Pengembalian sedang menunggu pemeriksaan dan verifikasi Admin Sarana.</span>
                    </div>
                @endif
            </section>

            @if($pengembalian->bukti_foto_video)
                <section class="loan-detail-section">
                    <div class="loan-detail-section-header">
                        <span class="loan-detail-section-icon" aria-hidden="true">
                            <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><path d="m21 15-5-5L5 21"></path>
                            </svg>
                        </span>
                        <div>
                            <h2>Bukti Pengembalian</h2>
                            <p>Lampiran foto atau video</p>
                        </div>
                    </div>
                    @if(\Illuminate\Support\Str::startsWith($pengembalian->bukti_foto_video, 'pengembalian/'))
                        @php
                            $evidenceUrl = asset('storage/' . $pengembalian->bukti_foto_video);
                            $extension = strtolower(pathinfo($pengembalian->bukti_foto_video, PATHINFO_EXTENSION));
                            $isVideo = in_array($extension, ['mp4', 'mov', 'avi', 'webm', 'mkv'], true);
                        @endphp
                        @if($isVideo)
                            <div class="loan-detail-evidence-wrap">
                                <video class="loan-detail-evidence" controls preload="metadata" src="{{ $evidenceUrl }}">
                                    Browser tidak mendukung pemutar video.
                                </video>
                            </div>
                        @else
                            <div class="loan-detail-evidence-wrap">
                                <a href="{{ $evidenceUrl }}" target="_blank" rel="noopener noreferrer">
                                    <img class="loan-detail-evidence" src="{{ $evidenceUrl }}" alt="Bukti foto pengembalian barang">
                                </a>
                            </div>
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
