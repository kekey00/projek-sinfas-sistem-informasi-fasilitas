<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/sinfas-logo.svg'))) }}">
    <title>@yield('title', 'SINFAS - Peminjaman Fasilitas Modern')</title>
    <meta name="description" content="Platform modern peminjaman sarana dan fasilitas sekolah/kampus secara instan & transparan.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            /* SINFAS royal-blue palette, shared with the login screen */
            --brand-primary: #3B5998;
            --brand-violet: #5B8DEF;
            --brand-cyan: #06B6D4;
            --brand-pink: #7BA7D9;
            --brand-gradient: linear-gradient(135deg, #7BA7D9 0%, #3B5998 50%, #2C4A7C 100%);
            --brand-gradient-hover: linear-gradient(135deg, #5B8DEF 0%, #2C4A7C 100%);
            --brand-mesh: radial-gradient(at 0% 0%, rgba(91, 141, 239, 0.08) 0px, transparent 50%),
                          radial-gradient(at 100% 0%, rgba(123, 167, 217, 0.06) 0px, transparent 50%),
                          radial-gradient(at 50% 100%, rgba(6, 182, 212, 0.04) 0px, transparent 50%);
            
            --surface: rgba(255, 255, 255, 0.92);
            --surface-card: #FFFFFF;
            --surface-hover: #F8FAFC;
            --bg-base: #F8FAFC;
            --border-subtle: #E2E8F0;
            --border-glow: rgba(91, 141, 239, 0.35);

            --text-main: #0F172A;
            --text-secondary: #475569;
            --text-muted: #94A3B8;

            --badge-green: #10B981;
            --badge-green-bg: #ECFDF5;
            --badge-amber: #F59E0B;
            --badge-amber-bg: #FFFBEB;
            --badge-rose: #F43F5E;
            --badge-rose-bg: #FFF1F2;
            --badge-cyan: #06B6D4;
            --badge-cyan-bg: #ECFEFF;

            --radius-sm: 10px;
            --radius-md: 14px;
            --radius-lg: 20px;
            --radius-pill: 9999px;

            --shadow-subtle: 0 2px 8px rgba(15, 23, 42, 0.04);
            --shadow-card: 0 10px 30px -5px rgba(15, 23, 42, 0.05), 0 4px 10px -2px rgba(15, 23, 42, 0.02);
            --shadow-card-hover: 0 20px 35px -8px rgba(59, 89, 152, 0.16), 0 8px 16px -4px rgba(15, 23, 42, 0.04);
            --shadow-glow: 0 8px 24px -4px rgba(59, 89, 152, 0.35);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-base);
            background-image: var(--brand-mesh);
            background-attachment: fixed;
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        h1, h2, h3, .brand-logo-text {
            font-family: 'Outfit', sans-serif;
        }

        /* GLASS NAVBAR */
        .glass-navbar {
            position: sticky;
            top: 0;
            z-index: 100;
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.2s ease;
        }

        .navbar-shell {
            max-width: 1240px;
            margin: 0 auto;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
        }

        /* LOGO */
        .brand-link {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: var(--brand-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            box-shadow: 0 4px 14px rgba(59, 89, 152, 0.35);
            transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .brand-link:hover .brand-icon {
            transform: scale(1.08) rotate(-4deg);
        }

        .brand-logo-text {
            font-size: 22px;
            font-weight: 900;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #2C4A7C 0%, #3B5998 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .brand-badge-vibe {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            padding: 2px 8px;
            border-radius: var(--radius-pill);
            background: #EEF4FF;
            color: var(--brand-primary);
            border: 1px solid rgba(91, 141, 239, 0.2);
            -webkit-text-fill-color: initial;
        }

        /* PILL NAV TABS */
        .nav-pill-group {
            display: flex;
            align-items: center;
            gap: 6px;
            background: rgba(241, 245, 249, 0.8);
            padding: 4px 6px;
            border-radius: var(--radius-pill);
            border: 1px solid rgba(226, 232, 240, 0.9);
        }

        .nav-pill-item {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 18px;
            border-radius: var(--radius-pill);
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .nav-pill-item:hover {
            color: var(--brand-primary);
        }

        .nav-pill-item.active {
            background: #FFFFFF;
            color: var(--brand-primary);
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.06);
        }

        /* ACTIONS */
        .header-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .icon-action-btn {
            width: 42px;
            height: 42px;
            border-radius: var(--radius-pill);
            background: #FFFFFF;
            border: 1.5px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            cursor: pointer;
            position: relative;
            transition: all 0.2s ease;
            box-shadow: var(--shadow-subtle);
        }

        .icon-action-btn:hover {
            background: #EEF4FF;
            color: var(--brand-primary);
            border-color: rgba(91, 141, 239, 0.4);
            transform: translateY(-2px);
        }

        /* AVATAR RING */
        .avatar-ring-btn {
            width: 44px;
            height: 44px;
            border-radius: var(--radius-pill);
            padding: 2.5px;
            background: linear-gradient(135deg, #7BA7D9, #3B5998, #2C4A7C);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(59, 89, 152, 0.25);
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .avatar-ring-btn:hover {
            transform: scale(1.08) rotate(3deg);
        }

        .avatar-inner {
            width: 100%;
            height: 100%;
            border-radius: var(--radius-pill);
            background: #FFFFFF;
            color: var(--brand-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 800;
        }

        /* DROPDOWN */
        .dropdown-menu-box {
            display: none;
            position: absolute;
            top: 56px;
            right: 0;
            background: #FFFFFF;
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-lg);
            box-shadow: 0 20px 45px -10px rgba(15, 23, 42, 0.15);
            width: 230px;
            z-index: 102;
            padding: 10px;
            animation: dropdownSlide 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .dropdown-menu-box.open { display: block; }

        @keyframes dropdownSlide {
            from { opacity: 0; transform: translateY(-8px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .dropdown-menu-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 14px;
            font-size: 13.5px;
            font-weight: 700;
            color: var(--text-main);
            text-decoration: none;
            border-radius: var(--radius-sm);
            transition: all 0.15s ease;
            border: none;
            width: 100%;
            background: none;
            text-align: left;
            cursor: pointer;
        }

        .dropdown-menu-item:hover {
            background: #EEF4FF;
            color: var(--brand-primary);
            transform: translateX(4px);
        }

        /* FLASHLIST */
        .flash-container {
            max-width: 1240px;
            margin: 18px auto 0;
            padding: 0 24px;
            width: 100%;
        }

        .modern-alert {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 20px;
            border-radius: var(--radius-md);
            font-size: 14px;
            font-weight: 600;
            margin-bottom: 16px;
            backdrop-filter: blur(8px);
            animation: slideInDown 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .modern-alert.alert-success {
            background: #F0FDF4;
            color: #166534;
            border: 1.5px solid #BBF7D0;
            box-shadow: 0 4px 14px rgba(22, 163, 74, 0.1);
        }

        /* Auto-hide animation */
        @keyframes alertFadeOut {
            0%   { opacity: 1; transform: translateY(0); max-height: 80px; margin-bottom: 16px; padding: 12px 20px; }
            70%  { opacity: 0; transform: translateY(-12px); max-height: 80px; margin-bottom: 16px; padding: 12px 20px; }
            100% { opacity: 0; transform: translateY(-12px); max-height: 0; margin-bottom: 0; padding: 0 20px; border-width: 0; }
        }

        .modern-alert.auto-dismiss {
            animation: slideInDown 0.3s cubic-bezier(0.16, 1, 0.3, 1),
                       alertFadeOut 0.5s ease-in-out 4s forwards;
        }

        .modern-alert.alert-error {
            background: #FFF1F2;
            color: #9F1239;
            border: 1.5px solid #FECDD3;
            box-shadow: 0 4px 14px rgba(225, 29, 72, 0.1);
        }

        /* MAIN WRAPPER */
        .app-body {
            flex: 1;
            max-width: 1240px;
            margin: 0 auto;
            padding: 28px 24px 48px;
            width: 100%;
            min-width: 0;
        }

        /* BACK NAVIGATION PILL */
        .back-pill-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 16px;
            border-radius: var(--radius-pill);
            background: #FFFFFF;
            border: 1px solid var(--border-subtle);
            color: var(--text-secondary);
            font-size: 13.5px;
            font-weight: 700;
            text-decoration: none;
            margin-bottom: 22px;
            box-shadow: var(--shadow-subtle);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .back-pill-link:hover {
            color: var(--brand-primary);
            border-color: rgba(91, 141, 239, 0.4);
            transform: translateX(-4px);
            background: #EEF4FF;
        }

        /* MODAL POPUP */
        .modal-shade {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.5);
            backdrop-filter: blur(8px);
            z-index: 999;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .modal-shade.open { display: flex; }

        .modal-box-vibe {
            background: #FFFFFF;
            border-radius: 24px;
            width: 100%;
            max-width: 460px;
            box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.25);
            border: 1px solid rgba(226, 232, 240, 0.8);
            overflow: hidden;
            animation: modalSpring 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-align: center;
            padding: 36px 30px;
            position: relative;
        }

        @keyframes modalSpring {
            from { opacity: 0; transform: scale(0.92) translateY(12px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        .modal-pulse-circle {
            width: 80px;
            height: 80px;
            border-radius: var(--radius-pill);
            background: #EEF4FF;
            color: var(--brand-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            position: relative;
        }

        .modal-pulse-circle::before {
            content: '';
            position: absolute;
            inset: -8px;
            border-radius: var(--radius-pill);
            border: 2px solid rgba(91, 141, 239, 0.3);
            animation: ringPulse 2s cubic-bezier(0.24, 0, 0.38, 1) infinite;
        }

        @keyframes ringPulse {
            0% { transform: scale(0.95); opacity: 0.8; }
            50% { transform: scale(1.15); opacity: 0.2; }
            100% { transform: scale(0.95); opacity: 0.8; }
        }

        .btn-genz-primary {
            background: var(--brand-gradient);
            color: #fff;
            border: none;
            border-radius: var(--radius-md);
            padding: 12px 26px;
            font-size: 14.5px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: var(--shadow-glow);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
        }

        .btn-genz-primary:hover {
            background: var(--brand-gradient-hover);
            transform: translateY(-2px);
            box-shadow: 0 12px 28px -4px rgba(79, 70, 229, 0.45);
        }

        .btn-genz-secondary {
            background: #F1F5F9;
            color: var(--text-main);
            border: 1px solid var(--border-subtle);
            border-radius: var(--radius-md);
            padding: 12px 22px;
            font-size: 14.5px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s ease;
            text-decoration: none;
        }

        .btn-genz-secondary:hover {
            background: #E2E8F0;
        }

        /* FOOTER */
        .glass-footer {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-top: 1px solid var(--border-subtle);
            padding: 20px 24px;
            text-align: center;
            font-size: 13px;
            color: var(--text-muted);
            margin-top: auto;
        }

        @media (max-width: 768px) {
            .navbar-shell { padding: 12px 18px; gap: 12px; }
            .navbar-shell > div:first-child { gap: 12px !important; min-width: 0; }
            .nav-pill-group { display: none; }
            .header-actions { gap: 8px; }
            .app-body { padding: 22px 18px 36px; }
        }

        @media (max-width: 500px) {
            .navbar-shell { padding: 10px 14px; }
            .brand-link { gap: 8px; }
            .brand-icon { width: 36px; height: 36px; }
            .brand-logo-text { font-size: 20px; }
            .header-actions { gap: 6px; }
            .icon-action-btn { width: 36px; height: 36px; }
            .avatar-ring-btn { width: 38px; height: 38px; }
            .app-body { padding: 18px 14px 32px; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- MODERN GLASS NAVBAR -->
    <header class="glass-navbar">
        <div class="navbar-shell">
            <div style="display: flex; align-items: center; gap: 24px;">
                <a href="{{ route('user.dashboard') }}" class="brand-link">
                    @include('components.sinfas-logo', ['class' => 'brand-icon', 'variant' => 'user'])
                    <span class="brand-logo-text">SINFAS</span>
                </a>

                <nav class="nav-pill-group">
                    <a href="{{ route('user.dashboard') }}" class="nav-pill-item {{ request()->routeIs('user.dashboard') || request()->routeIs('user.barang.*') ? 'active' : '' }}" id="nav-katalog">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><rect x="3" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="3" width="7" height="7" rx="1.5"></rect><rect x="14" y="14" width="7" height="7" rx="1.5"></rect><rect x="3" y="14" width="7" height="7" rx="1.5"></rect></svg>
                        <span>Katalog Fasilitas</span>
                    </a>
                    <a href="{{ route('user.status') }}" class="nav-pill-item {{ request()->routeIs('user.status') || request()->routeIs('user.pengembalian.*') ? 'active' : '' }}" id="nav-status">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                        <span>Status Pengajuan</span>
                    </a>
                </nav>
            </div>

            <div class="header-actions">
                <!-- HELP BTN -->
                <button type="button" class="icon-action-btn" onclick="toggleHelpModal()" title="Panduan & Bantuan" id="btn-help-top">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                </button>

                <!-- NOTIF BTN -->
                <button type="button" class="icon-action-btn" onclick="toggleNotifModal()" title="Notifikasi" id="btn-notif-top">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                    @if(isset($userNotifications) && $userNotifications->count() > 0)
                        <span style="position: absolute; top: 5px; right: 5px; min-width: 18px; height: 18px; border-radius: 9px; background: #5B8DEF; box-shadow: 0 0 8px #5B8DEF; color: #fff; font-size: 10px; font-weight: 800; display: flex; align-items: center; justify-content: center; padding: 0 4px;">{{ $userNotifications->count() }}</span>
                    @endif
                </button>

                <!-- USER AVATAR DROPDOWN -->
                <div style="position: relative;">
                    <div class="avatar-ring-btn" onclick="toggleUserDropdown()" id="btn-avatar-top" title="{{ Auth::user()->nama }}">
                        <div class="avatar-inner">
                            {{ strtoupper(substr(Auth::user()->nama ?? 'U', 0, 2)) }}
                        </div>
                    </div>

                    <div class="dropdown-menu-box" id="dropdown-box">
                        <div style="padding: 8px 12px 10px; border-bottom: 1px solid var(--border-subtle); margin-bottom: 6px;">
                            <div style="font-size: 14px; font-weight: 800; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                {{ Auth::user()->nama ?? 'Siswa' }}
                            </div>
                            <div style="font-size: 11.5px; color: var(--text-muted);">NIS: {{ Auth::user()->nis ?? '-' }}</div>
                        </div>

                        <a href="{{ route('user.profile') }}" class="dropdown-menu-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <span>Profil Saya</span>
                        </a>
                        <a href="{{ route('user.status') }}" class="dropdown-menu-item">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                            <span>Status Pinjaman</span>
                        </a>

                        <div style="height: 1px; background: var(--border-subtle); margin: 6px 0;"></div>

                        <form method="POST" action="{{ route('logout') }}" id="userLogoutForm">
                            @csrf
                            <button type="button" onclick="toggleUserLogoutModal()" class="dropdown-menu-item" style="color: var(--badge-rose); width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                <span>Keluar</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- ALERTS -->
    <div class="flash-container">
        @if(session('success'))
            <div class="modern-alert alert-success auto-dismiss" id="alert-success-auto">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 16px;">✨</span>
                    <span>{{ session('success') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" style="background:none; border:none; font-size:18px; cursor:pointer; color:inherit; opacity:0.6;">&times;</button>
            </div>
        @endif

        @if(session('error'))
            <div class="modern-alert alert-error">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <span style="font-size: 16px;">⚠️</span>
                    <span>{{ session('error') }}</span>
                </div>
                <button onclick="this.parentElement.remove()" style="background:none; border:none; font-size:18px; cursor:pointer; color:inherit; opacity:0.6;">&times;</button>
            </div>
        @endif
    </div>

    <!-- MAIN -->
    <main class="app-body">
        @yield('content')
    </main>

    <!-- HELP MODAL -->
    <div class="modal-shade" id="help-modal">
        <div class="modal-box-vibe">
            <div class="modal-pulse-circle">
                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            </div>
            <h3 style="font-size: 22px; font-weight: 800; margin-bottom: 8px;">Cara Pinjam Fasilitas ⚡</h3>
            <div style="text-align: left; font-size: 13.5px; color: var(--text-secondary); line-height: 1.7; margin: 20px 0; background: #F8FAFC; padding: 18px; border-radius: var(--radius-md); border: 1px solid var(--border-subtle);">
                <p style="margin-bottom: 8px;">🔎 <strong>1. Cari fasilitas:</strong> Pilih barang yang ingin dipinjam.</p>
                <p style="margin-bottom: 8px;">📝 <strong>2. Ajukan peminjaman:</strong> Isi keperluan dan tanggal peminjaman.</p>
                <p style="margin-bottom: 8px;">⏳ <strong>3. Tunggu persetujuan:</strong> Admin akan memeriksa pengajuanmu.</p>
                <p>📦 <strong>4. Kembalikan barang:</strong> Unggah foto kondisi barang saat dikembalikan.</p>
            </div>
            <button type="button" class="btn-genz-primary" onclick="toggleHelpModal()" style="width: 100%;">Siap, Paham!</button>
        </div>
    </div>

    <!-- NOTIF MODAL -->
    <div class="modal-shade" id="notif-modal">
        <div class="modal-box-vibe" style="max-width: 520px; padding: 0; text-align: left;">
            <!-- Modal Header -->
            <div style="padding: 24px 28px 16px; border-bottom: 1px solid #F1F5F9; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 42px; height: 42px; border-radius: 50%; background: #FDF2F8; color: #DB2777; display: flex; align-items: center; justify-content: center;">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                    </div>
                    <div>
                        <h3 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0;">Notifikasi</h3>
                        <p style="font-size: 12px; color: #94A3B8; margin: 2px 0 0; font-weight: 500;">
                            @if(isset($userNotifications) && $userNotifications->count() > 0)
                                {{ $userNotifications->count() }} pemberitahuan aktif
                            @else
                                Tidak ada pemberitahuan
                            @endif
                        </p>
                    </div>
                </div>
                <button type="button" onclick="toggleNotifModal()" style="background: #F1F5F9; border: none; width: 34px; height: 34px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #64748B; transition: all 0.2s;" onmouseover="this.style.background='#E2E8F0'" onmouseout="this.style.background='#F1F5F9'">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>

            <!-- Notification List -->
            <div style="max-height: 380px; overflow-y: auto; padding: 12px 16px;">
                @if(isset($userNotifications) && $userNotifications->count() > 0)
                    @foreach($userNotifications as $notif)
                        @php
                            $borderColor = match($notif['type']) {
                                'overdue' => '#FCA5A5',
                                'warning' => '#FCD34D',
                                'pending' => '#93C5FD',
                                'active'  => '#A7F3D0',
                                default   => '#E2E8F0',
                            };
                            $bgColor = match($notif['type']) {
                                'overdue' => '#FEF2F2',
                                'warning' => '#FFFBEB',
                                'pending' => '#EFF6FF',
                                'active'  => '#F0FDF4',
                                default   => '#F8FAFC',
                            };
                            $titleColor = match($notif['type']) {
                                'overdue' => '#DC2626',
                                'warning' => '#D97706',
                                'pending' => '#2563EB',
                                'active'  => '#059669',
                                default   => '#475569',
                            };
                        @endphp
                        <div style="background: {{ $bgColor }}; border: 1.5px solid {{ $borderColor }}; border-radius: 14px; padding: 14px 16px; margin-bottom: 10px; display: flex; align-items: flex-start; gap: 12px; transition: transform 0.15s ease;" onmouseover="this.style.transform='translateX(4px)'" onmouseout="this.style.transform='none'">
                            <div style="font-size: 22px; flex-shrink: 0; margin-top: 1px;">{{ $notif['icon'] }}</div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 4px;">
                                    <span style="font-size: 13px; font-weight: 800; color: {{ $titleColor }};">{{ $notif['title'] }}</span>
                                    <span style="font-size: 10.5px; color: #94A3B8; font-weight: 500; white-space: nowrap;">#{{ Str::limit($notif['kode'], 16) }}</span>
                                </div>
                                <p style="font-size: 12.5px; color: #475569; line-height: 1.55; margin: 0;">{{ $notif['message'] }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <!-- Empty state: Semua Beres -->
                    <div style="text-align: center; padding: 36px 20px;">
                        <div style="width: 72px; height: 72px; border-radius: 50%; background: #F0FDF4; color: #10B981; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 32px;">
                            ✅
                        </div>
                        <h4 style="font-size: 18px; font-weight: 800; color: #0F172A; margin: 0 0 6px;">Semua Beres! 🎉</h4>
                        <p style="font-size: 13px; color: #94A3B8; margin: 0; line-height: 1.5;">
                            Tidak ada barang yang perlu dikembalikan atau menunggu verifikasi saat ini.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Modal Footer -->
            <div style="padding: 14px 20px; border-top: 1px solid #F1F5F9; display: flex; gap: 10px;">
                <a href="{{ route('user.status') }}" class="btn-genz-primary" style="flex: 1; font-size: 13.5px; padding: 10px 16px;">Lihat Status Pengajuan</a>
                <button type="button" class="btn-genz-secondary" onclick="toggleNotifModal()" style="font-size: 13.5px; padding: 10px 16px;">Tutup</button>
            </div>
        </div>
    </div>

    <!-- LOGOUT CONFIRMATION MODAL USER -->
    <div class="modal-shade" id="user-logout-modal">
        <div class="modal-box-vibe" style="max-width: 420px;">
            <div class="modal-pulse-circle" style="background: #FFF1F2; color: #E11D48;">
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
            </div>
            <h3 style="font-size: 20px; font-weight: 800; margin-bottom: 6px; color: #1E293B;">Konfirmasi Keluar</h3>
            <p style="font-size: 13.5px; color: var(--text-secondary); margin-bottom: 24px; line-height: 1.5;">
                Apakah kamu yakin ingin keluar dari akun <strong>{{ Auth::user()->nama ?? 'Siswa' }}</strong>?
            </p>
            <div style="display: flex; gap: 10px;">
                <button type="button" class="btn-genz-secondary" onclick="toggleUserLogoutModal()" style="flex: 1;">Batal</button>
                <button type="button" class="btn-genz-primary" onclick="document.getElementById('userLogoutForm').submit()" style="flex: 1; background: #E11D48; box-shadow: 0 4px 14px rgba(225, 29, 72, 0.35);">Ya, Keluar</button>
            </div>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="glass-footer">
        <strong>SINFAS</strong> &bull; Sistem Informasi Fasilitas Sekolah &bull; {{ date('Y') }}
    </footer>

    <script>
        function toggleUserDropdown() {
            document.getElementById('dropdown-box').classList.toggle('open');
        }

        function toggleHelpModal() {
            document.getElementById('help-modal').classList.toggle('open');
        }

        function toggleNotifModal() {
            document.getElementById('notif-modal').classList.toggle('open');
        }

        function toggleUserLogoutModal() {
            const m = document.getElementById('user-logout-modal');
            if (m) m.classList.toggle('open');
            const dropdown = document.getElementById('dropdown-box');
            if (dropdown) dropdown.classList.remove('open');
        }

        window.addEventListener('click', function(e) {
            const avatar = document.getElementById('btn-avatar-top');
            const dropdown = document.getElementById('dropdown-box');
            if (dropdown && avatar && !avatar.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });

        // Otomatis hapus alert sukses setelah animasi selesai
        (function() {
            const alertEl = document.getElementById('alert-success-auto');
            if (alertEl) {
                setTimeout(function() {
                    alertEl.remove();
                }, 4500);
            }
        })();
    </script>
    @yield('scripts')
</body>
</html>
