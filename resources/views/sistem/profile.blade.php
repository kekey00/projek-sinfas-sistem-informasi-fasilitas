@extends('layouts.sistem')

@section('title', 'Pengaturan Akun - SINFAS')
@section('page_title', 'Pengaturan Akun')

@section('styles')
<style>
    /* ─── BREADCRUMB & HEADER ─── */
    .profile-top-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: #64748B;
        margin-bottom: 12px;
    }
    .profile-top-breadcrumb a {
        color: #1E3BB3;
        text-decoration: none;
        font-weight: 600;
    }
    .profile-top-breadcrumb a:hover {
        text-decoration: underline;
    }

    .profile-heading-title {
        font-family: 'Outfit', sans-serif;
        font-size: 26px;
        font-weight: 800;
        color: #1E293B;
        letter-spacing: -0.4px;
        margin-bottom: 24px;
    }

    /* ─── 2-COLUMN SETTINGS LAYOUT (PERSIS MOCKUP) ─── */
    .settings-split-grid {
        display: grid;
        grid-template-columns: 260px 1fr;
        gap: 28px;
        align-items: flex-start;
    }
    @media (max-width: 960px) {
        .settings-split-grid {
            grid-template-columns: 1fr;
        }
    }

    /* ─── LEFT TAB NAVIGATION (MENU SETTINGS) ─── */
    .settings-nav-card {
        background: #FFFFFF;
        border: 1px solid #E8EEF6;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(30, 41, 80, 0.04);
        padding: 10px 0;
        overflow: hidden;
    }

    .settings-tab-btn {
        width: 100%;
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 22px;
        font-size: 14px;
        font-weight: 600;
        color: #64748B;
        background: transparent;
        border: none;
        text-align: left;
        cursor: pointer;
        transition: all 0.15s ease;
        position: relative;
        font-family: inherit;
    }

    .settings-tab-btn svg {
        color: #94A3B8;
        transition: color 0.15s ease;
        flex-shrink: 0;
    }

    .settings-tab-btn:hover {
        background: #F8FAFC;
        color: #1E293B;
    }

    .settings-tab-btn:hover svg {
        color: #1E3BB3;
    }

    /* Active Tab State with Blue Right Indicator Bar */
    .settings-tab-btn.active {
        color: #1E3BB3;
        background: #F0F4FF;
        font-weight: 700;
    }

    .settings-tab-btn.active svg {
        color: #1E3BB3;
    }

    .settings-tab-btn.active::after {
        content: '';
        position: absolute;
        right: 0;
        top: 0;
        bottom: 0;
        width: 3.5px;
        background: #1E3BB3;
        border-radius: 4px 0 0 4px;
    }

    /* ─── RIGHT CARD (MAIN CONTENT FORM) ─── */
    .settings-main-card {
        background: #FFFFFF;
        border: 1px solid #E8EEF6;
        border-radius: 18px;
        box-shadow: 0 4px 20px -2px rgba(30, 41, 80, 0.05);
        padding: 36px 40px;
    }

    @media (max-width: 640px) {
        .settings-main-card {
            padding: 24px 20px;
        }
    }

    /* Avatar & Photo Action Row */
    .avatar-action-row {
        display: flex;
        align-items: center;
        gap: 28px;
        margin-bottom: 34px;
        flex-wrap: wrap;
    }

    .avatar-circle-wrapper {
        position: relative;
        width: 104px;
        height: 104px;
        flex-shrink: 0;
    }

    .avatar-img-view {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
        background: #EFF6FF;
        border: 3px solid #FFFFFF;
        box-shadow: 0 0 0 1.5px #E2E8F0, 0 8px 18px rgba(30, 59, 179, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Outfit', sans-serif;
        font-size: 34px;
        font-weight: 800;
        color: #1E3BB3;
        overflow: hidden;
    }

    .camera-badge-circle {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #1E3BB3;
        border: 2.5px solid #FFFFFF;
        color: #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 3px 8px rgba(30, 59, 179, 0.35);
        transition: transform 0.15s ease;
    }

    .camera-badge-circle:hover {
        transform: scale(1.1);
    }

    .avatar-btn-group {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
    }

    .btn-upload-avatar {
        background: #1E3BB3;
        color: #FFFFFF;
        border: none;
        border-radius: 9px;
        padding: 10px 22px;
        font-size: 13.5px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
        box-shadow: 0 3px 10px rgba(30, 59, 179, 0.22);
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .btn-upload-avatar:hover {
        background: #172F93;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(30, 59, 179, 0.32);
    }

    .btn-delete-avatar {
        background: #F8FAFC;
        color: #475569;
        border: 1px solid #CBD5E1;
        border-radius: 9px;
        padding: 10px 18px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-delete-avatar:hover {
        background: #F1F5F9;
        color: #1E293B;
        border-color: #94A3B8;
    }

    /* ─── FORM GRID (2-COLUMN PERSIS MOCKUP) ─── */
    .form-grid-pair {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 20px;
    }

    @media (max-width: 768px) {
        .form-grid-pair {
            grid-template-columns: 1fr;
        }
    }

    .form-group-custom {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .form-label-custom {
        font-size: 13px;
        font-weight: 700;
        color: #334155;
    }

    .form-input-custom {
        width: 100%;
        box-sizing: border-box;
        padding: 11px 15px;
        border: 1px solid #D0D5DD;
        border-radius: 9px;
        font-size: 13.5px;
        color: #1E293B;
        outline: none;
        background: #FFFFFF;
        font-family: inherit;
        transition: all 0.15s ease;
    }

    .form-input-custom:focus {
        border-color: #1E3BB3;
        box-shadow: 0 0 0 3px rgba(30, 59, 179, 0.12);
    }

    .form-input-custom[readonly] {
        background: #F8FAFC;
        color: #64748B;
        border-color: #E2E8F0;
        cursor: not-allowed;
    }

    /* Phone Input with Flag Prefix Group */
    .input-phone-group {
        display: flex;
        align-items: center;
        border: 1px solid #D0D5DD;
        border-radius: 9px;
        background: #FFFFFF;
        overflow: hidden;
        transition: all 0.15s ease;
    }

    .input-phone-group:focus-within {
        border-color: #1E3BB3;
        box-shadow: 0 0 0 3px rgba(30, 59, 179, 0.12);
    }

    .phone-flag-prefix {
        display: flex;
        align-items: center;
        gap: 6px;
        padding: 0 12px;
        background: #F8FAFC;
        border-right: 1px solid #E2E8F0;
        height: 42px;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        user-select: none;
    }

    .phone-input-field {
        flex: 1;
        border: none;
        outline: none;
        padding: 11px 14px;
        font-size: 13.5px;
        color: #1E293B;
        font-family: inherit;
        background: transparent;
    }

    /* Gender Pill Card Radio (Persis Mockup) */
    .gender-pill-container {
        display: flex;
        gap: 12px;
    }

    .gender-radio-card {
        flex: 1;
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px 16px;
        border: 1px solid #D0D5DD;
        border-radius: 9px;
        cursor: pointer;
        transition: all 0.15s ease;
        user-select: none;
        background: #FFFFFF;
        font-size: 13.5px;
        font-weight: 600;
        color: #334155;
    }

    .gender-radio-card:hover {
        border-color: #1E3BB3;
        background: #F8FAFC;
    }

    .gender-radio-card input[type="radio"] {
        accent-color: #1E3BB3;
        width: 16px;
        height: 16px;
        cursor: pointer;
    }

    .gender-radio-card.active {
        border-color: #1E3BB3;
        background: #F0F4FF;
        color: #1E3BB3;
    }

    /* Save Changes Button (Vibrant Royal Blue) */
    .btn-save-changes {
        background: #1E3BB3;
        color: #FFFFFF;
        border: none;
        border-radius: 9px;
        padding: 12px 32px;
        font-size: 14px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s ease;
        box-shadow: 0 4px 14px rgba(30, 59, 179, 0.25);
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-top: 10px;
    }

    .btn-save-changes:hover {
        background: #172F93;
        transform: translateY(-1px);
        box-shadow: 0 8px 20px rgba(30, 59, 179, 0.35);
    }

    /* ─── TAB CONTENT PANELS ─── */
    .tab-content-panel {
        display: none;
    }
    .tab-content-panel.active {
        display: block;
        animation: fadeInTab 0.2s ease-in-out;
    }

    @keyframes fadeInTab {
        from { opacity: 0; transform: translateY(6px); }
        to   { opacity: 1; transform: translateY(0); }
    }

    /* Notification switches */
    .notif-toggle-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 0;
        border-bottom: 1px solid #F1F5F9;
    }
    .notif-toggle-row:last-child {
        border-bottom: none;
    }
    .notif-info-wrap {
        display: flex;
        flex-direction: column;
        gap: 3px;
    }
    .notif-title-txt {
        font-size: 14px;
        font-weight: 700;
        color: #1E293B;
    }
    .notif-desc-txt {
        font-size: 12.5px;
        color: #64748B;
    }

    /* Switch toggle */
    .switch-ui {
        position: relative;
        display: inline-block;
        width: 44px;
        height: 24px;
    }
    .switch-ui input { opacity: 0; width: 0; height: 0; }
    .slider-round {
        position: absolute;
        cursor: pointer;
        inset: 0;
        background-color: #CBD5E1;
        transition: .25s;
        border-radius: 34px;
    }
    .slider-round:before {
        position: absolute;
        content: "";
        height: 18px;
        width: 18px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .25s;
        border-radius: 50%;
    }
    input:checked + .slider-round { background-color: #1E3BB3; }
    input:checked + .slider-round:before { transform: translateX(20px); }

    /* Verification Badge Boxes */
    .verif-box-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: 12px;
        margin-bottom: 14px;
    }
    .verif-badge-success {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #ECFDF5;
        color: #047857;
        font-size: 12px;
        font-weight: 700;
        padding: 4px 12px;
        border-radius: 99px;
        border: 1px solid #A7F3D0;
    }
</style>
@endsection

@section('content')

    <!-- BREADCRUMB -->
    <div class="profile-top-breadcrumb">
        <a href="{{ route('sistem.dashboard') }}">Beranda</a>
        <span>/</span>
        <span>Pengaturan Akun</span>
    </div>

    <!-- TITLE -->
    <h1 class="profile-heading-title">Pengaturan Akun</h1>

    <!-- MAIN SETTINGS 2-COLUMN LAYOUT -->
    <div class="settings-split-grid">

        <!-- ─── LEFT COLUMN: VERTICAL TABS ─── -->
        <div class="settings-nav-card">
            <button type="button" class="settings-tab-btn active" onclick="switchSettingsTab('profile', this)" id="tab-btn-profile">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                    <circle cx="12" cy="7" r="4"></circle>
                </svg>
                <span>Pengaturan Profil</span>
            </button>

            <button type="button" class="settings-tab-btn" onclick="switchSettingsTab('password', this)" id="tab-btn-password">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                </svg>
                <span>Kata Sandi</span>
            </button>

            <button type="button" class="settings-tab-btn" onclick="switchSettingsTab('notifications', this)" id="tab-btn-notifications">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                    <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                </svg>
                <span>Notifikasi</span>
            </button>

            <button type="button" class="settings-tab-btn" onclick="switchSettingsTab('verification', this)" id="tab-btn-verification">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
                <span>Verifikasi Akun</span>
            </button>
        </div>

        <!-- ─── RIGHT COLUMN: CONTENT CARD ─── -->
        <div class="settings-main-card">

            <!-- 1. TAB PANEL: PENGATURAN PROFIL -->
            <div id="panel-profile" class="tab-content-panel active">
                
                <!-- TOP AVATAR SECTION -->
                <div class="avatar-action-row">
                    <div class="avatar-circle-wrapper">
                        <div class="avatar-img-view" id="avatarDisplayBox">
                            {{ strtoupper(substr($user->nama ?? 'S', 0, 2)) }}
                        </div>
                        <div class="camera-badge-circle" onclick="document.getElementById('avatarFileInput').click()" title="Ganti Foto">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path>
                                <circle cx="12" cy="13" r="4"></circle>
                            </svg>
                        </div>
                    </div>

                    <div class="avatar-btn-group">
                        <input type="file" id="avatarFileInput" accept="image/*" style="display:none;" onchange="previewAvatar(this)">
                        <button type="button" class="btn-upload-avatar" onclick="document.getElementById('avatarFileInput').click()">
                            <span>Unggah Foto Baru</span>
                        </button>
                        <button type="button" class="btn-delete-avatar" onclick="resetAvatar()">
                            <span>Hapus Foto</span>
                        </button>
                    </div>
                </div>

                <!-- FORM EDIT PROFIL -->
                <form action="{{ route('sistem.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Baris 1: Nama Lengkap & Username -->
                    <div class="form-grid-pair">
                        <div class="form-group-custom">
                            <label class="form-label-custom">Nama Lengkap <span style="color:#EF4444;">*</span></label>
                            <input type="text" name="nama" class="form-input-custom" value="{{ old('nama', $user->nama) }}" required placeholder="Nama lengkap Anda">
                        </div>

                        <div class="form-group-custom">
                            <label class="form-label-custom">Username <span style="color:#EF4444;">*</span></label>
                            <input type="text" name="username" class="form-input-custom" value="{{ old('username', $user->username) }}" required placeholder="Username akun">
                        </div>
                    </div>

                    <!-- Baris 2: Email & Nomor HP / WhatsApp -->
                    <div class="form-grid-pair">
                        <div class="form-group-custom">
                            <label class="form-label-custom">Email</label>
                            <input type="email" name="email" class="form-input-custom" value="{{ old('email', $user->email ?? 'sistem@sinfas.sch.id') }}" placeholder="contoh@gmail.com">
                        </div>

                        <div class="form-group-custom">
                            <label class="form-label-custom">Nomor Telepon / WhatsApp <span style="color:#EF4444;">*</span></label>
                            <div class="input-phone-group">
                                <div class="phone-flag-prefix">
                                    <span style="font-size:16px;">🇮🇩</span>
                                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="6 9 12 15 18 9"></polyline></svg>
                                </div>
                                <input type="text" name="nomor_kontak" class="phone-input-field" value="{{ old('nomor_kontak', $user->nomor_kontak ?? '081234567890') }}" placeholder="081234567890" required>
                            </div>
                        </div>
                    </div>

                    <!-- Baris 3: Jenis Kelamin & ID Pegawai -->
                    <div class="form-grid-pair">
                        <div class="form-group-custom">
                            <label class="form-label-custom">Jenis Kelamin</label>
                            <div class="gender-pill-container">
                                <label class="gender-radio-card active" onclick="selectGender(this)">
                                    <input type="radio" name="jenis_kelamin" value="Laki-laki" checked>
                                    <span>Laki-laki</span>
                                </label>
                                <label class="gender-radio-card" onclick="selectGender(this)">
                                    <input type="radio" name="jenis_kelamin" value="Perempuan">
                                    <span>Perempuan</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group-custom">
                            <label class="form-label-custom">ID / NIP Pegawai</label>
                            <input type="text" class="form-input-custom" value="{{ $user->nip ?? 'NIP-198801012010011001' }}" readonly>
                        </div>
                    </div>

                    <!-- Baris 4: Jabatan & Instansi -->
                    <div class="form-grid-pair">
                        <div class="form-group-custom">
                            <label class="form-label-custom">Jabatan / Role</label>
                            <input type="text" class="form-input-custom" value="Admin Sistem / Operator" readonly>
                        </div>

                        <div class="form-group-custom">
                            <label class="form-label-custom">Instansi / Unit Kerja</label>
                            <input type="text" class="form-input-custom" value="SMK SINFAS - Teknologi Informasi" readonly>
                        </div>
                    </div>

                    <!-- Baris 5: Alamat Ruangan / Kantor (Full Width) -->
                    <div class="form-group-custom" style="margin-bottom: 26px;">
                        <label class="form-label-custom">Alamat Kantor / Penempatan Ruang</label>
                        <input type="text" name="alamat_kantor" class="form-input-custom" value="Ruang Server & IT, Gedung Utama, Lantai 2" placeholder="Alamat ruangan atau kantor...">
                    </div>

                    <!-- TOMBOL SIMPAN PERUBAHAN -->
                    <button type="submit" class="btn-save-changes">
                        <span>Simpan Perubahan</span>
                    </button>
                </form>

            </div>

            <!-- 2. TAB PANEL: KATA SANDI -->
            <div id="panel-password" class="tab-content-panel">
                <div style="margin-bottom: 24px;">
                    <h2 style="font-family:'Outfit',sans-serif; font-size:18px; font-weight:700; color:#1E293B; margin-bottom:4px;">Ganti Kata Sandi</h2>
                    <p style="font-size:13.5px; color:#64748B;">Pastikan kata sandi Anda kuat dan minimal terdiri dari 6 karakter.</p>
                </div>

                <form action="{{ route('sistem.profile.update') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="nama" value="{{ $user->nama }}">
                    <input type="hidden" name="nomor_kontak" value="{{ $user->nomor_kontak }}">

                    <div class="form-group-custom" style="margin-bottom: 18px; max-width: 500px;">
                        <label class="form-label-custom">Kata Sandi Saat Ini <span style="color:#EF4444;">*</span></label>
                        <input type="password" name="current_password" class="form-input-custom" placeholder="Masukkan kata sandi saat ini" required>
                    </div>

                    <div class="form-grid-pair" style="max-width: 650px;">
                        <div class="form-group-custom">
                            <label class="form-label-custom">Kata Sandi Baru <span style="color:#EF4444;">*</span></label>
                            <input type="password" name="new_password" class="form-input-custom" placeholder="Minimal 6 karakter" required>
                        </div>
                        <div class="form-group-custom">
                            <label class="form-label-custom">Konfirmasi Kata Sandi Baru <span style="color:#EF4444;">*</span></label>
                            <input type="password" name="new_password_confirmation" class="form-input-custom" placeholder="Ulangi kata sandi baru" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-save-changes">
                        <span>Perbarui Kata Sandi</span>
                    </button>
                </form>
            </div>

            <!-- 3. TAB PANEL: NOTIFIKASI -->
            <div id="panel-notifications" class="tab-content-panel">
                <div style="margin-bottom: 24px;">
                    <h2 style="font-family:'Outfit',sans-serif; font-size:18px; font-weight:700; color:#1E293B; margin-bottom:4px;">Preferensi Notifikasi</h2>
                    <p style="font-size:13.5px; color:#64748B;">Atur pemberitahuan sistem yang ingin Anda terima.</p>
                </div>

                <div>
                    <div class="notif-toggle-row">
                        <div class="notif-info-wrap">
                            <span class="notif-title-txt">Registrasi Akun Baru</span>
                            <span class="notif-desc-txt">Terima pemberitahuan seketika saat ada pengguna baru mendaftar di sistem.</span>
                        </div>
                        <label class="switch-ui">
                            <input type="checkbox" checked>
                            <span class="slider-round"></span>
                        </label>
                    </div>

                    <div class="notif-toggle-row">
                        <div class="notif-info-wrap">
                            <span class="notif-title-txt">Perubahan Data Akun</span>
                            <span class="notif-desc-txt">Dapatkan notifikasi saat data akun pengguna diubah atau diperbarui.</span>
                        </div>
                        <label class="switch-ui">
                            <input type="checkbox" checked>
                            <span class="slider-round"></span>
                        </label>
                    </div>

                    <div class="notif-toggle-row">
                        <div class="notif-info-wrap">
                            <span class="notif-title-txt">Peringatan Keamanan Sistem</span>
                            <span class="notif-desc-txt">Peringatan otomatis saat terdeteksi aktivitas mencurigakan atau login gagal berulang.</span>
                        </div>
                        <label class="switch-ui">
                            <input type="checkbox" checked>
                            <span class="slider-round"></span>
                        </label>
                    </div>

                    <div class="notif-toggle-row">
                        <div class="notif-info-wrap">
                            <span class="notif-title-txt">Laporan Mingguan Sistem</span>
                            <span class="notif-desc-txt">Ringkasan aktivitas sistem, jumlah pengguna aktif, dan status server.</span>
                        </div>
                        <label class="switch-ui">
                            <input type="checkbox">
                            <span class="slider-round"></span>
                        </label>
                    </div>
                </div>

                <button type="button" class="btn-save-changes" style="margin-top: 24px;" onclick="window.showSinfasToast('success', 'Preferensi Disimpan', 'Pengaturan notifikasi berhasil diperbarui.')">
                    <span>Simpan Preferensi Notifikasi</span>
                </button>
            </div>

            <!-- 4. TAB PANEL: VERIFIKASI -->
            <div id="panel-verification" class="tab-content-panel">
                <div style="margin-bottom: 24px;">
                    <h2 style="font-family:'Outfit',sans-serif; font-size:18px; font-weight:700; color:#1E293B; margin-bottom:4px;">Status & Verifikasi Akun</h2>
                    <p style="font-size:13.5px; color:#64748B;">Informasi integritas dan otorisasi kredensial administrator sistem Anda.</p>
                </div>

                <div class="verif-box-item">
                    <div>
                        <div style="font-weight: 700; color:#1E293B; font-size:14px; margin-bottom:2px;">Status Akun</div>
                        <div style="font-size:12.5px; color:#64748B;">Akun resmi terdaftar sebagai operator sistem</div>
                    </div>
                    <span class="verif-badge-success">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                        <span>Terverifikasi Aktif</span>
                    </span>
                </div>

                <div class="verif-box-item">
                    <div>
                        <div style="font-weight: 700; color:#1E293B; font-size:14px; margin-bottom:2px;">Tingkat Otoritas</div>
                        <div style="font-size:12.5px; color:#64748B;">Hak akses penuh: kelola akun, pengaturan, & keamanan sistem</div>
                    </div>
                    <span style="font-size:12.5px; font-weight:700; color:#1E3BB3; background:#EFF6FF; padding:4px 12px; border-radius:99px; border:1px solid #BFDBFE;">
                        Admin Sistem / Operator
                    </span>
                </div>

                <div class="verif-box-item">
                    <div>
                        <div style="font-weight: 700; color:#1E293B; font-size:14px; margin-bottom:2px;">Waktu Bergabung</div>
                        <div style="font-size:12.5px; color:#64748B;">Tanggal registrasi pertama kali di sistem</div>
                    </div>
                    <span style="font-size:13px; font-weight:600; color:#334155;">
                        {{ $user->created_at ? $user->created_at->format('d F Y') : '10 Januari 2026' }}
                    </span>
                </div>

                <div class="verif-box-item">
                    <div>
                        <div style="font-weight: 700; color:#1E293B; font-size:14px; margin-bottom:2px;">Keamanan Sesi</div>
                        <div style="font-size:12.5px; color:#64748B;">Protokol keamanan kata sandi terenkripsi Bcrypt</div>
                    </div>
                    <span class="verif-badge-success">
                        <span>Aman & Terlindungi</span>
                    </span>
                </div>
            </div>

        </div>

    </div>

@endsection

@section('scripts')
<script>
    // Tab switcher
    function switchSettingsTab(tabName, btnEl) {
        // Deactivate all buttons & panels
        document.querySelectorAll('.settings-tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelectorAll('.tab-content-panel').forEach(p => p.classList.remove('active'));

        // Activate selected
        btnEl.classList.add('active');
        const targetPanel = document.getElementById('panel-' + tabName);
        if (targetPanel) {
            targetPanel.classList.add('active');
        }
    }

    // Gender radio pill selection visual
    function selectGender(cardEl) {
        document.querySelectorAll('.gender-radio-card').forEach(c => c.classList.remove('active'));
        cardEl.classList.add('active');
    }

    // Avatar preview
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const box = document.getElementById('avatarDisplayBox');
                box.innerHTML = '<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover;">';
                window.showSinfasToast('success', 'Foto Terpilih', 'Klik "Simpan Perubahan" untuk menyimpan.');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Reset avatar
    function resetAvatar() {
        const box = document.getElementById('avatarDisplayBox');
        box.innerHTML = '{{ strtoupper(substr($user->nama ?? "S", 0, 2)) }}';
        document.getElementById('avatarFileInput').value = '';
        window.showSinfasToast('info', 'Foto Direset', 'Foto profil dikembalikan ke inisial nama.');
    }
</script>
@endsection
