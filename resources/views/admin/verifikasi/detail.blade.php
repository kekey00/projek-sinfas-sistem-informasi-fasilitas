@extends('layouts.admin')

@section('title', 'Detail Peminjaman ' . $peminjaman->kode_pinjam . ' - SINFAS')
@section('page_title', 'Detail Peminjaman')

@section('styles')
<style>
    .detail-back-link {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #3B5998;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        width: fit-content;
    }

    .detail-back-link:hover { color: #2C4A7C; }

    .detail-card {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }

    .detail-card-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        padding: 22px 24px;
        border-bottom: 1px solid #F1F5F9;
    }

    .detail-title {
        color: #0F172A;
        font-family: 'Outfit', sans-serif;
        font-size: 19px;
        font-weight: 700;
    }

    .detail-code {
        color: #64748B;
        font-size: 12px;
        margin-top: 4px;
    }

    .detail-status {
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        padding: 6px 11px;
        white-space: nowrap;
    }

    .detail-status.done { background: #ECFDF5; color: #047857; }
    .detail-status.rejected { background: #FEF2F2; color: #B91C1C; }
    .detail-status.pending { background: #FFFBEB; color: #B45309; }
    .detail-status.active { background: #EEF2FF; color: #3B5998; }

    .detail-section {
        padding: 22px 24px;
    }

    .detail-section + .detail-section { border-top: 1px solid #F1F5F9; }

    .detail-section-title {
        color: #1E293B;
        font-family: 'Outfit', sans-serif;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 14px;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px 24px;
    }

    .detail-field-label {
        color: #94A3B8;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: .05em;
        text-transform: uppercase;
    }

    .detail-field-value {
        color: #334155;
        font-size: 13px;
        font-weight: 500;
        margin-top: 4px;
        overflow-wrap: anywhere;
    }

    .detail-evidence {
        display: block;
        max-width: min(100%, 560px);
        max-height: 420px;
        border-radius: 12px;
        border: 1px solid #E2E8F0;
        object-fit: contain;
        background: #F8FAFC;
    }

    .detail-note {
        color: #475569;
        font-size: 13px;
        line-height: 1.65;
        white-space: pre-wrap;
    }

    @media (max-width: 600px) {
        .detail-card-header { padding: 18px; flex-direction: column; }
        .detail-section { padding: 18px; }
        .detail-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')
<a class="detail-back-link" href="{{ route('admin.riwayat.index') }}">
    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
        <path d="M19 12H5M12 19l-7-7 7-7"></path>
    </svg>
    Kembali ke Riwayat Peminjaman
</a>

@php
    $return = $peminjaman->pengembalian;
    $statusClass = $return?->status === 'selesai'
        ? 'done'
        : ($peminjaman->status_pengajuan === 'ditolak' ? 'rejected' : ($peminjaman->status_pengajuan === 'menunggu' ? 'pending' : 'active'));
    $statusLabel = $return?->status === 'selesai'
        ? 'Pengembalian selesai'
        : ($return?->status === 'menunggu' ? 'Menunggu verifikasi pengembalian' : ucfirst($peminjaman->status_pengajuan));
@endphp

<section class="detail-card">
    <header class="detail-card-header">
        <div>
            <h2 class="detail-title">{{ $peminjaman->barang->nama_barang ?? $peminjaman->kode_barang }}</h2>
            <p class="detail-code">Kode peminjaman: {{ $peminjaman->kode_pinjam }}</p>
        </div>
        <span class="detail-status {{ $statusClass }}">{{ $statusLabel }}</span>
    </header>

    <div class="detail-section">
        <h3 class="detail-section-title">Informasi Peminjaman</h3>
        <div class="detail-grid">
            <div>
                <div class="detail-field-label">Peminjam</div>
                <div class="detail-field-value">{{ $peminjaman->siswa->nama ?? 'Siswa' }} (NIS: {{ $peminjaman->nis }})</div>
            </div>
            <div>
                <div class="detail-field-label">Barang</div>
                <div class="detail-field-value">{{ $peminjaman->barang->nama_barang ?? $peminjaman->kode_barang }}</div>
            </div>
            <div>
                <div class="detail-field-label">Kategori</div>
                <div class="detail-field-value">{{ $peminjaman->barang->kategori->nama_kategori ?? '-' }}</div>
            </div>
            <div>
                <div class="detail-field-label">Nomor Telepon</div>
                <div class="detail-field-value">{{ $peminjaman->nomor_telepon ?? $peminjaman->siswa->nomor_kontak ?? '-' }}</div>
            </div>
            <div>
                <div class="detail-field-label">Tanggal Peminjaman</div>
                <div class="detail-field-value">{{ $peminjaman->tanggal_pinjam?->format('d M Y') ?? '-' }}{{ $peminjaman->jam_pinjam ? ' · ' . $peminjaman->jam_pinjam : '' }}</div>
            </div>
            <div>
                <div class="detail-field-label">Rencana Kembali</div>
                <div class="detail-field-value">{{ $peminjaman->tanggal_kembali?->format('d M Y') ?? '-' }}{{ $peminjaman->jam_kembali ? ' · ' . $peminjaman->jam_kembali : '' }}</div>
            </div>
            <div>
                <div class="detail-field-label">Tanggal Pengajuan</div>
                <div class="detail-field-value">{{ $peminjaman->created_at?->format('d M Y, H:i') ?? '-' }}</div>
            </div>
            <div>
                <div class="detail-field-label">Kode Barang</div>
                <div class="detail-field-value">{{ $peminjaman->kode_barang }}</div>
            </div>
        </div>
    </div>

    <div class="detail-section">
        <h3 class="detail-section-title">Keperluan / Catatan</h3>
        <p class="detail-note">{{ $peminjaman->keterangan_penggunaan ?: '-' }}</p>
    </div>

    @if($return)
        <div class="detail-section">
            <h3 class="detail-section-title">Informasi Pengembalian</h3>
            <div class="detail-grid">
                <div>
                    <div class="detail-field-label">Tanggal Pengembalian</div>
                    <div class="detail-field-value">{{ $return->tanggal_kembali?->format('d M Y') ?? '-' }}</div>
                </div>
                <div>
                    <div class="detail-field-label">Kondisi Barang</div>
                    <div class="detail-field-value">{{ $return->kondisi_barang ?: 'Belum dicatat' }}</div>
                </div>
                <div>
                    <div class="detail-field-label">Status Verifikasi</div>
                    <div class="detail-field-value">{{ ucfirst($return->status ?? 'menunggu') }}</div>
                </div>
                <div>
                    <div class="detail-field-label">Waktu Laporan</div>
                    <div class="detail-field-value">{{ $return->created_at?->format('d M Y, H:i') ?? '-' }}</div>
                </div>
            </div>
        </div>

        @if($return->bukti_foto_video)
            <div class="detail-section">
                <h3 class="detail-section-title">Bukti Pengembalian</h3>
                @if(\Illuminate\Support\Str::startsWith($return->bukti_foto_video, 'pengembalian/'))
                    @php
                        $evidenceUrl = asset('storage/' . $return->bukti_foto_video);
                        $extension = strtolower(pathinfo($return->bukti_foto_video, PATHINFO_EXTENSION));
                        $isVideo = in_array($extension, ['mp4', 'mov', 'avi', 'webm', 'mkv'], true);
                    @endphp
                    @if($isVideo)
                        <video class="detail-evidence" controls preload="metadata" src="{{ $evidenceUrl }}">
                            Browser tidak mendukung pemutar video.
                        </video>
                    @else
                        <a href="{{ $evidenceUrl }}" target="_blank" rel="noopener noreferrer">
                            <img class="detail-evidence" src="{{ $evidenceUrl }}" alt="Bukti pengembalian barang">
                        </a>
                    @endif
                @else
                    <p class="detail-note">{{ $return->bukti_foto_video }}</p>
                @endif
            </div>
        @endif
    @endif
</section>
@endsection
