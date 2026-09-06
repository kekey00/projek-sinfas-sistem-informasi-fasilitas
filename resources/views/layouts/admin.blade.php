<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Sarana') - SINFAS</title>
    
    <!-- Google Fonts: Gorditas, Fredoka, Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@600;700&family=Gorditas:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Chart.js (Optional for dashboard) -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --color-royal-blue-start: #4A6FA5;
            --color-royal-blue-mid: #6B8DD6;
            --color-royal-blue-end: #8E9AAF;
            
            --color-dark-blue-bubble: #2C4A7C;
            --color-light-blue-bubble: #7BA7D9;
            --color-border-blue: #3B5998;
            --color-focus-blue: #5B8DEF;
            --color-sidebar-bg: linear-gradient(180deg, #4A70BA 0%, #3B5FA8 40%, #294883 100%);
            --color-cyan-divider: rgba(123, 167, 217, 0.65);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #EFF2F7;
            min-height: 100vh;
            height: 100vh;
            margin: 0;
            padding: 0;
            display: flex;
            overflow: hidden;
            color: #1E293B;
        }

        /* Admin Full Screen Layout Container */
        .admin-layout {
            display: flex;
            width: 100vw;
            height: 100vh;
            overflow: hidden;
        }

        /* Left Sidebar - Exact Match to Right Reference Image */
        .card-sidebar {
            width: 270px;
            min-width: 270px;
            height: 100vh;
            background: linear-gradient(180deg, #446EB9 0%, #3B64AF 100%);
            padding: 28px 22px;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
            color: #FFFFFF;
            box-shadow: 4px 0 20px rgba(27, 49, 90, 0.12);
            z-index: 20;
            position: relative;
        }

        /* Profile Header */
        .profile-box {
            display: flex;
            align-items: center;
            gap: 14px;
            padding-bottom: 6px;
        }

        .avatar-circle {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            border: 2px solid #FFFFFF;
            overflow: hidden;
            background: #1E293B;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .avatar-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-text {
            display: flex;
            flex-direction: column;
            line-height: 1.15;
        }

        .profile-name {
            font-family: 'Gorditas', cursive;
            font-size: 19px;
            font-weight: 700;
            color: #FFFFFF;
            text-shadow: 1.5px 1.5px 3px rgba(0, 0, 0, 0.28);
            letter-spacing: 0.3px;
        }

        /* Thin Sky Blue / Cyan Divider */
        .sidebar-divider {
            border: none;
            border-top: 1.5px solid #58B4FA;
            margin: 18px 0;
            opacity: 0.85;
        }

        /* Section Headings ("Menu" & "Account") */
        .section-title {
            font-family: 'Gorditas', cursive;
            font-size: 23px;
            font-weight: 700;
            color: #FFFFFF;
            margin-bottom: 14px;
            letter-spacing: 0.5px;
            text-shadow: 1.5px 2px 3px rgba(0, 0, 0, 0.25);
        }

        /* Nav links in sidebar (Pure Gorditas Text, No Icons - Exactly Matching Image) */
        .nav-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .nav-link {
            font-family: 'Gorditas', cursive;
            font-size: 15px;
            color: #FFFFFF;
            text-decoration: none;
            display: block;
            padding: 7px 10px;
            border-radius: 8px;
            line-height: 1.35;
            transition: all 0.2s ease;
            text-shadow: 1px 1.5px 2px rgba(0, 0, 0, 0.25);
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.16);
            color: #FFFFFF;
            transform: translateX(4px);
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.26);
            box-shadow: inset 0 0 8px rgba(255, 255, 255, 0.2);
            color: #FFFFFF;
            font-weight: 700;
        }

        /* RIGHT CONTENT PANEL */
        .main-content {
            flex: 1;
            height: 100vh;
            background: #EFF2F7;
            padding: 24px 32px;
            display: flex;
            flex-direction: column;
            gap: 20px;
            overflow-y: auto;
            position: relative;
            z-index: 5;
        }

        /* Top Bar */
        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding-bottom: 4px;
            gap: 16px;
        }

        .topbar-title {
            font-family: 'Gorditas', cursive;
            font-size: 26px;
            font-weight: 700;
            color: var(--color-dark-blue-bubble);
            display: flex;
            align-items: center;
            gap: 10px;
            text-shadow: 1px 1px 0px rgba(0,0,0,0.05);
        }

        .topbar-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .search-box {
            position: relative;
            width: 240px;
        }

        .search-box input {
            width: 100%;
            background: #EBF3FE;
            border: 2px solid var(--color-border-blue);
            border-radius: 20px;
            padding: 8px 14px 8px 34px;
            font-family: 'Poppins', sans-serif;
            font-size: 12.5px;
            color: #1E293B;
            outline: none;
            transition: all 0.2s;
        }

        .search-box input:focus {
            background: #FFFFFF;
            border-color: var(--color-focus-blue);
            box-shadow: 0 0 10px rgba(91, 141, 239, 0.35);
        }

        .search-box svg {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748B;
        }

        .icon-btn {
            background: #EBF3FE;
            border: 2px solid var(--color-border-blue);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--color-border-blue);
            box-shadow: 0 3px 8px rgba(59, 89, 152, 0.12);
            transition: all 0.2s ease;
            position: relative;
            text-decoration: none;
        }

        .icon-btn:hover {
            transform: scale(1.08);
            background: #FFFFFF;
            border-color: var(--color-focus-blue);
        }

        .badge-dot {
            position: absolute;
            top: 2px;
            right: 2px;
            width: 10px;
            height: 10px;
            background: #EF4444;
            border: 2px solid #FFFFFF;
            border-radius: 50%;
        }

        /* Alerts & Flash Messages */
        .alert-sinfas {
            padding: 12px 18px;
            border-radius: 14px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            animation: slideDown 0.3s ease-out;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .alert-success {
            background: #DEF7EC;
            border: 2px solid #31C48D;
            color: #03543F;
        }

        .alert-error {
            background: #FDE8E8;
            border: 2px solid #F98080;
            color: #9B1C1C;
        }

        .alert-close {
            background: transparent;
            border: none;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            color: inherit;
            opacity: 0.7;
        }
        .alert-close:hover { opacity: 1; }

        /* General Card Container */
        .content-card {
            background: #FFFFFF;
            border: 2.5px solid var(--color-border-blue);
            border-radius: 20px;
            padding: 20px 22px;
            box-shadow: 0 6px 20px rgba(44, 74, 124, 0.08);
        }

        .card-header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .card-heading {
            font-family: 'Gorditas', cursive;
            font-size: 18px;
            font-weight: 700;
            color: var(--color-dark-blue-bubble);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Action Buttons */
        .btn-sinfas-primary {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
            color: #FFFFFF;
            border: 2px solid var(--color-border-blue);
            padding: 8px 18px;
            border-radius: 12px;
            font-family: 'Gorditas', cursive;
            font-size: 12.5px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-sinfas-primary:hover {
            transform: translateY(-2px);
            filter: brightness(1.08);
            box-shadow: 0 6px 14px rgba(37, 99, 235, 0.35);
        }

        .btn-sinfas-secondary {
            background: #F1F5F9;
            color: #334155;
            border: 1.5px solid #CBD5E1;
            padding: 7px 16px;
            border-radius: 10px;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 12px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
            transition: all 0.2s;
        }

        .btn-sinfas-secondary:hover {
            background: #E2E8F0;
        }

        /* Custom Modern Table */
        .custom-table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
        }

        .custom-table th {
            text-align: left;
            padding: 12px 14px;
            color: var(--color-dark-blue-bubble);
            font-weight: 700;
            font-family: 'Gorditas', cursive;
            font-size: 12.5px;
            border-bottom: 2px solid #CBD5E1;
            background: #F1F6FD;
        }

        .custom-table th:first-child {
            border-top-left-radius: 12px;
            border-bottom-left-radius: 12px;
        }

        .custom-table th:last-child {
            border-top-right-radius: 12px;
            border-bottom-right-radius: 12px;
        }

        .custom-table td {
            padding: 12px 14px;
            color: #1E293B;
            border-bottom: 1px solid #EDF2F7;
            vertical-align: middle;
        }

        .custom-table tr:hover td {
            background-color: #F8FAFC;
        }

        .custom-table tr:last-child td {
            border-bottom: none;
        }

        /* Badges */
        .badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            gap: 4px;
        }

        .badge-success {
            background: #DEF7EC;
            color: #03543F;
            border: 1px solid #31C48D;
        }

        .badge-warning {
            background: #FEF08A;
            color: #854D0E;
            border: 1px solid #FACC15;
        }

        .badge-danger {
            background: #FEE2E2;
            color: #991B1B;
            border: 1px solid #F87171;
        }

        .badge-info {
            background: #EBF3FE;
            color: #1E40AF;
            border: 1px solid #93C5FD;
        }

        /* Action Buttons Cell */
        .actions-cell {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .btn-action-sm {
            padding: 5px 10px;
            border-radius: 8px;
            font-family: 'Gorditas', cursive;
            font-size: 11px;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s;
            text-decoration: none;
            border: 1.5px solid transparent;
        }

        .btn-action-approve {
            background: linear-gradient(135deg, #10B981, #059669);
            color: #FFFFFF;
            border-color: #047857;
            box-shadow: 0 2px 6px rgba(16, 185, 129, 0.25);
        }

        .btn-action-approve:hover {
            transform: scale(1.05);
            filter: brightness(1.1);
        }

        .btn-action-reject {
            background: linear-gradient(135deg, #EF4444, #DC2626);
            color: #FFFFFF;
            border-color: #B91C1C;
            box-shadow: 0 2px 6px rgba(239, 68, 68, 0.25);
        }

        .btn-action-reject:hover {
            transform: scale(1.05);
            filter: brightness(1.1);
        }

        .btn-action-edit {
            background: #EFF6FF;
            color: #2563EB;
            border-color: #BFDBFE;
        }

        .btn-action-edit:hover {
            background: #DBEAFE;
            transform: scale(1.05);
        }

        .btn-action-delete {
            background: #FEF2F2;
            color: #DC2626;
            border-color: #FECACA;
        }

        .btn-action-delete:hover {
            background: #FEE2E2;
            transform: scale(1.05);
        }

        /* Modal Overlay & Card */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(15, 23, 42, 0.55);
            backdrop-filter: blur(4px);
            z-index: 1000;
            display: none;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .modal-overlay.active {
            display: flex;
        }

        .modal-card {
            background: #FFFFFF;
            border: 3px solid var(--color-border-blue);
            border-radius: 22px;
            width: 100%;
            max-width: 580px;
            max-height: 90vh;
            overflow-y: auto;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.25);
            padding: 24px 28px;
            position: relative;
            animation: popIn 0.25s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }

        @keyframes popIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 18px;
            padding-bottom: 12px;
            border-bottom: 2px solid #E2E8F0;
        }

        .modal-title {
            font-family: 'Gorditas', cursive;
            font-size: 20px;
            color: var(--color-dark-blue-bubble);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .modal-close-btn {
            background: transparent;
            border: none;
            font-size: 22px;
            color: #64748B;
            cursor: pointer;
            width: 32px;
            height: 32px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.2s;
        }

        .modal-close-btn:hover {
            background: #F1F5F9;
            color: #0F172A;
        }

        /* Form Inputs */
        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 12.5px;
            color: #334155;
            margin-bottom: 6px;
        }

        .form-input, .form-select, .form-textarea {
            width: 100%;
            background: #F8FAFC;
            border: 2px solid #CBD5E1;
            border-radius: 12px;
            padding: 9px 14px;
            font-family: 'Poppins', sans-serif;
            font-size: 13px;
            color: #0F172A;
            outline: none;
            transition: all 0.2s;
        }

        .form-input:focus, .form-select:focus, .form-textarea:focus {
            background: #FFFFFF;
            border-color: var(--color-focus-blue);
            box-shadow: 0 0 8px rgba(91, 141, 239, 0.3);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 22px;
            padding-top: 14px;
            border-top: 1.5px solid #E2E8F0;
        }

        @media (max-width: 1080px) {
            .admin-layout {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
                overflow-y: auto;
            }
            .card-sidebar {
                width: 100%;
                min-width: 100%;
                height: auto;
                border-right: none;
                border-bottom: 2px solid #58B4FA;
                padding: 20px;
            }
            .main-content {
                height: auto;
                min-height: calc(100vh - 200px);
                padding: 20px 16px;
            }
        }
    </style>
    @yield('styles')
</head>
<body>

    <!-- MAIN ADMIN FULL-SCREEN LAYOUT -->
    <div class="admin-layout">
        
        <!-- LEFT SIDEBAR - Exactly Matching Right Image Reference -->
        <aside class="card-sidebar">
            <div>
                <!-- Profile Header: Avatar with White Border + "Admin" & "Sarana" in Gorditas Font -->
                <div class="profile-box">
                    <div class="avatar-circle">
                        <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80" alt="Admin Sarana">
                    </div>
                    <div class="profile-text">
                        <span class="profile-name">Admin</span>
                        <span class="profile-name">Sarana</span>
                    </div>
                </div>

                <!-- Cyan / Sky Blue Horizontal Divider -->
                <hr class="sidebar-divider">

                <!-- Section: Menu -->
                <div class="section-title">Menu</div>
                <ul class="nav-list">
                    <!-- Home -->
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            Home
                        </a>
                    </li>
                    <!-- Kelola Data Alat -->
                    <li>
                        <a href="{{ route('admin.barang.index') }}" class="nav-link {{ request()->routeIs('admin.barang.*') ? 'active' : '' }}">
                            Kelola Data Alat
                        </a>
                    </li>
                    <!-- Kelola Kategori (CRUD Data Master) -->
                    <li>
                        <a href="{{ route('admin.kategori.index') }}" class="nav-link {{ request()->routeIs('admin.kategori.*') ? 'active' : '' }}">
                            Kelola Kategori
                        </a>
                    </li>
                    <!-- Verifikasi Pengajuan & Pengembalian -->
                    <li>
                        <a href="{{ route('admin.verifikasi.index') }}" class="nav-link {{ request()->routeIs('admin.verifikasi.*') ? 'active' : '' }}">
                            Verifikasi Pengajuan &amp; Pengembalian
                        </a>
                    </li>
                </ul>

                <!-- Cyan / Sky Blue Horizontal Divider -->
                <hr class="sidebar-divider">

                <!-- Section: Account -->
                <div class="section-title">Account</div>
                <ul class="nav-list">
                    <!-- Profile -->
                    <li>
                        <a href="javascript:void(0)" onclick="openModal('profileModal')" class="nav-link">
                            Profile
                        </a>
                    </li>
                    <!-- Keluar -->
                    <li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                        <a href="javascript:void(0)" onclick="confirmLogout()" class="nav-link">
                            Keluar
                        </a>
                    </li>
                </ul>
            </div>
        </aside>

        <!-- RIGHT MAIN CONTENT -->
        <main class="main-content">
            <!-- Topbar -->
            <div class="topbar">
                <div class="topbar-title">
                    @yield('page_icon')
                    <span>@yield('page_title', 'Admin Sarana')</span>
                </div>

                <div class="topbar-actions">
                    <!-- Global Search Box -->
                    <div class="search-box">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                        <input type="text" id="globalSearchInput" placeholder="Cari data..." onkeyup="filterContentTable(this.value)">
                    </div>

                    <!-- Notifikasi Icon -->
                    <a href="{{ route('admin.verifikasi.index') }}" class="icon-btn" title="Notifikasi Peminjaman">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 22c1.1 0 2-.9 2-2h-4c0 1.1.9 2 2 2zm6-6v-5c0-3.07-1.63-5.64-4.5-6.32V4c0-.83-.67-1.5-1.5-1.5s-1.5.67-1.5 1.5v.68C7.64 5.36 6 7.92 6 11v5l-2 2v1h16v-1l-2-2zm-2 1H8v-6c0-2.48 1.51-4.5 4-4.5s4 2.02 4 4.5v6z"/>
                        </svg>
                        <span class="badge-dot"></span>
                    </a>

                    <!-- Bantuan Icon -->
                    <button class="icon-btn" title="Bantuan SINFAS" onclick="openModal('helpModal')">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 16h-2v-2h2v2zm1.07-7.75l-.9.92C12.45 11.9 12 12.5 12 14h-2v-.5c0-1.1.45-2.1 1.17-2.83l1.24-1.26c.37-.36.59-.86.59-1.41 0-1.1-.9-2-2-2s-2 .9-2 2H7c0-2.76 2.24-5 5-5s5 2.24 5 5c0 1.04-.42 1.99-1.07 2.75z"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Flash Message Alerts -->
            @if(session('success'))
                <div class="alert-sinfas alert-success">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>{{ session('success') }}</span>
                    </div>
                    <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert-sinfas alert-error">
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
                        <span>{{ session('error') }}</span>
                    </div>
                    <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            @if($errors->any())
                <div class="alert-sinfas alert-error">
                    <div>
                        <div style="font-weight: bold; margin-bottom: 4px;">Periksa kembali input Anda:</div>
                        <ul style="margin-left: 20px; font-size: 12.5px;">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
                </div>
            @endif

            <!-- Main Dynamic Page Content -->
            @yield('content')

        </main>
    </div>

    <!-- Modal: Profile Admin -->
    <div id="profileModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <span>Profil Admin Sarana</span>
                </div>
                <button class="modal-close-btn" onclick="closeModal('profileModal')">&times;</button>
            </div>
            <div style="text-align: center; margin-bottom: 20px;">
                <div style="width: 80px; height: 80px; border-radius: 50%; border: 3px solid #3B5998; margin: 0 auto 12px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=150&auto=format&fit=crop&q=80" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <h3 style="font-family: 'Gorditas', cursive; color: #1E293B; font-size: 20px;">{{ Auth::user()->nama ?? 'Admin Sarana' }}</h3>
                <span class="badge badge-info" style="margin-top: 4px;">Role: Admin Sarana</span>
            </div>
            <div style="background: #F8FAFC; border-radius: 12px; padding: 14px 18px; font-size: 13px; line-height: 2;">
                <div><strong>Username:</strong> {{ Auth::user()->username ?? 'admin' }}</div>
                <div><strong>Kontak:</strong> {{ Auth::user()->nomor_kontak ?? '-' }}</div>
                <div><strong>Hak Akses:</strong> Kelola Master Kategori &amp; Barang, Verifikasi Peminjaman &amp; Pengembalian</div>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-sinfas-secondary" onclick="closeModal('profileModal')">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Modal: Bantuan -->
    <div id="helpModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"></path><line x1="12" y1="17" x2="12.01" y2="17"></line></svg>
                    <span>Panduan Admin Sarana</span>
                </div>
                <button class="modal-close-btn" onclick="closeModal('helpModal')">&times;</button>
            </div>
            <div style="font-size: 13px; line-height: 1.8; color: #334155;">
                <p><strong>1. Kelola Data Alat:</strong> Menambah, mengubah stok kondisi alat (baik, kurang baik, rusak berat), dan mengunggah foto alat fasilitas.</p>
                <p><strong>2. Kelola Kategori:</strong> Mengatur kategori master fasilitas (misal: Elektronik, Audio Visual, dsb).</p>
                <p><strong>3. Verifikasi Pengajuan:</strong> Menyetujui atau menolak permohonan pinjam alat dari siswa. Saat disetujui, stok barang baik akan otomatis berkurang.</p>
                <p><strong>4. Verifikasi Pengembalian:</strong> Mengonfirmasi barang fisik yang dikembalikan siswa dan mencatat kondisi fisiknya.</p>
            </div>
            <div class="form-actions">
                <button type="button" class="btn-sinfas-primary" onclick="closeModal('helpModal')">Mengerti</button>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Keluar -->
    <div id="logoutConfirmModal" class="modal-overlay">
        <div class="modal-card" style="max-width: 420px; text-align: center;">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: #FEE2E2; color: #DC2626; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
            </div>
            <h3 style="font-family: 'Gorditas', cursive; font-size: 18px; margin-bottom: 8px;">Konfirmasi Keluar</h3>
            <p style="font-size: 13px; color: #64748B; margin-bottom: 20px;">Apakah Anda yakin ingin keluar dari sistem SINFAS?</p>
            <div style="display: flex; justify-content: center; gap: 12px;">
                <button type="button" class="btn-sinfas-secondary" onclick="closeModal('logoutConfirmModal')">Batal</button>
                <button type="button" class="btn-action-sm btn-action-reject" style="padding: 8px 18px; font-size: 12.5px;" onclick="document.getElementById('logout-form').submit();">Ya, Keluar</button>
            </div>
        </div>
    </div>

    <!-- Modal Utilities Scripts -->
    <script>
        function openModal(id) {
            const el = document.getElementById(id);
            if (el) el.classList.add('active');
        }

        function closeModal(id) {
            const el = document.getElementById(id);
            if (el) el.classList.remove('active');
        }

        function confirmLogout() {
            openModal('logoutConfirmModal');
        }

        // Close modal when clicking outside of card
        window.addEventListener('click', function(e) {
            if (e.target.classList.contains('modal-overlay')) {
                e.target.classList.remove('active');
            }
        });

        // Simple client-side search filter for table
        function filterContentTable(keyword) {
            const lower = keyword.toLowerCase();
            const rows = document.querySelectorAll('.custom-table tbody tr');
            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                row.style.display = text.includes(lower) ? '' : 'none';
            });
        }
    </script>

    @yield('scripts')
</body>
</html>
