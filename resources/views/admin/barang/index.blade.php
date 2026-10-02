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

    /* ─── MODAL DIALOGS (AESTHETIC & MODERN) ─── */
    .modal-add-item {
        background: #FFFFFF;
        border-radius: 18px;
        padding: 26px 28px;
        width: 94%;
        max-width: 580px;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.22), 0 0 0 1px rgba(226, 232, 240, 0.85);
        border: none;
        position: relative;
        transform: translateY(14px) scale(0.98);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .modal-overlay.active .modal-add-item,
    .modal-overlay.open .modal-add-item {
        transform: translateY(0) scale(1);
    }

    /* Custom smooth scrollbar for modal */
    .modal-add-item::-webkit-scrollbar {
        width: 6px;
    }
    .modal-add-item::-webkit-scrollbar-track {
        background: #F8FAFC;
        border-radius: 8px;
    }
    .modal-add-item::-webkit-scrollbar-thumb {
        background: #CBD5E1;
        border-radius: 8px;
    }
    .modal-add-item::-webkit-scrollbar-thumb:hover {
        background: #94A3B8;
    }

    .modal-item-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
        padding-bottom: 14px;
        border-bottom: 1px solid #EEF2F6;
    }

    .modal-item-title-wrap {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .modal-item-title {
        font-family: 'Outfit', sans-serif;
        font-size: 18px;
        font-weight: 700;
        color: #0F172A;
        letter-spacing: -0.2px;
    }

    .modal-item-close {
        background: #F1F5F9;
        border: none;
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 18px;
        color: #64748B;
        cursor: pointer;
        line-height: 1;
        transition: all 0.15s ease;
    }

    .modal-item-close:hover {
        background: #E2E8F0;
        color: #0F172A;
        transform: scale(1.05);
    }

    .item-form-group {
        margin-bottom: 15px;
    }

    .item-form-label {
        display: block;
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }

    .item-form-input,
    .item-form-select,
    .item-form-textarea {
        width: 100%;
        box-sizing: border-box;
        border: 1.5px solid #E2E8F0;
        border-radius: 10px;
        padding: 9.5px 13px;
        font-size: 13.5px;
        color: #0F172A;
        outline: none;
        background: #FAFAFC;
        font-family: inherit;
        transition: all 0.15s ease;
    }

    .item-form-input:focus,
    .item-form-select:focus,
    .item-form-textarea:focus {
        border-color: #2563EB;
        background: #FFFFFF;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
    }

    .item-form-input::placeholder,
    .item-form-textarea::placeholder {
        color: #94A3B8;
        font-size: 13px;
    }

    .item-form-textarea {
        min-height: 82px;
        resize: vertical;
        line-height: 1.5;
    }

    .item-grid-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
    }

    .item-grid-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 12px;
    }

    /* Kondisi Stok Cards */
    .stok-kondisi-card {
        background: #FAFAFC;
        border: 1.5px solid #E2E8F0;
        border-radius: 10px;
        padding: 8px 10px;
        transition: all 0.15s ease;
    }
    .stok-kondisi-card.baik {
        border-color: #BBF7D0;
        background: #F0FDF4;
    }
    .stok-kondisi-card.kurang-baik {
        border-color: #FDE68A;
        background: #FFFBEB;
    }
    .stok-kondisi-card.rusak-berat {
        border-color: #FECDD3;
        background: #FFF1F2;
    }
    .stok-kondisi-card label {
        display: block;
        font-size: 11.5px;
        font-weight: 700;
        margin-bottom: 4px;
    }
    .stok-kondisi-card.baik label { color: #15803D; }
    .stok-kondisi-card.kurang-baik label { color: #B45309; }
    .stok-kondisi-card.rusak-berat label { color: #BE123C; }
    .stok-kondisi-card input {
        border: 1px solid #CBD5E1;
        border-radius: 6px;
        padding: 6px 8px;
        font-size: 14px;
        font-weight: 700;
        width: 100%;
        box-sizing: border-box;
        outline: none;
        background: #FFFFFF;
        text-align: center;
        color: #0F172A;
    }

    /* Photo Upload Box */
    .photo-upload-container {
        border: 1.5px dashed #CBD5E1;
        border-radius: 12px;
        padding: 14px;
        background: #F8FAFC;
        text-align: center;
        transition: all 0.15s ease;
    }
    .photo-upload-container:hover {
        border-color: #2563EB;
        background: #F0F7FF;
    }
    .photo-preview-wrap {
        min-height: 140px;
        max-height: 200px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 12px;
        background: #FFFFFF;
        border-radius: 10px;
        border: 1px solid #E2E8F0;
        overflow: hidden;
        position: relative;
    }
    .photo-preview-wrap img {
        max-height: 180px;
        max-width: 100%;
        object-fit: contain;
        display: block;
    }
    .photo-empty-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 20px;
        color: #94A3B8;
    }
    .photo-empty-placeholder svg {
        margin-bottom: 8px;
        stroke: #CBD5E1;
    }
    .photo-empty-title {
        font-size: 13px;
        font-weight: 600;
        color: #64748B;
        margin-bottom: 2px;
    }
    .photo-empty-sub {
        font-size: 11px;
        color: #94A3B8;
    }
    .btn-choose-photo {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: 100%;
        padding: 9.5px 14px;
        background: #FFFFFF;
        border: 1.5px solid #CBD5E1;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        color: #1E293B;
        cursor: pointer;
        transition: all 0.15s ease;
        box-shadow: 0 1px 2px rgba(15,23,42,0.04);
    }
    .btn-choose-photo:hover {
        background: #EFF6FF;
        border-color: #2563EB;
        color: #2563EB;
    }

    .item-modal-footer {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 22px;
        padding-top: 16px;
        border-top: 1px solid #EEF2F6;
    }

    .btn-item-cancel {
        background: #FFFFFF;
        border: 1.5px solid #CBD5E1;
        color: #475569;
        border-radius: 9px;
        padding: 9px 20px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: all 0.15s ease;
    }

    .btn-item-cancel:hover {
        background: #F8FAFC;
        border-color: #94A3B8;
        color: #0F172A;
    }

    .btn-item-save {
        background: #2563EB;
        border: 1.5px solid transparent;
        color: #FFFFFF;
        border-radius: 9px;
        padding: 9px 24px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        box-shadow: 0 2px 6px rgba(37,99,235,0.25);
        transition: all 0.15s ease;
    }

    .btn-item-save:hover {
        background: #1D4ED8;
        box-shadow: 0 4px 12px rgba(37,99,235,0.35);
        transform: translateY(-1px);
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

        .item-grid-2,
        .item-grid-3 {
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

            <button type="button" class="btn-add-glow" onclick="openAddModal()">
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
                                <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_barang }}" class="photo-thumb-img" onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='inline-block';">
                                <svg style="display:none;" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="1.8"><rect x="2" y="7" width="20" height="14" rx="2"/><circle cx="12" cy="14" r="3"/><path d="M12 3v4"/><path d="M8 3h8"/></svg>
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
            <div class="modal-item-title-wrap">
                <div class="modal-item-title">Tambah Data Barang</div>
            </div>
            <button type="button" class="modal-item-close" onclick="closeModal('addItemModal')">&times;</button>
        </div>

        <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Nama Barang -->
            <div class="item-form-group">
                <label class="item-form-label">Nama Barang</label>
                <input type="text" name="nama_barang" class="item-form-input" placeholder="Masukkan nama barang / alat" required>
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

            <!-- Merk / Model -->
            <div class="item-form-group">
                <label class="item-form-label">Merk / Model</label>
                <input type="text" name="merk_model" class="item-form-input" placeholder="Contoh: Boya BY-WM4 Pro / Sony">
            </div>

            <!-- No Seri Pabrik & Ukuran / Dimensi -->
            <div class="item-grid-2 item-form-group">
                <div>
                    <label class="item-form-label">No Seri Pabrik</label>
                    <input type="text" name="no_seri_pabrik" class="item-form-input" placeholder="Contoh: BY-WM4-0192">
                </div>
                <div>
                    <label class="item-form-label">Ukuran / Dimensi</label>
                    <input type="text" name="ukuran_dimensi" class="item-form-input" placeholder="Contoh: 8 × 3 × 2 cm">
                </div>
            </div>

            <!-- Bahan & Tahun Pembelian -->
            <div class="item-grid-2 item-form-group">
                <div>
                    <label class="item-form-label">Bahan</label>
                    <input type="text" name="bahan" class="item-form-input" placeholder="Contoh: Plastik ABS">
                </div>
                <div>
                    <label class="item-form-label">Tahun Pembelian</label>
                    <input type="number" name="tahun_pembelian" class="item-form-input" placeholder="Contoh: 2023" min="1900" max="{{ date('Y') + 1 }}">
                </div>
            </div>

            <!-- Jumlah Stok & Kondisi -->
            <div class="item-form-group">
                <div class="item-grid-3">
                    <div class="stok-kondisi-card baik">
                        <label>Jumlah Baik</label>
                        <input type="number" name="jumlah_baik" value="0" min="0" required>
                    </div>
                    <div class="stok-kondisi-card kurang-baik">
                        <label>Jumlah K. Baik</label>
                        <input type="number" name="jumlah_kurang_baik" value="0" min="0">
                    </div>
                    <div class="stok-kondisi-card rusak-berat">
                        <label>Jumlah R. Berat</label>
                        <input type="number" name="jumlah_rusak_berat" value="0" min="0">
                    </div>
                </div>
            </div>

            <!-- Keterangan -->
            <div class="item-form-group">
                <label class="item-form-label">Keterangan</label>
                <textarea name="keterangan" class="item-form-textarea" placeholder="Contoh: Termasuk 1 transmitter, 1 receiver, dan hardcase bawaan"></textarea>
            </div>

            <!-- Foto Barang -->
            <div class="item-form-group">
                <label class="item-form-label">Foto Barang</label>
                <div class="photo-upload-container">
                    <div class="photo-preview-wrap">
                        <div id="addPhotoPlaceholder" class="photo-empty-placeholder">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="3" ry="3"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            <span class="photo-empty-title">Pratinjau Foto Barang</span>
                            <span class="photo-empty-sub">Belum ada foto yang dipilih</span>
                        </div>
                        <img id="addPhotoImg" src="" alt="Pratinjau Foto" style="display:none;" onerror="this.style.display='none'; document.getElementById('addPhotoPlaceholder').style.display='flex';">
                    </div>
                    <input type="file" id="add_foto_input" name="foto" accept="image/*" style="display:none;" onchange="previewItemPhoto(this, 'addPhotoImg', 'addPhotoPlaceholder')">
                    <button type="button" class="btn-choose-photo" onclick="document.getElementById('add_foto_input').click()">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                        Pilih file foto
                    </button>
                </div>
            </div>

            <!-- Footer: Cancel & Save -->
            <div class="item-modal-footer">
                <button type="button" class="btn-item-cancel" onclick="closeModal('addItemModal')">Batal</button>
                <button type="submit" class="btn-item-save">Simpan</button>
            </div>
        </form>
    </div>
</div>

{{-- ── Modal: Edit Item ── --}}
<div id="editItemModal" class="modal-overlay">
    <div class="modal-add-item">
        <div class="modal-item-header">
            <div class="modal-item-title-wrap">
                <div class="modal-item-title">Ubah Data Barang</div>
            </div>
            <button type="button" class="modal-item-close" onclick="closeModal('editItemModal')">&times;</button>
        </div>

        <form id="editItemForm" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Nama Barang -->
            <div class="item-form-group">
                <label class="item-form-label">Nama Barang</label>
                <input type="text" id="edit_nama_barang" name="nama_barang" class="item-form-input" placeholder="Masukkan nama barang" required>
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

            <!-- Merk / Model -->
            <div class="item-form-group">
                <label class="item-form-label">Merk / Model</label>
                <input type="text" id="edit_merk_model" name="merk_model" class="item-form-input" placeholder="Contoh: Boya BY-WM4 Pro">
            </div>

            <!-- No Seri Pabrik & Ukuran / Dimensi -->
            <div class="item-grid-2 item-form-group">
                <div>
                    <label class="item-form-label">No Seri Pabrik</label>
                    <input type="text" id="edit_no_seri_pabrik" name="no_seri_pabrik" class="item-form-input" placeholder="Contoh: BY-WM4-0192">
                </div>
                <div>
                    <label class="item-form-label">Ukuran / Dimensi</label>
                    <input type="text" id="edit_ukuran_dimensi" name="ukuran_dimensi" class="item-form-input" placeholder="Contoh: 8 × 3 × 2 cm">
                </div>
            </div>

            <!-- Bahan & Tahun Pembelian -->
            <div class="item-grid-2 item-form-group">
                <div>
                    <label class="item-form-label">Bahan</label>
                    <input type="text" id="edit_bahan" name="bahan" class="item-form-input" placeholder="Contoh: Plastik ABS">
                </div>
                <div>
                    <label class="item-form-label">Tahun Pembelian</label>
                    <input type="number" id="edit_tahun_pembelian" name="tahun_pembelian" class="item-form-input" placeholder="Contoh: 2023" min="1900" max="{{ date('Y') + 1 }}">
                </div>
            </div>

            <!-- Jumlah Stok & Kondisi -->
            <div class="item-form-group">
                <div class="item-grid-3">
                    <div class="stok-kondisi-card baik">
                        <label>Jumlah Baik</label>
                        <input type="number" id="edit_jumlah_baik" name="jumlah_baik" min="0" required>
                    </div>
                    <div class="stok-kondisi-card kurang-baik">
                        <label>Jumlah K. Baik</label>
                        <input type="number" id="edit_jumlah_kurang_baik" name="jumlah_kurang_baik" min="0">
                    </div>
                    <div class="stok-kondisi-card rusak-berat">
                        <label>Jumlah R. Berat</label>
                        <input type="number" id="edit_jumlah_rusak_berat" name="jumlah_rusak_berat" min="0">
                    </div>
                </div>
            </div>

            <!-- Keterangan -->
            <div class="item-form-group">
                <label class="item-form-label">Keterangan</label>
                <textarea id="edit_keterangan" name="keterangan" class="item-form-textarea" placeholder="Contoh: Termasuk 1 transmitter, 1 receiver, dan hardcase bawaan"></textarea>
            </div>

            <!-- Foto Barang -->
            <div class="item-form-group">
                <label class="item-form-label">Foto Barang</label>
                <div class="photo-upload-container">
                    <div class="photo-preview-wrap">
                        <div id="editPhotoPlaceholder" class="photo-empty-placeholder">
                            <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="18" height="18" rx="3" ry="3"></rect>
                                <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                <polyline points="21 15 16 10 5 21"></polyline>
                            </svg>
                            <span class="photo-empty-title">Pratinjau Foto Barang</span>
                            <span class="photo-empty-sub">Belum ada foto yang dipilih</span>
                        </div>
                        <img id="editCurrentPhotoImg" src="" alt="Pratinjau Foto" style="display:none;" onerror="this.style.display='none'; document.getElementById('editPhotoPlaceholder').style.display='flex';">
                    </div>
                    <input type="file" id="edit_foto_input" name="foto" accept="image/*" style="display:none;" onchange="previewItemPhoto(this, 'editCurrentPhotoImg', 'editPhotoPlaceholder')">
                    <button type="button" class="btn-choose-photo" onclick="document.getElementById('edit_foto_input').click()">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="12" y1="8" x2="12" y2="16"></line>
                            <line x1="8" y1="12" x2="16" y2="12"></line>
                        </svg>
                        Pilih file foto
                    </button>
                </div>
            </div>

            <!-- Footer: Cancel & Save -->
            <div class="item-modal-footer">
                <button type="button" class="btn-item-cancel" onclick="closeModal('editItemModal')">Batal</button>
                <button type="submit" class="btn-item-save">Simpan</button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    function previewItemPhoto(input, imgId, placeholderId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.getElementById(imgId);
                var placeholder = document.getElementById(placeholderId);
                img.src = e.target.result;
                img.style.display = 'block';
                if (placeholder) placeholder.style.display = 'none';
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function openAddModal() {
        var form = document.querySelector('#addItemModal form');
        if (form) form.reset();
        var fileInput = document.getElementById('add_foto_input');
        if (fileInput) fileInput.value = '';
        var img = document.getElementById('addPhotoImg');
        var placeholder = document.getElementById('addPhotoPlaceholder');
        if (img) { img.src = ''; img.style.display = 'none'; }
        if (placeholder) { placeholder.style.display = 'flex'; }
        openModal('addItemModal');
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

        var fileInput = document.getElementById('edit_foto_input');
        if (fileInput) fileInput.value = '';

        var img = document.getElementById('editCurrentPhotoImg');
        var placeholder = document.getElementById('editPhotoPlaceholder');

        if (item.foto) {
            img.src = "{{ asset('storage') }}/" + item.foto;
            img.style.display = 'block';
            if (placeholder) placeholder.style.display = 'none';
        } else {
            img.src = '';
            img.style.display = 'none';
            if (placeholder) placeholder.style.display = 'flex';
        }

        openModal('editItemModal');
    }
</script>
@endsection
