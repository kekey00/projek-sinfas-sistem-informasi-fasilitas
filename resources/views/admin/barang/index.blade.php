@extends('layouts.admin')

@section('title', 'Kelola Data Alat')
@section('page_title', 'Kelola data alat')

@section('styles')
<style>
    /* ── Page wrapper ── */
    .kda-wrap {
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 1px 4px rgba(0,0,0,.06);
        border: 1px solid #E8ECF0;
        overflow: hidden;
    }

    /* ── Header: judul + search + tombol ── */
    .kda-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px 14px;
        flex-wrap: wrap;
        gap: 14px;
    }

    .kda-title {
        font-size: 16px;
        font-weight: 600;
        color: #0F172A;
    }

    .kda-controls {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Search */
    .search-wrap {
        position: relative;
        width: 240px;
    }

    .search-wrap input {
        width: 100%;
        padding: 8px 14px 8px 36px;
        border: 1px solid #D1D5DB;
        border-radius: 8px;
        font-size: 13.5px;
        color: #1E293B;
        outline: none;
        font-family: 'Poppins', sans-serif;
        background: #FAFAFA;
        transition: border .2s;
    }

    .search-wrap input:focus {
        border-color: #1D4ED8;
        background: #FFFFFF;
    }

    .search-icon {
        position: absolute;
        left: 11px;
        top: 50%;
        transform: translateY(-50%);
        color: #9CA3AF;
        pointer-events: none;
    }

    /* Add Item button */
    .btn-add {
        background: #1D4ED8;
        color: #FFFFFF;
        border: none;
        border-radius: 8px;
        padding: 9px 18px;
        font-size: 13.5px;
        font-weight: 500;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        white-space: nowrap;
        transition: background .2s;
    }

    .btn-add:hover { background: #1E40AF; }

    /* ── Table ── */
    .kda-table {
        width: 100%;
        border-collapse: collapse;
    }

    .kda-table thead tr {
        background: #F8F9FB;
        border-top: 1px solid #EEF0F3;
        border-bottom: 1px solid #EEF0F3;
    }

    .kda-table th {
        padding: 11px 20px;
        font-size: 12.5px;
        font-weight: 600;
        color: #6B7280;
        text-align: left;
    }

    .kda-table td {
        padding: 13px 20px;
        font-size: 13.5px;
        color: #1E293B;
        border-bottom: 1px solid #F3F4F6;
        vertical-align: middle;
    }

    .kda-table tbody tr:last-child td { border-bottom: none; }

    .kda-table tbody tr:hover td { background: #FAFBFF; }

    /* Status badges */
    .status-available {
        color: #16A34A;
        font-weight: 500;
    }

    .status-unavailable {
        color: #DC2626;
        font-weight: 500;
    }

    /* R. Berat merah jika > 0 */
    .rusak-berat-red { color: #DC2626; font-weight: 500; }

    /* Action buttons */
    .btn-edit {
        background: none;
        border: none;
        color: #3B5998;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        padding: 3px 6px;
        font-family: 'Poppins', sans-serif;
        transition: color .15s;
        text-decoration: none;
    }

    .btn-edit:hover { color: #1D4ED8; text-decoration: underline; }

    .btn-delete {
        background: none;
        border: 1.5px solid #EF4444;
        color: #EF4444;
        border-radius: 6px;
        font-size: 12.5px;
        font-weight: 500;
        cursor: pointer;
        padding: 4px 12px;
        font-family: 'Poppins', sans-serif;
        transition: all .15s;
    }

    .btn-delete:hover {
        background: #FEF2F2;
        border-color: #DC2626;
        color: #DC2626;
    }

    /* ── Pagination ── */
    .kda-pagination {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 6px;
        padding: 14px 20px;
    }

    .page-btn {
        min-width: 32px;
        height: 32px;
        padding: 0 10px;
        border: 1px solid #D1D5DB;
        background: #FFFFFF;
        color: #374151;
        border-radius: 6px;
        font-size: 13px;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all .15s;
        text-decoration: none;
    }

    .page-btn:hover { background: #F3F4F6; }

    .page-btn.active {
        background: #1D4ED8;
        border-color: #1D4ED8;
        color: #FFFFFF;
        font-weight: 600;
    }

    /* ── Modal form styles ── */
    .modal-2col {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
    }
</style>
@endsection

@section('content')

<div class="kda-wrap">

    {{-- ── Header ── --}}
    <div class="kda-header">
        <h2 class="kda-title">Kelola data alat</h2>

        <div class="kda-controls">
            <form action="{{ route('admin.barang.index') }}" method="GET">
                <div class="search-wrap">
                    <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2.2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Search Items...">
                </div>
            </form>

            <button type="button" class="btn-add" onclick="openModal('addItemModal')">+ Add Item</button>
        </div>
    </div>

    {{-- ── Table ── --}}
    <table class="kda-table">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Category</th>
                <th>Baik</th>
                <th>K. Baik</th>
                <th>R. Berat</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barangs as $item)
            @php
                $isAvailable = $item->jumlah_baik > 0;
                $statusText  = $isAvailable ? 'Available' : 'Unavailable';
                $statusClass = $isAvailable ? 'status-available' : 'status-unavailable';
            @endphp
            <tr>
                <td style="font-weight: 500; color: #0F172A;">{{ $item->nama_barang }}</td>
                <td style="color: #6B7280;">{{ $item->kategori->nama_kategori ?? '-' }}</td>
                <td>{{ $item->jumlah_baik }}</td>
                <td>{{ $item->jumlah_kurang_baik }}</td>
                <td class="{{ $item->jumlah_rusak_berat > 0 ? 'rusak-berat-red' : '' }}">
                    {{ $item->jumlah_rusak_berat }}
                </td>
                <td>
                    <span class="{{ $statusClass }}">{{ $statusText }}</span>
                </td>
                <td>
                    <button type="button" class="btn-edit" onclick='openEditModal(@json($item))'>Edit</button>
                    <form action="{{ route('admin.barang.destroy', $item->kode_barang) }}" method="POST"
                        style="display:inline;" onsubmit="return confirm('Hapus barang ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center; color:#9CA3AF; padding:32px;">
                    Tidak ada data alat ditemukan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- ── Pagination ── --}}
    <div class="kda-pagination">
        {{-- Prev --}}
        @if($barangs->onFirstPage())
            <span class="page-btn" style="opacity:.45;cursor:default;">Prev</span>
        @else
            <a class="page-btn" href="{{ $barangs->previousPageUrl() }}">Prev</a>
        @endif

        {{-- Nomor halaman --}}
        @for($p = 1; $p <= $barangs->lastPage(); $p++)
            <a class="page-btn {{ $p == $barangs->currentPage() ? 'active' : '' }}"
               href="{{ $barangs->url($p) }}">{{ $p }}</a>
        @endfor

        {{-- Next --}}
        @if($barangs->hasMorePages())
            <a class="page-btn" href="{{ $barangs->nextPageUrl() }}">Next</a>
        @else
            <span class="page-btn" style="opacity:.45;cursor:default;">Next</span>
        @endif
    </div>
</div>

{{-- ── Modal: Tambah Alat ── --}}
<div id="addItemModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-card-top"></div>
        <div class="modal-header">
            <div class="modal-title">Tambah Alat / Barang</div>
            <button class="modal-close-btn" onclick="closeModal('addItemModal')">&times;</button>
        </div>
        <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="form-group">
                <label class="form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control" placeholder="Contoh: Projector Epson X300" required>
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

            <div class="modal-2col">
                <div class="form-group">
                    <label class="form-label">Jumlah Baik</label>
                    <input type="number" name="jumlah_baik" class="form-control" value="1" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Kurang Baik</label>
                    <input type="number" name="jumlah_kurang_baik" class="form-control" value="0" min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Rusak Berat</label>
                    <input type="number" name="jumlah_rusak_berat" class="form-control" value="0" min="0">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Merk / Model</label>
                <input type="text" name="merk_model" class="form-control" placeholder="Contoh: Epson EB-X300">
            </div>

            <div class="form-group">
                <label class="form-label">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2" placeholder="Deskripsi singkat..."></textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('addItemModal')">Batal</button>
                <button type="submit" class="btn-submit">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Modal: Edit Alat ── --}}
<div id="editItemModal" class="modal-overlay">
    <div class="modal-card">
        <div class="modal-card-top"></div>
        <div class="modal-header">
            <div class="modal-title">Edit Alat / Barang</div>
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

            <div class="modal-2col">
                <div class="form-group">
                    <label class="form-label">Jumlah Baik</label>
                    <input type="number" id="edit_jumlah_baik" name="jumlah_baik" class="form-control" min="0" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Kurang Baik</label>
                    <input type="number" id="edit_jumlah_kurang_baik" name="jumlah_kurang_baik" class="form-control" min="0">
                </div>
                <div class="form-group">
                    <label class="form-label">Rusak Berat</label>
                    <input type="number" id="edit_jumlah_rusak_berat" name="jumlah_rusak_berat" class="form-control" min="0">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Merk / Model</label>
                <input type="text" id="edit_merk_model" name="merk_model" class="form-control">
            </div>

            <div class="form-group">
                <label class="form-label">Keterangan</label>
                <textarea id="edit_keterangan" name="keterangan" class="form-control" rows="2"></textarea>
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
        document.getElementById('edit_nama_barang').value        = item.nama_barang;
        document.getElementById('edit_id_kategori').value        = item.id_kategori;
        document.getElementById('edit_jumlah_baik').value        = item.jumlah_baik;
        document.getElementById('edit_jumlah_kurang_baik').value = item.jumlah_kurang_baik ?? 0;
        document.getElementById('edit_jumlah_rusak_berat').value = item.jumlah_rusak_berat ?? 0;
        document.getElementById('edit_merk_model').value         = item.merk_model || '';
        document.getElementById('edit_keterangan').value         = item.keterangan || '';
        document.getElementById('editItemForm').action           = "{{ url('/admin/barang') }}/" + item.kode_barang;
        openModal('editItemModal');
    }
</script>
@endsection
