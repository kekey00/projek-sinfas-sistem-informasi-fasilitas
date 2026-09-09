<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Sarana') - SINFAS</title>

    <!-- Google Fonts: Baloo 2 + Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
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

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-canvas);
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ─── SIDEBAR SINFAS ADMIN (SESUAI TAMPILAN LOGIN & REFERENSI) ─── */
        .sidebar {
            width: 265px;
            min-width: 265px;
            background: linear-gradient(180deg, var(--color-royal-blue-start) 0%, var(--color-border-blue) 48%, var(--color-dark-blue-bubble) 100%);
            border-right: 2px solid var(--color-border-blue);
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            padding: 24px 20px 24px;
            min-height: 100vh;
            box-shadow: 4px 0 20px rgba(44, 74, 124, 0.18);
            z-index: 50;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        /* 1. Header Profil Admin Sarana (di Bagian Atas Sidebar) */
        .sidebar-user-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 4px 4px 18px 4px;
            border-bottom: 1.5px solid rgba(123, 167, 217, 0.45);
            margin-bottom: 20px;
        }

        .user-avatar-top {
            width: 46px;
            height: 46px;
            border-radius: 50%;
            background: #EFF6FF;
            border: 2px solid #FFFFFF;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .user-info-top {
            display: flex;
            flex-direction: column;
        }

        .user-role-top {
            font-family: 'Baloo 2', sans-serif;
            font-size: 13px;
            color: #FFFFFF;
            line-height: 1.1;
            letter-spacing: 0.3px;
            opacity: .8;
        }
        .user-name-top {
            font-family: 'Baloo 2', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #FFFFFF;
            line-height: 1.2;
            margin-top: 2px;
        }

        /* 2. Section Navigasi (Menu & Account) */
        .sidebar-section {
            margin-bottom: 20px;
        }

        .sidebar-section-divider {
            border-bottom: 1.5px solid rgba(123, 167, 217, 0.45);
            margin: 18px 0 20px 0;
        }

        .section-heading {
            font-family: 'Baloo 2', sans-serif;
            font-size: 11px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.5);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 8px;
            padding-left: 12px;
        }

        .sidebar-nav-list {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .nav-link-gorditas {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 10px;
            font-family: 'Baloo 2', sans-serif;
            font-size: 14px;
            font-weight: 600;
            color: rgba(255,255,255,.82);
            transition: all 0.18s ease;
        }
        .nav-link-gorditas svg {
            width: 17px; height: 17px;
            stroke-width: 2.1; flex-shrink: 0; opacity: .8;
        }

        .nav-link-gorditas:hover {
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            transform: translateX(3px);
        }
        .nav-link-gorditas.active {
            background: rgba(255, 255, 255, 0.18);
            color: #FFFFFF;
            font-weight: 700;
            border-left: 3px solid rgba(255,255,255,.8);
        }
        .nav-link-gorditas.active svg { opacity: 1; }

        /* ─── MAIN CONTENT ───────────────────────────────────── */
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
            padding: 16px 36px;
            background: #FFFFFF;
            border-bottom: 1px solid var(--border-color);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.03);
        }

        .page-title {
            font-family: 'Baloo 2', sans-serif;
            font-size: 18px;
            font-weight: 700;
            color: #0F172A;
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .topbar-btn {
            background: transparent;
            border: none;
            cursor: pointer;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0F172A;
            transition: all 0.2s ease;
        }

        .topbar-btn:hover {
            background: rgba(0, 0, 0, 0.05);
            transform: scale(1.05);
        }

        /* Container Isi Halaman */
        .page-content {
            padding: 24px 36px 36px 36px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            flex: 1;
        }

        /* Alert Notification */
        .alert-sinfas {
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 6px;
        }

        .alert-success {
            background: #DCFCE7;
            color: #15803D;
            border: 1px solid #BBF7D0;
        }

        .alert-danger {
            background: #FEE2E2;
            color: #B91C1C;
            border: 1px solid #FECACA;
        }

        /* Modal Global SINFAS (Sama dengan Card Login) */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(15, 23, 42, 0.45);
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

        .modal-card {
            background: #FFFFFF;
            border: 2.5px solid var(--color-border-blue);
            border-radius: 18px;
            padding: 26px;
            width: 90%;
            max-width: 540px;
            box-shadow: 0 15px 40px rgba(44, 74, 124, 0.2);
            transform: translateY(20px);
            transition: transform 0.25s ease;
            position: relative;
            overflow: hidden;
        }

        .modal-overlay.active .modal-card {
            transform: translateY(0);
        }

        .modal-card-top {
            height: 5px;
            background: linear-gradient(to right, var(--color-light-blue-bubble), var(--color-dark-blue-bubble));
            margin: -26px -26px 20px -26px;
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1.5px solid var(--border-color);
        }

        .modal-title {
            font-family: 'Gorditas', cursive;
            font-size: 17px;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: 0.3px;
        }

        .modal-close-btn {
            background: none;
            border: none;
            font-size: 22px;
            color: var(--text-muted);
            cursor: pointer;
            line-height: 1;
            transition: color 0.15s;
        }

        .modal-close-btn:hover {
            color: #DC2626;
        }

        .modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 20px;
            padding-top: 14px;
            border-top: 1.5px solid var(--border-color);
        }

        .btn-cancel {
            padding: 9px 18px;
            border-radius: 8px;
            background: #F1F5F9;
            color: #475569;
            border: 1.5px solid #CBD5E1;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.15s;
            font-family: 'Poppins', sans-serif;
        }

        .btn-cancel:hover {
            background: #E2E8F0;
        }

        /* Button Gradient SINFAS (Sama dengan Tombol Login) */
        .btn-submit {
            padding: 9px 24px;
            border-radius: 8px;
            background: linear-gradient(to right, var(--color-light-blue-bubble), var(--color-dark-blue-bubble));
            color: #FFFFFF;
            border: none;
            font-family: 'Gorditas', 'Poppins', sans-serif;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.25s ease;
            box-shadow: 0 4px 12px rgba(44, 74, 124, 0.25);
            letter-spacing: 0.3px;
        }

        .btn-submit:hover {
            transform: scale(1.02);
            filter: brightness(1.08);
            box-shadow: 0 6px 16px rgba(44, 74, 124, 0.35);
        }

        /* Form Utility */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 2px solid var(--color-border-blue);
            border-radius: 8px;
            font-size: 13.5px;
            color: #0F172A;
            outline: none;
            font-family: 'Poppins', sans-serif;
            transition: border-color 0.2s, box-shadow 0.2s;
            background: #FFFFFF;
        }

        .form-control:focus {
            border-color: var(--color-focus-blue);
            box-shadow: 0 0 8px rgba(91, 141, 239, 0.35);
        }

        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.25);
            border-radius: 4px;
        }
    </style>

    @yield('styles')
