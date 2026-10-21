<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml;base64,{{ base64_encode(file_get_contents(public_path('images/sinfas-logo.svg'))) }}">
    <title>@yield('title', 'SINFAS - Portal Peminjaman Fasilitas')</title>
    <meta name="description" content="Platform modern peminjaman sarana dan fasilitas sekolah/kampus secara instan & transparan.">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Outfit:wght@500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            /* ─── SINFAS ROYAL BLUE THEME ─── */
            --brand-primary: #3B5998;
            --brand-violet: #5B8DEF;
            --brand-cyan: #06B6D4;
            --brand-pink: #7BA7D9;
            --brand-gradient: linear-gradient(135deg, #7BA7D9 0%, #3B5998 50%, #2C4A7C 100%);
            --brand-gradient-hover: linear-gradient(135deg, #5B8DEF 0%, #2C4A7C 100%);
            --brand-mesh: radial-gradient(at 0% 0%, rgba(91, 141, 239, 0.08) 0px, transparent 50%),
                          radial-gradient(at 100% 0%, rgba(123, 167, 217, 0.06) 0px, transparent 50%),
                          radial-gradient(at 50% 100%, rgba(6, 182, 212, 0.04) 0px, transparent 50%);

            /* Sidebar Theme (Identik dengan SINFAS Admin & Login) */
            --sidebar-bg: linear-gradient(180deg, #1C335A 0%, #284777 55%, #182B49 100%);
            --sidebar-dark: #162844;
            --sidebar-active: linear-gradient(135deg, #6B8DD6 0%, #3B5998 100%);
            --sidebar-hover: rgba(255, 255, 255, 0.08);
            --sidebar-text: rgba(255, 255, 255, 0.78);
            --sidebar-text-active: #FFFFFF;
            --sidebar-border: rgba(255, 255, 255, 0.12);
            --sidebar-section: rgba(255, 255, 255, 0.45);

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
            --badge-rose: #EF4444;
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
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
            overflow-x: hidden;
        }

        h1, h2, h3, .brand-logo-text, .brand-title {
            font-family: 'Outfit', sans-serif;
        }

        /* ─── APP LAYOUT WITH SIDEBAR ─── */
        .user-layout {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* ─── SIDEBAR BIRU SINFAS USER ─── */
        .user-sidebar {
            width: 250px;
            min-width: 250px;
            background: var(--sidebar-bg);
            color: var(--sidebar-text-active);
            display: flex;
            flex-direction: column;
            padding: 0;
            min-height: 100vh;
            height: 100vh;
            position: sticky;
            top: 0;
            z-index: 50;
            overflow-y: auto;
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 4px 0 24px rgba(15, 23, 42, 0.08);
        }

        /* Brand Logo Area */
        .sidebar-brand-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 20px 18px 16px;
            border-bottom: 1px solid var(--sidebar-border);
        }

        .sidebar-brand-wrap {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            flex: 1;
        }

        .brand-logo-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            flex-shrink: 0;
            object-fit: cover;
            box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
        }

        .brand-title-wrap {
            display: flex;
            flex-direction: column;
        }

        .brand-title {
            font-size: 20px;
            font-weight: 800;
            color: #FFFFFF;
            letter-spacing: 0.5px;
            line-height: 1.1;
        }

        .brand-badge-user {
            font-size: 9.5px;
            font-weight: 800;
            letter-spacing: 0.8px;
            text-transform: uppercase;
            color: #93C5FD;
            margin-top: 2px;
        }

        .sidebar-close-btn {
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.12);
            border: none;
            color: #FFFFFF;
            width: 32px;
            height: 32px;
            border-radius: var(--radius-sm);
            cursor: pointer;
            transition: background 0.15s ease;
        }
        .sidebar-close-btn:hover {
            background: rgba(255, 255, 255, 0.22);
        }

        /* Mobile Backdrop */
        .sidebar-backdrop {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.6);
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

        /* Student Quick Info Card inside Sidebar */
        .sidebar-user-card {
            margin: 14px 12px 6px;
            padding: 12px 14px;
            background: rgba(255, 255, 255, 0.06);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-md);
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .sidebar-user-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #6B8DD6 0%, #3B5998 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 13px;
            font-weight: 800;
            flex-shrink: 0;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.25);
        }
        .sidebar-user-info {
            min-width: 0;
            flex: 1;
        }
        .sidebar-user-name {
            font-size: 13px;
            font-weight: 700;
            color: #FFFFFF;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-user-nis {
            font-size: 11px;
            color: rgba(255, 255, 255, 0.6);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        /* Sidebar Nav Wrap */
        .sidebar-nav-wrap {
            padding: 12px 12px 16px;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        .section-heading {
            font-size: 10px;
            font-weight: 800;
            color: var(--sidebar-section);
            text-transform: uppercase;
            letter-spacing: 1.2px;
            margin-bottom: 6px;
            margin-top: 16px;
            padding-left: 10px;
        }
        .section-heading:first-child {
            margin-top: 4px;
        }

        .sidebar-nav-list {
            display: flex;
            flex-direction: column;
            gap: 3px;
        }

        .nav-link-item {
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 14px;
            border-radius: var(--radius-md);
            font-size: 13.5px;
            font-weight: 500;
            color: var(--sidebar-text);
            transition: all 0.15s ease;
            position: relative;
            cursor: pointer;
            border: none;
            background: transparent;
            width: 100%;
            text-align: left;
            font-family: inherit;
        }

        .nav-link-item svg {
            width: 18px;
            height: 18px;
            stroke-width: 2.1;
            flex-shrink: 0;
            color: rgba(255, 255, 255, 0.65);
            transition: color 0.15s ease, transform 0.15s ease;
        }

        .nav-link-item:hover {
            background: var(--sidebar-hover);
            color: #FFFFFF;
            transform: translateX(2px);
        }
        .nav-link-item:hover svg {
            color: #FFFFFF;
            transform: scale(1.08);
        }

        .nav-link-item.active {
            background: var(--sidebar-active);
            color: #FFFFFF;
            font-weight: 700;
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
            font-weight: 800;
            border-radius: 99px;
            padding: 1px 7px;
            min-width: 20px;
            text-align: center;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.4);
        }
        .nav-badge.badge-blue {
            background: #3B82F6;
            box-shadow: 0 2px 6px rgba(59, 130, 246, 0.4);
        }

        /* Sidebar Footer */
        .sidebar-footer {
            border-top: 1px solid var(--sidebar-border);
            padding: 12px;
            margin-top: auto;
        }

        .nav-link-item.logout {
            color: rgba(255, 255, 255, 0.7);
        }
        .nav-link-item.logout:hover {
            background: rgba(239, 68, 68, 0.2);
            color: #FCA5A5;
        }
        .nav-link-item.logout:hover svg {
            color: #FCA5A5;
        }
        .nav-link-item.mobile-logout {
            display: none;
        }

        /* ─── MAIN CONTENT WRAPPER ─── */
        .user-main-wrapper {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            min-width: 0;
            overflow-y: auto;
        }

        /* ─── MODERN USER TOPBAR ─── */
        .user-topbar {
            position: sticky;
            top: 0;
            z-index: 40;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.85);
            padding: 12px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .sidebar-toggle-btn {
            display: none;
            align-items: center;
            justify-content: center;
            background: #FFFFFF;
            border: 1px solid var(--border-subtle);
            width: 38px;
            height: 38px;
            border-radius: var(--radius-sm);
            color: var(--text-main);
            cursor: pointer;
            box-shadow: var(--shadow-subtle);
            transition: all 0.15s ease;
        }
        .sidebar-toggle-btn:hover {
            background: #F1F5F9;
            color: var(--brand-primary);
        }

        .topbar-page-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
        }

        .topbar-page-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--text-main);
            letter-spacing: -0.3px;
            line-height: 1.2;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .topbar-page-subtitle {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 1px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }

        .topbar-date-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #F8FAFC;
            padding: 6px 14px;
            border-radius: var(--radius-pill);
            font-size: 12px;
            font-weight: 600;
            color: #64748B;
            border: 1px solid var(--border-subtle);
        }

        .icon-action-btn {
            position: relative;
            width: 38px;
            height: 38px;
            border-radius: var(--radius-sm);
            background: #FFFFFF;
            border: 1px solid var(--border-subtle);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748B;
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 1px 3px rgba(15, 23, 42, 0.04);
        }
        .icon-action-btn:hover {
            color: var(--brand-primary);
            border-color: rgba(91, 141, 239, 0.4);
            transform: translateY(-1px);
            background: #EEF4FF;
        }

        .avatar-ring-btn {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            padding: 2px;
            background: linear-gradient(135deg, #7BA7D9 0%, #3B5998 100%);
            cursor: pointer;
            transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .avatar-ring-btn:hover {
            transform: scale(1.06);
        }
        .avatar-inner {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: #FFFFFF;
            color: var(--brand-primary);
            font-size: 12px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 1.5px solid #FFFFFF;
        }

        /* USER DROPDOWN */
        .dropdown-menu-box {
            display: none;
            position: absolute;
            top: calc(100% + 10px);
            right: 0;
            width: 230px;
            background: #FFFFFF;
            border-radius: var(--radius-md);
            box-shadow: 0 15px 35px -5px rgba(15, 23, 42, 0.12), 0 5px 15px rgba(15, 23, 42, 0.04);
            border: 1px solid var(--border-subtle);
            padding: 8px;
            z-index: 1000;
            animation: dropFade 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .dropdown-menu-box.open { display: block; }

        @keyframes dropFade {
            from { opacity: 0; transform: translateY(-8px) scale(0.97); }
            to   { opacity: 1; transform: translateY(0) scale(1); }
        }

        .dropdown-menu-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 12px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--text-secondary);
            text-decoration: none;
            transition: all 0.15s ease;
        }
        .dropdown-menu-item:hover {
            background: #F1F5F9;
            color: var(--brand-primary);
        }

        /* ─── FLASH ALERTS ─── */
        .flash-container {
            max-width: 1240px;
            width: 100%;
            margin: 16px auto 0;
            padding: 0 28px;
        }

        .modern-alert {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px 18px;
            border-radius: var(--radius-md);
            font-size: 13.5px;
            font-weight: 600;
            margin-bottom: 12px;
            box-shadow: var(--shadow-subtle);
            animation: alertSlide 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }
        @keyframes alertSlide {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .alert-success {
            background: #ECFDF5;
            color: #065F46;
            border: 1.5px solid #A7F3D0;
        }
        .alert-error {
            background: #FFF1F2;
            color: #9F1239;
            border: 1.5px solid #FECDD3;
        }

        /* ─── PAGE BODY ─── */
        .app-body {
            flex: 1;
            max-width: 1240px;
            margin: 0 auto;
            padding: 24px 28px 48px;
            width: 100%;
            min-width: 0;
        }

        /* BUTTONS */
        .btn-genz-primary {
            background: var(--brand-gradient);
            color: #fff;
            border: none;
            border-radius: var(--radius-md);
            padding: 12px 24px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: var(--shadow-glow);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            text-decoration: none;
            font-family: inherit;
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
            padding: 12px 20px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.15s ease;
            text-decoration: none;
            font-family: inherit;
        }
        .btn-genz-secondary:hover {
            background: #E2E8F0;
        }

        /* ─── MODALS ─── */
        .modal-shade {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal-shade.open { display: flex; }

        .modal-box-vibe {
            background: #FFFFFF;
            border-radius: 24px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 25px 60px -15px rgba(15, 23, 42, 0.25);
            border: 1px solid rgba(226, 232, 240, 0.9);
            overflow: hidden;
            animation: modalSpring 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            text-align: center;
            padding: 32px 28px;
            position: relative;
        }
        @keyframes modalSpring {
            from { opacity: 0; transform: scale(0.92) translateY(12px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }

        .modal-pulse-circle {
            width: 72px;
            height: 72px;
            border-radius: var(--radius-pill);
            background: #EEF4FF;
            color: var(--brand-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
            position: relative;
        }

        /* ─── FOOTER ─── */
        .glass-footer {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-top: 1px solid var(--border-subtle);
            padding: 18px 28px;
            text-align: center;
            font-size: 12.5px;
            color: var(--text-muted);
            margin-top: auto;
        }

        /* ─── TOAST NOTIFICATIONS ─── */
        .user-toast-container {
            position: fixed;
            top: 24px;
            right: 24px;
            z-index: 999999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            pointer-events: none;
            max-width: 400px;
            width: calc(100% - 48px);
        }
        .user-toast-card {
            pointer-events: auto;
            background: #FFFFFF;
            border-radius: 16px;
            padding: 16px 18px;
            box-shadow: 0 16px 36px rgba(15, 23, 42, 0.16), 0 4px 12px rgba(15, 23, 42, 0.06);
            display: flex;
            align-items: flex-start;
            gap: 14px;
            border: 1.5px solid #E2E8F0;
            transform: translateY(-20px) scale(0.96);
            opacity: 0;
            transition: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }
        .user-toast-card.show {
            transform: translateY(0) scale(1);
            opacity: 1;
        }
        .user-toast-card.success {
            border-color: #A7F3D0;
            background: linear-gradient(180deg, #FFFFFF 0%, #F0FDF4 100%);
        }
        .user-toast-card.error {
            border-color: #FECDD3;
            background: linear-gradient(180deg, #FFFFFF 0%, #FFF1F2 100%);
        }
        .user-toast-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .user-toast-icon.success { background: #DCFCE7; }
        .user-toast-icon.error { background: #FEE2E2; }
        .user-toast-content { flex: 1; min-width: 0; }
        .user-toast-title { font-size: 13.5px; font-weight: 800; color: #0F172A; }
        .user-toast-message { font-size: 12.5px; color: #475569; margin-top: 3px; line-height: 1.45; }
        .user-toast-close { background: none; border: none; font-size: 18px; color: #94A3B8; cursor: pointer; }

        /* ─── RESPONSIVE BREAKPOINTS ─── */
        @media (max-width: 1024px) {
            .user-sidebar {
                position: fixed;
                top: 0;
                left: 0;
                bottom: 0;
                width: 270px;
                max-width: 85vw;
                height: 100vh;
                height: 100dvh;
                z-index: 1000;
                transform: translateX(-100%);
                transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1);
                box-shadow: none;
            }
            .user-sidebar.open {
                transform: translateX(0);
                box-shadow: 10px 0 35px rgba(15, 23, 42, 0.4);
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
            .sidebar-footer {
                display: none;
            }
            .nav-link-item.mobile-logout {
                display: flex;
                margin-top: 6px;
                background: rgba(239, 68, 68, 0.15);
                color: #FCA5A5;
            }
            .nav-link-item.mobile-logout svg {
                color: #FCA5A5;
            }
            .topbar-date-pill {
                display: none;
            }
            .user-topbar {
                padding: 10px 18px;
            }
            .app-body {
                padding: 18px 16px 36px;
            }
            .flash-container {
                padding: 0 16px;
            }
        }

        @media (max-width: 640px) {
            .topbar-page-title { font-size: 16px; }
            .topbar-page-subtitle { display: none; }
            .user-toast-container {
                left: 12px;
                right: 12px;
                width: auto;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <div class="user-layout">

        <!-- Mobile Sidebar Backdrop Overlay -->
        <div class="sidebar-backdrop" id="userSidebarBackdrop" onclick="closeUserSidebar()"></div>

        <!-- ─── SIDEBAR SINFAS USER (PORTAL SISWA) ─── -->
        <aside class="user-sidebar" id="userSidebar">

            <!-- Brand Header -->
            <div class="sidebar-brand-header">
                <a href="{{ route('user.dashboard') }}" class="sidebar-brand-wrap">
                    @include('components.sinfas-logo', ['class' => 'brand-logo-icon', 'variant' => 'user'])
                    <div class="brand-title-wrap">
                        <span class="brand-title">SINFAS</span>
                        <span class="brand-badge-user">PORTAL PEMINJAM</span>
                    </div>
                </a>
                <button type="button" class="sidebar-close-btn" onclick="closeUserSidebar()" aria-label="Tutup Menu">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="18" y1="6" x2="6" y2="18"></line>
                        <line x1="6" y1="6" x2="18" y2="18"></line>
                    </svg>
                </button>
            </div>

            <!-- Student Profile Badge Card -->
            <div class="sidebar-user-card">
                <div class="sidebar-user-avatar">
                    {{ strtoupper(substr(Auth::user()->nama ?? 'U', 0, 2)) }}
                </div>
                <div class="sidebar-user-info">
                    <div class="sidebar-user-name" title="{{ Auth::user()->nama }}">{{ Auth::user()->nama ?? 'Siswa' }}</div>
                    <div class="sidebar-user-nis">NIS: {{ Auth::user()->nis ?? '-' }}</div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="sidebar-nav-wrap">

                <!-- GRUP 1: MENU UTAMA -->
                <div class="section-heading">MENU UTAMA</div>
                <nav class="sidebar-nav-list">
                    {{-- 1. Katalog Fasilitas --}}
                    <a href="{{ route('user.dashboard') }}" class="nav-link-item {{ request()->routeIs('user.dashboard') || request()->routeIs('user.barang.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1.5"></rect>
                            <rect x="14" y="3" width="7" height="7" rx="1.5"></rect>
                            <rect x="14" y="14" width="7" height="7" rx="1.5"></rect>
                            <rect x="3" y="14" width="7" height="7" rx="1.5"></rect>
                        </svg>
                        <span>Katalog Fasilitas</span>
                    </a>

                    {{-- 2. Status & Riwayat Pinjaman --}}
                    @php
                        try {
                            $userActivePinjamCount = \App\Models\Peminjaman::where('nis', Auth::user()->nis)
                                ->whereIn('status_pengajuan', ['menunggu', 'disetujui'])
                                ->count();
                        } catch(\Throwable $e) {
                            $userActivePinjamCount = 0;
                        }
                    @endphp
                    <a href="{{ route('user.status') }}" class="nav-link-item {{ request()->routeIs('user.status') || request()->routeIs('user.pengembalian.*') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 16 14"></polyline>
                        </svg>
                        <span>Status Pinjaman</span>
                        <span class="nav-badge badge-blue" id="sidebar-loans-badge" style="{{ $userActivePinjamCount > 0 ? '' : 'display:none;' }}">{{ $userActivePinjamCount }}</span>
                    </a>

                    {{-- 3. Notifikasi --}}
                    @php
                        $notifInitCount = isset($userNotifications) ? $userNotifications->count() : 0;
                    @endphp
                    <a href="{{ route('user.notifikasi') }}" class="nav-link-item {{ request()->routeIs('user.notifikasi') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                        </svg>
                        <span>Notifikasi</span>
                        <span class="nav-badge" id="user-notif-badge-sidebar" style="{{ $notifInitCount > 0 ? '' : 'display:none;' }}">{{ $notifInitCount }}</span>
                    </a>

                    {{-- 4. Profil Saya --}}
                    <a href="{{ route('user.profile') }}" class="nav-link-item {{ request()->routeIs('user.profile') ? 'active' : '' }}">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                            <circle cx="12" cy="7" r="4"></circle>
                        </svg>
                        <span>Profil Saya</span>
                    </a>
                </nav>

                <!-- GRUP 2: BANTUAN & INFORMASI -->
                <div class="section-heading">BANTUAN & PANDUAN</div>
                <nav class="sidebar-nav-list">
                    {{-- 5. Panduan Cara Pinjam --}}
                    <button type="button" class="nav-link-item" onclick="toggleHelpModal()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="10"></circle>
                            <path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path>
                            <line x1="12" y1="17" x2="12.01" y2="17"></line>
                        </svg>
                        <span>Panduan Pinjam</span>
                    </button>

                    {{-- 6. Tata Tertib Sarana --}}
                    <button type="button" class="nav-link-item" onclick="toggleRulesModal()">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                            <polyline points="14 2 14 8 20 8"></polyline>
                            <line x1="16" y1="13" x2="8" y2="13"></line>
                            <line x1="16" y1="17" x2="8" y2="17"></line>
                            <polyline points="10 9 9 9 8 9"></polyline>
                        </svg>
                        <span>Tata Tertib & Aturan</span>
                    </button>

                    {{-- Mobile Logout Button --}}
                    <button type="button" onclick="toggleUserLogoutModal()" class="nav-link-item logout mobile-logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                        <span>Keluar Akun</span>
                    </button>
                </nav>

            </div>

            <!-- Footer Desktop Logout -->
            <div class="sidebar-footer">
                <button type="button" onclick="toggleUserLogoutModal()" class="nav-link-item logout">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                        <polyline points="16 17 21 12 16 7"></polyline>
                        <line x1="21" y1="12" x2="9" y2="12"></line>
                    </svg>
                    <span>Keluar Akun</span>
                </button>
            </div>

        </aside>

        <!-- ─── MAIN CONTENT WRAPPER ─── -->
        <div class="user-main-wrapper">

            <!-- TOPBAR USER -->
            <header class="user-topbar">
                <div class="topbar-left">
                    <button type="button" class="sidebar-toggle-btn" onclick="toggleUserSidebar()" aria-label="Buka Menu Sidebar">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="3" y1="12" x2="21" y2="12"></line>
                            <line x1="3" y1="6" x2="21" y2="6"></line>
                            <line x1="3" y1="18" x2="21" y2="18"></line>
                        </svg>
                    </button>
                    <div class="topbar-page-info">
                        <div class="topbar-page-title">
                            @yield('page_title', 'Portal Peminjaman Fasilitas')
                        </div>
                        <div class="topbar-page-subtitle">
                            <span>Sistem Informasi Sarana & Fasilitas Sekolah</span>
                        </div>
                    </div>
                </div>

                <div class="topbar-right">
                    <!-- Date Pill -->
                    <div class="topbar-date-pill">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <span>{{ \Carbon\Carbon::now()->translatedFormat('d M Y') }}</span>
                    </div>

                    <!-- HELP BTN -->
                    <button type="button" class="icon-action-btn" onclick="toggleHelpModal()" title="Panduan & Bantuan" id="btn-help-top">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    </button>

                    <!-- NOTIF BTN -->
                    <button type="button" class="icon-action-btn" onclick="toggleNotifModal()" title="Notifikasi" id="btn-notif-top">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                        <span id="user-notif-badge" style="position: absolute; top: 4px; right: 4px; min-width: 18px; height: 18px; border-radius: 9px; background: #EF4444; box-shadow: 0 0 8px rgba(239, 68, 68, 0.6); color: #fff; font-size: 10px; font-weight: 800; display: {{ $notifInitCount > 0 ? 'flex' : 'none' }}; align-items: center; justify-content: center; padding: 0 4px; transition: all 0.2s ease;">{{ $notifInitCount }}</span>
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
                                <div style="font-size: 13.5px; font-weight: 800; color: var(--text-main); white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
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
                            <a href="{{ route('user.notifikasi') }}" class="dropdown-menu-item">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                                <span>Semua Notifikasi</span>
                            </a>

                            <div style="height: 1px; background: var(--border-subtle); margin: 6px 0;"></div>

                            <button type="button" onclick="toggleUserLogoutModal()" class="dropdown-menu-item" style="color: #EF4444; width: 100%; text-align: left; background: none; border: none; cursor: pointer;">
                                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                <span>Keluar Akun</span>
                            </button>
                        </div>
                    </div>
                </div>
            </header>

            <!-- FLASH ALERTS -->
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

            <!-- PAGE CONTENT -->
            <main class="app-body">
                @yield('content')
            </main>

            <!-- FOOTER -->
            <footer class="glass-footer">
                <strong>SINFAS</strong> &bull; Sistem Informasi Fasilitas Sekolah &bull; {{ date('Y') }}
            </footer>

        </div>

    </div>

    <!-- ─── HELP MODAL (PANDUAN PINJAM) ─── -->
    <div class="modal-shade" id="help-modal">
        <div class="modal-box-vibe">
            <div class="modal-pulse-circle">
                <svg width="34" height="34" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
            </div>
            <h3 style="font-size: 21px; font-weight: 800; margin-bottom: 6px; color: #0F172A;">Cara Pinjam Fasilitas ⚡</h3>
            <p style="font-size: 13px; color: #64748B; margin-bottom: 18px;">Alur peminjaman fasilitas sekolah yang cepat, mudah, dan transparan:</p>
            <div style="text-align: left; font-size: 13px; color: var(--text-secondary); line-height: 1.6; margin-bottom: 22px; background: #F8FAFC; padding: 18px; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); display: flex; flex-direction: column; gap: 10px;">
                <p>🔎 <strong>1. Pilih Fasilitas:</strong> Buka <em>Katalog Fasilitas</em> dan pilih barang yang ingin dipinjam.</p>
                <p>📝 <strong>2. Isi Pengajuan:</strong> Tentukan tanggal peminjaman, estimasi kembali, dan keperluan jelas.</p>
                <p>⏳ <strong>3. Verifikasi Admin:</strong> Tunggu konfirmasi persetujuan dari petugas/admin sarana.</p>
                <p>📦 <strong>4. Ambil di Sarpras:</strong> Ambil barang di ruang sarana setelah disetujui.</p>
                <p>📸 <strong>5. Kembalikan & Foto:</strong> Saat mengembalikan, unggah foto kondisi barang via menu <em>Status Pinjaman</em>.</p>
            </div>
            <button type="button" class="btn-genz-primary" onclick="toggleHelpModal()" style="width: 100%;">Siap, Paham!</button>
        </div>
    </div>

    <!-- ─── RULES MODAL (TATA TERTIB SARANA) ─── -->
    <div class="modal-shade" id="rules-modal">
        <div class="modal-box-vibe" style="max-width: 520px; text-align: left;">
            <div style="display: flex; align-items: center; gap: 14px; margin-bottom: 16px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: #EEF4FF; color: #3B5998; display: flex; align-items: center; justify-content: center; font-size: 22px; flex-shrink: 0;">
                    📜
                </div>
                <div>
                    <h3 style="font-size: 19px; font-weight: 800; color: #0F172A; margin: 0;">Tata Tertib Peminjaman</h3>
                    <p style="font-size: 12px; color: #64748B; margin: 2px 0 0;">Aturan & ketentuan resmi penggunaan fasilitas sekolah</p>
                </div>
            </div>

            <div style="max-height: 340px; overflow-y: auto; padding: 14px; background: #F8FAFC; border-radius: var(--radius-md); border: 1px solid var(--border-subtle); font-size: 12.5px; color: #334155; line-height: 1.6; display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; gap: 10px;">
                    <span style="font-weight: 800; color: #3B5998;">1.</span>
                    <span><strong>Tujuan Peminjaman:</strong> Fasilitas hanya dapat dipinjam untuk keperluan kegiatan belajar mengajar, ekstrakurikuler, atau kegiatan resmi sekolah.</span>
                </div>
                <div style="display: flex; gap: 10px;">
                    <span style="font-weight: 800; color: #3B5998;">2.</span>
                    <span><strong>Batas Waktu:</strong> Batas waktu peminjaman maksimal adalah <strong>3 hari kerja</strong> kecuali mendapat persetujuan khusus dari pihak Sarana.</span>
                </div>
                <div style="display: flex; gap: 10px;">
                    <span style="font-weight: 800; color: #3B5998;">3.</span>
                    <span><strong>Tanggung Jawab Fisik:</strong> Peminjam bertanggung jawab penuh atas kebersihan, keutuhan, dan fungsi kelayakan barang yang dipinjam.</span>
                </div>
                <div style="display: flex; gap: 10px;">
                    <span style="font-weight: 800; color: #3B5998;">4.</span>
                    <span><strong>Foto Pengembalian:</strong> Wajib melampirkan foto bukti kondisi fisik barang saat melakukan form pengembalian.</span>
                </div>
                <div style="display: flex; gap: 10px;">
                    <span style="font-weight: 800; color: #EF4444;">5.</span>
                    <span><strong>Keterlambatan & Kerusakan:</strong> Keterlambatan beruntun atau kerusakan fasilitas akibat kelalaian akan dikenakan sanksi penangguhan hak pinjam serta kewajiban perbaikan/penggantian.</span>
                </div>
            </div>

            <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                <button type="button" class="btn-genz-primary" onclick="toggleRulesModal()" style="padding: 10px 22px; font-size: 13.5px;">Tutup</button>
            </div>
        </div>
    </div>

    <!-- ─── NOTIF MODAL ─── -->
    <div class="modal-shade" id="notif-modal">
        <div class="modal-box-vibe" style="max-width: 520px; padding: 0; text-align: left;">
            <!-- Modal Header -->
            <div style="padding: 22px 26px 16px; border-bottom: 1px solid #F1F5F9; display: flex; align-items: center; justify-content: space-between;">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <div style="width: 40px; height: 40px; border-radius: 50%; background: #EEF4FF; color: #3B5998; display: flex; align-items: center; justify-content: center;">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path><path d="M13.73 21a2 2 0 0 1-3.46 0"></path></svg>
                    </div>
                    <div>
                        <h3 style="font-size: 17px; font-weight: 800; color: #0F172A; margin: 0;">Pemberitahuan</h3>
                        <p id="user-notif-subtitle" style="font-size: 12px; color: #94A3B8; margin: 2px 0 0; font-weight: 500;">
                            @if(isset($userNotifications) && $userNotifications->count() > 0)
                                {{ $userNotifications->count() }} notifikasi aktif
                            @else
                                Tidak ada pemberitahuan baru
                            @endif
                        </p>
                    </div>
                </div>
                <button type="button" onclick="toggleNotifModal()" style="background: #F1F5F9; border: none; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; color: #64748B; transition: all 0.2s;" onmouseover="this.style.background='#E2E8F0'" onmouseout="this.style.background='#F1F5F9'">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                </button>
            </div>

            <!-- Notification List -->
            <div id="user-notif-list" style="max-height: 380px; overflow-y: auto; padding: 12px 16px;">
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
                        <div style="background: {{ $bgColor }}; border: 1.5px solid {{ $borderColor }}; border-radius: 14px; padding: 12px 14px; margin-bottom: 8px; display: flex; align-items: flex-start; gap: 12px; transition: transform 0.15s ease;" onmouseover="this.style.transform='translateX(4px)'" onmouseout="this.style.transform='none'">
                            <div style="font-size: 20px; flex-shrink: 0; margin-top: 1px;">{{ $notif['icon'] }}</div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 3px;">
                                    <span style="font-size: 13px; font-weight: 800; color: {{ $titleColor }};">{{ $notif['title'] }}</span>
                                    <span style="font-size: 10.5px; color: #94A3B8; font-weight: 500; white-space: nowrap;">#{{ Str::limit($notif['kode'], 16) }}</span>
                                </div>
                                <p style="font-size: 12px; color: #475569; line-height: 1.5; margin: 0;">{{ $notif['message'] }}</p>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div style="text-align: center; padding: 36px 20px;">
                        <div style="width: 64px; height: 64px; border-radius: 50%; background: #F0FDF4; color: #10B981; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; font-size: 28px;">
                            ✅
                        </div>
                        <h4 style="font-size: 17px; font-weight: 800; color: #0F172A; margin: 0 0 6px;">Semua Beres! 🎉</h4>
                        <p style="font-size: 12.5px; color: #94A3B8; margin: 0; line-height: 1.5;">
                            Tidak ada barang yang perlu dikembalikan atau menunggu verifikasi saat ini.
                        </p>
                    </div>
                @endif
            </div>

            <!-- Notif Modal Pagination -->
            <div id="user-notif-pagination" style="display: none; padding: 10px 18px; border-top: 1px solid #F1F5F9; align-items: center; justify-content: space-between; font-size: 12px; color: #64748B; background: #FAFBFD;">
                <span id="user-notif-page-info">Halaman 1 dari 1</span>
                <div style="display: inline-flex; align-items: center; gap: 4px;">
                    <button type="button" id="user-notif-prev-btn" onclick="changeNotifPage(-1)" style="border: 1px solid #CBD5E1; background: #fff; border-radius: 6px; padding: 3px 8px; font-size: 11.5px; font-weight: 600; cursor: pointer; color: #334155; transition: all 0.15s;">&larr; Prev</button>
                    <span id="user-notif-page-numbers" style="display: inline-flex; gap: 4px;"></span>
                    <button type="button" id="user-notif-next-btn" onclick="changeNotifPage(1)" style="border: 1px solid #CBD5E1; background: #fff; border-radius: 6px; padding: 3px 8px; font-size: 11.5px; font-weight: 600; cursor: pointer; color: #334155; transition: all 0.15s;">Next &rarr;</button>
                </div>
            </div>

            <!-- Modal Footer -->
            <div style="padding: 12px 18px; border-top: 1px solid #F1F5F9; display: flex; gap: 10px;">
                <a href="{{ route('user.notifikasi') }}" class="btn-genz-primary" style="flex: 1; font-size: 13px; padding: 9px 14px; text-align: center;">Lihat Semua Notifikasi</a>
                <button type="button" class="btn-genz-secondary" onclick="toggleNotifModal()" style="font-size: 13px; padding: 9px 14px;">Tutup</button>
            </div>
        </div>
    </div>

    <!-- ─── LOGOUT CONFIRMATION MODAL USER ─── -->
    <div class="modal-shade" id="user-logout-modal">
        <div class="modal-box-vibe" style="max-width: 420px;">
            <div class="modal-pulse-circle" style="background: #FFF1F2; color: #E11D48;">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                    <polyline points="16 17 21 12 16 7"></polyline>
                    <line x1="21" y1="12" x2="9" y2="12"></line>
                </svg>
            </div>
            <h3 style="font-size: 19px; font-weight: 800; margin-bottom: 6px; color: #1E293B;">Konfirmasi Keluar</h3>
            <p style="font-size: 13px; color: var(--text-secondary); margin-bottom: 22px; line-height: 1.5;">
                Apakah kamu yakin ingin keluar dari akun <strong>{{ Auth::user()->nama ?? 'Siswa' }}</strong>?
            </p>
            <form method="POST" action="{{ route('logout') }}" id="userLogoutForm">
                @csrf
                <div style="display: flex; gap: 10px;">
                    <button type="button" class="btn-genz-secondary" onclick="toggleUserLogoutModal()" style="flex: 1;">Batal</button>
                    <button type="submit" class="btn-genz-primary" style="flex: 1; background: #E11D48; box-shadow: 0 4px 14px rgba(225, 29, 72, 0.35);">Ya, Keluar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleUserSidebar() {
            const sidebar = document.getElementById('userSidebar');
            const backdrop = document.getElementById('userSidebarBackdrop');
            if (sidebar) sidebar.classList.toggle('open');
            if (backdrop) backdrop.classList.toggle('active');
        }

        function closeUserSidebar() {
            const sidebar = document.getElementById('userSidebar');
            const backdrop = document.getElementById('userSidebarBackdrop');
            if (sidebar) sidebar.classList.remove('open');
            if (backdrop) backdrop.classList.remove('active');
        }

        function toggleUserDropdown() {
            document.getElementById('dropdown-box').classList.toggle('open');
        }

        function toggleHelpModal() {
            document.getElementById('help-modal').classList.toggle('open');
            closeUserSidebar();
        }

        function toggleRulesModal() {
            document.getElementById('rules-modal').classList.toggle('open');
            closeUserSidebar();
        }

        function toggleNotifModal() {
            document.getElementById('notif-modal').classList.toggle('open');
        }

        function toggleUserLogoutModal() {
            const m = document.getElementById('user-logout-modal');
            if (m) m.classList.toggle('open');
            const dropdown = document.getElementById('dropdown-box');
            if (dropdown) dropdown.classList.remove('open');
            closeUserSidebar();
        }

        window.addEventListener('click', function(e) {
            const avatar = document.getElementById('btn-avatar-top');
            const dropdown = document.getElementById('dropdown-box');
            if (dropdown && avatar && !avatar.contains(e.target) && !dropdown.contains(e.target)) {
                dropdown.classList.remove('open');
            }
        });

        // Otomatis hapus alert sukses
        (function() {
            const alertEl = document.getElementById('alert-success-auto');
            if (alertEl) {
                setTimeout(function() {
                    alertEl.remove();
                }, 4500);
            }
        })();

        // Web Audio API Chime generator
        function playSinfasUserChime(type = 'success') {
            try {
                const AudioContext = window.AudioContext || window.webkitAudioContext;
                if (!AudioContext) return;
                const ctx = new AudioContext();
                if (ctx.state === 'suspended') {
                    ctx.resume();
                }
                const notes = type === 'success' ? [523.25, 659.25, 783.99] : [587.33, 440];
                notes.forEach((freq, idx) => {
                    const osc = ctx.createOscillator();
                    const gain = ctx.createGain();
                    osc.type = 'sine';
                    osc.frequency.setValueAtTime(freq, ctx.currentTime + idx * 0.12);
                    gain.gain.setValueAtTime(0.001, ctx.currentTime + idx * 0.12);
                    gain.gain.exponentialRampToValueAtTime(0.15, ctx.currentTime + idx * 0.12 + 0.02);
                    gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + idx * 0.12 + 0.35);
                    osc.connect(gain);
                    gain.connect(ctx.destination);
                    osc.start(ctx.currentTime + idx * 0.12);
                    osc.stop(ctx.currentTime + idx * 0.12 + 0.4);
                });
            } catch (e) {
                // Ignore audio restriction
            }
        }

        // Floating Toast Notification
        window.showUserToast = function(type, title, message) {
            let container = document.getElementById('user-toast-container');
            if (!container) {
                container = document.createElement('div');
                container.id = 'user-toast-container';
                container.className = 'user-toast-container';
                document.body.appendChild(container);
            }

            const toast = document.createElement('div');
            toast.className = `user-toast-card ${type}`;
            const iconSymbol = type === 'success' ? '✨' : '⚠️';

            toast.innerHTML = `
                <div class="user-toast-icon ${type}">${iconSymbol}</div>
                <div class="user-toast-content">
                    <div class="user-toast-title">${title}</div>
                    <div class="user-toast-message">${message}</div>
                </div>
                <button type="button" class="user-toast-close" onclick="this.closest('.user-toast-card').remove()">&times;</button>
            `;

            container.appendChild(toast);
            requestAnimationFrame(() => {
                toast.classList.add('show');
            });

            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 400);
            }, 6000);
        };

        // Realtime Polling User Notifications & Loan Updates
        (function() {
            let allUserNotifications = @json(isset($userNotifications) ? $userNotifications->values() : []);
            let notifCurrentPage = 1;
            const notifPerPage = 4;
            const knownStatuses = {};
            let isInitial = true;

            const bgMap = {
                overdue: '#FEF2F2',
                warning: '#FFFBEB',
                pending: '#EFF6FF',
                active:  '#F0FDF4',
            };
            const borderMap = {
                overdue: '#FCA5A5',
                warning: '#FCD34D',
                pending: '#93C5FD',
                active:  '#A7F3D0',
            };
            const titleMap = {
                overdue: '#DC2626',
                warning: '#D97706',
                pending: '#2563EB',
                active:  '#059669',
            };

            function updatePaginationControls(totalItems) {
                const totalPages = Math.ceil(totalItems / notifPerPage) || 1;
                const paginationEl = document.getElementById('user-notif-pagination');
                const pageInfoEl = document.getElementById('user-notif-page-info');
                const prevBtn = document.getElementById('user-notif-prev-btn');
                const nextBtn = document.getElementById('user-notif-next-btn');
                const pageNumbersEl = document.getElementById('user-notif-page-numbers');

                if (!paginationEl) return;

                if (totalItems <= notifPerPage) {
                    paginationEl.style.display = 'none';
                    return;
                }

                paginationEl.style.display = 'flex';
                if (pageInfoEl) pageInfoEl.textContent = `Halaman ${notifCurrentPage} dari ${totalPages}`;

                if (prevBtn) {
                    prevBtn.disabled = notifCurrentPage <= 1;
                    prevBtn.style.opacity = notifCurrentPage <= 1 ? '0.4' : '1';
                    prevBtn.style.cursor = notifCurrentPage <= 1 ? 'not-allowed' : 'pointer';
                }
                if (nextBtn) {
                    nextBtn.disabled = notifCurrentPage >= totalPages;
                    nextBtn.style.opacity = notifCurrentPage >= totalPages ? '0.4' : '1';
                    nextBtn.style.cursor = notifCurrentPage >= totalPages ? 'not-allowed' : 'pointer';
                }

                if (pageNumbersEl) {
                    let numbersHtml = '';
                    for (let p = 1; p <= totalPages; p++) {
                        const isActive = p === notifCurrentPage;
                        numbersHtml += `
                            <button type="button" onclick="goToNotifPage(${p})" style="border: 1px solid ${isActive ? '#3B5998' : '#CBD5E1'}; background: ${isActive ? '#3B5998' : '#FFFFFF'}; color: ${isActive ? '#FFFFFF' : '#334155'}; border-radius: 6px; padding: 2px 7px; font-size: 11px; font-weight: 700; cursor: pointer;">
                                ${p}
                            </button>
                        `;
                    }
                    pageNumbersEl.innerHTML = numbersHtml;
                }
            }

            window.changeNotifPage = function(delta) {
                const totalPages = Math.ceil(allUserNotifications.length / notifPerPage) || 1;
                const newPage = notifCurrentPage + delta;
                if (newPage >= 1 && newPage <= totalPages) {
                    notifCurrentPage = newPage;
                    renderNotificationList(allUserNotifications);
                }
            };

            window.goToNotifPage = function(page) {
                const totalPages = Math.ceil(allUserNotifications.length / notifPerPage) || 1;
                if (page >= 1 && page <= totalPages) {
                    notifCurrentPage = page;
                    renderNotificationList(allUserNotifications);
                }
            };

            function renderNotificationList(notifications) {
                allUserNotifications = notifications || [];
                const listEl = document.getElementById('user-notif-list');
                const subEl  = document.getElementById('user-notif-subtitle');
                if (!listEl) return;

                const count = allUserNotifications.length;
                if (subEl) {
                    subEl.textContent = count > 0 ? `${count} notifikasi aktif` : 'Tidak ada pemberitahuan baru';
                }

                if (count === 0) {
                    listEl.innerHTML = `
                        <div style="text-align: center; padding: 36px 20px;">
                            <div style="width: 64px; height: 64px; border-radius: 50%; background: #F0FDF4; color: #10B981; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px; font-size: 28px;">
                                ✅
                            </div>
                            <h4 style="font-size: 17px; font-weight: 800; color: #0F172A; margin: 0 0 6px;">Semua Beres! 🎉</h4>
                            <p style="font-size: 12.5px; color: #94A3B8; margin: 0; line-height: 1.5;">
                                Tidak ada barang yang perlu dikembalikan atau menunggu verifikasi saat ini.
                            </p>
                        </div>
                    `;
                    updatePaginationControls(0);
                    return;
                }

                const totalPages = Math.ceil(count / notifPerPage) || 1;
                if (notifCurrentPage > totalPages) notifCurrentPage = totalPages;

                const startIdx = (notifCurrentPage - 1) * notifPerPage;
                const pageItems = allUserNotifications.slice(startIdx, startIdx + notifPerPage);

                let html = '';
                pageItems.forEach(n => {
                    const borderColor = borderMap[n.type] || '#E2E8F0';
                    const bgColor     = bgMap[n.type] || '#F8FAFC';
                    const titleColor  = titleMap[n.type] || '#475569';
                    const shortKode   = n.kode.length > 16 ? n.kode.substring(0, 16) + '...' : n.kode;

                    html += `
                        <div style="background: ${bgColor}; border: 1.5px solid ${borderColor}; border-radius: 14px; padding: 12px 14px; margin-bottom: 8px; display: flex; align-items: flex-start; gap: 12px; transition: transform 0.15s ease;" onmouseover="this.style.transform='translateX(4px)'" onmouseout="this.style.transform='none'">
                            <div style="font-size: 20px; flex-shrink: 0; margin-top: 1px;">${n.icon}</div>
                            <div style="flex: 1; min-width: 0;">
                                <div style="display: flex; align-items: center; justify-content: space-between; gap: 8px; margin-bottom: 3px;">
                                    <span style="font-size: 13px; font-weight: 800; color: ${titleColor};">${n.title}</span>
                                    <span style="font-size: 10.5px; color: #94A3B8; font-weight: 500; white-space: nowrap;">#${shortKode}</span>
                                </div>
                                <p style="font-size: 12px; color: #475569; line-height: 1.5; margin: 0;">${n.message}</p>
                            </div>
                        </div>
                    `;
                });
                listEl.innerHTML = html;
                updatePaginationControls(count);
            }

            if (allUserNotifications.length > 0) {
                renderNotificationList(allUserNotifications);
            }

            async function checkUserLiveUpdates() {
                try {
                    const res = await fetch("{{ route('user.live-check') }}", {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });
                    if (!res.ok) return;
                    const data = await res.json();
                    if (!data.success) return;

                    // Update topbar badge
                    const topbarBadge = document.getElementById('user-notif-badge');
                    if (topbarBadge) {
                        topbarBadge.textContent = data.count;
                        topbarBadge.style.display = data.count > 0 ? 'flex' : 'none';
                    }

                    // Update sidebar badge
                    const sidebarBadge = document.getElementById('user-notif-badge-sidebar');
                    if (sidebarBadge) {
                        sidebarBadge.textContent = data.count;
                        sidebarBadge.style.display = data.count > 0 ? 'inline-block' : 'none';
                    }

                    // Render ulang modal
                    renderNotificationList(data.notifications);

                    // Deteksi perubahan status
                    if (data.recent_loans && Array.isArray(data.recent_loans)) {
                        data.recent_loans.forEach(loan => {
                            const prevStatus = knownStatuses[loan.kode_pinjam];
                            const currentStatus = loan.status_pengajuan;
                            const prevRetStatus = knownStatuses[loan.kode_pinjam + '_ret'];
                            const currentRetStatus = loan.status_pengembalian;

                            if (!isInitial && prevStatus) {
                                if (prevStatus === 'menunggu' && currentStatus === 'disetujui') {
                                    playSinfasUserChime('success');
                                    window.showUserToast(
                                        'success',
                                        '🎉 Pengajuan Disetujui!',
                                        `Peminjaman "${loan.nama_barang}" (#${loan.kode_pinjam}) telah DISETUJUI oleh Admin. Silakan ambil barang di ruang sarana.`
                                    );
                                    window.dispatchEvent(new CustomEvent('sinfas:loan-status-changed', { detail: loan }));
                                } else if (prevStatus === 'menunggu' && currentStatus === 'ditolak') {
                                    playSinfasUserChime('alert');
                                    window.showUserToast(
                                        'error',
                                        '❌ Pengajuan Ditolak',
                                        `Pengajuan pinjam "${loan.nama_barang}" (#${loan.kode_pinjam}) ditolak oleh Admin Sarana.`
                                    );
                                    window.dispatchEvent(new CustomEvent('sinfas:loan-status-changed', { detail: loan }));
                                } else if (prevRetStatus === 'menunggu' && currentRetStatus === 'selesai') {
                                    playSinfasUserChime('success');
                                    window.showUserToast(
                                        'success',
                                        '✅ Pengembalian Selesai!',
                                        `Pengembalian "${loan.nama_barang}" telah diverifikasi oleh Admin. Terima kasih telah merawat fasilitas!`
                                    );
                                    window.dispatchEvent(new CustomEvent('sinfas:loan-status-changed', { detail: loan }));
                                }
                            }

                            knownStatuses[loan.kode_pinjam] = currentStatus;
                            if (currentRetStatus) {
                                knownStatuses[loan.kode_pinjam + '_ret'] = currentRetStatus;
                            }
                        });
                    }

                    isInitial = false;
                } catch (e) {
                    // Silently ignore
                }
            }

            setInterval(checkUserLiveUpdates, 5000);
            setTimeout(checkUserLiveUpdates, 1500);
        })();
    </script>
    @yield('scripts')
</body>
</html>