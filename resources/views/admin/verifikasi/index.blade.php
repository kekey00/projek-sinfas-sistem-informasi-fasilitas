@extends('layouts.admin')

@section('title', 'Verifikasi Loan & Return')
@section('page_title', 'Verifikasi Loan & Return')

@section('styles')
<style>
    /* Tab Switcher */
    .tab-bar {
        display: flex;
        gap: 10px;
        margin-bottom: 20px;
    }

    .tab-link {
        padding: 9px 20px;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 500;
        text-decoration: none;
        color: #475569;
        background: #E2E8F0;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .tab-link.active {
        background: #1D4ED8;
        color: #FFFFFF;
        font-weight: 600;
    }

    .tab-pill-count {
        background: rgba(255, 255, 255, 0.25);
        padding: 2px 7px;
        border-radius: 12px;
        font-size: 11.5px;
    }

    .tab-link:not(.active) .tab-pill-count {
        background: #CBD5E1;
        color: #1E293B;
    }

    .verify-container {
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        border: 1px solid #F1F5F9;
        overflow: hidden;
    }

    .verify-header {
        padding: 18px 24px;
        border-bottom: 1px solid #F1F5F9;
    }

    .verify-title {
        font-size: 16px;
        font-weight: 600;
        color: #0F172A;
    }

    .verify-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .verify-table th {
        background: #FAFAFA;
        color: #64748B;
        font-size: 13px;
        font-weight: 500;
        padding: 14px 24px;
        border-bottom: 1px solid #F1F5F9;
    }

    .verify-table td {
        padding: 16px 24px;
        border-bottom: 1px solid #F8FAFC;
        font-size: 14px;
        color: #1E293B;
        vertical-align: middle;
    }

    .btn-action-approve {
        background: #16A34A;
        color: #FFFFFF;
        border: none;
        border-radius: 6px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.15s ease;
    }

    .btn-action-approve:hover {
        background: #15803D;
    }

    .btn-action-reject {
        background: #DC2626;
        color: #FFFFFF;
        border: none;
        border-radius: 6px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.15s ease;
    }

    .btn-action-reject:hover {
        background: #B91C1C;
    }

    .btn-action-verify {
        background: #1D4ED8;
        color: #FFFFFF;
        border: none;
        border-radius: 6px;
        padding: 6px 16px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.15s ease;
    }

    .btn-action-verify:hover {
        background: #1E40AF;
    }

    .condition-select {
        padding: 6px 10px;
        border: 1px solid #CBD5E1;
        border-radius: 6px;
        font-size: 13px;
        color: #0F172A;
        background: #FFFFFF;
    }
</style>
@endsection

