@extends('layouts.admin')

@section('title', 'Profil Saya - SINFAS')
@section('page_title', 'Profil Saya')

@section('styles')
<style>
    /* ─── BREADCRUMB & HEADER ─── */
    .profile-top-breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13.5px;
        color: #64748B;
        margin-bottom: 20px;
    }
    .profile-top-breadcrumb a {
        color: #2D4E9E;
        text-decoration: none;
        font-weight: 600;
    }
    .profile-top-breadcrumb a:hover {
        text-decoration: underline;
    }

    .profile-header-meta {
        margin-bottom: 22px;
    }
    .profile-title {
        font-family: 'Outfit', sans-serif;
        font-size: 26px;
        font-weight: 700;
        color: #1E293B;
        letter-spacing: -0.4px;
        margin-bottom: 4px;
    }
    .profile-subtitle {
        font-size: 13.5px;
        color: #64748B;
    }

    /* ─── ALERT FLASH ─── */
    .profile-alert {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 13px 18px;
        border-radius: 12px;
        font-size: 13.5px;
        font-weight: 500;
        margin-bottom: 20px;
    }
    .profile-alert-success {
        background: #F0FDF4;
        border: 1px solid #BBF7D0;
        color: #166534;
    }
    .profile-alert-error {
        background: #FEF2F2;
        border: 1px solid #FECACA;
        color: #991B1B;
    }

    /* ─── 2-COLUMN LAYOUT ─── */
    .profile-grid-layout {
        display: grid;
        grid-template-columns: 340px 1fr;
        gap: 24px;
        align-items: flex-start;
    }
    @media (max-width: 960px) {
        .profile-grid-layout { grid-template-columns: 1fr; }
    }

    /* ─── LEFT CARD (KARTU IDENTITAS) ─── */
    .profile-id-card {
        background: #FFFFFF;
        border: 1px solid #E8EEF6;
        border-radius: 18px;
        padding: 36px 24px 28px;
        box-shadow: 0 2px 12px -2px rgba(30, 41, 80, 0.05), 0 1px 3px rgba(0, 0, 0, 0.03);
        text-align: center;
    }

    .avatar-wrapper-center {
        display: flex;
        justify-content: center;
        margin-bottom: 16px;
    }
    .avatar-photo-circle {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        background: #EFF6FF;
        border: 4px solid #FFFFFF;
        box-shadow: 0 0 0 2px #E2E8F0, 0 8px 20px rgba(45, 78, 158, 0.15);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        font-family: 'Outfit', sans-serif;
        font-size: 38px;
        font-weight: 700;
        color: #2D4E9E;
    }

    .id-card-name {
        font-family: 'Outfit', sans-serif;
        font-size: 20px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 2px;
        letter-spacing: -0.3px;
    }
    .id-card-sub {
        font-size: 13.5px;
        color: #64748B;
        font-weight: 500;
        margin-bottom: 10px;
    }

    .role-badge-amber {
        display: inline-block;
        background: #F59E0B;
        color: #FFFFFF;
        font-size: 11.5px;
        font-weight: 700;
        padding: 3px 16px;
        border-radius: 9999px;
        letter-spacing: 0.3px;
        box-shadow: 0 2px 6px rgba(245, 158, 11, 0.25);
    }

    .sub-role-desc {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        font-size: 12.5px;
        color: #64748B;
        margin-top: 10px;
    }

    /* List info kiri */
    .id-info-list {
        margin-top: 28px;
        border-top: 1px solid #F1F5F9;
        text-align: left;
    }
    .id-info-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #F8FAFC;
        font-size: 13px;
    }
    .id-info-label {
        color: #64748B;
    }
    .id-info-value {
        font-weight: 600;
        color: #1E293B;
        text-align: right;
    }

    /* ─── RIGHT CARDS (EDIT PROFIL & GANTI PASSWORD) ─── */
    .card-settings-box {
        background: #FFFFFF;
        border: 1px solid #E8EEF6;
        border-radius: 18px;
        padding: 26px 30px;
        box-shadow: 0 2px 12px -2px rgba(30, 41, 80, 0.05), 0 1px 3px rgba(0, 0, 0, 0.03);
        margin-bottom: 20px;
    }

    .card-settings-header {
        display: flex;
        align-items: center;
        gap: 10px;
        font-family: 'Outfit', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #1E293B;
        margin-bottom: 22px;
        letter-spacing: -0.2px;
    }
    .card-settings-header svg {
        color: #2D4E9E;
    }

    /* Form Grid */
    .form-row-2 {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }
    .form-row-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr;
        gap: 16px;
        margin-bottom: 20px;
    }
    @media (max-width: 768px) {
        .form-row-2, .form-row-3 { grid-template-columns: 1fr; }
    }

    .form-field {
        display: flex;
        flex-direction: column;
        gap: 6px;
    }
    .form-label-txt {
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
    }
    .form-input-txt {
        width: 100%;
        box-sizing: border-box;
        padding: 10px 14px;
        border: 1px solid #CBD5E1;
        border-radius: 9px;
        font-size: 13.5px;
        color: #1E293B;
        outline: none;
        transition: all 0.15s ease;
        background: #FFFFFF;
        font-family: inherit;
    }
    .form-input-txt:focus {
        border-color: #2D4E9E;
        box-shadow: 0 0 0 3px rgba(45, 78, 158, 0.10);
    }
    .form-input-txt[readonly] {
        background: #F8FAFC;
        color: #64748B;
        cursor: not-allowed;
    }

    /* File upload mimic */
    .file-input-wrap {
        display: flex;
        align-items: center;
        border: 1px solid #CBD5E1;
        border-radius: 9px;
        background: #FFFFFF;
        padding: 4px;
        height: 40px;
        box-sizing: border-box;
    }
    .file-btn-fake {
        background: #F1F5F9;
        color: #334155;
        border: 1px solid #E2E8F0;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 600;
        padding: 5px 12px;
        white-space: nowrap;
        cursor: pointer;
    }
    .file-name-fake {
        font-size: 12px;
        color: #94A3B8;
        padding-left: 10px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* Buttons */
    .btn-save-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #2D4E9E;
        color: #FFFFFF;
        border: none;
        border-radius: 9px;
        padding: 10px 22px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
        box-shadow: 0 3px 10px rgba(45, 78, 158, 0.20);
    }
    .btn-save-submit:hover {
        background: #243f85;
        transform: translateY(-1px);
        box-shadow: 0 6px 16px rgba(45, 78, 158, 0.30);
    }

    .btn-password-submit {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: #FFFFFF;
        color: #2D4E9E;
        border: 1.5px solid #2D4E9E;
        border-radius: 9px;
        padding: 9px 20px;
        font-size: 13.5px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.15s ease;
    }
    .btn-password-submit:hover {
        background: #EFF6FF;
        transform: translateY(-1px);
    }
