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
        background: #2D4E9E;
        color: #FFFFFF;
        font-weight: 600;
        box-shadow: 0 1px 3px rgba(45, 78, 158, 0.20);
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
        background: #2D4E9E;
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
        border-color: #2D4E9E;
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
        background: #2D4E9E;
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
    .btn-approve:hover {
        background: #243f85;
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
</style>
@endsection

@section('content')

{{-- ── Tab Switcher ── --}}
<div class="verify-tabs-bar">
    <a href="{{ route('admin.verifikasi.index', ['tab' => 'requests']) }}"
       class="verify-tab-item {{ $tab === 'requests' ? 'active' : '' }}">
        <span>Pending Requests</span>
        @if($pendingRequests->total() > 0)
            <span class="tab-badge-pill">{{ $pendingRequests->total() }}</span>
        @endif
    </a>
    <a href="{{ route('admin.verifikasi.index', ['tab' => 'returns']) }}"
       class="verify-tab-item {{ $tab === 'returns' ? 'active' : '' }}">
        <span>Pending Returns</span>
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
                        {{ $pjm->tanggal_pinjam ? $pjm->tanggal_pinjam->format('d M Y') : '-' }}
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
                            </div>
                        </div>
                    </td>
                    <td style="font-weight: 600; color: #1E293B;">
                        {{ $active->barang->nama_barang ?? $active->kode_barang }}
                    </td>
                    <td style="color: #475569; white-space: nowrap; font-size: 12.5px;">
                        {{ $active->tanggal_kembali ? $active->tanggal_kembali->format('d M Y') : '-' }}
                    </td>
                    <td>
                        <div class="evidence-icons">
                            <button type="button" class="evidence-icon-btn" title="Cek Bukti Foto"
                                    onclick="openEvidenceModal('foto', '{{ addslashes($active->barang->nama_barang ?? '') }}', '{{ addslashes($active->siswa->nama ?? 'Siswa') }}')">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                            </button>
                            <button type="button" class="evidence-icon-btn" title="Cek Bukti Video"
                                    onclick="openEvidenceModal('video', '{{ addslashes($active->barang->nama_barang ?? '') }}', '{{ addslashes($active->siswa->nama ?? 'Siswa') }}')">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
                            </button>
                        </div>
                    </td>
                    <td>
                        <select class="condition-select" id="cond_{{ $active->kode_pinjam }}">
                            <option value="Baik">Baik</option>
                            <option value="Kurang Baik">Kurang Baik</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
                    </td>
                    <td>
                        <div style="display: flex; justify-content: flex-end; padding-right: 4px;">
                            <button type="button" class="btn-confirm"
                                onclick="submitReturn(
                                    '{{ $active->kode_pinjam }}',
                                    '{{ addslashes($active->barang->nama_barang ?? '') }}',
                                    '{{ addslashes($active->siswa->nama ?? 'Siswa') }}'
                                )">
                                Konfirmasi Return
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
                    <th>Tgl. Selesai</th>
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
                            </div>
                        </div>
                    </td>
                    <td style="color: #334155; font-weight: 500;">
                        {{ $hist->barang->nama_barang ?? $hist->kode_barang }}
                    </td>
                    <td style="color: #475569; white-space: nowrap; font-size: 12.5px;">
                        {{ $hist->pengembalian ? \Carbon\Carbon::parse($hist->pengembalian->tanggal_kembali)->format('d M Y') : $hist->updated_at->format('d M Y') }}
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
                    <td colspan="5">
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
    <div class="modal-card">
        <div class="modal-header">
            <div class="modal-title">Konfirmasi Persetujuan</div>
            <button class="modal-close-btn" onclick="closeModal('approveModal')">&times;</button>
        </div>
        <div style="margin-bottom: 16px;">
            <p style="font-size: 13.5px; color: #475569; margin-bottom: 12px;">
                Setujui pengajuan peminjaman fasilitas ini?
            </p>
            <div style="background: #F8FAFC; border: 1px solid #E2E8F0; border-radius: 8px; padding: 12px 14px; font-size: 13px; color: #334155; line-height: 1.8;">
                <div>Peminjam: <strong id="approveStudentName" style="color: #0F172A;"></strong></div>
                <div>Alat: <strong id="approveItemName" style="color: #0F172A;"></strong></div>
            </div>
        </div>
        <form id="approveForm" method="POST">
            @csrf
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('approveModal')">Batal</button>
                <button type="submit" class="btn-submit">Ya, Setujui</button>
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
            <div>Kondisi: <strong id="retConditionLabel" style="color: #0F172A;"></strong></div>
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
    function submitReturn(kodePinjam, itemName, studentName) {
        var sel       = document.getElementById('cond_' + kodePinjam);
        var condition = sel ? sel.value : 'Baik';

        document.getElementById('retStudentName').innerText    = studentName;
        document.getElementById('retItemName').innerText       = itemName;
        document.getElementById('retConditionLabel').innerText = condition;
        document.getElementById('retConditionInput').value     = condition;
        document.getElementById('retCatatanInput').value       = '';
        document.getElementById('retCatatanHidden').value      = '';

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
