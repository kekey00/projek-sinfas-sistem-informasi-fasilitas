@extends('layouts.admin')

@section('title', 'Kelola Data Alat')
@section('page_title', 'Kelola data alat')

@section('styles')
<style>
    /* ── Page wrapper (Gaya Card Login) ── */
    .kda-wrap {
        background: #FFFFFF;
        border-radius: 16px;
        box-shadow: 0 8px 30px rgba(44, 74, 124, 0.09);
        border: 2.5px solid #3B5998;
        overflow: hidden;
    }

    /* ── Header: judul + search + tombol ── */
    .kda-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 22px 24px 16px;
        flex-wrap: wrap;
        gap: 14px;
        border-bottom: 1.5px solid #EEF2F6;
    }

    .kda-title {
        font-family: 'Gorditas', cursive;
        font-size: 18px;
        font-weight: 700;
        color: #0F172A;
        letter-spacing: 0.3px;
    }

    .kda-controls {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    /* Search */
    .search-wrap {
        position: relative;
        width: 250px;
    }

    .search-wrap input {
        width: 100%;
        padding: 9px 14px 9px 38px;
        border: 2px solid #3B5998;
        border-radius: 9px;
        font-size: 13.5px;
        color: #1E293B;
        outline: none;
        font-family: 'Poppins', sans-serif;
        background: #FFFFFF;
        transition: all .2s;
    }

    .search-wrap input:focus {
        border-color: #5B8DEF;
        box-shadow: 0 0 8px rgba(91, 141, 239, 0.35);
    }

    .search-icon {
        position: absolute;
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        color: #3B5998;
        pointer-events: none;
    }

    /* Add Item button (Sama dengan tombol Login) */
    .btn-add {
        background: linear-gradient(to right, #7BA7D9, #2C4A7C);
        color: #FFFFFF;
        border: none;
        border-radius: 9px;
        padding: 9px 20px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        font-family: 'Gorditas', 'Poppins', sans-serif;
        white-space: nowrap;
        transition: all .25s ease;
        box-shadow: 0 4px 12px rgba(44, 74, 124, 0.22);
        letter-spacing: 0.3px;
    }

    .btn-add:hover {
        transform: scale(1.02);
        filter: brightness(1.08);
        box-shadow: 0 6px 16px rgba(44, 74, 124, 0.32);
    }

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

    /* ── Modal Add / Edit Item (Persis Screenshot 1:1) ── */
    .modal-add-item {
        background: #FFFFFF;
        border-radius: 12px;
        padding: 24px 28px;
        width: 90%;
        max-width: 520px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.16);
        border: 1px solid #E5E7EB;
        position: relative;
        max-height: 90vh;
        overflow-y: auto;
    }

    .modal-item-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .modal-item-title {
        font-size: 18px;
        font-weight: 700;
        color: #111827;
        font-family: 'Poppins', sans-serif;
    }

    .modal-item-close {
        background: none;
        border: none;
        font-size: 24px;
        color: #9CA3AF;
        cursor: pointer;
        line-height: 1;
        transition: color .15s;
    }

    .modal-item-close:hover {
        color: #111827;
    }

    .item-form-group {
        margin-bottom: 14px;
    }

    .item-form-label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #4B5563;
        margin-bottom: 6px;
        font-family: 'Poppins', sans-serif;
    }

    .item-form-input,
    .item-form-select {
        width: 100%;
        border: 1px solid #D1D5DB;
        border-radius: 8px;
        padding: 9px 14px;
        font-size: 13.5px;
        color: #1F2937;
        outline: none;
        background: #FFFFFF;
        font-family: 'Poppins', sans-serif;
        transition: border-color .15s, box-shadow .15s;
    }

    .item-form-input::placeholder {
        color: #9CA3AF;
    }

    .item-form-input:focus,
    .item-form-select:focus {
        border-color: #2563EB;
        box-shadow: 0 0 0 2px rgba(37, 99, 235, 0.15);
    }

    .item-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .item-modal-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 22px;
        padding-top: 8px;
    }

    .btn-item-cancel {
        background: #FFFFFF;
        border: 1px solid #D1D5DB;
        color: #4B5563;
        border-radius: 8px;
        padding: 8px 18px;
        font-size: 13.5px;
        font-weight: 500;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        transition: background .15s;
    }

    .btn-item-cancel:hover {
        background: #F9FAFB;
    }

    .btn-item-save {
        background: #1D4ED8;
        border: none;
        color: #FFFFFF;
        border-radius: 8px;
        padding: 8px 24px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        font-family: 'Poppins', sans-serif;
        transition: background .15s;
    }

    .btn-item-save:hover {
        background: #1E40AF;
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

{{-- ── Modal: Add Item (Sesuai Screenshot 1:1) ── --}}
<div id="addItemModal" class="modal-overlay">
    <div class="modal-add-item">
        <div class="modal-item-header">
            <div class="modal-item-title">Add Item</div>
            <button type="button" class="modal-item-close" onclick="closeModal('addItemModal')">&times;</button>
        </div>

        <form action="{{ route('admin.barang.store') }}" method="POST">
            @csrf

            <!-- Nama Barang -->
            <div class="item-form-group">
                <label class="item-form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="item-form-input" placeholder="e.g. Projector Epson X300" required>
            </div>

            <!-- Kategori -->
            <div class="item-form-group">
                <label class="item-form-label">Kategori</label>
                <select name="id_kategori" class="item-form-select" required>
                    <option value="" disabled selected>Select category</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Merk/Model -->
            <div class="item-form-group">
                <label class="item-form-label">Merk/Model</label>
                <input type="text" name="merk_model" class="item-form-input" placeholder="e.g. Epson">
            </div>

            <!-- No Seri Pabrik & Ukuran/Dimensi -->
            <div class="item-grid-2 item-form-group">
                <div>
                    <label class="item-form-label">No Seri Pabrik</label>
                    <input type="text" name="no_seri_pabrik" class="item-form-input" placeholder="e.g. SN1294819">
                </div>
                <div>
                    <label class="item-form-label">Ukuran/Dimensi</label>
                    <input type="text" name="ukuran_dimensi" class="item-form-input" placeholder="e.g. 30×20×10 cm">
                </div>
            </div>

            <!-- Bahan & Tahun Pembelian -->
            <div class="item-grid-2 item-form-group">
                <div>
                    <label class="item-form-label">Bahan</label>
                    <input type="text" name="bahan" class="item-form-input" placeholder="e.g. Plastik/Alumunium">
                </div>
                <div>
                    <label class="item-form-label">Tahun Pembelian</label>
                    <input type="number" name="tahun_pembelian" class="item-form-input" placeholder="e.g. 2023" min="1900" max="{{ date('Y') + 1 }}">
                </div>
            </div>

            <!-- Jumlah Baik -->
            <div class="item-form-group">
                <label class="item-form-label">Jumlah Baik</label>
                <input type="number" name="jumlah_baik" class="item-form-input" value="0" min="0" required>
            </div>

            <!-- Jumlah Kurang Baik -->
            <div class="item-form-group">
                <label class="item-form-label">Jumlah Kurang Baik</label>
                <input type="number" name="jumlah_kurang_baik" class="item-form-input" value="0" min="0">
            </div>

            <!-- Jumlah Rusak Berat -->
            <div class="item-form-group">
                <label class="item-form-label">Jumlah Rusak Berat</label>
                <input type="number" name="jumlah_rusak_berat" class="item-form-input" value="0" min="0">
            </div>

            <!-- Keterangan -->
            <div class="item-form-group">
                <label class="item-form-label">Keterangan</label>
                <input type="text" name="keterangan" class="item-form-input">
            </div>

            <!-- Footer: Cancel & Save -->
            <div class="item-modal-footer">
                <button type="button" class="btn-item-cancel" onclick="closeModal('addItemModal')">Cancel</button>
                <button type="submit" class="btn-item-save">Save</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Modal: Edit Item (Persis Screenshot 1:1) ── --}}
