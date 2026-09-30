@extends('layouts.admin')
@section('title', 'Laporan Barang yang Sering Dipinjam - SINFAS')
@section('page_title', 'Barang yang Sering Dipinjam')
@section('styles') @include('admin.laporan.partials.styles') @endsection
@section('content')
@include('admin.laporan.partials.print-header', [
    'docTitle' => 'LAPORAN FREKUENSI DAN TREN PEMINJAMAN BARANG',
    'docSubtitle' => 'Dokumen Resmi Analisis Tingkat Pemanfaatan Fasilitas dan Sarana Sekolah'
])
<div class="report-header"><div><div class="report-kicker">Laporan 01 / Peminjaman</div><h2 class="report-title">Barang yang Sering Dipinjam</h2><p class="report-subtitle">Melihat barang yang paling sering dipinjam dalam waktu tertentu.</p>@include('admin.laporan.partials.actions', ['pdfRoute' => 'admin.laporan.frekuensi.pdf'])</div><div class="report-mark">01</div></div>
<div class="report-card"><div class="report-card-header"><div class="report-index">01</div><div><div class="report-card-title">Analisis Peminjaman</div><p class="report-card-description">Gunakan filter untuk melihat barang yang paling sering digunakan.</p></div></div>@include('admin.laporan.partials.filter', ['reportRoute' => 'admin.laporan.frekuensi'])<div class="report-summary"><div class="summary-box"><div class="summary-label">Total transaksi</div><div class="summary-value">{{ $totalPeminjaman }}</div></div><div class="summary-box"><div class="summary-label">Jenis barang</div><div class="summary-value">{{ $totalBarangDipinjam }}</div></div></div><div class="report-table-wrap"><table class="report-table"><thead><tr><th>No</th><th>Nama Barang</th><th>Kategori</th><th>Frekuensi</th></tr></thead><tbody>@forelse($frekuensiBarang as $index => $item)<tr><td>{{ $index + 1 }}</td><td><strong>{{ $item['nama_barang'] }}</strong></td><td>{{ $item['kategori'] }}</td><td><span class="count-pill">{{ $item['frekuensi'] }}x</span></td></tr>@empty<tr><td colspan="4" class="empty-report">Belum ada data pada filter yang dipilih.</td></tr>@endforelse</tbody></table></div><div class="trend-title">Tren Peminjaman Harian</div><div class="trend-chart"><canvas id="trendPeminjamanChart"></canvas></div></div>
@include('admin.laporan.partials.print-signatures')
@endsection
@section('scripts')<script>new Chart(document.getElementById('trendPeminjamanChart'),{type:'line',data:{labels:@json($trenHarian->keys()->values()),datasets:[{label:'Peminjaman',data:@json($trenHarian->values()->values()),borderColor:'#232F72',backgroundColor:'rgba(35,47,114,.12)',fill:true,tension:.3,pointRadius:3}]},options:{responsive:true,maintainAspectRatio:false,plugins:{legend:{display:false}},scales:{y:{beginAtZero:true,ticks:{precision:0}}}}});</script>@endsection
