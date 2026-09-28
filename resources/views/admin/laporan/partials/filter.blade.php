<form method="GET" action="{{ route($reportRoute) }}" class="report-filter">
    <div class="report-field"><label for="tanggal_mulai">Tanggal Awal</label><input id="tanggal_mulai" type="date" name="tanggal_mulai" value="{{ $tanggalMulai }}"></div>
    <div class="report-field"><label for="tanggal_akhir">Tanggal Akhir</label><input id="tanggal_akhir" type="date" name="tanggal_akhir" value="{{ $tanggalAkhir }}"></div>
    <div class="report-field"><label for="kategori">Kategori Barang</label><select id="kategori" name="kategori"><option value="">Semua kategori</option>@foreach($kategoriList as $kategori)<option value="{{ $kategori->id_kategori }}" {{ (string) $kategoriTerpilih === (string) $kategori->id_kategori ? 'selected' : '' }}>{{ $kategori->nama_kategori }}</option>@endforeach</select></div>
    <button type="submit" class="report-button">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="7"></circle><line x1="16.5" y1="16.5" x2="21" y2="21"></line></svg>
        Cari
    </button>
</form>
