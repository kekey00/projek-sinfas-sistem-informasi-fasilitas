@extends('layouts.user')

@section('title', 'Mau pinjam apa hari ini? - SINFAS')

@section('styles')
<style>
    /* HERO VIBE BANNER */
    .hero-vibe-box {
        background: linear-gradient(135deg, #312E81 0%, #4338CA 40%, #6366F1 80%, #3B82F6 100%);
        border-radius: 28px;
        padding: 36px 40px;
        color: #fff;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 35px -5px rgba(67, 56, 202, 0.35);
    }

    .hero-vibe-box::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(236, 72, 153, 0.35) 0%, transparent 70%);
        filter: blur(25px);
        pointer-events: none;
    }

    .hero-vibe-box::after {
        content: '';
        position: absolute;
        bottom: -50px;
        left: 20%;
        width: 180px;
        height: 180px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(6, 182, 212, 0.3) 0%, transparent 70%);
        filter: blur(20px);
        pointer-events: none;
    }

    .hero-badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.25);
        padding: 4px 14px;
        border-radius: var(--radius-pill);
        font-size: 12px;
        font-weight: 700;
        margin-bottom: 12px;
        letter-spacing: 0.3px;
    }

    .hero-title-vibe {
        font-size: 32px;
        font-weight: 900;
        letter-spacing: -0.8px;
        line-height: 1.2;
        margin-bottom: 8px;
    }

    .hero-sub-vibe {
        font-size: 15px;
        color: rgba(255, 255, 255, 0.85);
        max-width: 620px;
        line-height: 1.6;
    }

    /* SEARCH & FILTER BAR */
    .search-filter-shell {
        display: flex;
        flex-direction: column;
        gap: 16px;
        margin-bottom: 32px;
    }

    .search-input-pill-wrap {
        display: flex;
        align-items: center;
        background: #FFFFFF;
        border: 2px solid #E2E8F0;
        border-radius: var(--radius-pill);
        padding: 6px 10px 6px 20px;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .search-input-pill-wrap:focus-within {
        border-color: var(--brand-primary);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12), 0 8px 20px rgba(79, 70, 229, 0.08);
    }

    .search-icon-svg {
        color: var(--text-muted);
        margin-right: 12px;
        flex-shrink: 0;
    }

    .search-input-clean {
        flex: 1;
        border: none;
        outline: none;
        font-family: inherit;
        font-size: 14.5px;
        font-weight: 500;
        color: var(--text-main);
        background: transparent;
    }

    .search-input-clean::placeholder {
        color: var(--text-muted);
    }

    .btn-search-trigger {
        background: var(--brand-gradient);
        color: #fff;
        border: none;
        border-radius: var(--radius-pill);
        padding: 10px 22px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 12px rgba(79, 70, 229, 0.25);
        transition: all 0.15s ease;
    }

    .btn-search-trigger:hover {
        opacity: 0.92;
        transform: scale(1.02);
    }

    /* CATEGORY CHIPS */
    .category-chip-scroll {
        display: flex;
        align-items: center;
        gap: 10px;
        overflow-x: auto;
        padding-bottom: 4px;
        scrollbar-width: none;
    }

    .category-chip-scroll::-webkit-scrollbar {
        display: none;
    }

    .category-chip-btn {
        padding: 8px 18px;
        border-radius: var(--radius-pill);
        font-size: 13px;
        font-weight: 700;
        text-decoration: none;
        white-space: nowrap;
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        color: var(--text-secondary);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: var(--shadow-subtle);
    }

    .category-chip-btn:hover {
        border-color: var(--brand-primary);
        color: var(--brand-primary);
        transform: translateY(-2px);
    }

    .category-chip-btn.active {
        background: #1E1B4B;
        border-color: #1E1B4B;
        color: #FFFFFF;
        box-shadow: 0 4px 12px rgba(30, 27, 75, 0.25);
    }

    /* GRID FASILITAS */
    .modern-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }

    .card-facility-vibe {
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 22px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.03);
        position: relative;
    }

    .card-facility-vibe:hover {
        transform: translateY(-8px);
        border-color: rgba(99, 102, 241, 0.5);
        box-shadow: 0 20px 35px -8px rgba(99, 102, 241, 0.18), 0 8px 16px -4px rgba(15, 23, 42, 0.04);
    }

    .card-image-aspect {
        position: relative;
        width: 100%;
        aspect-ratio: 16/11;
        background: linear-gradient(135deg, #F8FAFC, #EEF2FF);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 1px solid #F1F5F9;
    }

    .card-image-aspect img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .card-facility-vibe:hover .card-image-aspect img {
        transform: scale(1.08);
    }

    /* FLOATING STATUS PILL */
    .status-pill-floating {
        position: absolute;
        top: 12px;
        right: 12px;
        padding: 5px 12px;
        border-radius: var(--radius-pill);
        font-size: 11.5px;
        font-weight: 800;
        letter-spacing: 0.2px;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        backdrop-filter: blur(8px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        z-index: 2;
    }

    .status-pill-floating.available {
        background: rgba(236, 253, 245, 0.95);
        color: #047857;
        border: 1px solid #A7F3D0;
    }

    .status-pill-floating.empty {
        background: rgba(255, 241, 242, 0.95);
        color: #BE123C;
        border: 1px solid #FECDD3;
    }

    .status-dot-pulse {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-pill-floating.available .status-dot-pulse {
        box-shadow: 0 0 6px #10B981;
    }

    .card-detail-body {
        padding: 20px;
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .card-item-title {
        font-size: 17px;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 4px;
        line-height: 1.3;
    }

    .card-item-tag {
        font-size: 12.5px;
        font-weight: 600;
        color: #6366F1;
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .btn-loan-request-modern {
        margin-top: auto;
        background: var(--brand-gradient);
        color: #FFFFFF;
        padding: 11px 16px;
        border-radius: var(--radius-md);
        font-size: 14px;
        font-weight: 800;
        text-align: center;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.25);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        border: none;
    }

    .btn-loan-request-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(79, 70, 229, 0.4);
    }

    .btn-loan-request-modern.disabled {
        background: #E2E8F0;
        color: #94A3B8;
        box-shadow: none;
        cursor: not-allowed;
        pointer-events: none;
    }

    @media (max-width: 1120px) {
        .modern-cards-grid { grid-template-columns: repeat(3, 1fr); }
    }

    @media (max-width: 780px) {
        .modern-cards-grid { grid-template-columns: repeat(2, 1fr); }
        .hero-vibe-box { padding: 26px 24px; border-radius: 20px; }
        .hero-title-vibe { font-size: 26px; }
    }

    @media (max-width: 500px) {
        .modern-cards-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

    <!-- VIBRANT HERO BANNER -->
    <div class="hero-vibe-box">
        <div class="hero-badge-pill">
            <span>⚡ SINFAS Smart Hub</span>
        </div>
        <h1 class="hero-title-vibe">Mau pinjam apa hari ini? ✨</h1>
        <p class="hero-sub-vibe">
            Pinjam proyektor, mic, kamera, atau inventaris sekolah tanpa ribet manual. Cepat, instan, & tercatat otomatis!
        </p>
    </div>

    <!-- SEARCH & CHIPS ROW -->
    <div class="search-filter-shell">
        <form method="GET" action="{{ route('user.dashboard') }}" id="search-form">
            <input type="hidden" name="kategori" value="{{ request('kategori') }}">
            <div class="search-input-pill-wrap">
                <svg class="search-icon-svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="q" value="{{ request('q') }}" class="search-input-clean"
                       placeholder="Cari fasilitas... (proyektor, mic, speaker, papan tulis)" id="input-search">
                <button type="submit" class="btn-search-trigger">
                    <span>Cari</span>
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>
            </div>
        </form>

        <!-- CATEGORY CHIPS SCROLL -->
        <div class="category-chip-scroll">
            <a href="{{ route('user.dashboard', ['q' => request('q')]) }}"
               class="category-chip-btn {{ !request('kategori') ? 'active' : '' }}">
                <span>🔥 Semua Fasilitas</span>
            </a>
            @foreach($kategoris as $kat)
                <a href="{{ route('user.dashboard', ['kategori' => $kat->id_kategori, 'q' => request('q')]) }}"
                   class="category-chip-btn {{ request('kategori') == $kat->id_kategori ? 'active' : '' }}">
                    @if(str_contains(strtolower($kat->nama_kategori), 'elektronik')) 💻
                    @elseif(str_contains(strtolower($kat->nama_kategori), 'audio') || str_contains(strtolower($kat->nama_kategori), 'suara')) 🎙️
                    @elseif(str_contains(strtolower($kat->nama_kategori), 'proyektor') || str_contains(strtolower($kat->nama_kategori), 'visual')) 📽️
                    @elseif(str_contains(strtolower($kat->nama_kategori), 'furnitur') || str_contains(strtolower($kat->nama_kategori), 'meja')) 🪑
                    @elseif(str_contains(strtolower($kat->nama_kategori), 'lab') || str_contains(strtolower($kat->nama_kategori), 'praktik')) 🔬
                    @else 📦
                    @endif
                    <span>{{ $kat->nama_kategori }}</span>
                </a>
            @endforeach
        </div>
    </div>

    <!-- CARDS GRID -->
    <div class="modern-cards-grid">
        @forelse($barangs as $b)
            @php
                $isAvailable = $b->jumlah_baik > 0;
            @endphp
            <div class="card-facility-vibe" id="card-item-{{ $b->kode_barang }}">
                <div class="card-image-aspect">
                    <span class="status-pill-floating {{ $isAvailable ? 'available' : 'empty' }}">
                        <span class="status-dot-pulse"></span>
                        <span>{{ $isAvailable ? 'Tersedia' : 'Habis' }}</span>
                    </span>

                    @if($b->foto)
                        <img src="{{ asset('storage/' . $b->foto) }}" alt="{{ $b->nama_barang }}" loading="lazy">
                    @else
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#818CF8" stroke-width="1.6">
                            <rect x="2" y="7" width="20" height="14" rx="2"/><circle cx="12" cy="14" r="3"/><path d="M12 3v4"/><path d="M8 3h8"/>
                        </svg>
                    @endif
                </div>

                <div class="card-detail-body">
                    <h3 class="card-item-title">{{ $b->nama_barang }}</h3>
                    <div class="card-item-tag">
                        <span>#</span>
                        <span>{{ $b->kategori->nama_kategori ?? 'Umum' }}</span>
                        <span>&bull;</span>
                        <span>{{ $b->jumlah_baik }} unit baik</span>
                    </div>

                    @if($isAvailable)
                        <a href="{{ route('user.barang.show', $b->kode_barang) }}" class="btn-loan-request-modern" id="btn-request-{{ $b->kode_barang }}">
                            <span>Pinjam Fasilitas</span>
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                        </a>
                    @else
                        <button type="button" class="btn-loan-request-modern disabled">
                            <span>Stok Habis</span>
                        </button>
                    @endif
                </div>
            </div>
        @empty
            <div style="grid-column: 1 / -1; background:#FFFFFF; border: 2px dashed #CBD5E1; border-radius: 24px; padding: 60px 20px; text-align: center; color: var(--text-muted);">
                <div style="font-size: 44px; margin-bottom: 12px;">🔍</div>
                <h3 style="font-size: 18px; font-weight: 800; color: var(--text-main); margin-bottom: 6px;">Fasilitas Tidak Ditemukan</h3>
                <p style="font-size: 14px; margin-bottom: 18px;">Coba gunakan kata kunci lain atau pilih chip kategori di atas.</p>
                <a href="{{ route('user.dashboard') }}" class="btn-genz-primary">
                    Reset Pencarian
                </a>
            </div>
        @endforelse
    </div>

@endsection
