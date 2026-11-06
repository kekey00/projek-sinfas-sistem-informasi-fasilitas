<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("ALTER TABLE `peminjaman` MODIFY COLUMN `status_pengajuan` ENUM('menunggu', 'disetujui', 'ditolak', 'dibatalkan') NOT NULL DEFAULT 'menunggu'");
    }

    public function down(): void
    {
        DB::table('peminjaman')
            ->where('status_pengajuan', 'dibatalkan')
            ->update(['status_pengajuan' => 'ditolak']);

        DB::statement("ALTER TABLE `peminjaman` MODIFY COLUMN `status_pengajuan` ENUM('menunggu', 'disetujui', 'ditolak') NOT NULL DEFAULT 'menunggu'");
    }
};
