@extends('layouts.admin')
@section('title', 'Laporan Kondisi Barang - SINFAS')
@section('page_title', 'Kondisi Barang')
@section('styles') @include('admin.laporan.partials.styles') @endsection
@section('content')
@include('admin.laporan.partials.print-header', [
    'docTitle' => 'LAPORAN KERUSAKAN DAN RIWAYAT KONDISI BARANG',
    'docSubtitle' => 'Dokumen Resmi Pemeriksaan Fisik Fasilitas Pasca Pengembalian'
])
<div class="report-header"><div><div class="report-kicker">Laporan 02 / Kondisi Barang</div><h2 class="report-title">Kondisi Barang</h2><p class="report-subtitle">Melihat kondisi barang setelah dikembalikan, termasuk barang yang rusak.</p>@include('admin.laporan.partials.actions', ['pdfRoute' => 'admin.laporan.kondisi.pdf'])</div><div class="report-mark">02</div></div>
<div class="report-card orange"><div class="report-card-header"><div class="report-index">02</div><div><div class="report-card-title">Riwayat Kondisi Barang</div><p class="report-card-description">Filter berdasarkan periode dan kategori untuk melihat perubahan kondisi aset.</p></div></div>@include('admin.laporan.partials.filter', ['reportRoute' => 'admin.laporan.kondisi'])<div class="report-summary"><div class="summary-box"><div class="summary-label">Kondisi baik</div><div class="summary-value">{{ $kondisiRingkasan['Baik'] ?? 0 }}</div></div><div class="summary-box"><div class="summary-label">Kurang baik</div><div class="summary-value">{{ $kondisiRingkasan['Kurang Baik'] ?? 0 }}</div></div><div class="summary-box"><div class="summary-label">Rusak berat</div><div class="summary-value">{{ $kondisiRingkasan['Rusak Berat'] ?? 0 }}</div></div></div><div class="report-table-wrap"><table class="report-table"><thead><tr><th>Tanggal Pinjam</th><th>Barang</th><th>Tanggal Kembali</th><th>Kondisi</th></tr></thead><tbody>@forelse($riwayatKondisi as $item)<tr><td>{{ $item->tanggal_pinjam?->format('d/m/Y') }}</td><td><strong>{{ $item->barang->nama_barang ?? '-' }}</strong></td><td>{{ $item->pengembalian->tanggal_kembali?->format('d/m/Y') }}</td><td>{{ $item->pengembalian->kondisi_barang ?? 'Belum dicatat' }}</td></tr>@empty<tr><td colspan="4" class="empty-report">Belum ada riwayat kondisi pada filter yang dipilih.</td></tr>@endforelse</tbody></table></div></div>
<div class="report-card">
	<div class="report-card-header"><div><div class="report-card-title">Grafik Kondisi Barang</div><p class="report-card-description">Perbandingan kondisi barang yang dikembalikan pada periode laporan.</p></div></div>
	<div class="trend-chart"><canvas id="chartKondisiBarang"></canvas></div>
</div>
@include('admin.laporan.partials.print-signatures')
@endsection

@section('scripts')
<script>
	new Chart(document.getElementById('chartKondisiBarang'), {
		type: 'doughnut',
		data: {
			labels: ['Baik', 'Kurang Baik', 'Rusak Berat'],
			datasets: [{
				data: [{{ $kondisiRingkasan['Baik'] ?? 0 }}, {{ $kondisiRingkasan['Kurang Baik'] ?? 0 }}, {{ $kondisiRingkasan['Rusak Berat'] ?? 0 }}],
				backgroundColor: ['#0F9B8E', '#E7A23B', '#D95757'],
				borderColor: '#FFFFFF',
				borderWidth: 3,
				hoverOffset: 5
			}]
		},
		options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { position: 'bottom' } } }
	});
</script>
@endsection
