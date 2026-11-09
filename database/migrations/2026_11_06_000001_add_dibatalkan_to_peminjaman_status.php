<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Memperbarui tipe enum 'status_pengajuan' pada tabel peminjaman agar mencakup opsi 'dibatalkan'.
     *
     * @return void
     */

    public function up(): void
    {
        DB::statement("ALTER TABLE `peminjaman` MODIFY COLUMN `status_pengajuan` ENUM('menunggu', 'disetujui', 'ditolak', 'dibatalkan') NOT NULL DEFAULT 'menunggu'");
    }
    /**
     * Mengembalikan enum 'status_pengajuan' ke pilihan awal tanpa nilai 'dibatalkan'.
     *
     * @return void
     */


    public function down(): void
    {
        DB::table('peminjaman')
            ->where('status_pengajuan', 'dibatalkan')
            ->update(['status_pengajuan' => 'ditolak']);

        DB::statement("ALTER TABLE `peminjaman` MODIFY COLUMN `status_pengajuan` ENUM('menunggu', 'disetujui', 'ditolak') NOT NULL DEFAULT 'menunggu'");
    }
};
