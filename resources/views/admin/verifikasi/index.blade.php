@extends('layouts.admin')

@section('title', 'Verifikasi Pengajuan & Pengembalian')

@section('page_title', 'Verifikasi Pengajuan & Pengembalian')
@section('page_icon')
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    <path d="M9 11l3 3L22 4"></path>
    <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"></path>
</svg>
@endsection

@section('styles')
<style>
    /* Tab Switcher */
    .tab-nav {
        display: flex;
        gap: 8px;
        background: #EBF3FE;
        padding: 6px;
        border-radius: 14px;
        border: 1.5px solid var(--color-border-blue);
        width: fit-content;
        margin-bottom: 20px;
    }

    .tab-btn {
        padding: 8px 18px;
        border-radius: 10px;
        border: none;
        background: transparent;
        font-family: 'Gorditas', cursive;
        font-size: 12.5px;
        color: #475569;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
        text-decoration: none;
    }

    .tab-btn:hover {
        color: var(--color-border-blue);
        background: rgba(255, 255, 255, 0.6);
    }

    .tab-btn.active {
        background: #FFFFFF;
        color: var(--color-dark-blue-bubble);
        box-shadow: 0 3px 8px rgba(59, 89, 152, 0.15);
        font-weight: 700;
    }

    .tab-badge {
        background: #EF4444;
        color: #FFFFFF;
        padding: 2px 7px;
        border-radius: 10px;
        font-size: 10.5px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
    }

    .tab-badge-blue {
        background: #3B82F6;
        color: #FFFFFF;
        padding: 2px 7px;
        border-radius: 10px;
        font-size: 10.5px;
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
    }
</style>
@endsection

