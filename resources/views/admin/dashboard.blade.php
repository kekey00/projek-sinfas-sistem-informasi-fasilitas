@extends('layouts.admin')

@section('title', 'Admin Sarana Dashboard')
@section('page_title', 'Home')

@section('styles')
<style>
    /* ─── 4 STAT CARDS ─────────────────────────────────────── */
    .stat-cards-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-bottom: 24px;
    }

    .stat-card {
        background: #FFFFFF;
        border-radius: 8px;
        padding: 20px 22px;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        border: 1px solid #E2E8F0;
        display: flex;
        flex-direction: column;
        justify-content: center;
    }

    .stat-number {
        font-size: 34px;
        font-weight: 700;
        color: #0F172A;
        line-height: 1;
        letter-spacing: -0.5px;
    }

    .stat-label {
        font-size: 13px;
        font-weight: 400;
        color: #64748B;
        margin-top: 6px;
    }

    .stat-label.damaged {
        color: #D97706; /* Golden Amber / Orange Sesuai Gambar */
        font-weight: 500;
    }

    /* ─── PENDING LOAN REQUESTS ───────────────────────────── */
    .section-wrapper {
        margin-bottom: 24px;
    }

    .section-title {
        font-size: 15px;
        font-weight: 700;
        color: #0F172A;
        margin-bottom: 12px;
    }

    .table-container {
        background: #FFFFFF;
        border-radius: 8px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .dashboard-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
    }

    .dashboard-table th {
        background: #FFFFFF;
        color: #64748B;
        font-size: 13px;
        font-weight: 500;
        padding: 14px 24px;
        border-bottom: 1px solid #F1F5F9;
    }

    .dashboard-table td {
        padding: 16px 24px;
        border-bottom: 1px solid #F8FAFC;
        font-size: 13.5px;
        color: #1E293B;
        vertical-align: middle;
    }

    .dashboard-table tr:last-child td {
        border-bottom: none;
    }

    .btn-approve {
        background: #16A34A;
        color: #FFFFFF;
        border: none;
        border-radius: 6px;
        padding: 6px 20px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.15s ease;
    }

    .btn-approve:hover {
        background: #15803D;
    }

    .btn-reject {
        background: #DC2626;
        color: #FFFFFF;
        border: none;
        border-radius: 6px;
        padding: 6px 20px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.15s ease;
    }

    .btn-reject:hover {
        background: #B91C1C;
    }

    .actions-cell-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    /* ─── BAR LINE CHART ──────────────────────────────────── */
    .chart-section {
        margin-top: 6px;
    }

    .chart-section-title {
        font-size: 14px;
        font-weight: 500;
        color: #94A3B8;
        margin-bottom: 8px;
    }

    .chart-box {
        background: #FFFFFF;
        border-radius: 8px;
        padding: 24px;
        border: 1px solid #E2E8F0;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
        position: relative;
    }

    .chart-canvas-wrapper {
        position: relative;
        height: 280px;
        width: 100%;
    }

    .chart-bottom-row {
        display: flex;
        align-items: center;
        justify-content: flex-start;
        margin-top: 14px;
        gap: 16px;
        padding-left: 10px;
        overflow-x: auto;
    }

    .chart-zero-label {
        font-size: 12px;
        color: #64748B;
        font-weight: 500;
        margin-right: 8px;
    }

    .legend-row-exact {
        display: flex;
        align-items: center;
        gap: 16px;
        flex-wrap: nowrap;
    }

    .legend-item-exact {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 11.5px;
        color: #334155;
        white-space: nowrap;
    }

    .legend-box-color {
        width: 11px;
        height: 11px;
        border-radius: 2px;
        display: inline-block;
        flex-shrink: 0;
    }
</style>
@endsection

