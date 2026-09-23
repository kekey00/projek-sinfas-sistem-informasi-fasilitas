@extends('layouts.sistem')

@section('title', 'Dashboard Admin Sistem')
@section('page_title', 'Beranda')

@section('styles')
<style>
    /* ─── WELCOME HEADER ─── */
    .dash-header {
        margin-bottom: 6px;
    }
    .dash-title {
        font-family: 'Outfit', sans-serif;
        font-size: 26px;
        font-weight: 700;
        color: #1E293B;
        letter-spacing: -0.4px;
        margin-bottom: 4px;
    }
    .dash-subtitle {
        font-size: 13.5px;
        color: #64748B;
    }

    /* ─── STAT CARDS ROW ─── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }
    @media (max-width: 900px) { .stat-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: #FFFFFF;
        border: 1px solid #E8EEF6;
        border-radius: 14px;
        padding: 22px 24px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        box-shadow: 0 1px 4px rgba(30,41,80,0.06);
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .stat-card:hover {
        box-shadow: 0 6px 20px rgba(30,41,80,0.10);
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon.blue   { background: #EFF6FF; color: #2563EB; }
    .stat-icon.green  { background: #ECFDF5; color: #059669; }
    .stat-icon.amber  { background: #FFFBEB; color: #D97706; }

    .stat-body { flex: 1; }
    .stat-number {
        font-family: 'Outfit', sans-serif;
        font-size: 32px;
        font-weight: 700;
        color: #1E293B;
        line-height: 1.1;
        margin-bottom: 4px;
        letter-spacing: -0.5px;
    }
    .stat-label {
        font-size: 13px;
        color: #64748B;
        font-weight: 600;
    }
    .stat-meta {
        font-size: 11.5px;
        color: #94A3B8;
        margin-top: 6px;
        font-weight: 500;
        line-height: 1.35;
    }

    /* ─── QUICK ACTIONS ROW ─── */
    .quick-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    @media (max-width: 768px) { .quick-grid { grid-template-columns: 1fr; } }

    .quick-card {
        background: #FFFFFF;
        border: 1px solid #E8EEF6;
        border-radius: 14px;
        padding: 20px 24px;
        display: flex;
        align-items: center;
        gap: 18px;
        text-decoration: none;
        box-shadow: 0 1px 4px rgba(30,41,80,0.06);
        transition: all 0.2s ease;
        position: relative;
    }
    .quick-card:hover {
        box-shadow: 0 6px 20px rgba(30,41,80,0.10);
        transform: translateY(-2px);
        border-color: #2D4E9E;
    }

    .quick-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: transform 0.2s;
    }
    .quick-card:hover .quick-icon {
        transform: scale(1.05);
    }
    .quick-icon.blue { background: #EFF6FF; color: #2D4E9E; }
    .quick-icon.indigo { background: #EEF2FF; color: #4F46E5; }

    .quick-content { flex: 1; }
    .quick-title {
        font-family: 'Outfit', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 3px;
        letter-spacing: -0.2px;
    }
    .quick-desc {
        font-size: 12.5px;
        color: #64748B;
        line-height: 1.4;
    }

    .quick-arrow {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #F8FAFC;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #94A3B8;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    .quick-card:hover .quick-arrow {
        background: #2D4E9E;
        color: #FFFFFF;
        transform: translateX(3px);
    }

</style>
@endsection

@section('content')

    <!-- ─── WELCOME HEADER ─── -->
    <div class="dash-header">
        <h2 class="dash-title">Dashboard Admin Sistem</h2>
        <p class="dash-subtitle">Pantau status akun pengguna, pencadangan data, dan kondisi server SINFAS.</p>
    </div>

    <!-- ─── 3 STAT CARDS ─── -->
    <div class="stat-grid">

        <!-- Total Akun -->
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="stat-body">
                <div class="stat-number">{{ $totalAkun }}</div>
                <div class="stat-label">Total Akun</div>
                <div class="stat-meta">{{ $totalSiswa }} Siswa · {{ $totalAdminSarana }} Admin Sarana · {{ $totalAdminSistem }} Admin Sistem</div>
            </div>
        </div>

        <!-- Akun Baru Bulan Ini -->
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="8.5" cy="7" r="4"></circle>
                    <line x1="20" y1="8" x2="20" y2="14"></line>
                    <line x1="23" y1="11" x2="17" y2="11"></line>
                </svg>
            </div>
            <div class="stat-body">
                <div class="stat-number">+{{ $akunBulanIni }}</div>
                <div class="stat-label">Akun Baru Bulan Ini</div>
                <div class="stat-meta">{{ $periodeBulan }}</div>
            </div>
        </div>

        <!-- Backup Terakhir -->
        <div class="stat-card">
            <div class="stat-icon amber">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <ellipse cx="12" cy="5" rx="9" ry="3"></ellipse>
                    <path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path>
                    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path>
                </svg>
            </div>
            <div class="stat-body">
                <div class="stat-number">{{ $backupRelative }}</div>
                <div class="stat-label">Backup Terakhir</div>
                <div class="stat-meta">{{ $backupTerakhir }}</div>
            </div>
        </div>

    </div>

    <!-- ─── QUICK ACTION CARDS ─── -->
    <div class="quick-grid">
        <a href="{{ route('sistem.akun.index') }}" class="quick-card">
            <div class="quick-icon blue">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                    <circle cx="9" cy="7" r="4"></circle>
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                    <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                </svg>
            </div>
            <div class="quick-content">
                <div class="quick-title">Kelola Akun Pengguna</div>
                <div class="quick-desc">Lihat, tambah, ubah kata sandi, dan kelola hak akses akun pengguna sistem.</div>
            </div>
            <div class="quick-arrow">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>

        <a href="{{ route('sistem.settings.index') }}" class="quick-card">
            <div class="quick-icon indigo">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"></circle>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                </svg>
            </div>
            <div class="quick-content">
                <div class="quick-title">Pengaturan Sistem</div>
                <div class="quick-desc">Atur jam operasional, pencadangan data, optimasi cache, dan preferensi sistem.</div>
            </div>
            <div class="quick-arrow">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="9 18 15 12 9 6"></polyline>
                </svg>
            </div>
        </a>
    </div>

@endsection