@section('content')

    <!-- Tab Bar -->
    <div class="tab-nav">
        <a href="{{ route('admin.verifikasi.index', ['tab' => 'requests']) }}" class="tab-btn {{ $tab === 'requests' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
            <span>Pengajuan Pinjam (Pending)</span>
            @if($pendingRequests->total() > 0)
                <span class="tab-badge">{{ $pendingRequests->total() }}</span>
            @endif
        </a>

        <a href="{{ route('admin.verifikasi.index', ['tab' => 'returns']) }}" class="tab-btn {{ $tab === 'returns' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
            <span>Pengembalian (Aktif)</span>
            @if($activeLoans->total() > 0)
                <span class="tab-badge-blue">{{ $activeLoans->total() }}</span>
            @endif
        </a>

        <a href="{{ route('admin.verifikasi.index', ['tab' => 'history']) }}" class="tab-btn {{ $tab === 'history' ? 'active' : '' }}">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
            <span>Riwayat Selesai</span>
        </a>
    </div>

    <!-- ======================================================== -->
    <!-- TAB 1: PENDING REQUESTS (Pengajuan Pinjam)                -->
    <!-- ======================================================== -->
    @if($tab === 'requests')
    <div class="content-card">
        <div class="card-header-row">
            <div>
                <div class="card-heading">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
                    <span>Permohonan Pinjam Menunggu Verifikasi</span>
                </div>
                <div style="font-size: 12.5px; color: #64748B; margin-top: 2px;">
                    Verifikasi pengajuan peminjaman alat oleh siswa sebelum barang diserahkan
                </div>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Kode Pinjam</th>
                        <th>Peminjam (Siswa)</th>
                        <th>Nama Alat / Barang</th>
                        <th>Tgl Pinjam</th>
                        <th>Rencana Kembali</th>
                        <th>Keperluan</th>
                        <th style="text-align: center; width: 170px;">Aksi Verifikasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingRequests as $pjm)
                    <tr>
                        <td>
                            <code style="background: #EBF3FE; padding: 3px 6px; border-radius: 6px; font-size: 11.5px; color: var(--color-border-blue); font-weight: 600;">
                                {{ $pjm->kode_pinjam }}
                            </code>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #0F172A;">{{ $pjm->siswa->nama ?? 'Siswa' }}</div>
                            <div style="font-size: 11.5px; color: #64748B;">NIS: {{ $pjm->nis }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #0F172A;">{{ $pjm->barang->nama_barang ?? $pjm->kode_barang }}</div>
                            <div style="font-size: 11.5px; color: #64748B;">
                                Sisa Stok Baik: 
                                <strong style="color: {{ ($pjm->barang->jumlah_baik ?? 0) > 0 ? '#059669' : '#DC2626' }};">
                                    {{ $pjm->barang->jumlah_baik ?? 0 }}
                                </strong>
                            </div>
                        </td>
                        <td style="font-family: monospace; font-weight: 600; color: #334155;">
                            {{ $pjm->tanggal_pinjam ? $pjm->tanggal_pinjam->format('d M Y') : '-' }}
                        </td>
                        <td style="font-family: monospace; font-weight: 600; color: #334155;">
                            {{ $pjm->tanggal_kembali ? $pjm->tanggal_kembali->format('d M Y') : '-' }}
                        </td>
                        <td>
                            <div style="max-width: 220px; font-size: 12px; color: #475569; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;" title="{{ $pjm->keterangan_penggunaan }}">
                                {{ $pjm->keterangan_penggunaan }}
                            </div>
                        </td>
                        <td>
                            <div class="actions-cell" style="justify-content: center;">
                                <!-- Tombol Setujui -->
                                <button type="button" class="btn-action-sm btn-action-approve" onclick="openApproveModal('{{ $pjm->kode_pinjam }}', '{{ $pjm->barang->nama_barang ?? '' }}', '{{ $pjm->siswa->nama ?? 'Siswa' }}', {{ $pjm->barang->jumlah_baik ?? 0 }})">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    <span>Setujui</span>
                                </button>

                                <!-- Tombol Tolak -->
                                <button type="button" class="btn-action-sm btn-action-reject" onclick="openRejectModal('{{ $pjm->kode_pinjam }}', '{{ $pjm->barang->nama_barang ?? '' }}', '{{ $pjm->siswa->nama ?? 'Siswa' }}')">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                    <span>Tolak</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #94A3B8; padding: 36px 14px;">
                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1.8" style="margin-bottom: 8px;">
                                <circle cx="12" cy="12" r="10"></circle>
                                <polyline points="12 6 12 12 16 14"></polyline>
                            </svg>
                            <div>Tidak ada permohonan pinjam yang perlu diverifikasi saat ini.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 18px; display: flex; justify-content: flex-end;">
            {{ $pendingRequests->links() }}
        </div>
    </div>
    @endif

    <!-- ======================================================== -->
    <!-- TAB 2: PENDING RETURNS (Verifikasi Pengembalian Alat)      -->
    <!-- ======================================================== -->
    @if($tab === 'returns')
    <div class="content-card">
        <div class="card-header-row">
            <div>
                <div class="card-heading">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path></svg>
                    <span>Daftar Peminjaman Aktif (Menunggu Dikembalikan)</span>
                </div>
                <div style="font-size: 12.5px; color: #64748B; margin-top: 2px;">
                    Verifikasi fisik pengembalian barang yang sedang dipinjam oleh siswa
                </div>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Kode Pinjam</th>
                        <th>Peminjam (Siswa)</th>
                        <th>Nama Alat / Barang</th>
                        <th>Tgl Mulai Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Status Waktu</th>
                        <th style="text-align: center; width: 170px;">Aksi Pengembalian</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activeLoans as $active)
                    @php
                        $isOverdue = $active->tanggal_kembali && $active->tanggal_kembali->isPast() && !$active->tanggal_kembali->isToday();
                    @endphp
                    <tr>
                        <td>
                            <code style="background: #EBF3FE; padding: 3px 6px; border-radius: 6px; font-size: 11.5px; color: var(--color-border-blue); font-weight: 600;">
                                {{ $active->kode_pinjam }}
                            </code>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #0F172A;">{{ $active->siswa->nama ?? 'Siswa' }}</div>
                            <div style="font-size: 11.5px; color: #64748B;">NIS: {{ $active->nis }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #0F172A;">{{ $active->barang->nama_barang ?? $active->kode_barang }}</div>
                            <span class="badge badge-info">{{ $active->barang->kategori->nama_kategori ?? '-' }}</span>
                        </td>
                        <td style="font-family: monospace; font-weight: 600; color: #334155;">
                            {{ $active->tanggal_pinjam ? $active->tanggal_pinjam->format('d M Y') : '-' }}
                        </td>
                        <td style="font-family: monospace; font-weight: 600; color: #334155;">
                            {{ $active->tanggal_kembali ? $active->tanggal_kembali->format('d M Y') : '-' }}
                        </td>
                        <td>
                            @if($isOverdue)
                                <span class="badge badge-danger">Lewat Batas</span>
                            @else
                                <span class="badge badge-warning">Sedang Dipinjam</span>
                            @endif
                        </td>
                        <td style="text-align: center;">
                            <!-- Tombol Verifikasi Pengembalian -->
                            <button type="button" class="btn-sinfas-primary" style="font-size: 11.5px; padding: 6px 12px;" onclick="openReturnModal('{{ $active->kode_pinjam }}', '{{ $active->barang->nama_barang ?? '' }}', '{{ $active->siswa->nama ?? 'Siswa' }}')">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                <span>Terima Kembali</span>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #94A3B8; padding: 36px 14px;">
                            <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1.8" style="margin-bottom: 8px;">
                                <polyline points="1 4 1 10 7 10"></polyline><path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10"></path>
                            </svg>
                            <div>Saat ini tidak ada barang fasilitas yang sedang aktif dipinjam.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 18px; display: flex; justify-content: flex-end;">
            {{ $activeLoans->links() }}
        </div>
    </div>
    @endif

    <!-- ======================================================== -->
    <!-- TAB 3: RIWAYAT SELESAI                                    -->
    <!-- ======================================================== -->
    @if($tab === 'history')
    <div class="content-card">
        <div class="card-header-row">
            <div>
                <div class="card-heading">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                    <span>Riwayat Peminjaman Selesai &amp; Ditolak</span>
                </div>
                <div style="font-size: 12.5px; color: #64748B; margin-top: 2px;">
                    Arsip lengkap data peminjaman yang telah selesai dikembalikan atau ditolak
                </div>
            </div>
        </div>

        <div style="overflow-x: auto;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Kode Pinjam</th>
                        <th>Peminjam (Siswa)</th>
                        <th>Nama Alat / Barang</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tgl Selesai / Dikembalikan</th>
                        <th>Status Akhir</th>
                        <th>Kondisi Saat Kembali</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($historyLoans as $hist)
                    <tr>
                        <td>
                            <code style="background: #EBF3FE; padding: 3px 6px; border-radius: 6px; font-size: 11.5px; color: var(--color-border-blue); font-weight: 600;">
                                {{ $hist->kode_pinjam }}
                            </code>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #0F172A;">{{ $hist->siswa->nama ?? 'Siswa' }}</div>
                            <div style="font-size: 11.5px; color: #64748B;">NIS: {{ $hist->nis }}</div>
                        </td>
                        <td>
                            <div style="font-weight: 600; color: #0F172A;">{{ $hist->barang->nama_barang ?? $hist->kode_barang }}</div>
                        </td>
                        <td style="font-family: monospace; font-size: 12px; color: #475569;">
                            {{ $hist->tanggal_pinjam ? $hist->tanggal_pinjam->format('d M Y') : '-' }}
                        </td>
                        <td style="font-family: monospace; font-size: 12px; color: #475569;">
                            @if($hist->pengembalian)
                                {{ $hist->pengembalian->tanggal_kembali ? $hist->pengembalian->tanggal_kembali->format('d M Y') : '-' }}
                            @else
                                {{ $hist->updated_at ? $hist->updated_at->format('d M Y') : '-' }}
                            @endif
                        </td>
                        <td>
                            @if($hist->status_pengajuan === 'ditolak')
                                <span class="badge badge-danger">Ditolak</span>
                            @elseif($hist->pengembalian)
                                <span class="badge badge-success">Dikembalikan</span>
                            @else
                                <span class="badge badge-info">{{ ucfirst($hist->status_pengajuan) }}</span>
                            @endif
                        </td>
                        <td>
                            @if($hist->pengembalian)
                                @if($hist->pengembalian->kondisi_barang === 'Baik')
                                    <span class="badge badge-success">Baik</span>
                                @elseif($hist->pengembalian->kondisi_barang === 'Kurang Baik')
                                    <span class="badge badge-warning">Kurang Baik</span>
                                @else
                                    <span class="badge badge-danger">Rusak Berat</span>
                                @endif
                            @else
                                <span style="color: #94A3B8; font-size: 12px;">-</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: #94A3B8; padding: 36px 14px;">
                            <div>Belum ada riwayat peminjaman yang tersimpan.</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 18px; display: flex; justify-content: flex-end;">
            {{ $historyLoans->links() }}
        </div>
    </div>
    @endif

    <!-- ======================================================== -->
    <!-- MODALS SECTION                                           -->
    <!-- ======================================================== -->

    <!-- MODAL 1: Konfirmasi Persetujuan -->
    <div id="approveModal" class="modal-overlay">
        <div class="modal-card" style="max-width: 460px; text-align: center;">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: #DEF7EC; color: #059669; display: flex; align-items: center; justify-content: center; margin: 0 auto 14px;">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
            </div>
            <h3 style="font-family: 'Gorditas', cursive; font-size: 18px; margin-bottom: 8px;">Konfirmasi Persetujuan</h3>
            <p style="font-size: 13px; color: #64748B; margin-bottom: 12px;" id="approveModalText">
                Setujui permohonan peminjaman ini?
            </p>
            <div id="approveStockAlert" style="background: #F1F5F9; border-radius: 10px; padding: 10px; font-size: 12.5px; color: #334155; margin-bottom: 20px;">
                <!-- Filled dynamically -->
            </div>
            <form id="approveForm" method="POST">
                @csrf
                <div style="display: flex; justify-content: center; gap: 12px;">
                    <button type="button" class="btn-sinfas-secondary" onclick="closeModal('approveModal')">Batal</button>
                    <button type="submit" id="confirmApproveBtn" class="btn-action-sm btn-action-approve" style="padding: 8px 22px; font-size: 12.5px;">Ya, Setujui</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 2: Tolak Pengajuan -->
    <div id="rejectModal" class="modal-overlay">
        <div class="modal-card" style="max-width: 460px;">
            <div class="modal-header">
                <div class="modal-title">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#DC2626" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                    <span>Tolak Pengajuan</span>
                </div>
                <button class="modal-close-btn" onclick="closeModal('rejectModal')">&times;</button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <p style="font-size: 13px; color: #475569; margin-bottom: 14px;" id="rejectModalDesc">
                    Berikan alasan penolakan peminjaman alat ini:
                </p>
                <div class="form-group">
                    <label class="form-label">Alasan Penolakan <span style="color:red;">*</span></label>
                    <textarea name="alasan_penolakan" class="form-textarea" rows="3" placeholder="Contoh: Alat sedang dipersiapkan untuk ujian praktik / stok habis" required></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-sinfas-secondary" onclick="closeModal('rejectModal')">Batal</button>
                    <button type="submit" class="btn-action-sm btn-action-reject" style="padding: 8px 18px; font-size: 12.5px;">Konfirmasi Tolak</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL 3: Verifikasi Pengembalian Alat (Kondisi Saat Kembali) -->
    <div id="returnModal" class="modal-overlay">
        <div class="modal-card" style="max-width: 500px;">
            <div class="modal-header">
                <div class="modal-title">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    <span>Verifikasi Pengembalian Alat</span>
                </div>
                <button class="modal-close-btn" onclick="closeModal('returnModal')">&times;</button>
            </div>

            <form id="returnForm" method="POST">
                @csrf
                <div style="background: #EBF3FE; border: 1.5px solid var(--color-border-blue); border-radius: 12px; padding: 12px; margin-bottom: 16px; font-size: 13px;">
                    <div><strong>Kode Pinjam:</strong> <code id="returnModalKode"></code></div>
                    <div><strong>Nama Alat:</strong> <span id="returnModalAlat"></span></div>
                    <div><strong>Peminjam:</strong> <span id="returnModalPeminjam"></span></div>
                </div>

                <div class="form-group">
                    <label class="form-label">Tanggal Pengembalian Fisik <span style="color:red;">*</span></label>
                    <input type="date" name="tanggal_kembali" class="form-input" value="{{ date('Y-m-d') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label">Kondisi Alat Saat Diterima Kembali <span style="color:red;">*</span></label>
                    <select name="kondisi_barang" class="form-select" required>
                        <option value="Baik" selected>✅ Kondisi Baik (Normal tanpa kerusakan)</option>
                        <option value="Kurang Baik">⚠️ Kurang Baik (Ada baret/kelengkapan kurang)</option>
                        <option value="Rusak Berat">❌ Rusak Berat (Tidak berfungsi / rusak fisik)</option>
                    </select>
                </div>

                <div class="form-group">
                    <label class="form-label">Catatan / Keterangan Kondisi</label>
                    <textarea name="catatan" class="form-textarea" rows="2" placeholder="Tuliskan catatan pemeriksaan kelengkapan (misal: kabel HDMI lengkap, lensa bersih)"></textarea>
                </div>

                <div class="form-actions">
                    <button type="button" class="btn-sinfas-secondary" onclick="closeModal('returnModal')">Batal</button>
                    <button type="submit" class="btn-sinfas-primary">Konfirmasi Pengembalian</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openApproveModal(kodePinjam, namaAlat, namaSiswa, stokBaik) {
        const form = document.getElementById('approveForm');
        form.action = "{{ url('/admin/verifikasi/approve') }}/" + kodePinjam;

        document.getElementById('approveModalText').innerHTML = 
            'Setujui permohonan peminjaman alat <strong>' + namaAlat + '</strong> oleh siswa <strong>' + namaSiswa + '</strong>?';

        const alertBox = document.getElementById('approveStockAlert');
        const btn = document.getElementById('confirmApproveBtn');

        if (stokBaik < 1) {
            alertBox.innerHTML = '<span style="color: #DC2626; font-weight: bold;">⚠️ Perhatian: Stok barang kondisi baik habis (0). Anda tidak dapat menyetujui peminjaman ini.</span>';
            btn.disabled = true;
            btn.style.opacity = '0.5';
            btn.style.cursor = 'not-allowed';
        } else {
            alertBox.innerHTML = 'Saat disetujui, <strong>1 unit stok kondisi baik</strong> akan dialokasikan ke peminjam. (Sisa stok baik saat ini: <strong>' + stokBaik + '</strong>)';
            btn.disabled = false;
            btn.style.opacity = '1';
            btn.style.cursor = 'pointer';
        }

        openModal('approveModal');
    }

    function openRejectModal(kodePinjam, namaAlat, namaSiswa) {
        const form = document.getElementById('rejectForm');
        form.action = "{{ url('/admin/verifikasi/reject') }}/" + kodePinjam;

        document.getElementById('rejectModalDesc').innerHTML = 
            'Tolak permohonan peminjaman alat <strong>' + namaAlat + '</strong> oleh siswa <strong>' + namaSiswa + '</strong>:';

        openModal('rejectModal');
    }

    function openReturnModal(kodePinjam, namaAlat, namaSiswa) {
        const form = document.getElementById('returnForm');
        form.action = "{{ url('/admin/verifikasi/pengembalian') }}/" + kodePinjam;

        document.getElementById('returnModalKode').innerText = kodePinjam;
        document.getElementById('returnModalAlat').innerText = namaAlat;
        document.getElementById('returnModalPeminjam').innerText = namaSiswa;

        openModal('returnModal');
    }
</script>
@endsection
