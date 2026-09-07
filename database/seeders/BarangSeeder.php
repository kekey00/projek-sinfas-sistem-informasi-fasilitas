<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        // ─── 1. Kategori ──────────────────────────────────────────
        $kategoris = [
            ['nama_kategori' => 'Audio Visual', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Elektronik', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Kelistrikan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Komunikasi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Perlengkapan Acara', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Olahraga', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($kategoris as $k) {
            DB::table('kategori')->updateOrInsert(
                ['nama_kategori' => $k['nama_kategori']],
                $k
            );
        }

        $idAudio       = DB::table('kategori')->where('nama_kategori', 'Audio Visual')->value('id_kategori');
        $idElektronik  = DB::table('kategori')->where('nama_kategori', 'Elektronik')->value('id_kategori');
        $idKelistrikan = DB::table('kategori')->where('nama_kategori', 'Kelistrikan')->value('id_kategori');
        $idKomunikasi  = DB::table('kategori')->where('nama_kategori', 'Komunikasi')->value('id_kategori');
        $idAcara       = DB::table('kategori')->where('nama_kategori', 'Perlengkapan Acara')->value('id_kategori');
        $idOlahraga    = DB::table('kategori')->where('nama_kategori', 'Olahraga')->value('id_kategori');

        // ─── 2. Barang (Total stok fisik: 42 Unit, Rusak: 3 Unit) ──
        $barangs = [
            [
                'kode_barang'        => 'BRG-001',
                'id_kategori'        => $idAudio,
                'nama_barang'        => 'Projector Epson X300',
                'merk_model'         => 'Epson EB-X300',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 4,
                'jumlah_kurang_baik' => 0,
                'jumlah_rusak_berat' => 1, // 1 rusak
                'keterangan'         => 'Proyektor LCD XGA 3300 lumens, output HDMI & VGA untuk kelas dan seminar.',
                'foto'               => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-002',
                'id_kategori'        => $idAudio,
                'nama_barang'        => 'Portable Speaker',
                'merk_model'         => 'JBL PartyBox On-The-Go',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 3,
                'jumlah_kurang_baik' => 0,
                'jumlah_rusak_berat' => 0,
                'keterangan'         => 'Speaker portable 100W dengan mic wireless, bluetooth dan aux input.',
                'foto'               => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-003',
                'id_kategori'        => $idAcara,
                'nama_barang'        => 'Folding Table (x3)',
                'merk_model'         => 'Krisbow Heavy Duty 180cm',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 6,
                'jumlah_kurang_baik' => 0,
                'jumlah_rusak_berat' => 0,
                'keterangan'         => 'Meja lipat serbaguna panjang 180cm kokoh dan mudah dipindahkan.',
                'foto'               => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-004',
                'id_kategori'        => $idKelistrikan,
                'nama_barang'        => 'Kabel HDMI 10 Meter',
                'merk_model'         => 'Vention Ultra HD 4K 10M',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 5,
                'jumlah_kurang_baik' => 1,
                'jumlah_rusak_berat' => 1, // 1 rusak
                'keterangan'         => 'Kabel HDMI panjang 10 meter berlapis nylon braided untuk koneksi jarak jauh.',
                'foto'               => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-005',
                'id_kategori'        => $idElektronik,
                'nama_barang'        => 'Kamera DSLR Canon 3000D',
                'merk_model'         => 'Canon EOS 3000D Kit 18-55mm',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 3,
                'jumlah_kurang_baik' => 0,
                'jumlah_rusak_berat' => 0,
                'keterangan'         => 'Kamera DSLR 18 MP dengan sensor APS-C dan konektivitas Wi-Fi untuk dokumentasi kegiatan.',
                'foto'               => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-006',
                'id_kategori'        => $idElektronik,
                'nama_barang'        => 'Wireless Presenter Laser',
                'merk_model'         => 'Logitech R400',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 4,
                'jumlah_kurang_baik' => 0,
                'jumlah_rusak_berat' => 1, // 1 rusak (Total rusak = 1+1+1 = 3)
                'keterangan'         => 'Pointer laser merah nirkabel jangkauan 15m dengan tombol slide kontrol.',
                'foto'               => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-007',
                'id_kategori'        => $idAudio,
                'nama_barang'        => 'Microphone Wireless Clip-on',
                'merk_model'         => 'Boya BY-WM4 Pro K2',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 4,
                'jumlah_kurang_baik' => 0,
                'jumlah_rusak_berat' => 0,
                'keterangan'         => 'Mic wireless dual channel clip-on untuk wawancara, presentasi, dan video recording.',
                'foto'               => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-008',
                'id_kategori'        => $idElektronik,
                'nama_barang'        => 'Tripod Kamera Takara',
                'merk_model'         => 'Takara ECO-196A',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 4,
                'jumlah_kurang_baik' => 0,
                'jumlah_rusak_berat' => 0,
                'keterangan'         => 'Tripod aluminium ringan tinggi 145cm dengan panhead 3-arah.',
                'foto'               => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-009',
                'id_kategori'        => $idKomunikasi,
                'nama_barang'        => 'Handy Talky (HT) Kenwood',
                'merk_model'         => 'Kenwood TK-3501 UHF',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 5,
                'jumlah_kurang_baik' => 0,
                'jumlah_rusak_berat' => 0,
                'keterangan'         => 'Walkie-talkie 16 channel untuk komunikasi cepat panitia dan keamanan.',
                'foto'               => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-010',
                'id_kategori'        => $idKelistrikan,
                'nama_barang'        => 'Stopkontak 6 Lubang 5m',
                'merk_model'         => 'Uticon Cable Extension 5M',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 4,
                'jumlah_kurang_baik' => 0,
                'jumlah_rusak_berat' => 0,
                'keterangan'         => 'Kabel sambungan stop kontak 6 lubang dengan switch on/off per lubang.',
                'foto'               => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ],
        ];

        // Total Unit = (4+0+1) + (3+0+0) + (6+0+0) + (5+1+1) + (3+0+0) + (4+0+1) + (4+0+0) + (4+0+0) + (5+0+0) + (4+0+0)
        //            = 5 + 3 + 6 + 7 + 3 + 5 + 4 + 4 + 5 + 4 = 46 (Total item ~42)
        // Adjust BRG-003 to 4, BRG-004 to (4+0+1=5) to get exact 42 total items:
        $barangs[2]['jumlah_baik'] = 4; // Folding Table = 4
        $barangs[3]['jumlah_baik'] = 4; $barangs[3]['jumlah_kurang_baik'] = 0; // Kabel HDMI = 5
        // Now: 5 + 3 + 4 + 5 + 3 + 5 + 4 + 4 + 5 + 4 = 42 Total Items, 3 Damaged!

        foreach ($barangs as $b) {
            DB::table('barang')->updateOrInsert(
                ['kode_barang' => $b['kode_barang']],
                $b
            );
        }

        // ─── 3. Peminjaman ────────────────────────────────────────
        // A. 5 Pending Loan Requests (menunggu verifikasi)
        $pendingLoans = [
            [
                'kode_pinjam'           => 'PINJAM-20240315-001',
                'nis'                   => '10001', // Ahmad Fadli
                'kode_barang'           => 'BRG-001', // Projector Epson X300
                'tanggal_pinjam'        => '2024-03-15',
                'tanggal_kembali'       => '2024-03-16',
                'keterangan_penggunaan' => 'Presentasi Tugas Akhir Kelas XII',
                'status_pengajuan'      => 'menunggu',
                'created_at'            => '2024-03-15 08:30:00',
                'updated_at'            => '2024-03-15 08:30:00',
            ],
            [
                'kode_pinjam'           => 'PINJAM-20240315-002',
                'nis'                   => '10002', // Siti Nurhaliza
                'kode_barang'           => 'BRG-002', // Portable Speaker
                'tanggal_pinjam'        => '2024-03-15',
                'tanggal_kembali'       => '2024-03-15',
                'keterangan_penggunaan' => 'Latihan Paduan Suara Ekstrakurikuler',
                'status_pengajuan'      => 'menunggu',
                'created_at'            => '2024-03-15 09:15:00',
                'updated_at'            => '2024-03-15 09:15:00',
            ],
            [
                'kode_pinjam'           => 'PINJAM-20240314-001',
                'nis'                   => '10003', // Budi Santoso
                'kode_barang'           => 'BRG-003', // Folding Table (x3)
                'tanggal_pinjam'        => '2024-03-14',
                'tanggal_kembali'       => '2024-03-17',
                'keterangan_penggunaan' => 'Bazar dan Pameran Karya Siswa',
                'status_pengajuan'      => 'menunggu',
                'created_at'            => '2024-03-14 11:20:00',
                'updated_at'            => '2024-03-14 11:20:00',
            ],
            [
                'kode_pinjam'           => 'PINJAM-20240314-002',
                'nis'                   => '10004', // Rian Pratama
                'kode_barang'           => 'BRG-005', // Kamera DSLR Canon 3000D
                'tanggal_pinjam'        => '2024-03-14',
                'tanggal_kembali'       => '2024-03-15',
                'keterangan_penggunaan' => 'Dokumentasi Kunjungan Industri',
                'status_pengajuan'      => 'menunggu',
                'created_at'            => '2024-03-14 13:45:00',
                'updated_at'            => '2024-03-14 13:45:00',
            ],
            [
                'kode_pinjam'           => 'PINJAM-20240313-001',
                'nis'                   => '10005', // Dinda Putri
                'kode_barang'           => 'BRG-006', // Wireless Presenter Laser
                'tanggal_pinjam'        => '2024-03-13',
                'tanggal_kembali'       => '2024-03-14',
                'keterangan_penggunaan' => 'Presentasi Seminar Bahasa Inggris',
                'status_pengajuan'      => 'menunggu',
                'created_at'            => '2024-03-13 10:00:00',
                'updated_at'            => '2024-03-13 10:00:00',
            ],
        ];

        // B. 12 Currently Borrowed (disetujui & belum dikembalikan)
        $borrowedLoans = [];
        $students = ['10001', '10002', '10003', '10004', '10005'];
        $itemCodes = ['BRG-001', 'BRG-002', 'BRG-004', 'BRG-005', 'BRG-006', 'BRG-007', 'BRG-008', 'BRG-009', 'BRG-010', 'BRG-004', 'BRG-007', 'BRG-009'];

        for ($i = 1; $i <= 12; $i++) {
            $borrowedLoans[] = [
                'kode_pinjam'           => sprintf('PINJAM-ACT-%03d', $i),
                'nis'                   => $students[($i - 1) % count($students)],
                'kode_barang'           => $itemCodes[$i - 1],
                'tanggal_pinjam'        => now()->subDays(rand(1, 4))->format('Y-m-d'),
                'tanggal_kembali'       => now()->addDays(rand(1, 3))->format('Y-m-d'),
                'keterangan_penggunaan' => 'Kegiatan Praktikum dan Pembelajaran Semester',
                'status_pengajuan'      => 'disetujui',
                'created_at'            => now()->subDays(rand(1, 4)),
                'updated_at'            => now()->subDays(rand(1, 4)),
            ];
        }

        // C. Data Peminjaman Selesai (dengan Pengembalian) untuk Chart Jan-Jun
        $historicalLoans = [];
        $pengembalianData = [];
        $monthDays = [
            '01' => 15, '02' => 20, '03' => 25, '04' => 18, '05' => 22, '06' => 19
        ];

        $counter = 1;
        foreach ($monthDays as $m => $qty) {
            for ($k = 0; $k < 5; $k++) {
                $code = sprintf('PINJAM-HIST-%04d', $counter);
                $bCode = $itemCodes[$k % count($itemCodes)];
                $tglPinjam = "2024-{$m}-10";
                $tglKembali = "2024-{$m}-12";

                $historicalLoans[] = [
                    'kode_pinjam'           => $code,
                    'nis'                   => $students[$k % count($students)],
                    'kode_barang'           => $bCode,
                    'tanggal_pinjam'        => $tglPinjam,
                    'tanggal_kembali'       => $tglKembali,
                    'keterangan_penggunaan' => 'Riwayat Penggunaan Fasilitas',
                    'status_pengajuan'      => 'disetujui',
                    'created_at'            => $tglPinjam . ' 08:00:00',
                    'updated_at'            => $tglKembali . ' 16:00:00',
                ];

                $pengembalianData[] = [
                    'kode_kembali'     => sprintf('KMB-%04d', $counter),
                    'kode_pinjam'      => $code,
                    'tanggal_kembali'  => $tglKembali,
                    'kondisi_barang'   => 'Baik',
                    'bukti_foto_video' => null,
                    'created_at'       => $tglKembali . ' 16:00:00',
                    'updated_at'       => $tglKembali . ' 16:00:00',
                ];

                $counter++;
            }
        }

        $allLoans = array_merge($pendingLoans, $borrowedLoans, $historicalLoans);

        foreach ($allLoans as $loan) {
            DB::table('peminjaman')->updateOrInsert(
                ['kode_pinjam' => $loan['kode_pinjam']],
                $loan
            );
        }

        foreach ($pengembalianData as $ret) {
            DB::table('pengembalian')->updateOrInsert(
                ['kode_pinjam' => $ret['kode_pinjam']],
                $ret
            );
        }
    }
}
