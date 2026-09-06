@extends('layouts.admin')

@section('title', 'Dashboard Admin Sarana')

@section('page_title', 'Home')
@section('page_icon')
<svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
    <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
    <polyline points="9 22 9 12 15 12 15 22"></polyline>
</svg>
@endsection

@section('styles')
<style>
    /* 4 Summary Cards Grid */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
    }

    .stat-card {
        background: #CBE3FC;
        border: 2.5px solid var(--color-border-blue);
        border-radius: 18px;
        padding: 16px 18px;
        box-shadow: 0 6px 16px rgba(44, 74, 124, 0.12);
        display: flex;
        align-items: center;
        justify-content: space-between;
        transition: all 0.25s ease;
        position: relative;
        overflow: hidden;
        text-decoration: none;
    }

    .stat-card:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 10px 22px rgba(44, 74, 124, 0.2);
    }

    .stat-info {
        display: flex;
        flex-direction: column;
        z-index: 2;
    }

    .stat-number {
        font-family: 'Fredoka', sans-serif;
        font-size: 38px;
        font-weight: 700;
        color: #FFFFFF;
        line-height: 1;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.45);
    }

    .stat-label {
        font-family: 'Gorditas', cursive;
        font-size: 12px;
        font-weight: 700;
        color: #152644;
        margin-top: 5px;
        letter-spacing: 0.2px;
    }

    .stat-card-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        background: rgba(255, 255, 255, 0.75);
        border: 1.5px solid var(--color-border-blue);
        color: var(--color-border-blue);
        box-shadow: 0 3px 8px rgba(0,0,0,0.06);
        z-index: 2;
    }

    .stat-card.damaged {
        background: #FEE2E2;
        border-color: #DC2626;
    }

    .stat-card.damaged .stat-number {
        color: #DC2626;
        text-shadow: 1px 1px 2px rgba(220, 38, 38, 0.2);
    }

    .stat-card.damaged .stat-label {
        color: #991B1B;
    }

    .stat-card.damaged .stat-card-icon {
        background: #FFFFFF;
        border-color: #DC2626;
        color: #DC2626;
    }

    /* Chart Card */
    .chart-container {
        width: 100%;
        height: 270px;
        position: relative;
    }

    .chart-legend-row {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: center;
        gap: 10px;
        margin-top: 14px;
        font-family: 'Poppins', sans-serif;
        font-size: 11.5px;
        color: #4B5563;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        cursor: pointer;
        padding: 4px 10px;
        border-radius: 12px;
        background: #F1F6FD;
        border: 1px solid #E2E8F0;
        transition: all 0.2s ease;
    }

    .legend-item:hover {
        background: #E0EDFD;
        border-color: var(--color-border-blue);
        transform: scale(1.03);
    }

    .legend-dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        border: 2.5px solid;
        background: #FFFFFF;
        display: inline-block;
    }

    .item-icon-tag {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        background: #CBE3FC;
        border: 1.5px solid var(--color-border-blue);
        color: var(--color-border-blue);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    @media (max-width: 768px) {
        .stat-cards-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
</style>
@endsection

@section('content')

    <!-- 4 Statistic Summary Cards (SINFAS Glossy Theme) -->
    <div class="stat-cards-grid">
        
        <!-- 1. Menunggu Verifikasi -->
        <a href="{{ route('admin.verifikasi.index', ['tab' => 'requests']) }}" class="stat-card" title="Lihat Pengajuan Menunggu">
            <div class="stat-info">
                <span class="stat-number">{{ $menungguCount }}</span>
                <span class="stat-label">Menunggu Verifikasi</span>
            </div>
            <div class="stat-card-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="12 6 12 12 16 14"></polyline>
                </svg>
            </div>
        </a>

        <!-- 2. Total Alat -->
        <a href="{{ route('admin.barang.index') }}" class="stat-card" title="Lihat Kelola Alat">
            <div class="stat-info">
                <span class="stat-number">{{ $totalAlat }}</span>
                <span class="stat-label">Total Alat</span>
            </div>
            <div class="stat-card-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                    <polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
                    <line x1="12" y1="22.08" x2="12" y2="12"></line>
                </svg>
            </div>
        </a>

        <!-- 3. Sedang Dipinjam -->
        <a href="{{ route('admin.verifikasi.index', ['tab' => 'returns']) }}" class="stat-card" title="Lihat Peminjaman Aktif">
            <div class="stat-info">
                <span class="stat-number">{{ $sedangDipinjamCount }}</span>
                <span class="stat-label">Sedang Dipinjam</span>
            </div>
            <div class="stat-card-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <polyline points="17 1 21 5 17 9"></polyline>
                    <path d="M3 11V9a4 4 0 0 1 4-4h14"></path>
                    <polyline points="7 23 3 19 7 15"></polyline>
                    <path d="M21 13v2a4 4 0 0 1-4 4H3"></path>
                </svg>
            </div>
        </a>

        <!-- 4. Rusak -->
        <a href="{{ route('admin.barang.index', ['kondisi' => 'Rusak Berat']) }}" class="stat-card damaged" title="Lihat Alat Rusak">
            <div class="stat-info">
                <span class="stat-number">{{ $rusakCount }}</span>
                <span class="stat-label">Rusak</span>
            </div>
            <div class="stat-card-icon">
                <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z"></path>
                    <line x1="12" y1="9" x2="12" y2="13"></line>
                    <line x1="12" y1="17" x2="12.01" y2="17"></line>
                </svg>
            </div>
        </a>

    </div>

    <!-- Tabel Permintaan Peminjaman Menunggu -->
    <div class="content-card">
        <div class="card-header-row">
            <div class="card-heading">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                    <polyline points="14 2 14 8 20 8"></polyline>
                    <line x1="16" y1="13" x2="8" y2="13"></line>
                    <line x1="16" y1="17" x2="8" y2="17"></line>
                </svg>
                <span>Permintaan Peminjaman Menunggu</span>
            </div>
            <a href="{{ route('admin.verifikasi.index') }}" class="btn-sinfas-secondary" style="font-size: 11.5px;">
                Lihat Semua &rarr;
            </a>
        </div>
        
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Peminjam</th>
                    <th>Nama Alat</th>
                    <th>Tanggal Pinjam</th>
                    <th>Rencana Kembali</th>
                    <th style="text-align: center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendingRequests as $req)
                <tr>
                    <td>
                        <strong>{{ $req->siswa->nama ?? 'Siswa (NIS: ' . $req->nis . ')' }}</strong>
                    </td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div class="item-icon-tag">
                                <svg width="17" height="17" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2">
                                    <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
                                </svg>
                            </div>
                            <span>{{ $req->barang->nama_barang ?? $req->kode_barang }}</span>
                        </div>
                    </td>
                    <td style="color: #64748B; font-family: monospace; font-weight: 600;">
                        {{ $req->tanggal_pinjam ? $req->tanggal_pinjam->format('Y-m-d') : '-' }}
                    </td>
                    <td style="color: #64748B; font-family: monospace; font-weight: 600;">
                        {{ $req->tanggal_kembali ? $req->tanggal_kembali->format('Y-m-d') : '-' }}
                    </td>
                    <td>
                        <div class="actions-cell" style="justify-content: center;">
                            <!-- Form Setujui -->
                            <form action="{{ route('admin.verifikasi.approve', $req->kode_pinjam) }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="btn-action-sm btn-action-approve" onclick="return confirm('Setujui peminjaman {{ $req->barang->nama_barang ?? '' }} untuk {{ $req->siswa->nama ?? 'siswa' }}?')">
                                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><polyline points="20 6 9 17 4 12"></polyline></svg>
                                    <span>Setujui</span>
                                </button>
                            </form>

                            <!-- Button Tolak (Open Modal) -->
                            <button type="button" class="btn-action-sm btn-action-reject" onclick="openRejectModal('{{ $req->kode_pinjam }}', '{{ $req->barang->nama_barang ?? '' }}', '{{ $req->siswa->nama ?? 'Siswa' }}')">
                                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                <span>Tolak</span>
                            </button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; color: #94A3B8; padding: 28px 14px;">
                        <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#CBD5E1" stroke-width="1.8" style="margin-bottom: 6px;">
                            <circle cx="12" cy="12" r="10"></circle>
                            <polyline points="12 6 12 12 14 14"></polyline>
                        </svg>
                        <div>Tidak ada permintaan peminjaman yang menunggu verifikasi saat ini.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Grafik Tren Peminjaman Alat -->
    <div class="content-card">
        <div class="card-heading" style="margin-bottom: 12px;">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.3"><path d="M3 3v18h18"></path><path d="M18 9l-5 5-4-4-6 6"></path></svg>
            <span>Tren Peminjaman Alat</span>
        </div>

        <div class="chart-container">
            <canvas id="trendsChart"></canvas>
        </div>

        <!-- Legend Items -->
        <div class="chart-legend-row" id="customLegendRow">
            @foreach($chartDatasets as $idx => $ds)
            <div class="legend-item" onclick="toggleDataset({{ $idx }})">
                <span class="legend-dot" style="border-color: {{ $ds['borderColor'] }};"></span>
                <span>{{ $ds['label'] }}</span>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Modal: Tolak Pengajuan -->
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
                    <label class="form-label">Alasan Penolakan:</label>
                    <textarea name="alasan_penolakan" class="form-textarea" rows="3" placeholder="Contoh: Alat sedang dalam proses perbaikan / acara prioritas sekolah" required></textarea>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn-sinfas-secondary" onclick="closeModal('rejectModal')">Batal</button>
                    <button type="submit" class="btn-action-sm btn-action-reject" style="padding: 8px 18px; font-size: 12.5px;">Konfirmasi Tolak</button>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('scripts')
<script>
    const chartLabels = {!! json_encode($chartLabels) !!};
    const chartDatasets = {!! json_encode($chartDatasets) !!};

    const ctx = document.getElementById('trendsChart').getContext('2d');
    const trendsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: chartDatasets
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#1E293B',
                    titleFont: { family: 'Poppins', size: 12, weight: 'bold' },
                    bodyFont: { family: 'Poppins', size: 11.5 },
                    padding: 10,
                    cornerRadius: 8,
                }
            },
            scales: {
                x: {
                    grid: { color: '#F1F5F9', drawBorder: false },
                    ticks: { font: { family: 'Poppins', size: 12 }, color: '#64748B' }
                },
                y: {
                    beginAtZero: true,
                    position: 'right',
                    ticks: {
                        precision: 0,
                        font: { family: 'Poppins', size: 12 },
                        color: '#64748B'
                    },
                    grid: {
                        color: '#E2E8F0',
                        borderDash: [4, 4],
                        drawBorder: false
                    }
                }
            }
        }
    });

    function toggleDataset(index) {
        const isVisible = trendsChart.isDatasetVisible(index);
        trendsChart.setDatasetVisibility(index, !isVisible);
        trendsChart.update();
    }

    function openRejectModal(kodePinjam, namaBarang, namaSiswa) {
        const form = document.getElementById('rejectForm');
        form.action = "{{ url('/admin/verifikasi/reject') }}/" + kodePinjam;
        document.getElementById('rejectModalDesc').innerText = 
            'Tolak pengajuan peminjaman "' + namaBarang + '" oleh ' + namaSiswa + ':';
        openModal('rejectModal');
    }
</script>
@endsection
