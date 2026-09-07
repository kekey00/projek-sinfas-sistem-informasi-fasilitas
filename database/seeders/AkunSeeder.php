<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AkunSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Data Siswa
        $siswaData = [
            [
                'nis'        => '10001',
                'nama'       => 'Ahmad Fadli',
                'email'      => 'ahmad.fadli@sinfas.sch.id',
                'no_hp'      => '08123456701',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis'        => '10002',
                'nama'       => 'Siti Nurhaliza',
                'email'      => 'siti.nurhaliza@sinfas.sch.id',
                'no_hp'      => '08123456702',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis'        => '10003',
                'nama'       => 'Budi Santoso',
                'email'      => 'budi.santoso@sinfas.sch.id',
                'no_hp'      => '08123456703',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis'        => '10004',
                'nama'       => 'Rian Pratama',
                'email'      => 'rian.pratama@sinfas.sch.id',
                'no_hp'      => '08123456704',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nis'        => '10005',
                'nama'       => 'Dinda Putri',
                'email'      => 'dinda.putri@sinfas.sch.id',
                'no_hp'      => '08123456705',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('siswa')->upsert($siswaData, ['nis'], ['nama', 'email', 'no_hp', 'updated_at']);

        // 2. Data Pegawai
        $pegawaiData = [
            [
                'nip'        => '198501012010011001',
                'nama'       => 'Budi Setiawan, S.Pd',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nip'        => '198803152012022003',
                'nama'       => 'Siti Aminah, M.Kom',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('pegawai')->upsert($pegawaiData, ['nip'], ['nama', 'updated_at']);

        // 3. Data Akun Pengguna
        $akunData = [
            // Admin Sarana
            [
                'nis'          => null,
                'nip'          => '198501012010011001',
                'nama'         => 'Admin Sarana',
                'nomor_kontak' => '08123456789',
                'role'         => 'admin_sarana',
                'username'     => 'admin',
                'password'     => Hash::make('admin123'),
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            // Admin Sistem
            [
                'nis'          => null,
                'nip'          => '198803152012022003',
                'nama'         => 'Admin Sistem',
                'nomor_kontak' => '08129876543',
                'role'         => 'admin_sistem',
                'username'     => 'adminsistem',
                'password'     => Hash::make('admin123'),
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            // Akun Siswa
            [
                'nis'          => '10001',
                'nip'          => null,
                'nama'         => 'Ahmad Fadli',
                'nomor_kontak' => '08123456701',
                'role'         => 'siswa',
                'username'     => 'ahmad',
                'password'     => Hash::make('siswa123'),
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nis'          => '10002',
                'nip'          => null,
                'nama'         => 'Siti Nurhaliza',
                'nomor_kontak' => '08123456702',
                'role'         => 'siswa',
                'username'     => 'siti',
                'password'     => Hash::make('siswa123'),
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nis'          => '10003',
                'nip'          => null,
                'nama'         => 'Budi Santoso',
                'nomor_kontak' => '08123456703',
                'role'         => 'siswa',
                'username'     => 'budi',
                'password'     => Hash::make('siswa123'),
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nis'          => '10004',
                'nip'          => null,
                'nama'         => 'Rian Pratama',
                'nomor_kontak' => '08123456704',
                'role'         => 'siswa',
                'username'     => 'rian',
                'password'     => Hash::make('siswa123'),
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'nis'          => '10005',
                'nip'          => null,
                'nama'         => 'Dinda Putri',
                'nomor_kontak' => '08123456705',
                'role'         => 'siswa',
                'username'     => 'dinda',
                'password'     => Hash::make('siswa123'),
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ];

        foreach ($akunData as $item) {
            DB::table('akun')->updateOrInsert(
                ['username' => $item['username']],
                $item
            );
        }
    }
}
