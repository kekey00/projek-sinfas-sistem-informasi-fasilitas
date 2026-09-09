<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SINFAS</title>
    <meta name="description" content="Dashboard peminjaman fasilitas sekolah - SINFAS">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --navy-900: #16264F;
            --navy-800: #1B2F63;
            --indigo-700: #2D4FA0;
            --indigo-600: #3B66C4;
            --indigo-500: #4A76D2;
            --indigo-400: #6690DE;
            --indigo-100: #E8EEFC;
            --indigo-50:  #F0F4FF;
            --green-700:  #0E5E2C;
            --green-600:  #16A34A;
            --red-700:    #8B1E1E;
            --bg:     #F0F2F8;
            --surface:#FFFFFF;
            --border: #E4E8F4;
            --text:   #1B2333;
            --muted:  #64748B;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body { font-family: 'Inter', sans-serif; background: var(--bg); color: var(--text); min-height: 100vh; }

        /* APP SHELL */
        .app { display: flex; min-height: 100vh; }

        /* SIDEBAR */
        .sidebar {
            width: 240px; min-width: 240px;
            background: linear-gradient(175deg, var(--indigo-500) 0%, var(--navy-800) 55%, var(--navy-900) 100%);
            display: flex; flex-direction: column;
            color: #fff;
            position: sticky; top: 0; height: 100vh;
            overflow-y: auto;
            box-shadow: 4px 0 24px rgba(27,47,99,.18);
            z-index: 50;
        }
        .sidebar-brand {
            display: flex; align-items: center; gap: 12px;
            padding: 24px 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,.12);
        }
        .brand-logo {
            width: 40px; height: 40px; border-radius: 12px;
            background: rgba(255,255,255,.15); border: 1.5px solid rgba(255,255,255,.3);
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
        }
        .brand-name { font-family: 'Baloo 2', sans-serif; font-size: 21px; font-weight: 800; letter-spacing: .4px; color: #fff; }
        .sidebar-nav { flex: 1; padding: 14px 12px; display: flex; flex-direction: column; gap: 3px; }
        .nav-section-label {
            font-size: 10px; font-weight: 700; letter-spacing: 1.2px; text-transform: uppercase;
            color: rgba(255,255,255,.45); padding: 12px 8px 6px;
        }
        .nav-link {
            display: flex; align-items: center; gap: 11px;
            padding: 10px 12px; border-radius: 10px;
            color: rgba(255,255,255,.78); text-decoration: none;
            font-family: 'Baloo 2', sans-serif; font-size: 14.5px; font-weight: 600;
            transition: all .18s ease;
            cursor: pointer; background: none; border: none; width: 100%; text-align: left;
        }
        .nav-link svg { width: 18px; height: 18px; stroke-width: 2.1; flex-shrink: 0; opacity: .85; }
        .nav-link:hover { background: rgba(255,255,255,.1); color: #fff; }
        .nav-link.active { background: rgba(255,255,255,.16); color: #fff; border-left: 3px solid rgba(255,255,255,.8); }
        .nav-link.active svg { opacity: 1; }
        .sidebar-footer { padding: 12px; border-top: 1px solid rgba(255,255,255,.12); }
        .nav-link.logout { color: rgba(255,180,180,.85); }
        .nav-link.logout:hover { background: rgba(220,38,38,.15); color: #FCA5A5; }

        /* MAIN */
        .main { flex: 1; display: flex; flex-direction: column; min-height: 100vh; overflow-x: hidden; }

        /* TOPBAR */
        .topbar {
            background: var(--surface); border-bottom: 1px solid var(--border);
            padding: 12px 28px; display: flex; align-items: center; gap: 14px;
            position: sticky; top: 0; z-index: 40;
            box-shadow: 0 1px 4px rgba(0,0,0,.04);
        }
        .search-wrap { flex: 1; display: flex; align-items: center; gap: 10px; }
        .search-box { flex: 1; position: relative; max-width: 440px; }
        .search-icon { position: absolute; left: 14px; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
        .search-input {
            width: 100%; background: var(--bg); border: 1.5px solid var(--border);
            border-radius: 30px; padding: 9px 18px 9px 42px;
            font-family: 'Inter', sans-serif; font-size: 13.5px; color: var(--text);
            outline: none; transition: border-color .15s, box-shadow .15s;
        }
        .search-input::placeholder { color: #94A3B8; }
        .search-input:focus { border-color: var(--indigo-600); box-shadow: 0 0 0 3px var(--indigo-100); background: #fff; }
        .filter-select {
            background: var(--bg); border: 1.5px solid var(--border); border-radius: 30px;
            padding: 9px 36px 9px 16px; font-family: 'Baloo 2', sans-serif; font-size: 13.5px; font-weight: 600; color: #334155;
            cursor: pointer; outline: none; appearance: none; -webkit-appearance: none;
            background-image: url("data:image/svg+xml;utf8,<svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%23334155' stroke-width='2.4' stroke-linecap='round' stroke-linejoin='round'><polyline points='6 9 12 15 18 9'/></svg>");
            background-repeat: no-repeat; background-position: right 12px center;
        }
        .filter-select:focus { border-color: var(--indigo-600); box-shadow: 0 0 0 3px var(--indigo-100); }
        .topbar-icons { display: flex; align-items: center; gap: 6px; }
        .icon-btn {
            width: 36px; height: 36px; border-radius: 10px; border: none;
            background: var(--bg); display: flex; align-items: center; justify-content: center;
            color: var(--muted); cursor: pointer; transition: all .15s;
        }
        .icon-btn:hover { background: var(--indigo-100); color: var(--indigo-600); }

        /* PAGE BODY */
        .page-body { flex: 1; padding: 22px 28px; display: flex; flex-direction: column; gap: 18px; }

        /* ALERT */
        .alert-success {
            background: linear-gradient(135deg, #DCFCE7, #BBF7D0); border: 1.5px solid #86EFAC;
            border-radius: 12px; padding: 13px 18px; display: flex; align-items: center; gap: 10px;
            font-size: 13.5px; color: #15803D; font-weight: 500; animation: slideDown .35s ease;
        }
        @keyframes slideDown { from { opacity:0; transform:translateY(-8px); } to { opacity:1; transform:translateY(0); } }

        /* WELCOME BANNER */
        .welcome-banner {
            background: linear-gradient(135deg, var(--indigo-500) 0%, var(--navy-800) 60%, var(--navy-900) 100%);
            border-radius: 20px; padding: 22px 28px;
            display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 6px 20px rgba(27,47,99,.2); position: relative; overflow: hidden;
        }
        .welcome-banner::before {
            content: ''; position: absolute; top: -40px; right: -40px;
            width: 180px; height: 180px; border-radius: 50%; background: rgba(255,255,255,.06);
        }
        .welcome-text h1 { font-family: 'Baloo 2', sans-serif; font-size: 26px; font-weight: 800; color: #fff; }
        .welcome-text p { font-size: 13.5px; color: rgba(255,255,255,.75); margin-top: 4px; }
        .welcome-icon {
            width: 56px; height: 56px; border-radius: 16px;
            background: rgba(255,255,255,.12); display: flex; align-items: center; justify-content: center;
            border: 1.5px solid rgba(255,255,255,.2); flex-shrink: 0; position: relative; z-index: 1;
        }

        /* SECTION HEADER */
        .section-header { display: flex; align-items: center; justify-content: space-between; }
        .section-title { font-family: 'Baloo 2', sans-serif; font-size: 16px; font-weight: 700; color: var(--text); }
        .section-count {
            font-size: 13px; color: var(--muted); background: var(--bg);
            border: 1px solid var(--border); border-radius: 20px; padding: 3px 12px;
        }

        /* FACILITY GRID */
        .facility-grid { display: grid; grid-template-columns: repeat(5, 1fr); gap: 16px; }

        .facility-card {
            background: var(--surface); border: 1.5px solid var(--border); border-radius: 16px;
            padding: 16px 12px 14px; display: flex; flex-direction: column;
            align-items: center; gap: 10px; position: relative;
            text-decoration: none; color: var(--text);
            transition: transform .2s, box-shadow .2s, border-color .2s;
            box-shadow: 0 2px 8px rgba(0,0,0,.04); cursor: pointer;
        }
        .facility-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(27,47,99,.12); border-color: var(--indigo-400); }

        .status-badge {
            position: absolute; top: -10px; left: 50%; transform: translateX(-50%);
            padding: 2px 14px; border-radius: 20px;
            font-family: 'Baloo 2', sans-serif; font-size: 10.5px; font-weight: 700;
            color: #fff; white-space: nowrap; border: 1.5px solid #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,.15); z-index: 5;
        }
        .status-badge.available   { background: var(--green-700); }
        .status-badge.unavailable { background: var(--red-700); }

        .card-icon-wrap {
            width: 68px; height: 68px; border-radius: 16px;
            background: var(--indigo-50); display: flex; align-items: center; justify-content: center;
            color: var(--indigo-600); transition: background .2s; margin-top: 8px;
        }
        .facility-card:hover .card-icon-wrap { background: var(--indigo-100); }
        .card-image-box {
            width: 68px; height: 68px; border-radius: 16px; overflow: hidden;
            display: flex; align-items: center; justify-content: center; margin-top: 8px;
        }
        .card-image-box img { max-width: 100%; max-height: 100%; object-fit: contain; transition: transform .2s; filter: drop-shadow(0 3px 5px rgba(0,0,0,.15)); }
        .facility-card:hover .card-image-box img { transform: scale(1.08); }

        .card-bottom { width: 100%; text-align: center; }
        .card-name { font-family: 'Baloo 2', sans-serif; font-size: 12.5px; font-weight: 700; color: var(--text); display: block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 4px; }
        .card-action { display: inline-block; font-size: 11.5px; font-weight: 600; color: var(--indigo-600); text-decoration: none; transition: color .15s; }
        .card-action:hover { color: var(--indigo-700); text-decoration: underline; }
        .card-action.disabled { color: var(--muted); pointer-events: none; }

        /* EMPTY STATE */
        .empty-state { text-align: center; padding: 60px 20px; color: var(--muted); grid-column: 1 / -1; }
        .empty-state svg { margin: 0 auto 14px; display: block; opacity: .35; }
        .empty-state p { font-family: 'Baloo 2', sans-serif; font-size: 16px; font-weight: 600; margin-bottom: 4px; }

        /* RESPONSIVE */
        @media (max-width: 1200px) { .facility-grid { grid-template-columns: repeat(4,1fr); } }
        @media (max-width: 960px)  { .facility-grid { grid-template-columns: repeat(3,1fr); } }
        @media (max-width: 720px)  { .facility-grid { grid-template-columns: repeat(2,1fr); } }
        @media (max-width: 680px)  { .app { flex-direction: column; } .sidebar { width:100%; min-width:100%; height:auto; position:static; } }
        @media (max-width: 480px)  { .facility-grid { grid-template-columns: 1fr; } }
    </style>
</head>
<body>
<div class="app">

    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-logo">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
            </div>
            <span class="brand-name">SINFAS</span>
        </div>

        <nav class="sidebar-nav">
            <span class="nav-section-label">Menu</span>

            <a href="{{ route('user.dashboard') }}" class="nav-link active" id="nav-home">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                <span>Beranda</span>
            </a>

            <a href="#" class="nav-link" id="nav-riwayat">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/>
                    <line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                    <polyline points="10 9 9 9 8 9"/>
                </svg>
                <span>Riwayat Pinjam</span>
            </a>

            <span class="nav-section-label">Akun</span>

            <a href="#" class="nav-link" id="nav-profile">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
                <span>Profil Saya</span>
            </a>
        </nav>

        <div class="sidebar-footer">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-link logout" id="btn-logout">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- MAIN -->
    <div class="main">

        <!-- TOPBAR -->
        <div class="topbar">
            <form method="GET" action="{{ route('user.dashboard') }}" class="search-wrap" id="search-form">
                <div class="search-box">
                    <svg class="search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" id="search-input" name="q" class="search-input" placeholder="Cari nama barang…" value="{{ request('q') }}" autocomplete="off">
                </div>
                <select name="kategori" id="filter-kategori" class="filter-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </form>
            <div class="topbar-icons">
                <button class="icon-btn" id="btn-notif" title="Notifikasi">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                    </svg>
                </button>
                <button class="icon-btn" id="btn-user-icon" title="Profil">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- PAGE BODY -->
        <div class="page-body">

            @if(session('success'))
                <div class="alert-success" id="alert-success">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#16A34A" stroke-width="2.5">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Welcome Banner -->
            <div class="welcome-banner">
                <div class="welcome-text">
                    <h1>Halo, {{ Auth::user()->nama }}! ??</h1>
                    <p>Temukan dan pinjam peralatan yang kamu butuhkan</p>
                </div>
                <div class="welcome-icon">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,.9)" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/>
                    </svg>
                </div>
            </div>

            <!-- Section header -->
            <div class="section-header">
                <span class="section-title">
                    @if(request('q') || request('kategori'))
                        Hasil pencarian@if(request('q')) untuk "<em>{{ request('q') }}</em>"@endif
                    @else
                        Daftar Peralatan
                    @endif
                </span>
                <span class="section-count">{{ $barangs->count() }} barang</span>
            </div>

            <!-- Grid -->
            <div class="facility-grid" id="facility-grid">
                @if($barangs->isEmpty())
                    <div class="empty-state">
                        <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.4">
                            <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                        </svg>
                        <p>Tidak ada barang ditemukan</p>
                        <small>Coba kata kunci atau kategori yang berbeda</small>
                    </div>
                @else
                    @foreach($barangs as $barang)
                        @php $tersedia = $barang->jumlah_baik > 0; @endphp
                        <div class="facility-card" onclick="window.location='{{ route('user.barang.show', $barang->kode_barang) }}'">
                            <span class="status-badge {{ $tersedia ? 'available' : 'unavailable' }}">
                                {{ $tersedia ? 'Tersedia' : 'Digunakan' }}
                            </span>

                            @if($barang->foto)
                                <div class="card-image-box">
                                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}">
                                </div>
                            @else
                                @php $katNama = strtolower($barang->kategori->nama_kategori ?? ''); @endphp
                                <div class="card-icon-wrap">
                                    @if(str_contains($barang->nama_barang,'Camera') || str_contains($barang->nama_barang,'Kamera'))
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                                    @elseif(str_contains($barang->nama_barang,'Mikrofon') || str_contains($barang->nama_barang,'Mic') || str_contains($katNama,'audio'))
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="23"/><line x1="8" y1="23" x2="16" y2="23"/></svg>
                                    @elseif(str_contains($barang->nama_barang,'Proyektor') || str_contains($barang->nama_barang,'Projector'))
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="7" width="20" height="14" rx="2"/><circle cx="12" cy="14" r="3"/><path d="M12 3v4"/><path d="M8 3h8"/></svg>
                                    @elseif(str_contains($barang->nama_barang,'Laptop') || str_contains($katNama,'elektronik'))
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                                    @elseif(str_contains($barang->nama_barang,'Speaker'))
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="4" y="2" width="16" height="20" rx="2"/><circle cx="12" cy="14" r="4"/><line x1="12" y1="6" x2="12.01" y2="6"/></svg>
                                    @elseif(str_contains($barang->nama_barang,'HT') || str_contains($katNama,'komunik'))
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.29 6.29l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                                    @else
                                        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                                    @endif
                                </div>
                            @endif

                            <div class="card-bottom">
                                <span class="card-name" title="{{ $barang->nama_barang }}">{{ $barang->nama_barang }}</span>
                                @if($tersedia)
                                    <a href="{{ route('user.barang.show', $barang->kode_barang) }}" class="card-action" id="apply-{{ $barang->kode_barang }}" onclick="event.stopPropagation()">
                                        + Ajukan Pinjam
                                    </a>
                                @else
                                    <span class="card-action disabled">Sedang Digunakan</span>
                                @endif
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    const searchInput = document.getElementById('search-input');
    let debounceTimer;
    if (searchInput) {
        searchInput.addEventListener('input', () => {
            clearTimeout(debounceTimer);
            debounceTimer = setTimeout(() => { document.getElementById('search-form').submit(); }, 420);
        });
    }
    const alertEl = document.getElementById('alert-success');
    if (alertEl) {
        setTimeout(() => {
            alertEl.style.transition = 'opacity .5s ease';
            alertEl.style.opacity = '0';
            setTimeout(() => alertEl.remove(), 500);
        }, 5000);
    }
</script>
</body>
</html>
