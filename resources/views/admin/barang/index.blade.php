@extends('layouts.admin')

@section('title', 'Kelola Data Alat & Sarana - SINFAS')
@section('page_title', 'Kelola Data Alat')

@section('styles')
<style>
    /* ─── MINIMALIST CONTAINER ─── */
    .kda-wrap {
        background: #FFFFFF;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.05);
        border: 1px solid #E2E8F0;
        overflow: hidden;
    }

    /* ─── HEADER: TITLE + SEARCH + CTA ─── */
    .kda-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 20px 24px;
        flex-wrap: wrap;
        gap: 16px;
        border-bottom: 1px solid #E2E8F0;
        background: #FFFFFF;
    }

    .kda-title-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .kda-title {
        font-family: 'Outfit', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: #0F172A;
        letter-spacing: -0.2px;
    }

    .kda-badge-total {
        background: #EFF6FF;
        color: #2563EB;
        font-size: 11.5px;
        font-weight: 600;
        padding: 3px 10px;
        border-radius: 6px;
        border: 1px solid #BFDBFE;
    }

    .kda-controls {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    /* Search Bar */
    .search-wrap {
        position: relative;
        width: 250px;
    }

    .search-wrap input {
        width: 100%;
        padding: 8px 14px 8px 38px;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        font-size: 13px;
        color: #0F172A;
        outline: none;
        font-family: inherit;
        background: #FFFFFF;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .search-wrap input:focus {
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

    /* CTA Button - Blue */
    .btn-add-glow {
        background: #2D4E9E;
        color: #FFFFFF;
        border: 1px solid transparent;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        white-space: nowrap;
        transition: background 0.15s ease;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }

    .btn-add-glow:hover {
        background: #243f85;
    }

    /* ─── TABLE ─── */
    .kda-table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .kda-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .kda-table thead tr {
        background: #F8FAFC;
        border-bottom: 1px solid #E2E8F0;
    }

    .kda-table th {
        padding: 12px 20px;
        font-size: 11.5px;
        font-weight: 600;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .kda-table td {
        padding: 14px 20px;
        font-size: 13.5px;
        color: #1E293B;
        border-bottom: 1px solid #F1F5F9;
        vertical-align: middle;
    }

    .kda-table tbody tr:last-child td {
        border-bottom: none;
    }

    .kda-table tbody tr:hover td {
        background: #F0F4FF;
    }

    /* Photo Thumbnail */
    .photo-thumb-wrap {
        width: 42px;
        height: 42px;
        border-radius: 8px;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .photo-thumb-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .code-pill {
        font-family: 'SF Mono', Consolas, monospace;
        font-size: 12px;
        font-weight: 600;
        color: #475569;
        background: #F1F5F9;
        padding: 2px 7px;
        border-radius: 5px;
        border: 1px solid #E2E8F0;
    }

    /* Minimal Stock Chips */
    .stock-chip {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 28px;
        padding: 2px 7px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: 600;
    }
    .stock-chip.baik   { background: #F0FDF4; color: #166534; border: 1px solid #DCFCE7; }
    .stock-chip.kurang { background: #FFFBEB; color: #B45309; border: 1px solid #FEF3C7; }
    .stock-chip.rusak  { background: #FEF2F2; color: #991B1B; border: 1px solid #FEE2E2; }

    /* Minimal Status Badges */
    .status-pill-modern {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 3px 10px;
        border-radius: 999px;
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
    }
    .status-pill-modern.available {
        background: #F0FDF4;
        color: #166534;
        border: 1px solid #DCFCE7;
    }
    .status-pill-modern.unavailable {
        background: #FEF2F2;
        color: #991B1B;
        border: 1px solid #FEE2E2;
    }
    .pulse-dot-small {
        width: 6px;
        height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* Action buttons */
    .actions-wrap-barang {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .btn-edit-pill {
        background: #FFFFFF;
        color: #334155;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        padding: 5px 12px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
        font-family: inherit;
    }
    .btn-edit-pill:hover {
        background: #F8FAFC;
        border-color: #CBD5E1;
        color: #0F172A;
    }

    .btn-delete-pill {
        background: #FFFFFF;
        border: 1px solid #FEE2E2;
        color: #DC2626;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
        cursor: pointer;
        padding: 5px 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: all 0.15s ease;
        font-family: inherit;
    }
    .btn-delete-pill:hover {
        background: #FEF2F2;
    }

    /* ─── PAGINATION ─── */
    .kda-pagination {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 4px;
        padding: 14px 24px;
        border-top: 1px solid #E2E8F0;
        background: #FFFFFF;
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
        transition: all 0.15s ease;
        text-decoration: none;
    }

    .page-btn:hover {
        background: #F8FAFC;
        border-color: #CBD5E1;
        color: #0F172A;
    }

    .page-btn.active {
        background: #0F172A;
        border-color: #0F172A;
        color: #FFFFFF;
        font-weight: 600;
    }

    /* ─── MODAL DIALOGS ─── */
    .modal-add-item {
        background: #FFFFFF;
        border-radius: 14px;
        padding: 24px;
        width: 92%;
        max-width: 560px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(15, 23, 42, 0.1);
        border: 1px solid #E2E8F0;
        position: relative;
    }

    .modal-item-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
        padding-bottom: 12px;
        border-bottom: 1px solid #E2E8F0;
    }

    .modal-item-title {
        font-family: 'Outfit', sans-serif;
        font-size: 17px;
        font-weight: 700;
        color: #0F172A;
        letter-spacing: -0.2px;
    }

    .modal-item-close {
        background: transparent;
        border: none;
        width: 28px;
        height: 28px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #94A3B8;
        cursor: pointer;
        line-height: 1;
        transition: all 0.15s ease;
    }

    .modal-item-close:hover {
        background: #F1F5F9;
        color: #0F172A;
    }

    .item-form-group {
        margin-bottom: 14px;
    }

    .item-form-label {
        display: block;
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 5px;
    }

    .item-form-input,
    .item-form-select {
        width: 100%;
        box-sizing: border-box;
        border: 1px solid #CBD5E1;
        border-radius: 8px;
        padding: 8px 12px;
        font-size: 13px;
        color: #0F172A;
        outline: none;
        background: #FFFFFF;
        font-family: inherit;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .item-form-input:focus,
    .item-form-select:focus {
        border-color: #0F172A;
        box-shadow: 0 0 0 3px rgba(15, 23, 42, 0.08);
    }

    .item-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .item-modal-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
        padding-top: 14px;
        border-top: 1px solid #E2E8F0;
    }

    .btn-item-cancel {
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        color: #475569;
        border-radius: 6px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.15s ease;
    }

    .btn-item-cancel:hover {
        background: #F8FAFC;
        border-color: #CBD5E1;
        color: #0F172A;
    }

    .btn-item-save {
        background: #0F172A;
        border: 1px solid transparent;
        color: #FFFFFF;
        border-radius: 6px;
        padding: 8px 18px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: background 0.15s ease;
    }

    .btn-item-save:hover {
        background: #1E293B;
    }

    /* ─── RESPONSIVE RULES (MOBILE) ─── */
    @media (max-width: 768px) {
        .kda-header {
            flex-direction: column;
            align-items: stretch;
            gap: 14px;
            padding: 16px 14px;
        }

        .kda-title-wrap {
            justify-content: space-between;
        }

        .kda-controls {
            flex-direction: column;
            align-items: stretch;
            width: 100%;
            gap: 10px;
        }

        .kda-controls form {
            width: 100%;
        }

        .search-wrap {
            width: 100%;
        }

        .btn-add-glow {
            justify-content: center;
            width: 100%;
        }

        .kda-pagination {
            justify-content: center;
            flex-wrap: wrap;
            padding: 12px 14px;
        }

        .modal-add-item {
            width: calc(100% - 24px);
            margin: 12px;
            padding: 18px 16px;
        }

        .item-grid-2 {
            grid-template-columns: 1fr;
            gap: 10px;
        }
    }
</style>
@endsection

@section('content')

<div class="kda-wrap">

    {{-- ── Header ── --}}
    <div class="kda-header">
        <div class="kda-title-wrap">
            <h2 class="kda-title">Katalog Data Sarana & Alat</h2>
            <span class="kda-badge-total">{{ $barangs->total() }} Total Alat</span>
        </div>

        <div class="kda-controls">
            <form action="{{ route('admin.barang.index') }}" method="GET">
                <div class="search-wrap">
                    <svg class="search-icon" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama atau kode alat...">
                </div>
            </form>

            <button type="button" class="btn-add-glow" onclick="openModal('addItemModal')">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                <span>Tambah Alat</span>
            </button>
        </div>
    </div>

    {{-- ── Table ── --}}
    <div class="kda-table-responsive">
        <table class="kda-table">
            <thead>
                <tr>
                    <th style="width: 60px;">Foto</th>
                    <th style="width: 120px;">Kode</th>
                    <th>Nama Alat</th>
                    <th>Kategori</th>
                    <th>Baik</th>
                    <th>K. Baik</th>
                    <th>R. Berat</th>
                    <th>Ketersediaan</th>
                    <th style="text-align: right; padding-right: 20px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($barangs as $item)
                @php
                    $isAvailable = $item->jumlah_baik > 0;
                    $statusText  = $isAvailable ? 'Tersedia' : 'Tidak Tersedia';
                    $statusClass = $isAvailable ? 'available' : 'unavailable';
                @endphp
                <tr>
                    <td>
                        <div class="photo-thumb-wrap">
                            @if($item->foto)
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_barang }}" class="photo-thumb-img">
                            @else
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="1.8"><rect x="2" y="7" width="20" height="14" rx="2"/><circle cx="12" cy="14" r="3"/><path d="M12 3v4"/><path d="M8 3h8"/></svg>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="code-pill">{{ $item->kode_barang }}</span>
                    </td>
                    <td>
                        <div style="font-weight: 600; color: #0F172A; font-size: 13.5px;">{{ $item->nama_barang }}</div>
                        @if($item->merk_model)
                            <div style="font-size: 11.5px; color: #64748B; margin-top: 1px;">Merk: {{ $item->merk_model }}</div>
                        @endif
                    </td>
                    <td>
                        <span style="display:inline-block; background:#F8FAFC; border:1px solid #E2E8F0; padding:2px 8px; border-radius:5px; font-size:11.5px; font-weight:500; color:#475569;">
                            {{ $item->kategori->nama_kategori ?? '-' }}
                        </span>
                    </td>
                    <td>
                        <span class="stock-chip baik">{{ $item->jumlah_baik }}</span>
                    </td>
                    <td>
                        <span class="stock-chip kurang">{{ $item->jumlah_kurang_baik }}</span>
                    </td>
                    <td>
                        <span class="stock-chip rusak">{{ $item->jumlah_rusak_berat }}</span>
                    </td>
                    <td>
                        <span class="status-pill-modern {{ $statusClass }}">
                            <span class="pulse-dot-small"></span>
                            {{ $statusText }}
                        </span>
                    </td>
                    <td>
                        <div class="actions-wrap-barang" style="justify-content: flex-end; padding-right: 4px;">
                            <button type="button" class="btn-edit-pill" onclick='openEditModal(@json($item))'>
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 20h9"></path><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"></path></svg>
                                Edit
                            </button>
                            <form action="{{ route('admin.barang.destroy', $item->kode_barang) }}" method="POST"
                                style="display:inline;" onsubmit="return confirm('Hapus alat {{ addslashes($item->nama_barang) }} dari sistem?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-delete-pill">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="text-align:center; color:#94A3B8; padding:40px 20px;">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="opacity:0.35; margin:0 auto 10px; display:block;">
                            <rect x="2" y="7" width="20" height="14" rx="2"/><circle cx="12" cy="14" r="3"/>
                        </svg>
                        Tidak ada data sarana atau alat yang cocok dengan pencarian Anda.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ── Pagination ── --}}
    <div class="kda-pagination">
        @if($barangs->onFirstPage())
            <span class="page-btn" style="opacity:.4;cursor:default;">Prev</span>
        @else
            <a class="page-btn" href="{{ $barangs->previousPageUrl() }}">Prev</a>
        @endif

        @for($p = 1; $p <= $barangs->lastPage(); $p++)
            <a class="page-btn {{ $p == $barangs->currentPage() ? 'active' : '' }}"
               href="{{ $barangs->url($p) }}">{{ $p }}</a>
        @endfor

        @if($barangs->hasMorePages())
            <a class="page-btn" href="{{ $barangs->nextPageUrl() }}">Next</a>
        @else
            <span class="page-btn" style="opacity:.4;cursor:default;">Next</span>
        @endif
    </div>
</div>

{{-- ── Modal: Add Item ── --}}
<div id="addItemModal" class="modal-overlay">
    <div class="modal-add-item">
        <div class="modal-item-header">
            <div class="modal-item-title">Tambah Sarana / Alat Baru</div>
            <button type="button" class="modal-item-close" onclick="closeModal('addItemModal')">&times;</button>
        </div>

        <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nama Barang -->
            <div class="item-form-group">
                <label class="item-form-label">Nama Barang / Alat</label>
                <input type="text" name="nama_barang" class="item-form-input" placeholder="Contoh: Proyektor Epson X300 / Kamera DSLR" required>
            </div>

            <!-- Kategori -->
            <div class="item-form-group">
                <label class="item-form-label">Kategori</label>
                <select name="id_kategori" class="item-form-select" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Foto Barang -->
            <div class="item-form-group">
                <label class="item-form-label">Foto Alat / Sarana (Opsional)</label>
                <input type="file" name="foto" class="item-form-input" accept="image/*" onchange="previewItemPhoto(this, 'addPhotoPreview', 'addPhotoImg')">
                <div id="addPhotoPreview" style="display:none; margin-top:10px;">
                    <img id="addPhotoImg" src="" alt="Preview Foto" style="max-height: 100px; border-radius: 8px; border: 1px solid #E2E8F0;">
                </div>
            </div>

            <!-- Merk/Model -->
            <div class="item-form-group">
                <label class="item-form-label">Merk / Model</label>
                <input type="text" name="merk_model" class="item-form-input" placeholder="Contoh: Sony, Epson, Logitech">
            </div>

            <!-- No Seri Pabrik & Ukuran/Dimensi -->
            <div class="item-grid-2 item-form-group">
                <div>
                    <label class="item-form-label">No Seri Pabrik</label>
                    <input type="text" name="no_seri_pabrik" class="item-form-input" placeholder="Contoh: SN1294819">
                </div>
                <div>
                    <label class="item-form-label">Ukuran / Dimensi</label>
                    <input type="text" name="ukuran_dimensi" class="item-form-input" placeholder="Contoh: 30×20×10 cm">
                </div>
            </div>

            <!-- Bahan & Tahun Pembelian -->
            <div class="item-grid-2 item-form-group">
                <div>
                    <label class="item-form-label">Bahan</label>
                    <input type="text" name="bahan" class="item-form-input" placeholder="Contoh: Plastik / Alumunium">
                </div>
                <div>
                    <label class="item-form-label">Tahun Pembelian</label>
                    <input type="number" name="tahun_pembelian" class="item-form-input" placeholder="Contoh: 2024" min="1900" max="{{ date('Y') + 1 }}">
                </div>
            </div>

            <!-- Kondisi Fisik Stok -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;" class="item-form-group">
                <div>
                    <label class="item-form-label" style="color: #166534;">Jumlah Baik</label>
                    <input type="number" name="jumlah_baik" class="item-form-input" value="0" min="0" required>
                </div>
                <div>
                    <label class="item-form-label" style="color: #B45309;">Kurang Baik</label>
                    <input type="number" name="jumlah_kurang_baik" class="item-form-input" value="0" min="0">
                </div>
                <div>
                    <label class="item-form-label" style="color: #991B1B;">Rusak Berat</label>
                    <input type="number" name="jumlah_rusak_berat" class="item-form-input" value="0" min="0">
                </div>
            </div>

            <!-- Keterangan -->
            <div class="item-form-group">
                <label class="item-form-label">Keterangan Tambahan</label>
                <input type="text" name="keterangan" class="item-form-input" placeholder="Contoh: Tersedia di Lemari Lab 2">
            </div>

            <!-- Footer: Cancel & Save -->
            <div class="item-modal-footer">
                <button type="button" class="btn-item-cancel" onclick="closeModal('addItemModal')">Batal</button>
                <button type="submit" class="btn-item-save">Simpan Alat</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Modal: Edit Item ── --}}
<div id="editItemModal" class="modal-overlay">
    <div class="modal-add-item">
        <div class="modal-item-header">
            <div class="modal-item-title">Edit Data Alat</div>
            <button type="button" class="modal-item-close" onclick="closeModal('editItemModal')">&times;</button>
        </div>

        <form id="editItemForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama Barang -->
            <div class="item-form-group">
                <label class="item-form-label">Nama Barang / Alat</label>
                <input type="text" id="edit_nama_barang" name="nama_barang" class="item-form-input" required>
            </div>

            <!-- Kategori -->
            <div class="item-form-group">
                <label class="item-form-label">Kategori</label>
                <select id="edit_id_kategori" name="id_kategori" class="item-form-select" required>
                    <option value="" disabled>Pilih Kategori</option>
                    @foreach($kategoris as $k)
                        <option value="{{ $k->id_kategori }}">{{ $k->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Foto Barang -->
            <div class="item-form-group">
                <label class="item-form-label">Foto Alat / Sarana</label>
                <div id="editCurrentPhotoBox" style="display:none; margin-bottom:10px;">
                    <span style="font-size:11.5px; color:#64748B; display:block; margin-bottom:4px;">Foto Saat Ini:</span>
                    <img id="editCurrentPhotoImg" src="" alt="Foto Saat Ini" style="max-height: 90px; border-radius: 8px; border: 1px solid #E2E8F0;">
                </div>
                <input type="file" name="foto" class="item-form-input" accept="image/*" onchange="previewItemPhoto(this, 'editNewPhotoPreview', 'editNewPhotoImg')">
                <div id="editNewPhotoPreview" style="display:none; margin-top:10px;">
                    <span style="font-size:11.5px; color:#166534; font-weight:600; display:block; margin-bottom:4px;">Foto Baru Terpilih:</span>
                    <img id="editNewPhotoImg" src="" alt="Foto Baru" style="max-height: 90px; border-radius: 8px; border: 1px solid #BBF7D0;">
                </div>
            </div>

            <!-- Merk/Model -->
            <div class="item-form-group">
                <label class="item-form-label">Merk / Model</label>
                <input type="text" id="edit_merk_model" name="merk_model" class="item-form-input">
            </div>

            <!-- No Seri Pabrik & Ukuran/Dimensi -->
            <div class="item-grid-2 item-form-group">
                <div>
                    <label class="item-form-label">No Seri Pabrik</label>
                    <input type="text" id="edit_no_seri_pabrik" name="no_seri_pabrik" class="item-form-input">
                </div>
                <div>
                    <label class="item-form-label">Ukuran / Dimensi</label>
                    <input type="text" id="edit_ukuran_dimensi" name="ukuran_dimensi" class="item-form-input">
                </div>
            </div>

            <!-- Bahan & Tahun Pembelian -->
            <div class="item-grid-2 item-form-group">
                <div>
                    <label class="item-form-label">Bahan</label>
                    <input type="text" id="edit_bahan" name="bahan" class="item-form-input">
                </div>
                <div>
                    <label class="item-form-label">Tahun Pembelian</label>
                    <input type="number" id="edit_tahun_pembelian" name="tahun_pembelian" class="item-form-input" min="1900" max="{{ date('Y') + 1 }}">
                </div>
            </div>

            <!-- Kondisi Fisik Stok -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;" class="item-form-group">
                <div>
                    <label class="item-form-label" style="color: #166534;">Jumlah Baik</label>
                    <input type="number" id="edit_jumlah_baik" name="jumlah_baik" class="item-form-input" min="0" required>
                </div>
                <div>
                    <label class="item-form-label" style="color: #B45309;">Kurang Baik</label>
                    <input type="number" id="edit_jumlah_kurang_baik" name="jumlah_kurang_baik" class="item-form-input" min="0">
                </div>
                <div>
                    <label class="item-form-label" style="color: #991B1B;">Rusak Berat</label>
                    <input type="number" id="edit_jumlah_rusak_berat" name="jumlah_rusak_berat" class="item-form-input" min="0">
                </div>
            </div>

            <!-- Keterangan -->
            <div class="item-form-group">
                <label class="item-form-label">Keterangan</label>
                <input type="text" id="edit_keterangan" name="keterangan" class="item-form-input">
            </div>

            <!-- Footer: Cancel & Save -->
            <div class="item-modal-footer">
                <button type="button" class="btn-item-cancel" onclick="closeModal('editItemModal')">Batal</button>
                <button type="submit" class="btn-item-save">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function previewItemPhoto(input, previewId, imgId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(imgId).src = e.target.result;
                document.getElementById(previewId).style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

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

        if (item.foto) {
            document.getElementById('editCurrentPhotoImg').src = "{{ asset('storage') }}/" + item.foto;
            document.getElementById('editCurrentPhotoBox').style.display = 'block';
        } else {
            document.getElementById('editCurrentPhotoBox').style.display = 'none';
        }
        document.getElementById('editNewPhotoPreview').style.display = 'none';

        openModal('editItemModal');
    }
</script>
@endsection