</style>
@endsection

@section('content')

    <!-- BREADCRUMB -->
    <div class="profile-top-breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Beranda</a>
        <span>/</span>
        <span>Profil</span>
    </div>

    <!-- FLASH MESSAGE -->
    @if(session('success'))
        <div class="profile-alert profile-alert-success">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="20 6 9 17 4 12"></polyline>
            </svg>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div class="profile-alert profile-alert-error">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="12" cy="12" r="10"></circle>
                <line x1="12" y1="8" x2="12" y2="12"></line>
                <line x1="12" y1="16" x2="12.01" y2="16"></line>
            </svg>
            <div>
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- TITLE & SUBTITLE -->
    <div class="profile-header-meta">
        <h1 class="profile-title">Profil Saya</h1>
        <p class="profile-subtitle">Kelola informasi akun Anda</p>
    </div>

    <div class="profile-grid-layout">

        <!-- ─── KARTU KIRI: IDENTITAS PROFIL ─── -->
        <div class="profile-id-card">
            <div class="avatar-wrapper-center">
                <div class="avatar-photo-circle">
                    {{ strtoupper(substr($user->nama ?? 'A', 0, 2)) }}
                </div>
            </div>

            <div class="id-card-name">{{ $user->nama ?? 'Admin Sarana' }}</div>
            <div class="id-card-sub">{{ $user->nip ?? ($user->username ?? 'admin_sarana') }}</div>

            <div>
                <span class="role-badge-amber">
                    Admin Sarana
                </span>
            </div>

            <div class="sub-role-desc">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
                <span>Administrator Sarana</span>
            </div>

            <!-- List Detail -->
            <div class="id-info-list">
                <div class="id-info-row">
                    <span class="id-info-label">Email</span>
                    <span class="id-info-value">{{ $user->email ?? 'sarana@sinfas.sch.id' }}</span>
                </div>
                <div class="id-info-row">
                    <span class="id-info-label">Jenis Kelamin</span>
                    <span class="id-info-value">Laki-laki</span>
                </div>
                <div class="id-info-row" style="border-bottom: none;">
                    <span class="id-info-label">Bergabung</span>
                    <span class="id-info-value">{{ $user->created_at ? $user->created_at->format('d M Y') : '18 Apr 2026' }}</span>
                </div>
            </div>
        </div>

        <!-- ─── KOLOM KANAN: EDIT PROFIL & GANTI PASSWORD ─── -->
        <div>

            <!-- FORM 1: EDIT PROFIL -->
            <div class="card-settings-box">
                <div class="card-settings-header">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                    <span>Edit Profil</span>
                </div>

                <form method="POST" action="{{ route('admin.profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="form-row-2">
                        <div class="form-field">
                            <label class="form-label-txt">Nama Lengkap</label>
                            <input type="text" name="nama" class="form-input-txt" value="{{ old('nama', $user->nama) }}" required>
                        </div>
                        <div class="form-field">
                            <label class="form-label-txt">Email</label>
                            <input type="email" name="email" class="form-input-txt" value="{{ old('email', $user->email ?? 'sarana@sinfas.sch.id') }}">
                        </div>
                    </div>

                    <div class="form-row-3">
                        <div class="form-field">
                            <label class="form-label-txt">Jabatan / Kontak</label>
                            <input type="text" name="nomor_kontak" class="form-input-txt" value="{{ old('nomor_kontak', $user->nomor_kontak ?? 'Admin Sarana Prasarana') }}" placeholder="e.g. 08123456789">
                        </div>
                        <div class="form-field">
                            <label class="form-label-txt">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-input-txt">
                                <option value="Laki-laki" selected>Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>
                        <div class="form-field">
                            <label class="form-label-txt">Foto Profil</label>
                            <div class="file-input-wrap">
                                <span class="file-btn-fake">Pilih File</span>
                                <span class="file-name-fake">Tidak ada file yang dipilih</span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-save-submit">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="20 6 9 17 4 12"></polyline>
                        </svg>
                        <span>Simpan Perubahan</span>
                    </button>
                </form>
            </div>

            <!-- FORM 2: GANTI PASSWORD -->
            <div class="card-settings-box">
                <div class="card-settings-header">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect>
                        <path d="M7 11V7a5 5 0 0 1 10 0v4"></path>
                    </svg>
                    <span>Ganti Password</span>
                </div>

                <form method="POST" action="{{ route('admin.profile.update') }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="nama" value="{{ $user->nama }}">

                    <div class="form-row-3">
                        <div class="form-field">
                            <label class="form-label-txt">Password Lama</label>
                            <input type="password" name="current_password" class="form-input-txt" placeholder="Password lama" required>
                        </div>
                        <div class="form-field">
                            <label class="form-label-txt">Password Baru</label>
                            <input type="password" name="new_password" class="form-input-txt" placeholder="Minimal 6 karakter" required>
                        </div>
                        <div class="form-field">
                            <label class="form-label-txt">Konfirmasi Password</label>
                            <input type="password" name="new_password_confirmation" class="form-input-txt" placeholder="Ulangi password baru" required>
                        </div>
                    </div>

                    <button type="submit" class="btn-password-submit">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                        </svg>
                        <span>Ubah Password</span>
                    </button>
                </form>
            </div>

        </div>

    </div>

@endsection
