@extends('admin.laporan.pdf.layout')

@section('title', 'Laporan Kerusakan dan Kondisi Barang')
@section('doc_title', 'LAPORAN KERUSAKAN DAN RIWAYAT KONDISI BARANG')
@section('doc_subtitle', 'Dokumen Resmi Pemeriksaan Fisik Fasilitas Pasca Pengembalian')

@section('content')
    <!-- EXECUTIVE SUMMARY CARDS -->
    <table class="summary-table">
        <tr>
            <td class="summary-card success" style="width: 33.3%;">
                <div class="sc-label">KONDISI BAIK / NORMAL</div>
                <div class="sc-value" style="color: #166534;">{{ $kondisiRingkasan['Baik'] ?? 0 }} <span class="sc-unit">Unit</span></div>
            </td>
            <td class="summary-card warning" style="width: 33.3%;">
                <div class="sc-label">KONDISI KURANG BAIK</div>
                <div class="sc-value" style="color: #D97706;">{{ $kondisiRingkasan['Kurang Baik'] ?? 0 }} <span class="sc-unit">Unit</span></div>
            </td>
            <td class="summary-card danger" style="width: 33.3%;">
                <div class="sc-label">RUSAK BERAT / BUTUH SERVIS</div>
                <div class="sc-value" style="color: #DC2626;">{{ $kondisiRingkasan['Rusak Berat'] ?? 0 }} <span class="sc-unit">Unit</span></div>
            </td>
        </tr>
    </table>

    <!-- DATA TABLE -->
    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 30px;" class="center">No</th>
                <th style="width: 105px;" class="center">Tgl Pinjam</th>
                <th>Nama Barang / Sarana</th>
                <th style="width: 150px;">Peminjam</th>
                <th style="width: 105px;" class="center">Tgl Kembali</th>
                <th style="width: 120px;" class="center">Kondisi Barang</th>
            </tr>
        </thead>
        <tbody>
            @forelse($riwayatKondisi as $index => $item)
                @php 
                    $kondisi = $item->pengembalian->kondisi_barang ?? 'Belum dicatat';
                    $badgeClass = match(strtolower($kondisi)) {
                        'baik' => 'badge-success',
                        'kurang baik' => 'badge-warning',
                        'rusak berat' => 'badge-danger',
                        default => 'badge-neutral',
                    };
                @endphp
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td class="center">{{ $item->tanggal_pinjam?->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $item->barang->nama_barang ?? '-' }}</strong>
                        @if($item->barang && $item->barang->kategori)
                            <div style="font-size: 7.5px; color: #64748B;">Kategori: {{ $item->barang->kategori->nama_kategori }}</div>
                        @endif
                    </td>
                    <td>{{ $item->siswa->nama ?? $item->nis }}</td>
                    <td class="center">{{ $item->pengembalian->tanggal_kembali?->format('d/m/Y') ?? '-' }}</td>
                    <td class="center">
                        <span class="badge {{ $badgeClass }}">{{ $kondisi }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty-cell">Belum ada riwayat kondisi barang yang dikembalikan pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
