@extends('layouts.admin')

@section('title', 'Kelola Data Alat')

@section('page_title', 'Kelola Data Alat')
@section('page_icon')
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
    <line x1="12" y1="22.08" x2="12" y2="12"></line>
</svg>
@endsection

@section('content')

    <!-- Card Kelola Alat -->
    <div class="content-card">
        <!-- Card Header: Title, Search, Filter & Tambah Button -->
        <div class="card-header-row">
            <div>
                <div class="card-heading">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    </svg>
                    <span>Daftar Data Alat &amp; Barang</span>
                </div>
                <div style="font-size: 12.5px; color: #64748B; margin-top: 2px;">
                    Kelola data peralatan, spesifikasi, dan stok kondisi barang fasilitas
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <!-- Filter Form -->
                <form action="{{ route('admin.barang.index') }}" method="GET" style="display: flex; gap: 8px; align-items: center;">
                    <select name="kategori" class="form-select" style="width: 170px; padding: 7px 10px; font-size: 12px;" onchange="this.form.submit()">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kat)
                            <option value="{{ $kat->id_kategori }}" {{ request('kategori') == $kat->id_kategori ? 'selected' : '' }}>
                                {{ $kat->nama_kategori }}
                            </option>
                        @endforeach
                    </select>

                    <div style="position: relative; width: 180px;">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari alat/merk..." class="form-input" style="padding: 7px 10px 7px 28px; font-size: 12px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2.5" style="position: absolute; left: 8px; top: 50%; transform: translateY(-50%);">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>

                    @if(request('kategori') || request('q') || request('kondisi'))
                        <a href="{{ route('admin.barang.index') }}" class="btn-sinfas-secondary" style="padding: 6px 10px; font-size: 11px;" title="Reset filter">Reset</a>
                    @endif
                </form>

                <!-- Button Tambah Alat -->
                <button type="button" class="btn-sinfas-primary" onclick="openModal('addBarangModal')">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Tambah Alat</span>
                </button>
            </div>
        </div>

        <!-- Tabel Data Alat -->
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px;">Foto</th>
                        <th>Kode</th>
                        <th>Nama Alat / Barang</th>
                        <th>Kategori</th>
                        <th style="text-align: center;">Baik</th>
                        <th style="text-align: center;">K. Baik</th>
                        <th style="text-align: center;">Rusak</th>
                        <th>Status</th>
                        <th style="text-align: center; width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barangs as $item)
                    <tr>
                        <!-- Foto Thumbnail -->
                        <td>
                            <div style="width: 42px; height: 42px; border-radius: 8px; overflow: hidden; background: #E2E8F0; border: 1.5px solid #CBD5E1; display: flex; align-items: center; justify-content: center;">
                                @if($item->foto)
                                    <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->nama_barang }}" style="width: 100%; height: 100%; object-fit: cover;">
                                @else
                                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#94A3B8" stroke-width="2">
                                        <rect x="3" y="3" width="18" height="18" rx="2" ry="2"></rect>
                                        <circle cx="8.5" cy="8.5" r="1.5"></circle>
                                        <polyline points="21 15 16 10 5 21"></polyline>
                                    </svg>
                                @endif
                            </div>
                        </td>
                        <!-- Kode -->
                        <td>
                            <code style="background: #EBF3FE; padding: 3px 6px; border-radius: 6px; font-size: 11.5px; color: var(--color-border-blue); font-weight: 600;">
                                {{ $item->kode_barang }}
                            </code>
                        </td>
                        <!-- Nama Alat -->
                        <td>
                            <div style="font-weight: 600; color: #0F172A;">{{ $item->nama_barang }}</div>
                            @if($item->merk_model)
                                <div style="font-size: 11.5px; color: #64748B;">{{ $item->merk_model }}</div>
                            @endif
                        </td>
                        <!-- Kategori -->
                        <td>
                            <span class="badge badge-info">{{ $item->kategori->nama_kategori ?? '-' }}</span>
                        </td>
                        <!-- Stok Baik -->
                        <td style="text-align: center; font-weight: 700; color: #059669;">
                            {{ $item->jumlah_baik }}
                        </td>
                        <!-- Stok Kurang Baik -->
                        <td style="text-align: center; font-weight: 600; color: #D97706;">
                            {{ $item->jumlah_kurang_baik }}
                        </td>
                        <!-- Stok Rusak Berat -->
                        <td style="text-align: center; font-weight: 600; color: #DC2626;">
                            {{ $item->jumlah_rusak_berat }}
                        </td>
                        <!-- Status -->
                        <td>
                            @if($item->jumlah_baik > 0)
                                <span class="badge badge-success">Tersedia</span>
                            @else
                                <span class="badge badge-danger">Habis</span>
                            @endif
                        </td>
                        <!-- Aksi -->
                        <td>
                            <div class="actions-cell" style="justify-content: center;">
                                <!-- Tombol Detail -->
                                <button type="button" class="btn-action-sm btn-action-edit" style="color: #4F46E5; border-color: #C7D2FE;" title="Detail Informasi" onclick="showDetailModal({{ json_encode($item) }}, '{{ $item->kategori->nama_kategori ?? '-' }}')">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                </button>

                                <!-- Tombol Edit -->
                                <button type="button" class="btn-action-sm btn-action-edit" title="Edit Alat" onclick="openEditModal({{ json_encode($item) }})">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                </button>

                                <!-- Tombol Hapus -->
                                <button type="button" class="btn-action-sm btn-action-delete" title="Hapus Alat" onclick="openDeleteModal('{{ $item->kode_barang }}', '{{ $item->nama_barang }}')">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" style="text-align: center; color: #94A3B8; padding: 32px 14px;">
                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1.8" style="margin-bottom: 8px;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <line x1="12" y1="8" x2="12" y2="12"></line>
                                <line x1="12" y1="16" x2="12.01" y2="16"></line>
                            </svg>
                            <div>Belum ada data alat atau barang yang ditemukan.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 18px; display: flex; justify-content: flex-end;">
            {{ $barangs->links() }}
        </div>
    </div>

    <!-- MODAL: Tambah Alat Baru -->
    <div id="addBarangModal" class="modal-overlay">
        <div class="modal-card" style="max-width: 650px;">
            <div class="modal-header">
                <div class="modal-title">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Tambah Data Alat / Barang</span>
                </div>
                <button class="modal-close-btn" onclick="closeModal('addBarangModal')">&times;</button>
            </div>

            <form action="{{ route('admin.barang.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nama Alat / Barang <span style="color:red;">*</span></label>
                        <input type="text" name="nama_barang" class="form-input" placeholder="Contoh: Kamera DSLR Canon EOS 3000D" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori <span style="color:red;">*</span></label>
                        <select name="id_kategori" class="form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Kode Barang (Opsional)</label>
                        <input type="text" name="kode_barang" class="form-input" placeholder="Auto jika dikosongkan (BRG-XXX)">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Merk / Model</label>
                        <input type="text" name="merk_model" class="form-input" placeholder="Contoh: Canon EOS 3000D">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">No Seri Pabrik</label>
                        <input type="text" name="no_seri_pabrik" class="form-input" placeholder="Contoh: SN-8893921">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tahun Pembelian</label>
                        <input type="number" name="tahun_pembelian" class="form-input" value="{{ date('Y') }}" min="2000" max="{{ date('Y') + 1 }}">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Bahan / Material</label>
                        <input type="text" name="bahan" class="form-input" placeholder="Contoh: Plastik &amp; Logam">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ukuran / Dimensi</label>
                        <input type="text" name="ukuran_dimensi" class="form-input" placeholder="Contoh: 129 x 101 x 77 mm">
                    </div>
                </div>

                <!-- Input Stok Kondisi -->
                <div style="background: #F1F6FD; border: 1.5px solid var(--color-border-blue); border-radius: 12px; padding: 12px; margin-bottom: 16px;">
                    <div style="font-family: 'Gorditas', cursive; font-size: 13px; color: var(--color-dark-blue-bubble); margin-bottom: 10px;">
                        Jumlah &amp; Kondisi Fisik:
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                        <div>
                            <label class="form-label" style="color: #059669;">Kondisi Baik <span style="color:red;">*</span></label>
                            <input type="number" name="jumlah_baik" class="form-input" value="1" min="0" required>
                        </div>
                        <div>
                            <label class="form-label" style="color: #D97706;">Kurang Baik</label>
                            <input type="number" name="jumlah_kurang_baik" class="form-input" value="0" min="0">
                        </div>
                        <div>
                            <label class="form-label" style="color: #DC2626;">Rusak Berat</label>
                            <input type="number" name="jumlah_rusak_berat" class="form-input" value="0" min="0">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Unggah Foto Alat (Opsional, Max 2MB)</label>
                    <input type="file" name="foto" class="form-input" accept="image/*">
                </div>

                <div class="form-group">
                    <label class="form-label">Keterangan / Catatan Fasilitas</label>
                    <textarea name="keterangan" class="form-textarea" rows="2" placeholder="Tuliskan spesifikasi kelengkapan alat (misal: termasuk baterai dan charger)"></textarea>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-sinfas-secondary" onclick="closeModal('addBarangModal')">Batal</button>
                    <button type="submit" class="btn-sinfas-primary">Simpan Alat</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Edit Alat -->
    <div id="editBarangModal" class="modal-overlay">
        <div class="modal-card" style="max-width: 650px;">
            <div class="modal-header">
                <div class="modal-title">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    <span>Edit Data Alat / Barang</span>
                </div>
                <button class="modal-close-btn" onclick="closeModal('editBarangModal')">&times;</button>
            </div>

            <form id="editBarangForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Nama Alat / Barang <span style="color:red;">*</span></label>
                        <input type="text" name="nama_barang" id="edit_nama_barang" class="form-input" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Kategori <span style="color:red;">*</span></label>
                        <select name="id_kategori" id="edit_id_kategori" class="form-select" required>
                            @foreach($kategoris as $kat)
                                <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Kode Barang</label>
                        <input type="text" id="edit_kode_barang" class="form-input" disabled style="background: #E2E8F0;">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Merk / Model</label>
                        <input type="text" name="merk_model" id="edit_merk_model" class="form-input">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">No Seri Pabrik</label>
                        <input type="text" name="no_seri_pabrik" id="edit_no_seri_pabrik" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Tahun Pembelian</label>
                        <input type="number" name="tahun_pembelian" id="edit_tahun_pembelian" class="form-input">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Bahan / Material</label>
                        <input type="text" name="bahan" id="edit_bahan" class="form-input">
                    </div>
                    <div class="form-group">
                        <label class="form-label">Ukuran / Dimensi</label>
                        <input type="text" name="ukuran_dimensi" id="edit_ukuran_dimensi" class="form-input">
                    </div>
                </div>

                <!-- Input Stok Kondisi -->
                <div style="background: #F1F6FD; border: 1.5px solid var(--color-border-blue); border-radius: 12px; padding: 12px; margin-bottom: 16px;">
                    <div style="font-family: 'Gorditas', cursive; font-size: 13px; color: var(--color-dark-blue-bubble); margin-bottom: 10px;">
                        Jumlah &amp; Kondisi Fisik:
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 10px;">
                        <div>
                            <label class="form-label" style="color: #059669;">Kondisi Baik <span style="color:red;">*</span></label>
                            <input type="number" name="jumlah_baik" id="edit_jumlah_baik" class="form-input" min="0" required>
                        </div>
                        <div>
                            <label class="form-label" style="color: #D97706;">Kurang Baik</label>
                            <input type="number" name="jumlah_kurang_baik" id="edit_jumlah_kurang_baik" class="form-input" min="0">
                        </div>
                        <div>
                            <label class="form-label" style="color: #DC2626;">Rusak Berat</label>
                            <input type="number" name="jumlah_rusak_berat" id="edit_jumlah_rusak_berat" class="form-input" min="0">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Ganti Foto Alat (Kosongkan jika tidak ingin mengubah)</label>
                    <input type="file" name="foto" class="form-input" accept="image/*">
                </div>

                <div class="form-group">
                    <label class="form-label">Keterangan / Catatan Fasilitas</label>
                    <textarea name="keterangan" id="edit_keterangan" class="form-textarea" rows="2"></textarea>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-sinfas-secondary" onclick="closeModal('editBarangModal')">Batal</button>
                    <button type="submit" class="btn-sinfas-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Detail Informasi Alat -->
    <div id="detailBarangModal" class="modal-overlay">
        <div class="modal-card" style="max-width: 500px;">
            <div class="modal-header">
                <div class="modal-title">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg>
                    <span>Detail Alat / Barang</span>
                </div>
                <button class="modal-close-btn" onclick="closeModal('detailBarangModal')">&times;</button>
            </div>
            
            <div id="detailModalBody" style="font-size: 13px; line-height: 1.8;">
                <!-- Filled dynamically by JavaScript -->
            </div>

            <div class="form-actions">
                <button type="button" class="btn-sinfas-primary" onclick="closeModal('detailBarangModal')">Tutup</button>
            </div>
        </div>
    </div>

    <!-- MODAL: Hapus Alat -->
    <div id="deleteBarangModal" class="modal-overlay">
        <div class="modal-card" style="max-width: 440px; text-align: center;">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: #FEE2E2; color: #DC2626; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            </div>
            <h3 style="font-family: 'Gorditas', cursive; font-size: 18px; margin-bottom: 8px;">Hapus Data Alat</h3>
            <p style="font-size: 13px; color: #64748B; margin-bottom: 20px;">
                Apakah Anda yakin ingin menghapus <strong id="deleteBarangName" style="color: #0F172A;"></strong>? Data yang dihapus tidak dapat dipulihkan.
            </p>
            <form id="deleteBarangForm" method="POST">
                @csrf
                @method('DELETE')
                <div style="display: flex; justify-content: center; gap: 12px;">
                    <button type="button" class="btn-sinfas-secondary" onclick="closeModal('deleteBarangModal')">Batal</button>
                    <button type="submit" class="btn-action-sm btn-action-reject" style="padding: 8px 20px; font-size: 12.5px;">Hapus</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openEditModal(item) {
        const form = document.getElementById('editBarangForm');
        form.action = "{{ url('/admin/barang') }}/" + item.kode_barang;

        document.getElementById('edit_kode_barang').value = item.kode_barang;
        document.getElementById('edit_nama_barang').value = item.nama_barang || '';
        document.getElementById('edit_id_kategori').value = item.id_kategori || '';
        document.getElementById('edit_merk_model').value = item.merk_model || '';
        document.getElementById('edit_no_seri_pabrik').value = item.no_seri_pabrik || '';
        document.getElementById('edit_tahun_pembelian').value = item.tahun_pembelian || '';
        document.getElementById('edit_bahan').value = item.bahan || '';
        document.getElementById('edit_ukuran_dimensi').value = item.ukuran_dimensi || '';
        document.getElementById('edit_jumlah_baik').value = item.jumlah_baik || 0;
        document.getElementById('edit_jumlah_kurang_baik').value = item.jumlah_kurang_baik || 0;
        document.getElementById('edit_jumlah_rusak_berat').value = item.jumlah_rusak_berat || 0;
        document.getElementById('edit_keterangan').value = item.keterangan || '';

        openModal('editBarangModal');
    }

    function showDetailModal(item, namaKategori) {
        const photoHtml = item.foto 
            ? `<div style="width: 100%; height: 180px; border-radius: 12px; overflow: hidden; margin-bottom: 14px; border: 2px solid #CBD5E1;">
                <img src="{{ asset('storage') }}/${item.foto}" style="width:100%; height:100%; object-fit: cover;">
               </div>`
            : '';

        const html = `
            ${photoHtml}
            <div style="background: #F8FAFC; border: 1.5px solid #E2E8F0; border-radius: 12px; padding: 14px 16px;">
                <div><strong>Kode:</strong> <code>${item.kode_barang}</code></div>
                <div><strong>Nama:</strong> ${item.nama_barang}</div>
                <div><strong>Kategori:</strong> ${namaKategori}</div>
                <div><strong>Merk / Model:</strong> ${item.merk_model || '-'}</div>
                <div><strong>No Seri:</strong> ${item.no_seri_pabrik || '-'}</div>
                <div><strong>Tahun Beli:</strong> ${item.tahun_pembelian || '-'}</div>
                <div><strong>Dimensi / Bahan:</strong> ${item.ukuran_dimensi || '-'} / ${item.bahan || '-'}</div>
                <hr style="margin: 8px 0; border: none; border-top: 1px dashed #CBD5E1;">
                <div><strong>Stok Baik:</strong> <span style="color: #059669; font-weight: bold;">${item.jumlah_baik}</span> unit</div>
                <div><strong>Stok Kurang Baik:</strong> <span style="color: #D97706; font-weight: bold;">${item.jumlah_kurang_baik}</span> unit</div>
                <div><strong>Stok Rusak:</strong> <span style="color: #DC2626; font-weight: bold;">${item.jumlah_rusak_berat}</span> unit</div>
                <hr style="margin: 8px 0; border: none; border-top: 1px dashed #CBD5E1;">
                <div><strong>Keterangan:</strong> ${item.keterangan || 'Tidak ada keterangan khusus.'}</div>
            </div>
        `;

        document.getElementById('detailModalBody').innerHTML = html;
        openModal('detailBarangModal');
    }

    function openDeleteModal(kode, nama) {
        const form = document.getElementById('deleteBarangForm');
        form.action = "{{ url('/admin/barang') }}/" + kode;
        document.getElementById('deleteBarangName').innerText = nama + ' (' + kode + ')';
        openModal('deleteBarangModal');
    }
</script>
@endsection
