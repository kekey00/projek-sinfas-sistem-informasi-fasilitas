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
            ['nama_kategori' => 'Electronics', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Furniture', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Equipment', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Audio Visual', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Kelistrikan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Komunikasi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Olahraga', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($kategoris as $k) {
            DB::table('kategori')->updateOrInsert(
                ['nama_kategori' => $k['nama_kategori']],
                $k
            );
        }

        $idElectronics = DB::table('kategori')->where('nama_kategori', 'Electronics')->value('id_kategori');
        $idFurniture   = DB::table('kategori')->where('nama_kategori', 'Furniture')->value('id_kategori');
        $idEquipment   = DB::table('kategori')->where('nama_kategori', 'Equipment')->value('id_kategori');

        // ─── 2. Barang Sesuai Screenshot Kelola Alat ───────────────
        $barangs = [
            [
                'kode_barang'        => 'BRG-001',
                'id_kategori'        => $idElectronics,
                'nama_barang'        => 'Projector Epson X300',
                'merk_model'         => 'Epson EB-X300',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 4,
                'jumlah_kurang_baik' => 1,
                'jumlah_rusak_berat' => 0,
                'keterangan'         => 'Proyektor LCD XGA 3300 lumens, output HDMI & VGA untuk kelas dan seminar.',
                'foto'               => null,
                'created_at'         => '2024-01-01 08:00:00',
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-002',
                'id_kategori'        => $idElectronics,
                'nama_barang'        => 'Portable Speaker JBL',
                'merk_model'         => 'JBL PartyBox On-The-Go',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 2,
                'jumlah_kurang_baik' => 1,
                'jumlah_rusak_berat' => 0,
                'keterangan'         => 'Speaker portable 100W dengan mic wireless, bluetooth dan aux input.',
                'foto'               => null,
                'created_at'         => '2024-01-02 08:00:00',
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-003',
                'id_kategori'        => $idFurniture,
                'nama_barang'        => 'Folding Table 180cm',
                'merk_model'         => 'Krisbow Heavy Duty 180cm',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 8,
                'jumlah_kurang_baik' => 1,
                'jumlah_rusak_berat' => 1,
                'keterangan'         => 'Meja lipat serbaguna panjang 180cm kokoh dan mudah dipindahkan.',
                'foto'               => null,
                'created_at'         => '2024-01-03 08:00:00',
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-004',
                'id_kategori'        => $idEquipment,
                'nama_barang'        => 'Whiteboard 120cm',
                'merk_model'         => 'Sakana Standard 120x80cm',
                'kondisi'            => 'Kurang Baik',
                'jumlah_baik'        => 0,
                'jumlah_kurang_baik' => 1,
                'jumlah_rusak_berat' => 1,
                'keterangan'         => 'Papan tulis putih gantung magnetik 120cm.',
                'foto'               => null,
                'created_at'         => '2024-01-04 08:00:00',
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-005',
                'id_kategori'        => $idElectronics,
                'nama_barang'        => 'Kabel HDMI 10 Meter',
                'merk_model'         => 'Vention Ultra HD 4K 10M',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 5,
                'jumlah_kurang_baik' => 1,
                'jumlah_rusak_berat' => 1,
                'keterangan'         => 'Kabel HDMI panjang 10 meter berlapis nylon braided untuk koneksi jarak jauh.',
                'foto'               => null,
                'created_at'         => '2024-01-05 08:00:00',
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-006',
                'id_kategori'        => $idElectronics,
                'nama_barang'        => 'Kamera DSLR Canon 3000D',
                'merk_model'         => 'Canon EOS 3000D Kit 18-55mm',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 3,
                'jumlah_kurang_baik' => 0,
                'jumlah_rusak_berat' => 0,
                'keterangan'         => 'Kamera DSLR 18 MP dengan sensor APS-C dan konektivitas Wi-Fi untuk dokumentasi kegiatan.',
                'foto'               => null,
                'created_at'         => '2024-01-06 08:00:00',
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-007',
                'id_kategori'        => $idElectronics,
                'nama_barang'        => 'Wireless Presenter Laser',
                'merk_model'         => 'Logitech R400',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 4,
                'jumlah_kurang_baik' => 0,
                'jumlah_rusak_berat' => 0,
                'keterangan'         => 'Pointer laser merah nirkabel jangkauan 15m dengan tombol slide kontrol.',
                'foto'               => null,
                'created_at'         => '2024-01-07 08:00:00',
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-008',
                'id_kategori'        => $idElectronics,
                'nama_barang'        => 'Microphone Wireless Clip-on',
                'merk_model'         => 'Boya BY-WM4 Pro K2',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 4,
                'jumlah_kurang_baik' => 0,
                'jumlah_rusak_berat' => 0,
                'keterangan'         => 'Mic wireless dual channel clip-on untuk wawancara, presentasi, dan video recording.',
                'foto'               => null,
                'created_at'         => '2024-01-08 08:00:00',
                'updated_at'         => now(),
            ],
            [
                'kode_barang'        => 'BRG-009',
                'id_kategori'        => $idElectronics,
                'nama_barang'        => 'Tripod Kamera Takara',
                'merk_model'         => 'Takara ECO-196A',
                'kondisi'            => 'Baik',
                'jumlah_baik'        => 4,
                'jumlah_kurang_baik' => 0,
                'jumlah_rusak_berat' => 0,
                'keterangan'         => 'Tripod aluminium ringan tinggi 145cm dengan panhead 3-arah.',
                'foto'               => null,
                'created_at'         => '2024-01-09 08:00:00',
                'updated_at'         => now(),
            ],
        ];

        foreach ($barangs as $b) {
            DB::table('barang')->updateOrInsert(
                ['kode_barang' => $b['kode_barang']],
                $b
            );
        }

        // ─── 3. Peminjaman (Tetap sinkron dengan dashboard) ────────
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
                'kode_barang'           => 'BRG-002', // Portable Speaker JBL
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
                'kode_barang'           => 'BRG-003', // Folding Table 180cm
                'tanggal_pinjam'        => '2024-03-14',
                'tanggal_kembali'       => '2024-03-17',
                'keterangan_penggunaan' => 'Bazar dan Pameran Karya Siswa',
                'status_pengajuan'      => 'menunggu',
                'created_at'            => '2024-03-14 11:20:00',
                'updated_at'            => '2024-03-14 11:20:00',
            ],
        ];

        foreach ($pendingLoans as $loan) {
            DB::table('peminjaman')->updateOrInsert(
                ['kode_pinjam' => $loan['kode_pinjam']],
                $loan
            );
        }
    }
}
