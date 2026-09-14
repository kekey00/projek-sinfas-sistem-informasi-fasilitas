@extends('layouts.sistem')

@section('title', 'Pengaturan Sistem')
@section('page_title', 'Pengaturan Sistem')

@section('styles')
<style>
    .settings-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
    }
    @media (max-width: 900px) { .settings-grid { grid-template-columns: 1fr; } }

    .settings-card {
        background: #FFFFFF;
        border-radius: 14px;
        border: 1px solid #E8EEF6;
        box-shadow: 0 1px 4px rgba(30, 41, 80, 0.05);
        overflow: hidden;
    }

    .settings-card-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 18px 24px;
        border-bottom: 1px solid #F1F5F9;
        background: #FFFFFF;
    }

    .settings-card-icon {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .icon-blue  { background: #EFF6FF; color: #2563EB; }
    .icon-green { background: #ECFDF5; color: #059669; }
    .icon-amber { background: #FFFBEB; color: #D97706; }

    .settings-card-title {
        font-family: 'Outfit', sans-serif;
        font-size: 15.5px;
        font-weight: 700;
        color: #1E293B;
        letter-spacing: -0.2px;
    }

    .settings-card-sub {
        font-size: 12px;
        color: #64748B;
        margin-top: 1px;
    }

    .settings-card-body {
        padding: 20px 24px;
    }

    /* Info Rows */
    .info-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 11px 0;
        border-bottom: 1px solid #F1F5F9;
    }

    .info-row:last-child { border-bottom: none; }

    .info-label {
        font-size: 13px;
        color: #64748B;
        font-weight: 500;
    }

    .info-value {
        font-size: 13px;
        font-weight: 600;
        color: #1E293B;
        text-align: right;
    }

    /* Status indicator */
    .status-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 6px;
    }

    .dot-green { background: #10B981; box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.25); }
    .dot-red   { background: #EF4444; box-shadow: 0 0 0 2px rgba(239, 68, 68, 0.25); }

    /* Action Buttons */
    .action-btn-row {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        padding-top: 6px;
    }

    .btn-sys-action {
        flex: 1;
        padding: 10px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        font-family: inherit;
        border: none;
        transition: all 0.15s ease;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        text-decoration: none;
        min-width: 140px;
    }

    .btn-backup {
        background: #2D4E9E;
        color: #FFFFFF;
    }
    .btn-backup:hover {
        background: #243f85;
        transform: translateY(-1px);
    }

    .btn-cache {
        background: #F1F5F9;
        color: #334155;
        border: 1px solid #CBD5E1;
    }
    .btn-cache:hover {
        background: #E2E8F0;
        color: #0F172A;
    }

    /* Full-width card */
    .settings-card-full {
        grid-column: 1 / -1;
    }

    /* Form Settings */
    .settings-form-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 16px;
    }
    @media (max-width: 800px) { .settings-form-grid { grid-template-columns: 1fr; } }

    /* Version Info */
    .version-badge {
        display: inline-flex;
        align-items: center;
        padding: 2px 10px;
        border-radius: 6px;
        font-size: 11.5px;
        font-weight: 600;
        background: #EFF6FF;
        color: #2563EB;
    }
</style>
@endsection

@section('content')

<div class="settings-grid">

    {{-- ── Informasi Sistem ── --}}
    <div class="settings-card">
        <div class="settings-card-header">
            <div class="settings-card-icon icon-blue">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/>
                </svg>
            </div>
            <div>
                <div class="settings-card-title">Informasi Sistem</div>
                <div class="settings-card-sub">Detail versi aplikasi dan spesifikasi server</div>
            </div>
        </div>
        <div class="settings-card-body">
            <div class="info-row">
                <span class="info-label">Nama Sistem</span>
                <span class="info-value">{{ $settings['nama_instansi'] }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Versi Aplikasi</span>
                <span class="info-value"><span class="version-badge">v{{ $settings['versi_sistem'] }}</span></span>
            </div>
            <div class="info-row">
                <span class="info-label">Zona Waktu</span>
                <span class="info-value">{{ $settings['timezone'] }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status Server</span>
                <span class="info-value">
                    <span class="status-dot dot-green"></span>Online (Aktif)
                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Versi PHP</span>
                <span class="info-value">{{ PHP_VERSION }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Versi Laravel</span>
                <span class="info-value">{{ app()->version() }}</span>
            </div>
        </div>
    </div>

    {{-- ── Backup & Pemeliharaan ── --}}
    <div class="settings-card">
        <div class="settings-card-header">
            <div class="settings-card-icon icon-amber">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="20 7 12 3 4 7"/><polyline points="4 7 4 17 12 21 20 17 20 7"/><polyline points="12 3 12 21"/><line x1="4" y1="12" x2="12" y2="12"/><line x1="12" y1="12" x2="20" y2="12"/>
                </svg>
            </div>
            <div>
                <div class="settings-card-title">Backup & Pemeliharaan</div>
                <div class="settings-card-sub">Kelola pencadangan data dan cache sistem</div>
            </div>
        </div>
        <div class="settings-card-body">
            <div class="info-row">
                <span class="info-label">Backup Terakhir</span>
                <span class="info-value" style="color: #059669;">{{ $settings['backup_terakhir'] }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Jadwal Backup Otomatis</span>
                <span class="info-value">{{ $settings['backup_jadwal'] }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Status Backup Otomatis</span>
                <span class="info-value">
                    <span class="status-dot {{ $settings['backup_otomatis'] ? 'dot-green' : 'dot-red' }}"></span>
                    {{ $settings['backup_otomatis'] ? 'Aktif' : 'Nonaktif' }}
                </span>
            </div>
            <div style="margin-top: 18px;">
                <div class="action-btn-row">
                    <form action="{{ route('sistem.settings.backup') }}" method="POST" style="flex: 1;">
                        @csrf
                        <button type="submit" class="btn-sys-action btn-backup" style="width: 100%;"
                                onclick="return confirm('Jalankan backup database sekarang?')">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                            Backup Sekarang
                        </button>
                    </form>
                    <form action="{{ route('sistem.settings.clear-cache') }}" method="POST" style="flex: 1;">
                        @csrf
                        <button type="submit" class="btn-sys-action btn-cache" style="width: 100%;">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><polyline points="1 4 1 10 7 10"/><path d="M3.51 15a9 9 0 1 0 .49-3.21"/></svg>
                            Bersihkan Cache
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- ── Konfigurasi Operasional ── --}}
    <div class="settings-card settings-card-full">
        <div class="settings-card-header">
            <div class="settings-card-icon icon-green">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="3"/>
                    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                </svg>
            </div>
            <div>
                <div class="settings-card-title">Konfigurasi Operasional</div>
                <div class="settings-card-sub">Atur parameter jam operasional sekolah, peminjaman, dan notifikasi</div>
            </div>
        </div>
        <div class="settings-card-body">
            <form action="{{ route('sistem.settings.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="settings-form-grid">
                    <div class="form-group">
                        <label class="form-label">Nama Instansi</label>
                        <input type="text" name="nama_instansi" class="form-control" value="{{ $settings['nama_instansi'] }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Email Notifikasi</label>
                        <input type="email" name="email_notifikasi" class="form-control" value="{{ $settings['email_notifikasi'] }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Maks. Ukuran Foto (MB)</label>
                        <input type="number" name="max_file_size" class="form-control" value="{{ $settings['max_file_size'] }}" min="1" max="10" required>
                    </div>
                </div>

                <div class="settings-form-grid" style="margin-top: 8px;">
                    <div class="form-group">
                        <label class="form-label">Jam Buka Operasional</label>
                        <input type="time" name="jam_operasional_buka" class="form-control" value="{{ $settings['jam_operasional_buka'] }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Jam Tutup Operasional</label>
                        <input type="time" name="jam_operasional_tutup" class="form-control" value="{{ $settings['jam_operasional_tutup'] }}" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Maks. Hari Peminjaman</label>
                        <input type="number" name="maks_hari_pinjam" class="form-control" value="{{ $settings['maks_hari_pinjam'] }}" min="1" max="30" required>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; margin-top: 18px;">
                    <button type="submit" class="btn-sys-action btn-backup" style="min-width: 180px; flex: 0;">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v13a2 2 0 0 1-2 2z"/><polyline points="17 21 17 13 7 13 7 21"/><polyline points="7 3 7 8 15 8"/></svg>
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>

@endsection
