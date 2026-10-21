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

    /* MODERN SINFAS PAGINATION */
    .user-pagination-wrapper {
        margin-top: 36px;
        padding-top: 24px;
        border-top: 1px solid var(--border-subtle);
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }
    .user-pagination-info {
        font-size: 13.5px;
        color: var(--text-muted);
        font-weight: 500;
    }
    .user-pagination-info strong {
        color: var(--text-main);
        font-weight: 700;
    }
    .user-pagination-pills {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #FFFFFF;
        padding: 5px 8px;
        border-radius: var(--radius-pill);
        border: 1.5px solid #E2E8F0;
        box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
    }
    .user-page-btn {
        min-width: 36px;
        height: 36px;
        padding: 0 10px;
        border-radius: var(--radius-pill);
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        font-weight: 700;
        color: #475569;
        text-decoration: none;
        transition: all 0.18s ease;
        gap: 4px;
        border: 1px solid transparent;
        font-family: inherit;
    }
    .user-page-btn:hover:not(.disabled):not(.active) {
        background: #F1F5F9;
        color: #1E293B;
        border-color: #CBD5E1;
        transform: translateY(-1px);
    }
    .user-page-btn.active {
        background: linear-gradient(135deg, #3B5998 0%, #2C4A7C 100%);
        color: #FFFFFF !important;
        box-shadow: 0 3px 10px rgba(44, 74, 124, 0.28);
    }
    .user-page-btn.disabled {
        opacity: 0.35;
        cursor: not-allowed;
        color: #94A3B8;
    }
    .user-page-ellipsis {
        padding: 0 4px;
        color: #94A3B8;
        font-size: 13px;
    }

    /* ─── DASHBOARD 2-COLUMN LAYOUT WITH SIDE CARD WIDGET ─── */
    .dashboard-layout-columns {
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 28px;
        align-items: start;
    }
    .dashboard-main-column {
        min-width: 0;
    }
    .dashboard-side-column {
        display: flex;
        flex-direction: column;
        gap: 20px;
        position: sticky;
        top: 96px;
    }

    /* SIDE CARD WIDGET COMMON */
    .side-card-widget {
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.04);
        transition: all 0.25s ease;
    }
    .side-card-widget:hover {
        border-color: #CBD5E1;
        box-shadow: 0 8px 24px rgba(15, 23, 42, 0.07);
    }
    .side-card-header {
        padding: 16px 20px;
        border-bottom: 1px solid #F1F5F9;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
    }
    .side-card-title {
        font-size: 14px;
        font-weight: 800;
        color: #0F172A;
        display: flex;
        align-items: center;
        gap: 8px;
        margin: 0;
    }
    .side-card-body {
        padding: 18px 20px;
    }

    /* WIDGET 1: USER PROFILE CARD */
    .side-profile-hero {
        background: linear-gradient(135deg, #2C4A7C 0%, #3B5998 60%, #5B8DEF 100%);
        color: #FFFFFF;
        padding: 22px 20px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .side-profile-hero::before {
        content: '';
        position: absolute;
        top: -30px;
        right: -30px;
        width: 100px;
        height: 100px;
        background: radial-gradient(circle, rgba(255,255,255,0.2) 0%, transparent 70%);
        border-radius: 50%;
    }
    .side-avatar-circle {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        background: #FFFFFF;
        color: #2C4A7C;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        font-weight: 900;
        margin: 0 auto 12px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
        border: 3px solid rgba(255, 255, 255, 0.4);
    }
    .side-profile-name {
        font-size: 16px;
        font-weight: 800;
        margin-bottom: 4px;
        letter-spacing: -0.2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .side-profile-nis {
        font-size: 12px;
        color: rgba(255, 255, 255, 0.9);
        display: inline-block;
        background: rgba(255, 255, 255, 0.2);
        padding: 2px 10px;
        border-radius: var(--radius-pill);
        font-weight: 600;
    }
    .side-stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 8px;
        padding: 14px 16px;
        background: #F8FAFC;
        border-bottom: 1px solid #E2E8F0;
        text-align: center;
    }
    .side-stat-box {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }
    .side-stat-num {
        font-size: 16px;
        font-weight: 800;
        color: #0F172A;
    }
    .side-stat-label {
        font-size: 10px;
        font-weight: 700;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    /* WIDGET 2: ACTIVE LOAN ITEM */
    .side-loan-item {
        background: #F8FAFC;
        border: 1.5px solid #E2E8F0;
        border-radius: 14px;
        padding: 12px 14px;
        margin-bottom: 10px;
        transition: transform 0.15s ease;
    }
    .side-loan-item:hover {
        transform: translateY(-2px);
        border-color: #93C5FD;
        background: #FFFFFF;
    }
    .side-loan-title {
        font-size: 13.5px;
        font-weight: 800;
        color: #0F172A;
        margin-bottom: 4px;
    }
    .side-loan-deadline {
        font-size: 11.5px;
        display: flex;
        align-items: center;
        gap: 6px;
        margin-bottom: 8px;
    }
    .side-loan-action-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        width: 100%;
        padding: 7px 12px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 700;
        text-decoration: none;
        background: #3B5998;
        color: #FFFFFF;
        transition: all 0.15s ease;
    }
    .side-loan-action-btn:hover {
        background: #2C4A7C;
    }

    /* RESPONSIVE LAYOUT */
    @media (max-width: 1100px) {
        .dashboard-layout-columns {
            grid-template-columns: 1fr 300px;
            gap: 20px;
        }
    }
    @media (max-width: 950px) {
        .dashboard-layout-columns {
            grid-template-columns: 1fr;
        }
        .dashboard-side-column {
            position: static;
            margin-top: 20px;
        }
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

    <!-- ─── 2-COLUMN DASHBOARD LAYOUT ─── -->
    <div class="dashboard-layout-columns">
        
        <!-- KOLOM UTAMA (KIRI): PENCARIAN, FILTER, GRID BARANG, & PAGINATION -->
        <div class="dashboard-main-column">

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
                ✨ Semua Fasilitas
            @endif
        </h2>
        <span class="facility-section-count">
            {{ $barangs->total() }} fasilitas
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

    <!-- PAGINATION SINFAS MODERN -->
    @if($barangs->hasPages())
        <div class="user-pagination-wrapper">
            <div class="user-pagination-info">
                Menampilkan <strong>{{ $barangs->firstItem() ?? 0 }}</strong> &ndash; <strong>{{ $barangs->lastItem() ?? 0 }}</strong> dari <strong>{{ $barangs->total() }}</strong> fasilitas
            </div>
            <div class="user-pagination-pills">
                {{-- Tombol Sebelumnya --}}
                @if($barangs->onFirstPage())
                    <span class="user-page-btn disabled" aria-disabled="true">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Prev</span>
                    </span>
                @else
                    <a href="{{ $barangs->previousPageUrl() }}" class="user-page-btn" rel="prev">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"></polyline></svg>
                        <span>Prev</span>
                    </a>
                @endif

                {{-- Nomor Halaman --}}
                @for($p = 1; $p <= $barangs->lastPage(); $p++)
                    @if($p == 1 || $p == $barangs->lastPage() || ($p >= $barangs->currentPage() - 1 && $p <= $barangs->currentPage() + 1))
                        @if($p == $barangs->currentPage())
                            <span class="user-page-btn active" aria-current="page">{{ $p }}</span>
                        @else
                            <a href="{{ $barangs->url($p) }}" class="user-page-btn">{{ $p }}</a>
                        @endif
                    @elseif($p == 2 || $p == $barangs->lastPage() - 1)
                        <span class="user-page-ellipsis">&hellip;</span>
                    @endif
                @endfor

                {{-- Tombol Selanjutnya --}}
                @if($barangs->hasMorePages())
                    <a href="{{ $barangs->nextPageUrl() }}" class="user-page-btn" rel="next">
                        <span>Next</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </a>
                @else
                    <span class="user-page-btn disabled" aria-disabled="true">
                        <span>Next</span>
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </span>
                @endif
            </div>
        </div>
    @endif

        </div> <!-- /.dashboard-main-column -->

        <!-- ─── KOLOM KANAN: SIDE CARD WIDGETS ─── -->
        <aside class="dashboard-side-column">
            
            <!-- 1. KARTU PROFIL & STATS SISWA -->
            <div class="side-card-widget">
                <div class="side-profile-hero">
                    <div class="side-avatar-circle">
                        {{ strtoupper(substr(Auth::user()->nama ?? 'U', 0, 2)) }}
                    </div>
                    <div class="side-profile-name">{{ Auth::user()->nama ?? 'Siswa SINFAS' }}</div>
                    <div class="side-profile-nis">NIS: {{ Auth::user()->nis ?? '-' }}</div>
                </div>
                <div class="side-stats-grid">
                    <div class="side-stat-box">
                        <span class="side-stat-num">{{ $userTotalLoans ?? 0 }}</span>
                        <span class="side-stat-label">Total Pinjam</span>
                    </div>
                    <div class="side-stat-box">
                        <span class="side-stat-num" style="color: #D97706;">{{ $userPendingLoans ?? 0 }}</span>
                        <span class="side-stat-label">Antrean</span>
                    </div>
                    <div class="side-stat-box">
                        <span class="side-stat-num" style="color: #2563EB;">{{ isset($userActiveLoans) ? $userActiveLoans->count() : 0 }}</span>
                        <span class="side-stat-label">Sedang Bawa</span>
                    </div>
                </div>
                <div style="padding: 12px 18px; text-align: center;">
                    <a href="{{ route('user.profile') }}" style="font-size: 12px; font-weight: 700; color: #3B5998; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                        <span>Kelola Profil & Password</span>
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </a>
                </div>
            </div>

            <!-- 2. KARTU PINJAMAN AKTIF KAMU (LIVE TRACKER) -->
            <div class="side-card-widget">
                <div class="side-card-header">
                    <h4 class="side-card-title">
                        <span>📦</span>
                        <span>Pinjaman Aktif</span>
                    </h4>
                    @if(isset($userActiveLoans) && $userActiveLoans->count() > 0)
                        <span style="font-size: 11px; font-weight: 800; background: #EFF6FF; color: #2563EB; padding: 2px 8px; border-radius: var(--radius-pill); border: 1px solid #BFDBFE;">
                            {{ $userActiveLoans->count() }} Fasilitas
                        </span>
                    @endif
                </div>
                <div class="side-card-body" style="padding: 14px 16px;">
                    @if(isset($userActiveLoans) && $userActiveLoans->count() > 0)
                        @foreach($userActiveLoans as $pjm)
                            @php
                                $now = \Carbon\Carbon::now();
                                $deadline = $pjm->tanggal_kembali;
                                $isOverdue = $deadline && $deadline->lt($now->startOfDay());
                                $isNearDeadline = $deadline && !$isOverdue && $deadline->lte($now->copy()->addDays(1)->endOfDay());
                            @endphp
                            <div class="side-loan-item" style="{{ $isOverdue ? 'border-color: #FECACA; background: #FEF2F2;' : ($isNearDeadline ? 'border-color: #FDE68A; background: #FFFBEB;' : '') }}">
                                <div class="side-loan-title">{{ $pjm->barang->nama_barang ?? 'Fasilitas' }}</div>
                                <div class="side-loan-deadline" style="color: {{ $isOverdue ? '#DC2626' : ($isNearDeadline ? '#D97706' : '#64748B') }};">
                                    <span>{{ $isOverdue ? '🚨 Terlambat!' : ($isNearDeadline ? '⚠️ Tenggat Besok!' : '⏳ Tenggat:') }}</span>
                                    <strong>{{ $deadline ? $deadline->format('d M Y') : '-' }}</strong>
                                </div>
                                <a href="{{ route('user.pengembalian.create', $pjm->kode_pinjam) }}" class="side-loan-action-btn" style="{{ $isOverdue ? 'background: #DC2626;' : '' }}">
                                    <span>Kembalikan Barang</span>
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                                </a>
                            </div>
                        @endforeach
                    @else
                        <!-- State Kosong (Bebas Tanggungan) -->
                        <div style="text-align: center; padding: 18px 10px;">
                            <div style="width: 48px; height: 48px; border-radius: 50%; background: #ECFDF5; color: #10B981; display: flex; align-items: center; justify-content: center; font-size: 22px; margin: 0 auto 10px;">
                                ✓
                            </div>
                            <div style="font-size: 14px; font-weight: 800; color: #0F172A; margin-bottom: 3px;">Bebas Tanggungan! ✨</div>
                            <p style="font-size: 12px; color: #64748B; line-height: 1.5; margin: 0;">
                                Kamu tidak sedang meminjam fasilitas apa pun saat ini.
                            </p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- 3. KARTU JAM OPERASIONAL & BANTUAN -->
            <div class="side-card-widget" style="background: linear-gradient(180deg, #FFFFFF 0%, #F8FAFC 100%);">
                <div class="side-card-header">
                    <h4 class="side-card-title">
                        <span>🕒</span>
                        <span>Ruang Sarana</span>
                    </h4>
                    <span style="font-size: 11px; font-weight: 700; color: #10B981; background: #ECFDF5; padding: 2px 7px; border-radius: 6px;">Buka</span>
                </div>
                <div class="side-card-body" style="padding: 14px 18px; font-size: 12.5px; color: #475569; line-height: 1.6;">
                    <div style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 10px;">
                        <span style="font-size: 16px;">🏢</span>
                        <div>
                            <strong style="color: #0F172A; display: block;">Lokasi Pelayanan</strong>
                            <span>Ruang Sarpras & Inventaris (Gedung A, Lt. 1)</span>
                        </div>
                    </div>
                    <div style="display: flex; align-items: flex-start; gap: 10px; margin-bottom: 12px;">
                        <span style="font-size: 16px;">⏱️</span>
                        <div>
                            <strong style="color: #0F172A; display: block;">Jam Layanan</strong>
                            <span>Senin &ndash; Jumat &bull; 07.00 &ndash; 16.00 WIB</span>
                        </div>
                    </div>
                    <button type="button" onclick="toggleHelpModal()" style="width: 100%; background: #F1F5F9; border: 1px solid #CBD5E1; border-radius: 8px; padding: 8px 12px; font-size: 12px; font-weight: 700; color: #334155; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px; transition: all 0.15s;" onmouseover="this.style.background='#E2E8F0'" onmouseout="this.style.background='#F1F5F9'">
                        <span>Panduan Cara Pinjam</span>
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    </button>
                </div>
            </div>

        </aside>
    </div> <!-- /.dashboard-layout-columns -->

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
