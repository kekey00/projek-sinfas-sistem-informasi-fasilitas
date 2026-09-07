<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Sistem') - SINFAS</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gorditas:wght@400;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            /* Warna SINFAS Khas Tampilan Login */
            --color-royal-blue-start:  #4A6FA5;
            --color-royal-blue-mid:    #6B8DD6;
            --color-royal-blue-end:    #8E9AAF;
            --color-dark-blue-bubble:  #2C4A7C;
            --color-light-blue-bubble: #7BA7D9;
            --color-border-blue:       #3B5998;
            --color-focus-blue:        #5B8DEF;

            --bg-canvas:    #F4F6F9;
            --text-dark:    #0F172A;
            --text-muted:   #64748B;
            --border-color: #E2E8F0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--bg-canvas);
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ─── SIDEBAR SINFAS KHAS TAMPILAN LOGIN ─── */
        .sidebar {
            width: 235px;
            min-width: 235px;
            background: linear-gradient(180deg, var(--color-royal-blue-start) 0%, var(--color-border-blue) 48%, var(--color-dark-blue-bubble) 100%);
            border-right: 2.5px solid var(--color-border-blue);
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            padding: 0;
            min-height: 100vh;
            box-shadow: 4px 0 22px rgba(44, 74, 124, 0.2);
            z-index: 50;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        /* Sidebar Brand */
        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 22px 18px 18px;
            border-bottom: 1.5px solid rgba(123, 167, 217, 0.45);
            margin-bottom: 14px;
        }

        .brand-icon {
            width: 34px;
            height: 34px;
            border-radius: 8px;
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(44, 74, 124, 0.25);
        }

        .brand-text {
            font-family: 'Gorditas', cursive;
            font-size: 16.5px;
            font-weight: 700;
            color: #FFFFFF;
            letter-spacing: 0.5px;
            line-height: 1.2;
            text-shadow: 1px 2px 3px rgba(0, 0, 0, 0.2);
        }

        /* Nav Section */
        .nav-section {
            padding: 0 12px;
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            border-radius: 10px;
            text-decoration: none;
            color: #FFFFFF;
            font-size: 13.5px;
            font-weight: 500;
            transition: all 0.2s ease;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #FFFFFF;
            transform: translateX(2px);
        }

        .nav-item.active {
            background: #FFFFFF !important;
            color: var(--color-border-blue) !important;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(44, 74, 124, 0.2);
        }

        .nav-item.active svg {
            stroke: var(--color-border-blue);
        }

        .nav-item svg {
            flex-shrink: 0;
        }

        .nav-divider {
            height: 1.5px;
            background: rgba(123, 167, 217, 0.45);
            margin: 16px 14px;
        }

        /* Sidebar Bottom User */
        .sidebar-bottom {
            margin-top: auto;
            padding: 16px 14px 20px;
            border-top: 1.5px solid rgba(123, 167, 217, 0.45);
        }

        .user-card-bottom {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 6px 4px;
        }

        .user-avatar-bottom {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #EFF6FF;
            border: 2px solid #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-border-blue);
            font-size: 13px;
            font-weight: 700;
            flex-shrink: 0;
            overflow: hidden;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
        }

        .user-info-bottom { overflow: hidden; }

        .user-name-bottom {
            font-family: 'Gorditas', cursive;
            font-size: 13.5px;
            font-weight: 700;
            color: #FFFFFF;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            line-height: 1.2;
            letter-spacing: 0.3px;
        }

        .user-role-bottom {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.8);
            margin-top: 2px;
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
            padding: 14px 30px;
            background: #FFFFFF;
            border-bottom: 2px solid var(--color-border-blue);
            position: sticky;
            top: 0;
            z-index: 40;
            height: 56px;
            box-shadow: 0 2px 8px rgba(44, 74, 124, 0.05);
        }

        .topbar-left {
            display: flex;
            align-items: center;
        }

        .page-title {
            font-family: 'Gorditas', cursive;
            font-size: 16px;
            font-weight: 700;
            color: var(--color-dark-blue-bubble);
            letter-spacing: 0.3px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .topbar-icon-btn {
            background: none;
            border: none;
            cursor: pointer;
            color: var(--color-border-blue);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 6px;
            border-radius: 50%;
            transition: color 0.15s, background 0.15s;
        }

        .topbar-icon-btn:hover {
            color: var(--color-dark-blue-bubble);
            background: #EFF6FF;
        }

        /* Content */
        .page-content {
            padding: 24px 32px 36px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            flex: 1;
        }

        /* Alert */
        .alert-sys {
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background: #E8F5E9;
            color: #2E7D32;
            border: 1px solid #A5D6A7;
        }

        .alert-danger {
            background: #FFEBEE;
            color: #C62828;
            border: 1px solid #EF9A9A;
        }

        /* Modal Overlay */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(13, 27, 42, 0.5);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: all 0.25s ease;
            backdrop-filter: blur(4px);
        }

        .modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-box {
            background: #FFFFFF;
            border-radius: 18px;
            border: 2.5px solid var(--color-border-blue);
            padding: 28px;
            width: 90%;
            max-width: 520px;
            box-shadow: 0 20px 50px rgba(44, 74, 124, 0.2);
            transform: translateY(20px) scale(0.98);
            transition: transform 0.25s ease;
            max-height: 90vh;
            overflow-y: auto;
        }

        .modal-overlay.active .modal-box {
            transform: translateY(0) scale(1);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 14px;
            border-bottom: 2px solid var(--border-color);
        }

        .modal-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--color-dark-blue-bubble);
            font-family: 'Gorditas', cursive;
            letter-spacing: 0.3px;
        }

        .modal-close {
            background: none;
            border: none;
            font-size: 22px;
            color: #90A4AE;
            cursor: pointer;
            line-height: 1;
            transition: color 0.15s;
        }

        .modal-close:hover { color: #C62828; }

        .modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 22px;
            padding-top: 14px;
            border-top: 2px solid var(--border-color);
        }

        /* Form */
        .form-group { margin-bottom: 14px; }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: var(--color-dark-blue-bubble);
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 9px 14px;
            border: 2px solid #CBD5E1;
            border-radius: 10px;
            font-size: 13.5px;
            color: var(--text-dark);
            outline: none;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #FFFFFF;
        }

        .form-control:focus {
            border-color: var(--color-focus-blue);
            box-shadow: 0 0 0 3px rgba(91, 141, 239, 0.2);
        }

        .form-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        /* Buttons */
        .btn-cancel {
            padding: 8px 20px;
            border-radius: 10px;
            background: #F8FAFC;
            color: var(--text-muted);
            border: 2px solid #CBD5E1;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: background 0.15s;
        }

        .btn-cancel:hover { background: #F1F5F9; }

        .btn-primary {
            padding: 8px 22px;
            border-radius: 10px;
            background: linear-gradient(135deg, var(--color-royal-blue-start) 0%, var(--color-border-blue) 100%);
            color: #FFFFFF;
            border: none;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: all 0.2s;
            box-shadow: 0 4px 14px rgba(44, 74, 124, 0.25);
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 18px rgba(44, 74, 124, 0.35);
        }

        .btn-danger {
            padding: 6px 14px;
            border-radius: 7px;
            background: #FFEBEE;
            color: #C62828;
            border: 1.5px solid #EF9A9A;
            font-size: 12.5px;
            font-weight: 500;
            cursor: pointer;
            font-family: 'Poppins', sans-serif;
            transition: all 0.15s;
        }

        .btn-danger:hover { background: #FFCDD2; }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(21, 101, 192, 0.2); border-radius: 4px; }
    </style>

    @yield('styles')
</head>
<body>
<div class="admin-layout">

    <!-- ─── SIDEBAR ─── -->
    <aside class="sidebar">

        <!-- Brand Persis Mockup -->
        <div class="sidebar-brand">
            <div class="brand-icon">
                <!-- White square logo icon -->
            </div>
            <div class="brand-text">SINFAS Admin</div>
        </div>

        <!-- Menu Section -->
        <div class="nav-section">
            <a href="{{ route('sistem.dashboard') }}" class="nav-item {{ request()->routeIs('sistem.dashboard') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                    <polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                Beranda
            </a>

            <a href="{{ route('sistem.akun.index') }}" class="nav-item {{ request()->routeIs('sistem.akun.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                Kelola Akun
            </a>

            <a href="{{ route('sistem.settings.index') }}" class="nav-item {{ request()->routeIs('sistem.settings.*') ? 'active' : '' }}">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                </svg>
                Kelola Sistem
            </a>
        </div>

        <div class="nav-divider"></div>

        <!-- Account Section -->
        <div class="nav-section">
            <a href="javascript:void(0)" onclick="openModal('profileModal')" class="nav-item">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                    <circle cx="12" cy="7" r="4"/>
                </svg>
                Profil
            </a>

            <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                @csrf
                <a href="javascript:void(0)" onclick="document.getElementById('logoutForm').submit()" class="nav-item">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/>
                        <line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    Keluar
                </a>
            </form>
        </div>

        <!-- Bottom User Card -->
        <div class="sidebar-bottom">
            <div class="user-card-bottom">
                <div class="user-avatar-bottom">
                    <svg width="34" height="34" viewBox="0 0 36 36" fill="none">
                        <circle cx="18" cy="18" r="18" fill="#93C5FD"/>
                        <circle cx="18" cy="13" r="5.5" fill="#FDBA74"/>
                        <path d="M12.5 11C12.5 11 14 7.5 18 7.5C22 7.5 23.5 11 23.5 11C23.5 11 21.5 9 18 9C14.5 9 12.5 11 12.5 11Z" fill="#1F2937"/>
                        <path d="M8 32C8 26.5 12.5 23 18 23C23.5 23 28 26.5 28 32" fill="#1E293B"/>
                        <polygon points="15.5,23 18,27.5 20.5,23" fill="#FFFFFF"/>
                        <polygon points="17.2,25.5 18.8,25.5 18.5,31 17.5,31" fill="#DC2626"/>
                    </svg>
                </div>
                <div class="user-info-bottom">
                    <div class="user-name-bottom">{{ Auth::user()->nama ?? 'Admin Sistem' }}</div>
                    <div class="user-role-bottom">Operator</div>
                </div>
            </div>
        </div>

    </aside>

    <!-- ─── MAIN CONTENT ─── -->
    <main class="main-wrapper">

        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <div class="page-title">@yield('page_title', 'Beranda')</div>
            </div>
            <div class="topbar-right">
                <button class="topbar-icon-btn" title="Notifikasi">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="#000000">
                        <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                    </svg>
                </button>
                <button class="topbar-icon-btn" title="Bantuan">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="#000000">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 16h-2v-2h2v2zm1.07-7.75l-.9.92C12.45 11.9 12 12.5 12 14h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.04-.42 1.99-1.07 2.75z"/>
                    </svg>
                </button>
            </div>
        </header>

        <!-- Alerts -->
        <div style="padding: 0 32px;">
            @if(session('success'))
                <div class="alert-sys alert-success" style="margin-top: 16px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="alert-sys alert-danger" style="margin-top: 16px;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif
        </div>

        <!-- Page Body -->
        <div class="page-content">
            @yield('content')
        </div>
    </main>
</div>

<!-- ─── Modal Profil ─── -->
<div id="profileModal" class="modal-overlay">
    <div class="modal-box" style="max-width: 400px;">
        <div class="modal-header">
            <div class="modal-title">Profil Pengguna</div>
            <button class="modal-close" onclick="closeModal('profileModal')">&times;</button>
        </div>
        <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: linear-gradient(135deg, #1565C0, #1A237E); display: flex; align-items: center; justify-content: center; font-family: 'Gorditas', cursive; font-size: 22px; font-weight: 700; color: #FFFFFF; box-shadow: 0 4px 14px rgba(21, 101, 192, 0.35);">
                {{ substr(Auth::user()->nama ?? 'A', 0, 1) }}
            </div>
            <div>
                <div style="font-weight: 700; font-size: 15px; color: #0D1B2A;">{{ Auth::user()->nama ?? 'Admin Sistem' }}</div>
                <div style="font-size: 12.5px; color: #546E7A; margin-top: 2px;">Username: {{ Auth::user()->username ?? 'adminsistem' }}</div>
                <div style="font-size: 12.5px; color: #1565C0; font-weight: 600; margin-top: 2px;">Role: {{ Auth::user()->role ?? 'admin_sistem' }}</div>
            </div>
        </div>
        <div class="modal-footer" style="border-top: 1.5px solid #CFD8DC; padding-top: 14px; margin-top: 0; justify-content: flex-end;">
            <button type="button" class="btn-cancel" onclick="closeModal('profileModal')">Tutup</button>
        </div>
    </div>
</div>

<script>
    function openModal(id) {
        const m = document.getElementById(id);
        if (m) m.classList.add('active');
    }
    function closeModal(id) {
        const m = document.getElementById(id);
        if (m) m.classList.remove('active');
    }
    window.addEventListener('click', function(e) {
        if (e.target.classList.contains('modal-overlay')) {
            e.target.classList.remove('active');
        }
    });
</script>

@yield('scripts')
</body>
</html>
