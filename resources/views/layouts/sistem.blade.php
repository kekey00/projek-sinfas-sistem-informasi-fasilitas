<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Sistem') - SINFAS</title>

    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            /* ─── BLUE/INDIGO PALETTE SESUAI SINFAS MODERN ─── */
            --sidebar-bg:          #2D4E9E;
            --sidebar-dark:        #243f85;
            --sidebar-active:      rgba(255,255,255,0.18);
            --sidebar-hover:       rgba(255,255,255,0.10);
            --sidebar-text:        rgba(255,255,255,0.75);
            --sidebar-text-active: #FFFFFF;
            --sidebar-border:      rgba(255,255,255,0.12);
            --sidebar-section:     rgba(255,255,255,0.45);

            /* Main Brand Colors */
            --brand-blue:      #2D4E9E;
            --brand-blue-dark: #1e3a7a;
            --brand-emerald:   #10B981;
            --brand-amber:     #F59E0B;
            --brand-rose:      #EF4444;

            /* Surfaces & Grays */
            --bg-canvas:       #F0F4FF;
            --surface-card:    #FFFFFF;
            --border-color:    #E2E8F0;
            --border-subtle:   #F1F5F9;
            --surface-hover:   #F8FAFF;

            --text-dark:       #1E293B;
            --text-muted:      #64748B;
            --text-subtle:     #94A3B8;

            --radius-sm:       6px;
            --radius-md:       10px;
            --radius-lg:       14px;
            --radius-xl:       18px;
            --radius-pill:     9999px;

            --shadow-subtle:   0 1px 3px 0 rgba(15,23,42,0.06);
            --shadow-card:     0 1px 4px 0 rgba(30,41,80,0.06);
            --shadow-hover:    0 4px 16px rgba(30,41,80,0.10);
            --shadow-modal:    0 20px 25px -5px rgba(15,23,42,0.12), 0 8px 10px -6px rgba(15,23,42,0.06);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg-canvas);
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ─── SIDEBAR MODERN (BIRU INDIGO) ─── */
        .sidebar {
            width: 240px;
            min-width: 240px;
            background: var(--sidebar-bg);
            color: var(--sidebar-text-active);
            display: flex;
            flex-direction: column;
            padding: 0;
            min-height: 100vh;
            z-index: 50;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        /* Brand / Logo */
        .sidebar-brand-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 20px 16px;
            border-bottom: 1px solid var(--sidebar-border);
            text-decoration: none;
        }

        .brand-logo-icon {
            width: 36px;
            height: 36px;
            border-radius: var(--radius-md);
            background: rgba(255,255,255,0.20);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #FFFFFF;
            flex-shrink: 0;
        }

        .brand-title {
            font-family: 'Outfit', sans-serif;
            font-size: 19px;
            font-weight: 700;
            color: #FFFFFF;
            letter-spacing: 0.4px;
        }

        /* Sidebar Nav */
        .sidebar-nav-wrap {
            padding: 20px 12px 12px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .section-heading {
            font-size: 10.5px;
            font-weight: 700;
            color: var(--sidebar-section);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 6px;
            margin-top: 16px;
            padding-left: 10px;
        }

        .section-heading:first-child {
            margin-top: 0;
        }

        .sidebar-nav-list {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .nav-link-item {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: var(--radius-md);
            font-size: 13.5px;
            font-weight: 500;
            color: var(--sidebar-text);
            transition: all 0.15s ease;
            position: relative;
        }

        .nav-link-item svg {
            width: 18px;
            height: 18px;
            stroke-width: 2;
            flex-shrink: 0;
            color: rgba(255,255,255,0.60);
            transition: color 0.15s ease;
        }

        .nav-link-item:hover {
            background: var(--sidebar-hover);
            color: #FFFFFF;
        }

        .nav-link-item:hover svg {
            color: #FFFFFF;
        }

        .nav-link-item.active {
            background: var(--sidebar-active);
            color: #FFFFFF;
            font-weight: 600;
        }

        .nav-link-item.active svg {
            color: #FFFFFF;
        }

        /* Logout / Footer */
        .sidebar-footer {
            border-top: 1px solid var(--sidebar-border);
            padding: 12px;
        }

        .nav-link-item.logout {
            color: rgba(255,255,255,0.65);
        }

        .nav-link-item.logout:hover {
            background: rgba(239,68,68,0.20);
            color: #fca5a5;
        }

        .nav-link-item.logout:hover svg {
            color: #fca5a5;
        }

        /* ─── MAIN CONTENT ─── */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: var(--bg-canvas);
            overflow-y: auto;
        }

        /* Topbar */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 32px;
            background: #FFFFFF;
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 40;
            height: 60px;
        }

        .page-title {
            font-family: 'Outfit', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.2px;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* Admin Profile Pill */
        .admin-profile-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: 99px;
            padding: 5px 14px 5px 6px;
            cursor: pointer;
            transition: all 0.15s ease;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
            text-decoration: none;
        }

        .admin-profile-pill:hover {
            border-color: #CBD5E1;
            background: #F8FAFC;
            box-shadow: 0 2px 6px rgba(0,0,0,0.07);
        }

        .profile-avatar-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #EFF6FF;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #2563EB;
            flex-shrink: 0;
            font-weight: 700;
            font-size: 13px;
        }

        .profile-info-block {
            display: flex;
            flex-direction: column;
            text-align: left;
            line-height: 1.2;
        }

        .profile-name-text {
            font-family: 'Outfit', sans-serif;
            font-size: 13px;
            font-weight: 600;
            color: #1E293B;
        }

        .profile-role-sub {
            font-size: 11px;
            color: #64748B;
            font-weight: 400;
        }

        /* Page Content */
        .page-content {
            padding: 24px 32px 36px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            flex: 1;
        }

        /* ─── MODAL MODERN ─── */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.45);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
            backdrop-filter: blur(4px);
        }

        .modal-overlay.active,
        .modal-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-card {
            background: #FFFFFF;
            border-radius: var(--radius-xl);
            border: 1px solid var(--border-color);
            padding: 24px 28px;
            width: 90%;
            max-width: 520px;
            box-shadow: var(--shadow-modal);
            transform: translateY(12px) scale(0.98);
            transition: transform 0.2s ease;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-overlay.active .modal-card,
        .modal-overlay.open .modal-card {
            transform: translateY(0) scale(1);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            padding-bottom: 14px;
            border-bottom: 1px solid var(--border-subtle);
        }

        .modal-title {
            font-family: 'Outfit', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: #1E293B;
            letter-spacing: -0.2px;
        }

        .modal-close-btn {
            background: none;
            border: none;
            font-size: 22px;
            color: #94A3B8;
            cursor: pointer;
            line-height: 1;
            transition: color 0.15s;
            border-radius: 6px;
            padding: 2px 6px;
        }

        .modal-close-btn:hover { color: #E11D48; }

        .modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
            padding-top: 14px;
            border-top: 1px solid var(--border-subtle);
        }

        /* Form Controls Modern */
        .form-group { margin-bottom: 14px; }

        .form-label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #CBD5E1;
            border-radius: var(--radius-md);
            font-size: 13.5px;
            color: var(--text-dark);
            outline: none;
            font-family: inherit;
            transition: all 0.15s ease;
            background: #FFFFFF;
        }

        .form-control:focus {
            border-color: var(--brand-blue);
            box-shadow: 0 0 0 3px rgba(45, 78, 158, 0.12);
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* Buttons */
        .btn-cancel {
            padding: 8px 18px;
            border-radius: var(--radius-md);
            background: #F8FAFC;
            color: var(--text-muted);
            border: 1px solid #E2E8F0;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.15s;
        }

        .btn-cancel:hover { background: #F1F5F9; color: #1E293B; }

        .btn-primary {
            padding: 8px 20px;
            border-radius: var(--radius-md);
            background: var(--brand-blue);
            color: #FFFFFF;
            border: none;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            font-family: inherit;
            transition: background 0.15s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: var(--sidebar-dark);
        }

        /* ─── TOAST NOTIFICATION ─── */
        .sinfas-toast-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }

        .sinfas-toast-card {
            pointer-events: auto;
            display: flex;
            align-items: center;
            gap: 12px;
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-radius: var(--radius-lg);
            padding: 12px 18px;
            box-shadow: 0 10px 25px -5px rgba(15,23,42,0.12);
            min-width: 300px;
            max-width: 420px;
            animation: toastSlideIn 0.25s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            transition: opacity 0.25s, transform 0.25s;
        }

        @keyframes toastSlideIn {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .toast-icon-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            flex-shrink: 0;
        }

        .toast-icon-circle.success { background: #ECFDF5; color: #059669; }
        .toast-icon-circle.error { background: #FFF1F2; color: #E11D48; }

        .toast-text-wrap { flex: 1; }
        .toast-title { font-size: 13px; font-weight: 600; color: #1E293B; }
        .toast-subtitle { font-size: 11.5px; color: #64748B; margin-top: 1px; }

        .toast-close-btn {
            background: none;
            border: none;
            font-size: 18px;
            color: #94A3B8;
            cursor: pointer;
            line-height: 1;
            padding: 2px;
        }

        .toast-close-btn:hover { color: #64748B; }

        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(45, 78, 158, 0.2); border-radius: 4px; }
    </style>

    @yield('styles')
</head>
<body>
<div class="admin-layout">

    <!-- ─── SIDEBAR BIRU INDIGO SINFAS ─── -->
    <aside class="sidebar">

        <!-- Brand / Header -->
        <a href="{{ route('sistem.dashboard') }}" class="sidebar-brand-wrap">
            <div class="brand-logo-icon">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="8" r="4"></circle>
                    <path d="M6 20v-2a6 6 0 0 1 12 0v2"></path>
                </svg>
            </div>
            <span class="brand-title">SINFAS Admin</span>
        </a>

        <!-- Navigation Menu -->
        <div class="sidebar-nav-wrap">
            <div class="section-heading">Menu Utama</div>
            <nav class="sidebar-nav-list">

                <!-- Beranda / Dashboard -->
                <a href="{{ route('sistem.dashboard') }}" class="nav-link-item {{ request()->routeIs('sistem.dashboard') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                        <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                        <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                        <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                    </svg>
                    Beranda
                </a>

                <!-- Kelola Akun -->
                <a href="{{ route('sistem.akun.index') }}" class="nav-link-item {{ request()->routeIs('sistem.akun.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                    Kelola Akun
                </a>

                <!-- Pengaturan Sistem -->
                <a href="{{ route('sistem.settings.index') }}" class="nav-link-item {{ request()->routeIs('sistem.settings.*') ? 'active' : '' }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                    </svg>
                    Kelola Sistem
                </a>

            </nav>
        </div>

        <!-- Sidebar Footer / Logout -->
        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                @csrf
                <a href="javascript:void(0)" onclick="openLogoutModal()" class="nav-link-item logout">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    Logout
                </a>
            </form>
        </div>

    </aside>

    <!-- ─── MAIN CONTENT ─── -->
    <main class="main-wrapper">

        <!-- Topbar -->
        <header class="topbar">
            <h1 class="page-title">@yield('page_title', 'Beranda')</h1>
            <div class="topbar-actions">
                <button type="button" class="admin-profile-pill" onclick="openProfileModal()">
                    <div class="profile-avatar-circle">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                    </div>
                    <div class="profile-info-block">
                        <span class="profile-name-text">{{ Auth::user()->nama ?? 'Admin Sistem' }}</span>
                        <span class="profile-role-sub">Operator Sistem</span>
                    </div>
                </button>
            </div>
        </header>

        <!-- Page Body -->
        <div class="page-content">
            @yield('content')
        </div>

    </main>
</div>

<!-- Modal Profil & Pengaturan Akun Admin Sistem -->
<div id="profileModal" class="modal-overlay">
    <div class="modal-card" style="max-width: 480px;">
        <div class="modal-header">
            <div class="modal-title">Profil & Akun Admin Sistem</div>
            <button class="modal-close-btn" onclick="closeModal('profileModal')">&times;</button>
        </div>
        
        <form action="{{ route('user.profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Hero Profile Info -->
            <div style="display:flex;align-items:center;gap:14px;background:#F8FAFC;padding:16px;border-radius:14px;border:1px solid #E2E8F0;margin-bottom:18px;">
                <div style="width:54px;height:54px;border-radius:14px;background:#2D4E9E;display:flex;align-items:center;justify-content:center;font-family:'Outfit',sans-serif;font-size:22px;font-weight:700;color:#FFFFFF;flex-shrink:0;box-shadow:0 4px 12px rgba(45,78,158,0.25);">
                    {{ strtoupper(substr(Auth::user()->nama ?? 'S', 0, 1)) }}
                </div>
                <div style="flex:1;">
                    <div style="font-family:'Outfit',sans-serif;font-size:16.5px;font-weight:700;color:#1E293B;">{{ Auth::user()->nama ?? 'Admin Sistem' }}</div>
                    <div style="font-size:12.5px;color:#64748B;">Username: <strong style="color:#334155;">{{ '@' . (Auth::user()->username ?? 'adminsistem') }}</strong></div>
                    <div style="display:inline-flex;align-items:center;gap:6px;font-size:11.5px;color:#4F46E5;font-weight:600;background:#EEF2FF;padding:2px 8px;border-radius:99px;margin-top:4px;border:1px solid #C7D2FE;">
                        <span style="width:6px;height:6px;border-radius:50%;background:#4F46E5;"></span>
                        Operator Sistem &bull; Aktif
                    </div>
                </div>
            </div>

            <!-- Fields -->
            <div class="form-group">
                <label class="form-label">Nama Lengkap <span style="color:#E11D48;">*</span></label>
                <input type="text" name="nama" class="form-control" value="{{ Auth::user()->nama ?? '' }}" required>
            </div>

            <div class="form-group">
                <label class="form-label">Nomor WhatsApp / HP</label>
                <input type="text" name="nomor_kontak" class="form-control" value="{{ Auth::user()->nomor_kontak ?? '' }}" placeholder="08xxxxxxxxxx">
            </div>

            <!-- Ubah Password -->
            <div style="margin-top:16px;border-top:1px solid #F1F5F9;padding-top:14px;">
                <div style="font-family:'Outfit',sans-serif;font-size:13.5px;font-weight:700;color:#1E293B;margin-bottom:10px;display:flex;align-items:center;gap:6px;">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    Ubah Password <span style="font-size:11px;font-weight:400;color:#94A3B8;">(Opsional)</span>
                </div>

                <div class="form-group">
                    <label class="form-label">Password Saat Ini</label>
                    <input type="password" name="current_password" class="form-control" placeholder="Isi jika ingin mengganti password">
                </div>

                <div class="form-grid-2">
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Password Baru</label>
                        <input type="password" name="new_password" class="form-control" placeholder="Min. 6 karakter">
                    </div>
                    <div class="form-group" style="margin-bottom:0;">
                        <label class="form-label">Konfirmasi Password</label>
                        <input type="password" name="new_password_confirmation" class="form-control" placeholder="Ulangi password">
                    </div>
                </div>
            </div>

            <div class="modal-footer" style="margin-top:20px;">
                <button type="button" class="btn-cancel" onclick="closeModal('profileModal')">Tutup</button>
                <button type="submit" class="btn-primary" style="background:#2D4E9E;">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi Logout Admin Sistem -->
<div id="logoutConfirmModal" class="modal-overlay">
    <div class="modal-card" style="max-width: 400px; text-align: center;">
        <div style="width: 52px; height: 52px; border-radius: 50%; background: #FFF1F2; color: #E11D48; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 14px;">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
            </svg>
        </div>
        <div style="font-family: 'Outfit', sans-serif; font-size: 18px; font-weight: 700; color: #1E293B; margin-bottom: 6px;">Konfirmasi Keluar</div>
        <p style="font-size: 13px; color: #64748B; margin-bottom: 20px; line-height: 1.5;">
            Apakah Anda yakin ingin keluar dari sesi Admin Sistem? Anda harus login kembali untuk mengakses panel ini.
        </p>
        <div style="display: flex; gap: 10px; justify-content: center;">
            <button type="button" class="btn-cancel" onclick="closeModal('logoutConfirmModal')" style="flex: 1;">Batal</button>
            <button type="button" onclick="document.getElementById('logoutForm').submit()" style="flex: 1; padding: 8px 18px; border-radius: var(--radius-md); background: #E11D48; color: #FFFFFF; border: none; font-size: 13px; font-weight: 600; cursor: pointer; transition: background 0.15s;" onmouseover="this.style.background='#BE123C'" onmouseout="this.style.background='#E11D48'">Ya, Keluar</button>
        </div>
    </div>
</div>

<!-- Toast Notifications Container -->
<div class="sinfas-toast-container" id="toastContainer">
    @if(session('success'))
        <div class="sinfas-toast-card" id="sessionToast">
            <div class="toast-icon-circle success">✓</div>
            <div class="toast-text-wrap">
                <div class="toast-title">{{ session('toast_title') ?? session('success') }}</div>
                <div class="toast-subtitle">{{ session('toast_subtitle') ?? 'Data berhasil disimpan ke sistem.' }}</div>
            </div>
            <button type="button" class="toast-close-btn" onclick="this.closest('.sinfas-toast-card').remove()">&times;</button>
        </div>
    @endif
    @if(session('error'))
        <div class="sinfas-toast-card" id="sessionToastErr">
            <div class="toast-icon-circle error">✗</div>
            <div class="toast-text-wrap">
                <div class="toast-title">{{ session('toast_title') ?? session('error') }}</div>
                <div class="toast-subtitle">{{ session('toast_subtitle') ?? 'Terjadi kesalahan, periksa input Anda.' }}</div>
            </div>
            <button type="button" class="toast-close-btn" onclick="this.closest('.sinfas-toast-card').remove()">&times;</button>
        </div>
    @endif
</div>

<script>
    function openModal(id) {
        const m = document.getElementById(id);
        if (m) { m.classList.add('active'); m.classList.add('open'); }
    }
    function closeModal(id) {
        const m = document.getElementById(id);
        if (m) { m.classList.remove('active'); m.classList.remove('open'); }
    }
    function openProfileModal() { openModal('profileModal'); }
    function openLogoutModal() { openModal('logoutConfirmModal'); }

    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.classList.remove('active');
            e.target.classList.remove('open');
        }
    });

    window.showSinfasToast = function(type, title, subtitle) {
        const container = document.getElementById('toastContainer');
        if (!container) return;
        const toast = document.createElement('div');
        toast.className = 'sinfas-toast-card';
        const icon = type === 'success' ? '✓' : '✗';
        const iconClass = type === 'success' ? 'success' : 'error';
        const sub = subtitle || (type === 'success' ? 'Data berhasil disimpan.' : 'Terjadi kesalahan.');
        toast.innerHTML = `
            <div class="toast-icon-circle ${iconClass}">${icon}</div>
            <div class="toast-text-wrap">
                <div class="toast-title">${title}</div>
                <div class="toast-subtitle">${sub}</div>
            </div>
            <button type="button" class="toast-close-btn" onclick="this.closest('.sinfas-toast-card').remove()">&times;</button>
        `;
        container.appendChild(toast);
        setTimeout(() => {
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(10px)';
            setTimeout(() => toast.remove(), 250);
        }, 4000);
    };

    setTimeout(function() {
        document.querySelectorAll('.sinfas-toast-card').forEach(function(el) {
            el.style.opacity = '0';
            el.style.transform = 'translateY(10px)';
            setTimeout(() => el.remove(), 250);
        });
    }, 4000);
</script>

@yield('scripts')
</body>
</html>
