<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Laporan Sarana Prasarana') - SINFAS</title>
    <style>
        @page {
            margin: 24px 28px 24px 28px;
        }
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #1E293B;
            font-size: 9.5px;
            line-height: 1.4;
            background: #FFFFFF;
        }

        /* ─── KOP SURAT RESMI ─── */
        .kop-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 0;
        }
        .kop-table td {
            border: none;
            padding: 0;
            vertical-align: middle;
        }
        .kop-logo-cell {
            width: 54px;
            vertical-align: middle;
        }
        .kop-logo-img {
            width: 50px;
            height: 50px;
            display: block;
        }
        .kop-text-center {
            text-align: center;
            padding: 0 12px;
            vertical-align: middle;
        }
        .kop-instansi {
            font-size: 8.5px;
            font-weight: 700;
            color: #475569;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }
        .kop-sekolah {
            font-size: 17px;
            font-weight: 800;
            color: #121358;
            letter-spacing: 0.5px;
            margin: 2px 0 3px 0;
            text-transform: uppercase;
        }
        .kop-unit {
            font-size: 10.5px;
            font-weight: 700;
            color: #232F72;
            letter-spacing: 0.4px;
            text-transform: uppercase;
        }
        .kop-side-badge {
            width: 80px;
            text-align: right;
            vertical-align: middle;
        }
        .side-pill {
            display: inline-block;
            padding: 5px 8px;
            background: #F0F4FA;
            border: 1px solid #CBD5E1;
            border-radius: 6px;
            font-size: 7.5px;
            font-weight: 700;
            color: #232F72;
            text-align: center;
            line-height: 1.25;
        }

        /* ─── GARIS KOP GANDA ─── */
        .kop-divider-thick {
            height: 2.5px;
            background: #121358;
            margin-top: 8px;
        }
        .kop-divider-thin {
            height: 0.8px;
            background: #2F578A;
            margin-top: 1.5px;
            margin-bottom: 12px;
        }

        /* ─── JUDUL LAPORAN ─── */
        .doc-header {
            text-align: center;
            margin-bottom: 12px;
        }
        .doc-title {
            font-size: 14px;
            font-weight: 800;
            color: #121358;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }
        .doc-subtitle {
            font-size: 9px;
            color: #64748B;
            margin-top: 3px;
            font-style: italic;
        }

        /* ─── META INFO BOX ─── */
        .meta-table {
            width: 100%;
            border-collapse: collapse;
            background: #F8FAFC;
            border: 1px solid #E2E8F0;
            border-radius: 6px;
            margin-bottom: 12px;
        }
        .meta-table td {
            padding: 6px 12px;
            font-size: 8.5px;
            color: #334155;
            border: none;
        }
        .meta-label {
            color: #64748B;
        }
        .meta-value {
            font-weight: 700;
            color: #0F172A;
        }

        /* ─── RINGKASAN / SUMMARY CARDS ─── */
        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
            margin-left: -8px;
            margin-right: -8px;
            margin-bottom: 12px;
        }
        .summary-card {
            background: #FFFFFF;
            border: 1px solid #E2E8F0;
            border-top: 3px solid #232F72;
            border-radius: 6px;
            padding: 6px 10px;
            vertical-align: top;
        }
        .summary-card.primary { border-top-color: #121358; }
        .summary-card.danger { border-top-color: #DC2626; }
        .summary-card.success { border-top-color: #16A34A; }
        .summary-card.warning { border-top-color: #D97706; }
        .summary-card.info { border-top-color: #2F578A; }

        .sc-label {
            font-size: 7.5px;
            font-weight: 700;
            color: #64748B;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        .sc-value {
            font-size: 15px;
            font-weight: 800;
            line-height: 1.2;
            color: #0F172A;
        }
        .sc-unit {
            font-size: 8.5px;
            font-weight: 500;
            color: #64748B;
            margin-left: 2px;
        }

        /* ─── TABEL DATA UTAMA ─── */
        .report-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9px;
            margin-bottom: 14px;
        }
        .report-table th {
            background: #121358;
            color: #FFFFFF;
            font-weight: 700;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 7px 8px;
            border: 1px solid #121358;
            vertical-align: middle;
        }
        .report-table th.center, .report-table td.center {
            text-align: center;
        }
        .report-table th.right, .report-table td.right {
            text-align: right;
        }
        .report-table td {
            padding: 6px 8px;
            border: 1px solid #E2E8F0;
            color: #334155;
            vertical-align: middle;
        }
        .report-table tbody tr:nth-child(even) td {
            background-color: #F8FAFC;
        }
        .report-table tr.total-row td {
            background: #F1F5F9;
            font-weight: 800;
            color: #0F172A;
            border-top: 2px solid #CBD5E1;
        }

        /* ─── STATUS BADGES ─── */
        .badge {
            display: inline-block;
            padding: 2.5px 7px;
            border-radius: 4px;
            font-size: 8px;
            font-weight: 700;
            line-height: 1.1;
            text-align: center;
        }
        .badge-danger {
            background: #FEE2E2;
            color: #991B1B;
            border: 1px solid #FCA5A5;
        }
        .badge-success {
            background: #DCFCE7;
            color: #166534;
            border: 1px solid #86EFAC;
        }
        .badge-warning {
            background: #FEF3C7;
            color: #92400E;
            border: 1px solid #FCD34D;
        }
        .badge-info {
            background: #DBEAFE;
            color: #1E40AF;
            border: 1px solid #93C5FD;
        }
        .badge-neutral {
            background: #F1F5F9;
            color: #475569;
            border: 1px solid #CBD5E1;
        }

        /* ─── BAGIAN PENGESAHAN / TANDA TANGAN ─── */
        .signature-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            page-break-inside: avoid;
        }
        .signature-table td {
            border: none;
            padding: 0;
            vertical-align: top;
            font-size: 9px;
            color: #1E293B;
        }
        .sig-col-left {
            width: 50%;
            text-align: left;
        }
        .sig-col-right {
            width: 50%;
            text-align: right;
        }
        .sig-box {
            display: inline-block;
            text-align: left;
            min-width: 200px;
        }
        .sig-date {
            margin-bottom: 2px;
            color: #475569;
            height: 14px;
            line-height: 14px;
        }
        .sig-role {
            font-weight: 700;
            color: #0F172A;
            margin-bottom: 45px;
        }
        .sig-name {
            font-weight: 700;
            text-decoration: underline;
            color: #0F172A;
        }
        .sig-nip {
            font-size: 8px;
            color: #64748B;
            margin-top: 2px;
        }

        /* ─── FOOTER ─── */
        .doc-footer {
            width: 100%;
            margin-top: 14px;
            padding-top: 6px;
            border-top: 0.8px dashed #CBD5E1;
        }
        .doc-footer table {
            width: 100%;
            border-collapse: collapse;
        }
        .doc-footer td {
            border: none;
            padding: 0;
            font-size: 7.5px;
            color: #94A3B8;
        }

        .empty-cell {
            text-align: center;
            padding: 24px 10px !important;
            color: #64748B;
            font-style: italic;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo-cell">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/sinfas-logo.png'))) }}" class="kop-logo-img" alt="Logo SINFAS">
            </td>
            <td class="kop-text-center">
                <div class="kop-instansi">Sistem Informasi Pengelolaan Fasilitas Sekolah</div>
                <div class="kop-sekolah">SMK SINFAS TERPADU</div>
                <div class="kop-unit">UNIT KERJA SARANA DAN PRASARANA SEKOLAH</div>
            </td>
            <td class="kop-side-badge">
                <div class="side-pill">
                    DOKUMEN RESMI<br>
                    <strong style="color: #121358;">SINFAS-SARPRAS</strong>
                </div>
            </td>
        </tr>
    </table>
    <div class="kop-divider-thick"></div>
    <div class="kop-divider-thin"></div>

    <!-- JUDUL LAPORAN -->
    <div class="doc-header">
        <div class="doc-title">@yield('doc_title')</div>
        <div class="doc-subtitle">@yield('doc_subtitle')</div>
    </div>

    <!-- META INFO DOKUMEN -->
    <table class="meta-table">
        <tr>
            <td style="width: 55%;">
                <span class="meta-label">Periode Laporan:</span>
                <span class="meta-value">
                    @if(isset($tanggalMulai) && isset($tanggalAkhir))
                        {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }} s.d. {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') }}
                    @else
                        Semua Periode / Posisi Terkini
                    @endif
                </span>
            </td>
            <td style="width: 45%; text-align: right;">
                <span class="meta-label">Waktu Cetak:</span>
                <span class="meta-value">{{ now()->format('d/m/Y H:i') }} WIB</span>
                &nbsp;|&nbsp;
                <span class="meta-label">Otoritas:</span>
                <span class="meta-value" style="color: #121358;">Staf Sarana</span>
            </td>
        </tr>
    </table>

    <!-- KONTEN LAPORAN & RINGKASAN -->
    @yield('content')

    <!-- PENGESAHAN / TANDA TANGAN -->
    <table class="signature-table">
        <tr>
            <td class="sig-col-left">
                <div class="sig-box">
                    <div class="sig-date">&nbsp;</div>
                    <div class="sig-role">Mengetahui,<br>Kepala Sekolah SMK SINFAS</div>
                    <div class="sig-name">Drs. H. Mulyadi, M.Pd.</div>
                    <div class="sig-nip">NIP. 19780512 200501 1 004</div>
                </div>
            </td>
            <td class="sig-col-right">
                <div class="sig-box">
                    <div class="sig-date">Bandung, {{ now()->format('d/m/Y') }}</div>
                    <div class="sig-role">Penanggung Jawab Sarpras,<br>Staf Pengelola Fasilitas</div>
                    <div class="sig-name">{{ auth()->user()->nama ?? 'Administrator Sarpras' }}</div>
                    <div class="sig-nip">NIP/ID: {{ auth()->user()->nip ?? auth()->user()->username ?? 'STF-SARPRAS-01' }}</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- FOOTER RESMI -->
    <div class="doc-footer">
        <table>
            <tr>
                <td style="text-align: left;">
                    Dokumen resmi yang dihasilkan secara otomatis oleh <strong>SINFAS (Sistem Informasi Fasilitas)</strong>.
                </td>
                <td style="text-align: right;">
                    Halaman 1 &bull; Validitas Terverifikasi Sistem
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
