@extends('layouts.sistem')

@section('title', 'Kelola Akun')
@section('page_title', 'Kelola Akun')

@section('styles')
<style>
    /* ── Stats Bar ── */
    .akun-stats {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 14px;
        margin-bottom: 22px;
    }

    .akun-stat-item {
        background: #FFFFFF;
        border-radius: 12px;
        padding: 16px 18px;
        border: 1px solid #E3EAF4;
        box-shadow: 0 2px 8px rgba(21, 101, 192, 0.06);
        display: flex;
        flex-direction: column;
    }

    .akun-stat-num {
        font-size: 28px;
        font-weight: 800;
        color: #1A237E;
        line-height: 1;
    }

    .akun-stat-lbl {
        font-size: 11.5px;
        color: #78909C;
        margin-top: 5px;
    }

    /* ── Table Wrapper ── */
    .table-wrap {
        background: #FFFFFF;
        border-radius: 14px;
        border: 1px solid #E3EAF4;
        box-shadow: 0 2px 12px rgba(21, 101, 192, 0.07);
        overflow: hidden;
    }

    .table-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 22px 14px;
        border-bottom: 1px solid #EEF2F6;
        flex-wrap: wrap;
        gap: 12px;
    }

    .table-title {
        font-size: 15px;
        font-weight: 700;
        color: #1A237E;
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
        border: 1.5px solid #CFD8DC;
        border-radius: 8px;
        font-size: 13px;
        color: #1A237E;
        outline: none;
        width: 220px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.2s;
        background: #FAFCFF;
    }

    .search-box input:focus {
        border-color: #42A5F5;
        box-shadow: 0 0 0 3px rgba(66, 165, 245, 0.12);
        background: #FFFFFF;
    }

    .search-icon {
        position: absolute;
        left: 10px;
        top: 50%;
        transform: translateY(-50%);
        color: #90A4AE;
        pointer-events: none;
    }

    .filter-select {
        padding: 8px 12px;
        border: 1.5px solid #CFD8DC;
        border-radius: 8px;
        font-size: 13px;
        color: #455A64;
        outline: none;
        font-family: 'Poppins', sans-serif;
        background: #FAFCFF;
        cursor: pointer;
        transition: border-color 0.2s;
    }

    .filter-select:focus { border-color: #42A5F5; }

    .btn-add-akun {
        padding: 8px 18px;
        background: linear-gradient(135deg, #1565C0, #1A237E);
        color: #FFFFFF;
        border: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        box-shadow: 0 4px 12px rgba(21, 101, 192, 0.3);
        transition: all 0.2s;
        white-space: nowrap;
    }

    .btn-add-akun:hover {
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(21, 101, 192, 0.4);
    }

    /* ── Table ── */
    .akun-table {
        width: 100%;
        border-collapse: collapse;
    }

    .akun-table thead tr {
        background: #F8FAFF;
        border-bottom: 1.5px solid #EEF2F6;
    }

    .akun-table th {
        padding: 11px 18px;
        font-size: 11.5px;
        font-weight: 600;
        color: #78909C;
        text-align: left;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .akun-table td {
        padding: 13px 18px;
        font-size: 13px;
        color: #1A237E;
        border-bottom: 1px solid #F5F7FC;
        vertical-align: middle;
    }

    .akun-table tbody tr:last-child td { border-bottom: none; }
    .akun-table tbody tr:hover td { background: #FAFCFF; }

    /* Role Badges */
    .role-badge {
        display: inline-flex;
        align-items: center;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
    }

    .role-siswa        { background: #E3F2FD; color: #1565C0; }
    .role-admin_sarana { background: #E8F5E9; color: #2E7D32; }
    .role-admin_sistem { background: #FCE4EC; color: #880E4F; }

    /* Action Buttons */
    .btn-edit-row {
        background: none;
        border: none;
        color: #1565C0;
        font-size: 12.5px;
        font-weight: 500;
        cursor: pointer;
        padding: 3px 6px;
        font-family: 'Poppins', sans-serif;
        transition: color 0.15s;
        text-decoration: none;
    }

    .btn-edit-row:hover { color: #0D47A1; text-decoration: underline; }

    .btn-del-row {
        background: none;
        border: 1.5px solid #EF9A9A;
        color: #C62828;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 500;
        cursor: pointer;
        padding: 3px 10px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.15s;
    }

    .btn-del-row:hover { background: #FFCDD2; }

    .btn-reset-row {
        background: none;
        border: 1.5px solid #FFE082;
        color: #E65100;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 500;
        cursor: pointer;
        padding: 3px 8px;
        font-family: 'Poppins', sans-serif;
        transition: all 0.15s;
    }

    .btn-reset-row:hover { background: #FFF8E1; }

    /* Pagination */
    .pagination-wrap {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 12px 18px;
        border-top: 1px solid #EEF2F6;
    }

    .pagination-info { font-size: 12.5px; color: #90A4AE; }

    .pagination-links {
        display: flex;
        gap: 4px;
    }

    .page-btn {
        min-width: 30px;
        height: 30px;
        padding: 0 8px;
        border: 1px solid #CFD8DC;
        background: #FFFFFF;
        color: #455A64;
        border-radius: 6px;
        font-size: 12.5px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: all 0.15s;
    }

    .page-btn:hover { background: #EEF2F6; }
    .page-btn.active { background: #1565C0; border-color: #1565C0; color: #FFFFFF; font-weight: 600; }
    .page-btn.disabled { opacity: 0.4; cursor: default; pointer-events: none; }
</style>
@endsection

@section('content')

{{-- ── Stats Bar ── --}}
<div class="akun-stats">
    <div class="akun-stat-item">
        <div class="akun-stat-num">{{ $stats['total'] }}</div>
        <div class="akun-stat-lbl">Total Akun</div>
    </div>
    <div class="akun-stat-item">
        <div class="akun-stat-num" style="color: #1565C0;">{{ $stats['siswa'] }}</div>
        <div class="akun-stat-lbl">Akun Siswa</div>
    </div>
    <div class="akun-stat-item">
        <div class="akun-stat-num" style="color: #2E7D32;">{{ $stats['admin_sarana'] }}</div>
        <div class="akun-stat-lbl">Admin Sarana</div>
    </div>
    <div class="akun-stat-item">
        <div class="akun-stat-num" style="color: #880E4F;">{{ $stats['admin_sistem'] }}</div>
        <div class="akun-stat-lbl">Admin Sistem</div>
    </div>
</div>

{{-- ── Table ── --}}
<div class="table-wrap">
    <div class="table-header">
        <div class="table-title">Daftar Akun Pengguna</div>
        <div class="table-controls">
            <form action="{{ route('sistem.akun.index') }}" method="GET" style="display:flex; gap: 10px; align-items:center;">
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
            <button type="button" class="btn-add-akun" onclick="openModal('addAkunModal')">+ Tambah Akun</button>
        </div>
    </div>

    <table class="akun-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Username</th>
                <th>NIS / NIP</th>
                <th>No. HP</th>
                <th>Role</th>
                <th>Bergabung</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($akunList as $index => $akun)
            <tr>
                <td style="color: #90A4AE; font-size: 12px;">{{ $akunList->firstItem() + $index }}</td>
                <td style="font-weight: 600; color: #0D1B2A;">{{ $akun->nama }}</td>
                <td style="color: #455A64;">@{{ $akun->username }}</td>
                <td style="color: #78909C; font-size: 12px;">{{ $akun->nis ?? $akun->nip ?? '-' }}</td>
                <td style="color: #78909C; font-size: 12.5px;">{{ $akun->nomor_kontak ?? '-' }}</td>
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
                <td style="color: #90A4AE; font-size: 12px;">{{ $akun->created_at?->format('d M Y') ?? '-' }}</td>
                <td>
                    <div style="display: flex; align-items: center; gap: 6px;">
                        <button type="button" class="btn-edit-row" onclick='openEditAkunModal(@json($akun))'>Edit</button>

                        <form action="{{ route('sistem.akun.reset-password', $akun->id_akun) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Reset password akun {{ $akun->nama }} ke default?')">
                            @csrf
                            <button type="submit" class="btn-reset-row">Reset PW</button>
                        </form>

                        @if(auth()->id() !== $akun->id_akun)
                        <form action="{{ route('sistem.akun.destroy', $akun->id_akun) }}" method="POST" style="display:inline;"
                              onsubmit="return confirm('Hapus akun {{ $akun->nama }}? Tindakan ini tidak bisa dibatalkan!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-del-row">Hapus</button>
                        </form>
                        @endif
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; color: #90A4AE; padding: 36px; font-size: 13px;">
                    Tidak ada akun ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- Pagination ── --}}
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
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title">Tambah Akun Baru</div>
            <button class="modal-close" onclick="closeModal('addAkunModal')">&times;</button>
        </div>
        <form action="{{ route('sistem.akun.store') }}" method="POST">
            @csrf
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span style="color:#C62828;">*</span></label>
                    <input type="text" name="nama" class="form-control" placeholder="e.g. Budi Santoso" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Username <span style="color:#C62828;">*</span></label>
                    <input type="text" name="username" class="form-control" placeholder="e.g. budi.s" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Role <span style="color:#C62828;">*</span></label>
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
                    <input type="text" name="nis" class="form-control" placeholder="e.g. 10006" id="addNisInput">
                </div>
                <div class="form-group" id="addNipGroup" style="display:none;">
                    <label class="form-label">NIP (Nomor Induk Pegawai)</label>
                    <input type="text" name="nip" class="form-control" placeholder="e.g. 198801012010011001" id="addNipInput">
                </div>
                <div class="form-group">
                    <label class="form-label">Nomor HP</label>
                    <input type="text" name="nomor_kontak" class="form-control" placeholder="e.g. 0812345678">
                </div>
            </div>

            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Password <span style="color:#C62828;">*</span></label>
                    <input type="password" name="password" class="form-control" placeholder="Min. 6 karakter" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password <span style="color:#C62828;">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password" required>
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
    <div class="modal-box">
        <div class="modal-header">
            <div class="modal-title">Edit Akun</div>
            <button class="modal-close" onclick="closeModal('editAkunModal')">&times;</button>
        </div>
        <form id="editAkunForm" method="POST">
            @csrf
            @method('PUT')
            <div class="form-grid-2">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap <span style="color:#C62828;">*</span></label>
                    <input type="text" id="edit_nama" name="nama" class="form-control" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Username <span style="color:#C62828;">*</span></label>
                    <input type="text" id="edit_username" name="username" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Role <span style="color:#C62828;">*</span></label>
                <select id="edit_role" name="role" class="form-control" required onchange="toggleIdentifier(this.value, 'edit')">
                    <option value="siswa">Siswa</option>
                    <option value="admin_sarana">Admin Sarana</option>
                    <option value="admin_sistem">Admin Sistem</option>
                </select>
            </div>

            <div class="form-grid-2">
                <div class="form-group" id="editNisGroup">
                    <label class="form-label">NIS</label>
                    <input type="text" id="edit_nis" name="nis" class="form-control" placeholder="e.g. 10001">
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
                    <label class="form-label">Password Baru <small style="color:#90A4AE;">(kosongkan jika tidak diubah)</small></label>
                    <input type="password" name="password" class="form-control" placeholder="Password baru...">
                </div>
                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" class="form-control" placeholder="Ulangi password baru...">
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
