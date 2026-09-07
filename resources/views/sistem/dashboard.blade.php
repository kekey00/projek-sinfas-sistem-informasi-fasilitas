@extends('layouts.sistem')

@section('title', 'Dashboard Admin Sistem')
@section('page_title', 'Beranda')

@section('styles')
<style>
    /* ── Stat Cards Row Khas SINFAS ── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 18px;
        margin-bottom: 22px;
    }

    .stat-card {
        background: #FFFFFF;
        border-radius: 16px;
        padding: 22px 26px;
        box-shadow: 0 4px 16px rgba(44, 74, 124, 0.08);
        border: 2.5px solid var(--color-border-blue);
        position: relative;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .stat-card:hover {
        box-shadow: 0 8px 24px rgba(44, 74, 124, 0.14);
        transform: translateY(-2px);
    }

    .stat-number {
        font-family: 'Gorditas', cursive;
        font-size: 34px;
        font-weight: 700;
        color: #0F172A;
        line-height: 1.1;
        letter-spacing: 0.3px;
        margin-bottom: 6px;
    }

    .stat-label {
        font-size: 13.5px;
        color: var(--color-border-blue);
        font-weight: 600;
        line-height: 1.4;
    }

    .stat-label span {
        display: block;
        font-size: 11.5px;
        color: var(--text-muted);
        margin-top: 4px;
        font-weight: 500;
    }

    /* ── Quick Action Cards Khas SINFAS ── */
    .quick-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 18px;
        margin-bottom: 24px;
    }

    .quick-card {
        background: #FFFFFF;
        border-radius: 16px;
        padding: 20px 26px;
        box-shadow: 0 4px 16px rgba(44, 74, 124, 0.08);
        border: 2.5px solid var(--color-border-blue);
        display: flex;
        align-items: center;
        gap: 18px;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    .quick-card:hover {
        box-shadow: 0 8px 24px rgba(44, 74, 124, 0.15);
        transform: translateY(-2px);
        border-color: var(--color-focus-blue);
    }

    .quick-icon {
        width: 50px;
        height: 50px;
        border-radius: 12px;
        background: linear-gradient(135deg, #EFF6FF 0%, #DBEAFE 100%);
        border: 1.5px solid var(--color-light-blue-bubble);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        box-shadow: 0 2px 6px rgba(44, 74, 124, 0.1);
    }

    .quick-content { flex: 1; }

    .quick-title {
        font-family: 'Gorditas', cursive;
        font-size: 15.5px;
        font-weight: 700;
        color: var(--color-dark-blue-bubble);
        letter-spacing: 0.3px;
    }

    .quick-desc {
        font-size: 12px;
        color: #64748B;
        margin-top: 3px;
        line-height: 1.4;
    }

    .quick-arrow {
        color: var(--color-border-blue);
        font-size: 22px;
        font-weight: 700;
        margin-left: auto;
        transition: transform 0.2s ease;
    }

    .quick-card:hover .quick-arrow {
        transform: translateX(4px);
    }
</style>
@endsection

@section('content')

{{-- ── 3 Kartu Statistik Dalam Bahasa Indonesia ── --}}
<div class="stat-grid">
    <div class="stat-card">
        <div class="stat-number">{{ $totalAkun }}</div>
        <div class="stat-label">
            Total Akun
            <span>{{ $totalSiswa }} Siswa · {{ $totalAdminSarana }} Admin Sarana · {{ $totalAdminSistem }} Admin Sistem</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-number">{{ $akunBulanIni }}</div>
        <div class="stat-label">
            Akun Baru Bulan Ini
            <span>{{ $periodeBulan }}</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-number">{{ $backupRelative }}</div>
        <div class="stat-label">
            Backup Terakhir
            <span>{{ $backupTerakhir }}</span>
        </div>
    </div>
</div>

{{-- ── Quick Actions Dalam Bahasa Indonesia ── --}}
<div class="quick-grid">
    <a href="{{ route('sistem.akun.index') }}" class="quick-card">
        <div class="quick-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-dark-blue-bubble)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                <circle cx="9" cy="7" r="4"/>
                <path d="M23 21v-2a4 4 0 0 0-3-3.87"/>
                <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
        </div>
        <div class="quick-content">
            <div class="quick-title">Kelola Akun</div>
            <div class="quick-desc">Lihat, tambah, edit, dan kelola akun pengguna sistem</div>
        </div>
        <div class="quick-arrow">&rarr;</div>
    </a>

    <a href="{{ route('sistem.settings.index') }}" class="quick-card">
        <div class="quick-icon">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="var(--color-dark-blue-bubble)" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="3"/>
                <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
            </svg>
        </div>
        <div class="quick-content">
            <div class="quick-title">Pengaturan Sistem</div>
            <div class="quick-desc">Atur jam operasional, pencadangan data, dan preferensi sistem</div>
        </div>
        <div class="quick-arrow">&rarr;</div>
    </a>
</div>

@endsection
