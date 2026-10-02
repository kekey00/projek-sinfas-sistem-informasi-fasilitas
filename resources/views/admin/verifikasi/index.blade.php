@extends('layouts.admin')

@section('title', (($tab ?? '') === 'history' ? 'Riwayat Peminjaman' : 'Verifikasi Peminjaman & Pengembalian') . ' - SINFAS')
@section('page_title', ($tab ?? '') === 'history' ? 'Riwayat Peminjaman' : 'Verifikasi Pengajuan')

@section('styles')
<style>
    /* ─── SEGMENTED TAB CONTROL (MINIMALIST) ─── */
    .verify-tabs-bar {
        display: inline-flex;
        gap: 4px;
        margin-bottom: 20px;
        background: #F1F5F9;
        border-radius: 8px;
        padding: 4px;
        border: 1px solid #E2E8F0;
    }
    .verify-tab-item {
        padding: 7px 18px;
        border-radius: 6px;
        font-size: 13px;
        font-weight: 500;
        text-decoration: none;
        color: #64748B;
        background: transparent;
        transition: all 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
        font-family: inherit;
    }
    .verify-tab-item:hover {
        color: #0F172A;
    }
    .verify-tab-item.active {
        background: linear-gradient(135deg, #6B8DD6 0%, #3B5998 100%);
        color: #FFFFFF;
        font-weight: 600;
        box-shadow: 0 3px 10px rgba(44, 74, 124, 0.25);
    }
    .tab-badge-pill {
        padding: 2px 7px;
        border-radius: 999px;
        font-size: 11px;
        font-weight: 600;
    }
    .verify-tab-item.active .tab-badge-pill {
        background: rgba(255,255,255,0.25);
        color: #FFFFFF;
    }
    .verify-tab-item:not(.active) .tab-badge-pill {
        background: #E2E8F0;
        color: #64748B;
    }

    /* ─── SECTION TITLE ─── */
    .section-title-verif {
        font-family: 'Outfit', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #0F172A;
        margin-bottom: 12px;
        display: flex;
        align-items: center;
        gap: 8px;
        letter-spacing: -0.2px;
    }

    /* ─── TABLE CONTAINER ─── */
    .verif-card-wrap {
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.05);
        border: 1px solid #E2E8F0;
        overflow: hidden;
    }
    .verif-table-responsive {
        width: 100%;
        overflow-x: auto;
    }
    .verif-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    .verif-table thead tr {
        background: #F8FAFC;
        border-bottom: 1px solid #E2E8F0;
    }
    .verif-table th {
        padding: 12px 20px;
        font-size: 11.5px;
        font-weight: 600;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .verif-table td {
        padding: 14px 20px;
        border-bottom: 1px solid #F1F5F9;
        font-size: 13px;
        color: #1E293B;
        vertical-align: middle;
    }
    .verif-table tbody tr:last-child td {
        border-bottom: none;
    }
    .verif-table tbody tr:hover td {
        background: #F8FAFC;
    }

    /* Student Avatar Circle */
    .verif-student-cell {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .student-circle-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, #6B8DD6, #3B5998);
        color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Outfit', sans-serif;
        font-weight: 700;
        font-size: 12px;
        flex-shrink: 0;
    }

    /* Inline condition select */
    .condition-select {
        border: 1px solid #CBD5E1;
        border-radius: 6px;
        padding: 6px 10px;
        font-size: 12.5px;
        color: #0F172A;
        background: #FFFFFF;
        cursor: pointer;
        outline: none;
        min-width: 120px;
        font-family: inherit;
        font-weight: 500;
        transition: border-color 0.15s ease;
    }
    .condition-select:focus {
        border-color: #3B5998;
    }

    /* Evidence buttons */
    .evidence-icons {
        display: flex;
        gap: 6px;
        align-items: center;
    }
    .evidence-icon-btn {
        width: 32px;
        height: 32px;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        background: #FFFFFF;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748B;
        transition: all 0.15s ease;
    }
    .evidence-icon-btn:hover {
        background: #F8FAFC;
        border-color: #CBD5E1;
        color: #0F172A;
    }

    /* Action buttons */
    .action-btns-wrap {
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .btn-approve {
        background: linear-gradient(135deg, #6B8DD6 0%, #3B5998 100%);
        color: #FFFFFF;
        border: 1px solid transparent;
        border-radius: 6px;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
        font-family: inherit;
        white-space: nowrap;
        box-shadow: 0 2px 6px rgba(44, 74, 124, 0.2);
    }
    .btn-approve:hover {
        background: linear-gradient(135deg, #5B8DEF 0%, #2F4D8A 100%);
    }
    .btn-reject {
        background: #FFFFFF;
        color: #DC2626;
        border: 1px solid #FEE2E2;
        border-radius: 6px;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.15s ease;
        font-family: inherit;
        white-space: nowrap;
    }
    .btn-reject:hover {
        background: #FEF2F2;
    }
    .btn-confirm {
        background: #059669;
        color: #FFFFFF;
        border: 1px solid transparent;
        border-radius: 6px;
        padding: 6px 14px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.15s ease;
        font-family: inherit;
        white-space: nowrap;
    }
    .btn-confirm:hover {
        background: #047857;
    }

    /* ─── PAGINATION ─── */
    .verif-pagination {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 4px;
        padding: 14px 20px;
        border-top: 1px solid #E2E8F0;
        background: #FFFFFF;
    }
    .page-nav-btn {
        min-width: 32px;
        height: 32px;
        padding: 0 10px;
        border: 1px solid #E2E8F0;
        background: #FFFFFF;
        color: #475569;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s ease;
        text-decoration: none;
    }
    .page-nav-btn:hover {
        background: #F8FAFC;
        border-color: #CBD5E1;
        color: #0F172A;
    }
    .page-nav-btn.active {
        background: #0F172A;
        border-color: #0F172A;
        color: #FFFFFF;
        font-weight: 600;
    }

    /* ─── EMPTY STATE ─── */
    .empty-state {
        text-align: center;
        padding: 40px 20px;
        color: #94A3B8;
        font-size: 13.5px;
    }
    .empty-state-icon {
        font-size: 28px;
        margin-bottom: 8px;
        display: block;
        opacity: 0.6;
    }

    .approve-modal-card {
        max-width: 520px;
        padding: 0;
        overflow: hidden;
        border-radius: 16px;
    }
    .approve-modal-card .modal-header {
        align-items: flex-start;
        margin: 0;
        padding: 24px 26px 18px;
        border-bottom: 0;
    }
    .approve-modal-heading { display: flex; align-items: center; gap: 14px; }
    .approve-modal-icon {
        display: grid;
        width: 48px;
        height: 48px;
        flex: 0 0 auto;
        place-items: center;
        border: 1px solid #BFDBFE;
        border-radius: 14px;
        background: #EFF6FF;
        color: #2563EB;
    }
    .approve-modal-icon svg { width: 23px; height: 23px; }
    .approve-modal-kicker { display: block; margin-bottom: 4px; color: #2563EB; font-size: 10px; font-weight: 800; letter-spacing: .8px; }
    .approve-modal-card .modal-title { font-size: 20px; line-height: 1.2; }
    .approve-modal-card .modal-close-btn { flex: 0 0 auto; }
    .approve-modal-copy { margin: 0 26px 16px; color: #64748B; font-size: 13px; line-height: 1.65; }
    .approve-modal-summary {
        margin: 0 26px;
        padding: 4px 15px;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        background: #F8FAFC;
    }
    .approve-modal-detail { display: flex; align-items: center; gap: 12px; padding: 12px 0; }
    .approve-modal-detail + .approve-modal-detail { border-top: 1px solid #E2E8F0; }
    .approve-modal-detail-icon {
        display: grid;
        width: 36px;
        height: 36px;
        flex: 0 0 auto;
        place-items: center;
        border-radius: 10px;
        background: #EAF0FB;
        color: #3B5998;
    }
    .approve-modal-detail-icon svg { width: 18px; height: 18px; }
    .approve-modal-detail-copy { display: grid; min-width: 0; gap: 3px; }
    .approve-modal-detail-copy span { color: #64748B; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: .5px; }
    .approve-modal-detail-copy strong { color: #0F172A; font-size: 13px; font-weight: 700; overflow-wrap: anywhere; }
    .approve-modal-impact {
        display: flex;
        align-items: flex-start;
        gap: 9px;
        margin: 14px 26px 0;
        padding: 11px 12px;
        border: 1px solid #DBEAFE;
        border-radius: 10px;
        background: #EFF6FF;
        color: #1E40AF;
        font-size: 11.5px;
        line-height: 1.6;
    }
    .approve-modal-impact svg { width: 16px; height: 16px; flex: 0 0 auto; margin-top: 1px; }
    .approve-modal-impact p { margin: 0; }
    .approve-modal-card .modal-footer { margin: 18px 26px 24px; padding-top: 16px; }
    .approve-modal-card .btn-cancel,
    .approve-modal-card .btn-submit { min-height: 40px; padding: 9px 16px; border-radius: 8px; }
    .approve-modal-card .btn-submit { display: inline-flex; align-items: center; gap: 8px; }
    .approve-modal-card .btn-submit svg { width: 15px; height: 15px; }

    /* ─── RESPONSIVE RULES (MOBILE) ─── */
    @media (max-width: 768px) {
        .verify-tabs-bar {
            width: 100%;
            display: flex;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding: 4px;
            gap: 4px;
        }

        .verify-tab-item {
            padding: 7px 14px;
            font-size: 12px;
            flex-shrink: 0;
        }

        .section-title-verif {
            font-size: 14.5px;
            margin-bottom: 10px;
        }

        .approve-modal-card .modal-header { padding: 20px 20px 16px; }
        .approve-modal-copy { margin-right: 20px; margin-left: 20px; }
        .approve-modal-summary { margin-right: 20px; margin-left: 20px; }
        .approve-modal-impact { margin-right: 20px; margin-left: 20px; }
        .approve-modal-card .modal-footer { margin: 16px 20px 20px; }

        .verif-pagination {
            justify-content: center;
            flex-wrap: wrap;
            padding: 12px 14px;
        }
    }
</style>
@endsection

@section('content')

{{-- ── Tab Switcher ── --}}
<div class="verify-tabs-bar">
    <a href="{{ route('admin.verifikasi.index', ['tab' => 'requests']) }}"
       class="verify-tab-item {{ $tab === 'requests' ? 'active' : '' }}">
        <span>Pengajuan Pinjaman</span>
        @if($pendingRequests->total() > 0)
            <span class="tab-badge-pill">{{ $pendingRequests->total() }}</span>
        @endif
    </a>
    <a href="{{ route('admin.verifikasi.index', ['tab' => 'returns']) }}"
       class="verify-tab-item {{ $tab === 'returns' ? 'active' : '' }}">
        <span>Pengembalian Barang</span>
        @if($activeLoans->total() > 0)
            <span class="tab-badge-pill">{{ $activeLoans->total() }}</span>
        @endif
    </a>
    <a href="{{ route('admin.verifikasi.index', ['tab' => 'history']) }}"
       class="verify-tab-item {{ $tab === 'history' ? 'active' : '' }}">
        <span>Riwayat Selesai</span>
        @if($historyLoans->total() > 0)
            <span class="tab-badge-pill">{{ $historyLoans->total() }}</span>
        @endif
    </a>
</div>

{{-- ─── TAB 1: PENDING REQUESTS ─── --}}
@if($tab === 'requests')
<div class="section-title-verif">
    <span>Daftar Pengajuan Pinjaman Menunggu Verifikasi</span>
</div>

<div class="verif-card-wrap">
    <div class="verif-table-responsive">
        <table class="verif-table">
            <thead>
                <tr>
                    <th style="width: 22%;">Peminjam</th>
                    <th style="width: 20%;">Alat / Fasilitas</th>
                    <th style="width: 14%;">Lokasi</th>
                    <th style="width: 22%;">Keperluan Pinjam</th>
                    <th style="width: 10%;">Tgl. Pinjam</th>
                    <th style="width: 12%; text-align: right; padding-right: 20px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingRequests as $pjm)
                <tr>
                    <td>
                        <div class="verif-student-cell">
                            <div class="student-circle-avatar">
                                {{ strtoupper(substr($pjm->siswa->nama ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #0F172A;">{{ $pjm->siswa->nama ?? 'Siswa' }}</div>
                                <div style="font-size: 11.5px; color: #64748B;">NIS: {{ $pjm->nis }}</div>
                                @php
                                    $phoneReq = $pjm->nomor_telepon ?? ($pjm->siswa->nomor_kontak ?? null);
                                @endphp
                                @if($phoneReq)
                                    <div style="font-size: 11.5px; margin-top: 2px;">
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', (str_starts_with($phoneReq, '0') ? '62'.substr($phoneReq, 1) : $phoneReq)) }}"
                                           target="_blank"
                                           style="color: #059669; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 3px;"
                                           title="Hubungi via WhatsApp">
                                            <span>📱 {{ $phoneReq }}</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #1E293B;">{{ $pjm->barang->nama_barang ?? $pjm->kode_barang }}</div>
                        <div style="font-size: 11.5px; color: #64748B;">{{ $pjm->barang->kategori->nama_kategori ?? '-' }}</div>
                    </td>
                    <td>
                        <span style="display:inline-block; background:#F8FAFC; border:1px solid #E2E8F0; padding:2px 8px; border-radius:5px; font-size:11.5px; font-weight:500; color:#475569;">
                            {{ $pjm->lokasi ?? 'Ruang Kelas' }}
                        </span>
                    </td>
                    <td style="color: #64748B; font-size: 13px;">
                        {{ Str::limit($pjm->keterangan_penggunaan, 32) }}
                    </td>
                    <td style="color: #475569; white-space: nowrap; font-size: 12.5px;">
                        <div>{{ $pjm->tanggal_pinjam ? $pjm->tanggal_pinjam->format('d M Y') : '-' }}</div>
                        @if($pjm->created_at)
                            <div style="font-size: 11px; color: #4F46E5; font-weight: 600; margin-top: 2px;">
                                ⏰ {{ $pjm->created_at->format('H:i') }} WIB
                            </div>
                        @endif
                    </td>
                    <td>
                        <div class="action-btns-wrap" style="justify-content: flex-end; padding-right: 4px;">
                            <button type="button" class="btn-approve"
                                onclick="openApproveModal('{{ $pjm->kode_pinjam }}', '{{ addslashes($pjm->siswa->nama ?? 'Siswa') }}', '{{ addslashes($pjm->barang->nama_barang ?? $pjm->kode_barang) }}')">
                                Setujui
                            </button>
                            <button type="button" class="btn-reject"
                                onclick="openRejectModal('{{ $pjm->kode_pinjam }}')">
                                Tolak
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <span class="empty-state-icon">📋</span>
                            Tidak ada pengajuan peminjaman yang menunggu verifikasi saat ini.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="verif-pagination">
        @if($pendingRequests->onFirstPage())
            <span class="page-nav-btn" style="opacity:.4;cursor:default;">Prev</span>
        @else
            <a class="page-nav-btn" href="{{ $pendingRequests->previousPageUrl() }}">Prev</a>
        @endif

        @for($p = 1; $p <= $pendingRequests->lastPage(); $p++)
            <a class="page-nav-btn {{ $p == $pendingRequests->currentPage() ? 'active' : '' }}"
               href="{{ $pendingRequests->url($p) }}">{{ $p }}</a>
        @endfor

        @if($pendingRequests->hasMorePages())
            <a class="page-nav-btn" href="{{ $pendingRequests->nextPageUrl() }}">Next</a>
        @else
            <span class="page-nav-btn" style="opacity:.4;cursor:default;">Next</span>
        @endif
    </div>
</div>
@endif

{{-- ─── TAB 2: PENDING RETURNS ─── --}}
@if($tab === 'returns')
<div class="section-title-verif">
    <span>Daftar Alat Sedang Dipinjam & Menunggu Pengembalian</span>
</div>

<div class="verif-card-wrap">
    <div class="verif-table-responsive">
        <table class="verif-table">
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Nama Alat</th>
                    <th>Tgl. Rencana Kembali</th>
                    <th>Bukti</th>
                    <th>Kondisi Fisik</th>
                    <th style="text-align: right; padding-right: 20px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activeLoans as $active)
                <tr>
                    <td>
                        <div class="verif-student-cell">
                            <div class="student-circle-avatar" style="background: #166534;">
                                {{ strtoupper(substr($active->siswa->nama ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #0F172A;">{{ $active->siswa->nama ?? 'Siswa' }}</div>
                                <div style="font-size: 11.5px; color: #64748B;">NIS: {{ $active->nis }}</div>
                                @php
                                    $phoneAct = $active->nomor_telepon ?? ($active->siswa->nomor_kontak ?? null);
                                @endphp
                                @if($phoneAct)
                                    <div style="font-size: 11.5px; margin-top: 2px;">
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', (str_starts_with($phoneAct, '0') ? '62'.substr($phoneAct, 1) : $phoneAct)) }}"
                                           target="_blank"
                                           style="color: #059669; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 3px;"
                                           title="Hubungi via WhatsApp">
                                            <span>📱 {{ $phoneAct }}</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="font-weight: 600; color: #1E293B;">
                        <div>{{ $active->barang->nama_barang ?? $active->kode_barang }}</div>
                        @if($active->pengembalian && $active->pengembalian->status === 'menunggu')
                            <div style="margin-top: 4px;">
                                <span style="background: #FEF3C7; color: #92400E; border: 1px solid #FCD34D; font-size: 11px; padding: 2px 8px; border-radius: 9999px; font-weight: 700; display: inline-flex; align-items: center; gap: 4px;">
                                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #D97706;"></span>
                                    Diajukan Siswa (Butuh Verifikasi)
                                </span>
                            </div>
                        @else
                            <div style="margin-top: 4px;">
                                <span style="background: #F1F5F9; color: #64748B; font-size: 11px; padding: 2px 8px; border-radius: 9999px; font-weight: 600;">
                                    Belum Lapor Kembali
                                </span>
                            </div>
                        @endif
                    </td>
                    <td style="color: #475569; white-space: nowrap; font-size: 12.5px;">
                        <div>{{ $active->tanggal_kembali ? $active->tanggal_kembali->format('d M Y') : '-' }}</div>
                        @if($active->pengembalian && $active->pengembalian->tanggal_kembali)
                            <div style="font-size: 11px; color: #059669; font-weight: 600; margin-top: 2px;">
                                Lapor: {{ $active->pengembalian->tanggal_kembali->format('d M Y') }}
                                pukul {{ $active->pengembalian->created_at?->format('H:i') ?? '-' }} WIB
                            </div>
                        @endif
                    </td>
                    <td>
                        @php
                            $bukti = $active->pengembalian->bukti_foto_video ?? null;
                            $isBuktiFile = $bukti && (str_starts_with($bukti, 'pengembalian/') || str_contains($bukti, '.'));
                        @endphp
                        @if($isBuktiFile)
                            <div class="evidence-icons">
                                <button type="button" class="evidence-icon-btn" title="Lihat Foto Bukti dari Siswa"
                                        style="border-color: #3B5998; color: #3B5998; background: #EEF2FF;"
                                        onclick="previewEvidenceFile('{{ asset('storage/' . $bukti) }}', '{{ addslashes($active->barang->nama_barang ?? '') }}', '{{ addslashes($active->siswa->nama ?? 'Siswa') }}')">
                                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                                </button>
                            </div>
                        @elseif($bukti)
                            <span style="font-size: 11px; color: #475569; max-width: 100px; display: inline-block; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $bukti }}">
                                📝 {{ $bukti }}
                            </span>
                        @else
                            <span style="font-size: 11.5px; color: #94A3B8;">-</span>
                        @endif
                    </td>
                    <td>
                        @php
                            $repCondition = $active->pengembalian->kondisi_barang ?? 'Baik';
                        @endphp
                        <select class="condition-select" id="cond_{{ $active->kode_pinjam }}">
                            <option value="Baik" {{ $repCondition === 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Kurang Baik" {{ $repCondition === 'Kurang Baik' ? 'selected' : '' }}>Kurang Baik</option>
                            <option value="Rusak Berat" {{ $repCondition === 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                        @if($active->pengembalian)
                            <div style="font-size: 10.5px; color: #64748B; margin-top: 3px;">
                                Siswa: <strong>{{ $active->pengembalian->kondisi_barang }}</strong>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="display: flex; justify-content: flex-end; padding-right: 4px;">
                            <button type="button" class="btn-confirm"
                                @if($active->pengembalian && $active->pengembalian->status === 'menunggu')
                                    style="background: linear-gradient(135deg, #4F46E5 0%, #3730A3 100%); box-shadow: 0 2px 6px rgba(79, 70, 229, 0.25);"
                                @endif
                                onclick="submitReturn(
                                    '{{ $active->kode_pinjam }}',
                                    '{{ addslashes($active->barang->nama_barang ?? '') }}',
                                    '{{ addslashes($active->siswa->nama ?? 'Siswa') }}',
                                    '{{ addslashes($active->pengembalian->kondisi_barang ?? '') }}',
                                    '{{ $isBuktiFile ? asset('storage/' . $bukti) : '' }}'
                                )">
                                {{ $active->pengembalian && $active->pengembalian->status === 'menunggu' ? 'Verifikasi & Terima' : 'Konfirmasi Return' }}
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <span class="empty-state-icon">📦</span>
                            Tidak ada barang yang sedang menunggu pengembalian saat ini.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="verif-pagination">
        @if($activeLoans->onFirstPage())
            <span class="page-nav-btn" style="opacity:.4;cursor:default;">Prev</span>
        @else
            <a class="page-nav-btn" href="{{ $activeLoans->previousPageUrl() }}">Prev</a>
        @endif
        @for($p = 1; $p <= $activeLoans->lastPage(); $p++)
            <a class="page-nav-btn {{ $p == $activeLoans->currentPage() ? 'active' : '' }}"
               href="{{ $activeLoans->url($p) }}">{{ $p }}</a>
        @endfor
        @if($activeLoans->hasMorePages())
            <a class="page-nav-btn" href="{{ $activeLoans->nextPageUrl() }}">Next</a>
        @else
            <span class="page-nav-btn" style="opacity:.4;cursor:default;">Next</span>
        @endif
    </div>
</div>
@endif

{{-- ─── TAB 3: RIWAYAT SELESAI ─── --}}
@if($tab === 'history')
<div class="section-title-verif">
    <span>Histori Peminjaman & Pengembalian Selesai</span>
</div>

<div class="verif-card-wrap">
    <div class="verif-table-responsive">
        <table class="verif-table">
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Nama Alat</th>
                    <th>Tgl. Peminjaman</th>
                    <th>Tgl. Pengembalian</th>
                    <th>Status / Kondisi</th>
                    <th>Catatan & Bukti</th>
                </tr>
            </thead>
            <tbody>
                @forelse($historyLoans as $hist)
                <tr>
                    <td>
                        <div class="verif-student-cell">
                            <div class="student-circle-avatar" style="background: #334155;">
                                {{ strtoupper(substr($hist->siswa->nama ?? 'S', 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-weight: 600; color: #0F172A;">{{ $hist->siswa->nama ?? 'Siswa' }}</div>
                                <div style="font-size: 11.5px; color: #64748B;">NIS: {{ $hist->nis }}</div>
                                @php
                                    $phoneHist = $hist->nomor_telepon ?? ($hist->siswa->nomor_kontak ?? null);
                                @endphp
                                @if($phoneHist)
                                    <div style="font-size: 11.5px; margin-top: 2px;">
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', (str_starts_with($phoneHist, '0') ? '62'.substr($phoneHist, 1) : $phoneHist)) }}"
                                           target="_blank"
                                           style="color: #059669; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 3px;"
                                           title="Hubungi via WhatsApp">
                                            <span>📱 {{ $phoneHist }}</span>
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="color: #334155; font-weight: 500;">
                        {{ $hist->barang->nama_barang ?? $hist->kode_barang }}
                    </td>
                    <td style="color: #475569; white-space: nowrap; font-size: 12.5px;">
                        <span style="font-weight: 600; color: #0F172A;">
                            {{ $hist->tanggal_pinjam ? \Carbon\Carbon::parse($hist->tanggal_pinjam)->format('d M Y') : '-' }}
                        </span>
                        @if($hist->created_at)
                            <div style="font-size: 11px; color: #4F46E5; font-weight: 600; margin-top: 2px;">
                                ⏰ {{ $hist->created_at->format('H:i') }} WIB
                            </div>
                        @endif
                    </td>
                    <td style="color: #475569; white-space: nowrap; font-size: 12.5px;">
                        @if($hist->pengembalian && $hist->pengembalian->tanggal_kembali)
                            <span style="font-weight: 600; color: #059669;">
                                {{ \Carbon\Carbon::parse($hist->pengembalian->tanggal_kembali)->format('d M Y') }}
                            </span>
                            <div style="font-size: 11px; color: #059669; font-weight: 600; margin-top: 2px;">
                                ⏰ {{ $hist->pengembalian->created_at?->format('H:i') ?? '-' }} WIB
                            </div>
                        @elseif($hist->status_pengajuan === 'ditolak')
                            <span style="color: #94A3B8;">-</span>
                        @elseif($hist->tanggal_kembali)
                            <span style="font-weight: 500; color: #64748B;">
                                {{ \Carbon\Carbon::parse($hist->tanggal_kembali)->format('d M Y') }}
                            </span>
                        @else
                            <span style="color: #94A3B8;">-</span>
                        @endif
                    </td>
                    <td>
                        @if($hist->pengembalian)
                            @php
                                $cond = $hist->pengembalian->kondisi_barang;
                                $style = match($cond) {
                                    'Baik' => 'background:#F0FDF4; color:#166534; border:1px solid #DCFCE7;',
                                    'Kurang Baik' => 'background:#FFFBEB; color:#B45309; border:1px solid #FEF3C7;',
                                    'Rusak Berat' => 'background:#FEF2F2; color:#991B1B; border:1px solid #FEE2E2;',
                                    default => 'background:#F8FAFC; color:#475569; border:1px solid #E2E8F0;'
                                };
                            @endphp
                            <span style="display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:999px; font-size:11.5px; font-weight:600; {{ $style }}">
                                Dikembalikan ({{ $cond }})
                            </span>
                        @else
                            <span style="display:inline-flex; align-items:center; gap:5px; padding:3px 10px; border-radius:999px; font-size:11.5px; font-weight:600; background:#FEF2F2; color:#991B1B; border:1px solid #FEE2E2;">
                                Ditolak
                            </span>
                        @endif
                    </td>
                    <td style="font-size: 13px; color: #64748B;">
                        @if($hist->pengembalian && $hist->pengembalian->bukti_foto_video)
                            @if(Str::startsWith($hist->pengembalian->bukti_foto_video, 'pengembalian/'))
                                <button type="button" class="btn-action-text edit" style="display:inline-flex; align-items:center; gap:5px; color:#0F172A; font-weight:600; background:#F8FAFC; border:1px solid #E2E8F0; padding:4px 10px; border-radius:6px; cursor:pointer;"
                                        onclick="previewEvidenceFile('{{ asset('storage/' . $hist->pengembalian->bukti_foto_video) }}', '{{ addslashes($hist->barang->nama_barang ?? '') }}', '{{ addslashes($hist->siswa->nama ?? '') }}')">
                                    Lihat Bukti Foto
                                </button>
                            @else
                                <span>{{ $hist->pengembalian->bukti_foto_video }}</span>
                            @endif
                        @elseif($hist->keterangan_penggunaan)
                            {{ Str::limit($hist->keterangan_penggunaan, 40) }}
                        @else
                            -
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <span class="empty-state-icon">📋</span>
                            Belum ada riwayat verifikasi yang selesai.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="verif-pagination">
        @if($historyLoans->onFirstPage())
            <span class="page-nav-btn" style="opacity:.4;cursor:default;">Prev</span>
        @else
            <a class="page-nav-btn" href="{{ $historyLoans->previousPageUrl() }}">Prev</a>
        @endif
        @for($p = 1; $p <= $historyLoans->lastPage(); $p++)
            <a class="page-nav-btn {{ $p == $historyLoans->currentPage() ? 'active' : '' }}"
               href="{{ $historyLoans->url($p) }}">{{ $p }}</a>
        @endfor
        @if($historyLoans->hasMorePages())
            <a class="page-nav-btn" href="{{ $historyLoans->nextPageUrl() }}">Next</a>
        @else
            <span class="page-nav-btn" style="opacity:.4;cursor:default;">Next</span>
        @endif
    </div>
</div>
@endif

{{-- MODAL 1: REJECT REQUEST --}}
<div id="rejectModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <div class="modal-title">Tolak Pengajuan Peminjaman</div>
            <button class="modal-close-btn" onclick="closeModal('rejectModal')">&times;</button>
        </div>
        <form id="rejectForm" method="POST">
            @csrf
            <div style="margin-bottom: 14px;">
                <label style="display:block; font-size:12.5px; font-weight:600; color:#334155; margin-bottom:5px;">Alasan Penolakan (Opsional)</label>
                <textarea name="alasan" class="form-textarea" rows="3"
                          placeholder="Tuliskan alasan penolakan jika diperlukan..."
                          style="width: 100%; box-sizing:border-box; border:1px solid #CBD5E1; border-radius:8px; padding:8px 12px; font-family:inherit; font-size:13px; outline:none;"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('rejectModal')">Batal</button>
                <button type="submit" class="btn-submit" style="background: #DC2626;">Konfirmasi Tolak</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL 2: APPROVE REQUEST --}}
<div id="approveModal" class="modal-overlay">
    <div class="modal-card approve-modal-card" role="dialog" aria-modal="true" aria-labelledby="approveModalTitle">
        <div class="modal-header">
            <div class="approve-modal-heading">
                <span class="approve-modal-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M8 4h-2a2 2 0 0 0-2 2v14h16V6a2 2 0 0 0-2-2h-2"/><rect x="8" y="2" width="8" height="4" rx="1"/><path d="m9 14 2 2 4-4"/></svg>
                </span>
                <div>
                    <span class="approve-modal-kicker">TINDAKAN ADMIN</span>
                    <div class="modal-title" id="approveModalTitle">Setujui peminjaman?</div>
                </div>
            </div>
            <button type="button" class="modal-close-btn" onclick="closeModal('approveModal')" aria-label="Tutup dialog">&times;</button>
        </div>
        <p class="approve-modal-copy">Pastikan data peminjam dan fasilitas sudah benar sebelum melanjutkan.</p>
        <div class="approve-modal-summary">
            <div class="approve-modal-detail">
                <span class="approve-modal-detail-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="8" r="4"/><path d="M5 21v-2a7 7 0 0 1 14 0v2"/></svg>
                </span>
                <span class="approve-modal-detail-copy"><span>Nama peminjam</span><strong id="approveStudentName"></strong></span>
            </div>
            <div class="approve-modal-detail">
                <span class="approve-modal-detail-icon" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7.5 12 3l8 4.5v9L12 21l-8-4.5z"/><path d="m4.5 7.8 7.5 4.3 7.5-4.3M12 12v9"/></svg>
                </span>
                <span class="approve-modal-detail-copy"><span>Fasilitas dipinjam</span><strong id="approveItemName"></strong></span>
            </div>
        </div>
        <div class="approve-modal-impact">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M12 11v5M12 8h.01"/></svg>
            <p>Setelah disetujui, status pengajuan berubah dan stok tersedia berkurang satu.</p>
        </div>
        <form id="approveForm" method="POST">
            @csrf
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('approveModal')">Batal</button>
                <button type="submit" class="btn-submit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="m5 12 4 4L19 6"/></svg>
                    Setujui Peminjaman
                </button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL 3: KONFIRMASI RETURN --}}
<div id="returnConfirmModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <div class="modal-title">Konfirmasi Pengembalian</div>
            <button class="modal-close-btn" onclick="closeModal('returnConfirmModal')">&times;</button>
        </div>

        <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 12px 14px; font-size: 13px; color: #334155; line-height: 1.8; margin-bottom: 14px;">
            <div>Peminjam: <strong id="retStudentName" style="color: #0F172A;"></strong></div>
            <div>Barang: <strong id="retItemName" style="color: #0F172A;"></strong></div>
            <div>Kondisi Diverifikasi: <strong id="retConditionLabel" style="color: #0F172A;"></strong></div>
            <div id="retStudentReportedBox" style="display:none; color: #0284C7; font-size: 12px; margin-top: 4px; padding-top: 4px; border-top: 1px dashed #E2E8F0;">
                Laporan Siswa: <strong id="retStudentReported"></strong>
            </div>
        </div>

        <div id="retBuktiPreviewContainer" style="display:none; margin-bottom: 14px; text-align: center; background: #F8FAFC; border: 1px dashed #CBD5E1; border-radius: 8px; padding: 10px;">
            <div style="font-size: 11.5px; font-weight: 700; color: #475569; margin-bottom: 6px;">Foto Bukti dari Siswa:</div>
            <img id="retBuktiImg" src="" style="max-height: 140px; border-radius: 6px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);" alt="Bukti Foto">
        </div>

        {{-- Warning Box jika Rusak --}}
        <div id="retConditionWarning" style="display:none; background:#FFFBEB; border:1px solid #FEF3C7; border-radius:8px; padding:12px 14px; margin: 12px 0; font-size:12.5px; color:#B45309; text-align:left;">
            <div style="font-weight:600; margin-bottom:4px;">
                Peringatan Kerusakan
            </div>
            <div>Kondisi barang dilaporkan rusak/kurang baik. Laporan kerusakan otomatis dicatat dan stok fisik barang akan disesuaikan di sistem.</div>
            <div style="margin-top:8px;">
                <label style="font-size:11.5px; font-weight:600; color:#92400E; display:block; margin-bottom:4px;">Catatan Kerusakan (Opsional):</label>
                <input type="text" id="retCatatanInput" placeholder="Misal: Tombol macet / kabel lecet" style="width:100%; box-sizing:border-box; padding:6px 10px; font-size:12.5px; border:1px solid #FDE68A; border-radius:6px; outline:none; background:#FFFFFF;">
            </div>
        </div>

        <form id="returnForm" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="kondisi_barang" id="retConditionInput">
            <input type="hidden" name="tanggal_kembali" value="{{ date('Y-m-d') }}">
            <input type="hidden" name="catatan" id="retCatatanHidden">
            <div style="margin: 12px 0 16px;">
                <label style="display: block; font-size: 12.5px; font-weight: 600; color: #475569; margin-bottom: 6px;">Foto Bukti Fisik Saat Kembali (Opsional)</label>
                <input type="file" name="bukti_foto" accept="image/*" style="font-size: 12.5px; color: #64748B;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('returnConfirmModal')">Batal</button>
                <button type="submit" class="btn-submit" onclick="document.getElementById('retCatatanHidden').value = document.getElementById('retCatatanInput').value">Konfirmasi Pengembalian</button>
            </div>
        </form>
    </div>
</div>

{{-- MODAL 4: EVIDENCE PREVIEW MODAL --}}
<div id="evidencePreviewModal" class="modal-overlay">
    <div class="modal-card" style="max-width: 480px; text-align: center;">
        <div class="modal-header">
            <div class="modal-title" id="evidenceTitle">Bukti Pengembalian</div>
            <button class="modal-close-btn" onclick="closeModal('evidencePreviewModal')">&times;</button>
        </div>
        <p style="font-size:12.5px; color:#64748B; margin-bottom:12px;" id="evidenceSubtitle">Pemeriksaan fisik alat</p>
        <div id="evidenceContainer" style="background:#F8FAFC; border:1px solid #E2E8F0; border-radius:10px; padding:16px; margin: 12px 0; min-height:140px; display:flex; align-items:center; justify-content:center;">
            <img id="evidenceImg" src="" style="max-width:100%; max-height:280px; border-radius:8px; display:none;" alt="Bukti Foto">
            <div id="evidenceEmpty" style="color:#64748B; font-size:12.5px; line-height: 1.6;">
                <strong>Pemeriksaan Fisik Langsung</strong><br>
                Bukti fisik alat dapat dicek saat serah terima barang atau diunggah langsung melalui form konfirmasi pengembalian.
            </div>
        </div>
        <div class="modal-footer" style="justify-content: center; margin-top: 10px;">
            <button type="button" class="btn-cancel" onclick="closeModal('evidencePreviewModal')">Tutup</button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    /* ── APPROVE ── */
    function openApproveModal(kodePinjam, studentName, itemName) {
        document.getElementById('approveStudentName').innerText = studentName;
        document.getElementById('approveItemName').innerText    = itemName;
        document.getElementById('approveForm').action =
            "{{ url('/admin/verifikasi/approve') }}/" + kodePinjam;
        openModal('approveModal');
    }

    /* ── REJECT ── */
    function openRejectModal(kodePinjam) {
        document.getElementById('rejectForm').action =
            "{{ url('/admin/verifikasi/reject') }}/" + kodePinjam;
        openModal('rejectModal');
    }

    /* ── INLINE RETURN: read select, toggle warning box, open confirm modal ── */
    function submitReturn(kodePinjam, itemName, studentName, studentCondition, buktiUrl) {
        var sel       = document.getElementById('cond_' + kodePinjam);
        var condition = sel ? sel.value : (studentCondition || 'Baik');

        document.getElementById('retStudentName').innerText    = studentName;
        document.getElementById('retItemName').innerText       = itemName;
        document.getElementById('retConditionLabel').innerText = condition;
        document.getElementById('retConditionInput').value     = condition;
        document.getElementById('retCatatanInput').value       = '';
        document.getElementById('retCatatanHidden').value      = '';

        var reportedBox = document.getElementById('retStudentReportedBox');
        if (reportedBox) {
            if (studentCondition) {
                document.getElementById('retStudentReported').innerText = studentCondition;
                reportedBox.style.display = 'block';
            } else {
                reportedBox.style.display = 'none';
            }
        }

        var buktiBox = document.getElementById('retBuktiPreviewContainer');
        var buktiImg = document.getElementById('retBuktiImg');
        if (buktiBox && buktiImg) {
            if (buktiUrl) {
                buktiImg.src = buktiUrl;
                buktiBox.style.display = 'block';
            } else {
                buktiBox.style.display = 'none';
                buktiImg.src = '';
            }
        }

        var warningBox = document.getElementById('retConditionWarning');
        if (warningBox) {
            warningBox.style.display = (condition !== 'Baik' ? 'block' : 'none');
        }

        document.getElementById('returnForm').action =
            "{{ url('/admin/verifikasi/pengembalian') }}/" + kodePinjam;

        openModal('returnConfirmModal');
    }

    /* ── Evidence preview modal ── */
    function openEvidenceModal(type, itemName, studentName) {
        document.getElementById('evidenceTitle').innerText = 'Bukti Pengembalian - ' + itemName;
        document.getElementById('evidenceSubtitle').innerText = 'Peminjam: ' + studentName + ' (' + (type === 'video' ? 'Video' : 'Foto') + ')';
        document.getElementById('evidenceImg').style.display = 'none';
        document.getElementById('evidenceEmpty').style.display = 'block';
        openModal('evidencePreviewModal');
    }

    function previewEvidenceFile(fileUrl, itemName, studentName) {
        document.getElementById('evidenceTitle').innerText = 'Bukti Pengembalian: ' + itemName;
        document.getElementById('evidenceSubtitle').innerText = 'Peminjam: ' + studentName;
        var img = document.getElementById('evidenceImg');
        img.src = fileUrl;
        img.style.display = 'block';
        document.getElementById('evidenceEmpty').style.display = 'none';
        openModal('evidencePreviewModal');
    }
</script>
@endsection
