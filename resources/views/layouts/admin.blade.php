<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Sarana') - SINFAS</title>

    <!-- Google Fonts: Gorditas + Poppins (sama dengan login) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gorditas:wght@400;700&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --blue-start:  #4A6FA5;
            --blue-mid:    #6B8DD6;
            --blue-end:    #8E9AAF;
            --blue-dark:   #2C4A7C;
            --blue-light:  #7BA7D9;
            --blue-border: #3B5998;
            --blue-focus:  #5B8DEF;
            --text-dark:   #0F172A;
            --text-muted:  #64748B;
            --border-col:  #E2E8F0;
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: #F0F2F5;
            overflow-x: hidden;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 265px;
            min-width: 265px;
            background: rgba(255,255,255,0.97);
            border-right: 3px solid var(--blue-border);
            border-radius: 0 20px 20px 0;
            display: flex;
            flex-direction: column;
            padding: 28px 18px 24px;
            min-height: 100vh;
            position: sticky;
            top: 0;
            height: 100vh;
            overflow-y: auto;
            box-shadow: 4px 0 24px rgba(44,74,124,.18);
            z-index: 50;
        }

        /* Sidebar full putih - tidak ada pseudo-element berwarna */

        .sidebar-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 32px;
            padding-left: 4px;
        }

        .sidebar-logo-icon {
            width: 38px;
            height: 38px;
            background: #EFF6FF;
            border: 2px solid var(--blue-border);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(44,74,124,.15);
            flex-shrink: 0;
        }

        .sidebar-logo-icon svg { color: var(--blue-dark); }

        .sidebar-title {
            font-family: 'Gorditas', cursive;
            font-size: 20px;
            font-weight: 700;
            color: var(--blue-dark);
            letter-spacing: 0.5px;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1;
        }

        .nav-item {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 11px 16px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            color: #1E293B;
            transition: all 0.2s ease;
            border: 2px solid transparent;
        }

        .nav-item:hover {
            background: rgba(59,89,152,.08);
            border-color: rgba(59,89,152,.2);
            transform: translateX(3px);
        }

        .nav-item.active {
            background: #1D4ED8;
            color: #FFFFFF;
            font-weight: 600;
            border-color: transparent;
            box-shadow: 0 4px 14px rgba(29,78,216,.25);
        }

        .nav-item.active svg { stroke: #FFFFFF; }
        .nav-item svg { stroke: #64748B; flex-shrink: 0; transition: stroke 0.2s; }

        .sidebar-spacer {
            margin: 16px 0;
            height: 1px;
            background: linear-gradient(to right, transparent, var(--blue-border), transparent);
            opacity: 0.35;
        }

        .sidebar-user {
            margin-top: auto;
            padding-top: 16px;
            border-top: 2px solid rgba(59,89,152,.2);
            display: flex;
            align-items: center;
            gap: 10px;
            padding-left: 4px;
        }

        .user-avatar {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: #EFF6FF;
            border: 2px solid var(--blue-border);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .user-info { display: flex; flex-direction: column; }
        .user-name { font-size: 14px; font-weight: 600; color: #1E293B; line-height: 1.2; }
        .user-role { font-size: 11.5px; color: var(--text-muted); margin-top: 2px; }

        /* MAIN */
        .main-wrapper { flex: 1; display: flex; flex-direction: column; min-height: 100vh; background: #F0F2F5; }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 32px;
            background: #FFFFFF;
            border-bottom: 1px solid #E8ECF0;
            box-shadow: 0 1px 4px rgba(0,0,0,.06);
        }

        .page-title {
            font-family: 'Poppins', sans-serif;
            font-size: 15px;
            font-weight: 600;
            color: #1E293B;
        }

        .topbar-actions { display: flex; align-items: center; gap: 12px; }

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
            color: #1E293B;
            transition: all 0.2s ease;
        }

        .topbar-btn:hover { background: #F1F5F9; transform: scale(1.05); }

        .page-content {
            padding: 24px 32px 36px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            flex: 1;
        }

        /* Alerts */
        .alert-sinfas { padding: 12px 18px; border-radius: 10px; font-size: 14px; display: flex; align-items: center; gap: 10px; margin-bottom: 4px; }
        .alert-success { background: #DCFCE7; color: #15803D; border: 1px solid #BBF7D0; }
        .alert-danger  { background: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA; }

        /* MODAL */
        .modal-overlay {
            position: fixed; inset: 0;
            background: rgba(15,23,42,.5);
            display: flex; align-items: center; justify-content: center;
            z-index: 1000; opacity: 0; pointer-events: none;
            transition: all 0.25s ease; backdrop-filter: blur(4px);
        }
        .modal-overlay.active { opacity: 1; pointer-events: auto; }

        .modal-card {
            background: #FFFFFF;
            border: 2px solid var(--blue-border);
            border-radius: 20px;
            padding: 28px;
            width: 90%; max-width: 540px;
            box-shadow: 0 20px 50px rgba(44,74,124,.25);
            transform: translateY(24px) scale(0.97);
            transition: transform 0.25s ease;
        }
        .modal-overlay.active .modal-card { transform: translateY(0) scale(1); }

        .modal-card-top {
            height: 6px;
            background: linear-gradient(to right, var(--blue-mid), var(--blue-dark));
            border-radius: 18px 18px 0 0;
            margin: -28px -28px 20px;
        }

        .modal-header {
            display: flex; align-items: center; justify-content: space-between;
            margin-bottom: 18px; padding-bottom: 12px; border-bottom: 1.5px solid var(--border-col);
        }

        .modal-title { font-family: 'Gorditas', cursive; font-size: 17px; font-weight: 700; color: var(--text-dark); }

        .modal-close-btn { background: none; border: none; font-size: 22px; color: var(--text-muted); cursor: pointer; line-height: 1; transition: color 0.2s; }
        .modal-close-btn:hover { color: #DC2626; }

        .modal-footer { display: flex; align-items: center; justify-content: flex-end; gap: 12px; margin-top: 20px; padding-top: 14px; border-top: 1.5px solid var(--border-col); }

        .btn-cancel {
            padding: 9px 20px; border-radius: 8px; background: #F1F5F9; color: #475569;
            border: 1.5px solid #CBD5E1; font-size: 13.5px; font-weight: 500; cursor: pointer; transition: all 0.2s;
        }
        .btn-cancel:hover { background: #E2E8F0; }

        .btn-submit {
            padding: 9px 22px; border-radius: 8px;
            background: linear-gradient(to right, var(--blue-light), var(--blue-dark));
            color: #FFFFFF; border: none; font-size: 13.5px; font-weight: 600;
            cursor: pointer; transition: all 0.3s ease; box-shadow: 0 4px 12px rgba(44,74,124,.25);
        }
        .btn-submit:hover { transform: scale(1.02); filter: brightness(1.08); box-shadow: 0 6px 18px rgba(44,74,124,.35); }

        /* Forms */
        .form-group { margin-bottom: 14px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: #1E293B; margin-bottom: 6px; }
        .form-control {
            width: 100%; padding: 10px 14px; border: 2px solid #CBD5E1; border-radius: 8px;
            font-size: 13.5px; color: #0F172A; outline: none; font-family: 'Poppins', sans-serif;
            transition: border-color 0.25s, box-shadow 0.25s; background: #FFFFFF;
        }
        .form-control:focus { border-color: var(--blue-focus); box-shadow: 0 0 0 3px rgba(91,141,239,.2); }

        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(59,89,152,.3); border-radius: 4px; }
    </style>

    @yield('styles')
</head>
<body>

    <div class="admin-layout">

        <!-- SIDEBAR -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo-icon">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="3" width="18" height="18" rx="3" ry="3"></rect>
                    </svg>
                </div>
                <div class="sidebar-title">SINFAS Admin</div>
            </div>

            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                    <span>Beranda</span>
                </a>

                <a href="{{ route('admin.barang.index') }}" class="nav-item {{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                        <line x1="12" y1="22.08" x2="12" y2="12"></line>
                    </svg>
                    <span>Kelola Alat</span>
                </a>

                <a href="{{ route('admin.kategori.index') }}" class="nav-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path>
                    </svg>
                    <span>Kelola Kategori</span>
                </a>

                <a href="{{ route('admin.verifikasi.index') }}" class="nav-item {{ request()->routeIs('admin.verifikasi.*') ? 'active' : '' }}">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 11l3 3L22 4"></path>
                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                    </svg>
                    <span>Verifikasi Pinjam &amp; Kembali</span>
                </a>

                <div class="sidebar-spacer"></div>

                <a href="javascript:void(0)" onclick="openProfileModal()" class="nav-item">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Profil</span>
                </a>

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

            <div class="sidebar-user">
                <div class="user-avatar">
                    <svg width="38" height="38" viewBox="0 0 48 48" fill="none">
                        <circle cx="24" cy="24" r="24" fill="#BFDBFE"/>
                        <circle cx="24" cy="18" r="8.5" fill="#FDE68A"/>
                        <path d="M17 16C17 12 20 10 24 10C28 10 31 12 31 16C31 17 30 17 29 17C28 15 26 14 24 14C22 14 20 15 19 17C18 17 17 17 17 16Z" fill="#334155"/>
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

        <!-- MAIN CONTENT -->
        <main class="main-wrapper">
            <header class="topbar">
                <h1 class="page-title">@yield('page_title', 'Beranda')</h1>
                <div class="topbar-actions">
                    <button class="topbar-btn" title="Notifikasi" aria-label="Notifikasi">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="#1E293B">
                            <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2z"/>
                        </svg>
                    </button>
                    <button class="topbar-btn" title="Bantuan" aria-label="Bantuan">
                        <svg width="22" height="22" viewBox="0 0 24 24">
                            <circle cx="12" cy="12" r="11" fill="#1E293B"/>
                            <text x="12" y="16.5" fill="#ffffff" font-size="13" font-weight="bold" text-anchor="middle">?</text>
                        </svg>
                    </button>
                </div>
            </header>

            <div style="padding: 0 32px;">
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

            <div class="page-content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Modal Profil -->
    <div id="profileModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-card-top"></div>
            <div class="modal-header">
                <div class="modal-title">Profil Pengguna</div>
                <button class="modal-close-btn" onclick="closeModal('profileModal')">&times;</button>
            </div>
            <div style="display:flex;align-items:center;gap:16px;margin-bottom:20px;">
                <div style="width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,#7BA7D9,#2C4A7C);border:2px solid #3B5998;display:flex;align-items:center;justify-content:center;font-family:'Gorditas',cursive;font-size:24px;font-weight:700;color:#fff;">
                    {{ substr(Auth::user()->nama ?? 'A', 0, 1) }}
                </div>
                <div>
                    <div style="font-size:16px;font-weight:600;color:#0F172A;">{{ Auth::user()->nama ?? 'Admin Sarana' }}</div>
                    <div style="font-size:13px;color:#64748B;">Username: {{ Auth::user()->username ?? 'admin' }}</div>
                    <div style="font-size:13px;color:#3B5998;font-weight:500;">Role: {{ Auth::user()->role ?? 'admin_sarana' }}</div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-cancel" onclick="closeModal('profileModal')">Tutup</button>
            </div>
        </div>
    </div>

    <script>
        function openModal(id) {
            const el = document.getElementById(id);
            if (el) el.classList.add('active');
        }
        function closeModal(id) {
            const el = document.getElementById(id);
            if (el) el.classList.remove('active');
        }
        function openProfileModal() { openModal('profileModal'); }
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.classList.remove('active');
            }
        });
    </script>

    @yield('scripts')
</body>
</html>
