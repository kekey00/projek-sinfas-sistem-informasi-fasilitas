<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        // ──────────────────────────────────────────────────────────
        // 1. SISWA TAMBAHAN (Total jadi 15 siswa)
        // ──────────────────────────────────────────────────────────
        $siswaTambahan = [
            ['nis' => '10006', 'nama' => 'Fajar Nugroho',    'email' => 'fajar.nugroho@sinfas.sch.id',    'no_hp' => '08123456706'],
            ['nis' => '10007', 'nama' => 'Anita Rahayu',     'email' => 'anita.rahayu@sinfas.sch.id',     'no_hp' => '08123456707'],
            ['nis' => '10008', 'nama' => 'Muhammad Rizki',   'email' => 'muhammad.rizki@sinfas.sch.id',   'no_hp' => '08123456708'],
            ['nis' => '10009', 'nama' => 'Dewi Anggraini',   'email' => 'dewi.anggraini@sinfas.sch.id',   'no_hp' => '08123456709'],
            ['nis' => '10010', 'nama' => 'Hendri Setiawan',  'email' => 'hendri.setiawan@sinfas.sch.id',  'no_hp' => '08123456710'],
            ['nis' => '10011', 'nama' => 'Novia Kusuma',     'email' => 'novia.kusuma@sinfas.sch.id',     'no_hp' => '08123456711'],
            ['nis' => '10012', 'nama' => 'Arif Hidayatullah','email' => 'arif.hidayatullah@sinfas.sch.id','no_hp' => '08123456712'],
            ['nis' => '10013', 'nama' => 'Sari Wulandari',   'email' => 'sari.wulandari@sinfas.sch.id',   'no_hp' => '08123456713'],
            ['nis' => '10014', 'nama' => 'Bagas Pratama',    'email' => 'bagas.pratama@sinfas.sch.id',    'no_hp' => '08123456714'],
            ['nis' => '10015', 'nama' => 'Lestari Putri',    'email' => 'lestari.putri@sinfas.sch.id',    'no_hp' => '08123456715'],
        ];

        foreach ($siswaTambahan as $s) {
            DB::table('siswa')->updateOrInsert(
                ['nis' => $s['nis']],
                array_merge($s, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        // ──────────────────────────────────────────────────────────
        // 2. PEGAWAI TAMBAHAN
        // ──────────────────────────────────────────────────────────
        $pegawaiTambahan = [
            ['nip' => '199001012015011002', 'nama' => 'Rudi Kurniawan, S.Kom'],
        ];

        foreach ($pegawaiTambahan as $p) {
            DB::table('pegawai')->updateOrInsert(
                ['nip' => $p['nip']],
                array_merge($p, ['created_at' => now(), 'updated_at' => now()])
            );
        }

        // ──────────────────────────────────────────────────────────
        // 3. AKUN & ENTITAS TAMBAHAN (Target Persis Mockup: 156 Akun)
        // 142 Siswa + 12 Admin Sarana + 2 Admin Sistem = 156 Akun
        // ──────────────────────────────────────────────────────────
        $hashedSiswa = Hash::make('siswa123');
        $hashedAdmin = Hash::make('admin123');

        $siswaBatch = [];
        $akunBatch  = [];
        $pegawaiBatch = [];

        // Siswa 16 hingga 142 (total 142 siswa)
        // Set 8 akun terakhir dibuat di bulan Agustus 2026 agar "Akun Baru Bulan Ini = 8"
        for ($i = 16; $i <= 142; $i++) {
            $nis = (string)(10000 + $i);
            $nama = 'Siswa ' . $i;
            $username = 'siswa' . $i;
            $isBulanIni = ($i > 134); // 135 s/d 142 = 8 siswa
            $createdAt = $isBulanIni ? '2026-08-' . str_pad($i - 134, 2, '0', STR_PAD_LEFT) . ' 10:00:00' : '2026-05-10 08:00:00';

            $siswaBatch[] = [
                'nis'        => $nis,
                'nama'       => $nama,
                'email'      => "{$username}@sinfas.sch.id",
                'no_hp'      => '0812' . str_pad($i, 7, '0', STR_PAD_LEFT),
                'created_at' => $createdAt,
                'updated_at' => now(),
            ];

            $akunBatch[] = [
                'nis'          => $nis,
                'nip'          => null,
                'nama'         => $nama,
                'nomor_kontak' => '0812' . str_pad($i, 7, '0', STR_PAD_LEFT),
                'role'         => 'siswa',
                'username'     => $username,
                'password'     => $hashedSiswa,
                'created_at'   => $createdAt,
                'updated_at'   => now(),
            ];
        }

        foreach (array_chunk($siswaBatch, 50) as $chunk) {
            DB::table('siswa')->upsert($chunk, ['nis'], ['nama', 'email', 'no_hp', 'updated_at']);
        }

        // Admin Sarana tambahan (total 12 admin sarana)
        // Sudah ada 'admin' dan 'rudi.k', jadi tambah 10 admin sarana
        for ($j = 3; $j <= 12; $j++) {
            $nip = '198501012010011' . str_pad($j, 3, '0', STR_PAD_LEFT);
            $nama = 'Admin Sarana ' . $j;
            $username = 'sarana' . $j;

            $pegawaiBatch[] = [
                'nip'        => $nip,
                'nama'       => $nama,
                'created_at' => '2026-01-10 08:00:00',
                'updated_at' => now(),
            ];

            $akunBatch[] = [
                'nis'          => null,
                'nip'          => $nip,
                'nama'         => $nama,
                'nomor_kontak' => '0813' . str_pad($j, 7, '0', STR_PAD_LEFT),
                'role'         => 'admin_sarana',
                'username'     => $username,
                'password'     => $hashedAdmin,
                'created_at'   => '2026-01-10 08:00:00',
                'updated_at'   => now(),
            ];
        }

        // Admin Sistem ke-2 (sudah ada 1: 'adminsistem')
        $nipSistem2 = '198803152012022099';
        $pegawaiBatch[] = [
            'nip'        => $nipSistem2,
            'nama'       => 'Admin Sistem 2',
            'created_at' => '2026-01-15 08:00:00',
            'updated_at' => now(),
        ];
        $akunBatch[] = [
            'nis'          => null,
            'nip'          => $nipSistem2,
            'nama'         => 'Admin Sistem 2',
            'nomor_kontak' => '081999999999',
            'role'         => 'admin_sistem',
            'username'     => 'adminsistem2',
            'password'     => $hashedAdmin,
            'created_at'   => '2026-01-15 08:00:00',
            'updated_at'   => now(),
        ];

        foreach (array_chunk($pegawaiBatch, 50) as $chunk) {
            DB::table('pegawai')->upsert($chunk, ['nip'], ['nama', 'updated_at']);
        }

        foreach (array_chunk($akunBatch, 50) as $chunk) {
            DB::table('akun')->upsert($chunk, ['username'], ['nis', 'nip', 'nama', 'nomor_kontak', 'role', 'password', 'updated_at']);
        }

        // ──────────────────────────────────────────────────────────
        // 4. BARANG TAMBAHAN (lebih variatif)
        // ──────────────────────────────────────────────────────────
        $idAudioVisual = DB::table('kategori')->where('nama_kategori', 'Audio Visual')->value('id_kategori');
        $idEquipment   = DB::table('kategori')->where('nama_kategori', 'Equipment')->value('id_kategori');
        $idFurniture   = DB::table('kategori')->where('nama_kategori', 'Furniture')->value('id_kategori');
        $idElectronics = DB::table('kategori')->where('nama_kategori', 'Electronics')->value('id_kategori');
        $idOlahraga    = DB::table('kategori')->where('nama_kategori', 'Olahraga')->value('id_kategori');

        $barangTambahan = [
            [
                'kode_barang' => 'BRG-010',
                'id_kategori' => $idAudioVisual,
                'nama_barang' => 'Speaker Portable JBL Xtreme',
                'merk_model'  => 'JBL Xtreme 3',
                'kondisi'     => 'Baik',
                'jumlah_baik' => 2, 'jumlah_kurang_baik' => 0, 'jumlah_rusak_berat' => 0,
                'keterangan'  => 'Speaker portabel tahan air dengan suara stereo 100W.',
            ],
            [
                'kode_barang' => 'BRG-011',
                'id_kategori' => $idEquipment,
                'nama_barang' => 'Papan Tulis Interaktif 75"',
                'merk_model'  => 'Hikvision DS-D5B75RB/D',
                'kondisi'     => 'Baik',
                'jumlah_baik' => 1, 'jumlah_kurang_baik' => 0, 'jumlah_rusak_berat' => 0,
                'keterangan'  => 'Smart board 75 inci layar sentuh multi-touch untuk presentasi interaktif.',
            ],
            [
                'kode_barang' => 'BRG-012',
                'id_kategori' => $idFurniture,
                'nama_barang' => 'Kursi Lipat Futura',
                'merk_model'  => 'Futura FR-01',
                'kondisi'     => 'Baik',
                'jumlah_baik' => 20, 'jumlah_kurang_baik' => 5, 'jumlah_rusak_berat' => 2,
                'keterangan'  => 'Kursi lipat besi anti karat, mudah disimpan dan dipindah.',
            ],
            [
                'kode_barang' => 'BRG-013',
                'id_kategori' => $idElectronics,
                'nama_barang' => 'Drone DJI Mini 4 Pro',
                'merk_model'  => 'DJI Mini 4 Pro',
                'kondisi'     => 'Baik',
                'jumlah_baik' => 1, 'jumlah_kurang_baik' => 0, 'jumlah_rusak_berat' => 0,
                'keterangan'  => 'Drone kamera 4K/60fps untuk dokumentasi kegiatan sekolah.',
            ],
            [
                'kode_barang' => 'BRG-014',
                'id_kategori' => $idOlahraga,
                'nama_barang' => 'Bola Sepak Adidas',
                'merk_model'  => 'Adidas Tiro Club Ball',
                'kondisi'     => 'Baik',
                'jumlah_baik' => 5, 'jumlah_kurang_baik' => 2, 'jumlah_rusak_berat' => 0,
                'keterangan'  => 'Bola sepak ukuran 5, cocok untuk latihan dan pertandingan.',
            ],
            [
                'kode_barang' => 'BRG-015',
                'id_kategori' => $idAudioVisual,
                'nama_barang' => 'Kamera Mirrorless Sony A6400',
                'merk_model'  => 'Sony Alpha A6400 Kit 16-50mm',
                'kondisi'     => 'Baik',
                'jumlah_baik' => 2, 'jumlah_kurang_baik' => 0, 'jumlah_rusak_berat' => 0,
                'keterangan'  => 'Kamera mirrorless 24MP dengan AF tercepat di kelasnya.',
            ],
        ];

        foreach ($barangTambahan as $b) {
            DB::table('barang')->updateOrInsert(
                ['kode_barang' => $b['kode_barang']],
                array_merge($b, [
                    'foto'       => null,
                    'created_at' => now()->subMonths(rand(1, 6)),
                    'updated_at' => now(),
                ])
            );
        }

        // ──────────────────────────────────────────────────────────
        // 5. PEMINJAMAN LENGKAP (disetujui, selesai, ditolak)
        // ──────────────────────────────────────────────────────────
        $peminjamanLengkap = [
            // --- SUDAH DISETUJUI (sedang dipinjam) ---
            [
                'kode_pinjam'           => 'PINJAM-20260901-001',
                'nis'                   => '10001',
                'kode_barang'           => 'BRG-001',
                'tanggal_pinjam'        => '2026-09-01',
                'tanggal_kembali'       => '2026-09-08',
                'lokasi'                => 'Aula Sekolah',
                'keterangan_penggunaan' => 'Presentasi karya siswa tingkat provinsi',
                'status_pengajuan'      => 'disetujui',
                'created_at'            => '2026-08-30 09:00:00',
                'updated_at'            => '2026-08-31 10:00:00',
            ],
            [
                'kode_pinjam'           => 'PINJAM-20260902-001',
                'nis'                   => '10002',
                'kode_barang'           => 'BRG-006',
                'tanggal_pinjam'        => '2026-09-02',
                'tanggal_kembali'       => '2026-09-05',
                'lokasi'                => 'Studio Foto',
                'keterangan_penggunaan' => 'Dokumentasi pameran karya fotografi siswa',
                'status_pengajuan'      => 'disetujui',
                'created_at'            => '2026-09-01 10:30:00',
                'updated_at'            => '2026-09-01 14:00:00',
            ],
            // --- SUDAH DIKEMBALIKAN (selesai) ---
            [
                'kode_pinjam'           => 'PINJAM-20260820-001',
                'nis'                   => '10003',
                'kode_barang'           => 'BRG-007',
                'tanggal_pinjam'        => '2026-08-20',
                'tanggal_kembali'       => '2026-08-21',
                'lokasi'                => 'Ruang Multimedia',
                'keterangan_penggunaan' => 'Seminar motivasi siswa kelas 12',
                'status_pengajuan'      => 'disetujui',
                'created_at'            => '2026-08-19 08:00:00',
                'updated_at'            => '2026-08-21 15:00:00',
            ],
            [
                'kode_pinjam'           => 'PINJAM-20260815-001',
                'nis'                   => '10004',
                'kode_barang'           => 'BRG-008',
                'tanggal_pinjam'        => '2026-08-15',
                'tanggal_kembali'       => '2026-08-16',
                'lokasi'                => 'Panggung Pensi',
                'keterangan_penggunaan' => 'Pentas seni akhir semester',
                'status_pengajuan'      => 'disetujui',
                'created_at'            => '2026-08-14 09:00:00',
                'updated_at'            => '2026-08-16 17:00:00',
            ],
            [
                'kode_pinjam'           => 'PINJAM-20260810-001',
                'nis'                   => '10005',
                'kode_barang'           => 'BRG-009',
                'tanggal_pinjam'        => '2026-08-10',
                'tanggal_kembali'       => '2026-08-12',
                'lokasi'                => 'Lapangan',
                'keterangan_penggunaan' => 'Dokumentasi upacara 17 Agustus',
                'status_pengajuan'      => 'disetujui',
                'created_at'            => '2026-08-09 10:00:00',
                'updated_at'            => '2026-08-12 13:00:00',
            ],
            [
                'kode_pinjam'           => 'PINJAM-20260805-001',
                'nis'                   => '10006',
                'kode_barang'           => 'BRG-005',
                'tanggal_pinjam'        => '2026-08-05',
                'tanggal_kembali'       => '2026-08-06',
                'lokasi'                => 'Lab Komputer',
                'keterangan_penggunaan' => 'Praktikum koneksi display eksternal',
                'status_pengajuan'      => 'disetujui',
                'created_at'            => '2026-08-04 11:00:00',
                'updated_at'            => '2026-08-06 14:00:00',
            ],
            // --- DITOLAK ---
            [
                'kode_pinjam'           => 'PINJAM-20260818-001',
                'nis'                   => '10007',
                'kode_barang'           => 'BRG-013',
                'tanggal_pinjam'        => '2026-08-18',
                'tanggal_kembali'       => '2026-08-20',
                'lokasi'                => 'Luar Sekolah',
                'keterangan_penggunaan' => 'Lomba drone tingkat kabupaten [Catatan: Penggunaan di luar area sekolah tidak diizinkan]',
                'status_pengajuan'      => 'ditolak',
                'created_at'            => '2026-08-17 09:00:00',
                'updated_at'            => '2026-08-17 14:00:00',
            ],
            [
                'kode_pinjam'           => 'PINJAM-20260822-001',
                'nis'                   => '10008',
                'kode_barang'           => 'BRG-002',
                'tanggal_pinjam'        => '2026-08-22',
                'tanggal_kembali'       => '2026-08-25',
                'lokasi'                => 'Rumah Siswa',
                'keterangan_penggunaan' => 'Latihan band [Catatan: Peminjaman ke rumah pribadi tidak diperkenankan]',
                'status_pengajuan'      => 'ditolak',
                'created_at'            => '2026-08-21 13:00:00',
                'updated_at'            => '2026-08-22 09:00:00',
            ],
        ];

        foreach ($peminjamanLengkap as $p) {
            DB::table('peminjaman')->updateOrInsert(
                ['kode_pinjam' => $p['kode_pinjam']],
                $p
            );
        }

        // ──────────────────────────────────────────────────────────
        // 6. PENGEMBALIAN (untuk peminjaman yang sudah selesai)
        // ──────────────────────────────────────────────────────────
        $pengembalianData = [
            [
                'kode_kembali'     => 'KBL-20260821-001',
                'kode_pinjam'      => 'PINJAM-20260820-001',
                'tanggal_kembali'  => '2026-08-21',
                'kondisi_barang'   => 'Baik',
                'bukti_foto_video' => 'Alat dikembalikan dalam kondisi baik dan bersih.',
                'created_at'       => '2026-08-21 15:30:00',
                'updated_at'       => '2026-08-21 15:30:00',
            ],
            [
                'kode_kembali'     => 'KBL-20260816-001',
                'kode_pinjam'      => 'PINJAM-20260815-001',
                'tanggal_kembali'  => '2026-08-16',
                'kondisi_barang'   => 'Kurang Baik',
                'bukti_foto_video' => 'Kabel mic ada yang sedikit terkelupas, masih bisa berfungsi.',
                'created_at'       => '2026-08-16 17:30:00',
                'updated_at'       => '2026-08-16 17:30:00',
            ],
            [
                'kode_kembali'     => 'KBL-20260812-001',
                'kode_pinjam'      => 'PINJAM-20260810-001',
                'tanggal_kembali'  => '2026-08-12',
                'kondisi_barang'   => 'Baik',
                'bukti_foto_video' => 'Tripod berfungsi normal, dikembalikan tepat waktu.',
                'created_at'       => '2026-08-12 13:30:00',
                'updated_at'       => '2026-08-12 13:30:00',
            ],
            [
                'kode_kembali'     => 'KBL-20260806-001',
                'kode_pinjam'      => 'PINJAM-20260805-001',
                'tanggal_kembali'  => '2026-08-06',
                'kondisi_barang'   => 'Baik',
                'bukti_foto_video' => 'Kabel HDMI lengkap dan tidak ada kerusakan.',
                'created_at'       => '2026-08-06 14:30:00',
                'updated_at'       => '2026-08-06 14:30:00',
            ],
        ];

        foreach ($pengembalianData as $k) {
            DB::table('pengembalian')->updateOrInsert(
                ['kode_kembali' => $k['kode_kembali']],
                $k
            );
        }

        $this->command->info('✅ DummyDataSeeder berhasil dijalankan!');
        $this->command->info('   → Siswa: ' . DB::table('siswa')->count());
        $this->command->info('   → Akun: ' . DB::table('akun')->count());
        $this->command->info('   → Barang: ' . DB::table('barang')->count());
        $this->command->info('   → Peminjaman: ' . DB::table('peminjaman')->count());
        $this->command->info('   → Pengembalian: ' . DB::table('pengembalian')->count());
    }
}
