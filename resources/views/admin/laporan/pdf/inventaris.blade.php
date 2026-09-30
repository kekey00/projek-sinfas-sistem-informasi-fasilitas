@extends('admin.laporan.pdf.layout')

@section('title', 'Laporan Rekapitulasi Stok dan Status Inventaris')
@section('doc_title', 'REKAPITULASI STOK DAN STATUS INVENTARIS')
@section('doc_subtitle', 'Dokumen Resmi Pendataan Jumlah, Kelaikan Fisik, dan Distribusi Sarana Prasarana')

@section('content')
    <!-- EXECUTIVE SUMMARY CARDS -->
    <table class="summary-table">
        <tr>
            <td class="summary-card primary" style="width: 20%;">
                <div class="sc-label">TOTAL UNIT ASET</div>
                <div class="sc-value" style="color: #121358;">{{ $stokRingkasan['Kondisi baik'] + $stokRingkasan['Kurang baik'] + $stokRingkasan['Rusak berat'] }} <span class="sc-unit">Unit</span></div>
            </td>
            <td class="summary-card success" style="width: 20%;">
                <div class="sc-label">KONDISI BAIK</div>
                <div class="sc-value" style="color: #166534;">{{ $stokRingkasan['Kondisi baik'] }} <span class="sc-unit">Unit</span></div>
            </td>
            <td class="summary-card warning" style="width: 20%;">
                <div class="sc-label">KURANG BAIK</div>
                <div class="sc-value" style="color: #D97706;">{{ $stokRingkasan['Kurang baik'] }} <span class="sc-unit">Unit</span></div>
            </td>
            <td class="summary-card danger" style="width: 20%;">
                <div class="sc-label">RUSAK BERAT</div>
                <div class="sc-value" style="color: #DC2626;">{{ $stokRingkasan['Rusak berat'] }} <span class="sc-unit">Unit</span></div>
            </td>
            <td class="summary-card info" style="width: 20%;">
                <div class="sc-label">SEDANG DIPINJAM</div>
                <div class="sc-value" style="color: #2F578A;">{{ $stokRingkasan['Sedang dipinjam'] }} <span class="sc-unit">Unit</span></div>
            </td>
        </tr>
    </table>

    <!-- DATA TABLE -->
    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 30px;" class="center">No</th>
                <th>Nama Barang / Fasilitas</th>
                <th style="width: 130px;">Kategori</th>
                <th style="width: 65px;" class="center">Baik</th>
                <th style="width: 75px;" class="center">Kurang Baik</th>
                <th style="width: 75px;" class="center">Rusak Berat</th>
                <th style="width: 65px;" class="center">Dipinjam</th>
                <th style="width: 70px;" class="center">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($stokInventaris as $index => $item)
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td><strong>{{ $item['nama_barang'] }}</strong></td>
                    <td><span class="badge badge-neutral">{{ $item['kategori'] }}</span></td>
                    <td class="center" style="color: #166534; font-weight: 700;">{{ $item['baik'] }}</td>
                    <td class="center" style="color: #D97706; font-weight: 700;">{{ $item['kurang_baik'] }}</td>
                    <td class="center" style="color: #DC2626; font-weight: 700;">{{ $item['rusak_berat'] }}</td>
                    <td class="center" style="color: #2F578A; font-weight: 700;">{{ $item['dipinjam'] }}</td>
                    <td class="center" style="font-weight: 800; background: #F1F5F9;">{{ $item['total'] }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="empty-cell">Belum ada data inventaris barang yang terdaftar.</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr class="total-row">
                <td colspan="3" class="right" style="text-align: right; padding-right: 12px;">TOTAL KESELURUHAN:</td>
                <td class="center" style="color: #166534;">{{ $stokRingkasan['Kondisi baik'] }}</td>
                <td class="center" style="color: #D97706;">{{ $stokRingkasan['Kurang baik'] }}</td>
                <td class="center" style="color: #DC2626;">{{ $stokRingkasan['Rusak berat'] }}</td>
                <td class="center" style="color: #2F578A;">{{ $stokRingkasan['Sedang dipinjam'] }}</td>
                <td class="center" style="font-size: 10px; color: #121358;">{{ $stokInventaris->sum('total') }}</td>
            </tr>
        </tfoot>
    </table>
@endsection
