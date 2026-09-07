@extends('layouts.admin')

@section('title', 'Verifikasi Peminjaman & Pengembalian - SINFAS')
@section('page_title', 'Verifikasi Peminjaman & Pengembalian')

@section('styles')
<style>
    /* ── Tab Switcher ── */
    .verify-tabs-bar {
        display: flex;
        gap: 0;
        margin-bottom: 22px;
        background: #E2E8F0;
        border-radius: 8px;
        padding: 4px;
        width: fit-content;
    }
    .verify-tab-item {
        padding: 8px 22px;
        border-radius: 6px;
        font-size: 13.5px;
        font-weight: 500;
        text-decoration: none;
        color: #64748B;
        background: transparent;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        white-space: nowrap;
    }
    .verify-tab-item:hover { color: #374151; }
    .verify-tab-item.active {
        background: #FFFFFF;
        color: #111827;
        font-weight: 600;
        box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    }
    .tab-badge {
        background: #1D4ED8;
        color: #fff;
        padding: 1px 7px;
        border-radius: 10px;
        font-size: 11px;
        font-weight: 600;
    }

    /* ── Section Title ── */
    .section-title-verif {
        font-size: 15px;
        font-weight: 700;
        color: #0F172A;
        margin-bottom: 12px;
    }

    /* ── Table Container ── */
    .verif-card-wrap {
        background: #FFFFFF;
        border-radius: 10px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.07);
        border: 1px solid #E5E7EB;
        overflow: hidden;
    }
    .verif-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }
    .verif-table thead tr {
        background: #FAFAFA;
        border-bottom: 1.5px solid #E5E7EB;
    }
    .verif-table th {
        padding: 12px 16px;
        font-size: 12px;
        font-weight: 600;
        color: #6B7280;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }
    .verif-table td {
        padding: 13px 16px;
        border-bottom: 1px solid #F1F5F9;
        font-size: 13.5px;
        color: #1E293B;
        vertical-align: middle;
    }
    .verif-table tbody tr:last-child td { border-bottom: none; }
    .verif-table tbody tr:hover td { background: #F8FAFF; }

    /* ── Inline Condition Select ── */
    .condition-select {
        border: 1px solid #D1D5DB;
        border-radius: 6px;
        padding: 6px 10px;
        font-size: 13px;
        color: #374151;
        background: #FFFFFF;
        cursor: pointer;
        outline: none;
        min-width: 120px;
        font-family: inherit;
        transition: border-color .15s;
    }
    .condition-select:focus { border-color: #2563EB; }

    /* ── Evidence Icons ── */
    .evidence-icons { display: flex; gap: 6px; align-items: center; }
    .evidence-icon-btn {
        width: 34px;
        height: 28px;
        border: 1px solid #D1D5DB;
        border-radius: 5px;
        background: #F9FAFB;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #6B7280;
        transition: all .15s;
    }
    .evidence-icon-btn:hover {
        background: #EFF6FF;
        border-color: #93C5FD;
        color: #2563EB;
    }

    /* ── Action Buttons ── */
    .action-btns-wrap { display: flex; align-items: center; gap: 7px; }
    .btn-approve {
        background: #16A34A; color: #FFFFFF; border: none;
        border-radius: 6px; padding: 6px 16px; font-size: 13px;
        font-weight: 500; cursor: pointer; transition: background 0.15s;
        font-family: inherit; white-space: nowrap;
    }
    .btn-approve:hover { background: #15803D; }
    .btn-reject {
        background: #DC2626; color: #FFFFFF; border: none;
        border-radius: 6px; padding: 6px 16px; font-size: 13px;
        font-weight: 500; cursor: pointer; transition: background 0.15s;
        font-family: inherit; white-space: nowrap;
    }
    .btn-reject:hover { background: #B91C1C; }
    .btn-confirm {
        background: #16A34A; color: #FFFFFF; border: none;
        border-radius: 6px; padding: 6px 18px; font-size: 13px;
        font-weight: 500; cursor: pointer; transition: background 0.15s;
        font-family: inherit; white-space: nowrap;
    }
    .btn-confirm:hover { background: #15803D; }

    /* ── Pagination ── */
    .verif-pagination {
        display: flex; align-items: center; justify-content: flex-end;
        gap: 5px; padding: 13px 16px; border-top: 1px solid #F1F5F9;
    }
    .page-nav-btn {
        min-width: 30px; height: 30px; padding: 0 10px;
        border: 1px solid #D1D5DB; background: #FFFFFF; color: #374151;
        border-radius: 5px; font-size: 12.5px; cursor: pointer;
        display: inline-flex; align-items: center; justify-content: center;
        transition: all .15s; text-decoration: none;
    }
    .page-nav-btn:hover { background: #F3F4F6; }
    .page-nav-btn.active {
        background: #1D4ED8; border-color: #1D4ED8;
        color: #FFFFFF; font-weight: 600;
    }

    /* ── Modal Overlay ── */
    .modal-overlay {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.45); z-index: 9999;
        align-items: center; justify-content: center;
    }
    .modal-overlay.open { display: flex; }

    /* ── Modal Card ── */
    .modal-card {
        background: #FFFFFF; border-radius: 12px; padding: 26px 28px;
        width: 92%; max-width: 440px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.2);
        border: 1px solid #E5E7EB;
        animation: modalIn .2s ease;
    }
    @keyframes modalIn {
        from { transform: scale(.94); opacity: 0; }
        to   { transform: scale(1);   opacity: 1; }
    }
    .modal-title {
        font-size: 17px; font-weight: 700;
        color: #0F172A; margin-bottom: 16px;
    }
    .modal-label {
        display: block; font-size: 13px;
        color: #64748B; margin-bottom: 7px;
    }
    .modal-textarea {
        width: 100%; box-sizing: border-box;
        border: 1px solid #D1D5DB; border-radius: 8px;
        padding: 10px 13px; font-size: 13.5px; color: #1F2937;
        outline: none; font-family: inherit; resize: vertical;
        min-height: 80px; transition: border-color .15s;
    }
    .modal-textarea:focus { border-color: #2563EB; }
    .modal-info-text { font-size: 13.5px; color: #4B5563; margin-bottom: 12px; }
    .modal-detail-row { font-size: 13px; color: #6B7280; line-height: 1.8; margin-bottom: 16px; }
    .modal-detail-row strong { color: #1F2937; font-weight: 500; }
    .modal-footer {
        display: flex; align-items: center; justify-content: flex-end;
        gap: 10px; margin-top: 20px;
    }
    .btn-modal-cancel {
        background: #FFFFFF; border: 1px solid #D1D5DB; color: #4B5563;
        border-radius: 8px; padding: 8px 18px; font-size: 13.5px;
        font-weight: 500; cursor: pointer; transition: background .15s; font-family: inherit;
    }
    .btn-modal-cancel:hover { background: #F9FAFB; }
    .btn-modal-reject {
        background: #DC2626; color: #FFFFFF; border: none;
        border-radius: 8px; padding: 8px 20px; font-size: 13.5px;
        font-weight: 600; cursor: pointer; transition: background .15s; font-family: inherit;
    }
    .btn-modal-reject:hover { background: #B91C1C; }
    .btn-modal-approve {
        background: #16A34A; color: #FFFFFF; border: none;
        border-radius: 8px; padding: 8px 22px; font-size: 13.5px;
        font-weight: 600; cursor: pointer; transition: background .15s; font-family: inherit;
    }
    .btn-modal-approve:hover { background: #15803D; }

    /* ── Alert Flash ── */
    .alert-flash {
        padding: 12px 18px; border-radius: 8px;
        margin-bottom: 16px; font-size: 13.5px; font-weight: 500;
    }
    .alert-success { background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0; }
    .alert-error   { background: #FEE2E2; color: #DC2626; border: 1px solid #FECACA; }

    /* ── Empty State ── */
    .empty-state { text-align: center; padding: 40px 20px; color: #94A3B8; font-size: 13.5px; }
    .empty-state-icon { font-size: 30px; margin-bottom: 10px; display: block; }
</style>
@endsection

@section('content')

{{-- Flash Messages --}}
@if(session('success'))
    <div class="alert-flash alert-success">&#10003; {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="alert-flash alert-error">&#10007; {{ session('error') }}</div>
@endif

{{-- ── Tab Switcher ── --}}
<div class="verify-tabs-bar">
    <a href="{{ route('admin.verifikasi.index', ['tab' => 'requests']) }}"
       class="verify-tab-item {{ $tab === 'requests' ? 'active' : '' }}">
        Pending Requests
        @if($pendingRequests->total() > 0)
            <span class="tab-badge">{{ $pendingRequests->total() }}</span>
        @endif
    </a>
    <a href="{{ route('admin.verifikasi.index', ['tab' => 'returns']) }}"
       class="verify-tab-item {{ $tab === 'returns' ? 'active' : '' }}">
        Pending Returns
        @if($activeLoans->total() > 0)
            <span class="tab-badge">{{ $activeLoans->total() }}</span>
        @endif
    </a>
</div>

{{-- ─── TAB 1: PENDING REQUESTS ─── --}}
    @if($tab === 'requests')
    <div class="section-title-verif">Pending Requests</div>

    <div class="verif-card-wrap">
        <table class="verif-table">
            <thead>
                <tr>
                    <th style="width: 20%;">Borrower</th>
                    <th style="width: 22%;">Item</th>
                    <th style="width: 14%;">Location</th>
                    <th style="width: 24%;">Reason</th>
                    <th style="width: 10%;">Date</th>
                    <th style="width: 10%;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingRequests as $pjm)
                <tr>
                    <td style="font-weight: 500; color: #0F172A;">
                        {{ $pjm->siswa->nama ?? 'Siswa' }}
                    </td>
                    <td style="color: #334155;">
                        {{ $pjm->barang->nama_barang ?? $pjm->kode_barang }}
                    </td>
                    <td style="color: #475569;">
                        {{ $pjm->lokasi ?? 'Ruang Kelas' }}
                    </td>
                    <td style="color: #64748B;">
                        {{ Str::limit($pjm->keterangan_penggunaan, 28) }}
                    </td>
                    <td style="color: #475569;">
                        {{ $pjm->tanggal_pinjam ? $pjm->tanggal_pinjam->format('Y-m-d') : '-' }}
                    </td>
                    <td>
                        <div class="action-btns-wrap">
                            <button type="button" class="btn-approve"
                                onclick="openApproveModal('{{ $pjm->kode_pinjam }}', '{{ addslashes($pjm->siswa->nama ?? 'Siswa') }}', '{{ addslashes($pjm->barang->nama_barang ?? $pjm->kode_barang) }}')">Approve</button>
                            <button type="button" class="btn-reject"
                                onclick="openRejectModal('{{ $pjm->kode_pinjam }}')">Reject</button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6">
                        <div class="empty-state">
                            <span class="empty-state-icon">📋</span>
                            Tidak ada pengajuan peminjaman yang menunggu verifikasi.
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pagination --}}
        <div class="verif-pagination">
            @if($pendingRequests->onFirstPage())
                <span class="page-nav-btn" style="opacity:.45;cursor:default;">Prev</span>
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
                <span class="page-nav-btn" style="opacity:.45;cursor:default;">Next</span>
            @endif
        </div>
    </div>
    @endif

{{-- ─── TAB 2: PENDING RETURNS ─── --}}
@if($tab === 'returns')
<div class="section-title-verif">Pending Returns</div>

<div class="verif-card-wrap">
    <table class="verif-table">
        <thead>
            <tr>
                <th>Borrower</th>
                <th>Item</th>
                <th>Return Date</th>
                <th>Evidence</th>
                <th>Condition</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($activeLoans as $active)
            <tr>
                <td style="font-weight:500; color:#0F172A;">
                    {{ $active->siswa->nama ?? 'Siswa' }}
                </td>
                <td style="color:#334155;">
                    {{ $active->barang->nama_barang ?? $active->kode_barang }}
                </td>
                <td style="color:#475569; white-space:nowrap;">
                    {{ $active->tanggal_kembali ? $active->tanggal_kembali->format('Y-m-d') : '-' }}
                </td>
                <td>
                    <div class="evidence-icons">
                        <label class="evidence-icon-btn" title="Upload Foto">
                            <input type="file" accept="image/*" style="display:none;"
                                   onchange="handleEvidenceUpload(this, 'foto')">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect><circle cx="8.5" cy="8.5" r="1.5"></circle><polyline points="21 15 16 10 5 21"></polyline></svg>
                        </label>
                        <label class="evidence-icon-btn" title="Upload Video">
                            <input type="file" accept="video/*" style="display:none;"
                                   onchange="handleEvidenceUpload(this, 'video')">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="23 7 16 12 23 17 23 7"></polygon><rect x="1" y="5" width="15" height="14" rx="2" ry="2"></rect></svg>
                        </label>
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
                    <button type="button" class="btn-confirm"
                        onclick="submitReturn(
                            '{{ $active->kode_pinjam }}',
                            '{{ addslashes($active->barang->nama_barang ?? '') }}',
                            '{{ addslashes($active->siswa->nama ?? 'Siswa') }}'
                        )">Confirm</button>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">
                    <div class="empty-state">
                        <span class="empty-state-icon">📦</span>
                        Tidak ada barang yang menunggu pengembalian.
                    </div>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

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

{{-- ════════════════════════════════════════════ --}}
{{-- MODAL 1: REJECT REQUEST --}}
{{-- ════════════════════════════════════════════ --}}
<div id="rejectModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-title">Reject Request</div>
        <form id="rejectForm" method="POST">
            @csrf
            <label class="modal-label">Alasan Penolakan (opsional)</label>
            <textarea name="alasan" class="modal-textarea"
                      placeholder="Tuliskan alasan jika perlu..."></textarea>
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel"
                        onclick="closeModal('rejectModal')">Cancel</button>
                <button type="submit" class="btn-modal-reject">Confirm Reject</button>
            </div>
        </form>
    </div>
</div>

{{-- ════════════════════════════════════════════ --}}
{{-- MODAL 2: APPROVE REQUEST --}}
{{-- ════════════════════════════════════════════ --}}
<div id="approveModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-title">Konfirmasi Persetujuan</div>
        <p class="modal-info-text">Yakin ingin menyetujui pengajuan ini?</p>
        <div class="modal-detail-row">
            <div>Peminjam: <strong id="approveStudentName"></strong></div>
            <div>Barang: <strong id="approveItemName"></strong></div>
        </div>
        <form id="approveForm" method="POST">
            @csrf
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel"
                        onclick="closeModal('approveModal')">Cancel</button>
                <button type="submit" class="btn-modal-approve">Ya, Setuju!</button>
            </div>
        </form>
    </div>
</div>

{{-- ════════════════════════════════════════════ --}}
{{-- MODAL 3: KONFIRMASI RETURN (inline confirm) --}}
{{-- ════════════════════════════════════════════ --}}
<div id="returnConfirmModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-title">Konfirmasi Pengembalian</div>
        <p class="modal-info-text">Verifikasi pengembalian barang ini?</p>
        <div class="modal-detail-row">
            <div>Peminjam: <strong id="retStudentName"></strong></div>
            <div>Barang: <strong id="retItemName"></strong></div>
            <div>Kondisi: <strong id="retConditionLabel"></strong></div>
        </div>
        <form id="returnForm" method="POST">
            @csrf
            <input type="hidden" name="kondisi_barang" id="retConditionInput">
            <input type="hidden" name="tanggal_kembali" value="{{ date('Y-m-d') }}">
            <div class="modal-footer">
                <button type="button" class="btn-modal-cancel"
                        onclick="closeModal('returnConfirmModal')">Cancel</button>
                <button type="submit" class="btn-modal-approve">Konfirmasi</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    /* ── Modal helpers ── */
    function openModal(id)  { document.getElementById(id).classList.add('open'); }
    function closeModal(id) { document.getElementById(id).classList.remove('open'); }

    /* Close on backdrop click */
    document.querySelectorAll('.modal-overlay').forEach(function(el) {
        el.addEventListener('click', function(e) {
            if (e.target === el) el.classList.remove('open');
        });
    });

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

    /* ── INLINE RETURN: read select, open confirm modal ── */
    function submitReturn(kodePinjam, itemName, studentName) {
        var sel       = document.getElementById('cond_' + kodePinjam);
        var condition = sel ? sel.value : 'Baik';

        document.getElementById('retStudentName').innerText   = studentName;
        document.getElementById('retItemName').innerText      = itemName;
        document.getElementById('retConditionLabel').innerText = condition;
        document.getElementById('retConditionInput').value    = condition;
        document.getElementById('returnForm').action =
            "{{ url('/admin/verifikasi/pengembalian') }}/" + kodePinjam;

        openModal('returnConfirmModal');
    }

    /* ── Evidence upload ── */
    function handleEvidenceUpload(input, type) {
        if (input.files && input.files[0]) {
            var btn = input.parentElement;
            btn.style.borderColor = '#86EFAC';
            btn.style.background  = '#DCFCE7';
            btn.style.color       = '#15803D';
            btn.title = (type === 'foto' ? '📷 ' : '🎥 ') + input.files[0].name;
        }
    }

    /* ── Auto-dismiss flash ── */
    setTimeout(function() {
        document.querySelectorAll('.alert-flash').forEach(function(el) {
            el.style.transition = 'opacity .5s';
            el.style.opacity = '0';
            setTimeout(function() { el.remove(); }, 500);
        });
    }, 4000);
</script>
@endsection
