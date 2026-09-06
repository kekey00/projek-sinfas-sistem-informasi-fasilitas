@extends('layouts.admin')

@section('title', 'Kelola Kategori')

@section('page_title', 'Kelola Kategori')
@section('page_icon')
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    <rect x="3" y="3" width="7" height="7"></rect>
    <rect x="14" y="3" width="7" height="7"></rect>
    <rect x="14" y="14" width="7" height="7"></rect>
    <rect x="3" y="14" width="7" height="7"></rect>
</svg>
@endsection

@section('content')

    <!-- Card Kelola Kategori -->
    <div class="content-card">
        <!-- Card Header: Title, Search & Tambah Button -->
        <div class="card-header-row">
            <div>
                <div class="card-heading">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                        <rect x="3" y="3" width="7" height="7"></rect>
                        <rect x="14" y="3" width="7" height="7"></rect>
                        <rect x="14" y="14" width="7" height="7"></rect>
                        <rect x="3" y="14" width="7" height="7"></rect>
                    </svg>
                    <span>Daftar Kategori Fasilitas</span>
                </div>
                <div style="font-size: 12.5px; color: #64748B; margin-top: 2px;">
                    Kelola kelompok kategori untuk mengklasifikasikan seluruh inventaris fasilitas sekolah
                </div>
            </div>

            <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
                <!-- Filter Search -->
                <form action="{{ route('admin.kategori.index') }}" method="GET" style="display: flex; gap: 8px; align-items: center;">
                    <div style="position: relative; width: 220px;">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama kategori..." class="form-input" style="padding: 7px 10px 7px 28px; font-size: 12px;">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#64748B" stroke-width="2.5" style="position: absolute; left: 8px; top: 50%; transform: translateY(-50%);">
                            <circle cx="11" cy="11" r="8"></circle>
                            <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                        </svg>
                    </div>

                    @if(request('q'))
                        <a href="{{ route('admin.kategori.index') }}" class="btn-sinfas-secondary" style="padding: 6px 10px; font-size: 11px;">Reset</a>
                    @endif
                </form>

                <!-- Button Tambah Kategori -->
                <button type="button" class="btn-sinfas-primary" onclick="openModal('addKategoriModal')">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Tambah Kategori</span>
                </button>
            </div>
        </div>

        <!-- Tabel Kategori -->
        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">No</th>
                        <th>Nama Kategori</th>
                        <th>Jumlah Alat / Barang</th>
                        <th>Terdaftar Pada</th>
                        <th style="text-align: center; width: 140px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kategoris as $index => $kat)
                    <tr>
                        <td style="text-align: center; color: #64748B; font-weight: 600;">
                            {{ $kategoris->firstItem() + $index }}
                        </td>
                        <td>
                            <div style="font-weight: 600; font-size: 14px; color: #0F172A; display: flex; align-items: center; gap: 8px;">
                                <div style="width: 30px; height: 30px; border-radius: 8px; background: #EBF3FE; border: 1.5px solid var(--color-border-blue); display: flex; align-items: center; justify-content: center; color: var(--color-border-blue);">
                                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3">
                                        <rect x="3" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="3" width="7" height="7"></rect>
                                        <rect x="14" y="14" width="7" height="7"></rect>
                                        <rect x="3" y="14" width="7" height="7"></rect>
                                    </svg>
                                </div>
                                <span>{{ $kat->nama_kategori }}</span>
                            </div>
                        </td>
                        <td>
                            <a href="{{ route('admin.barang.index', ['kategori' => $kat->id_kategori]) }}" class="badge badge-info" style="text-decoration: none;" title="Klik untuk filter barang kategori ini">
                                {{ $kat->barangs_count }} Items
                            </a>
                        </td>
                        <td style="color: #64748B; font-family: monospace; font-size: 12px;">
                            {{ $kat->created_at ? $kat->created_at->format('d M Y') : '-' }}
                        </td>
                        <td>
                            <div class="actions-cell" style="justify-content: center;">
                                <!-- Tombol Edit -->
                                <button type="button" class="btn-action-sm btn-action-edit" title="Edit Kategori" onclick="openEditKategoriModal({{ $kat->id_kategori }}, '{{ $kat->nama_kategori }}')">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                                    <span>Edit</span>
                                </button>

                                <!-- Tombol Hapus -->
                                <button type="button" class="btn-action-sm btn-action-delete" title="Hapus Kategori" onclick="openDeleteKategoriModal({{ $kat->id_kategori }}, '{{ $kat->nama_kategori }}', {{ $kat->barangs_count }})">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
                                    <span>Hapus</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #94A3B8; padding: 32px 14px;">
                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1.8" style="margin-bottom: 8px;">
                                <rect x="3" y="3" width="7" height="7"></rect>
                                <rect x="14" y="3" width="7" height="7"></rect>
                                <rect x="14" y="14" width="7" height="7"></rect>
                                <rect x="3" y="14" width="7" height="7"></rect>
                            </svg>
                            <div>Belum ada kategori yang ditemukan.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div style="margin-top: 18px; display: flex; justify-content: flex-end;">
            {{ $kategoris->links() }}
        </div>
    </div>

    <!-- MODAL: Tambah Kategori -->
    <div id="addKategoriModal" class="modal-overlay">
        <div class="modal-card" style="max-width: 480px;">
            <div class="modal-header">
                <div class="modal-title">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                    <span>Tambah Kategori Baru</span>
                </div>
                <button class="modal-close-btn" onclick="closeModal('addKategoriModal')">&times;</button>
            </div>

            <form action="{{ route('admin.kategori.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label class="form-label">Nama Kategori <span style="color:red;">*</span></label>
                    <input type="text" name="nama_kategori" class="form-input" placeholder="Contoh: Multimedia, Olahraga, Kelistrikan" required autofocus>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-sinfas-secondary" onclick="closeModal('addKategoriModal')">Batal</button>
                    <button type="submit" class="btn-sinfas-primary">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Edit Kategori -->
    <div id="editKategoriModal" class="modal-overlay">
        <div class="modal-card" style="max-width: 480px;">
            <div class="modal-header">
                <div class="modal-title">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>
                    <span>Edit Kategori</span>
                </div>
                <button class="modal-close-btn" onclick="closeModal('editKategoriModal')">&times;</button>
            </div>

            <form id="editKategoriForm" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label class="form-label">Nama Kategori <span style="color:red;">*</span></label>
                    <input type="text" name="nama_kategori" id="edit_nama_kategori" class="form-input" required>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-sinfas-secondary" onclick="closeModal('editKategoriModal')">Batal</button>
                    <button type="submit" class="btn-sinfas-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL: Hapus Kategori -->
    <div id="deleteKategoriModal" class="modal-overlay">
        <div class="modal-card" style="max-width: 440px; text-align: center;">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: #FEE2E2; color: #DC2626; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path></svg>
            </div>
            <h3 style="font-family: 'Gorditas', cursive; font-size: 18px; margin-bottom: 8px;">Hapus Kategori</h3>
            <p style="font-size: 13px; color: #64748B; margin-bottom: 20px;">
                Apakah Anda yakin ingin menghapus kategori <strong id="deleteKategoriName" style="color: #0F172A;"></strong>?
            </p>
            <div id="deleteWarningAlert" style="display: none; background: #FFFBEB; border: 1.5px solid #F59E0B; border-radius: 10px; padding: 10px; font-size: 12px; color: #92400E; margin-bottom: 16px; text-align: left;">
                ⚠️ <strong>Perhatian:</strong> Kategori ini memiliki barang terkait dan tidak dapat dihapus sebelum semua barang di dalamnya dipindahkan atau dihapus.
            </div>
            <form id="deleteKategoriForm" method="POST">
                @csrf
                @method('DELETE')
                <div style="display: flex; justify-content: center; gap: 12px;">
                    <button type="button" class="btn-sinfas-secondary" onclick="closeModal('deleteKategoriModal')">Batal</button>
                    <button type="submit" id="confirmDeleteKatBtn" class="btn-action-sm btn-action-reject" style="padding: 8px 20px; font-size: 12.5px;">Hapus</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openEditKategoriModal(id, nama) {
        const form = document.getElementById('editKategoriForm');
        form.action = "{{ url('/admin/kategori') }}/" + id;
        document.getElementById('edit_nama_kategori').value = nama;
        openModal('editKategoriModal');
    }

    function openDeleteKategoriModal(id, nama, barangsCount) {
        const form = document.getElementById('deleteKategoriForm');
        form.action = "{{ url('/admin/kategori') }}/" + id;
        document.getElementById('deleteKategoriName').innerText = nama;

        const warning = document.getElementById('deleteWarningAlert');
        const btn = document.getElementById('confirmDeleteKatBtn');

        if (barangsCount > 0) {
            warning.style.display = 'block';
            btn.disabled = true;
            btn.style.opacity = '0.5';
            btn.style.cursor = 'not-allowed';
        } else {
            warning.style.display = 'none';
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.style.cursor = 'pointer';
        }

        openModal('deleteKategoriModal');
    }
</script>
@endsection
