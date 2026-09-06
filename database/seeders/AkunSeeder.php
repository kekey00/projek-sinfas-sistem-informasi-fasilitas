<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AkunSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Tambahkan data siswa dulu (karena ada foreign key nis -> siswa.nis)
        DB::table('siswa')->insertOrIgnore([
            [
                'nis'        => '12345',
                'nama'       => 'Siswa Contoh',
                'email'      => 'siswa@sinfas.com',
                'no_hp'      => '08987654321',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        // 2. Masukkan akun
        DB::table('akun')->insert([
            // Akun Admin Sarana (nis null, tidak perlu ada di tabel siswa)
            [
                'nis'          => null,
                'nip'          => null,
                'nama'         => 'Admin Sarana',
                'nomor_kontak' => '08123456789',
                'role'         => 'admin_sarana',
                'username'     => 'admin',
                'password'     => Hash::make('admin123'),
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            // Akun Siswa / User
            [
                'nis'          => '12345',
                'nip'          => null,
                'nama'         => 'Siswa Contoh',
                'nomor_kontak' => '08987654321',
                'role'         => 'siswa',
                'username'     => 'siswa',
                'password'     => Hash::make('siswa123'),
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
