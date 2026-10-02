@extends('layouts.user')

@section('title', 'Mau pinjam apa hari ini? - SINFAS')

@section('styles')
<style>
    /* HERO VIBE BANNER */
    .hero-vibe-box {
        background: linear-gradient(135deg, #2C4A7C 0%, #3B5998 48%, #5B8DEF 100%);
        border-radius: 28px;
        padding: 36px 40px;
        color: #fff;
        margin-bottom: 28px;
        position: relative;
        overflow: hidden;
        box-shadow: 0 15px 35px -5px rgba(59, 89, 152, 0.35);
    }

    .hero-vibe-box::before {
        content: '';
        position: absolute;
        top: -60px;
        right: -60px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(123, 167, 217, 0.35) 0%, transparent 70%);
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
        background: radial-gradient(circle, rgba(91, 141, 239, 0.28) 0%, transparent 70%);
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

    /* SEARCH & FILTER ROW (SESUAI MOCKUP) */
    .search-filter-shell {
        display: flex;
        flex-direction: column;
        margin-bottom: 24px;
    }

    .search-row-flex {
        display: flex;
        align-items: center;
        gap: 12px;
        position: relative;
    }

    .search-input-box {
        flex: 1;
        display: flex;
        align-items: center;
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 12px;
        padding: 10px 18px;
        box-shadow: 0 1px 4px rgba(15, 23, 42, 0.04);
        transition: all 0.2s ease;
    }

    .search-input-box:focus-within {
        border-color: #5B8DEF;
        box-shadow: 0 0 0 3px rgba(91, 141, 239, 0.16);
    }

    .search-icon-svg {
        color: #94A3B8;
        margin-right: 10px;
        flex-shrink: 0;
    }

    .search-input-clean {
        flex: 1;
        border: none;
        outline: none;
        font-family: inherit;
        font-size: 14.5px;
        font-weight: 500;
        color: #1E293B;
        background: transparent;
    }

    .search-input-clean::placeholder {
        color: #94A3B8;
        font-weight: 400;
    }

    /* FILTER BUTTON & DROPDOWN */
    .filter-dropdown-container {
        position: relative;
    }

    .btn-filter-trigger {
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 12px;
        padding: 10px 18px;
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 1px 4px rgba(15, 23, 42, 0.04);
        white-space: nowrap;
        font-family: inherit;
    }

    .btn-filter-trigger:hover,
    .btn-filter-trigger.open {
        background: #F8FAFC;
        border-color: #CBD5E1;
        color: #0F172A;
    }

    .filter-dropdown-popup {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        width: 250px;
        background: #FFFFFF;
        border: 1px solid #E2E8F0;
        border-radius: 14px;
        box-shadow: 0 12px 30px rgba(15, 23, 42, 0.12), 0 4px 10px rgba(15, 23, 42, 0.04);
        padding: 8px;
        z-index: 100;
        max-height: 280px;
        overflow-y: auto;
        display: none;
    }

    .filter-dropdown-popup.open {
        display: block;
        animation: dropdownPop 0.18s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    }

    @keyframes dropdownPop {
        from { opacity: 0; transform: translateY(-6px) scale(0.98); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    .filter-dropdown-popup::-webkit-scrollbar {
        width: 6px;
    }
    .filter-dropdown-popup::-webkit-scrollbar-track {
        background: #F8FAFC;
        border-radius: 4px;
    }
    .filter-dropdown-popup::-webkit-scrollbar-thumb {
        background: #94A3B8;
        border-radius: 4px;
    }

    .filter-dropdown-item {
        display: block;
        padding: 9px 14px;
        border-radius: 9px;
        font-size: 13.5px;
        font-weight: 500;
        color: #334155;
        text-decoration: none;
        transition: all 0.15s ease;
        margin-bottom: 2px;
        line-height: 1.4;
    }

    .filter-dropdown-item:hover {
        background: #F1F5F9;
        color: #0F172A;
    }

    .filter-dropdown-item.active {
        background: #EEF4FF;
        color: #3B5998;
        font-weight: 700;
    }

    /* KATEGORI CEPAT CHIPS */
    .quick-category-title {
        font-family: 'Outfit', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #0F172A;
        margin: 22px 0 14px 0;
        letter-spacing: -0.3px;
    }

    .facility-section-heading {
        margin: 24px 0 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        min-width: 0;
    }

    .facility-section-heading h2 {
        min-width: 0;
        overflow-wrap: anywhere;
        font-family: 'Outfit', sans-serif;
        font-size: 20px;
        font-weight: 800;
        color: #0F172A;
    }

    .facility-section-count {
        flex-shrink: 0;
        font-size: 13px;
        color: #94A3B8;
        font-weight: 600;
    }

    .category-chip-scroll {
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }

    .category-chip-btn {
        padding: 8px 18px;
        border-radius: var(--radius-pill);
        font-size: 13px;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        color: #334155;
        transition: all 0.18s cubic-bezier(0.16, 1, 0.3, 1);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }

    .category-chip-btn:hover {
        border-color: #5B8DEF;
        color: #3B5998;
        transform: translateY(-1px);
    }

    .category-chip-btn.active {
        background: #3B5998 !important;
        border-color: #3B5998 !important;
        color: #FFFFFF !important;
        box-shadow: 0 4px 14px rgba(59, 89, 152, 0.28) !important;
        font-weight: 700;
    }

    /* GRID FASILITAS */
    .modern-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 24px;
    }

    .card-facility-vibe {
        background: #FFFFFF;
        border: none;
        border-radius: 22px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.08);
        position: relative;
    }

    .card-facility-vibe:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 35px -8px rgba(59, 89, 152, 0.18), 0 8px 16px -4px rgba(15, 23, 42, 0.06);
    }

    .card-image-aspect {
        position: relative;
        width: 100%;
        height: 205px;
        background: linear-gradient(135deg, #F8FAFC, #EEF4FF);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: none;
        padding: 6px 10px;
    }

    .card-image-aspect img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        filter: drop-shadow(0 4px 10px rgba(0, 0, 0, 0.08));
    }

    .card-facility-vibe:hover .card-image-aspect img {
        transform: scale(1.06);
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
        color: #3B5998;
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
        box-shadow: 0 4px 14px rgba(59, 89, 152, 0.25);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        border: none;
    }

    .btn-loan-request-modern:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 22px rgba(59, 89, 152, 0.4);
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
        .search-row-flex { flex-direction: column; align-items: stretch; }
        .search-input-box { width: 100%; min-width: 0; }
        .search-input-clean { width: 100%; min-width: 0; }
        .filter-dropdown-container { width: 100%; }
        .btn-filter-trigger { width: 100%; justify-content: center; }
        .filter-dropdown-popup { width: min(250px, calc(100vw - 28px)); right: 0; }
        .hero-badge-pill { max-width: 100%; white-space: normal; }
        .facility-section-heading { align-items: flex-start; }
        .facility-section-heading h2 { font-size: 18px; }
    }
