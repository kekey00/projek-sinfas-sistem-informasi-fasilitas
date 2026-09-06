<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - SINFAS</title>
    <meta name="description" content="Dashboard peminjaman fasilitas sekolah - SINFAS">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Gorditas:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #ECEEF2;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 24px 16px;
            color: #1E293B;
        }

        /* ── Outer Container ── */
        .user-dashboard-card {
            display: flex;
            flex-direction: row;
            width: 100%;
            max-width: 1280px;
            background: #FFFFFF;
            border: 3.5px solid #3B66C4;
            border-radius: 28px;
            box-shadow: 0 16px 40px rgba(44,74,124,0.22);
            min-height: 750px;
            overflow: hidden;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 230px;
            min-width: 230px;
            background: linear-gradient(180deg, #4673CE 0%, #375FB7 45%, #254790 100%);
            padding: 26px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #FFF;
            border-right: 3px solid #3B66C4;
        }
        .brand-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding-bottom: 24px;
        }
        .brand-avatar {
            width: 44px; height: 44px;
            border-radius: 50%;
            background: #D1D5DB;
            border: 2px solid #FFF;
            display: flex; align-items: center; justify-content: center;
            overflow: hidden;
            box-shadow: 0 3px 8px rgba(0,0,0,.15);
        }
        .brand-title {
            font-family: 'Gorditas', cursive;
            font-size: 22px; font-weight: 700;
            color: #FFF; letter-spacing: 1px;
            text-shadow: 1px 1px 2px rgba(0,0,0,.25);
        }
        .nav-list { display: flex; flex-direction: column; gap: 16px; list-style: none; margin-top: 10px; }
        .nav-link {
            font-family: 'Gorditas', cursive;
            font-size: 16px; color: #FFF; text-decoration: none;
            display: flex; align-items: center; gap: 12px;
            padding: 10px 14px; border-radius: 12px;
            transition: all .2s ease;
        }
        .nav-link:hover { background: rgba(255,255,255,.18); transform: translateX(4px); }
        .nav-link.active { background: rgba(255,255,255,.22); border: 1.5px solid rgba(255,255,255,.35); }
        .nav-icon { width: 22px; height: 22px; stroke-width: 2.3; flex-shrink: 0; }
        .nav-logout { margin-top: auto; padding-top: 20px; }

        /* ── MAIN CONTENT ── */
        .main-content {
            flex: 1;
            background: #FFF;
            padding: 24px 30px;
            display: flex; flex-direction: column; gap: 18px;
            overflow-y: auto;
        }

        /* ── TOP BAR ── */
        .topbar { display: flex; align-items: center; gap: 14px; width: 100%; }
        .search-form { flex: 1; display: flex; gap: 10px; }
        .search-container { flex: 1; position: relative; }
        .search-input {
            width: 100%;
            background: #C7DBF8;
            border: 2.5px solid #00A2FF;
            border-radius: 14px;
            padding: 10px 16px 10px 42px;
            font-family: 'Poppins', sans-serif;
            font-size: 13.5px; color: #1E293B;
            outline: none; transition: all .2s ease;
            box-shadow: inset 0 2px 4px rgba(0,0,0,.05);
        }
        .search-input::placeholder { color: #64748B; font-weight: 500; }
        .search-input:focus { background: #E2EEFC; border-color: #3B66C4; }
        .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: #334155; pointer-events: none; }

        .filter-select {
            background: #C2D1F7;
            border: 2px solid #3B66C4;
            border-radius: 12px;
            padding: 9px 14px;
            font-family: 'Gorditas', cursive;
            font-size: 13px; color: #1E293B;
            cursor: pointer; outline: none;
            transition: all .2s ease;
        }
        .filter-select:focus { background: #ADC2F5; }

        .search-btn {
            background: linear-gradient(135deg, #4673CE, #254790);
            border: none; border-radius: 12px;
            padding: 9px 18px;
            font-family: 'Gorditas', cursive;
            font-size: 13px; color: #FFF;
            cursor: pointer; transition: all .2s ease;
            box-shadow: 0 4px 12px rgba(59,102,196,.3);
        }
        .search-btn:hover { transform: scale(1.03); box-shadow: 0 6px 16px rgba(59,102,196,.4); }

        .top-icons-group { display: flex; align-items: center; gap: 10px; flex-shrink: 0; }
        .header-icon-btn {
            width: 40px; height: 40px;
            border-radius: 50%; border: 1.5px solid #CBD5E1;
            background: #FFF;
            display: flex; align-items: center; justify-content: center;
            color: #334155; cursor: pointer; transition: all .2s ease;
        }
        .header-icon-btn:hover { background: #F1F5F9; border-color: #94A3B8; transform: scale(1.06); }

        /* ── WELCOME BANNER ── */
        .welcome-banner {
            width: 100%;
            background: linear-gradient(180deg, #4A76D2 0%, #2D54A8 100%);
            border: 3px solid #3B66C4; border-radius: 20px;
            padding: 20px 30px;
            box-shadow: 0 6px 16px rgba(44,74,124,.18);
            display: flex; align-items: center; justify-content: space-between;
            min-height: 80px;
        }
        .welcome-title {
            font-family: 'Gorditas', cursive;
            font-size: 32px; font-weight: 700; color: #FFF;
            letter-spacing: 1.5px; text-shadow: 2px 2px 5px rgba(0,0,0,.4);
        }
        .welcome-sub {
            font-size: 13px; color: rgba(255,255,255,.8);
            font-weight: 400; margin-top: 4px;
        }

        /* ── SUCCESS ALERT ── */
        .alert-success {
            background: linear-gradient(135deg, #D1FAE5, #A7F3D0);
            border: 2px solid #10B981;
            border-radius: 14px; padding: 14px 20px;
            display: flex; align-items: center; gap: 12px;
            font-size: 13.5px; color: #065F46; font-weight: 500;
            animation: slideIn .4s ease;
        }
        @keyframes slideIn { from { opacity:0; transform:translateY(-10px); } to { opacity:1; transform:translateY(0); } }

        /* ── FACILITY CONTAINER ── */
        .section-label {
            font-family: 'Gorditas', cursive;
            font-size: 14px; color: rgba(255,255,255,.75);
            margin-bottom: 14px; letter-spacing: .5px;
        }
        .facility-container {
            background: linear-gradient(180deg, #375EB6 0%, #264790 100%);
            border: 3px solid #1E3A75; border-radius: 22px;
            padding: 24px 20px;
            box-shadow: inset 0 2px 8px rgba(0,0,0,.15), 0 6px 20px rgba(37,71,144,.2);
            flex: 1;
        }

        /* ── NO RESULT ── */
        .no-result {
            text-align: center; padding: 40px 20px;
            color: rgba(255,255,255,.7);
            font-family: 'Gorditas', cursive; font-size: 16px;
        }
        .no-result svg { opacity: .5; margin-bottom: 12px; }

        /* ── GRID ── */
        .facility-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            column-gap: 18px; row-gap: 22px;
        }
        .facility-card-wrapper { display: flex; flex-direction: column; align-items: center; gap: 6px; }
        .facility-card {
            width: 100%; aspect-ratio: 1/1;
            background: #C7D7FA;
            border: 2.5px solid #3B66C4; border-radius: 18px;
            display: flex; flex-direction: column;
            align-items: center; justify-content: space-between;
            padding: 12px 10px 10px;
            position: relative;
            box-shadow: 0 4px 12px rgba(0,0,0,.12);
            transition: transform .2s ease, box-shadow .2s ease;
            cursor: pointer; text-decoration: none;
        }
        .facility-card:hover { transform: translateY(-4px) scale(1.02); box-shadow: 0 8px 20px rgba(0,0,0,.2); }

        /* Status Badge */
        .status-badge {
            position: absolute; top: -11px; left: 50%; transform: translateX(-50%);
            padding: 2px 14px; border-radius: 20px;
            font-family: 'Gorditas', cursive; font-size: 11px; font-weight: 700;
            color: #FFF; letter-spacing: .5px;
            box-shadow: 0 2px 6px rgba(0,0,0,.2);
            z-index: 5; white-space: nowrap;
            border: 1.5px solid #FFF;
        }
        .status-badge.available { background-color: #0E5E2C; }
        .status-badge.unavailable { background-color: #8C1C1C; }

        /* Card Image */
        .card-image-box {
            flex: 1; width: 100%;
            display: flex; align-items: center; justify-content: center;
            padding: 4px; margin-top: 6px;
        }
        .card-image-box img {
            max-width: 85%; max-height: 80px;
            object-fit: contain;
            filter: drop-shadow(0 4px 6px rgba(0,0,0,.2));
            transition: transform .2s ease;
        }
        .facility-card:hover .card-image-box img { transform: scale(1.08); }

        /* Icon fallback */
        .card-icon-fallback {
            width: 60px; height: 60px;
            background: rgba(59,102,196,.15);
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            color: #3B66C4;
        }

        /* Bottom Name Pill */
        .name-pill {
            width: 100%;
            background: #7D9FEA; border: 1.5px solid #3B66C4;
            border-radius: 10px; padding: 3px 6px;
            text-align: center; box-shadow: 0 2px 4px rgba(0,0,0,.1);
        }
        .name-text {
            font-family: 'Gorditas', cursive; font-size: 11px; font-weight: 700;
            color: #FFF; display: block;
            text-shadow: 1px 1px 2px rgba(0,0,0,.25);
            white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
        }

        /* Apply Link */
        .apply-link {
            font-family: 'Gorditas', cursive; font-size: 12px; font-weight: 700;
            color: #FFF; text-decoration: none; letter-spacing: .3px;
            transition: color .15s ease;
            text-shadow: 1px 1px 2px rgba(0,0,0,.4);
            text-align: center;
        }
        .apply-link:hover { color: #D1E4FF; text-decoration: underline; }
        .apply-link.disabled-link { color: rgba(255,255,255,.4); pointer-events: none; }

        /* ── RESPONSIVE ── */
        @media (max-width: 1024px) { .facility-grid { grid-template-columns: repeat(3,1fr); } }
        @media (max-width: 768px) {
            .user-dashboard-card { flex-direction: column; }
            .sidebar { width:100%; min-width:100%; border-right:none; border-bottom:3px solid #3B66C4; }
            .facility-grid { grid-template-columns: repeat(2,1fr); }
        }
        @media (max-width: 480px) { .facility-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="user-dashboard-card">

    <!-- ═══════════════════ SIDEBAR ═══════════════════ -->
    <aside class="sidebar">
        <div>
            <!-- Brand -->
            <div class="brand-header">
                <div class="brand-avatar">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3B66C4" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <span class="brand-title">SINFAS</span>
            </div>

            <!-- Nav -->
            <ul class="nav-list">
                <li>
                    <a href="{{ route('user.dashboard') }}" class="nav-link active" id="nav-home">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                            <polyline points="9 22 9 12 15 12 15 22"/>
                        </svg>
                        <span>Home</span>
                    </a>
                </li>
                <li>
                    <a href="#profile" class="nav-link" id="nav-profile">
                        <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                        </svg>
                        <span>Profile</span>
                    </a>
                </li>
            </ul>
        </div>

        <!-- Logout -->
        <div class="nav-logout">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link" id="btn-logout" style="background:none;border:none;width:100%;text-align:left;cursor:pointer;">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- ═══════════════════ MAIN CONTENT ═══════════════════ -->
    <main class="main-content">

        <!-- 1. TOP BAR -->
        <div class="topbar">
            <!-- Search + Filter Form -->
            <form method="GET" action="{{ route('user.dashboard') }}" class="search-form" id="search-form">
                <div class="search-container">
                    <svg class="search-icon" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input
                        type="text"
                        id="search-input"
                        name="q"
                        class="search-input"
                        placeholder="Cari barang yang ingin dipinjam..."
                        value="{{ request('q') }}"
                        autocomplete="off"
                    >
                </div>

                <!-- Filter Kategori -->
                <select name="kategori" id="filter-kategori" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                            {{ $kat->nama_kategori }}
                        </option>
                    @endforeach
                </select>

                <button type="submit" class="search-btn" id="btn-search">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="vertical-align:middle;margin-right:4px;">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    Cari
                </button>
            </form>

            <!-- Icon Grup -->
            <div class="top-icons-group">
                <button class="header-icon-btn" id="btn-notif" title="Notifikasi">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                        <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                </button>
                <button class="header-icon-btn" id="btn-user-icon" title="Akun">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- 2. FLASH SUCCESS -->
        @if(session('success'))
            <div class="alert-success" id="alert-success">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/>
                    <polyline points="22 4 12 14.01 9 11.01"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <!-- 3. WELCOME BANNER -->
        <div class="welcome-banner">
            <div>
                <h1 class="welcome-title">Hi, {{ Auth::user()->nama }}!</h1>
                <p class="welcome-sub">Pilih barang yang ingin Anda pinjam</p>
            </div>
            <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.5">
                <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/>
            </svg>
        </div>

        <!-- 4. GRID BARANG -->
        <div class="facility-container">
            @if(request('q') || request('kategori'))
                <p class="section-label">
                    Hasil pencarian
                    @if(request('q')) untuk "{{ request('q') }}" @endif
                    @if(request('kategori')) · {{ $kategoris->find(request('kategori'))?->nama_kategori ?? '' }} @endif
                    — {{ $barangs->count() }} barang ditemukan
                </p>
            @endif

            @if($barangs->isEmpty())
                <div class="no-result">
                    <svg width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" display="block" style="margin:0 auto 16px;">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    Tidak ada barang yang ditemukan.<br>
                    <small style="font-family:'Poppins';font-size:13px;font-weight:400;">Coba kata kunci yang berbeda.</small>
                </div>
            @else
                <div class="facility-grid" id="facility-grid">
                    @foreach($barangs as $barang)
                        @php
                            $tersedia = $barang->jumlah_baik > 0;
                        @endphp
                        <div class="facility-card-wrapper">
                            <!-- Kartu Barang -->
                            <a href="{{ route('user.barang.show', $barang->kode_barang) }}"
                               class="facility-card"
                               id="card-{{ $barang->kode_barang }}"
                               title="Lihat detail {{ $barang->nama_barang }}">

                                <!-- Status Badge -->
                                <div class="status-badge {{ $tersedia ? 'available' : 'unavailable' }}">
                                    {{ $tersedia ? 'Tersedia' : 'Tidak Tersedia' }}
                                </div>

                                <!-- Gambar / Icon -->
                                <div class="card-image-box">
                                    @if($barang->foto)
                                        <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}">
                                    @else
                                        <!-- Placeholder icon berdasarkan kategori -->
                                        <div class="card-icon-fallback">
                                            @php $katNama = strtolower($barang->kategori->nama_kategori ?? ''); @endphp
                                            @if(str_contains($katNama,'elektronik') || str_contains($barang->nama_barang,'Laptop'))
                                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                            @elseif(str_contains($katNama,'audio') || str_contains($barang->nama_barang,'Mikrofon') || str_contains($barang->nama_barang,'Speaker'))
                                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="23"/><line x1="8" y1="23" x2="16" y2="23"/></svg>
                                            @elseif(str_contains($katNama,'listrik'))
                                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                                            @elseif(str_contains($katNama,'komunik') || str_contains($barang->nama_barang,'HT'))
                                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.29 6.29l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                            @elseif(str_contains($barang->nama_barang,'Camera') || str_contains($barang->nama_barang,'Kamera'))
                                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                            @elseif(str_contains($barang->nama_barang,'Proyektor'))
                                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="7" width="20" height="14" rx="2"/><circle cx="12" cy="14" r="3"/><path d="M12 3v4"/><path d="M8 3h8"/></svg>
                                            @else
                                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="3" width="20" height="14" rx="2"/><path d="M8 21h8"/><path d="M12 17v4"/></svg>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <!-- Nama Pill -->
                                <div class="name-pill">
                                    <span class="name-text" title="{{ $barang->nama_barang }}">{{ $barang->nama_barang }}</span>
                                </div>
                            </a>

                            <!-- Link Ajukan Peminjaman -->
                            @if($tersedia)
                                <a href="{{ route('user.barang.show', $barang->kode_barang) }}"
                                   class="apply-link"
                                   id="apply-{{ $barang->kode_barang }}">
                                    Ajukan Peminjaman
                                </a>
                            @else
                                <span class="apply-link disabled-link">Tidak Tersedia</span>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </main>
</div>

<script>
    // Auto-submit search saat user mengetik (debounce 400ms)
    const searchInput = document.getElementById('search-input');
    let debounceTimer;
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => {
                document.getElementById('search-form').submit();
            }, 400);
        });
    }

    // Auto-hide success alert setelah 5 detik
    const alert = document.getElementById('alert-success');
    if (alert) {
        setTimeout(() => {
            alert.style.transition = 'opacity .5s ease';
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 500);
        }, 5000);
    }
</script>

</body>
</html>