@section('content')

    <!-- 1. Empat Kartu Statistik -->
    <div class="stat-cards-grid">
        <div class="stat-card">
            <span class="stat-number">{{ $menungguCount }}</span>
            <span class="stat-label">Pending Verification</span>
        </div>

        <div class="stat-card">
            <span class="stat-number">{{ $totalAlat }}</span>
            <span class="stat-label">Total Items</span>
        </div>

        <div class="stat-card">
            <span class="stat-number">{{ $sedangDipinjamCount }}</span>
            <span class="stat-label">Currently Borrowed</span>
        </div>

        <div class="stat-card">
            <span class="stat-number">{{ $rusakCount }}</span>
            <span class="stat-label damaged">Damaged</span>
        </div>
    </div>

    <!-- 2. Pending Loan Requests Section -->
    <div class="section-wrapper">
        <h2 class="section-title">Pending Loan Requests</h2>
        
        <div class="table-container">
            <table class="dashboard-table">
                <thead>
                    <tr>
                        <th style="width: 25%;">Borrower</th>
                        <th style="width: 35%;">Item</th>
                        <th style="width: 20%;">Date</th>
                        <th style="width: 20%;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pendingRequests as $req)
                    <tr>
                        <td style="color: #0F172A; font-weight: 500;">
                            {{ $req->siswa->nama ?? 'Siswa (NIS: ' . $req->nis . ')' }}
                        </td>
                        <td style="color: #334155;">
                            {{ $req->barang->nama_barang ?? $req->kode_barang }}
                        </td>
                        <td style="color: #475569;">
                            {{ $req->tanggal_pinjam ? $req->tanggal_pinjam->format('Y-m-d') : '-' }}
                        </td>
                        <td>
                            <div class="actions-cell-wrapper">
                                <!-- Approve Form -->
                                <form action="{{ route('admin.verifikasi.approve', $req->kode_pinjam) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn-approve">Approve</button>
                                </form>

                                <!-- Reject Button -->
                                <button type="button" class="btn-reject" onclick="openRejectModal('{{ $req->kode_pinjam }}', '{{ $req->barang->nama_barang ?? '' }}', '{{ $req->siswa->nama ?? 'Siswa' }}')">
                                    Reject
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: #94A3B8; padding: 24px;">
                            Tidak ada permohonan peminjaman yang menunggu.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- 3. BarLineChart Section -->
    <div class="chart-section">
        <div class="chart-section-title">BarLineChart</div>
        
        <div class="chart-box">
            <div class="chart-canvas-wrapper">
                <canvas id="sinfasBarChart"></canvas>
            </div>

            <!-- Legend Baris Bawah Persis Screenshot -->
            <div class="chart-bottom-row">
                <span class="chart-zero-label">00</span>
                <div class="legend-row-exact">
                    <div class="legend-item-exact">
                        <span class="legend-box-color" style="background: #FF7E79;"></span>
                        <span>Kabel HDMI 10 Meter</span>
                    </div>
                    <div class="legend-item-exact">
                        <span class="legend-box-color" style="background: #38BDF8;"></span>
                        <span>Kamera DSLR Canon 3000D</span>
                    </div>
                    <div class="legend-item-exact">
                        <span class="legend-box-color" style="background: #FBBF24;"></span>
                        <span>Wireless Presenter Laser</span>
                    </div>
                    <div class="legend-item-exact">
                        <span class="legend-box-color" style="background: #60A5FA;"></span>
                        <span>Microphone Wireless Clip-on</span>
                    </div>
                    <div class="legend-item-exact">
                        <span class="legend-box-color" style="background: #4ADE80;"></span>
                        <span>Tripod Kamera Takara</span>
                    </div>
                    <div class="legend-item-exact">
                        <span class="legend-box-color" style="background: #A855F7;"></span>
                        <span>Speaker Portable ...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Konfirmasi Penolakan -->
    <div id="rejectModal" class="modal-overlay">
        <div class="modal-card">
            <div class="modal-header">
                <div class="modal-title">Reject Request</div>
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
                        display: false // Menggunakan legend kustom di bawah persis gambar
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
                        position: 'top', // Bulan (Jan, Feb, Mar, Apr, Mei, Jun) di atas grid seperti screenshot
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
