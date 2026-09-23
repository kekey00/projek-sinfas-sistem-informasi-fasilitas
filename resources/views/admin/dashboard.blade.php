@extends('layouts.admin')

@section('title', 'Dashboard Admin Sarana - SINFAS')
@section('page_title', 'Dashboard')

@section('styles')
<style>
    /* ─── WELCOME HEADER (ALA GEN Z MODERN) ─── */
    .dash-header-wrap {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 8px;
    }
    .header-badge-row {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 6px;
    }
    .genz-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #EEF2FF;
        color: #4F46E5;
        border: 1px solid rgba(79, 70, 229, 0.2);
        border-radius: 9999px;
        padding: 3px 10px;
        font-size: 11.5px;
        font-weight: 700;
        letter-spacing: 0.3px;
    }
    .pulse-green {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: #10B981;
        box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.3);
        animation: pulseLive 2s infinite;
    }
    @keyframes pulseLive {
        0%, 100% { transform: scale(1); opacity: 1; }
        50% { transform: scale(1.25); opacity: 0.7; }
    }
    .genz-date {
        font-size: 12.5px;
        color: #64748B;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }

    .dash-title {
        font-family: 'Outfit', sans-serif;
        font-size: 26px;
        font-weight: 700;
        color: #1E293B;
        letter-spacing: -0.5px;
        margin-bottom: 4px;
        line-height: 1.2;
    }
    .dash-subtitle {
        font-size: 13.5px;
        color: #64748B;
        font-weight: 400;
    }

    /* ─── STAT CARDS (GEN Z SQUIRCLE WITH ELEVATION) ─── */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }
    @media (max-width: 1024px) { .stat-grid { grid-template-columns: repeat(2,1fr); } }
    @media (max-width: 600px)  { .stat-grid { grid-template-columns: 1fr; } }

    .stat-card {
        background: #FFFFFF;
        border: 1px solid #E8EEF6;
        border-radius: 18px;
        padding: 20px;
        display: flex;
        align-items: flex-start;
        gap: 16px;
        box-shadow: 0 2px 12px -2px rgba(30, 41, 80, 0.05), 0 1px 3px rgba(0, 0, 0, 0.03);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        position: relative;
        overflow: hidden;
    }
    .stat-card:hover {
        box-shadow: 0 12px 28px -6px rgba(79, 70, 229, 0.12), 0 4px 10px -2px rgba(0, 0, 0, 0.04);
        transform: translateY(-3px);
        border-color: rgba(79, 70, 229, 0.25);
    }

    .stat-icon {
        width: 50px;
        height: 50px;
        border-radius: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: transform 0.25s ease;
    }
    .stat-card:hover .stat-icon {
        transform: scale(1.06);
    }
    .stat-icon.blue   { background: #EEF2FF; color: #4F46E5; border: 1px solid rgba(79, 70, 229, 0.15); }
    .stat-icon.green  { background: #ECFDF5; color: #059669; border: 1px solid rgba(5, 150, 105, 0.15); }
    .stat-icon.red    { background: #FFF1F2; color: #E11D48; border: 1px solid rgba(225, 29, 72, 0.15); }
    .stat-icon.amber  { background: #FFFBEB; color: #D97706; border: 1px solid rgba(217, 119, 6, 0.15); }

    .stat-body { flex: 1; }
    .stat-top-meta {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 4px;
    }
    .stat-micro-pill {
        font-size: 11px;
        font-weight: 700;
        padding: 2px 7px;
        border-radius: 9999px;
        letter-spacing: 0.2px;
    }
    .stat-micro-pill.blue  { background: #EFF6FF; color: #2563EB; }
    .stat-micro-pill.green { background: #ECFDF5; color: #059669; }
    .stat-micro-pill.red   { background: #FFF1F2; color: #E11D48; }
    .stat-micro-pill.amber { background: #FFFBEB; color: #D97706; }

    .stat-number {
        font-family: 'Outfit', sans-serif;
        font-size: 32px;
        font-weight: 700;
        color: #1E293B;
        line-height: 1;
        letter-spacing: -0.5px;
        margin-bottom: 4px;
    }
    .stat-label {
        font-size: 13px;
        color: #64748B;
        font-weight: 500;
    }

    /* ─── SECTION CARD (TABEL RIWAYAT) ─── */
    .section-card {
        background: #FFFFFF;
        border: 1px solid #E8EEF6;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 2px 12px -2px rgba(30, 41, 80, 0.05), 0 1px 3px rgba(0, 0, 0, 0.03);
    }

    .section-card-header {
        padding: 20px 24px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 14px;
        border-bottom: 1px solid #F1F5F9;
    }

    .section-card-title {
        font-family: 'Outfit', sans-serif;
        font-size: 16.5px;
        font-weight: 700;
        color: #1E293B;
        letter-spacing: -0.2px;
        margin-bottom: 2px;
    }
    .section-card-sub {
        font-size: 12.5px;
        color: #94A3B8;
    }

    /* Tab Filter Segmented Capsule */
    .tab-bar-capsule {
        display: inline-flex;
        align-items: center;
        background: #F1F5F9;
        border-radius: 9999px;
        padding: 4px;
        border: 1px solid #E2E8F0;
        gap: 3px;
    }

    .tab-capsule-btn {
        padding: 6px 16px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 600;
        border: 1px solid transparent;
        background: transparent;
        color: #64748B;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        font-family: inherit;
        white-space: nowrap;
    }
    .tab-capsule-btn:hover {
        color: #4F46E5;
        background: rgba(255, 255, 255, 0.6);
    }
    .tab-capsule-btn.active {
        background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);
        color: #FFFFFF;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.35);
    }

    /* ─── TABLE RIWAYAT ─── */
    .riwayat-table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .riwayat-table {
        width: 100%;
        border-collapse: collapse;
    }
    .riwayat-table thead tr {
        background: #F8FAFC;
        border-bottom: 1px solid #E8EEF6;
    }
    .riwayat-table thead th {
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.7px;
        color: #64748B;
        padding: 13px 20px;
    }
    .riwayat-table tbody tr {
        border-bottom: 1px solid #F1F5F9;
        transition: background 0.15s ease;
    }
    .riwayat-table tbody tr:last-child { border-bottom: none; }
    .riwayat-table tbody tr:hover { background: #F8FAFF; }
    .riwayat-table tbody td {
        padding: 14px 20px;
        vertical-align: middle;
        font-size: 13px;
        color: #334155;
    }

    /* Modern Avatar with layered ring */
    .av-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Outfit', sans-serif;
        font-size: 13px;
        font-weight: 700;
        color: #FFFFFF;
        flex-shrink: 0;
        box-shadow: 0 0 0 2px #FFFFFF, 0 2px 6px rgba(0,0,0,0.08);
    }
    .av-blue   { background: linear-gradient(135deg, #4F46E5, #7C3AED); }
    .av-teal   { background: #0D9488; }
    .av-sky    { background: #0284C7; }
    .av-indigo { background: #4F46E5; }
    .av-rose   { background: #E11D48; }
    .av-amber  { background: #D97706; }

    .peminjam-cell { display: flex; align-items: center; gap: 12px; }
    .peminjam-name { font-weight: 600; color: #1E293B; font-size: 13.5px; }
    .peminjam-nis  { font-size: 11.5px; color: #94A3B8; margin-top: 1px; font-weight: 500; }

    .barang-name { font-weight: 600; color: #1E293B; font-size: 13px; }
    .barang-cat  { font-size: 11.5px; color: #64748B; margin-top: 1px; }

    .date-text { font-size: 13px; color: #475569; font-weight: 500; }
    .date-text.overdue { color: #E11D48; font-weight: 700; }

    /* Modern Capsule Status Pills */
    .status-pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 11.5px;
        font-weight: 600;
        white-space: nowrap;
        letter-spacing: 0.2px;
    }
    .status-pill.selesai, .status-pill.dikembalikan {
        background: #ECFDF5;
        color: #059669;
        border: 1px solid #A7F3D0;
    }
    .status-pill.aktif, .status-pill.disetujui {
        background: #EFF6FF;
        color: #2563EB;
        border: 1px solid #BFDBFE;
    }
    .status-pill.terlambat {
        background: #FFF1F2;
        color: #E11D48;
        border: 1px solid #FECDD3;
    }
    .status-pill.menunggu {
        background: #FFFBEB;
        color: #D97706;
        border: 1px solid #FDE68A;
    }
    .status-pill.ditolak {
        background: #F8FAFC;
        color: #64748B;
        border: 1px solid #E2E8F0;
    }
    .status-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        background: currentColor;
    }

    /* ─── PERMINTAAN PENDING SECTION ─── */
    .pending-card {
        background: #FFFFFF;
        border: 1px solid #E8EEF6;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: 0 2px 12px -2px rgba(30, 41, 80, 0.05), 0 1px 3px rgba(0, 0, 0, 0.03);
    }
    .pending-header {
        padding: 18px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border-bottom: 1px solid #F1F5F9;
    }
    .pending-title {
        font-family: 'Outfit', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #1E293B;
        letter-spacing: -0.2px;
    }
    .pending-count-badge {
        background: #FFFBEB;
        color: #D97706;
        font-size: 11.5px;
        font-weight: 700;
        padding: 3px 10px;
        border-radius: 9999px;
        border: 1px solid #FDE68A;
        margin-left: 8px;
    }
    .link-lihat-semua {
        font-size: 12.5px;
        font-weight: 600;
        color: #2D4E9E;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        transition: transform 0.15s ease;
    }
    .link-lihat-semua:hover { transform: translateX(3px); }

    /* Action Buttons (Capsule Gen Z) */
    .btn-approve {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        background: #ECFDF5;
        color: #059669;
        border: 1px solid #A7F3D0;
        cursor: pointer;
        transition: all 0.15s ease;
        font-family: inherit;
    }
    .btn-approve:hover { background: #059669; color: #FFFFFF; border-color: #059669; transform: translateY(-1px); }

    .btn-reject {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        background: #FFF1F2;
        color: #E11D48;
        border: 1px solid #FECDD3;
        cursor: pointer;
        transition: all 0.15s ease;
        font-family: inherit;
    }
    .btn-reject:hover { background: #E11D48; color: #FFFFFF; border-color: #E11D48; transform: translateY(-1px); }

    /* ─── CHART TREN PEMINJAMAN ─── */
    .chart-card {
        background: #FFFFFF;
        border: 1px solid #E8EEF6;
        border-radius: 18px;
        padding: 22px 24px;
        box-shadow: 0 2px 12px -2px rgba(30, 41, 80, 0.05), 0 1px 3px rgba(0, 0, 0, 0.03);
    }
    .chart-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 18px;
    }
    .chart-title {
        font-family: 'Outfit', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #1E293B;
        letter-spacing: -0.2px;
    }
    .chart-badge {
        font-size: 11.5px;
        color: #64748B;
        background: #F1F5F9;
        padding: 3px 10px;
        border-radius: 9999px;
        font-weight: 600;
    }
    .chart-canvas-wrap {
        height: 230px;
        position: relative;
    }

    /* Empty state */
    .empty-state {
        text-align: center;
        padding: 36px 20px;
        color: #94A3B8;
    }
    .empty-state svg { margin: 0 auto 10px; display: block; opacity: 0.35; }
    .empty-state p { font-size: 13px; font-weight: 500; color: #64748B; }

    /* Modal Styling */
    .btn-submit {
        padding: 8px 18px;
        border-radius: 8px;
        background: #2D4E9E;
        color: #FFFFFF;
        border: none;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        transition: background 0.15s ease;
    }
    .btn-submit:hover { background: #243f85; }

    /* ─── RESPONSIVE RULES (MOBILE) ─── */
    @media (max-width: 768px) {
        .dash-title {
            font-size: 20px;
        }
        .header-badge-row {
            flex-wrap: wrap;
            gap: 8px;
        }
        .section-card-header {
            flex-direction: column;
            align-items: stretch;
            gap: 12px;
            padding: 16px;
        }
        .tab-bar-capsule {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            padding: 3px;
        }
        .pending-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
            padding: 16px;
        }
        .chart-card {
            padding: 18px 16px;
        }
        .chart-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }
        .chart-canvas-wrap {
            height: 200px;
        }
    }
</style>
@endsection

@section('content')

    <!-- ─── WELCOME HEADER ─── -->
    <div class="dash-header-wrap">
        <div>
            <div class="header-badge-row">
                <span class="genz-pill"><span class="pulse-green"></span> Pemantauan Langsung</span>
                <span class="genz-date">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                        <line x1="16" y1="2" x2="16" y2="6"></line>
                        <line x1="8" y1="2" x2="8" y2="6"></line>
                        <line x1="3" y1="10" x2="21" y2="10"></line>
                    </svg>
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </span>
            </div>
            <h2 class="dash-title">Dashboard Admin Sarana</h2>
            <p class="dash-subtitle">Pantau ketersediaan barang dan perputaran fasilitas sekolah secara real-time.</p>
        </div>
    </div>

    <!-- ─── 4 STAT CARDS ─── -->
    <div class="stat-grid">

        <!-- Total Barang -->
        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect>
                    <line x1="8" y1="21" x2="16" y2="21"></line>
                    <line x1="12" y1="17" x2="12" y2="21"></line>
                </svg>
            </div>
            <div class="stat-body">
                <div class="stat-top-meta">
                    <span class="stat-label">Total Barang</span>
                    <span class="stat-micro-pill blue">Inventaris</span>
                </div>
                <div class="stat-number">{{ $totalAlat }}</div>
            </div>
        </div>

        <!-- Tersedia -->
        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path>
                    <polyline points="22 4 12 14.01 9 11.01"></polyline>
                </svg>
            </div>
            <div class="stat-body">
                <div class="stat-top-meta">
                    <span class="stat-label">Tersedia</span>
                    <span class="stat-micro-pill green">Siap Pakai</span>
                </div>
                <div class="stat-number">{{ $tersediaCount ?? ($totalAlat - $sedangDipinjamCount) }}</div>
            </div>
        </div>

        <!-- Sedang Dipinjam -->
        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
            <div class="stat-body">
                <div class="stat-top-meta">
                    <span class="stat-label">Sedang Dipinjam</span>
                    <span class="stat-micro-pill red">Aktif</span>
                </div>
                <div class="stat-number">{{ $sedangDipinjamCount }}</div>
            </div>
        </div>

        <!-- Menunggu Verifikasi -->
        <div class="stat-card">
            <div class="stat-icon amber">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
            </div>
            <div class="stat-body">
                <div class="stat-top-meta">
                    <span class="stat-label">Menunggu</span>
                    <span class="stat-micro-pill amber">Antrean</span>
                </div>
                <div class="stat-number">{{ $menungguCount }}</div>
            </div>
        </div>

    </div>

    <!-- ─── TABEL RIWAYAT PEMINJAMAN (DENGAN CAPSULE SEGMENTED FILTER) ─── -->
    <div class="section-card">
        <div class="section-card-header">
            <div>
                <div class="section-card-title">Riwayat Peminjaman</div>
                <div class="section-card-sub">Daftar seluruh transaksi peminjaman barang oleh siswa.</div>
            </div>
            <!-- Tab Filter Segmented Capsule -->
            <div class="tab-bar-capsule" id="tabBar">
                <button class="tab-capsule-btn active" onclick="filterTab(this,'semua')">Semua</button>
                <button class="tab-capsule-btn" onclick="filterTab(this,'aktif')">Aktif</button>
                <button class="tab-capsule-btn" onclick="filterTab(this,'selesai')">Selesai</button>
                <button class="tab-capsule-btn" onclick="filterTab(this,'terlambat')">Terlambat</button>
            </div>
        </div>

        <div class="riwayat-table-responsive">
            <table class="riwayat-table" id="riwayatTable">
                <thead>
                    <tr>
                        <th>PEMINJAM</th>
                        <th>BARANG</th>
                        <th>TGL PINJAM</th>
                        <th>TGL KEMBALI</th>
                        <th>STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $avColors = ['av-blue','av-teal','av-sky','av-indigo','av-rose','av-amber'];
                        $avIdx = 0;
                    @endphp
                    @forelse($riwayatPeminjaman as $rw)
                    @php
                        $st = $rw->status_pengajuan ?? 'menunggu';
                        // Determine if overdue
                        $isOverdue = ($st === 'disetujui' && $rw->tanggal_kembali && $rw->tanggal_kembali->isPast());
                        $displayStatus = $isOverdue ? 'terlambat' : $st;
                        $statusLabel = match($displayStatus) {
                            'disetujui'    => 'Aktif',
                            'dikembalikan' => 'Selesai',
                            'selesai'      => 'Selesai',
                            'terlambat'    => 'Terlambat',
                            'menunggu'     => 'Menunggu',
                            'ditolak'      => 'Ditolak',
                            default        => ucfirst($displayStatus)
                        };

                        // Class for filtering
                        $filterCat = match($displayStatus) {
                            'disetujui'               => 'aktif',
                            'dikembalikan', 'selesai' => 'selesai',
                            'terlambat'               => 'terlambat',
                            default                   => 'lainnya'
                        };

                        $pillClass = match($displayStatus) {
                            'disetujui'               => 'aktif',
                            'dikembalikan', 'selesai' => 'selesai',
                            'terlambat'               => 'terlambat',
                            'menunggu'                => 'menunggu',
                            'ditolak'                 => 'ditolak',
                            default                   => 'menunggu'
                        };

                        $avClass = $avColors[$avIdx % count($avColors)];
                        $avIdx++;
                    @endphp
                    <tr data-status="{{ $filterCat }}">
                        <td>
                            <div class="peminjam-cell">
                                <div class="av-circle {{ $avClass }}">
                                    {{ strtoupper(substr($rw->siswa->nama ?? 'S', 0, 2)) }}
                                </div>
                                <div>
                                    <div class="peminjam-name">{{ $rw->siswa->nama ?? 'Siswa' }}</div>
                                    <div class="peminjam-nis">NIS {{ $rw->nis }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="barang-name">{{ $rw->barang->nama_barang ?? $rw->kode_barang }}</div>
                            <div class="barang-cat">{{ $rw->barang->kategori->nama_kategori ?? '-' }}</div>
                        </td>
                        <td>
                            <span class="date-text">{{ $rw->tanggal_pinjam ? $rw->tanggal_pinjam->format('d M Y') : '-' }}</span>
                        </td>
                        <td>
                            <span class="date-text {{ $isOverdue ? 'overdue' : '' }}">
                                {{ $rw->tanggal_kembali ? $rw->tanggal_kembali->format('d M Y') : '-' }}
                            </span>
                        </td>
                        <td>
                            <span class="status-pill {{ $pillClass }}">
                                <span class="status-dot"></span>
                                {{ $statusLabel }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                                <p>Belum ada riwayat peminjaman.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ─── PERMINTAAN MENUNGGU ─── -->
    <div class="pending-card">
        <div class="pending-header">
            <div style="display:flex;align-items:center;">
                <span class="pending-title">Permintaan Peminjaman Menunggu</span>
                @if($pendingRequests->count() > 0)
                    <span class="pending-count-badge">{{ $pendingRequests->count() }} Antrean</span>
                @endif
            </div>
            <a href="{{ route('admin.verifikasi.index') }}" class="link-lihat-semua">
                Lihat Semua
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
            </a>
        </div>

        <div class="riwayat-table-responsive">
            <table class="riwayat-table">
                <thead>
                    <tr>
                        <th>PEMINJAM</th>
                        <th>NAMA ALAT / SARANA</th>
                        <th>TGL. PINJAM</th>
                        <th>TGL. KEMBALI</th>
                        <th style="text-align:right;padding-right:24px;">AKSI CEPAT</th>
                    </tr>
                </thead>
                <tbody>
                    @php $avIdx2 = 0; @endphp
                    @forelse($pendingRequests as $req)
                    @php
                        $avClass2 = $avColors[$avIdx2 % count($avColors)];
                        $avIdx2++;
                    @endphp
                    <tr>
                        <td>
                            <div class="peminjam-cell">
                                <div class="av-circle {{ $avClass2 }}">
                                    {{ strtoupper(substr($req->siswa->nama ?? 'S', 0, 2)) }}
                                </div>
                                <div>
                                    <div class="peminjam-name">{{ $req->siswa->nama ?? 'Siswa' }}</div>
                                    <div class="peminjam-nis">NIS {{ $req->nis }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div class="barang-name">{{ $req->barang->nama_barang ?? $req->kode_barang }}</div>
                            <div class="barang-cat">{{ $req->barang->kategori->nama_kategori ?? '-' }}</div>
                        </td>
                        <td>
                            <span class="date-text">{{ $req->tanggal_pinjam ? $req->tanggal_pinjam->format('d M Y') : '-' }}</span>
                        </td>
                        <td>
                            <span class="date-text">{{ $req->tanggal_kembali ? $req->tanggal_kembali->format('d M Y') : '-' }}</span>
                        </td>
                        <td>
                            <div style="display:flex;gap:8px;justify-content:flex-end;padding-right:8px;">
                                <button type="button" class="btn-approve" onclick="openApproveModal('{{ $req->kode_pinjam }}','{{ addslashes($req->barang->nama_barang ?? $req->kode_barang) }}','{{ addslashes($req->siswa->nama ?? 'Siswa') }}')">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                    Setujui
                                </button>
                                <button type="button" class="btn-reject" onclick="openRejectModal('{{ $req->kode_pinjam }}','{{ addslashes($req->barang->nama_barang ?? '') }}','{{ addslashes($req->siswa->nama ?? 'Siswa') }}')">
                                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    Tolak
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="empty-state">
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                <p>Tidak ada permohonan yang menunggu saat ini.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- ─── CHART TREN PEMINJAMAN ─── -->
    <div class="chart-card">
        <div class="chart-header">
            <div>
                <div class="chart-title">Statistik Tren Peminjaman Alat</div>
                <div style="font-size:12.5px;color:#94A3B8;margin-top:2px;">Analisis volume peminjaman barang per bulan</div>
            </div>
            <span class="chart-badge">Semester 1 (Jan - Jun)</span>
        </div>
        <div class="chart-canvas-wrap">
            <canvas id="sinfasBarChart"></canvas>
        </div>
    </div>

    <!-- Modal Konfirmasi Persetujuan -->
    <div id="approveModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">Konfirmasi Persetujuan</div>
                <button class="modal-close-btn" onclick="closeModal('approveModal')">&times;</button>
            </div>
            <form id="approveForm" method="POST">
                @csrf
                <div style="margin-bottom:14px;">
                    <p style="font-size:13.5px;color:#475569;margin-bottom:12px;">Setujui permohonan peminjaman alat berikut?</p>
                    <div style="background:#F8FAFC;border:1px solid #E2E8F0;border-radius:10px;padding:12px 14px;font-size:13px;color:#334155;line-height:1.8;">
                        <div>Peminjam: <strong id="approveStudentName" style="color:#1E293B;"></strong></div>
                        <div>Barang: <strong id="approveItemName" style="color:#1E293B;"></strong></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal('approveModal')">Batal</button>
                    <button type="submit" class="btn-submit">Ya, Setujui</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Penolakan -->
    <div id="rejectModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">Tolak Pengajuan</div>
                <button class="modal-close-btn" onclick="closeModal('rejectModal')">&times;</button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div style="margin-bottom:14px;">
                    <p style="font-size:13.5px;color:#475569;margin-bottom:10px;">
                        Tolak pengajuan peminjaman <strong id="rejectItemName"></strong> oleh <strong id="rejectStudentName"></strong>?
                    </p>
                    <label style="display:block;font-size:12.5px;font-weight:600;color:#334155;margin-bottom:5px;">Alasan Penolakan</label>
                    <textarea name="alasan" rows="3" placeholder="Contoh: Barang sedang dalam perawatan..." style="width:100%;box-sizing:border-box;border:1px solid #CBD5E1;border-radius:8px;padding:8px 12px;font-family:inherit;font-size:13px;outline:none;resize:vertical;transition:border-color 0.15s;" onfocus="this.style.borderColor='#2D4E9E'" onblur="this.style.borderColor='#CBD5E1'"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal('rejectModal')">Batal</button>
                    <button type="submit" class="btn-submit" style="background:#E11D48;">Konfirmasi Tolak</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    // ─── TAB FILTER CAPSULE ───
    function filterTab(btn, status) {
        document.querySelectorAll('#tabBar .tab-capsule-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        const rows = document.querySelectorAll('#riwayatTable tbody tr[data-status]');
        rows.forEach(row => {
            if (status === 'semua') {
                row.style.display = '';
            } else {
                row.style.display = (row.dataset.status === status) ? '' : 'none';
            }
        });
    }

    // ─── MODAL ACTIONS ───
    function openApproveModal(kodePinjam, itemName, studentName) {
        document.getElementById('approveItemName').innerText = itemName;
        document.getElementById('approveStudentName').innerText = studentName;
        document.getElementById('approveForm').action = "{{ url('/admin/verifikasi/approve') }}/" + kodePinjam;
        openModal('approveModal');
    }

    function openRejectModal(kodePinjam, itemName, studentName) {
        document.getElementById('rejectItemName').innerText = itemName;
        document.getElementById('rejectStudentName').innerText = studentName;
        document.getElementById('rejectForm').action = "{{ url('/admin/verifikasi/reject') }}/" + kodePinjam;
        openModal('rejectModal');
    }

    // ─── CHART ───
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('sinfasBarChart').getContext('2d');
        const labels = @json($chartLabels);
        const datasets = @json($chartDatasets);

        const colors = ['#2D4E9E', '#0D9488', '#7C3AED', '#D97706', '#059669', '#475569'];
        if (datasets && datasets.length) {
            datasets.forEach((ds, idx) => {
                ds.backgroundColor = colors[idx % colors.length];
                ds.borderRadius = 8;
                ds.borderSkipped = false;
                ds.maxBarThickness = 36;
            });
        }

        new Chart(ctx, {
            type: 'bar',
            data: { labels, datasets },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1E293B',
                        titleFont: { size: 12, family: 'Outfit', weight: '700' },
                        bodyFont: { size: 12, family: 'Plus Jakarta Sans' },
                        padding: 10,
                        cornerRadius: 10,
                        displayColors: true
                    }
                },
                scales: {
                    x: {
                        ticks: { font: { size: 12, family: 'Plus Jakarta Sans', weight: '500' }, color: '#64748B' },
                        grid: { display: false },
                        border: { display: false }
                    },
                    y: {
                        beginAtZero: true,
                        ticks: { stepSize: 1, font: { size: 11, family: 'Plus Jakarta Sans' }, color: '#94A3B8' },
                        grid: { color: '#F1F5F9', borderDash: [4,4], drawTicks: false },
                        border: { display: false }
                    }
                }
            }
        });
    });
</script>
@endsection
