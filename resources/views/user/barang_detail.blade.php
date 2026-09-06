<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Barang / Pengajuan Peminjaman - SINFAS</title>
    <meta name="description" content="Detail barang dan formulir pengajuan peminjaman - SINFAS">

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
        .page-card {
            display: flex;
            flex-direction: row;
            width: 100%;
            max-width: 1280px;
            background: #FFF;
            border: 3.5px solid #3B66C4;
            border-radius: 28px;
            box-shadow: 0 16px 40px rgba(44,74,124,.22);
            min-height: 750px;
            overflow: hidden;
        }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 230px; min-width: 230px;
            background: linear-gradient(180deg,#4673CE 0%,#375FB7 45%,#254790 100%);
            padding: 26px 20px;
            display: flex; flex-direction: column;
            justify-content: space-between;
            color: #FFF; border-right: 3px solid #3B66C4;
        }
        .brand-header { display:flex;align-items:center;gap:12px;padding-bottom:24px; }
        .brand-avatar {
            width:44px;height:44px;border-radius:50%;
            background:#D1D5DB;border:2px solid #FFF;
            display:flex;align-items:center;justify-content:center;
            box-shadow:0 3px 8px rgba(0,0,0,.15);
        }
        .brand-title {
            font-family:'Gorditas',cursive;font-size:22px;font-weight:700;
            color:#FFF;letter-spacing:1px;text-shadow:1px 1px 2px rgba(0,0,0,.25);
        }
        .nav-list { display:flex;flex-direction:column;gap:16px;list-style:none;margin-top:10px; }
        .nav-link {
            font-family:'Gorditas',cursive;font-size:16px;color:#FFF;text-decoration:none;
            display:flex;align-items:center;gap:12px;
            padding:10px 14px;border-radius:12px;transition:all .2s ease;
        }
        .nav-link:hover { background:rgba(255,255,255,.18);transform:translateX(4px); }
        .nav-icon { width:22px;height:22px;stroke-width:2.3;flex-shrink:0; }
        .nav-logout { margin-top:auto;padding-top:20px; }

        /* ── MAIN CONTENT ── */
        .main-content {
            flex:1; padding: 30px 34px;
            display: flex; flex-direction: column; gap: 0;
            overflow-y: auto;
            background: linear-gradient(160deg, #3C68C8 0%, #2A4FA0 40%, #1E3A78 100%);
        }

        /* Breadcrumb / Back button */
        .back-btn {
            display: inline-flex; align-items: center; gap: 6px;
            color: rgba(255,255,255,.85);
            font-family: 'Gorditas', cursive;
            font-size: 14px; text-decoration: none;
            margin-bottom: 20px;
            transition: color .2s ease;
        }
        .back-btn:hover { color: #FFF; }

        /* ── TWO-COLUMN LAYOUT ── */
        .detail-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px;
            align-items: start;
        }

        /* ── LEFT PANEL (Barang Info) ── */
        .left-panel {
            display: flex; flex-direction: column; gap: 18px;
        }

        /* Foto barang */
        .barang-foto-box {
            background: linear-gradient(135deg, #C7D7FA, #A8C4F8);
            border: 2.5px solid #3B66C4;
            border-radius: 20px;
            display: flex; align-items: center; justify-content: center;
            min-height: 220px; padding: 20px;
            position: relative;
            box-shadow: 0 8px 24px rgba(0,0,0,.18);
            overflow: hidden;
        }
        .barang-foto-box img {
            max-width: 100%; max-height: 200px;
            object-fit: contain;
            filter: drop-shadow(0 8px 16px rgba(0,0,0,.25));
        }
        .barang-foto-icon {
            width: 120px; height: 120px;
            display: flex; align-items: center; justify-content: center;
            color: #3B66C4;
        }

        /* Status badge (di dalam foto) */
        .foto-status {
            position: absolute; bottom: 16px; left: 50%; transform: translateX(-50%);
            padding: 6px 24px; border-radius: 30px;
            font-family: 'Gorditas', cursive; font-size: 16px; font-weight: 700;
            color: #FFF; letter-spacing: .5px;
            border: 2px solid #FFF;
            box-shadow: 0 4px 12px rgba(0,0,0,.25);
        }
        .foto-status.available { background: #0E5E2C; }
        .foto-status.unavailable { background: #8C1C1C; }

        /* Info barang */
        .barang-info-card {
            background: rgba(255,255,255,.1);
            border: 1.5px solid rgba(255,255,255,.2);
            border-radius: 16px; padding: 20px 22px;
            backdrop-filter: blur(8px);
        }
        .barang-nama {
            font-family: 'Gorditas', cursive;
            font-size: 22px; font-weight: 700;
            color: #FFF; margin-bottom: 10px;
            text-shadow: 1px 1px 3px rgba(0,0,0,.3);
        }
        .barang-meta {
            font-size: 13px; color: rgba(255,255,255,.85);
            line-height: 1.9;
        }
        .barang-meta strong { color: #FFF; }
        .deskripsi-label {
            font-family: 'Gorditas', cursive;
            font-size: 15px; color: #FFF;
            margin: 14px 0 6px;
        }
        .deskripsi-text {
            font-size: 13px; color: rgba(255,255,255,.8);
            line-height: 1.7;
        }

        /* ── RIGHT PANEL (Form) ── */
        .right-panel {
            background: #F0F4FF;
            border: 2.5px solid #3B66C4;
            border-radius: 20px; padding: 28px 30px;
            box-shadow: 0 8px 24px rgba(0,0,0,.18);
        }

        .form-title {
            font-family: 'Gorditas', cursive;
            font-size: 22px; font-weight: 700;
            color: #1E3A75; text-align: center;
            margin-bottom: 24px;
            text-shadow: 1px 1px 2px rgba(0,0,0,.1);
        }

        /* Form group */
        .form-group { margin-bottom: 18px; }
        .form-label {
            display: block;
            font-size: 13.5px; font-weight: 600;
            color: #374151; margin-bottom: 7px;
        }
        .form-control {
            width: 100%;
            background: #FFF;
            border: 2px solid #B8CCEE;
            border-radius: 10px;
            padding: 11px 14px;
            font-family: 'Poppins', sans-serif;
            font-size: 13.5px; color: #1E293B;
            outline: none; transition: border-color .2s ease, box-shadow .2s ease;
        }
        .form-control:focus {
            border-color: #3B66C4;
            box-shadow: 0 0 0 3px rgba(59,102,196,.15);
        }
        textarea.form-control { resize: vertical; min-height: 110px; }

        /* Error messages */
        .error-msg {
            font-size: 12px; color: #DC2626;
            margin-top: 5px; display: block;
        }
        .form-control.is-error { border-color: #DC2626; }

        /* Submit Button */
        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #3B66C4, #1E3A75);
            border: none; border-radius: 12px;
            padding: 14px;
            font-family: 'Gorditas', cursive;
            font-size: 16px; font-weight: 700;
            color: #FFF; cursor: pointer;
            letter-spacing: .5px;
            transition: all .25s ease;
            box-shadow: 0 6px 18px rgba(30,58,117,.35);
            margin-top: 6px;
        }
        .submit-btn:hover {
            background: linear-gradient(135deg, #2D54A8, #152D60);
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(30,58,117,.45);
        }
        .submit-btn:active { transform: translateY(0); }
        .submit-btn:disabled { opacity:.6; cursor:not-allowed; transform:none; }

        /* Catatan */
        .form-note {
            font-size: 12px; color: #64748B;
            margin-top: 12px; text-align: center;
            line-height: 1.5;
        }

        /* Stok info */
        .stok-info {
            display: flex; gap: 10px; flex-wrap: wrap;
            margin-bottom: 18px;
        }
        .stok-badge {
            padding: 4px 12px; border-radius: 20px;
            font-size: 12px; font-weight: 600;
            border: 1.5px solid;
        }
        .stok-baik { background:#D1FAE5;color:#065F46;border-color:#10B981; }
        .stok-kurang { background:#FEF3C7;color:#92400E;border-color:#F59E0B; }
        .stok-rusak { background:#FEE2E2;color:#991B1B;border-color:#EF4444; }

        /* ── RESPONSIVE ── */
        @media (max-width: 900px) {
            .detail-layout { grid-template-columns: 1fr; }
        }
        @media (max-width: 768px) {
            .page-card { flex-direction: column; }
            .sidebar { width:100%;min-width:100%;border-right:none;border-bottom:3px solid #3B66C4; }
        }
    </style>
</head>
<body>

<div class="page-card">

    <!-- ═══════════════════ SIDEBAR ═══════════════════ -->
    <aside class="sidebar">
        <div>
            <div class="brand-header">
                <div class="brand-avatar">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#3B66C4" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                    </svg>
                </div>
                <span class="brand-title">SINFAS</span>
            </div>
            <ul class="nav-list">
                <li>
                    <a href="{{ route('user.dashboard') }}" class="nav-link" id="nav-home">
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

        <!-- Back Button -->
        <a href="{{ route('user.dashboard') }}" class="back-btn" id="btn-kembali">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <polyline points="15 18 9 12 15 6"/>
            </svg>
            Kembali
        </a>

        <div class="detail-layout">

            <!-- ── LEFT: Info Barang ── -->
            <div class="left-panel">

                <!-- Foto Barang -->
                <div class="barang-foto-box" id="barang-foto-box">
                    @if($barang->foto)
                        <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}" id="barang-foto">
                    @else
                        <div class="barang-foto-icon">
                            @php $katNama = strtolower($barang->kategori->nama_kategori ?? ''); @endphp
                            @if(str_contains($barang->nama_barang,'Camera') || str_contains($barang->nama_barang,'Kamera'))
                                <svg width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                            @elseif(str_contains($barang->nama_barang,'Mikrofon') || str_contains($barang->nama_barang,'Mic'))
                                <svg width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="23"/><line x1="8" y1="23" x2="16" y2="23"/></svg>
                            @elseif(str_contains($barang->nama_barang,'Proyektor'))
                                <svg width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="7" width="20" height="14" rx="2"/><circle cx="12" cy="14" r="3"/><path d="M12 3v4"/><path d="M8 3h8"/></svg>
                            @elseif(str_contains($barang->nama_barang,'HT') || str_contains($barang->nama_barang,'Handy'))
                                <svg width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.69 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.6 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.29 6.29l.91-.91a2 2 0 0 1 2.11-.45c.907.339 1.85.573 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            @elseif(str_contains($barang->nama_barang,'Laptop'))
                                <svg width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                            @elseif(str_contains($barang->nama_barang,'Speaker'))
                                <svg width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="4" y="2" width="16" height="20" rx="2"/><circle cx="12" cy="14" r="4"/><line x1="12" y1="6" x2="12.01" y2="6"/></svg>
                            @else
                                <svg width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                            @endif
                        </div>
                    @endif

                    <!-- Status overlay -->
                    @php $tersedia = $barang->jumlah_baik > 0; @endphp
                    <div class="foto-status {{ $tersedia ? 'available' : 'unavailable' }}">
                        {{ $tersedia ? 'Tersedia' : 'Tidak Tersedia' }}
                    </div>
                </div>

                <!-- Info Card -->
                <div class="barang-info-card">
                    <h1 class="barang-nama" id="barang-nama">{{ $barang->nama_barang }}</h1>

                    <!-- Stok badges -->
                    <div class="stok-info">
                        @if($barang->jumlah_baik > 0)
                            <span class="stok-badge stok-baik">✓ {{ $barang->jumlah_baik }} Baik</span>
                        @endif
                        @if($barang->jumlah_kurang_baik > 0)
                            <span class="stok-badge stok-kurang">⚠ {{ $barang->jumlah_kurang_baik }} Kurang Baik</span>
                        @endif
                        @if($barang->jumlah_rusak_berat > 0)
                            <span class="stok-badge stok-rusak">✗ {{ $barang->jumlah_rusak_berat }} Rusak Berat</span>
                        @endif
                    </div>

                    <div class="barang-meta">
                        <div><strong>Kategori</strong> : {{ $barang->kategori->nama_kategori ?? '-' }}</div>
                        <div><strong>Kondisi &nbsp;&nbsp;</strong> : {{ $barang->kondisi ?? 'Baik' }}</div>
                        @if($barang->merk_model)
                            <div><strong>Merk/Model</strong> : {{ $barang->merk_model }}</div>
                        @endif
                        @if($barang->tahun_pembelian)
                            <div><strong>Tahun</strong> : {{ $barang->tahun_pembelian }}</div>
                        @endif
                    </div>

                    @if($barang->keterangan)
                        <p class="deskripsi-label">Deskripsi</p>
                        <p class="deskripsi-text" id="barang-deskripsi">{{ $barang->keterangan }}</p>
                    @endif
                </div>
            </div>

            <!-- ── RIGHT: Formulir Pengajuan ── -->
            <div class="right-panel" id="form-pinjam">
                <h2 class="form-title">Formulir Pengajuan Pinjaman</h2>

                @if(!$tersedia)
                    <div style="text-align:center;padding:30px 0;color:#64748B;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="1.5" style="margin:0 auto 12px;display:block;">
                            <circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                        </svg>
                        <p style="font-family:'Gorditas',cursive;font-size:16px;color:#DC2626;margin-bottom:8px;">Barang Tidak Tersedia</p>
                        <p style="font-size:13px;">Maaf, barang ini sedang tidak tersedia untuk dipinjam saat ini.</p>
                    </div>
                @else
                    <form method="POST" action="{{ route('user.peminjaman.store') }}" id="form-pengajuan">
                        @csrf

                        <!-- Hidden: kode barang -->
                        <input type="hidden" name="kode_barang" value="{{ $barang->kode_barang }}">

                        <!-- Tanggal Pinjam -->
                        <div class="form-group">
                            <label class="form-label" for="tanggal_pinjam">Tanggal Pinjam</label>
                            <input
                                type="date"
                                id="tanggal_pinjam"
                                name="tanggal_pinjam"
                                class="form-control {{ $errors->has('tanggal_pinjam') ? 'is-error' : '' }}"
                                value="{{ old('tanggal_pinjam') }}"
                                min="{{ date('Y-m-d') }}"
                                required
                            >
                            @error('tanggal_pinjam')
                                <span class="error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Rencana Tanggal Kembali -->
                        <div class="form-group">
                            <label class="form-label" for="tanggal_kembali">Rencana Tanggal Kembali</label>
                            <input
                                type="date"
                                id="tanggal_kembali"
                                name="tanggal_kembali"
                                class="form-control {{ $errors->has('tanggal_kembali') ? 'is-error' : '' }}"
                                value="{{ old('tanggal_kembali') }}"
                                min="{{ date('Y-m-d', strtotime('+1 day')) }}"
                                required
                            >
                            @error('tanggal_kembali')
                                <span class="error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Tujuan / Alasan Peminjaman -->
                        <div class="form-group">
                            <label class="form-label" for="keterangan_penggunaan">Tujuan / Alasan Peminjaman</label>
                            <textarea
                                id="keterangan_penggunaan"
                                name="keterangan_penggunaan"
                                class="form-control {{ $errors->has('keterangan_penggunaan') ? 'is-error' : '' }}"
                                placeholder="Contoh: Digunakan untuk kegiatan dokumentasi lomba sains tanggal 10 September 2026..."
                                required
                            >{{ old('keterangan_penggunaan') }}</textarea>
                            @error('keterangan_penggunaan')
                                <span class="error-msg">{{ $message }}</span>
                            @enderror
                        </div>

                        @error('stok')
                            <div style="background:#FEE2E2;border:1.5px solid #EF4444;border-radius:10px;padding:12px 16px;margin-bottom:16px;font-size:13px;color:#991B1B;">
                                {{ $message }}
                            </div>
                        @enderror

                        <!-- Submit -->
                        <button type="submit" class="submit-btn" id="btn-kirim-pengajuan">
                            Kirim Pengajuan Pinjaman
                        </button>

                        <p class="form-note">
                            Catatan: Pengajuan pinjaman memerlukan persetujuan admin.
                        </p>
                    </form>
                @endif
            </div>

        </div>
    </main>
</div>

<script>
    // Pastikan tanggal kembali selalu setelah tanggal pinjam
    const tglPinjam = document.getElementById('tanggal_pinjam');
    const tglKembali = document.getElementById('tanggal_kembali');

    if (tglPinjam && tglKembali) {
        tglPinjam.addEventListener('change', function () {
            if (this.value) {
                const nextDay = new Date(this.value);
                nextDay.setDate(nextDay.getDate() + 1);
                const minKembali = nextDay.toISOString().split('T')[0];
                tglKembali.min = minKembali;
                if (tglKembali.value && tglKembali.value <= this.value) {
                    tglKembali.value = minKembali;
                }
            }
        });
    }

    // Loading state pada tombol submit
    const form = document.getElementById('form-pengajuan');
    const btnKirim = document.getElementById('btn-kirim-pengajuan');
    if (form && btnKirim) {
        form.addEventListener('submit', function () {
            btnKirim.disabled = true;
            btnKirim.textContent = 'Mengirim...';
        });
    }
</script>

</body>
</html>
