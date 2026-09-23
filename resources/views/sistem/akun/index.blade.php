@extends('layouts.sistem')

@section('title', 'Kelola Akun')
@section('page_title', 'Kelola Akun')

@section('styles')
<style>
    /* ─── STATS ROW ─── */
    .akun-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 20px;
    }
    @media (max-width: 900px) { .akun-stats { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 500px) { .akun-stats { grid-template-columns: 1fr; } }

    .akun-stat-item {
        background: #FFFFFF;
        border-radius: 12px;
        padding: 16px 20px;
        border: 1px solid #E8EEF6;
        box-shadow: 0 1px 4px rgba(30, 41, 80, 0.05);
        display: flex;
        align-items: center;
        gap: 14px;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }
    .akun-stat-item:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 41, 80, 0.08);
    }

    .akun-stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .akun-stat-icon.blue   { background: #EFF6FF; color: #2563EB; }
    .akun-stat-icon.green  { background: #ECFDF5; color: #059669; }
    .akun-stat-icon.indigo { background: #EEF2FF; color: #4F46E5; }
    .akun-stat-icon.dark   { background: #F1F5F9; color: #475569; }

    .akun-stat-num {
        font-family: 'Outfit', sans-serif;
        font-size: 24px;
        font-weight: 700;
        color: #1E293B;
        line-height: 1.1;
    }
    .akun-stat-lbl {
        font-size: 12px;
        color: #64748B;
        font-weight: 500;
        margin-top: 2px;
    }

    /* ─── TABLE WRAPPER ─── */
    .table-wrap {
        background: #FFFFFF;
        border-radius: 14px;
        border: 1px solid #E8EEF6;
        box-shadow: 0 1px 4px rgba(30, 41, 80, 0.05);
        overflow: hidden;
    }

    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 22px;
        border-bottom: 1px solid #F1F5F9;
        flex-wrap: wrap;
        gap: 12px;
    }

    .table-title {
        font-family: 'Outfit', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #1E293B;
        letter-spacing: -0.2px;
    }

    .table-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .search-box {
        position: relative;
    }

    .search-box input {
        padding: 8px 14px 8px 36px;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        font-size: 13px;
        color: #1E293B;
        outline: none;
        width: 230px;
        font-family: inherit;
        transition: all 0.15s ease;
        background: #FFFFFF;
    }

    .search-box input:focus {
        border-color: #2D4E9E;
        box-shadow: 0 0 0 3px rgba(45, 78, 158, 0.10);
    }

    .search-icon {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: #94A3B8;
        pointer-events: none;
    }

    .filter-select {
        padding: 8px 12px;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        font-size: 13px;
        color: #334155;
        outline: none;
        font-family: inherit;
        background: #FFFFFF;
        cursor: pointer;
        transition: border-color 0.15s;
    }
    .filter-select:focus {
        border-color: #2D4E9E;
        box-shadow: 0 0 0 3px rgba(45, 78, 158, 0.10);
    }

    .btn-add-akun {
        padding: 8px 18px;
        background: #2D4E9E;
        color: #FFFFFF;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: background 0.15s ease, transform 0.15s ease;
        white-space: nowrap;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .btn-add-akun:hover {
        background: #243f85;
        transform: translateY(-1px);
    }

    /* ─── TABLE STYLING ─── */
    .akun-table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .akun-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .akun-table thead tr {
        background: #F8FAFC;
        border-bottom: 1px solid #E2E8F0;
    }

    .akun-table th {
        padding: 12px 18px;
        font-size: 11px;
        font-weight: 700;
        color: #64748B;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .akun-table td {
        padding: 13px 18px;
        color: #334155;
        border-bottom: 1px solid #F1F5F9;
        vertical-align: middle;
    }

    .akun-table tbody tr:last-child td { border-bottom: none; }
    .akun-table tbody tr:hover td { background: #F8FAFF; }

    .user-cell {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .user-avatar {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: #EFF6FF;
        color: #2563EB;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 13px;
        flex-shrink: 0;
    }
    .user-name {
        font-weight: 600;
        color: #1E293B;
    }
    .user-uname {
        font-size: 12px;
        color: #64748B;
    }

    /* Role Badges */
    .role-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
    }
    .role-siswa        { background: #EFF6FF; color: #2563EB; }
    .role-admin_sarana { background: #ECFDF5; color: #059669; }
    .role-admin_sistem { background: #EEF2FF; color: #4F46E5; }

    /* Action Buttons */
    .action-btn-group {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-action-edit {
        background: #F1F5F9;
        color: #2D4E9E;
        border: 1px solid #CBD5E1;
        border-radius: 6px;
        padding: 5px 10px;
        font-size: 11.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
        font-family: inherit;
    }
    .btn-action-edit:hover {
        background: #2D4E9E;
        color: #FFFFFF;
        border-color: #2D4E9E;
    }

    .btn-action-reset {
        background: #FFFBEB;
        color: #D97706;
        border: 1px solid #FDE68A;
        border-radius: 6px;
        padding: 5px 10px;
        font-size: 11.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
        font-family: inherit;
    }
    .btn-action-reset:hover {
        background: #D97706;
        color: #FFFFFF;
        border-color: #D97706;
    }

    .btn-action-del {
        background: #FFF1F2;
        color: #E11D48;
        border: 1px solid #FECDD3;
        border-radius: 6px;
        padding: 5px 10px;
        font-size: 11.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
        font-family: inherit;
    }
    .btn-action-del:hover {
        background: #E11D48;
        color: #FFFFFF;
        border-color: #E11D48;
    }

    /* Pagination */
    .pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 22px;
        border-top: 1px solid #F1F5F9;
        background: #FFFFFF;
        flex-wrap: wrap;
        gap: 10px;
    }

    .pagination-info { font-size: 12.5px; color: #64748B; }

    .pagination-links {
        display: flex;
        gap: 4px;
    }

    .page-btn {
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
        text-decoration: none;
        transition: all 0.15s;
    }
    .page-btn:hover { background: #F1F5F9; color: #1E293B; }
    .page-btn.active {
        background: #2D4E9E;
        border-color: #2D4E9E;
        color: #FFFFFF;
        font-weight: 600;
    }
    .page-btn.disabled { opacity: 0.4; cursor: default; pointer-events: none; }

    /* ─── RESPONSIVE RULES (MOBILE) ─── */
    @media (max-width: 768px) {
        .table-header {
            flex-direction: column;
            align-items: stretch;
            gap: 14px;
            padding: 16px 14px;
        }

        .table-controls {
            flex-direction: column;
            align-items: stretch;
            width: 100%;
            gap: 10px;
        }

        .table-controls form {
            flex-direction: column;
            align-items: stretch !important;
            width: 100%;
            gap: 10px !important;
        }

        .search-box, .search-box input {
            width: 100% !important;
        }

        .filter-select {
            width: 100%;
        }

        .btn-add-akun {
            justify-content: center;
            width: 100%;
        }

        .pagination-wrap {
            flex-direction: column;
            align-items: center;
            text-align: center;
            padding: 14px;
            gap: 12px;
        }

        .pagination-links {
            flex-wrap: wrap;
            justify-content: center;
        }
    }
</style>
@endsection

@section('content')

{{-- ── 4 Stats Row ── --}}
<div class="akun-stats">
    <div class="akun-stat-item">
        <div class="akun-stat-icon dark">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                <circle cx="9" cy="7" r="4"></circle>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
            </svg>
        </div>
        <div>
            <div class="akun-stat-num">{{ $stats['total'] }}</div>
            <div class="akun-stat-lbl">Total Akun</div>
        </div>
    </div>
    <div class="akun-stat-item">
        <div class="akun-stat-icon blue">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
            </svg>
        </div>
        <div>
            <div class="akun-stat-num" style="color: #2563EB;">{{ $stats['siswa'] }}</div>
            <div class="akun-stat-lbl">Akun Siswa</div>
        </div>
    </div>
    <div class="akun-stat-item">
        <div class="akun-stat-icon green">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect>
                <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path>
            </svg>
        </div>
        <div>
            <div class="akun-stat-num" style="color: #059669;">{{ $stats['admin_sarana'] }}</div>
            <div class="akun-stat-lbl">Admin Sarana</div>
        </div>
    </div>
    <div class="akun-stat-item">
        <div class="akun-stat-icon indigo">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"></circle>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
            </svg>
        </div>
        <div>
            <div class="akun-stat-num" style="color: #4F46E5;">{{ $stats['admin_sistem'] }}</div>
            <div class="akun-stat-lbl">Admin Sistem</div>
        </div>
    </div>
</div>

{{-- ── Main Table Card ── --}}
<div class="table-wrap">
    <div class="table-header">
        <div class="table-title">Daftar Akun Pengguna</div>
        <div class="table-controls">
            <form action="{{ route('sistem.akun.index') }}" method="GET" style="display:flex; gap: 8px; align-items:center;">
                <div class="search-box">
                    <svg class="search-icon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau username...">
                </div>
                <select name="role" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Role</option>
                    <option value="siswa" {{ request('role') === 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="admin_sarana" {{ request('role') === 'admin_sarana' ? 'selected' : '' }}>Admin Sarana</option>
                    <option value="admin_sistem" {{ request('role') === 'admin_sistem' ? 'selected' : '' }}>Admin Sistem</option>
                </select>
            </form>
            <button type="button" class="btn-add-akun" onclick="openModal('addAkunModal')">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                Tambah Akun
            </button>
        </div>
    </div>

    <div class="akun-table-responsive">
        <table class="akun-table">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th>PENGGUNA</th>
                    <th>NIS / NIP</th>
                    <th>NO. HP</th>
                    <th>ROLE</th>
                    <th>TGL. BERGABUNG</th>
                    <th style="text-align: right; padding-right: 22px;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($akunList as $index => $akun)
                <tr>
                    <td style="color: #94A3B8; font-size: 12px;">{{ $akunList->firstItem() + $index }}</td>
                    <td>
                        <div class="user-cell">
                            <div class="user-avatar">
                                {{ strtoupper(substr($akun->nama ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <div class="user-name">{{ $akun->nama }}</div>
                                <div class="user-uname">{{ '@' . $akun->username }}</div>
                            </div>
                        </div>
                    </td>
                    <td style="color: #64748B; font-weight: 500;">{{ $akun->nis ?? $akun->nip ?? '-' }}</td>
                    <td style="color: #64748B;">{{ $akun->nomor_kontak ?? '-' }}</td>
                    <td>
                        @php
                            $roleLabel = match($akun->role) {
                                'siswa' => 'Siswa',
                                'admin_sarana' => 'Admin Sarana',
                                'admin_sistem' => 'Admin Sistem',
                                default => $akun->role
                            };
                        @endphp
                        <span class="role-badge role-{{ $akun->role }}">{{ $roleLabel }}</span>
                    </td>
                    <td style="color: #64748B; font-size: 12.5px;">{{ $akun->created_at?->format('d M Y') ?? '-' }}</td>
                    <td>
                        <div class="action-btn-group" style="justify-content: flex-end; padding-right: 6px;">
                            <button type="button" class="btn-action-edit" onclick='openEditAkunModal(@json($akun))'>Edit</button>

                            <form action="{{ route('sistem.akun.reset-password', $akun->id_akun) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('Reset password akun {{ $akun->nama }} ke default (sinfas123)?')">
                                @csrf
                                <button type="submit" class="btn-action-reset">Reset PW</button>
                            </form>

                            @if(auth()->id() !== $akun->id_akun)
                            <form action="{{ route('sistem.akun.destroy', $akun->id_akun) }}" method="POST" style="display:inline;"
                                  onsubmit="return confirm('Hapus akun {{ $akun->nama }}? Tindakan ini tidak bisa dibatalkan!')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action-del">Hapus</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #94A3B8; padding: 40px; font-size: 13.5px;">
                        Tidak ada data akun pengguna yang sesuai filter.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── Pagination ── --}}
    <div class="pagination-wrap">
        <div class="pagination-info">
            Menampilkan {{ $akunList->firstItem() ?? 0 }}–{{ $akunList->lastItem() ?? 0 }} dari {{ $akunList->total() }} akun
        </div>
        <div class="pagination-links">
            @if($akunList->onFirstPage())
                <span class="page-btn disabled">‹</span>
            @else
                <a class="page-btn" href="{{ $akunList->previousPageUrl() }}">‹</a>
            @endif

            @foreach($akunList->getUrlRange(1, $akunList->lastPage()) as $page => $url)
                <a class="page-btn {{ $page == $akunList->currentPage() ? 'active' : '' }}" href="{{ $url }}">{{ $page }}</a>
            @endforeach

            @if($akunList->hasMorePages())
                <a class="page-btn" href="{{ $akunList->nextPageUrl() }}">›</a>
            @else
                <span class="page-btn disabled">›</span>
            @endif
        </div>
    </div>
</div>

{{-- ── Modal: Tambah Akun ── --}}
<div id="addAkunModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <div class="modal-title">Tambah Akun Baru</div>
            <button class="modal-close-btn" onclick="closeModal('addAkunModal')">&times;</button>
        </div>
        <form action="{{ route('sistem.akun.store') }}" method="POST">
            @csrf
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="nama" class="form-control" placeholder="Contoh: Budi Santoso" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Username <span style="color:#EF4444;">*</span></label>
                    <input type="text" name="username" class="form-control" placeholder="Contoh: budi.s" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Role <span style="color:#EF4444;">*</span></label>
                <select name="role" class="form-control" required id="addRoleSelect" onchange="toggleIdentifier(this.value, 'add')">
                    <option value="" disabled selected>Pilih role akun</option>
                    <option value="siswa">Siswa</option>
                    <option value="admin_sarana">Admin Sarana</option>
                    <option value="admin_sistem">Admin Sistem</option>
                </select>
            </div>

            <div class="form-grid-2">
                <div class="form-group" id="addNisGroup">
                    <label class="form-label">NIS (Nomor Induk Siswa)</label>
                    <input type="text" name="nis" class="form-control" placeholder="Contoh: 10006" id="addNisInput">
                </div>
                <div class="form-group" id="addNipGroup" style="display:none;">
                    <label class="form-label">NIP (Nomor Induk Pegawai)</label>
                    <input type="text" name="nip" class="form-control" placeholder="Contoh: 198801012010011001" id="addNipInput">
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="nomor_kontak" class="form-control" placeholder="Contoh: 0812345678">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Kata Sandi <span style="color:#EF4444;">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Kata Sandi <span style="color:#EF4444;">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi" required>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('addAkunModal')">Batal</button>
                <button type="submit" class="btn-primary">Simpan Akun</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Modal: Edit Akun ── --}}
<div id="editAkunModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-header">
            <div class="modal-title">Edit Akun Pengguna</div>
            <button class="modal-close-btn" onclick="closeModal('editAkunModal')">&times;</button>
        </div>
        <form id="editAkunForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span style="color:#EF4444;">*</span></label>
                    <input type="text" id="edit_nama" name="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Username <span style="color:#EF4444;">*</span></label>
                    <input type="text" id="edit_username" name="username" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Role <span style="color:#EF4444;">*</span></label>
                <select id="edit_role" name="role" class="form-control" required onchange="toggleIdentifier(this.value, 'edit')">
                    <option value="siswa">Siswa</option>
                    <option value="admin_sarana">Admin Sarana</option>
                    <option value="admin_sistem">Admin Sistem</option>
                </select>
            </div>

            <div class="form-grid-2">
                <div class="form-group" id="editNisGroup">
                    <label class="form-label">NIS</label>
                    <input type="text" id="edit_nis" name="nis" class="form-control" placeholder="Contoh: 10001">
                </div>
                <div class="form-group" id="editNipGroup" style="display:none;">
                    <label class="form-label">NIP</label>
                    <input type="text" id="edit_nip" name="nip" class="form-control" placeholder="NIP Pegawai">
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" id="edit_nomor_kontak" name="nomor_kontak" class="form-control">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Kata Sandi Baru <small style="color:#94A3B8; font-weight:400;">(kosongkan jika tidak diubah)</small></label>
                    <input type="password" name="password" class="form-control" placeholder="Kata sandi baru...">
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Kata Sandi</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi kata sandi...">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('editAkunModal')">Batal</button>
                <button type="submit" class="btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function toggleIdentifier(role, prefix) {
        const nisGroup = document.getElementById(prefix + 'NisGroup');
        const nipGroup = document.getElementById(prefix + 'NipGroup');
        if (!nisGroup) return;

        if (role === 'siswa') {
            nisGroup.style.display = 'block';
            if (nipGroup) nipGroup.style.display = 'none';
        } else {
            nisGroup.style.display = 'none';
            if (nipGroup) nipGroup.style.display = 'block';
        }
    }

    function openEditAkunModal(akun) {
        document.getElementById('edit_nama').value          = akun.nama || '';
        document.getElementById('edit_username').value      = akun.username || '';
        document.getElementById('edit_role').value          = akun.role || 'siswa';
        document.getElementById('edit_nis').value           = akun.nis || '';
        document.getElementById('edit_nip').value           = akun.nip || '';
        document.getElementById('edit_nomor_kontak').value  = akun.nomor_kontak || '';
        document.getElementById('editAkunForm').action      = "{{ url('/sistem/akun') }}/" + akun.id_akun;

        toggleIdentifier(akun.role, 'edit');
        openModal('editAkunModal');
    }
</script>
@endsection
