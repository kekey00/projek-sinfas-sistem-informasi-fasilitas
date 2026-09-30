<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/sinfas-logo.svg'))) }}">
    <title>@yield('title', 'Admin Sarana') - SINFAS</title>

    <!-- Google Fonts: Plus Jakarta Sans & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&family=Outfit:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            /* ─── SINFAS ROYAL BLUE THEME (SELARAS DENGAN LOGIN) ─── */
            --color-royal-blue-start:  #4A6FA5;
            --color-royal-blue-mid:    #6B8DD6;
            --color-royal-blue-end:    #8E9AAF;
            --color-dark-blue:         #2C4A7C;
            --color-light-blue:        #7BA7D9;
            --color-border-blue:       #3B5998;
            --color-focus-blue:        #5B8DEF;

            /* Sidebar */
            --sidebar-bg:              linear-gradient(180deg, #1C335A 0%, #284777 55%, #182B49 100%);
            --sidebar-dark:            #162844;
            --sidebar-active:          linear-gradient(135deg, #6B8DD6 0%, #3B5998 100%);
            --sidebar-hover:           rgba(255, 255, 255, 0.08);
            --sidebar-text:            rgba(255, 255, 255, 0.78);
            --sidebar-text-active:     #FFFFFF;
            --sidebar-border:          rgba(255, 255, 255, 0.12);
            --sidebar-section:         rgba(255, 255, 255, 0.45);

            /* Main Brand Palette */
            --brand-blue:              #3B5998;
            --brand-blue-dark:         #2C4A7C;
            --brand-blue-light:        #6B8DD6;
            --brand-emerald:           #10B981;
            --brand-amber:             #F59E0B;
            --brand-rose:              #EF4444;
            --brand-gradient:          linear-gradient(135deg, #6B8DD6 0%, #3B5998 60%, #2C4A7C 100%);
            --brand-gradient-hover:    linear-gradient(135deg, #7BA7D9 0%, #4A6FA5 60%, #1E3456 100%);

            /* Surfaces & Grays */
            --bg-canvas:               #F1F5FA;
            --surface-card:            #FFFFFF;
            --border-color:            #E2E8F0;
            --border-subtle:           #EDF2F7;
            --surface-hover:           #F8FAFC;

            --text-dark:               #0F172A;
            --text-muted:              #64748B;
            --text-subtle:             #94A3B8;

            --radius-sm:               8px;
            --radius-md:               12px;
            --radius-lg:               16px;
            --radius-xl:               20px;
            --radius-pill:             9999px;

            --shadow-subtle:           0 1px 3px 0 rgba(15, 23, 42, 0.04);
            --shadow-card:             0 4px 20px -2px rgba(44, 74, 124, 0.07), 0 2px 6px -1px rgba(15, 23, 42, 0.03);
            --shadow-modal:            0 20px 25px -5px rgba(15, 23, 42, 0.14), 0 8px 10px -6px rgba(15, 23, 42, 0.06);
        }

        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Outfit', 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-canvas);
            background-image: radial-gradient(at 0% 0%, rgba(107, 141, 214, 0.12) 0px, transparent 50%),
                              radial-gradient(at 100% 0%, rgba(74, 111, 165, 0.08) 0px, transparent 50%),
                              radial-gradient(at 50% 100%, rgba(123, 167, 217, 0.10) 0px, transparent 50%);
            background-attachment: fixed;
            color: var(--text-dark);
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* ─── SIDEBAR BIRU ─── */
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

        /* Brand/Logo Area */
        .sidebar-brand-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid var(--sidebar-border);
        }

        .sidebar-brand-wrap {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 20px 20px 16px;
            text-decoration: none;
            flex: 1;
        }

        .sidebar-close-btn {
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: #FFFFFF;
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            margin-right: 14px;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .sidebar-close-btn:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Mobile Sidebar Backdrop */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            z-index: 999;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.25s ease;
        }

        .sidebar-backdrop.active {
            opacity: 1;
            pointer-events: auto;
        }

        .brand-logo-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            flex-shrink: 0;
            object-fit: cover;
            box-shadow: 0 4px 12px rgba(79, 70, 229, 0.35);
        }

        .brand-title {
            font-family: 'Outfit', sans-serif;
            font-size: 20px;
            font-weight: 700;
            color: #FFFFFF;
            letter-spacing: 0.5px;
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
            box-shadow: 0 4px 14px rgba(44, 74, 124, 0.35);
        }

        .nav-link-item.active svg {
            color: #FFFFFF;
        }

        .nav-badge {
            margin-left: auto;
            background: #EF4444;
            color: #FFFFFF;
            font-size: 11px;
            font-weight: 700;
            border-radius: 99px;
            padding: 1px 7px;
            min-width: 20px;
            text-align: center;
        }

        /* Logout di bawah sidebar */
        .sidebar-footer {
            border-top: 1px solid var(--sidebar-border);
            padding: 12px;
        }

        .nav-link-item.logout {
            color: rgba(255,255,255,0.65);
        }

        .nav-link-item.mobile-logout {
            display: none;
        }

        .nav-link-item.logout:hover {
            background: rgba(239,68,68,0.20);
            color: #fca5a5;
        }

        .nav-link-item.logout:hover svg {
            color: #fca5a5;
        }

        /* ─── MAIN WRAPPER & TOPBAR ─── */
        .main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background: var(--bg-canvas);
            overflow-y: auto;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 14px 32px;
            background: rgba(255, 255, 255, 0.90);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-color);
            position: sticky;
            top: 0;
            z-index: 40;
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
            gap: 10px;
        }

        .topbar-date-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #F8FAFC;
            padding: 6px 12px;
            border-radius: var(--radius-sm);
            font-size: 12.5px;
            font-weight: 500;
            color: #64748B;
            border: 1px solid var(--border-color);
        }

        .topbar-btn {
            background: #FFFFFF;
            border: 1px solid var(--border-color);
            cursor: pointer;
            width: 36px;
            height: 36px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748B;
            transition: all 0.15s ease;
        }

        .topbar-btn:hover {
            background: #F8FAFC;
            color: var(--brand-blue);
            border-color: #CBD5E1;
        }

        .topbar-profile-trigger {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 12px 5px 6px;
            border-radius: var(--radius-md);
            background: #F8FAFC;
            border: 1px solid var(--border-color);
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .topbar-profile-trigger:hover {
            border-color: rgba(99, 102, 241, 0.35);
            background: #EEF2FF;
        }

        .topbar-avatar {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: var(--brand-gradient);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            font-family: 'Outfit', sans-serif;
            box-shadow: 0 2px 8px rgba(79, 70, 229, 0.3);
        }

        /* Container Isi Halaman */
        .page-content {
            padding: 24px 32px 40px 32px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            flex: 1;
        }

        /* ─── MODAL GLOBAL SINFAS ─── */
        .modal-overlay {
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(15,23,42,0.45);
            backdrop-filter: blur(4px);
            -webkit-backdrop-filter: blur(4px);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 10000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.2s ease;
        }

        .modal-overlay.active,
        .modal-overlay.open {
            opacity: 1;
            pointer-events: auto;
        }

        .modal-card {
            background: #FFFFFF;
            border: 1px solid var(--border-color);
            border-radius: var(--radius-lg);
            padding: 24px;
            width: 90%;
            max-width: 500px;
            box-shadow: var(--shadow-modal);
            transform: translateY(12px) scale(0.98);
            transition: all 0.2s ease;
            position: relative;
        }

        .modal-overlay.active .modal-card,
        .modal-overlay.open .modal-card {
            transform: translateY(0) scale(1);
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border-color);
        }

        .modal-title {
            font-family: 'Outfit', sans-serif;
            font-size: 17px;
            font-weight: 700;
            color: var(--text-dark);
            letter-spacing: -0.2px;
        }

        .modal-close-btn {
            background: transparent;
            border: none;
            width: 28px;
            height: 28px;
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            color: #94A3B8;
            cursor: pointer;
            line-height: 1;
            transition: all 0.15s ease;
        }

        .modal-close-btn:hover {
            background: #F1F5F9;
            color: #0F172A;
        }

        .modal-footer {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
            padding-top: 14px;
            border-top: 1px solid var(--border-color);
        }

        .btn-cancel {
            padding: 8px 16px;
            border-radius: var(--radius-sm);
            background: #FFFFFF;
            color: #475569;
            border: 1px solid var(--border-color);
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
            font-family: inherit;
        }

        .btn-cancel:hover {
            background: #F8FAFC;
            border-color: #CBD5E1;
            color: #0F172A;
        }

        .btn-submit {
            padding: 8px 18px;
            border-radius: var(--radius-sm);
            background: var(--brand-gradient);
            color: #FFFFFF;
            border: 1px solid transparent;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: inherit;
            box-shadow: 0 3px 10px rgba(79, 70, 229, 0.25);
        }

        .btn-submit:hover {
            background: var(--brand-gradient-hover);
            box-shadow: 0 5px 15px rgba(79, 70, 229, 0.35);
            transform: translateY(-1px);
        }

        /* ─── TOAST NOTIFICATION ─── */
        .sinfas-toast-container {
            position: fixed;
            bottom: 24px;
            right: 24px;
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 10px;
            pointer-events: none;
        }

        .sinfas-toast-card {
            pointer-events: auto;
            background: #FFFFFF;
            border-radius: var(--radius-md);
            border: 1px solid var(--border-color);
            box-shadow: 0 10px 25px -5px rgba(15,23,42,0.12), 0 4px 6px -2px rgba(15,23,42,0.06);
            padding: 14px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 300px;
            max-width: 400px;
            animation: toastSlideIn 0.25s ease;
            transition: opacity 0.25s ease, transform 0.25s ease;
        }

        @keyframes toastSlideIn {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .toast-icon-circle {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 14px;
            font-weight: 700;
        }

        .toast-icon-circle.success { background: #DCFCE7; color: #166534; }
        .toast-icon-circle.error   { background: #FEE2E2; color: #991B1B; }

        .toast-text-wrap { flex: 1; min-width: 0; }

        .toast-title {
            font-family: 'Outfit', sans-serif;
            font-size: 13.5px;
            font-weight: 700;
            color: #0F172A;
            line-height: 1.3;
        }

        .toast-subtitle {
            font-size: 12px;
            color: #64748B;
            margin-top: 2px;
            line-height: 1.35;
        }

        .toast-close-btn {
            background: none;
            border: none;
            color: #94A3B8;
            font-size: 18px;
            cursor: pointer;
            line-height: 1;
            padding: 2px;
            border-radius: 4px;
            transition: all 0.15s;
        }

        .toast-close-btn:hover { color: #0F172A; background: #F1F5F9; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; height: 5px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.25); border-radius: 4px; }
        .main-wrapper ::-webkit-scrollbar-thumb { background: #CBD5E1; }
        ::-webkit-scrollbar-thumb:hover { background: #94A3B8; }
        /* Topbar Left & Toggle Button */
        .topbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
            flex: 1;
        }

        .sidebar-toggle-btn {
            display: none;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: var(--radius-sm);
            background: #FFFFFF;
            border: 1px solid var(--border-color);
            color: var(--text-dark);
            cursor: pointer;
            transition: all 0.15s ease;
            flex-shrink: 0;
        }

        .sidebar-toggle-btn:hover {
            background: #F1F5F9;
            color: var(--brand-blue);
            border-color: #CBD5E1;
        }

        /* ─── RESPONSIVE RULES (MOBILE & TABLET) ─── */
        @media (max-width: 991px) {
            .admin-layout {
                width: 100%;
                min-width: 0;
            }

            .main-wrapper,
            .page-content {
                min-width: 0;
            }

            .page-content > * {
                min-width: 0;
                max-width: 100%;
            }

            .sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                width: 270px;
                max-width: 84vw;
                height: 100vh;
                height: 100dvh;
                min-height: 0;
                max-height: 100dvh;
                z-index: 1000;
                transform: translateX(-100%);
                transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1);
                box-shadow: none;
                overflow: hidden;
            }

            .sidebar-nav-wrap {
                min-height: 0;
                overflow-y: auto;
                overscroll-behavior: contain;
            }

            .sidebar-footer {
                display: none;
            }

            .nav-link-item.mobile-logout {
                display: flex;
                margin-top: 4px;
                background: rgba(239, 68, 68, 0.12);
                color: #FCA5A5;
            }

            .nav-link-item.mobile-logout svg {
                color: #FCA5A5;
            }

            .sidebar.open {
                transform: translateX(0);
                box-shadow: 10px 0 30px rgba(15, 23, 42, 0.35);
            }

            .sidebar-backdrop {
                display: block;
            }

            .sidebar-close-btn {
                display: flex;
            }

            .sidebar-toggle-btn {
                display: flex;
            }

            .topbar {
                padding: 10px 16px;
                gap: 12px;
            }

            .page-title {
                font-size: 17px;
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
            }

            .topbar-date-pill {
                display: none;
            }

            .page-content {
                padding: 18px 16px 36px;
                gap: 16px;
            }
        }

        @media (max-width: 640px) {
            .topbar {
                padding: 8px 12px;
            }

            .page-title {
                font-size: 15px;
            }

            .topbar-profile-trigger .topbar-user-text {
                display: none;
            }

            .topbar-profile-trigger {
                padding: 4px;
                border-radius: 50%;
            }

            .topbar-profile-trigger svg.chevron-down {
                display: none;
            }

            .page-content {
                padding: 14px 12px 28px;
                gap: 14px;
            }

            .modal-card {
                width: calc(100% - 24px) !important;
                margin: 12px !important;
                padding: 18px 16px !important;
                max-height: 92vh !important;
            }

            .form-grid-2 {
                grid-template-columns: 1fr !important;
                gap: 10px !important;
            }

            .sinfas-toast-container {
                left: 12px !important;
                right: 12px !important;
                bottom: 14px !important;
                min-width: auto !important;
                max-width: 100% !important;
            }

            .sinfas-toast-card {
                min-width: auto !important;
                width: 100% !important;
            }
        }
    </style>

    @yield('styles')
</head>
<body>

    <div class="admin-layout">

        <!-- Mobile Sidebar Backdrop Overlay -->
        <div class="sidebar-backdrop" id="sidebarBackdrop" onclick="closeSidebar()"></div>

        <!-- ─── SIDEBAR BIRU SINFAS ADMIN ─── -->
        <aside class="sidebar" id="sidebar">

            <!-- Brand Logo Header -->
            <div class="sidebar-brand-header">
                <a href="{{ route('admin.dashboard') }}" class="sidebar-brand-wrap">
                    @include('components.sinfas-logo', ['class' => 'brand-logo-icon', 'variant' => 'admin'])
                    <span class="brand-title">SINFAS</span>
                </a>
                <button type="button" class="sidebar-close-btn" onclick="closeSidebar()" aria-label="Tutup Menu">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Navigation -->
            <div class="sidebar-nav-wrap">
                <div class="section-heading">MENU UTAMA</div>
                <nav class="sidebar-nav-list">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                            <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                            <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                            <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('admin.barang.index') }}" class="nav-link-item {{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                            <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                            <line x1="12" y1="22.08" x2="12" y2="12"></line>
                        </svg>
                        Data Barang
                    </a>
                    <a href="{{ route('admin.kategori.index') }}" class="nav-link-item {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line>
                            <circle cx="4" cy="6" r="1.5"></circle><circle cx="4" cy="12" r="1.5"></circle><circle cx="4" cy="18" r="1.5"></circle>
                        </svg>
                        Kategori
                    </a>
                    <a href="{{ route('admin.verifikasi.index') }}" class="nav-link-item {{ (request()->routeIs('admin.verifikasi.*') && request('tab') !== 'history' && !request()->routeIs('admin.riwayat.*')) ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 11l3 3L22 4"></path>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
                        </svg>
                        Verifikasi
                        @php
                            try {
                                $pendingCount = \App\Models\Peminjaman::where('status_pengajuan','menunggu')->count();
                            } catch(\Exception $e) {
                                $pendingCount = 0;
                            }
                        @endphp
                        @if($pendingCount > 0)
                            <span class="nav-badge">{{ $pendingCount }}</span>
                        @endif
                    </a>
                    <a href="{{ route('admin.riwayat.index') }}" class="nav-link-item {{ (request()->routeIs('admin.riwayat.*') || (request()->routeIs('admin.verifikasi.*') && request('tab') === 'history')) ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        Riwayat Peminjaman
                    </a>
                    <a href="{{ route('admin.laporan.index') }}" class="nav-link-item {{ request()->routeIs('admin.laporan.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path>
                            <path d="M8 7h8M8 11h8M8 15h5"></path>
                        </svg>
                        Laporan
                    </a>
                    <a href="{{ route('admin.profile') }}" class="nav-link-item {{ request()->routeIs('admin.profile') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"></circle>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"></path>
                        </svg>
                        Pengaturan Akun
                    </a>
                    <a href="javascript:void(0)" onclick="openLogoutModal()" class="nav-link-item logout mobile-logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        Logout
                    </a>
                </nav>
            </div>

            <!-- Footer Logout -->
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
                <div class="topbar-left">
                    <button type="button" class="sidebar-toggle-btn" id="sidebarToggle" onclick="toggleSidebar()" aria-label="Buka Menu">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <h1 class="page-title">@yield('page_title', 'Dashboard')</h1>
                </div>

                <div class="topbar-actions">
                    <div class="topbar-date-pill">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</span>
                    </div>

                    <button class="topbar-btn" title="Notifikasi" onclick="window.showSinfasToast('success', 'Sistem SINFAS Aktif', 'Semua layanan berjalan lancar.')">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                    </button>

                    <a href="{{ route('admin.profile') }}" class="topbar-profile-trigger" style="text-decoration:none;">
                        <div class="topbar-avatar">
                            {{ strtoupper(substr(Auth::user()->nama ?? 'A', 0, 1)) }}
                        </div>
                        <div class="topbar-user-text" style="display:flex;flex-direction:column;line-height:1.2;">
                            <span style="font-size:13px;font-weight:600;color:#1E293B;">{{ Auth::user()->nama ?? 'Admin Sarana' }}</span>
                            <span style="font-size:11px;color:#64748B;">Administrator</span>
                        </div>
                        <svg class="chevron-down" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                    </a>
                </div>
            </header>

            <!-- Page Body -->
            <div class="page-content">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Modal Profil & Pengaturan Akun Admin Sarana -->
    <div id="profileModal" class="modal-overlay">
        <div class="modal-card" style="max-width: 480px;">
            <div class="modal-header">
                <div class="modal-title">Profil & Akun Admin Sarana</div>
                <button class="modal-close-btn" onclick="closeModal('profileModal')">&times;</button>
            </div>
            
            <form action="{{ route('user.profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Hero Profile Info -->
                <div style="display:flex;align-items:center;gap:14px;background:#F8FAFC;padding:16px;border-radius:14px;border:1px solid #E2E8F0;margin-bottom:18px;">
                    <div style="width:54px;height:54px;border-radius:14px;background:var(--brand-gradient);display:flex;align-items:center;justify-content:center;font-family:'Outfit',sans-serif;font-size:22px;font-weight:700;color:#FFFFFF;flex-shrink:0;box-shadow:0 4px 14px rgba(79,70,229,0.35);">
                        {{ strtoupper(substr(Auth::user()->nama ?? 'A', 0, 1)) }}
                    </div>
                    <div style="flex:1;">
                        <div style="font-family:'Outfit',sans-serif;font-size:16.5px;font-weight:700;color:#1E293B;">{{ Auth::user()->nama ?? 'Admin Sarana' }}</div>
                        <div style="font-size:12.5px;color:#64748B;">Username: <strong style="color:#334155;">{{ '@' . (Auth::user()->username ?? 'admin') }}</strong></div>
                        <div style="display:inline-flex;align-items:center;gap:6px;font-size:11.5px;color:#059669;font-weight:600;background:#ECFDF5;padding:2px 8px;border-radius:99px;margin-top:4px;border:1px solid #A7F3D0;">
                            <span style="width:6px;height:6px;border-radius:50%;background:#10B981;"></span>
                            Admin Sarana &bull; Aktif
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

                <!-- Ubah Kata Sandi -->
                <div style="margin-top:16px;border-top:1px solid #F1F5F9;padding-top:14px;">
                    <div style="font-family:'Outfit',sans-serif;font-size:13.5px;font-weight:700;color:#1E293B;margin-bottom:10px;display:flex;align-items:center;gap:6px;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                        Ubah Kata Sandi <span style="font-size:11px;font-weight:400;color:#94A3B8;">(Opsional)</span>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Kata Sandi Saat Ini</label>
                        <input type="password" name="current_password" class="form-control" placeholder="Isi jika ingin mengganti kata sandi">
                    </div>

                    <div class="form-grid-2">
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Kata Sandi Baru</label>
                            <input type="password" name="new_password" class="form-control" placeholder="Min. 6 karakter">
                        </div>
                        <div class="form-group" style="margin-bottom:0;">
                            <label class="form-label">Konfirmasi Kata Sandi</label>
                            <input type="password" name="new_password_confirmation" class="form-control" placeholder="Ulangi kata sandi baru">
                        </div>
                    </div>
                </div>

                <div class="modal-footer" style="margin-top:20px;">
                    <button type="button" class="btn-cancel" onclick="closeModal('profileModal')">Tutup</button>
                    <button type="submit" class="btn-primary" style="background:var(--brand-gradient);border:none;box-shadow:0 4px 12px rgba(79,70,229,0.25);">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Logout -->
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
                Apakah Anda yakin ingin keluar dari akun ini? Sesi Anda akan diakhiri.
            </p>
            <div style="display: flex; gap: 10px; justify-content: center;">
                <button type="button" class="btn-cancel" onclick="closeModal('logoutConfirmModal')" style="flex: 1;">Batal</button>
                <button type="button" onclick="document.getElementById('logoutForm').submit()" style="flex: 1; padding: 8px 18px; border-radius: var(--radius-md); background: #E11D48; color: #FFFFFF; border: none; font-size: 13px; font-weight: 600; cursor: pointer; transition: background 0.15s;" onmouseover="this.style.background='#BE123C'" onmouseout="this.style.background='#E11D48'">Ya, Keluar</button>
            </div>
        </div>
    </div>

    <!-- Toast Notifications -->
    <div class="sinfas-toast-container" id="toastContainer">
        @if(session('success'))
            <div class="sinfas-toast-card" id="sessionToast">
                <div class="toast-icon-circle success">✓</div>
                <div class="toast-text-wrap">
                    <div class="toast-title">{{ session('toast_title') ?? 'Berhasil' }}</div>
                    <div class="toast-subtitle">{{ session('toast_subtitle') ?? session('success') }}</div>
                </div>
                <button type="button" class="toast-close-btn" onclick="this.closest('.sinfas-toast-card').remove()">&times;</button>
            </div>
        @endif
        @if(session('error'))
            <div class="sinfas-toast-card" id="sessionToastErr">
                <div class="toast-icon-circle error">✗</div>
                <div class="toast-text-wrap">
                    <div class="toast-title">{{ session('toast_title') ?? 'Terjadi Kesalahan' }}</div>
                    <div class="toast-subtitle">{{ session('toast_subtitle') ?? session('error') }}</div>
                </div>
                <button type="button" class="toast-close-btn" onclick="this.closest('.sinfas-toast-card').remove()">&times;</button>
            </div>
        @endif
    </div>

    <script>
        /* Mobile Sidebar Controller */
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (!sidebar) return;
            if (sidebar.classList.contains('open')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }

        function openSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar) sidebar.classList.add('open');
            if (backdrop) backdrop.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            const sidebar = document.getElementById('sidebar');
            const backdrop = document.getElementById('sidebarBackdrop');
            if (sidebar) sidebar.classList.remove('open');
            if (backdrop) backdrop.classList.remove('active');
            document.body.style.overflow = '';
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') closeSidebar();
        });

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
