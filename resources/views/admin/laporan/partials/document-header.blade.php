<header class="report-document-heading">
    <div class="document-school-brand">
        @include('components.sinfas-logo', ['class' => 'document-school-logo', 'style' => 'width: 54px; height: 54px; object-fit: contain;'])
        <div class="document-school-name">
            <strong>SMK SINFAS</strong>
            <span>Sistem Informasi Fasilitas</span>
            <span>Bagian Sarana dan Prasarana</span>
        </div>
    </div>
    <div class="document-heading-content">
        <div class="document-number">LAPORAN {{ $documentNumber }}</div>
        <h2 class="report-title">{{ $documentTitle }}</h2>
        <p class="report-subtitle">{{ $documentDescription }}</p>
    </div>
    <dl class="document-metadata">
        <div><dt>Nomor Dokumen</dt><dd>SINFAS/SPR/{{ $documentNumber }}/{{ now()->format('Y') }}</dd></div>
        <div><dt>Periode Laporan</dt><dd>{{ $tanggalMulai }} sampai {{ $tanggalAkhir }}</dd></div>
        <div><dt>Tanggal Cetak</dt><dd>{{ now()->format('d/m/Y H:i') }}</dd></div>
    </dl>
</header>
