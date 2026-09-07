<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Sarana') - SINFAS</title>
    
    <!-- Google Fonts: Inter & Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary-blue: #1D4ED8;
            --primary-blue-dark: #1E40AF;
            --sidebar-bg: #1D4ED8;
            --bg-canvas: #F4F5F7;
            --text-dark: #0F172A;
            --text-muted: #64748B;
            --border-color: #E2E8F0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-canvas);
            color: var(--text-dark);
            min-height: 100vh;
            margin: 0;
            display: flex;
            overflow-x: hidden;
        }

        .admin-layout {
            display: flex;
            width: 100vw;
            min-height: 100vh;
        }

        /* ─── SIDEBAR SINFAS ADMIN ───────────────────────────── */
        .sidebar {
            width: 270px;
            min-width: 270px;
            background: var(--sidebar-bg);
            color: #FFFFFF;
            display: flex;
            flex-direction: column;
            padding: 28px 20px 24px;
            min-height: 100vh;
            box-shadow: 4px 0 15px rgba(0, 0, 0, 0.05);
            z-index: 50;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
        }

        /* Header Logo */
        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 36px;
            padding-left: 6px;
        }

        .sidebar-logo-icon {
            width: 34px;
            height: 34px;
            background: #FFFFFF;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
            flex-shrink: 0;
        }

        .sidebar-logo-icon svg {
            color: var(--primary-blue);
        }

        .sidebar-title {
            font-size: 21px;
            font-weight: 700;
            color: #FFFFFF;
            letter-spacing: -0.3px;
        }

        /* Menu Navigasi */
        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 8px;
            flex: 1;
        }

        .nav-item {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 500;
            color: #FFFFFF;
            transition: all 0.2s ease;
        }

        .nav-item:hover {
            background: rgba(255, 255, 255, 0.14);
            transform: translateX(3px);
        }

        /* Active Nav Item: White Pill Button */
        .nav-item.active {
            background: #FFFFFF;
            color: var(--primary-blue);
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        .nav-item.active svg {
            color: var(--primary-blue);
            stroke: var(--primary-blue);
        }

        .nav-item svg {
            color: #FFFFFF;
            stroke: #FFFFFF;
            flex-shrink: 0;
            transition: all 0.2s ease;
        }

        .sidebar-spacer {
            margin: 20px 0;
            height: 1px;
            background: rgba(255, 255, 255, 0.15);
        }

        /* User Profile di Bawah Sidebar */
        .sidebar-user {
            margin-top: auto;
            padding-top: 18px;
            border-top: 1px solid rgba(255, 255, 255, 0.15);
            display: flex;
            align-items: center;
            gap: 12px;
            padding-left: 6px;
        }

        .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #EFF6FF;
            border: 2px solid rgba(255, 255, 255, 0.8);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-name {
            font-size: 14.5px;
            font-weight: 600;
            color: #FFFFFF;
            line-height: 1.2;
        }

        .user-role {
            font-size: 12px;
            color: rgba(255, 255, 255, 0.75);
            margin-top: 2px;
        }

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
            padding: 22px 36px;
            background: transparent;
        }

        .page-title {
            font-size: 20px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 16px;
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
            position: relative;
        }

        .topbar-btn:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        /* Container Isi Halaman */
        .page-content {
            padding: 0 36px 36px 36px;
            display: flex;
            flex-direction: column;
            gap: 24px;
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
            margin-bottom: 8px;
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

        /* Modal Global */
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
            backdrop-filter: blur(3px);
        }

        .modal-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-card {
            background: #FFFFFF;
            border-radius: 16px;
            padding: 24px;
            width: 90%;
            max-width: 540px;
            box-shadow: 0 20px 35px rgba(0, 0, 0, 0.15);
            transform: translateY(20px);
            transition: transform 0.25s ease;
        }

        .modal-overlay.active .modal-card {
            transform: translateY(0);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-title {
            font-size: 17px;
            font-weight: 600;
            color: var(--text-dark);
        }

        .modal-close-btn {
            background: none;
            border: none;
            font-size: 22px;
            color: var(--text-muted);
            cursor: pointer;
            line-height: 1;
        }

        .modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 20px;
            padding-top: 14px;
            border-top: 1px solid var(--border-color);
        }

        .btn-cancel {
            padding: 8px 18px;
            border-radius: 8px;
            background: #F1F5F9;
            color: #475569;
            border: none;
            font-size: 13.5px;
            font-weight: 500;
            cursor: pointer;
        }

        .btn-submit {
            padding: 8px 20px;
            border-radius: 8px;
            background: var(--primary-blue);
            color: #FFFFFF;
            border: none;
            font-size: 13.5px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-submit:hover {
            background: var(--primary-blue-dark);
        }
    </style>

    @yield('styles')
</head>
<body>

    <div class="admin-layout">
        <!-- ─── SIDEBAR ─────────────────────────────────────── -->
        <aside class="sidebar">
            <!-- Header Brand -->
            <div class="sidebar-header">
                <div class="sidebar-logo-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="3" ry="3"></rect>
                    </svg>
                </div>
                <div class="sidebar-title">SINFAS Admin</div>
            </div>

            <!-- Menu List -->
            <nav class="sidebar-nav">
                <!-- 1. Home -->
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span>Home</span>
                </a>

                <!-- 2. Kelola Alat -->
                <a href="{{ route('admin.barang.index') }}" class="nav-item {{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                    <span>Kelola Alat</span>
                </a>

                <!-- 3. Kelola Kategori -->
                <a href="{{ route('admin.kategori.index') }}" class="nav-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <span>Kelola Kategori</span>
                </a>

                <!-- 4. Verifikasi Loan & Return -->
                <a href="{{ route('admin.verifikasi.index') }}" class="nav-item {{ request()->routeIs('admin.verifikasi.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 11l3 3L22 4"></path>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                    <span>Verifikasi Loan &amp; Return</span>
                </a>

                <div class="sidebar-spacer"></div>

                <!-- 5. Profile -->
                <a href="javascript:void(0)" onclick="openProfileModal()" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Profile</span>
                </a>

                <!-- 6. Keluar -->
                <form action="{{ route('logout') }}" method="POST" id="logoutForm">
                    @csrf
                    <a href="javascript:void(0)" onclick="document.getElementById('logoutForm').submit()" class="nav-item">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Keluar</span>
                    </a>
                </form>
            </nav>

            <!-- User Info di Bagian Bawah -->
            <div class="sidebar-user">
                <div class="user-avatar">
                    <svg width="40" height="40" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="24" fill="#93C5FD"/>
                        <!-- Head -->
                        <circle cx="24" cy="18" r="8.5" fill="#FDE68A"/>
                        <path d="M17 16C17 12 20 10 24 10C28 10 31 12 31 16C31 17 30 17 29 17C28 15 26 14 24 14C22 14 20 15 19 17C18 17 17 17 17 16Z" fill="#334155"/>
                        <!-- Suit & Tie -->
                        <path d="M10 44C10 33 16 29 24 29C32 29 38 33 38 44H10Z" fill="#1E293B"/>
                        <polygon points="20,29 24,35 28,29" fill="#FFFFFF"/>
                        <polygon points="23,33 25,33 24.5,42 23.5,42" fill="#DC2626"/>
                    </svg>
                </div>
                <div class="user-info">
                    <span class="user-name">{{ Auth::user()->nama ?? 'Admin Sarana' }}</span>
                    <span class="user-role">Operator</span>
                </div>
            </div>
        </aside>

        <!-- ─── MAIN CONTENT ─────────────────────────────────── -->
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

    <!-- Modal Profil Admin Sarana -->
    <div id="profileModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">Profil Pengguna</div>
                <button class="modal-close-btn" onclick="closeModal('profileModal')">&times;</button>
            </div>
            <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 20px;">
                <div style="width: 60px; height: 60px; border-radius: 50%; background: #EFF6FF; border: 2px solid #1D4ED8; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 700; color: #1D4ED8;">
                    {{ substr(Auth::user()->nama ?? 'A', 0, 1) }}
                </div>
                <div>
                    <div style="font-size: 16px; font-weight: 600;">{{ Auth::user()->nama ?? 'Admin Sarana' }}</div>
                    <div style="font-size: 13px; color: #64748B;">Username: {{ Auth::user()->username ?? 'admin' }}</div>
                    <div style="font-size: 13px; color: #1D4ED8; font-weight: 500;">Role: {{ Auth::user()->role ?? 'admin_sarana' }}</div>
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
