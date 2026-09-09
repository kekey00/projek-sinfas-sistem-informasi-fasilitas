@extends('layouts.admin')

@section('title', 'Dashboard Admin Sarana')
@section('page_title', 'Beranda')

@section('styles')
<style>
    /* ─── STAT CARDS ─── */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }
    .stat-card {
        background: #FFFFFF;
        border-radius: 16px;
        padding: 20px 22px;
        box-shadow: 0 2px 12px rgba(44, 74, 124, 0.08);
        border: 1.5px solid #E8EDF8;
        display: flex;
        align-items: center;
        gap: 16px;
        transition: box-shadow .2s, transform .2s;
    }
    .stat-card:hover { box-shadow: 0 6px 20px rgba(44,74,124,.14); transform: translateY(-2px); }
    .stat-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .stat-icon.orange  { background: #FEF3C7; color: #D97706; }
    .stat-icon.blue    { background: #DBEAFE; color: #2563EB; }
    .stat-icon.green   { background: #DCFCE7; color: #16A34A; }
    .stat-icon.red     { background: #FEE2E2; color: #DC2626; }
    .stat-info { flex: 1; min-width: 0; }
    .stat-number {
        font-size: 32px; font-weight: 700; color: #0F172A;
        line-height: 1; letter-spacing: -0.5px;
    }
    .stat-label { font-size: 12.5px; font-weight: 500; color: #64748B; margin-top: 5px; }

    /* ─── SECTION WRAPPER ─── */
    .section-wrapper { margin-bottom: 24px; }
    .section-title {
        font-family: 'Baloo 2', sans-serif;
        font-size: 16px; font-weight: 700; color: #0F172A;
        margin-bottom: 12px;
        display: flex; align-items: center; gap: 8px;
    }
    .section-title svg { opacity: .65; }

    /* ─── TABLE ─── */
    .table-container {
        background: #FFFFFF;
        border-radius: 16px;
        border: 1.5px solid #E8EDF8;
        box-shadow: 0 2px 12px rgba(44, 74, 124, 0.06);
        overflow: hidden;
    }
    .dashboard-table { width: 100%; border-collapse: collapse; text-align: left; }
    .dashboard-table th {
        background: #F8FAFF;
        color: #64748B; font-size: 12px; font-weight: 600;
        padding: 13px 20px; border-bottom: 1.5px solid #EEF2FB;
        text-transform: uppercase; letter-spacing: .5px;
    }
    .dashboard-table td {
        padding: 14px 20px; border-bottom: 1px solid #F8FAFC;
        font-size: 13.5px; color: #1E293B; vertical-align: middle;
    }
    .dashboard-table tr:last-child td { border-bottom: none; }
    .dashboard-table tr:hover td { background: #FAFBFF; }

    /* ─── ACTION BUTTONS ─── */
    .btn-approve {
        background: #16A34A; color: #FFFFFF; border: none;
        border-radius: 8px; padding: 6px 16px;
        font-size: 12.5px; font-weight: 600; cursor: pointer;
        transition: background .15s; display: inline-flex; align-items: center; gap: 5px;
    }
    .btn-approve:hover { background: #15803D; }
    .btn-reject {
        background: #DC2626; color: #FFFFFF; border: none;
        border-radius: 8px; padding: 6px 16px;
        font-size: 12.5px; font-weight: 600; cursor: pointer;
        transition: background .15s; display: inline-flex; align-items: center; gap: 5px;
    }
    .btn-reject:hover { background: #B91C1C; }
    .actions-cell-wrapper { display: flex; align-items: center; gap: 8px; }

    /* ─── STATUS PILLS ─── */
    .status-pill {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 12px; border-radius: 20px;
        font-size: 12px; font-weight: 600; white-space: nowrap;
    }
    .status-pill.disetujui  { background: #DCFCE7; color: #15803D; }
    .status-pill.ditolak    { background: #FEE2E2; color: #B91C1C; }
    .status-pill.dikembalikan { background: #EDE9FE; color: #7C3AED; }
    .status-pill.menunggu   { background: #FEF3C7; color: #B45309; }
    .status-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; }

    /* ─── CHART ─── */
    .chart-section { margin-top: 6px; }
    .chart-box {
        background: #FFFFFF; border-radius: 16px; padding: 24px;
        border: 1.5px solid #E8EDF8;
        box-shadow: 0 2px 12px rgba(44, 74, 124, 0.06);
        position: relative;
    }
    .chart-canvas-wrapper { position: relative; height: 280px; width: 100%; }
    .chart-bottom-row {
        display: flex; align-items: center; justify-content: flex-start;
        margin-top: 14px; gap: 16px; padding-left: 10px; overflow-x: auto;
    }
    .chart-zero-label { font-size: 12px; color: #64748B; font-weight: 500; margin-right: 8px; }
    .legend-row-exact { display: flex; align-items: center; gap: 16px; flex-wrap: nowrap; }
    .legend-item-exact { display: flex; align-items: center; gap: 6px; font-size: 11.5px; color: #334155; white-space: nowrap; }
    .legend-box-color { width: 11px; height: 11px; border-radius: 2px; display: inline-block; flex-shrink: 0; }

    /* ─── EMPTY TABLE ─── */
    .table-empty { text-align: center; padding: 32px; color: #94A3B8; }
    .table-empty svg { opacity: .35; margin: 0 auto 10px; display: block; }
    .table-empty p { font-size: 13.5px; font-weight: 500; }
</style>
@endsection

@section('content')

    <!-- 1. Empat Kartu Statistik -->
    <div class="stat-cards-grid">

        <div class="stat-card">
            <div class="stat-icon orange">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $menungguCount }}</div>
                <div class="stat-label">Menunggu Verifikasi</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon blue">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $totalAlat }}</div>
                <div class="stat-label">Total Alat / Barang</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon green">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/>
                    <path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $sedangDipinjamCount }}</div>
                <div class="stat-label">Sedang Dipinjam</div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon red">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"/>
                    <line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/>
                </svg>
            </div>
            <div class="stat-info">
                <div class="stat-number">{{ $rusakCount }}</div>
                <div class="stat-label">Rusak Berat</div>
            </div>
        </div>

    </div>

    <!-- 2. Tabel Permintaan Peminjaman Menunggu -->
    <div class="section-wrapper">
        <h2 class="section-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#F59E0B" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
            Permintaan Peminjaman Menunggu
        </h2>

        <div class="table-container">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Nama Alat</th>
                        <th>Tgl. Pinjam</th>
                        <th>Tgl. Kembali</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingRequests as $req)
                    <tr>
                        <td style="font-weight: 600; color: #0F172A;">
                            {{ $req->siswa->nama ?? 'Siswa (NIS: ' . $req->nis . ')' }}
                        </td>
                        <td style="color: #334155;">
                            {{ $req->barang->nama_barang ?? $req->kode_barang }}
                        </td>
                        <td style="color: #475569;">
                            {{ $req->tanggal_pinjam ? $req->tanggal_pinjam->format('d M Y') : '-' }}
                        </td>
                        <td style="color: #475569;">
                            {{ $req->tanggal_kembali ? $req->tanggal_kembali->format('d M Y') : '-' }}
                        </td>
                        <td>
                            <div class="actions-cell-wrapper">
                                <form action="{{ route('admin.verifikasi.approve', $req->kode_pinjam) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn-approve">
                                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                                        Setujui
                                    </button>
                                </form>
                                <button type="button" class="btn-reject" onclick="openRejectModal('{{ $req->kode_pinjam }}', '{{ $req->barang->nama_barang ?? '' }}', '{{ $req->siswa->nama ?? 'Siswa' }}')">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                                    Tolak
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="table-empty">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/>
                                </svg>
                                <p>Tidak ada permohonan peminjaman yang menunggu</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3. Riwayat Peminjaman -->
    <div class="section-wrapper">
        <h2 class="section-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#6B7280" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/>
            </svg>
            Riwayat Peminjaman
        </h2>

        <div class="table-container">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th>Peminjam</th>
                        <th>Nama Alat</th>
                        <th>Tgl. Pinjam</th>
                        <th>Tgl. Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatPeminjaman as $rw)
                    <tr>
                        <td style="font-weight: 600; color: #0F172A;">
                            {{ $rw->siswa->nama ?? 'Siswa (NIS: ' . $rw->nis . ')' }}
                        </td>
                        <td style="color: #334155;">{{ $rw->barang->nama_barang ?? $rw->kode_barang }}</td>
                        <td style="color: #475569;">{{ $rw->tanggal_pinjam ? $rw->tanggal_pinjam->format('d M Y') : '-' }}</td>
                        <td style="color: #475569;">{{ $rw->tanggal_kembali ? $rw->tanggal_kembali->format('d M Y') : '-' }}</td>
                        <td>
                            @php
                                $st = $rw->status_pengajuan;
                                $stLabel = match($st) {
                                    'disetujui'    => 'Disetujui',
                                    'ditolak'      => 'Ditolak',
                                    'dikembalikan' => 'Dikembalikan',
                                    default        => ucfirst($st),
                                };
                            @endphp
                            <span class="status-pill {{ $st }}">
                                <span class="status-dot"></span>
                                {{ $stLabel }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">
                            <div class="table-empty">
                                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                    <polyline points="14 2 14 8 20 8"/>
                                </svg>
                                <p>Belum ada riwayat peminjaman</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 4. Bagian Grafik Tren Peminjaman -->
    <div class="chart-section">
        <h2 class="section-title">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#3B66C4" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round">
                <line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/>
                <line x1="6" y1="20" x2="6" y2="14"/><line x1="1" y1="20" x2="23" y2="20"/>
            </svg>
            Grafik Tren Peminjaman Alat
        </h2>

        <div class="chart-box">
            <div class="chart-canvas-wrapper">
                <canvas id="sinfasBarChart"></canvas>
            </div>
            <div class="chart-bottom-row">
                <span class="chart-zero-label">00</span>
                <div class="legend-row-exact">
                    <div class="legend-item-exact"><span class="legend-box-color" style="background: #FF7E79;"></span><span>Kabel HDMI 10 Meter</span></div>
                    <div class="legend-item-exact"><span class="legend-box-color" style="background: #38BDF8;"></span><span>Kamera DSLR Canon 3000D</span></div>
                    <div class="legend-item-exact"><span class="legend-box-color" style="background: #FBBF24;"></span><span>Wireless Presenter Laser</span></div>
                    <div class="legend-item-exact"><span class="legend-box-color" style="background: #60A5FA;"></span><span>Microphone Wireless Clip-on</span></div>
                    <div class="legend-item-exact"><span class="legend-box-color" style="background: #4ADE80;"></span><span>Tripod Kamera Takara</span></div>
                    <div class="legend-item-exact"><span class="legend-box-color" style="background: #A855F7;"></span><span>Speaker Portable ...</span></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Penolakan -->
    <div id="rejectModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-card-top"></div>
            <div class="modal-header">
                <div class="modal-title">Tolak Pengajuan</div>
                <button class="modal-close-btn" onclick="closeModal('rejectModal')">&times;</button>
            </div>
            <form id="rejectForm" method="POST">
                @csrf
                <div style="margin-bottom: 14px;">
                    <p style="font-size: 13.5px; color: #475569; margin-bottom: 10px;">
                        Tolak pengajuan peminjaman <strong id="rejectItemName"></strong> oleh <strong id="rejectStudentName"></strong>?
                    </p>
                    <label style="display: block; font-size: 13px; font-weight: 500; margin-bottom: 6px;">Alasan Penolakan</label>
                    <textarea name="alasan" class="form-textarea" rows="3" placeholder="Contoh: Barang sedang dalam perawatan atau jadwal bentrok" style="width: 100%; border: 1px solid #CBD5E1; border-radius: 8px; padding: 10px; font-family: inherit; font-size: 13px;"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn-cancel" onclick="closeModal('rejectModal')">Batal</button>
                    <button type="submit" class="btn-reject" style="padding: 8px 20px;">Konfirmasi Tolak</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    function openRejectModal(kodePinjam, itemName, studentName) {
        document.getElementById('rejectItemName').innerText = itemName;
        document.getElementById('rejectStudentName').innerText = studentName;
        document.getElementById('rejectForm').action = "{{ url('/admin/verifikasi/reject') }}/" + kodePinjam;
        openModal('rejectModal');
    }

    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('sinfasBarChart').getContext('2d');
        const labels = @json($chartLabels);
        const datasets = @json($chartDatasets);

        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: datasets
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        backgroundColor: '#1E293B',
                        titleFont: { size: 12, family: 'Poppins' },
                        bodyFont: { size: 11, family: 'Poppins' },
                        padding: 8,
                        cornerRadius: 6
                    }
                },
                scales: {
                    x: {
                        position: 'top',
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: { size: 12.5, family: 'Poppins', weight: '500' },
                            color: '#475569',
                            padding: 8
                        },
                        border: {
                            display: false
                        }
                    },
                    y: {
                        min: 0,
                        max: 100,
                        ticks: {
                            stepSize: 20,
                            font: { size: 12, family: 'Poppins' },
                            color: '#64748B'
                        },
                        grid: {
                            color: '#E2E8F0',
                            borderDash: [4, 4],
                            drawTicks: false
                        },
                        border: {
                            display: false
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
