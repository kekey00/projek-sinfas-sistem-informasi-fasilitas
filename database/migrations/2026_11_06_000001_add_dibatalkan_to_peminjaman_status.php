<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('peminjaman', function (Blueprint $table) {
            $table->enum('status_pengajuan', ['menunggu', 'disetujui', 'ditolak', 'dibatalkan'])
                ->default('menunggu')
                ->change();
        });
    }

    public function down(): void
    {
        DB::table('peminjaman')
            ->where('status_pengajuan', 'dibatalkan')
            ->update(['status_pengajuan' => 'ditolak']);

        Schema::table('peminjaman', function (Blueprint $table) {
            $table->enum('status_pengajuan', ['menunggu', 'disetujui', 'ditolak'])
                ->default('menunggu')
                ->change();
        });
    }
};
