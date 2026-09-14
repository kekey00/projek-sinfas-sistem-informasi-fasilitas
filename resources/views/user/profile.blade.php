@extends('layouts.user')

@section('title', 'My Profile - SINFAS')

@section('styles')
<style>
    .profile-shell-card {
        max-width: 680px;
        margin: 0 auto;
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 28px;
        padding: 40px 44px;
        box-shadow: var(--shadow-card);
    }

    /* AVATAR HERO */
    .avatar-hero-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 34px;
    }

    .avatar-story-ring {
        position: relative;
        width: 104px;
        height: 104px;
        border-radius: var(--radius-pill);
        padding: 3.5px;
        background: linear-gradient(135deg, #EC4899 0%, #8B5CF6 50%, #3B82F6 100%);
        box-shadow: 0 8px 25px -4px rgba(139, 92, 246, 0.35);
        margin-bottom: 14px;
    }

    .avatar-story-inner {
        width: 100%;
        height: 100%;
        border-radius: var(--radius-pill);
        background: #F8FAFC;
        border: 3px solid #FFFFFF;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--brand-primary);
        overflow: hidden;
    }

    .avatar-camera-pill {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 32px;
        height: 32px;
        border-radius: var(--radius-pill);
        background: var(--brand-primary);
        border: 2.5px solid #FFFFFF;
        color: #fff;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        cursor: pointer;
        transition: transform 0.2s cubic-bezier(0.34, 1.56, 0.64, 1);
    }

    .avatar-camera-pill:hover {
        transform: scale(1.15);
    }

    .profile-heading-name {
        font-size: 24px;
        font-weight: 900;
        letter-spacing: -0.5px;
        color: var(--text-main);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .verified-icon-check {
        width: 20px;
        height: 20px;
        color: #3B82F6;
    }

    .profile-role-sub {
        font-size: 13.5px;
        color: var(--text-secondary);
        margin-top: 2px;
    }

    /* SECTIONS */
    .profile-box-section {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: var(--radius-lg);
        padding: 24px;
        margin-bottom: 22px;
    }

    .section-vibe-header {
        font-size: 15px;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 18px;
        display: flex;
        align-items: center;
        gap: 8px;
        padding-bottom: 10px;
        border-bottom: 1.5px solid #E2E8F0;
    }

    .input-field-wrap {
        margin-bottom: 16px;
    }

    .label-vibe-clean {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: var(--text-main);
        margin-bottom: 6px;
    }

    .control-vibe-input {
        width: 100%;
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: var(--radius-md);
        padding: 11px 16px;
        font-size: 14px;
        color: var(--text-main);
        outline: none;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        font-family: inherit;
    }

    .control-vibe-input:focus {
        border-color: var(--brand-primary);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
    }

    .control-vibe-input[readonly],
    .control-vibe-input:disabled {
        background: #F1F5F9;
        color: #64748B;
        cursor: not-allowed;
    }

    .btn-save-vibe {
        width: 100%;
        background: var(--brand-gradient);
        color: #fff;
        border: none;
        border-radius: var(--radius-md);
        padding: 13px;
        font-size: 15px;
        font-weight: 800;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: var(--shadow-glow);
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        margin-top: 10px;
    }

    .btn-save-vibe:hover {
        background: var(--brand-gradient-hover);
        transform: translateY(-2px);
        box-shadow: 0 12px 28px -4px rgba(79, 70, 229, 0.45);
    }

    @media (max-width: 640px) {
        .profile-shell-card { padding: 26px 20px; }
    }
</style>
@endsection

@section('content')

    <!-- BACK NAV PILL -->
    <a href="{{ route('user.dashboard') }}" class="back-pill-link" id="btn-back-home">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
        <span>Back to Home</span>
    </a>

    <div class="profile-shell-card">

        <!-- AVATAR HEADER -->
        <div class="avatar-hero-wrap">
            <div class="avatar-story-ring">
                <div class="avatar-story-inner">
                    <svg width="56" height="56" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                        <circle cx="12" cy="7" r="4"></circle>
                    </svg>
                </div>
                <div class="avatar-camera-pill" title="Ubah Foto Profil">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                </div>
            </div>

            <h1 class="profile-heading-name">
                <span>{{ $user->nama }}</span>
                <svg class="verified-icon-check" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                </svg>
            </h1>
            <p class="profile-role-sub">Siswa &bull; NIS: <strong>{{ $user->nis ?? '-' }}</strong></p>
        </div>

        <form method="POST" action="{{ route('user.profile.update') }}" id="form-profile-vibe">
            @csrf
            @method('PUT')

            <!-- SECTION 1: PERSONAL IDENTIFICATION -->
            <div class="profile-box-section">
                <div class="section-vibe-header">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                    <span>Personal Identification</span>
                </div>

                <!-- FULL NAME -->
                <div class="input-field-wrap">
                    <label for="nama" class="label-vibe-clean">Full Name</label>
                    <input type="text" id="nama" name="nama" class="control-vibe-input"
                           value="{{ old('nama', $user->nama) }}" required>
                    @error('nama')
                        <span style="font-size:12px; color:var(--badge-rose); display:block; margin-top:4px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- NIS / NIM -->
                <div class="input-field-wrap">
                    <label for="nis" class="label-vibe-clean">NIM / NIS (Nomor Induk Siswa)</label>
                    <input type="text" id="nis" class="control-vibe-input" value="{{ $user->nis ?? '-' }}" readonly title="Identitas NIS terverifikasi oleh sekolah">
                </div>

                <!-- EMAIL -->
                <div class="input-field-wrap">
                    <label for="email" class="label-vibe-clean">Email Address</label>
                    <input type="email" id="email" name="email" class="control-vibe-input"
                           value="{{ old('email', $siswa->email ?? '') }}" placeholder="nama@sekolah.sch.id">
                    @error('email')
                        <span style="font-size:12px; color:var(--badge-rose); display:block; margin-top:4px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- PHONE NUMBER -->
                <div class="input-field-wrap" style="margin-bottom: 0;">
                    <label for="nomor_kontak" class="label-vibe-clean">Phone Number (WhatsApp / HP)</label>
                    <input type="text" id="nomor_kontak" name="nomor_kontak" class="control-vibe-input"
                           value="{{ old('nomor_kontak', $user->nomor_kontak ?? ($siswa->no_hp ?? '')) }}" placeholder="08xxxxxxxxxx">
                    @error('nomor_kontak')
                        <span style="font-size:12px; color:var(--badge-rose); display:block; margin-top:4px;">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- SECTION 2: CHANGE PASSWORD -->
            <div class="profile-box-section">
                <div class="section-vibe-header">
                    <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
                    <span>Change Password 🔒</span>
                </div>

                <!-- CURRENT PASSWORD -->
                <div class="input-field-wrap">
                    <label for="current_password" class="label-vibe-clean">Current Password</label>
                    <input type="password" id="current_password" name="current_password" class="control-vibe-input"
                           placeholder="Masukkan kata sandi saat ini jika ingin mengganti">
                    @error('current_password')
                        <span style="font-size:12px; color:var(--badge-rose); display:block; margin-top:4px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- NEW PASSWORD -->
                <div class="input-field-wrap">
                    <label for="new_password" class="label-vibe-clean">New Password</label>
                    <input type="password" id="new_password" name="new_password" class="control-vibe-input"
                           placeholder="Minimal 6 karakter">
                    @error('new_password')
                        <span style="font-size:12px; color:var(--badge-rose); display:block; margin-top:4px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- CONFIRM NEW PASSWORD -->
                <div class="input-field-wrap" style="margin-bottom: 0;">
                    <label for="new_password_confirmation" class="label-vibe-clean">Confirm New Password</label>
                    <input type="password" id="new_password_confirmation" name="new_password_confirmation" class="control-vibe-input"
                           placeholder="Ulangi kata sandi baru">
                </div>
            </div>

            <button type="submit" class="btn-save-vibe" id="btn-save-changes">
                <span>Save Changes ✨</span>
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </button>
        </form>

    </div>

@endsection
