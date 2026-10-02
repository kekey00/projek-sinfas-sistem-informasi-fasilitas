@extends('layouts.admin')
@section('title', 'Daftar Stok Barang - SINFAS')
@section('page_title', 'Daftar Stok Barang')
@section('styles') @include('admin.laporan.partials.styles') @endsection
@section('content')
@include('admin.laporan.partials.print-header', [
    'docTitle' => 'REKAPITULASI STOK DAN STATUS INVENTARIS',
    'docSubtitle' => 'Dokumen Resmi Pendataan Jumlah, Kelaikan Fisik, dan Distribusi Sarana Prasarana'
])
<div class="report-header"><div><div class="report-kicker">Laporan 04 / Stok Barang</div><h2 class="report-title">Daftar Stok Barang</h2><p class="report-subtitle">Melihat jumlah barang yang baik, kurang baik, rusak, dan sedang dipinjam.</p>@include('admin.laporan.partials.actions', ['pdfRoute' => 'admin.laporan.inventaris.pdf'])</div><div class="report-mark">04</div></div>
<div class="report-card blue"><div class="report-card-header"><div class="report-index">04</div><div><div class="report-card-title">Rekapitulasi Inventaris</div><p class="report-card-description">Gunakan kategori untuk mempersempit pemeriksaan stok dan kondisi aset.</p></div></div>@include('admin.laporan.partials.filter', ['reportRoute' => 'admin.laporan.inventaris'])<div class="report-table-wrap"><table class="report-table"><thead><tr><th>Barang</th><th>Kategori</th><th>Baik</th><th>Kurang Baik</th><th>Rusak Berat</th><th>Dipinjam</th><th>Total</th></tr></thead><tbody>@forelse($stokInventaris as $item)<tr><td><strong>{{ $item['nama_barang'] }}</strong></td><td>{{ $item['kategori'] }}</td><td>{{ $item['baik'] }}</td><td>{{ $item['kurang_baik'] }}</td><td>{{ $item['rusak_berat'] }}</td><td>{{ $item['dipinjam'] }}</td><td><span class="count-pill">{{ $item['total'] }}</span></td></tr>@empty<tr><td colspan="7" class="empty-report">Belum ada data inventaris.</td></tr>@endforelse</tbody></table></div></div>
<div class="report-card">
	<div class="report-card-header"><div><div class="report-card-title">Grafik Kondisi dan Stok Barang</div><p class="report-card-description">Jumlah unit barang berdasarkan kondisi dan status saat ini.</p></div></div>
	<div class="trend-chart"><canvas id="chartStokInventaris"></canvas></div>
</div>
@include('admin.laporan.partials.print-signatures')
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
	if (typeof Chart === 'undefined') { console.error('Chart.js not loaded'); return; }
	var ctx = document.getElementById('chartStokInventaris');
	if (!ctx) return;
	new Chart(ctx, {
		type: 'bar',
		data: {
			labels: ['Baik', 'Kurang Baik', 'Rusak Berat', 'Sedang Dipinjam'],
			datasets: [{
				label: 'Jumlah barang',
				data: [{{ $stokRingkasan['Kondisi baik'] ?? 0 }}, {{ $stokRingkasan['Kurang baik'] ?? 0 }}, {{ $stokRingkasan['Rusak berat'] ?? 0 }}, {{ $stokRingkasan['Sedang dipinjam'] ?? 0 }}],
				backgroundColor: ['#0F9B8E', '#E7A23B', '#D95757', '#5476AA'],
				borderRadius: 7,
				borderSkipped: false,
				maxBarThickness: 54
			}]
		},
		options: {
			responsive: true,
			maintainAspectRatio: false,
			plugins: { legend: { display: false } },
			scales: { y: { beginAtZero: true, ticks: { precision: 0 } } }
		}
	});
});
</script>
@endsection
