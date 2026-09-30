@extends('admin.laporan.pdf.layout')

@section('title', 'Laporan Keterlambatan Pengembalian Barang')
@section('doc_title', 'LAPORAN KETERLAMBATAN PENGEMBALIAN BARANG')
@section('doc_subtitle', 'Dokumen Resmi Rekapitulasi dan Pengawasan Peminjaman Melebihi Batas Waktu')

@section('content')
    <!-- EXECUTIVE SUMMARY CARDS -->
    <table class="summary-table">
        <tr>
            <td class="summary-card primary" style="width: 33.3%;">
                <div class="sc-label">TOTAL KASUS KETERLAMBATAN</div>
                <div class="sc-value" style="color: #121358;">{{ $keterlambatan->count() }} <span class="sc-unit">Transaksi</span></div>
            </td>
            <td class="summary-card danger" style="width: 33.3%;">
                <div class="sc-label">BARANG BELUM DIKEMBALIKAN</div>
                <div class="sc-value" style="color: #DC2626;">{{ $keterlambatanRingkasan['Belum dikembalikan'] }} <span class="sc-unit">Peminjaman</span></div>
            </td>
            <td class="summary-card success" style="width: 33.3%;">
                <div class="sc-label">SUDAH DIKEMBALIKAN (TERLAMBAT)</div>
                <div class="sc-value" style="color: #166534;">{{ $keterlambatanRingkasan['Sudah dikembalikan'] }} <span class="sc-unit">Peminjaman</span></div>
            </td>
        </tr>
    </table>

    <!-- DATA TABLE -->
    <table class="report-table">
        <thead>
            <tr>
                <th style="width: 30px;" class="center">No</th>
                <th style="width: 160px;">Nama Peminjam</th>
                <th>Nama Barang</th>
                <th style="width: 120px;" class="center">Batas Kembali</th>
                <th style="width: 170px;" class="center">Status Realisasi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($keterlambatan as $index => $item)
                @php $sudahKembali = (bool) $item->pengembalian; @endphp
                <tr>
                    <td class="center">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->siswa->nama ?? $item->nis }}</strong>
                        @if($item->siswa && $item->siswa->nis)
                            <div style="font-size: 7.5px; color: #64748B;">NIS: {{ $item->siswa->nis }}</div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $item->barang->nama_barang ?? '-' }}</strong>
                        @if($item->barang && $item->barang->kategori)
                            <div style="font-size: 7.5px; color: #64748B;">Kategori: {{ $item->barang->kategori->nama_kategori }}</div>
                        @endif
                    </td>
                    <td class="center">
                        {{ $item->tanggal_kembali?->format('d/m/Y') }}
                    </td>
                    <td class="center">
                        @if($sudahKembali)
                            <span class="badge badge-success">Dikembalikan {{ $item->pengembalian->tanggal_kembali?->format('d/m/Y') }}</span>
                        @else
                            <span class="badge badge-danger">Belum Dikembalikan</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="empty-cell">Tidak ada data peminjaman yang terlambat pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
