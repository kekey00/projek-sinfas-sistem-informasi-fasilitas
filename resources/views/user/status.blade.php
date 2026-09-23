@extends('layouts.user')

@section('title', 'Status Pengajuan Peminjaman - SINFAS')

@section('styles')
<style>
    .status-hero-heading {
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

    /* FILTER TABS PILLS */
    .filter-tabs-row {
        display: flex;
        align-items: center;
        gap: 8px;
        overflow-x: auto;
        padding-bottom: 4px;
        margin-bottom: 24px;
    }

    .filter-tab-pill {
        padding: 7px 18px;
        border-radius: var(--radius-pill);
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        color: var(--text-secondary);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        user-select: none;
    }

    .filter-tab-pill:hover {
        border-color: var(--brand-primary);
        color: var(--brand-primary);
    }

    .filter-tab-pill.active {
        background: #1E1B4B;
        border-color: #1E1B4B;
        color: #FFFFFF;
        box-shadow: 0 4px 12px rgba(30, 27, 75, 0.2);
    }

    /* STATUS CARD LIST */
    .cards-stack-list {
        display: flex;
        flex-direction: column;
        gap: 18px;
    }

    .loan-card-vibe {
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 22px;
        padding: 22px 28px;
        display: flex;
        flex-direction: column;
        gap: 16px;
        box-shadow: var(--shadow-card);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
    }

    .loan-card-vibe:hover {
        transform: translateY(-4px);
        border-color: rgba(99, 102, 241, 0.4);
        box-shadow: var(--shadow-card-hover);
    }

    .card-main-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        flex-wrap: wrap;
    }

    .card-left-identity {
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .thumb-aspect-box {
        width: 80px;
        height: 80px;
        border-radius: 18px;
        background: #F8FAFC;
        border: 1.5px solid #E2E8F0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
        padding: 6px;
    }

    .thumb-aspect-box img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
    }

    .item-meta-column {
        display: flex;
        flex-direction: column;
        gap: 4px;
    }

    .item-title-bold {
        font-size: 18px;
        font-weight: 800;
        color: var(--text-main);
    }

    .item-tags-row {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13px;
        color: var(--text-secondary);
        flex-wrap: wrap;
    }

    .code-pill {
        font-weight: 700;
        color: var(--brand-primary);
        background: #EEF2FF;
        padding: 2px 8px;
        border-radius: 6px;
    }

    /* BADGES */
    .status-badge-genz {
        padding: 6px 16px;
        border-radius: var(--radius-pill);
        font-size: 12.5px;
        font-weight: 800;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }

    .status-badge-genz.pending {
        background: #FFFBEB;
        color: #B45309;
        border: 1.5px solid #FCD34D;
    }

    .status-badge-genz.approved {
        background: #ECFDF5;
        color: #047857;
        border: 1.5px solid #A7F3D0;
    }

    .status-badge-genz.rejected {
        background: #FFF1F2;
        color: #BE123C;
        border: 1.5px solid #FECDD3;
    }

    .status-badge-genz.returned {
        background: #F0FDF4;
        color: #15803D;
        border: 1.5px solid #86EFAC;
    }

    .badge-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    /* CARD BOTTOM SECTION */
    .card-footer-action-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-top: 12px;
        border-top: 1px solid #F1F5F9;
        flex-wrap: wrap;
        gap: 12px;
    }

    .btn-return-vibe {
        background: var(--brand-gradient);
        color: #FFFFFF;
        padding: 9px 22px;
        border-radius: var(--radius-md);
        font-size: 13.5px;
        font-weight: 800;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: var(--shadow-glow);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        margin-left: auto;
    }

    .btn-return-vibe:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(79, 70, 229, 0.4);
    }

    .rejection-vibe-box {
        background: #FFF1F2;
        border: 1.5px solid #FFE4E6;
        border-radius: var(--radius-md);
        padding: 12px 16px;
        font-size: 13px;
        color: #9F1239;
        display: flex;
        align-items: flex-start;
        gap: 10px;
        width: 100%;
    }

    .returned-vibe-box {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: var(--radius-md);
        padding: 10px 16px;
        font-size: 13px;
        color: var(--text-secondary);
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
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
    <div class="status-hero-heading">
        <div>
            <h1 class="title-vibe-bold">Status Pengajuan Pinjamanmu 🚀</h1>
            <p style="font-size: 14.5px; color: var(--text-secondary); margin-top: 4px;">
                Pantau proses verifikasi admin & ajukan pengembalian dengan cepat.
            </p>
        </div>
        <a href="{{ route('user.dashboard') }}" class="btn-genz-primary" style="font-size: 13.5px; padding: 10px 20px;">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
            Pinjam Alat Baru
        </a>
    </div>

    <!-- FILTER TABS -->
    <div class="filter-tabs-row">
        <div class="filter-tab-pill active" onclick="filterStatus('all', this)">
            <span>Semua</span>
            <span style="opacity: 0.7;">({{ $peminjamans->count() }})</span>
        </div>
        <div class="filter-tab-pill" onclick="filterStatus('menunggu', this)">
            <span>⏳ Menunggu</span>
            <span style="opacity: 0.7;">({{ $peminjamans->where('status_pengajuan', 'menunggu')->count() }})</span>
        </div>
        <div class="filter-tab-pill" onclick="filterStatus('disetujui', this)">
            <span>✅ Disetujui</span>
            <span style="opacity: 0.7;">({{ $peminjamans->where('status_pengajuan', 'disetujui')->whereNull('pengembalian')->count() }})</span>
        </div>
        <div class="filter-tab-pill" onclick="filterStatus('returned', this)">
            <span>📦 Selesai</span>
            <span style="opacity: 0.7;">({{ $peminjamans->whereNotNull('pengembalian')->count() }})</span>
        </div>
        <div class="filter-tab-pill" onclick="filterStatus('ditolak', this)">
            <span>❌ Ditolak</span>
            <span style="opacity: 0.7;">({{ $peminjamans->where('status_pengajuan', 'ditolak')->count() }})</span>
        </div>
    </div>

    <!-- CARDS LIST -->
    <div class="cards-stack-list" id="loan-items-container">
        @forelse($peminjamans as $pjm)
            @php
                $barang = $pjm->barang;
                $isApproved = $pjm->status_pengajuan === 'disetujui';
                $isPending = $pjm->status_pengajuan === 'menunggu';
                $isRejected = $pjm->status_pengajuan === 'ditolak';
                $isReturned = $pjm->pengembalian !== null;
                $filterCategory = $isReturned ? 'returned' : $pjm->status_pengajuan;
            @endphp

            <div class="loan-card-vibe" data-status="{{ $filterCategory }}" id="card-loan-{{ $pjm->kode_pinjam }}">
                <div class="card-main-row">
                    <div class="card-left-identity">
                        <div class="thumb-aspect-box">
                            @if($barang && $barang->foto)
                                <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}">
                            @else
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="#818CF8" stroke-width="1.8">
                                    <rect x="2" y="7" width="20" height="14" rx="2"/><circle cx="12" cy="14" r="3"/><path d="M12 3v4"/><path d="M8 3h8"/>
                                </svg>
                            @endif
                        </div>

                        <div class="item-meta-column">
                            <h2 class="item-title-bold">{{ $barang->nama_barang ?? 'Fasilitas' }}</h2>
                            <div class="item-tags-row">
                                <span class="code-pill">#{{ $pjm->kode_pinjam }}</span>
                                <span>&bull;</span>
                                <span>Kategori: <strong>{{ $barang->kategori->nama_kategori ?? '-' }}</strong></span>
                                <span>&bull;</span>
                                <span>{{ $pjm->tanggal_pinjam ? $pjm->tanggal_pinjam->format('d M Y') : '-' }} &rarr; {{ $pjm->tanggal_kembali ? $pjm->tanggal_kembali->format('d M Y') : '-' }}</span>
                                @if($pjm->nomor_telepon)
                                    <span>&bull;</span>
                                    <span>No. Telp: <strong>{{ $pjm->nomor_telepon }}</strong></span>
                                @endif
                            </div>
                            @if($pjm->keterangan_penggunaan)
                                <div style="font-size: 13px; color: #475569; margin-top: 4px;">
                                    Keperluan: <em>"{{ $pjm->keterangan_penggunaan }}"</em>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- BADGE -->
                    <div>
                        @if($isReturned)
                            <span class="status-badge-genz returned">
                                <span class="badge-dot"></span>
                                <span>Dikembalikan</span>
                            </span>
                        @elseif($isApproved)
                            <span class="status-badge-genz approved">
                                <span class="badge-dot"></span>
                                <span>Disetujui</span>
                            </span>
                        @elseif($isPending)
                            <span class="status-badge-genz pending">
                                <span class="badge-dot"></span>
                                <span>Menunggu</span>
                            </span>
                        @elseif($isRejected)
                            <span class="status-badge-genz rejected">
                                <span class="badge-dot"></span>
                                <span>Ditolak</span>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- CARD ACTIONS OR NOTES -->
                @if($isApproved && !$isReturned)
                    <div class="card-footer-action-row">
                        <span style="font-size: 13px; color: #047857; font-weight: 600;">
                            ✨ Pengajuan disetujui! Ambil barang dan klik tombol di samping setelah selesai:
                        </span>
                        <a href="{{ route('user.pengembalian.create', $pjm->kode_pinjam) }}" class="btn-return-vibe" id="btn-return-{{ $pjm->kode_pinjam }}">
                            <span>Ajukan Pengembalian</span>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </a>
                    </div>
                @endif

                @if($isRejected)
                    <div class="rejection-vibe-box">
                        <span style="font-size: 18px;">⚠️</span>
                        <div>
                            <strong>Catatan Penolakan:</strong> Permintaan peminjaman belum dapat disetujui oleh admin sarana prasarana. Silakan periksa kembali jadwal peminjaman atau pilih unit lain.
                        </div>
                    </div>
                @endif

                @if($isReturned)
                    <div class="returned-vibe-box">
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <span style="color: #10B981; font-size: 16px;">✓</span>
                            <span>Barang telah dikembalikan pada <strong>{{ $pjm->pengembalian->tanggal_kembali ? $pjm->pengembalian->tanggal_kembali->format('d M Y') : '-' }}</strong></span>
                        </div>
                        <span style="font-weight: 700; color: var(--text-main);">Kondisi: {{ $pjm->pengembalian->kondisi_barang ?? 'Baik' }}</span>
                    </div>
                @endif
            </div>
        @empty
            <div style="background:#FFFFFF; border: 2px dashed #E2E8F0; border-radius: 24px; padding: 60px 20px; text-align: center; color: var(--text-muted);">
                <div style="font-size: 44px; margin-bottom: 12px;">📦</div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--text-main); margin-bottom: 4px;">Belum Ada Pengajuan</h3>
                <p style="font-size: 14px; margin-bottom: 18px;">Kamu belum pernah mengajukan peminjaman fasilitas sekolah.</p>
                <a href="{{ route('user.dashboard') }}" class="btn-genz-primary">
                    Mulai Pinjam Sekarang
                </a>
            </div>
        @endforelse
    </div>

    <!-- MODAL POPUP MENUNGGU PERSETUJUAN ADMIN -->
    <div class="modal-shade {{ session('loan_submitted') ? 'open' : '' }}" id="waiting-approval-modal">
        <div class="modal-box-vibe">
            <div class="modal-pulse-circle" style="background:#E0F2FE; color:#0284C7;">
                <svg width="38" height="38" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <h3 style="font-size: 22px; font-weight: 900; letter-spacing: -0.4px; margin-bottom: 8px;">Menunggu Persetujuan Admin ⏳</h3>
            <p style="font-size: 14px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 24px;">
                Permintaan peminjaman Anda telah terkirim ke dalam antrean. Mohon tunggu konfirmasi dari Admin Sarpras.
            </p>
            <button type="button" class="btn-genz-primary" style="width: 100%;" onclick="closeApprovalModal()" id="btn-close-approval-modal">
                Tutup
            </button>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function closeApprovalModal() {
        const modal = document.getElementById('waiting-approval-modal');
        if (modal) modal.classList.remove('open');
    }

    function filterStatus(status, el) {
        document.querySelectorAll('.filter-tab-pill').forEach(pill => pill.classList.remove('active'));
        el.classList.add('active');

        const cards = document.querySelectorAll('.loan-card-vibe');
        cards.forEach(card => {
            if (status === 'all' || card.getAttribute('data-status') === status) {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        });
    }
</script>
@endsection
