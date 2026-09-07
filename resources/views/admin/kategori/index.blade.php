@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('page_title', 'Kelola Kategori')

@section('styles')
<style>
    .kategori-container {
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        border: 1px solid #F1F5F9;
        overflow: hidden;
    }

    .kategori-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .kategori-title {
        font-size: 17px;
        font-weight: 600;
        color: #0F172A;
    }

    .header-actions {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .search-input-wrap {
        position: relative;
        width: 260px;
    }

    .search-input-wrap input {
        width: 100%;
        padding: 8px 14px 8px 36px;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        font-size: 13.5px;
        color: #0F172A;
        outline: none;
    }

    .search-input-wrap input:focus {
        border-color: #1D4ED8;
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #94A3B8;
        pointer-events: none;
    }

    .btn-add-category {
        background: #1D4ED8;
        color: #FFFFFF;
        border: none;
        border-radius: 8px;
        padding: 8px 18px;
        font-size: 13.5px;
        font-weight: 500;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: background 0.2s;
    }

    .btn-add-category:hover {
        background: #1E40AF;
    }

    .kategori-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .kategori-table th {
        background: #FAFAFA;
        color: #64748B;
        font-size: 13px;
        font-weight: 500;
        padding: 14px 24px;
        border-top: 1px solid #F1F5F9;
        border-bottom: 1px solid #F1F5F9;
    }

    .kategori-table td {
        padding: 16px 24px;
        border-bottom: 1px solid #F8FAFC;
        font-size: 14px;
        color: #1E293B;
        vertical-align: middle;
    }

    .btn-action-text {
        background: none;
        border: none;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        padding: 2px 6px;
        border-radius: 4px;
    }

    .btn-action-text.edit {
        color: #1D4ED8;
    }

    .btn-action-text.edit:hover {
        background: #EFF6FF;
    }

    .btn-action-text.delete {
        color: #DC2626;
    }

    .btn-action-text.delete:hover {
        background: #FEF2F2;
    }

    .form-group {
        margin-bottom: 16px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #334155;
        margin-bottom: 6px;
    }

    .form-control {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        font-size: 13.5px;
        color: #0F172A;
        outline: none;
        font-family: inherit;
    }

    .form-control:focus {
        border-color: #1D4ED8;
    }
</style>
@endsection

@section('content')

    <div class="kategori-container">
        <!-- Header -->
        <div class="kategori-header">
            <h2 class="kategori-title">Kelola Kategori</h2>
            
            <div class="header-actions">
                <form action="{{ route('admin.kategori.index') }}" method="GET" style="display: flex; gap: 8px;">
                    <div class="search-input-wrap">
                        <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari kategori...">
                    </div>
                    @if(request('q'))
                        <a href="{{ route('admin.kategori.index') }}" style="padding: 8px 12px; font-size: 13px; color: #64748B; text-decoration: none; align-self: center;">Reset</a>
                    @endif
                </form>

                <button type="button" class="btn-add-category" onclick="openModal('addCategoryModal')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>+ Add Category</span>
                </button>
            </div>
        </div>

        <!-- Table -->
        <table class="kategori-table">
            <thead>
                <tr>
                    <th>Nama Kategori</th>
                    <th>Jumlah Barang</th>
                    <th style="text-align: right; padding-right: 32px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategoris as $kat)
                <tr>
                    <td style="font-weight: 500; color: #0F172A;">
                        {{ $kat->nama_kategori }}
                    </td>
                    <td style="color: #475569; font-weight: 600;">
                        {{ $kat->barang_count ?? $kat->barang()->count() }} Item
                    </td>
                    <td style="text-align: right; padding-right: 28px;">
                        <button type="button" class="btn-action-text edit" onclick="openEditCategoryModal({{ $kat->id_kategori }}, '{{ $kat->nama_kategori }}')">Edit</button>
                        <form action="{{ route('admin.kategori.destroy', $kat->id_kategori) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus kategori {{ $kat->nama_kategori }}?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action-text delete">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center; color: #94A3B8; padding: 28px;">
                        Belum ada kategori yang ditambahkan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Modal Add Category Sesuai Figma -->
    <div id="addCategoryModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">Add Category</div>
                <button class="modal-close-btn" onclick="closeModal('addCategoryModal')">&times;</button>
            </div>
            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="nama_kategori" class="form-control" placeholder="Enter Category Name" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal('addCategoryModal')">Cancel</button>
                    <button type="submit" class="btn-submit">Save</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit Category -->
    <div id="editCategoryModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">Edit Category</div>
                <button class="modal-close-btn" onclick="closeModal('editCategoryModal')">&times;</button>
            </div>
            <form id="editCategoryForm" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" id="edit_nama_kategori" name="nama_kategori" class="form-control" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal('editCategoryModal')">Cancel</button>
                    <button type="submit" class="btn-submit">Save</button>
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
