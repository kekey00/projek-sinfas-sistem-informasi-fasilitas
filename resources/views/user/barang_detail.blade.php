@extends('layouts.user')

@section('title', 'Pinjam ' . $barang->nama_barang . ' - SINFAS')

@section('styles')
<style>
    .loan-request-grid {
        display: grid;
        grid-template-columns: 440px 1fr;
        gap: 32px;
        align-items: start;
    }

    /* LEFT PREVIEW CARD */
    .facility-hero-card {
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 26px;
        overflow: hidden;
        box-shadow: var(--shadow-card);
        position: relative;
    }

    .facility-hero-image-wrap {
        position: relative;
        width: 100%;
        aspect-ratio: 4/3;
        background: linear-gradient(135deg, #EEF2FF, #F8FAFC);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 1px solid #F1F5F9;
        padding: 20px;
    }

    .facility-hero-image-wrap img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        object-position: center;
        filter: drop-shadow(0 6px 14px rgba(0, 0, 0, 0.07));
    }

    .badge-status-glow {
        position: absolute;
        top: 16px;
        left: 16px;
        padding: 6px 16px;
        border-radius: var(--radius-pill);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.3px;
        color: #fff;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.15);
        backdrop-filter: blur(8px);
        z-index: 2;
    }

    .facility-hero-content {
        padding: 28px;
    }

    .facility-title-hero {
        font-size: 24px;
        font-weight: 900;
        letter-spacing: -0.5px;
        color: var(--text-main);
        margin-bottom: 6px;
    }

    .facility-category-chip {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        font-size: 13px;
        font-weight: 700;
        color: var(--brand-primary);
        background: #EEF2FF;
        padding: 4px 12px;
        border-radius: var(--radius-pill);
        margin-bottom: 22px;
    }

    .specs-chips-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 12px;
        margin-bottom: 22px;
    }

    .spec-chip-item {
        background: #F8FAFC;
        border: 1px solid #E2E8F0;
        border-radius: var(--radius-md);
        padding: 12px 14px;
    }

    .spec-label {
        font-size: 11.5px;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-muted);
        letter-spacing: 0.5px;
        margin-bottom: 2px;
    }

    .spec-val {
        font-size: 14px;
        font-weight: 800;
        color: var(--text-main);
    }

    .desc-bubble {
        background: #F8FAFC;
        border-left: 3px solid var(--brand-primary);
        padding: 14px 16px;
        border-radius: 0 var(--radius-sm) var(--radius-sm) 0;
        font-size: 13.5px;
        color: var(--text-secondary);
        line-height: 1.6;
    }

    /* RIGHT FORM CARD */
    .form-card-vibe {
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 26px;
        padding: 36px 40px;
        box-shadow: var(--shadow-card);
    }

    .form-title-wrap {
        margin-bottom: 26px;
        padding-bottom: 16px;
        border-bottom: 1.5px solid #F1F5F9;
    }

    .form-title-text {
        font-size: 24px;
        font-weight: 900;
        letter-spacing: -0.4px;
        color: var(--text-main);
        margin-bottom: 4px;
    }

    .form-title-sub {
        font-size: 14px;
        color: var(--text-secondary);
    }

    .form-input-group {
        margin-bottom: 20px;
    }

    .form-label-vibe {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13.5px;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 8px;
    }

    .form-control-vibe {
        width: 100%;
        background: #F8FAFC;
        border: 1.5px solid #E2E8F0;
        border-radius: var(--radius-md);
        padding: 12px 16px;
        font-size: 14.5px;
        font-weight: 500;
        color: var(--text-main);
        outline: none;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        font-family: inherit;
    }

    .form-control-vibe:focus {
        background: #FFFFFF;
        border-color: var(--brand-primary);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
    }

    .form-control-vibe[readonly],
    .form-control-vibe:disabled {
        background: #F1F5F9;
        color: #64748B;
        cursor: not-allowed;
        border-color: #E2E8F0;
    }

    .date-inputs-split {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
        margin-bottom: 16px;
    }

    @media (max-width: 580px) {
        .date-inputs-split {
            grid-template-columns: 1fr;
            gap: 12px;
        }
    }

    .btn-submit-loan-vibe {
        width: 100%;
        background: var(--brand-gradient);
        color: #fff;
        border: none;
        border-radius: var(--radius-md);
        padding: 14px;
        font-size: 15.5px;
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

    .btn-submit-loan-vibe:hover {
        background: var(--brand-gradient-hover);
        transform: translateY(-2px);
        box-shadow: 0 12px 28px -4px rgba(79, 70, 229, 0.45);
    }

    @media (max-width: 960px) {
        .loan-request-grid { grid-template-columns: 1fr; }
        .form-card-vibe { padding: 26px 24px; }
    }
</style>
@endsection

@section('content')

    <!-- BACK NAV PILL -->
    <a href="{{ route('user.dashboard') }}" class="back-pill-link" id="btn-back-catalog">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
        <span>Kembali ke Katalog</span>
    </a>

    @php
        $isAvailable = $barang->jumlah_baik > 0;
    @endphp

    <div class="loan-request-grid">

        <!-- LEFT PANEL: ITEM PREVIEW -->
        <div class="facility-hero-card">
            <div class="facility-hero-image-wrap">
                <span class="badge-status-glow" style="background: {{ $isAvailable ? 'linear-gradient(135deg, #10B981, #059669)' : 'linear-gradient(135deg, #F43F5E, #E11D48)' }};">
                    <span style="width: 6px; height: 6px; border-radius: 50%; background: #fff;"></span>
                    <span>{{ $isAvailable ? 'Tersedia' : 'Habis' }}</span>
                </span>

                @if($barang->foto)
                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" onerror="this.style.display='none'; if(this.nextElementSibling) this.nextElementSibling.style.display='block';">
                    <svg style="display:none;" width="84" height="84" viewBox="0 0 24 24" fill="none" stroke="#818CF8" stroke-width="1.5">
                        <rect x="2" y="7" width="20" height="14" rx="2"/><circle cx="12" cy="14" r="3"/><path d="M12 3v4"/><path d="M8 3h8"/>
                    </svg>
                @else
                    <svg width="84" height="84" viewBox="0 0 24 24" fill="none" stroke="#818CF8" stroke-width="1.5">
                        <rect x="2" y="7" width="20" height="14" rx="2"/><circle cx="12" cy="14" r="3"/><path d="M12 3v4"/><path d="M8 3h8"/>
                    </svg>
                @endif
            </div>

            <div class="facility-hero-content">
                <h1 class="facility-title-hero" id="barang-detail-title">{{ $barang->nama_barang }}</h1>
                <div class="facility-category-chip">
                    <span>#</span>
                    <span>{{ $barang->kategori->nama_kategori ?? 'Umum' }}</span>
                </div>

                <div class="specs-chips-grid">
                    <div class="spec-chip-item">
                        <div class="spec-label">Kondisi Fisik</div>
                        <div class="spec-val">{{ $barang->kondisi ?? 'Baik' }} ✨</div>
                    </div>
                    <div class="spec-chip-item">
                        <div class="spec-label">Stok Tersedia</div>
                        <div class="spec-val">{{ $barang->jumlah_baik }} Unit 📦</div>
                    </div>
                    @if($barang->merk_model)
                        <div class="spec-chip-item" style="grid-column: 1 / -1;">
                            <div class="spec-label">Merk / Model</div>
                            <div class="spec-val">{{ $barang->merk_model }}</div>
                        </div>
                    @endif
                </div>

                @if($barang->keterangan)
                    <div class="desc-bubble">
                        <strong>Catatan Fasilitas:</strong><br>
                        {{ $barang->keterangan }}
                    </div>
                @endif
            </div>
        </div>

        <!-- RIGHT PANEL: LOAN REQUEST FORM -->
        <div class="form-card-vibe">
            <div class="form-title-wrap">
                <h2 class="form-title-text">Formulir Peminjaman 📝</h2>
                <p class="form-title-sub">Isi keperluan peminjaman fasilitas untuk diverifikasi Admin Sarpras.</p>
            </div>

            @if(!$isAvailable)
                <div style="background:#FFF1F2; border: 1.5px solid #FECDD3; border-radius: var(--radius-md); padding: 24px; text-align:center; color:#9F1239;">
                    <div style="font-size: 32px; margin-bottom: 8px;">⛔</div>
                    <h3 style="font-size: 16px; font-weight: 800; margin-bottom: 4px;">Stok Barang Sedang Tidak Tersedia</h3>
                    <p style="font-size: 13.5px; color:#BE123C; margin-bottom: 16px;">Barang ini sedang dipinjam seluruhnya atau sedang dalam pemeliharaan.</p>
                    <a href="{{ route('user.dashboard') }}" class="btn-genz-primary" style="font-size: 13.5px; padding: 10px 20px;">
                        Pilih Fasilitas Lain
                    </a>
                </div>
            @else
                <form method="POST" action="{{ route('user.peminjaman.store') }}" id="form-peminjaman">
                    @csrf
                    <input type="hidden" name="kode_barang" value="{{ $barang->kode_barang }}">

                    <!-- BORROWER NAME -->
                    <div class="form-input-group">
                        <label class="form-label-vibe">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                            <span>Nama Peminjam</span>
                        </label>
                        <input type="text" class="form-control-vibe" value="{{ Auth::user()->nama }}" readonly title="Nama peminjam terverifikasi">
                    </div>

                    <!-- BORROWER IDENTITY / NIM / NIS -->
                    <div class="form-input-group">
                        <label class="form-label-vibe">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="4" width="18" height="16" rx="2"></rect><line x1="7" y1="8" x2="17" y2="8"></line><line x1="7" y1="12" x2="13" y2="12"></line></svg>
                            <span>Nomor Induk Siswa (NIS)</span>
                        </label>
                        <input type="text" class="form-control-vibe" value="{{ Auth::user()->nis ?? '-' }}" readonly title="NIS resmi">
                    </div>

                    <!-- BORROWER PHONE NUMBER -->
                    <div class="form-input-group">
                        <label for="nomor_telepon" class="form-label-vibe">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                            <span>Nomor Telepon / WhatsApp</span>
                        </label>
                        <input type="tel" id="nomor_telepon" name="nomor_telepon" class="form-control-vibe"
                               placeholder="Contoh: 081234567890"
                               value="{{ old('nomor_telepon', Auth::user()->nomor_kontak ?? (Auth::user()->siswa->no_hp ?? '')) }}"
                               required>
                        @error('nomor_telepon')
                            <span style="font-size:12px; color:var(--badge-rose); display:block; margin-top:4px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- PURPOSE / REASON -->
                    <div class="form-input-group">
                        <label for="keterangan_penggunaan" class="form-label-vibe">
                            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path></svg>
                            <span>Keperluan Pinjam</span>
                        </label>
                        <textarea id="keterangan_penggunaan" name="keterangan_penggunaan" class="form-control-vibe" rows="3"
                                  placeholder="Contoh: Digunakan untuk presentasi kelas atau dokumentasi kegiatan OSIS..." required>{{ old('keterangan_penggunaan') }}</textarea>
                        @error('keterangan_penggunaan')
                            <span style="font-size:12px; color:var(--badge-rose); display:block; margin-top:4px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- LOAN AND PLANNED RETURN DATES -->
                    <div class="date-inputs-split">
                        <div class="form-input-group">
                            <label for="tanggal_pinjam" class="form-label-vibe">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                                <span>Tanggal Pinjam</span>
                            </label>
                            <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" class="form-control-vibe"
                                   value="{{ old('tanggal_pinjam', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                            @error('tanggal_pinjam')
                                <span style="font-size:12px; color:var(--badge-rose); display:block; margin-top:4px;">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-input-group">
                            <label for="tanggal_kembali" class="form-label-vibe">
                                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><polyline points="23 4 23 10 17 10"></polyline><polyline points="1 20 1 14 7 14"></polyline><path d="M3.51 9a9 9 0 0 1 14.85-3.36L23 10M1 14l4.64 4.36A9 9 0 0 0 20.49 15"></path></svg>
                                <span>Rencana Tanggal Pengembalian</span>
                            </label>
                            <input type="date" id="tanggal_kembali" name="tanggal_kembali" class="form-control-vibe"
                                   value="{{ old('tanggal_kembali', date('Y-m-d')) }}" min="{{ date('Y-m-d') }}" required>
                            @error('tanggal_kembali')
                                <span style="font-size:12px; color:var(--badge-rose); display:block; margin-top:4px;">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>

                    <button type="submit" class="btn-submit-loan-vibe" id="btn-submit-loan">
                        <span>Ajukan Peminjaman</span>
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                    </button>

                    <p style="font-size: 12px; color: var(--text-muted); text-align: center; margin-top: 14px;">
                        🔒 Data peminjamanmu langsung terhubung ke sistem sarana prasarana sekolah.
                    </p>
                </form>
            @endif
        </div>

    </div>

@endsection

@section('scripts')
<script>
    const tglPinjam = document.getElementById('tanggal_pinjam');
    const tglKembali = document.getElementById('tanggal_kembali');

    if (tglPinjam && tglKembali) {
        tglPinjam.addEventListener('change', function () {
            if (this.value) {
                tglKembali.min = this.value;
                if (tglKembali.value && tglKembali.value < this.value) {
                    tglKembali.value = this.value;
                }
            }
        });
    }

</script>
@endsection
