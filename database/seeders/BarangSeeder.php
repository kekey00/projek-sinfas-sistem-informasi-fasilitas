<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Kategori ────────────────────────────────────────────
        $kategoris = [
            ['nama_kategori' => 'Elektronik', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Audio Visual', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Kelistrikan', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Komunikasi', 'created_at' => now(), 'updated_at' => now()],
            ['nama_kategori' => 'Olahraga', 'created_at' => now(), 'updated_at' => now()],
        ];

        DB::table('kategori')->insertOrIgnore($kategoris);

        $idElektronik  = DB::table('kategori')->where('nama_kategori', 'Elektronik')->value('id_kategori');
        $idAudio       = DB::table('kategori')->where('nama_kategori', 'Audio Visual')->value('id_kategori');
        $idListrik     = DB::table('kategori')->where('nama_kategori', 'Kelistrikan')->value('id_kategori');
        $idKomunikasi  = DB::table('kategori')->where('nama_kategori', 'Komunikasi')->value('id_kategori');
        $idOlahraga    = DB::table('kategori')->where('nama_kategori', 'Olahraga')->value('id_kategori');

        // ─── Barang ──────────────────────────────────────────────
        $barangs = [
            [
                'kode_barang'       => 'BRG-001',
                'id_kategori'       => $idElektronik,
                'nama_barang'       => 'Camera Canon EOS 5D Mark IV',
                'merk_model'        => 'Canon EOS 5D Mark IV',
                'kondisi'           => 'Baik',
                'jumlah_baik'       => 2,
                'jumlah_kurang_baik'=> 0,
                'jumlah_rusak_berat'=> 0,
                'keterangan'        => 'Canon EOS 5D Mark IV adalah kamera DSLR full-frame 30.4 MP yang cocok untuk fotografi profesional dan perekaman video 4K. Menghasilkan gambar tajam dengan performa andal di berbagai kondisi cahaya.',
                'foto'              => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'kode_barang'       => 'BRG-002',
                'id_kategori'       => $idAudio,
                'nama_barang'       => 'Mikrofon Kondenser',
                'merk_model'        => 'Audio Technica AT2020',
                'kondisi'           => 'Baik',
                'jumlah_baik'       => 3,
                'jumlah_kurang_baik'=> 0,
                'jumlah_rusak_berat'=> 0,
                'keterangan'        => 'Mikrofon kondenser kardioid berkualitas studio, ideal untuk rekaman vokal, podcast, dan instrumen akustik.',
                'foto'              => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'kode_barang'       => 'BRG-003',
                'id_kategori'       => $idAudio,
                'nama_barang'       => 'Proyektor Epson EB-X51',
                'merk_model'        => 'Epson EB-X51',
                'kondisi'           => 'Baik',
                'jumlah_baik'       => 4,
                'jumlah_kurang_baik'=> 1,
                'jumlah_rusak_berat'=> 0,
                'keterangan'        => 'Proyektor LCD dengan resolusi XGA (1024x768), kecerahan 3600 lumen, cocok untuk presentasi di ruang kelas maupun ruang rapat.',
                'foto'              => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'kode_barang'       => 'BRG-004',
                'id_kategori'       => $idKomunikasi,
                'nama_barang'       => 'Handy Talky (HT) Kenwood',
                'merk_model'        => 'Kenwood TK-3501',
                'kondisi'           => 'Baik',
                'jumlah_baik'       => 5,
                'jumlah_kurang_baik'=> 0,
                'jumlah_rusak_berat'=> 0,
                'keterangan'        => 'Radio komunikasi dua arah UHF 16 channel, ideal untuk koordinasi acara, keamanan, dan kegiatan outdoor.',
                'foto'              => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'kode_barang'       => 'BRG-005',
                'id_kategori'       => $idListrik,
                'nama_barang'       => 'Kabel Roll 10 Meter',
                'merk_model'        => 'Belden 10m 4 Colokan',
                'kondisi'           => 'Baik',
                'jumlah_baik'       => 8,
                'jumlah_kurang_baik'=> 2,
                'jumlah_rusak_berat'=> 0,
                'keterangan'        => 'Kabel gulung / roll dengan 4 colokan, panjang 10 meter. Cocok untuk keperluan acara dan presentasi.',
                'foto'              => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'kode_barang'       => 'BRG-006',
                'id_kategori'       => $idElektronik,
                'nama_barang'       => 'Laptop Lenovo ThinkPad',
                'merk_model'        => 'Lenovo ThinkPad E14 Gen2',
                'kondisi'           => 'Baik',
                'jumlah_baik'       => 5,
                'jumlah_kurang_baik'=> 0,
                'jumlah_rusak_berat'=> 0,
                'keterangan'        => 'Laptop bisnis dengan prosesor Intel Core i5, RAM 8GB, SSD 512GB, layar 14 inci FHD. Ideal untuk presentasi, desain ringan, dan pengolahan data.',
                'foto'              => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'kode_barang'       => 'BRG-007',
                'id_kategori'       => $idAudio,
                'nama_barang'       => 'Speaker Portable JBL',
                'merk_model'        => 'JBL Xtreme 3',
                'kondisi'           => 'Baik',
                'jumlah_baik'       => 3,
                'jumlah_kurang_baik'=> 0,
                'jumlah_rusak_berat'=> 0,
                'keterangan'        => 'Speaker Bluetooth portabel tahan air dengan daya 100W, baterai tahan hingga 15 jam. Cocok untuk acara indoor dan outdoor.',
                'foto'              => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
            [
                'kode_barang'       => 'BRG-008',
                'id_kategori'       => $idListrik,
                'nama_barang'       => 'Stopkontak Banyak Lubang',
                'merk_model'        => 'Panasonic WEZF1309',
                'kondisi'           => 'Baik',
                'jumlah_baik'       => 10,
                'jumlah_kurang_baik'=> 1,
                'jumlah_rusak_berat'=> 0,
                'keterangan'        => 'Stop kontak multi lubang 6 colokan dengan pengaman arus lebih. Aman dan terpercaya untuk keperluan banyak perangkat sekaligus.',
                'foto'              => null,
                'created_at'        => now(),
                'updated_at'        => now(),
            ],
        ];

        DB::table('barang')->insertOrIgnore($barangs);
    }
}
