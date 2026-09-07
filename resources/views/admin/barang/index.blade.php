@extends('layouts.admin')

@section('title', 'Kelola data alat')
@section('page_title', 'Kelola data alat')

@section('styles')
<style>
    .items-container {
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        border: 1px solid #F1F5F9;
        overflow: hidden;
    }

    .items-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .items-title {
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
        transition: border 0.2s;
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

    .btn-add-item {
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

    .btn-add-item:hover {
        background: #1E40AF;
    }

    /* Table */
    .items-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .items-table th {
        background: #FAFAFA;
        color: #64748B;
        font-size: 13px;
        font-weight: 500;
        padding: 14px 24px;
        border-top: 1px solid #F1F5F9;
        border-bottom: 1px solid #F1F5F9;
    }

    .items-table td {
        padding: 16px 24px;
        border-bottom: 1px solid #F8FAFC;
        font-size: 14px;
        color: #1E293B;
        vertical-align: middle;
    }

    .badge-condition {
        display: inline-block;
        padding: 3px 10px;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 500;
    }

    .badge-condition.tersedia {
        background: #DCFCE7;
        color: #15803D;
    }

    .badge-condition.perawatan {
        background: #FEF3C7;
        color: #B45309;
    }

    .btn-action-text {
        background: none;
        border: none;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        padding: 2px 6px;
        border-radius: 4px;
        text-decoration: none;
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
        margin-bottom: 14px;
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

    <div class="items-container">
        <!-- Header: Search & Add Item Button -->
        <div class="items-header">
            <h2 class="items-title">Kelola data alat</h2>
            
            <div class="header-actions">
                <form action="{{ route('admin.barang.index') }}" method="GET" style="display: flex; gap: 8px;">
                    <div class="search-input-wrap">
                        <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau kode alat...">
                    </div>
                    @if(request('q'))
                        <a href="{{ route('admin.barang.index') }}" style="padding: 8px 12px; font-size: 13px; color: #64748B; text-decoration: none; align-self: center;">Reset</a>
                    @endif
                </form>

                <button type="button" class="btn-add-item" onclick="openModal('addItemModal')">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>+ Tambah Alat</span>
                </button>
            </div>
        </div>

        <!-- Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>Kode Barang</th>
                    <th>Kategori</th>
                    <th>Stok</th>
                    <th>Di Pakai</th>
                    <th>Kondisi</th>
                    <th style="text-align: right; padding-right: 32px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $item)
                @php
                    $totalStok = $item->jumlah_baik + $item->jumlah_kurang_baik + $item->jumlah_rusak_berat;
                    $diPakai = $item->dipinjam_count ?? 0;
                    $statusText = ($item->jumlah_baik > 0) ? 'Tersedia' : 'Dalam Perawatan';
                    $badgeClass = ($item->jumlah_baik > 0) ? 'tersedia' : 'perawatan';
                @endphp
                <tr>
                    <td style="font-weight: 500; color: #0F172A;">
                        <div>{{ $item->nama_barang }}</div>
                        <div style="font-size: 12px; color: #64748B;">{{ $item->kode_barang }}</div>
                    </td>
                    <td style="color: #475569;">
                        {{ $item->kategori->nama_kategori ?? '-' }}
                    </td>
                    <td style="font-weight: 600;">
                        {{ $totalStok }}
                    </td>
                    <td style="font-weight: 600; color: #1D4ED8;">
                        {{ $diPakai }}
                    </td>
                    <td>
                        <span class="badge-condition {{ $badgeClass }}">
                            {{ $statusText }}
                        </span>
                    </td>
                    <td style="text-align: right; padding-right: 28px;">
                        <button type="button" class="btn-action-text edit" onclick='openEditModal(@json($item))'>Edit</button>
                        <form action="{{ route('admin.barang.destroy', $item->kode_barang) }}" method="POST" style="display: inline;" onsubmit="return confirm('Hapus barang ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action-text delete">Hapus</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; color: #94A3B8; padding: 28px;">
                        Tidak ada data alat ditemukan.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination -->
        <div style="padding: 16px 24px; display: flex; justify-content: flex-end;">
            {{ $barangs->links() }}
        </div>
    </div>

    <!-- Modal: Tambah Alat -->
    <div id="addItemModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">Tambah Alat</div>
                <button class="modal-close-btn" onclick="closeModal('addItemModal')">&times;</button>
            </div>
            <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Proyektor Epson X300" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select name="id_kategori" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">Total Unit Baik</label>
                        <input type="number" name="jumlah_baik" class="form-control" value="1" min="0" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Total Unit Rusak</label>
                        <input type="number" name="jumlah_rusak_berat" class="form-control" value="0" min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Merk / Model</label>
                    <input type="text" name="merk_model" class="form-control" placeholder="Contoh: Epson EB-X300">
                </div>

                <div class="form-group">
                    <label class="form-label">Keterangan / Spesifikasi</label>
                    <textarea name="keterangan" class="form-control" rows="3" placeholder="Deskripsi kondisi atau kelengkapan..."></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal('addItemModal')">Batal</button>
                    <button type="submit" class="btn-submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal: Edit Alat -->
    <div id="editItemModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">Edit Alat</div>
                <button class="modal-close-btn" onclick="closeModal('editItemModal')">&times;</button>
            </div>
            <form id="editItemForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" id="edit_nama_barang" name="nama_barang" class="form-control" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Kategori</label>
                    <select id="edit_id_kategori" name="id_kategori" class="form-control" required>
                        @foreach($kategoris as $k)
                            <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                        @endforeach
                    </select>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
                    <div class="form-group">
                        <label class="form-label">Unit Kondisi Baik</label>
                        <input type="number" id="edit_jumlah_baik" name="jumlah_baik" class="form-control" min="0" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Unit Rusak</label>
                        <input type="number" id="edit_jumlah_rusak_berat" name="jumlah_rusak_berat" class="form-control" min="0">
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Merk / Model</label>
                    <input type="text" id="edit_merk_model" name="merk_model" class="form-control">
                </div>

                <div class="form-group">
                    <label class="form-label">Keterangan</label>
                    <textarea id="edit_keterangan" name="keterangan" class="form-control" rows="3"></textarea>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal('editItemModal')">Batal</button>
                    <button type="submit" class="btn-submit">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openEditModal(item) {
        document.getElementById('edit_nama_barang').value = item.nama_barang;
        document.getElementById('edit_id_kategori').value = item.id_kategori;
        document.getElementById('edit_jumlah_baik').value = item.jumlah_baik;
        document.getElementById('edit_jumlah_rusak_berat').value = item.jumlah_rusak_berat;
        document.getElementById('edit_merk_model').value = item.merk_model || '';
        document.getElementById('edit_keterangan').value = item.keterangan || '';
        
        document.getElementById('editItemForm').action = "{{ url('/admin/barang') }}/" + item.kode_barang;
        openModal('editItemModal');
    }
</script>
@endsection