<div id="editItemModal" class="modal-overlay">
    <div class="modal-add-item">
        <div class="modal-item-header">
            <div class="modal-item-title">Edit Item</div>
            <button type="button" class="modal-item-close" onclick="closeModal('editItemModal')">&times;</button>
        </div>

        <form id="editItemForm" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama Barang -->
            <div class="item-form-group">
                <label class="item-form-label">Nama Barang</label>
                <input type="text" id="edit_nama_barang" name="nama_barang" class="item-form-input" placeholder="e.g. Projector Epson X300" required>
            </div>

            <!-- Kategori -->
            <div class="item-form-group">
                <label class="item-form-label">Kategori</label>
                <select id="edit_id_kategori" name="id_kategori" class="item-form-select" required>
                    <option value="" disabled>Select category</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Merk/Model -->
            <div class="item-form-group">
                <label class="item-form-label">Merk/Model</label>
                <input type="text" id="edit_merk_model" name="merk_model" class="item-form-input" placeholder="e.g. Epson">
            </div>

            <!-- No Seri Pabrik & Ukuran/Dimensi -->
            <div class="item-grid-2 item-form-group">
                <div>
                    <label class="item-form-label">No Seri Pabrik</label>
                    <input type="text" id="edit_no_seri_pabrik" name="no_seri_pabrik" class="item-form-input" placeholder="e.g. SN1294819">
                </div>
                <div>
                    <label class="item-form-label">Ukuran/Dimensi</label>
                    <input type="text" id="edit_ukuran_dimensi" name="ukuran_dimensi" class="item-form-input" placeholder="e.g. 30×20×10 cm">
                </div>
            </div>

            <!-- Bahan & Tahun Pembelian -->
            <div class="item-grid-2 item-form-group">
                <div>
                    <label class="item-form-label">Bahan</label>
                    <input type="text" id="edit_bahan" name="bahan" class="item-form-input" placeholder="e.g. Plastik/Alumunium">
                </div>
                <div>
                    <label class="item-form-label">Tahun Pembelian</label>
                    <input type="number" id="edit_tahun_pembelian" name="tahun_pembelian" class="item-form-input" placeholder="e.g. 2023" min="1900" max="{{ date('Y') + 1 }}">
                </div>
            </div>

            <!-- Jumlah Baik -->
            <div class="item-form-group">
                <label class="item-form-label">Jumlah Baik</label>
                <input type="number" id="edit_jumlah_baik" name="jumlah_baik" class="item-form-input" min="0" required>
            </div>

            <!-- Jumlah Kurang Baik -->
            <div class="item-form-group">
                <label class="item-form-label">Jumlah Kurang Baik</label>
                <input type="number" id="edit_jumlah_kurang_baik" name="jumlah_kurang_baik" class="item-form-input" min="0">
            </div>

            <!-- Jumlah Rusak Berat -->
            <div class="item-form-group">
                <label class="item-form-label">Jumlah Rusak Berat</label>
                <input type="number" id="edit_jumlah_rusak_berat" name="jumlah_rusak_berat" class="item-form-input" min="0">
            </div>

            <!-- Keterangan -->
            <div class="item-form-group">
                <label class="item-form-label">Keterangan</label>
                <input type="text" id="edit_keterangan" name="keterangan" class="item-form-input">
            </div>

            <!-- Footer: Cancel & Save -->
            <div class="item-modal-footer">
                <button type="button" class="btn-item-cancel" onclick="closeModal('editItemModal')">Cancel</button>
                <button type="submit" class="btn-item-save">Save</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function openEditModal(item) {
        document.getElementById('edit_nama_barang').value        = item.nama_barang || '';
        document.getElementById('edit_id_kategori').value        = item.id_kategori || '';
        document.getElementById('edit_merk_model').value         = item.merk_model || '';
        document.getElementById('edit_no_seri_pabrik').value     = item.no_seri_pabrik || '';
        document.getElementById('edit_ukuran_dimensi').value     = item.ukuran_dimensi || '';
        document.getElementById('edit_bahan').value              = item.bahan || '';
        document.getElementById('edit_tahun_pembelian').value    = item.tahun_pembelian || '';
        document.getElementById('edit_jumlah_baik').value        = item.jumlah_baik ?? 0;
        document.getElementById('edit_jumlah_kurang_baik').value = item.jumlah_kurang_baik ?? 0;
        document.getElementById('edit_jumlah_rusak_berat').value = item.jumlah_rusak_berat ?? 0;
        document.getElementById('edit_keterangan').value         = item.keterangan || '';
        document.getElementById('editItemForm').action           = "{{ url('/admin/barang') }}/" + item.kode_barang;
        openModal('editItemModal');
    }
</script>
@endsection
