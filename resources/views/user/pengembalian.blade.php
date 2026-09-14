@extends('layouts.user')

@section('title', 'Pengembalian Barang - SINFAS')

@section('styles')
<style>
    .return-grid-layout {
        display: grid;
        grid-template-columns: 420px 1fr;
        gap: 32px;
        align-items: start;
    }

    /* LEFT DETAIL CARD */
    .return-preview-card {
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 26px;
        overflow: hidden;
        box-shadow: var(--shadow-card);
        position: relative;
    }

    .return-photo-wrapper {
        position: relative;
        width: 100%;
        aspect-ratio: 4/3;
        background: linear-gradient(135deg, #EEF2FF, #F8FAFC);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-bottom: 1px solid #F1F5F9;
    }

    .return-photo-wrapper img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .status-badge-borrowed {
        position: absolute;
        top: 16px;
        left: 16px;
        background: linear-gradient(135deg, #10B981, #059669);
        color: #fff;
        padding: 5px 16px;
        border-radius: var(--radius-pill);
        font-size: 12px;
        font-weight: 800;
        letter-spacing: 0.2px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.15);
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .return-card-body {
        padding: 26px;
    }

    .return-item-title {
        font-size: 22px;
        font-weight: 900;
        letter-spacing: -0.4px;
        color: var(--text-main);
        margin-bottom: 16px;
    }

    .return-meta-stack {
        display: flex;
        flex-direction: column;
        gap: 12px;
        font-size: 13.5px;
        color: var(--text-secondary);
    }

    .meta-line {
        display: flex;
        justify-content: space-between;
        padding-bottom: 8px;
        border-bottom: 1px dashed #E2E8F0;
    }

    .meta-line strong {
        color: var(--text-main);
    }

    /* RIGHT FORM CARD */
    .return-form-vibe-card {
        background: #FFFFFF;
        border: 1.5px solid #E2E8F0;
        border-radius: 26px;
        padding: 36px 40px;
        box-shadow: var(--shadow-card);
    }

    .form-header-box {
        margin-bottom: 26px;
        padding-bottom: 16px;
        border-bottom: 1.5px solid #F1F5F9;
    }

    .form-header-title {
        font-size: 24px;
        font-weight: 900;
        letter-spacing: -0.4px;
        color: var(--text-main);
        margin-bottom: 4px;
    }

    .form-header-sub {
        font-size: 14px;
        color: var(--text-secondary);
    }

    .form-group-vibe {
        margin-bottom: 22px;
    }

    .label-vibe-bold {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 13.5px;
        font-weight: 800;
        color: var(--text-main);
        margin-bottom: 8px;
    }

    .input-vibe-control {
        width: 100%;
        background: #F8FAFC;
        border: 1.5px solid #E2E8F0;
        border-radius: var(--radius-md);
        padding: 12px 16px;
        font-size: 14px;
        color: var(--text-main);
        outline: none;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        font-family: inherit;
    }

    .input-vibe-control:focus {
        background: #FFFFFF;
        border-color: var(--brand-primary);
        box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.12);
    }

    /* CONDITION SELECTION CARDS */
    .condition-cards-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 12px;
    }

    .condition-option-box {
        border: 2px solid #E2E8F0;
        border-radius: var(--radius-md);
        padding: 14px 12px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        background: #F8FAFC;
        user-select: none;
    }

    .condition-option-box:hover {
        border-color: var(--brand-primary);
        background: #EEF2FF;
        transform: translateY(-2px);
    }

    .condition-option-box.active {
        border-color: var(--brand-primary);
        background: #EEF2FF;
        box-shadow: 0 4px 14px rgba(79, 70, 229, 0.18);
    }

    .cond-emoji {
        font-size: 22px;
        margin-bottom: 4px;
    }

    .cond-title {
        font-size: 13.5px;
        font-weight: 800;
        color: var(--text-main);
    }

    .cond-desc {
        font-size: 11px;
        color: var(--text-muted);
        margin-top: 2px;
    }

    /* DROPZONE */
    .dropzone-vibe-box {
        border: 2px dashed #CBD5E1;
        border-radius: var(--radius-md);
        background: #F8FAFC;
        padding: 28px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .dropzone-vibe-box:hover {
        border-color: var(--brand-primary);
        background: #EEF2FF;
    }

    .dropzone-icon-circle {
        width: 52px;
        height: 52px;
        border-radius: var(--radius-pill);
        background: #EEF2FF;
        color: var(--brand-primary);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
    }

    .preview-box-holder {
        display: none;
        margin-top: 16px;
        text-align: center;
    }

    .preview-box-holder img {
        max-height: 200px;
        border-radius: var(--radius-md);
        border: 2px solid #E2E8F0;
        box-shadow: var(--shadow-subtle);
    }

    .btn-submit-return-vibe {
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

    .btn-submit-return-vibe:hover {
        background: var(--brand-gradient-hover);
        transform: translateY(-2px);
        box-shadow: 0 12px 28px -4px rgba(79, 70, 229, 0.45);
    }

    @media (max-width: 960px) {
        .return-grid-layout { grid-template-columns: 1fr; }
        .condition-cards-grid { grid-template-columns: 1fr; }
    }
</style>
@endsection

@section('content')

    <!-- BACK NAV PILL -->
    <a href="{{ route('user.status') }}" class="back-pill-link" id="btn-back-status">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
        <span>Back to Status Pengajuan</span>
    </a>

    @php
        $barang = $peminjaman->barang;
    @endphp

    <div class="return-grid-layout">

        <!-- LEFT PANEL: ITEM PREVIEW -->
        <div class="return-preview-card">
            <div class="return-photo-wrapper">
                <span class="status-badge-borrowed">
                    <span style="width:6px; height:6px; border-radius:50%; background:#fff;"></span>
                    <span>Sedang Dipinjam</span>
                </span>

                @if($barang && $barang->foto)
                    <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}">
                @else
                    <svg width="76" height="76" viewBox="0 0 24 24" fill="none" stroke="#818CF8" stroke-width="1.6">
                        <rect x="2" y="7" width="20" height="14" rx="2"/><circle cx="12" cy="14" r="3"/><path d="M12 3v4"/><path d="M8 3h8"/>
                    </svg>
                @endif
            </div>

            <div class="return-card-body">
                <h2 class="return-item-title">{{ $barang->nama_barang ?? 'Fasilitas' }}</h2>
                <div class="return-meta-stack">
                    <div class="meta-line">
                        <span>Kode Pinjam</span>
                        <strong>#{{ $peminjaman->kode_pinjam }}</strong>
                    </div>
                    <div class="meta-line">
                        <span>Kategori</span>
                        <strong>{{ $barang->kategori->nama_kategori ?? '-' }}</strong>
                    </div>
                    <div class="meta-line">
                        <span>Tanggal Pinjam</span>
                        <strong>{{ $peminjaman->tanggal_pinjam ? $peminjaman->tanggal_pinjam->format('d M Y') : '-' }}</strong>
                    </div>
                    <div class="meta-line">
                        <span>Rencana Kembali</span>
                        <strong>{{ $peminjaman->tanggal_kembali ? $peminjaman->tanggal_kembali->format('d M Y') : '-' }}</strong>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT PANEL: RETURN FORM -->
        <div class="return-form-vibe-card">
            <div class="form-header-box">
                <h1 class="form-header-title">Form Pengembalian 📦</h1>
                <p class="form-header-sub">Laporkan pengembalian barang dan rincian kondisi fisiknya secara jujur.</p>
            </div>

            <form method="POST" action="{{ route('user.pengembalian.store', $peminjaman->kode_pinjam) }}" enctype="multipart/form-data" id="form-pengembalian">
                @csrf

                <!-- TANGGAL PENGEMBALIAN -->
                <div class="form-group-vibe">
                    <label for="tanggal_kembali" class="label-vibe-bold">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect><line x1="16" y1="2" x2="16" y2="6"></line><line x1="8" y1="2" x2="8" y2="6"></line><line x1="3" y1="10" x2="21" y2="10"></line></svg>
                        <span>Tanggal Pengembalian Fisik</span>
                    </label>
                    <input type="date" id="tanggal_kembali" name="tanggal_kembali" class="input-vibe-control"
                           value="{{ old('tanggal_kembali', date('Y-m-d')) }}" required>
                    @error('tanggal_kembali')
                        <span style="font-size:12px; color:var(--badge-rose); display:block; margin-top:4px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- KONDISI BARANG KARTU PILIHAN -->
                <div class="form-group-vibe">
                    <label class="label-vibe-bold">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
                        <span>Kondisi Fisik Saat Dikembalikan</span>
                    </label>

                    <input type="hidden" name="kondisi_barang" id="kondisi_barang" value="{{ old('kondisi_barang', 'Baik') }}">

                    <div class="condition-cards-grid">
                        <div class="condition-option-box {{ old('kondisi_barang', 'Baik') == 'Baik' ? 'active' : '' }}" onclick="selectKondisi('Baik', this)">
                            <div class="cond-emoji">✨</div>
                            <div class="cond-title">Baik</div>
                            <div class="cond-desc">Mulus & Normal</div>
                        </div>

                        <div class="condition-option-box {{ old('kondisi_barang') == 'Kurang Baik' ? 'active' : '' }}" onclick="selectKondisi('Kurang Baik', this)">
                            <div class="cond-emoji">⚠️</div>
                            <div class="cond-title">Kurang Baik</div>
                            <div class="cond-desc">Ada lecet / cacat</div>
                        </div>

                        <div class="condition-option-box {{ old('kondisi_barang') == 'Rusak Berat' ? 'active' : '' }}" onclick="selectKondisi('Rusak Berat', this)">
                            <div class="cond-emoji">💥</div>
                            <div class="cond-title">Rusak Berat</div>
                            <div class="cond-desc">Perlu servis/ganti</div>
                        </div>
                    </div>

                    @error('kondisi_barang')
                        <span style="font-size:12px; color:var(--badge-rose); display:block; margin-top:4px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- UPLOAD BUKTI FOTO -->
                <div class="form-group-vibe">
                    <label class="label-vibe-bold">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></svg>
                        <span>Upload Foto Kondisi Barang</span>
                    </label>

                    <div class="dropzone-vibe-box" onclick="document.getElementById('bukti_foto').click()">
                        <div class="dropzone-icon-circle">
                            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
                                <polyline points="17 8 12 3 7 8"></polyline>
                                <line x1="12" y1="3" x2="12" y2="15"></line>
                            </svg>
                        </div>
                        <div style="font-size: 14px; font-weight: 800; color: var(--text-main); margin-bottom: 4px;" id="dropzone-label">
                            Pilih atau Seret Foto Fisik ke Sini 📸
                        </div>
                        <div style="font-size: 12.5px; color: var(--text-muted);">
                            Format JPG, PNG, atau WebP (Maksimal 5 MB)
                        </div>
                        <input type="file" id="bukti_foto" name="bukti_foto" accept="image/*" style="display: none;" onchange="previewUpload(this)">
                    </div>

                    <div class="preview-box-holder" id="preview-box">
                        <img id="img-preview" src="" alt="Preview Bukti">
                    </div>

                    @error('bukti_foto')
                        <span style="font-size:12px; color:var(--badge-rose); display:block; margin-top:4px;">{{ $message }}</span>
                    @enderror
                </div>

                <!-- CATATAN TAMBAHAN -->
                <div class="form-group-vibe">
                    <label for="catatan" class="label-vibe-bold">
                        <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline></svg>
                        <span>Catatan Tambahan (Opsional)</span>
                    </label>
                    <textarea id="catatan" name="catatan" class="input-vibe-control" rows="3"
                              placeholder="Rincian tambahan mengenai kelengkapan kabel, adaptor, atau kondisi barang...">{{ old('catatan') }}</textarea>
                </div>

                <button type="submit" class="btn-submit-return-vibe" id="btn-submit-return">
                    <span>Ajukan Pengembalian</span>
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"></polyline></svg>
                </button>

                <p style="font-size: 12px; color: var(--text-muted); text-align: center; margin-top: 14px;">
                    🛡️ Serahkan fisik barang secara langsung ke ruang Sarana Prasarana sekolah.
                </p>
            </form>
        </div>

    </div>

@endsection

@section('scripts')
<script>
    function selectKondisi(val, el) {
        document.getElementById('kondisi_barang').value = val;
        document.querySelectorAll('.condition-option-box').forEach(b => b.classList.remove('active'));
        el.classList.add('active');
    }

    function previewUpload(input) {
        const label = document.getElementById('dropzone-label');
        const box = document.getElementById('preview-box');
        const img = document.getElementById('img-preview');

        if (input.files && input.files[0]) {
            const file = input.files[0];
            label.textContent = '📸 ' + file.name;
            const reader = new FileReader();
            reader.onload = function(e) {
                img.src = e.target.result;
                box.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    }
</script>
@endsection
