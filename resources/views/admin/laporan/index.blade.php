@extends('layouts.admin')
@section('title', 'Pusat Laporan - SINFAS')
@section('page_title', 'Laporan')
@section('styles') @include('admin.laporan.partials.styles') @endsection
@section('content')
<div class="report-header"><div><div class="report-kicker">Pusat Analitik Sarana</div><h2 class="report-title">Daftar Laporan Utama Staf Sarana</h2><p class="report-subtitle">Pilih laporan yang ingin dianalisis. Setiap laporan memiliki halaman dan filter tersendiri.</p></div><div class="report-mark"><svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M4 19V5M4 19h17m-14-4 3-4 3 2 5-7"/><circle cx="18" cy="6" r="1"/></svg></div></div>
<div class="catalog-grid">
    <article class="catalog-card"><div class="catalog-number">LAPORAN 01</div><h3 class="catalog-title">Barang yang Sering Dipinjam</h3><p class="catalog-description">Melihat barang yang paling sering dipinjam dalam waktu tertentu.</p><a class="catalog-link" href="{{ route('admin.laporan.frekuensi') }}">Buka laporan <span>→</span></a></article>
    <article class="catalog-card"><div class="catalog-number">LAPORAN 02</div><h3 class="catalog-title">Kondisi Barang</h3><p class="catalog-description">Melihat kondisi barang setelah dikembalikan, termasuk barang yang rusak.</p><a class="catalog-link" href="{{ route('admin.laporan.kondisi') }}">Buka laporan <span>→</span></a></article>
    <article class="catalog-card"><div class="catalog-number">LAPORAN 03</div><h3 class="catalog-title">Barang yang Terlambat Dikembalikan</h3><p class="catalog-description">Melihat siapa yang terlambat mengembalikan barang dan barang yang dibawa.</p><a class="catalog-link" href="{{ route('admin.laporan.keterlambatan') }}">Buka laporan <span>→</span></a></article>
    <article class="catalog-card"><div class="catalog-number">LAPORAN 04</div><h3 class="catalog-title">Daftar Stok Barang</h3><p class="catalog-description">Melihat jumlah barang yang baik, kurang baik, rusak, dan sedang dipinjam.</p><a class="catalog-link" href="{{ route('admin.laporan.inventaris') }}">Buka laporan <span>→</span></a></article>
</div>
@endsection
