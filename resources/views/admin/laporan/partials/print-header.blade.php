<div class="print-only print-document-header">
    <table class="print-kop-table">
        <tr>
            <td style="width: 54px; vertical-align: middle;">
                @if(file_exists(public_path('images/sinfas-logo.png')))
                    <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('images/sinfas-logo.png'))) }}" width="50" height="50" alt="Logo SINFAS" style="display: block; object-fit: contain;">
                @else
                    <img src="{{ asset('images/sinfas-logo.png') }}" width="50" height="50" alt="Logo SINFAS" style="display: block; object-fit: contain;">
                @endif
            </td>
            <td class="print-kop-center">
                <div class="print-kop-instansi">Sistem Informasi Pengelolaan Fasilitas Sekolah</div>
                <div class="print-kop-sekolah">SMK SINFAS TERPADU</div>
                <div class="print-kop-unit">UNIT KERJA SARANA DAN PRASARANA SEKOLAH</div>
            </td>
            <td style="width: 80px; text-align: right; vertical-align: middle;">
                <div class="print-side-badge">
                    DOKUMEN RESMI<br>
                    <strong style="color: #121358;">SINFAS-SARPRAS</strong>
                </div>
            </td>
        </tr>
    </table>
    <div class="print-kop-divider-thick"></div>
    <div class="print-kop-divider-thin"></div>

    <div class="print-doc-title-wrap">
        <div class="print-doc-title">{{ $docTitle ?? 'LAPORAN SARANA DAN PRASARANA' }}</div>
        <div class="print-doc-subtitle">{{ $docSubtitle ?? 'Dokumen Resmi Pengelolaan dan Pengawasan Sarana Prasarana Sekolah' }}</div>
    </div>

    <table class="print-meta-table">
        <tr>
            <td style="width: 55%;">
                <span class="print-meta-label">Periode Laporan:</span>
                <span class="print-meta-value">
                    @if(isset($tanggalMulai) && isset($tanggalAkhir))
                        {{ \Carbon\Carbon::parse($tanggalMulai)->format('d/m/Y') }} s.d. {{ \Carbon\Carbon::parse($tanggalAkhir)->format('d/m/Y') }}
                    @else
                        Semua Periode / Posisi Terkini
                    @endif
                </span>
            </td>
            <td style="width: 45%; text-align: right;">
                <span class="print-meta-label">Waktu Cetak:</span>
                <span class="print-meta-value">{{ now()->format('d/m/Y H:i') }} WIB</span>
                &nbsp;|&nbsp;
                <span class="print-meta-label">Otoritas:</span>
                <span class="print-meta-value" style="color: #121358;">Staf Sarana</span>
            </td>
        </tr>
    </table>
</div>
