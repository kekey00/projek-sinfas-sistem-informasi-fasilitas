<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>{{ $barang->nama_barang }} - SINFAS</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@500;600;700;800&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    :root{
        --navy-900:#16264F;
        --navy-800:#1B2F63;
        --indigo-600:#3B66C4;
        --indigo-500:#4A76D2;
        --indigo-100:#E8EEFC;
        --green-600:#16A34A;
        --red-600:#DC2626;
        --bg:#F4F6FB;
        --surface:#FFFFFF;
        --border:#E5E9F5;
        --text:#1B2333;
        --muted:#6B7280;
    }
    *{box-sizing:border-box;margin:0;padding:0;}
    html,body{height:100%;}
    body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);min-height:100vh;}
    .app{display:flex;min-height:100vh;}

    /* SIDEBAR (sama seperti dashboard) */
    .sidebar{
        width:250px;min-width:250px;
        background:linear-gradient(190deg,var(--indigo-500) 0%, var(--navy-800) 55%, var(--navy-900) 100%);
        padding:28px 18px;display:flex;flex-direction:column;color:#fff;
    }
    .brand{display:flex;align-items:center;gap:12px;padding:0 6px 26px;}
    .brand-avatar{
        width:42px;height:42px;border-radius:50%;background:rgba(255,255,255,.15);
        border:2px solid rgba(255,255,255,.5);display:flex;align-items:center;justify-content:center;
    }
    .brand-name{font-family:'Baloo 2',sans-serif;font-size:20px;font-weight:700;letter-spacing:.3px;}
    .nav{display:flex;flex-direction:column;gap:6px;}
    .nav-item{
        display:flex;align-items:center;gap:12px;padding:11px 14px;border-radius:12px;
        color:rgba(255,255,255,.82);text-decoration:none;font-family:'Baloo 2',sans-serif;
        font-weight:600;font-size:15px;border-left:3px solid transparent;
        transition:background .15s ease, color .15s ease;
    }
    .nav-item svg{width:20px;height:20px;stroke-width:2.1;flex-shrink:0;}
    .nav-item:hover{background:rgba(255,255,255,.08);color:#fff;}
    .nav-item.active{background:rgba(255,255,255,.14);color:#fff;border-left:3px solid #fff;}
    .nav-spacer{flex:1;}
    .nav-bottom{border-top:1px solid rgba(255,255,255,.15);padding-top:10px;margin-top:10px;}
    .nav-bottom button{
        all:unset;display:flex;align-items:center;gap:12px;width:100%;cursor:pointer;
        padding:11px 14px;border-radius:12px;color:rgba(255,255,255,.75);
        font-family:'Baloo 2',sans-serif;font-weight:600;font-size:15px;box-sizing:border-box;
    }
    .nav-bottom button:hover{background:rgba(255,255,255,.08);color:#fff;}
    .nav-bottom svg{width:20px;height:20px;stroke-width:2.1;flex-shrink:0;}

    /* MAIN */
    .main{flex:1;padding:26px 34px;display:flex;flex-direction:column;gap:20px;}

    .topbar{display:flex;align-items:center;gap:14px;}
    .back-link{
        display:flex;align-items:center;gap:6px;color:var(--indigo-600);text-decoration:none;
        font-family:'Baloo 2',sans-serif;font-weight:600;font-size:14px;
    }
    .back-link:hover{text-decoration:underline;}
    .back-link svg{width:16px;height:16px;}

    /* CONTENT SPLIT */
    .content{display:grid;grid-template-columns:1fr 1fr;gap:24px;align-items:start;}

    /* ITEM DETAIL PANEL */
    .item-panel{
        background:var(--surface);border:1.5px solid var(--border);border-radius:20px;
        padding:22px;box-shadow:0 8px 20px rgba(27,47,99,.06);
    }
    .item-photo{
        position:relative;width:100%;aspect-ratio:4/3;border-radius:16px;overflow:hidden;
        background:var(--indigo-100);display:flex;align-items:center;justify-content:center;margin-bottom:16px;
    }
    .item-photo img{width:100%;height:100%;object-fit:cover;}
    .badge{
        position:absolute;top:12px;left:12px;font-family:'Baloo 2',sans-serif;font-size:12px;font-weight:700;
        padding:5px 14px;border-radius:20px;color:#fff;background:var(--green-600);letter-spacing:.2px;
    }
    .item-name{font-family:'Baloo 2',sans-serif;font-size:22px;font-weight:700;margin-bottom:10px;}
    .item-meta{display:flex;flex-direction:column;gap:5px;margin-bottom:18px;}
    .item-meta div{font-size:13.5px;color:var(--muted);}
    .item-meta strong{color:var(--text);font-weight:600;}
    .item-desc-label{font-family:'Baloo 2',sans-serif;font-size:14px;font-weight:700;margin-bottom:6px;}
    .item-desc{font-size:13.5px;color:var(--muted);line-height:1.6;}

    /* FORM PANEL */
    .form-panel{
        background:var(--surface);border:1.5px solid var(--border);border-radius:20px;
        padding:26px;box-shadow:0 8px 20px rgba(27,47,99,.06);
    }
    .form-title{font-family:'Baloo 2',sans-serif;font-size:19px;font-weight:700;margin-bottom:4px;}
    .form-sub{font-size:13px;color:var(--muted);margin-bottom:20px;}
    .field{margin-bottom:16px;}
    .field label{display:block;font-size:13px;font-weight:600;color:var(--text);margin-bottom:6px;}
    .field input, .field textarea{
        width:100%;border:1.5px solid var(--border);border-radius:12px;padding:11px 14px;
        font-family:'Inter',sans-serif;font-size:13.5px;color:var(--text);outline:none;
        transition:border-color .15s ease, box-shadow .15s ease;
    }
    .field input:focus, .field textarea:focus{border-color:var(--indigo-600);box-shadow:0 0 0 3px var(--indigo-100);}
    .field textarea{resize:vertical;min-height:90px;}
    .field-row{display:flex;align-items:center;gap:12px;}
    .field-row input{max-width:110px;}
    .field-hint{font-size:12px;color:var(--muted);}

    .submit-btn{
        width:100%;background:var(--indigo-600);color:#fff;border:none;border-radius:12px;
        padding:13px;font-family:'Baloo 2',sans-serif;font-size:15px;font-weight:700;cursor:pointer;
        transition:opacity .15s ease;
    }
    .submit-btn:hover{opacity:.92;}
    .form-note{font-size:12px;color:var(--muted);text-align:center;margin-top:12px;}

    @media (max-width:900px){
        .content{grid-template-columns:1fr;}
    }
    @media (max-width:860px){
        .app{flex-direction:column;}
        .sidebar{width:100%;min-width:100%;flex-direction:row;align-items:center;padding:16px 18px;}
        .nav{flex-direction:row;}
        .nav-spacer{display:none;}
        .nav-bottom{border:none;margin:0;padding:0;}
    }
</style>
</head>
<body>

<div class="app">
    <aside class="sidebar">
        <div class="brand">
            <div class="brand-avatar">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2.1" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
            </div>
            <span class="brand-name">SINFAS</span>
        </div>

        <nav class="nav">
            <a href="{{ route('user.dashboard') }}" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
                </svg>
                <span>Beranda</span>
            </a>
            <a href="#" class="nav-item active">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                    <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
                </svg>
                <span>Ajukan Pinjam</span>
            </a>
            <a href="#" class="nav-item">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/>
                </svg>
                <span>Profil Saya</span>
            </a>
        </nav>

        <div class="nav-spacer"></div>

        <div class="nav-bottom">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/>
                        <polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
                    </svg>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </aside>

    <main class="main">
        <div class="topbar">
            <a href="{{ route('user.dashboard') }}" class="back-link" id="btn-kembali">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4"><polyline points="15 18 9 12 15 6"/></svg>
                Kembali ke Dashboard
            </a>
        </div>

        <div class="content">

            <!-- DETAIL BARANG -->
            <div class="item-panel">
                <div class="item-photo">
                    @php $tersedia = $barang->jumlah_baik > 0; @endphp
                    <span class="badge" style="background:{{ $tersedia ? '#0E5E2C' : '#8B1E1E' }}">
                        {{ $tersedia ? 'Tersedia' : 'Tidak Tersedia' }}
                    </span>
                    @if($barang->foto)
                        <img src="{{ asset('storage/' . $barang->foto) }}" alt="{{ $barang->nama_barang }}">
                    @else
                        @php $katNama = strtolower($barang->kategori->nama_kategori ?? ''); @endphp
                        @if(str_contains($barang->nama_barang,'Camera') || str_contains($barang->nama_barang,'Kamera'))
                            <svg width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="#3B66C4" stroke-width="1.4"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"/><circle cx="12" cy="13" r="4"/></svg>
                        @elseif(str_contains($barang->nama_barang,'Mikrofon') || str_contains($barang->nama_barang,'Mic'))
                            <svg width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="#3B66C4" stroke-width="1.4"><path d="M12 1a3 3 0 0 0-3 3v8a3 3 0 0 0 6 0V4a3 3 0 0 0-3-3z"/><path d="M19 10v2a7 7 0 0 1-14 0v-2"/><line x1="12" y1="19" x2="12" y2="23"/><line x1="8" y1="23" x2="16" y2="23"/></svg>
                        @elseif(str_contains($barang->nama_barang,'Proyektor'))
                            <svg width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="#3B66C4" stroke-width="1.4"><rect x="2" y="7" width="20" height="14" rx="2"/><circle cx="12" cy="14" r="3"/><path d="M12 3v4"/><path d="M8 3h8"/></svg>
                        @elseif(str_contains($barang->nama_barang,'Laptop'))
                            <svg width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="#3B66C4" stroke-width="1.4"><rect x="2" y="3" width="20" height="14" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg>
                        @else
                            <svg width="90" height="90" viewBox="0 0 24 24" fill="none" stroke="#3B66C4" stroke-width="1.4"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/></svg>
                        @endif
                    @endif
                </div>
                <h1 class="item-name" id="barang-nama">{{ $barang->nama_barang }}</h1>
                <div class="item-meta">
                    <div>Kategori &nbsp;&nbsp;: <strong>{{ $barang->kategori->nama_kategori ?? '-' }}</strong></div>
                    <div>Kondisi &nbsp;&nbsp;&nbsp;&nbsp; : <strong>{{ $barang->kondisi ?? 'Baik' }}</strong></div>
                    <div>Stok Tersedia : <strong>{{ $barang->jumlah_baik }} unit baik</strong></div>
                    @if($barang->merk_model)<div>Merk/Model : <strong>{{ $barang->merk_model }}</strong></div>@endif
                </div>
                @if($barang->keterangan)
                    <div class="item-desc-label">Deskripsi</div>
                    <p class="item-desc">{{ $barang->keterangan }}</p>
                @endif
            </div>

            <!-- FORM PENGAJUAN -->
            <div class="form-panel">
                <div class="form-title">Formulir Pengajuan Peminjaman</div>
                <div class="form-sub">Lengkapi data di bawah ini untuk mengajukan peminjaman barang.</div>

                @if(!$tersedia)
                    <div style="text-align:center;padding:30px 0;">
                        <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="#EF4444" stroke-width="1.5" style="margin:0 auto 12px;display:block;">
                            <circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/>
                        </svg>
                        <p style="font-family:'Baloo 2',sans-serif;font-size:16px;font-weight:700;color:#DC2626;margin-bottom:8px;">Barang Tidak Tersedia</p>
                        <p style="font-size:13px;color:#64748B;">Barang ini sedang tidak tersedia untuk dipinjam.</p>
                        <a href="{{ route('user.dashboard') }}" style="display:inline-block;margin-top:16px;padding:10px 24px;background:#3B66C4;color:#fff;border-radius:10px;text-decoration:none;font-family:'Baloo 2',sans-serif;font-weight:700;font-size:14px;">
                            ← Kembali ke Dashboard
                        </a>
                    </div>
                @else
                    <form method="POST" action="{{ route('user.peminjaman.store') }}" id="form-pengajuan">
                        @csrf
                        <input type="hidden" name="kode_barang" value="{{ $barang->kode_barang }}">

                        @error('stok')
                            <div style="background:#FEE2E2;border:1.5px solid #EF4444;border-radius:10px;padding:12px 16px;margin-bottom:16px;font-size:13px;color:#991B1B;">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="field">
                            <label for="tanggal_pinjam">Tanggal Pinjam</label>
                            <input type="date" id="tanggal_pinjam" name="tanggal_pinjam" value="{{ old('tanggal_pinjam') }}" min="{{ date('Y-m-d') }}" required {{ $errors->has('tanggal_pinjam') ? 'style=border-color:#DC2626' : '' }}>
                            @error('tanggal_pinjam')<span style="font-size:12px;color:#DC2626;display:block;margin-top:4px;">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label for="tanggal_kembali">Rencana Tanggal Kembali</label>
                            <input type="date" id="tanggal_kembali" name="tanggal_kembali" value="{{ old('tanggal_kembali') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" required {{ $errors->has('tanggal_kembali') ? 'style=border-color:#DC2626' : '' }}>
                            @error('tanggal_kembali')<span style="font-size:12px;color:#DC2626;display:block;margin-top:4px;">{{ $message }}</span>@enderror
                        </div>
                        <div class="field">
                            <label for="keterangan_penggunaan">Tujuan / Alasan Peminjaman</label>
                            <textarea id="keterangan_penggunaan" name="keterangan_penggunaan" placeholder="Contoh: Dokumentasi acara sekolah tanggal 15 September" required>{{ old('keterangan_penggunaan') }}</textarea>
                            @error('keterangan_penggunaan')<span style="font-size:12px;color:#DC2626;display:block;margin-top:4px;">{{ $message }}</span>@enderror
                        </div>

                        <button class="submit-btn" type="submit" id="btn-kirim-pengajuan">Kirim Pengajuan Pinjaman</button>
                        <p class="form-note">Catatan: Pengajuan pinjaman memerlukan persetujuan admin.</p>
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
                if (tglKembali.value && tglKembali.value <= this.value) tglKembali.value = minKembali;
            }
        });
    }
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