@section('content')

    <!-- Tab Bar -->
    <div class="tab-bar">
        <a href="{{ route('admin.verifikasi.index', ['tab' => 'requests']) }}" class="tab-link {{ $tab === 'requests' ? 'active' : '' }}">
            <span>Pending Requests</span>
            <span class="tab-pill-count">{{ $pendingRequests->total() }}</span>
        </a>

        <a href="{{ route('admin.verifikasi.index', ['tab' => 'returns']) }}" class="tab-link {{ $tab === 'returns' ? 'active' : '' }}">
            <span>Pending Returns</span>
            <span class="tab-pill-count">{{ $activeLoans->total() }}</span>
        </a>

        <a href="{{ route('admin.verifikasi.index', ['tab' => 'history']) }}" class="tab-link {{ $tab === 'history' ? 'active' : '' }}">
            <span>Riwayat Selesai</span>
        </a>
    </div>

    <!-- ─── TAB 1: PENDING REQUESTS ──────────────────────────── -->
    @if($tab === 'requests')
    <div class="verify-container">
        <div class="verify-header">
            <h2 class="verify-title">Pending Loan Requests</h2>
        </div>

        <table class="verify-table">
            <thead>
                <tr>
                    <th>Borrower</th>
                    <th>Item</th>
                    <th>Borrow Date</th>
                    <th>Due Date</th>
                    <th style="width: 200px; text-align: right; padding-right: 32px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingRequests as $pjm)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #0F172A;">{{ $pjm->siswa->nama ?? 'Siswa' }}</div>
                        <div style="font-size: 12px; color: #64748B;">NIS: {{ $pjm->nis }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 500;">{{ $pjm->barang->nama_barang ?? $pjm->kode_barang }}</div>
                        <div style="font-size: 12px; color: #64748B;">{{ $pjm->keterangan_penggunaan }}</div>
                    </td>
                    <td style="color: #475569;">
                        {{ $pjm->tanggal_pinjam ? $pjm->tanggal_pinjam->format('Y-m-d') : '-' }}
                    </td>
                    <td style="color: #475569;">
                        {{ $pjm->tanggal_kembali ? $pjm->tanggal_kembali->format('Y-m-d') : '-' }}
                    </td>
                    <td style="text-align: right; padding-right: 28px;">
                        <form action="{{ route('admin.verifikasi.approve', $pjm->kode_pinjam) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn-action-approve" onclick="return confirm('Setujui peminjaman ini?')">Approve</button>
                        </form>

                        <button type="button" class="btn-action-reject" onclick="openRejectModal('{{ $pjm->kode_pinjam }}', '{{ $pjm->barang->nama_barang ?? '' }}', '{{ $pjm->siswa->nama ?? 'Siswa' }}')">
                            Reject
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #94A3B8; padding: 28px;">
                        Tidak ada permohonan pinjam yang menunggu verifikasi saat ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="padding: 16px 24px; display: flex; justify-content: flex-end;">
            {{ $pendingRequests->links() }}
        </div>
    </div>
    @endif

    <!-- ─── TAB 2: PENDING RETURNS ───────────────────────────── -->
    @if($tab === 'returns')
    <div class="verify-container">
        <div class="verify-header">
            <h2 class="verify-title">Pending Returns (Peminjaman Aktif)</h2>
        </div>

        <table class="verify-table">
            <thead>
                <tr>
                    <th>Borrower</th>
                    <th>Item</th>
                    <th>Borrow Date</th>
                    <th>Due Date</th>
                    <th style="width: 220px; text-align: right; padding-right: 32px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activeLoans as $active)
                <tr>
                    <td>
                        <div style="font-weight: 600; color: #0F172A;">{{ $active->siswa->nama ?? 'Siswa' }}</div>
                        <div style="font-size: 12px; color: #64748B;">NIS: {{ $active->nis }}</div>
                    </td>
                    <td>
                        <div style="font-weight: 500;">{{ $active->barang->nama_barang ?? $active->kode_barang }}</div>
                        <div style="font-size: 12px; color: #64748B;">Kode Pinjam: {{ $active->kode_pinjam }}</div>
                    </td>
                    <td style="color: #475569;">
                        {{ $active->tanggal_pinjam ? $active->tanggal_pinjam->format('Y-m-d') : '-' }}
                    </td>
                    <td style="color: #475569;">
                        {{ $active->tanggal_kembali ? $active->tanggal_kembali->format('Y-m-d') : '-' }}
                    </td>
                    <td style="text-align: right; padding-right: 28px;">
                        <button type="button" class="btn-action-verify" onclick="openReturnModal('{{ $active->kode_pinjam }}', '{{ $active->barang->nama_barang ?? '' }}', '{{ $active->siswa->nama ?? 'Siswa' }}')">
                            Verify Return
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #94A3B8; padding: 28px;">
                        Tidak ada barang yang sedang dipinjam saat ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="padding: 16px 24px; display: flex; justify-content: flex-end;">
            {{ $activeLoans->links() }}
        </div>
    </div>
    @endif

    <!-- ─── TAB 3: RIWAYAT SELESAI ───────────────────────────── -->
    @if($tab === 'history')
    <div class="verify-container">
        <div class="verify-header">
            <h2 class="verify-title">Riwayat Selesai</h2>
        </div>

        <table class="verify-table">
            <thead>
                <tr>
                    <th>Borrower</th>
                    <th>Item</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Kondisi Saat Kembali</th>
                </tr>
            </thead>
            <tbody>
                @forelse($historyLoans as $hist)
                <tr>
                    <td>
                        <div style="font-weight: 500;">{{ $hist->siswa->nama ?? 'Siswa' }}</div>
                    </td>
                    <td>
                        {{ $hist->barang->nama_barang ?? $hist->kode_barang }}
                    </td>
                    <td style="color: #64748B;">
                        {{ $hist->tanggal_pinjam ? $hist->tanggal_pinjam->format('Y-m-d') : '-' }}
                    </td>
                    <td style="color: #64748B;">
                        {{ $hist->pengembalian->tanggal_kembali ?? '-' }}
                    </td>
                    <td>
                        <span style="display: inline-block; padding: 3px 8px; border-radius: 6px; font-size: 12px; background: #DCFCE7; color: #15803D; font-weight: 500;">
                            {{ $hist->pengembalian->kondisi_barang ?? 'Baik' }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #94A3B8; padding: 28px;">
                        Belum ada riwayat pengembalian yang tercatat.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div style="padding: 16px 24px; display: flex; justify-content: flex-end;">
            {{ $historyLoans->links() }}
        </div>
    </div>
    @endif

    <!-- Modal Verify Return -->
    <div id="returnModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">Verify Return</div>
                <button class="modal-close-btn" onclick="closeModal('returnModal')">&times;</button>
            </div>
            <form id="returnForm" method="POST">
                @csrf
                <div style="margin-bottom: 14px;">
                    <p style="font-size: 13.5px; color: #475569; margin-bottom: 12px;">
                        Verifikasi pengembalian barang <strong id="returnItemName"></strong> oleh <strong id="returnStudentName"></strong>.
                    </p>
                    
                    <label style="display: block; font-size: 13px; font-weight: 500; margin-bottom: 6px;">Kondisi Barang Saat Kembali</label>
                    <select name="kondisi_barang" class="condition-select" style="width: 100%; margin-bottom: 14px;" required>
                        <option value="Baik">Baik (Lengkap & Berfungsi Normal)</option>
                        <option value="Kurang Baik">Kurang Baik (Lecet / Perlu Perbaikan Ringan)</option>
                        <option value="Rusak Berat">Rusak Berat (Tidak Berfungsi / Patah)</option>
                    </select>

                    <label style="display: block; font-size: 13px; font-weight: 500; margin-bottom: 6px;">Tanggal Dikembalikan</label>
                    <input type="date" name="tanggal_kembali" value="{{ date('Y-m-d') }}" style="width: 100%; padding: 8px 12px; border: 1px solid #CBD5E1; border-radius: 6px;" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal('returnModal')">Batal</button>
                    <button type="submit" class="btn-submit">Konfirmasi Kembali</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Reject -->
    <div id="rejectModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">Reject Request</div>
                <button class="modal-close-btn" onclick="closeModal('rejectModal')">&times;</button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div style="margin-bottom: 14px;">
                    <p style="font-size: 13.5px; color: #475569; margin-bottom: 10px;">
                        Tolak pengajuan peminjaman <strong id="rejectItemName"></strong> oleh <strong id="rejectStudentName"></strong>?
                    </p>
                    <label style="display: block; font-size: 13px; font-weight: 500; margin-bottom: 6px;">Alasan Penolakan</label>
                    <textarea name="alasan" class="form-control" rows="3" placeholder="Contoh: Barang sedang dalam perawatan atau jadwal bentrok" style="width: 100%; border: 1px solid #CBD5E1; border-radius: 8px; padding: 10px; font-family: inherit; font-size: 13px;"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal('rejectModal')">Batal</button>
                    <button type="submit" class="btn-action-reject" style="padding: 8px 20px;">Konfirmasi Tolak</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openReturnModal(kodePinjam, itemName, studentName) {
        document.getElementById('returnItemName').innerText = itemName;
        document.getElementById('returnStudentName').innerText = studentName;
        document.getElementById('returnForm').action = "{{ url('/admin/verifikasi/pengembalian') }}/" + kodePinjam;
        openModal('returnModal');
    }

    function openRejectModal(kodePinjam, itemName, studentName) {
        document.getElementById('rejectItemName').innerText = itemName;
        document.getElementById('rejectStudentName').innerText = studentName;
        document.getElementById('rejectForm').action = "{{ url('/admin/verifikasi/reject') }}/" + kodePinjam;
        openModal('rejectModal');
    }
</script>
@endsection
