@extends('layouts.admin')
@section('title', 'Daftar Stok Barang - SINFAS')
@section('page_title', 'Daftar Stok Barang')
@section('styles') @include('admin.laporan.partials.styles') @endsection
@section('content')
@include('admin.laporan.partials.document-header', ['documentNumber' => '04', 'documentTitle' => 'Laporan Daftar Stok Barang', 'documentDescription' => 'Rekap jumlah barang berdasarkan kondisi dan status peminjaman.'])
@include('admin.laporan.partials.actions', ['pdfRoute' => 'admin.laporan.inventaris.pdf'])
<div class="report-card formal-report"><div class="report-card-header"><div class="report-index">04</div><div><div class="report-card-title">Rincian Persediaan Barang</div><p class="report-card-description">Jumlah persediaan berdasarkan kondisi barang dan status peminjaman.</p></div></div>@include('admin.laporan.partials.filter', ['reportRoute' => 'admin.laporan.inventaris'])<div class="report-table-wrap"><table class="report-table"><thead><tr><th>No.</th><th>Nama Barang</th><th>Kategori</th><th>Baik</th><th>Kurang Baik</th><th>Rusak Berat</th><th>Dipinjam</th><th>Jumlah</th></tr></thead><tbody>@forelse($stokInventaris as $index => $item)<tr><td>{{ $index + 1 }}</td><td><strong>{{ $item['nama_barang'] }}</strong></td><td>{{ $item['kategori'] }}</td><td>{{ $item['baik'] }}</td><td>{{ $item['kurang_baik'] }}</td><td>{{ $item['rusak_berat'] }}</td><td>{{ $item['dipinjam'] }}</td><td>{{ $item['total'] }}</td></tr>@empty<tr><td colspan="8" class="empty-report">Belum terdapat data barang.</td></tr>@endforelse</tbody></table></div></div>
@endsection
