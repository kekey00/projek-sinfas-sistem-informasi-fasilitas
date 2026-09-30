@extends('admin.laporan.pdf.layout')

@section('title', 'Laporan Frekuensi Peminjaman Barang')
@section('doc_title', 'LAPORAN FREKUENSI DAN TREN PEMINJAMAN BARANG')
@section('doc_subtitle', 'Dokumen Resmi Analisis Tingkat Pemanfaatan Fasilitas dan Sarana Sekolah')

@section('content')
    <!-- EXECUTIVE SUMMARY CARDS -->
    <table class="summary-table">
        <tr>
            <td class="summary-card primary" style="width: 50%;">
                <div class="sc-label">TOTAL TRANSAKSI PEMINJAMAN</div>
                <div class="sc-value" style="color: #121358;">{{ $totalPeminjaman }} <span class="sc-unit">Kali Transaksi</span></div>
            </td>
            <td class="summary-card info" style="width: 50%;">
                <div class="sc-label">VARIASI JENIS BARANG DIPINJAM</div>
                <div class="sc-value" style="color: #2F578A;">{{ $totalBarangDipinjam }} <span class="sc-unit">Jenis Barang</span></div>
            </td>
        </tr>
    </table>

    <!-- DATA TABLE -->
    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 35px;" class="center">No</th>
                <th>Nama Barang / Sarana</th>
                <th style="width: 180px;">Kategori Fasilitas</th>
                <th style="width: 140px;" class="center">Frekuensi Dipinjam</th>
                <th style="width: 130px;" class="center">Persentase</th>
            </tr>
        </thead>
        <tbody>
            @php $totalSemua = $frekuensiBarang->sum('frekuensi') ?: 1; @endphp
            @forelse($frekuensiBarang as $index => $item)
                @php $persen = round(($item['frekuensi'] / $totalSemua) * 100, 1); @endphp
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item['nama_barang'] }}</strong>
                    </td>
                    <td>
                        <span class="badge badge-neutral">{{ $item['kategori'] }}</span>
                    </td>
                    <td class="center">
                        <span class="badge badge-info">{{ $item['frekuensi'] }} kali</span>
                    </td>
                    <td class="center">
                        <strong>{{ $persen }}%</strong>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="empty-cell">Belum ada riwayat transaksi peminjaman pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