</head>
<body>

    <div class="admin-layout">

        <!-- ─── SIDEBAR SINFAS ADMIN (TAMPILAN LOGIN & FIGMA) ─── -->
        <aside class="sidebar">
            
            <!-- 1. Header Profil Admin Sarana -->
            <div class="sidebar-user-header">
                <div class="user-avatar-top">
                    <svg width="42" height="42" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="24" fill="#BFDBFE"/>
                        <circle cx="24" cy="18" r="8.5" fill="#FDE68A"/>
                        <path d="M17 16C17 12 20 10 24 10C28 10 31 12 31 16C31 17 30 17 29 17C28 15 26 14 24 14C22 14 20 15 19 17C18 17 17 17 17 16Z" fill="#334155"/>
                        <path d="M10 44C10 33 16 29 24 29C32 29 38 33 38 44H10Z" fill="#1E293B"/>
                        <polygon points="20,29 24,35 28,29" fill="#FFFFFF"/>
                        <polygon points="23,33 25,33 24.5,42 23.5,42" fill="#DC2626"/>
                    </svg>
                </div>
                <div class="user-info-top">
                    <span class="user-role-top">Admin</span>
                    <span class="user-name-top">Sarana</span>
                </div>
            </div>

            <!-- 2. Bagian Menu -->
            <div class="sidebar-section">
                <div class="section-heading">MENU</div>
                <nav class="sidebar-nav-list">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link-gorditas {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                        Home
                    </a>
                    <a href="{{ route('admin.barang.index') }}" class="nav-link-gorditas {{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        </svg>
                        Kelola Data Alat
                    </a>
                    <a href="{{ route('admin.kategori.index') }}" class="nav-link-gorditas {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="8" y1="6" x2="21" y2="6"/><line x1="8" y1="12" x2="21" y2="12"/><line x1="8" y1="18" x2="21" y2="18"/>
                            <line x1="3" y1="6" x2="3.01" y2="6"/><line x1="3" y1="12" x2="3.01" y2="12"/><line x1="3" y1="18" x2="3.01" y2="18"/>
                        </svg>
                        Kelola Kategori
                    </a>
                    <a href="{{ route('admin.verifikasi.index') }}" class="nav-link-gorditas {{ request()->routeIs('admin.verifikasi.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 11 12 14 22 4"/>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                        </svg>
                        Verifikasi Pengajuan
                    </a>
                </nav>
            </div>

            <div class="sidebar-section-divider"></div>

            <!-- 3. Bagian Account -->
            <div class="sidebar-section">
                <div class="section-heading">AKUN</div>
                <nav class="sidebar-nav-list">
                    <a href="javascript:void(0)" onclick="openProfileModal()" class="nav-link-gorditas">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                        Profil
                    </a>
                    <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                        @csrf
                        <a href="javascript:void(0)" onclick="document.getElementById('logoutForm').submit()" class="nav-link-gorditas" style="color:rgba(255,160,160,.85);">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                                <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                            </svg>
                            Keluar
                        </a>
                    </form>
                </nav>
            </div>

        </aside>

        <!-- ─── MAIN CONTENT ───────────────────────────────────── -->
        <main class="main-wrapper">
            <!-- Topbar -->
            <header class="topbar">
                <h1 class="page-title">@yield('page_title', 'Home')</h1>
                <div class="topbar-actions">
                    <!-- Bell Icon -->
                    <button class="topbar-btn" title="Notifikasi" aria-label="Notifikasi">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="#000000">
                            <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                        </svg>
                    </button>

                    <!-- Help Question Icon -->
                    <button class="topbar-btn" title="Bantuan" aria-label="Bantuan">
                        <svg width="22" height="22" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="11" fill="#000000"/>
                            <text x="12" y="16.5" fill="#ffffff" font-size="14" font-weight="bold" text-anchor="middle" font-family="'Poppins', sans-serif">?</text>
                        </svg>
                    </button>
                </div>
            </header>

            <!-- Alerts -->
            <div style="padding: 0 36px;">
                @if(session('success'))
                    <div class="alert-sinfas alert-success">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert-sinfas alert-danger">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
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

    <!-- Modal Profil Admin Sarana (Tema Login SINFAS) -->
    <div id="profileModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-card-top"></div>
            <div class="modal-header">
                <div class="modal-title">Profil Pengguna</div>
                <button class="modal-close-btn" onclick="closeModal('profileModal')">&times;</button>
            </div>
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: linear-gradient(135deg, var(--color-light-blue-bubble), var(--color-dark-blue-bubble)); border: 2px solid var(--color-border-blue); display: flex; align-items: center; justify-content: center; font-family: 'Gorditas', cursive; font-size: 24px; font-weight: 700; color: #FFFFFF; box-shadow: 0 4px 12px rgba(44, 74, 124, 0.25);">
                    {{ substr(Auth::user()->nama ?? 'A', 0, 1) }}
                </div>
                <div>
                    <div style="font-family: 'Gorditas', cursive; font-size: 16px; font-weight: 700; color: #0F172A;">{{ Auth::user()->nama ?? 'Admin Sarana' }}</div>
                    <div style="font-size: 13px; color: #64748B;">Username: {{ Auth::user()->username ?? 'admin' }}</div>
                    <div style="font-size: 13px; color: var(--color-border-blue); font-weight: 600;">Role: {{ Auth::user()->role ?? 'admin_sarana' }}</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('profileModal')">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) modal.classList.add('active');
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) modal.classList.remove('active');
        }

        function openProfileModal() {
            openModal('profileModal');
        }

        // Close when clicking outside
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.classList.remove('active');
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
