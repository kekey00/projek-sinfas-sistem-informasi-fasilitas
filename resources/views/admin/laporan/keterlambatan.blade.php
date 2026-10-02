@extends('layouts.admin')
@section('title', 'Laporan Barang Terlambat Dikembalikan - SINFAS')
@section('page_title', 'Barang yang Terlambat Dikembalikan')
@section('styles') @include('admin.laporan.partials.styles') @endsection
@section('content')
@include('admin.laporan.partials.print-header', [
    'docTitle' => 'LAPORAN KETERLAMBATAN PENGEMBALIAN BARANG',
    'docSubtitle' => 'Dokumen Resmi Rekapitulasi dan Pengawasan Peminjaman Melebihi Batas Waktu'
])
<div class="report-header"><div><div class="report-kicker">Laporan 03 / Pengembalian</div><h2 class="report-title">Barang yang Terlambat Dikembalikan</h2><p class="report-subtitle">Melihat siapa yang terlambat mengembalikan barang dan barang yang dibawa.</p>@include('admin.laporan.partials.actions', ['pdfRoute' => 'admin.laporan.keterlambatan.pdf'])</div><div class="report-mark">03</div></div>
<div class="report-card red"><div class="report-card-header"><div class="report-index">03</div><div><div class="report-card-title">Daftar Keterlambatan</div><p class="report-card-description">Peminjaman aktif yang sudah melewati batas waktu juga ditampilkan sebagai keterlambatan.</p></div></div>@include('admin.laporan.partials.filter', ['reportRoute' => 'admin.laporan.keterlambatan'])<div class="report-summary"><div class="summary-box"><div class="summary-label">Total keterlambatan</div><div class="summary-value">{{ $keterlambatan->count() }}</div></div></div><div class="report-table-wrap"><table class="report-table"><thead><tr><th>Peminjam</th><th>Barang</th><th>Rencana Kembali</th><th>Realisasi / Status</th></tr></thead><tbody>@forelse($keterlambatan as $item)@php $sudahKembali = (bool) $item->pengembalian; @endphp<tr><td><strong>{{ $item->siswa->nama ?? $item->nis }}</strong></td><td>{{ $item->barang->nama_barang ?? '-' }}</td><td>{{ $item->tanggal_kembali?->format('d/m/Y') }}</td><td>{{ $sudahKembali ? 'Dikembalikan ' . $item->pengembalian->tanggal_kembali->format('d/m/Y') : 'Belum dikembalikan' }}</td></tr>@empty<tr><td colspan="4" class="empty-report">Tidak ada keterlambatan pada filter yang dipilih.</td></tr>@endforelse</tbody></table></div></div>
	@php
		$totalKeterlambatan = ($keterlambatanRingkasan['Belum dikembalikan'] ?? 0) + ($keterlambatanRingkasan['Sudah dikembalikan'] ?? 0);
	@endphp
	<div class="report-card">
		<div class="report-card-header"><div><div class="report-card-title">Grafik Status Keterlambatan</div><p class="report-card-description">Perbandingan barang terlambat yang belum dan sudah dikembalikan.</p></div></div>
		@if($totalKeterlambatan > 0)
			<div class="trend-chart"><canvas id="chartKeterlambatan"></canvas></div>
		@else
			<div style="text-align:center; padding: 48px 20px; color:#94a3b8; font-size:13.5px;">
				<svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#cbd5e1" stroke-width="1.6" style="margin:0 auto 10px; display:block;"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
				Tidak ada data keterlambatan pada periode ini.
			</div>
		@endif
	</div>
@include('admin.laporan.partials.print-signatures')
@endsection

@if($totalKeterlambatan > 0)
@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
	if (typeof Chart === 'undefined') { console.error('Chart.js not loaded'); return; }
	var ctx = document.getElementById('chartKeterlambatan');
	if (!ctx) return;
	new Chart(ctx, {
		type: 'doughnut',
		data: {
			labels: ['Belum dikembalikan', 'Sudah dikembalikan'],
			datasets: [{
				data: [{{ $keterlambatanRingkasan['Belum dikembalikan'] ?? 0 }}, {{ $keterlambatanRingkasan['Sudah dikembalikan'] ?? 0 }}],
				backgroundColor: ['#D95757', '#E7A23B'],
				borderColor: '#FFFFFF',
				borderWidth: 3,
				hoverOffset: 5
			}]
		},
		options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
	});
});
</script>
@endsection
@endif
