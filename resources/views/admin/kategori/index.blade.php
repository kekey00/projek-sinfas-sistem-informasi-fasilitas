@extends('layouts.admin')

@section('title', 'Kelola Kategori - SINFAS')
@section('page_title', 'Kelola Kategori')

@section('styles')
<style>
    /* ─── MINIMALIST CONTAINER ─── */
    .kategori-container {
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.05);
        border: 1px solid #E2E8F0;
        overflow: hidden;
    }

    /* ─── HEADER ─── */
    .kategori-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        flex-wrap: wrap;
        gap: 16px;
        border-bottom: 1px solid #E2E8F0;
        background: #FFFFFF;
    }

    .kategori-title-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .kategori-title {
        font-family: 'Outfit', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: #0F172A;
        letter-spacing: -0.2px;
    }

    .kategori-badge-total {
        background: #EFF6FF;
        color: #2563EB;
        font-size: 11.5px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 6px;
        border: 1px solid #BFDBFE;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Search Bar */
    .search-input-wrap {
        position: relative;
        width: 240px;
    }

    .search-input-wrap input {
        width: 100%;
        padding: 8px 14px 8px 38px;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        font-size: 13px;
        color: #0F172A;
        outline: none;
        background: #FFFFFF;
        font-family: inherit;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .search-input-wrap input:focus {
        border-color: #2D4E9E;
        box-shadow: 0 0 0 3px rgba(45, 78, 158, 0.10);
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94A3B8;
        pointer-events: none;
    }

    /* Add Category CTA Button */
    .btn-add-category-glow {
        background: #2D4E9E;
        color: #FFFFFF;
        border: 1px solid transparent;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        transition: background 0.15s ease;
        font-family: inherit;
        white-space: nowrap;
    }

    .btn-add-category-glow:hover {
        background: #243f85;
    }

    /* ─── TABLE ─── */
    .kategori-table-wrap {
        width: 100%;
        overflow-x: auto;
    }

    .kategori-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .kategori-table th {
        background: #F8FAFC;
        color: #64748B;
        font-size: 11.5px;
        font-weight: 600;
        padding: 12px 24px;
        border-bottom: 1px solid #E2E8F0;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .kategori-table td {
        padding: 16px 24px;
        border-bottom: 1px solid #F1F5F9;
        font-size: 13.5px;
        color: #1E293B;
        vertical-align: middle;
    }

    .kategori-table tbody tr:last-child td {
        border-bottom: none;
    }

    .kategori-table tbody tr:hover td {
        background: #F8FAFC;
    }

    .category-cell-row {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .category-icon-circle {
        width: 34px;
        height: 34px;
        border-radius: 8px;
        background: #F8FAFC;
        color: #0F172A;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        border: 1px solid #E2E8F0;
    }

    .items-count-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        color: #475569;
    }

    .btn-action-pill {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.15s ease;
    }

    .btn-action-pill.edit {
        background: #FFFFFF;
        color: #334155;
        border: 1px solid #E2E8F0;
    }
    .btn-action-pill.edit:hover {
        background: #F8FAFC;
        border-color: #CBD5E1;
        color: #0F172A;
    }

    .btn-action-pill.delete {
        background: #FFFFFF;
        color: #DC2626;
        border: 1px solid #FEE2E2;
    }
    .btn-action-pill.delete:hover {
        background: #FEF2F2;
    }

    .form-group-cat {
        margin-bottom: 14px;
    }

    .form-label-cat {
        display: block;
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 5px;
    }

    .form-control-cat {
        width: 100%;
        box-sizing: border-box;
        padding: 9px 12px;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        font-size: 13px;
        color: #0F172A;
        outline: none;
        font-family: inherit;
        background: #FFFFFF;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .form-control-cat:focus {
        border-color: #0F172A;
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
    }
</style>
@endsection

@section('content')

    <div class="kategori-container">
        <!-- Header -->
        <div class="kategori-header">
            <div class="kategori-title-wrap">
                <h2 class="kategori-title">Kelola Kategori Fasilitas</h2>
                <span class="kategori-badge-total">{{ $kategoris->total() }} Kategori</span>
            </div>
            
            <div class="header-actions">
                <form action="{{ route('admin.kategori.index') }}" method="GET" style="display: flex; gap: 8px;">
                    <div class="search-input-wrap">
                        <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kategori...">
                    </div>
                    @if(request('q'))
                        <a href="{{ route('admin.kategori.index') }}" style="padding: 6px 12px; font-size: 12.5px; color: #64748B; text-decoration: none; align-self: center; font-weight:500;">Reset</a>
                    @endif
                </form>

                <button type="button" class="btn-add-category-glow" onclick="openModal('addCategoryModal')">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Tambah Kategori</span>
                </button>
            </div>
        </div>

        <!-- Table -->
        <div class="kategori-table-wrap">
            <table class="kategori-table">
                <thead>
                    <tr>
                        <th>Nama Kategori</th>
                        <th>Jumlah Alat Terkait</th>
                        <th style="text-align: right; padding-right: 28px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $kat)
                    <tr>
                        <td>
                            <div class="category-cell-row">
                                <div class="category-icon-circle">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                        <line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line>
                                        <circle cx="4" cy="6" r="1.5"></circle><circle cx="4" cy="12" r="1.5"></circle><circle cx="4" cy="18" r="1.5"></circle>
                                    </svg>
                                </div>
                                <span style="font-weight: 600; color: #0F172A; font-size: 13.5px;">{{ $kat->nama_kategori }}</span>
                            </div>
                        </td>
                        <td>
                            <span class="items-count-chip">
                                {{ $kat->barang_count ?? $kat->barangs()->count() }} Alat
                            </span>
                        </td>
                        <td>
                            <div style="display: flex; align-items: center; justify-content: flex-end; gap: 6px; padding-right: 4px;">
                                <button type="button" class="btn-action-pill edit" onclick="openEditCategoryModal({{ $kat->id_kategori }}, '{{ addslashes($kat->nama_kategori) }}')">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                    Edit
                                </button>
                                <form action="{{ route('admin.kategori.destroy', $kat->id_kategori) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus kategori {{ $kat->nama_kategori }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action-pill delete">
                                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: #94A3B8; padding: 40px 20px;">
                            Belum ada kategori fasilitas yang terdaftar.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Kategori -->
    <div id="addCategoryModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">Tambah Kategori Baru</div>
                <button class="modal-close-btn" onclick="closeModal('addCategoryModal')">&times;</button>
            </div>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="form-group-cat">
                    <label class="form-label-cat">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control-cat" placeholder="e.g. Audio Visual, Proyektor, Kamera" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal('addCategoryModal')">Batal</button>
                    <button type="submit" class="btn-submit">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Kategori -->
    <div id="editCategoryModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">Edit Kategori</div>
                <button class="modal-close-btn" onclick="closeModal('editCategoryModal')">&times;</button>
            </div>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group-cat">
                    <label class="form-label-cat">Nama Kategori</label>
                    <input type="text" id="edit_nama_kategori" name="nama_kategori" class="form-control-cat" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal('editCategoryModal')">Batal</button>
                    <button type="submit" class="btn-submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openEditCategoryModal(id, name) {
        document.getElementById('edit_nama_kategori').value = name;
        document.getElementById('editCategoryForm').action = "{{ url('/admin/kategori') }}/" + id;
        openModal('editCategoryModal');
    }
</script>
@endsection