</style>
@endsection

@section('content')

    <!-- VIBRANT HERO BANNER -->
    <div class="hero-vibe-box">
        <div class="hero-badge-pill">
            <span>👋 Selamat datang, {{ Auth::user()->nama ?? 'User' }}</span>
        </div>
        <h1 class="hero-title-vibe">Mau pinjam apa hari ini? ✨</h1>
        <p class="hero-sub-vibe">
            Pinjam proyektor, mic, kamera, atau inventaris sekolah tanpa ribet manual. Cepat, instan, & tercatat otomatis!
        </p>
    </div>

    @php
        if (!function_exists('getKatIcon')) {
            function getKatIcon($name) {
                $l = strtolower($name);
                if (str_contains($l, 'audio') || str_contains($l, 'sound') || str_contains($l, 'suara') || str_contains($l, 'speaker')) return '🎤';
                if (str_contains($l, 'kabel') || str_contains($l, 'adapter') || str_contains($l, 'colokan')) return '🔌';
                if (str_contains($l, 'kamera') || str_contains($l, 'foto') || str_contains($l, 'video') || str_contains($l, 'dokumentasi')) return '📷';
                if (str_contains($l, 'lab') || str_contains($l, 'multimedia') || str_contains($l, 'elektronik') || str_contains($l, 'komputer') || str_contains($l, 'laptop')) return '💻';
                if (str_contains($l, 'proyektor') || str_contains($l, 'presentasi') || str_contains($l, 'visual')) return '💡';
                if (str_contains($l, 'furnitur') || str_contains($l, 'furniture') || str_contains($l, 'meja') || str_contains($l, 'kursi')) return '🪑';
                if (str_contains($l, 'olahraga') || str_contains($l, 'sport') || str_contains($l, 'bola')) return '⚽';
                if (str_contains($l, 'listrik') || str_contains($l, 'kelistrikan')) return '⚡';
                return '📦';
            }
        }

        $activeKat = request('kategori');
        $isAll = empty($activeKat);
        $isPopular = ($activeKat === 'sering_dipinjam');
    @endphp

    <!-- SEARCH & FILTER ROW -->
    <div class="search-filter-shell">
        <form method="GET" action="{{ route('user.dashboard') }}" id="search-form" class="search-row-flex">
            <input type="hidden" name="kategori" value="{{ $activeKat }}">
            
            <div class="search-input-box">
                <svg class="search-icon-svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8"></circle>
                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                </svg>
                <input type="text" name="q" value="{{ request('q') }}" class="search-input-clean"
                       placeholder="Cari alat, kategori, atau status..." id="input-search">
            </div>

            <!-- FILTER BUTTON & DROPDOWN -->
            <div class="filter-dropdown-container">
                <button type="button" class="btn-filter-trigger {{ $activeKat ? 'open' : '' }}" id="btnFilterTrigger" onclick="toggleFilterDropdown(event)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" y1="6" x2="21" y2="6"></line>
                        <line x1="6" y1="12" x2="18" y2="12"></line>
                        <line x1="10" y1="18" x2="14" y2="18"></line>
                    </svg>
                    <span>Filter</span>
                </button>

                <!-- Dropdown Menu -->
                <div class="filter-dropdown-popup" id="filterDropdownMenu">
                    <a href="{{ route('user.dashboard', ['q' => request('q')]) }}"
                       class="filter-dropdown-item {{ $isAll ? 'active' : '' }}">
                        Semua Kategori (Beranda)
                    </a>
                    <a href="{{ route('user.dashboard', ['kategori' => 'sering_dipinjam', 'q' => request('q')]) }}"
                       class="filter-dropdown-item {{ $isPopular ? 'active' : '' }}">
                        🔥 Sering Dipinjam
                    </a>
                    @foreach($kategoris as $kat)
                        <a href="{{ route('user.dashboard', ['kategori' => $kat->id_kategori, 'q' => request('q')]) }}"
                           class="filter-dropdown-item {{ $activeKat == $kat->id_kategori ? 'active' : '' }}">
                            {{ $kat->nama_kategori }}
                        </a>
                    @endforeach
                </div>
            </div>
        </form>

        <!-- KATEGORI CEPAT -->
        <div class="quick-category-section">
            <h3 class="quick-category-title">Kategori Cepat</h3>
            <div class="category-chip-scroll">
                <a href="{{ route('user.dashboard', ['q' => request('q')]) }}"
                   class="category-chip-btn {{ $isAll ? 'active' : '' }}">
                    <span>✨ Semua</span>
                </a>
                <a href="{{ route('user.dashboard', ['kategori' => 'sering_dipinjam', 'q' => request('q')]) }}"
                   class="category-chip-btn {{ $isPopular ? 'active' : '' }}">
                    <span>🔥 Sering Dipinjam</span>
                </a>
                @foreach($kategoris as $kat)
                    <a href="{{ route('user.dashboard', ['kategori' => $kat->id_kategori, 'q' => request('q')]) }}"
                       class="category-chip-btn {{ $activeKat == $kat->id_kategori ? 'active' : '' }}">
                        <span>{{ getKatIcon($kat->nama_kategori) }} {{ $kat->nama_kategori }}</span>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- SECTION TITLE -->
    <div class="facility-section-heading">
        <h2 style="margin: 0; display: flex; align-items: center; gap: 8px;">
            @if($isPopular)
                🔥 Sering Dipinjam
            @elseif(!empty($activeKat))
                @php
                    $currentKat = $kategoris->firstWhere('id_kategori', $activeKat);
                @endphp
                {{ $currentKat ? (getKatIcon($currentKat->nama_kategori) . ' ' . $currentKat->nama_kategori) : 'Fasilitas' }}
            @elseif(request()->filled('q'))
                🔍 Hasil Pencarian: "{{ request('q') }}"
            @else
                🔥 Sering Dipinjam
            @endif
        </h2>
        <span class="facility-section-count">
            {{ $barangs->count() }} fasilitas
        </span>
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
                        <img src="{{ asset('storage/' . $b->foto) }}" alt="{{ $b->nama_barang }}" loading="lazy" onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='block';">
                        <svg style="display:none;" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#5B8DEF" stroke-width="1.6">
                            <rect x="2" y="7" width="20" height="14" rx="2"/><circle cx="12" cy="14" r="3"/><path d="M12 3v4"/><path d="M8 3h8"/>
                        </svg>
                    @else
                        <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="#5B8DEF" stroke-width="1.6">
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

    <script>
        function toggleFilterDropdown(event) {
            event.stopPropagation();
            const menu = document.getElementById('filterDropdownMenu');
            const btn = document.getElementById('btnFilterTrigger');
            if (menu) {
                menu.classList.toggle('open');
                if (btn) btn.classList.toggle('open');
            }
        }

        document.addEventListener('click', function(e) {
            const menu = document.getElementById('filterDropdownMenu');
            const btn = document.getElementById('btnFilterTrigger');
            if (menu && menu.classList.contains('open')) {
                if (!menu.contains(e.target) && !btn.contains(e.target)) {
                    menu.classList.remove('open');
                    if (btn) btn.classList.remove('open');
                }
            }
        });

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const menu = document.getElementById('filterDropdownMenu');
                const btn = document.getElementById('btnFilterTrigger');
                if (menu) menu.classList.remove('open');
                if (btn) btn.classList.remove('open');
            }
        });
    </script>
@endsection
